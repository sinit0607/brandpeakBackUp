<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Mail\EmailVerify;
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;
use App\Models\AndroidLogin;
use Illuminate\Http\Request;
use App\Models\EmailVerified;
use App\Models\PasswordReset;
use App\Models\EarningHistory;
use App\Models\ReferralSystem;
use App\Models\StorageSetting;
use App\Models\ReferralRegister;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthApi extends Controller
{
    public function login(Request $request)
    {
        $email = $request->get("email");
        $password = $request->get("password");
        
        if (Auth::attempt(['email' => $email, 'password' => $password])) 
        {
            $user = User::find(Auth::user()->id);
            $ReferralRegister = ReferralRegister::where('user_id',Auth::user()->id)->first();
            
            $res = array(
                'userId' => $user->id,  
                'userName' => $user->name,
                'emailId' => $user->email, 
                'password' => "",
                'phoneNumber' => $user->mobile_no,
                'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                'is_email_verify' => ($user->email_verified_at != null)?true:false,
                'userType' => $user->login_type, 
                'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))    
            );
        } 
        else 
        {
            return response()->json([
                'status' => "Error",
                'message' => "Invalid Login Credentials",
            ], 404);
        }

        return response()->json($res);
    }

    public function registration(Request $request)
    {
        //dd($request->all());
        $exist = User::where('email', $request->get('email'))->first();
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email,' . \Request::get("id"),
            'mobile_no' => 'required|numeric',
            'image' => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            $errors = [];
            foreach ($validation->errors()->messages() as $key => $value) {
                $errors[] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json([
              'status' => "Error",
              'message' => $errors,
            ], 404);
        }
        else
        {
            $id = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'), 
                'password' => bcrypt($request->get('password')), 
                'mobile_no' => $request->get('mobile_no'),
                'api_token' => str::random(60),
                'login_type' => "normal",
                "referral_code" => strtoupper(str::random(10)),
                "user_type" => "User",
            ])->id;

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $image = $request->file('image');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $user = User::find($id);
                    $user->image = $file;
                    $user->save();
                }
            }
            else
            {
                if ($request->file("image") && $request->file('image')->isValid()) {
                    $this->upload_image($request->file("image"),"image", $id);
                }
            }

            $user = User::find($id);
            $email = $user->email;
            $name = $user->name;
            //$code = Str::random(10);
            $code = mt_rand(100000, 999999);

            $token = Str::random(60);
            EmailVerified::where('user_id', $id)->delete();
            EmailVerified::create(['user_id' => $id, 'code' => $code, 'created_at' => date('Y-m-d H:i:s')]);
            Mail::to($email)->send(new EmailVerify($email, $token, $name, $code));
            $ReferralRegister = ReferralRegister::where('user_id',$id)->first();

            $data = array(
                'userId' => $user->id, 
                'userName' => $user->name,
                'emailId' => $user->email, 
                'password' => "",
                'phoneNumber' => $user->mobile_no,
                'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                'userType' => $user->login_type, 
                'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
            );
        }

        return $data;
    }

    public function resendVerifyCode(Request $request)
    {
        $user = User::find($request->userId);
        if(!empty($user))
        {
            $email = $user->email;
            $name = $user->name;
            // $code = Str::random(10);
            $code = mt_rand(100000, 999999);

            $token = Str::random(60);
            EmailVerified::where('user_id', $request->userId)->delete();
            EmailVerified::create(['user_id' => $request->userId, 'code' => $code, 'created_at' => date('Y-m-d H:i:s')]);
            Mail::to($email)->send(new EmailVerify($email, $token, $name, $code));

            return response()->json([
                'status' => "success",
                'message' => "Resend Email Verification Code Successfully!",
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => "Error",
                'message' => "Invalid userId",
            ], 404);
        }
    }

    public function verifyAccount(Request $request)
    {
        $exist = EmailVerified::where('user_id', $request->get('userId'))->where('code',$request->get('code'))->first();
        if($exist != null)
        {
            $user = User::find($request->get('userId'));
            if(!empty($user))
            {
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->save();

                return response()->json([
                    'status' => "success",
                    'message' => "Email Verification Successfully!",
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => "Error",
                    'message' => "Invalid userId",
                ], 404);
            }
        }
        else
        {
            return response()->json([
                'status' => "Error",
                'message' => "Invalid userId && Code!",
            ], 404);
        }
    }

    public function google_registration(Request $request)
    {
        $exist = User::where('email', $request->get('email'))->first();
        if($exist != null)
        {
            $user = User::where('email', $request->get('email'))->first();
            $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();

            $data = array(
                'userId' => $user->id, 
                'userName' => $user->name,
                'emailId' => $user->email, 
                'password' => "",
                'phoneNumber' => $user->mobile_no,
                'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                'userType' => $user->login_type, 
                'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
            );
        }
        else
        {
            $user_data = User::where('email', "brandusergoogle@gmail.com")->where('name', "Brand_User_Google")->first();
            if($user_data != null)
            {
                $user = User::where('email', "brandusergoogle@gmail.com")->where('name', "Brand_User_Google")->first();
                $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();

                $data = array(
                    'userId' => $user->id, 
                    'userName' => $user->name,
                    'emailId' => $user->email, 
                    'password' => "",
                    'phoneNumber' => ($user->mobile_no)?$user->mobile_no:"",
                    'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                    'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                    'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                    'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                    'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                    'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                    'userType' => $user->login_type, 
                    'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                    'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                    'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
                );
            }
            else
            {
                $id = User::create([
                    'name' => "Brand_User_Google",
                    'email' => "brandusergoogle@gmail.com",
                    'password' => null, 
                    'api_token' => str::random(60),
                    'login_type' => "google",
                    'image' => $request->get('image'),
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    "referral_code" => strtoupper(str::random(10)),
                    "user_type" => "User",
                ])->id;

                $user = User::find($id);
                $ReferralRegister = ReferralRegister::where('user_id',$id)->first();

                $data = array(
                    'userId' => $user->id, 
                    'userName' => $user->name,
                    'emailId' => $user->email, 
                    'password' => "",
                    'phoneNumber' => ($user->mobile_no)?$user->mobile_no:"",
                    'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                    'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                    'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                    'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                    'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                    'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                    'userType' => $user->login_type, 
                    'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                    'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                    'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
                );
            }
        }
        return $data;
    }

    public function phone_login(Request $request)
    {
        $exist = User::where('mobile_no', $request->get('phoneNumber'))->first();
        if($exist != null)
        {
            $user = User::where('mobile_no', $request->get('phoneNumber'))->first();
            $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();

            $data = array(
                'userId' => $user->id, 
                'userName' => $user->name,
                'emailId' => $user->email, 
                'password' => "",
                'phoneNumber' => $user->mobile_no,
                'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                'userType' => $user->login_type, 
                'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
            );
        }
        else
        {
            $user_data = User::where('email', $request->get('email'))->where('name', $request->get('name'))->first();
            if($user_data != null)
            {
                $user = User::find($user_data->id);
                $user->name = $request->get("name");
                $user->email = $request->get("email");
                $user->mobile_no = $request->get("phoneNumber");
                $user->save();
                $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();

                $data = array(
                    'userId' => $user->id, 
                    'userName' => $user->name,
                    'emailId' => $user->email, 
                    'password' => "",
                    'phoneNumber' => $user->mobile_no,
                    'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                    'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                    'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                    'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                    'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                    'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                    'userType' => $user->login_type, 
                    'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                    'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                    'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
                );
            }
            else
            {
                $id = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'mobile_no' => $request->get('phoneNumber'),
                    'password' => null, 
                    'api_token' => str::random(60),
                    'login_type' => "phone",
                    'image' => "911065a3-c074-43db-9fae-c4f94a5d754a.png",
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    "referral_code" => strtoupper(str::random(10)),
                    "user_type" => "User",
                ])->id;

                $user = User::find($id);
                $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();

                $data = array(
                    'userId' => $user->id, 
                    'userName' => $user->name,
                    'emailId' => $user->email, 
                    'password' => "",
                    'phoneNumber' => $user->mobile_no,
                    'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                    'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                    'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                    'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                    'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                    'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                    'userType' => $user->login_type, 
                    'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                    'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                    'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
                );
            }
        }
        return $data;
    }

    public function user_data(Request $request)
    {
        $user = User::find($request->id);

        if (!empty($user))
        {
            if($user->email_verified_at != null)
            {
                $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();

                $res = array(
                    'userId' => $user->id,  
                    'userName' => $user->name,
                    'emailId' => $user->email, 
                    'password' => "",
                    'phoneNumber' => $user->mobile_no,
                    'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                    'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                    'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                    'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                    'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                    'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                    'userType' => $user->login_type, 
                    'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                    'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                    'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
                );
            }
            else
            {
                return response()->json([
                    'status' => "Error",
                    'message' => "Please Verify Email Id!",
                ], 404);
            }
        } 
        else 
        {
            return response()->json([
                'status' => "Error",
                'message' => "Invalid userId",
            ], 404);
        }
        return response()->json($res);
    }

    public function profile_update(Request $request)
    {
        if($request->get('referralCode'))
        {
            $referral_exist = User::where('referral_code', $request->get('referralCode'))->first();
            if($referral_exist != null)
            {
                $user = User::find($request->id);
                if(!empty($user))
                {
                    $validation = Validator::make($request->all(), [
                        'name' => 'required',
                        'email' => 'required|email|unique:users,email,' . \Request::get("id"),
                        "image" => "nullable|mimes:jpg,png,jpeg",
                    ]);
            
                    if ($validation->fails()) {
                        $errors = [];
                        foreach ($validation->errors()->messages() as $key => $value) {
                            $errors[] = is_array($value) ? implode(',', $value) : $value;
                        }
            
                        return response()->json([
                            'status' => "Error",
                            'message' => $errors,
                        ], 404);
                    }
                    else
                    {
                        if($user->email_verified_at != null)
                        {
                            $user_mobile = User::where("mobile_no",$request->get("mobile_no"))->first();
                            if($request->get("mobile_no") == null || empty($user_mobile) || $user_mobile->id == $user->id)
                            {
                                $user = User::find($request->id);
                                $user->name = $request->get("name");
                                $user->email = $request->get("email");
                                $user->mobile_no = $request->get("mobile_no");
                                $user->save();
                    
                                if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
                                {
                                    if ($request->file("image") && $request->file('image')->isValid()) {
                                        $image = $request->file('image');
                                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                                
                                        $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                                        
                                        $user = User::find($request->id);
                                        $user->image = $file;
                                        $user->save();
                                    }
                                }
                                else
                                {
                                    if ($request->file("image") && $request->file('image')->isValid()) {
                                        $this->upload_image($request->file("image"),"image", $request->id);
                                    }
                                }

                                $rr = ReferralRegister::where("user_id",$request->id)->where("referral_code",$request->get('referralCode'))->first();
                                if($rr == null && $request->get('referralCode'))
                                {
                                    ReferralRegister::create([
                                        "user_id" => $request->id,
                                        "referral_code" => $request->get('referralCode')
                                    ]);

                                    $referral_user = User::where('referral_code',$request->get('referralCode'))->first();
                                    $referral_user->current_balance = $referral_user->current_balance + ReferralSystem::getReferralSystem('register_point');
                                    $referral_user->total_balance = $referral_user->total_balance + ReferralSystem::getReferralSystem('register_point');
                                    $referral_user->save();

                                    EarningHistory::create([
                                        "user_id" => $referral_user->id,
                                        "amount" => ReferralSystem::getReferralSystem('register_point'),
                                        "amount_type" => 1,
                                        "refer_user" => $request->id,
                                    ]);
                                }

                                $user = User::find($request->id);
                                $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();

                                $data = array(
                                    'userId' => $user->id, 
                                    'userName' => $user->name,
                                    'emailId' => $user->email, 
                                    'password' => "",
                                    'phoneNumber' => $user->mobile_no,
                                    'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                                    'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                                    'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                                    'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                                    'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                                    'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                                    'userType' => $user->login_type, 
                                    'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                                    'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                                    'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
                                );
                            }
                            else
                            {
                                return response()->json([
                                    'status' => "Error",
                                    'message' => "Mobile No Already Register!",
                                ], 404);
                            }
                        }
                        else
                        {
                            return response()->json([
                                'status' => "Error",
                                'message' => "Please Verify Email Id!",
                            ], 404);
                        }
                    }
                }
                else 
                {
                    return response()->json([
                        'status' => "Error",
                        'message' => "Invalid userId",
                    ], 404);
                }
            }
            else
            {
                return response()->json([
                    'status' => "Error",
                    'message' => "Invalid Referral Code",
                ], 404);
            }
        }
        else
        {
            $user = User::find($request->id);
            if(!empty($user))
            {
                $validation = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . \Request::get("id"),
                    "image" => "nullable|mimes:jpg,png,jpeg",
                ]);
        
                if ($validation->fails()) {
                    $errors = [];
                    foreach ($validation->errors()->messages() as $key => $value) {
                        $errors[] = is_array($value) ? implode(',', $value) : $value;
                    }
        
                    return response()->json([
                        'status' => "Error",
                        'message' => $errors,
                    ], 404);
                }
                else
                {
                    if($user->email_verified_at != null)
                    {
                        $user_mobile = User::where("mobile_no",$request->get("mobile_no"))->first();
                        if($request->get("mobile_no") == null || empty($user_mobile) || $user_mobile->id == $user->id)
                        {
                            $user = User::find($request->id);
                            $user->name = $request->get("name");
                            $user->email = $request->get("email");
                            $user->mobile_no = $request->get("mobile_no");
                            $user->save();
                
                            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
                            {
                                if ($request->file("image") && $request->file('image')->isValid()) {
                                    $image = $request->file('image');
                                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                            
                                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                                    
                                    $user = User::find($request->id);
                                    $user->image = $file;
                                    $user->save();
                                }
                            }
                            else
                            {
                                if($request->file("image") && $request->file('image')->isValid()) {
                                    $this->upload_image($request->file("image"),"image", $request->id);
                                }
                            }
                            
                            $user = User::find($request->id);
                            $ReferralRegister = ReferralRegister::where('user_id',$user->id)->first();
                            
                            $data = array(
                                'userId' => $user->id, 
                                'userName' => $user->name,
                                'emailId' => $user->email, 
                                'password' => "",
                                'phoneNumber' => $user->mobile_no,
                                'useReferral' => ($ReferralRegister)?$ReferralRegister->referral_code:"",
                                'planName' => ($user->subscription_id)?$user->subscription->plan_name:"",
                                'planDuration' => ($user->subscription_id)?$user->subscription->duration." ".$user->subscription->duration_type:"",
                                'planStartDate' => ($user->subscription_start_date)?$user->subscription_start_date:"",
                                'planEndDate' => ($user->subscription_start_date)?$user->subscription_end_date:"",
                                'isSubscribe' => ($user->is_subscribe)?(date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?true:false:false,
                                'userType' => $user->login_type, 
                                'businessLimit' => (date_format(date_create(implode("", preg_split("/[-\s:,]/", $user->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today')))?$user->business_limit:1,   
                                'profileImage' => ($user->image)?(substr($user->image, 0, 4)=="http")?$user->image:((StorageSetting::getStorageSetting('storage') == 'DigitalOcean')?Storage::disk('spaces')->url('uploads/'.$user->image):asset('uploads/'.$user->image)):"",
                                'createdAt' => date('Y-m-d H:i:s', strtotime($user->created_at))
                            );
                        }
                        else
                        {
                            return response()->json([
                                'status' => "Error",
                                'message' => "Mobile No Already Register!",
                            ], 404);
                        }
                    }
                    else
                    {
                        return response()->json([
                            'status' => "Error",
                            'message' => "Please Verify Email Id!",
                        ], 404);
                    }
                }
            }
            else 
            {
                return response()->json([
                    'status' => "Error",
                    'message' => "Invalid userId",
                ], 404);
            }
        }

        return $data;
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        $image = User::find($id);
        $image->$field = $fileName;
        $image->save();
    }

    public function forgot_password(Request $request)
    {
        $user = User::where('email', $request->email)->get()->toArray();
        if (!empty($user)) 
        {
            $this->validateEmail($request);
            $email = $request->email;
            $name = $user[0]['name'];
            //$newPassword = Str::random(10);
            $newPassword = mt_rand(100000, 999999);

            $user = User::find($user[0]['id']);
            $user->password =  bcrypt($newPassword);
            $user->save();

            $token = Str::random(60);
            PasswordReset::where('email', $email)->delete();
            PasswordReset::create(['email' => $email, 'token' => Hash::make($token), 'created_at' => date('Y-m-d H:i:s')]);
            Mail::to($email)->send(new ForgotPassword($email, $token, $name, $newPassword));

            return response()->json([
                'status' => "Success",
                'message' => "Email Send Your Email Address.",
            ], 200);
        } 
        else 
        {
            return response()->json([
                'status' => "Error",
                'message' => "Please Enter Valid Email Address...",
            ], 404);
        }
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    public function change_password(Request $request)
    {
        $user = User::find($request->get('userId'));
        $validation = Validator::make($request->all(), [
            'newPassword' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = [];
            foreach ($validation->errors()->messages() as $key => $value) {
                $errors[] = is_array($value) ? implode(',', $value) : $value;
            }

            return response()->json([
              'status' => "Error",
              'message' => $errors,
            ], 404);
        }
        else
        {
            if ($user == null) {
                return response()->json([
                    'status' => 'Error',
                    'message' => "Invalid User Id!",
                    'data' => null,
                ], 404);
            } 
            else
            {
                $user->password = bcrypt($request->get('newPassword'));
                $user->save();

                $data['status'] = 'Success';
                $data['message'] = "Your Password has been Updated Successfully.";
            }
        }
        return $data;
    }

    public function register_fcm(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'fcmToken' => 'required',
            'userId' => 'required|integer',
            'deviceId' => 'required',
        ]);

        $errors = $validation->errors();
        if (count($errors) > 0) {
            $data['status'] = 401;
            $data['message'] = "Unable to update FCM ID and deviceId";
            $data['data'] = "";

        } else {
            $user = User::find($request->userId);
            if (!empty($user)){
                $id = AndroidLogin::create([
                    'userId' => $request->get('userId'),
                    'fcmToken' => $request->get('fcmToken'), 
                    'deviceId' => $request->get('deviceId'), 
                ])->id;


                $data['status'] = 0;
                $data['message'] = "FCM Token Register Successfully!";
                $data['data'] = "";
            } else {
                $data['status'] = 401;
                $data['message'] = "Invalid userId.";
                $data['data'] = "";
            }

        }
        return $data;
    }

    public function logout(Request $request)
    {
        $val = AndroidLogin::where('userId',$request->userId)->where('deviceId',$request->deviceId)->get();

        if (!empty($val))
        {
            AndroidLogin::where('userId',$request->userId)->where('deviceId',$request->deviceId)->delete();
            $data['status'] = 0;
            $data['message'] = "User Logout Successfully!";
            $data['data'] = "";
        }
        else
        {
            $data['status'] = 404;
            $data['message'] = "Invalid Data!";
            $data['data'] = "";
        }


        return $data;
    }
}

