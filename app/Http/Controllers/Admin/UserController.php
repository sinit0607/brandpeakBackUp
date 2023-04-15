<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Business;
use App\Models\CustomFrame;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\EarningHistory;
use App\Models\StorageSetting;
use App\Models\WhatsappMessage;
use App\Models\WithdrawRequest;
use App\Models\ReferralRegister;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Users');
    }

    public function index()
    {
        $index['data'] = User::select('id','name','email','mobile_no','image','created_at','status')->orderBy('id', 'desc')->get();
        $index['whatsapp_messages'] = WhatsappMessage::get();
        return view("user.index", $index);
    }

    public function create()
    {
        $index['subscription'] = Subscription::where('status',1)->get();
        $index['roles'] = Role::get();
        return view("user.create",$index);
    }

    public function generat_code()
    {
        $user = User::get();
        foreach($user as $u)
        {
            $user_one = User::find($u->id);
            $user_one->referral_code = strtoupper(str::random(8));
            $user_one->save();
        }
    }

    public function password_change(Request $request)
    {
        $user = User::find($request->get("user_id"));
        $user->password = bcrypt($request->get("passwd"));
        $user->save();
    }

    public function user_status(Request $request)
    {
        $user = User::find($request->get("id"));
        $user->status = ($request->get("checked")=="true")?1:0;
        $user->save();
    }

    public function show($id)
    {
        $user_data = User::find($id);
        if($user_data->email != "demo2023@gmail.com")
        {
            $index['data'] = User::find($id);
            $index['business'] = Business::where('user_id',$id)->get();
            $index['subscription'] = Subscription::where('status',1)->get();
            $index['transaction'] = Transaction::where('user_id',$id)->get();
            $index['customFrame'] = CustomFrame::where('user_id',$id)->get();
            $index['earningHistory'] = EarningHistory::where('user_id',$id)->orderBy('id', 'DESC')->get();
            $index['referralRegister'] = ReferralRegister::where('referral_code',$user_data->referral_code)->get();
            $index['roles'] = Role::get();
        }
        
        return view('user.show',$index);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:8',
            "mobile_no" => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . \Request::get("id"),
            "image" => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } 
        else 
        {
            $role = Role::find($request->role_id);
            if(!empty($role))
            {
                if($role['name'])
                {
                    $user_type = 'Admin';
                }
            }
            else
            {
                $user_type = "User";
            }

            $id = User::create([
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "mobile_no" => $request->get("mobile_no"),
                "password" => bcrypt($request->get("password")),
                'api_token' => str::random(60),
                'login_type' => "normal",
                "user_type" => $user_type,
                "email_verified_at" => date('Y-m-d H:i:s'),
                "subscription_id" => $request->get("plan"),
                "subscription_start_date" => $request->get("subscription_start_from"),
                "subscription_end_date" => $request->get("subscription_start_to"),
                "is_subscribe" => ($request->get("plan"))?1:0,
                "referral_code" => strtoupper(str::random(10)),
            ])->id;

            $user = User::find($id);
            $role = Role::find($request->role_id);
            $user->assignRole($role);

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
           
            return redirect()->route("user.index");
        }
    }

    // public function edit($id)
    // {
    //     $user = User::find($id);
    //     $gender = Gender::where('status',1)->get();
    //     return view("user.edit", compact("user","gender"));
    // }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            //'password' => 'required|min:8',
            "mobile_no" => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . \Request::get("id"),
            "image" => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $user = User::whereId($request->get("id"))->first();
            $user->name = $request->get("name");
            $user->email = $request->get("email");
            $user->mobile_no = $request->get("mobile_no");
            if(!empty($request->get("password")))
            {
                $user->password = bcrypt($request->get("password"));
            }

            if($user->roles->first() != null)
            {
                $old = Role::find($user->roles->first()->id);
                if ($old != null) {
                    $user->removeRole($old);
                }
            }
            
            $role = Role::find($request->role_id);
            if(!empty($role))
            {
                if($role['name'])
                {
                    $user->user_type = 'Admin';
                    $user->assignRole($role);
                }
            }
            else
            {
                if($user->user_type == "Super Admin")
                {
                    $user->user_type = 'Super Admin';
                    $user->givePermissionTo(['Language','Category','CategoryFrame','Festival','FestivalFrame','CustomCategory',
                                            'CustomFrame','BusinessCategory','BusinessSubCategory','BusinessFrame','StickerCategory','Sticker',"ProductCategory",
                                            "Product","Inquiry","PosterCategory","PosterMaker","ReferralSystem","WithdrawRequest",'Video','News','Stories',
                                            'Users','Businesses','SubscriptionPlan','CouponCode',
                                            'BusinessCard','FinancialStatistics','Entry','Subject','Notification','WhatsAppMessage','Offer','UserRoleManagement','Settings']);
                }
                elseif($user->user_type == "Demo")
                {
                    $user->user_type = 'Demo';
                    $user->givePermissionTo(['Language','Category','CategoryFrame','Festival','FestivalFrame','CustomCategory',
                                            'CustomFrame','BusinessCategory','BusinessSubCategory','BusinessFrame','StickerCategory','Sticker',"ProductCategory",
                                            "Product","Inquiry","PosterCategory","PosterMaker","ReferralSystem","WithdrawRequest",'Video','News', 'Stories',
                                            'Users','Businesses','SubscriptionPlan','CouponCode',
                                            'BusinessCard','FinancialStatistics','Entry','Subject','Notification','WhatsAppMessage','Offer','UserRoleManagement','Settings']);
                }
                elseif($user->email == "demo2023@gmail.com")
                {
                    $user->user_type = 'Super Admin';
                    $user->givePermissionTo(['Language','Category','CategoryFrame','Festival','FestivalFrame','CustomCategory',
                                            'CustomFrame','BusinessCategory','BusinessSubCategory','BusinessFrame','StickerCategory','Sticker',"ProductCategory",
                                            "Product","Inquiry","PosterCategory","PosterMaker","ReferralSystem","WithdrawRequest",'Video','News', 'Stories',
                                            'Users','Businesses','SubscriptionPlan','CouponCode',
                                            'BusinessCard','FinancialStatistics','Entry','Subject','Notification','WhatsAppMessage','Offer','UserRoleManagement','Settings']);
                }
                else
                {
                    $user->user_type = 'User';
                }
            }
            
            $user->save();
            
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

            return redirect()->back();
        }
    }

    public function subscription_update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'plan' => 'required',
            "subscription_start_from" => 'required',
            "subscription_start_to" => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $subscription = Subscription::find($request->get("plan"));

            $user = User::find($request->get("id"));
            $user->subscription_id = $request->get("plan");
            $user->subscription_start_date = Carbon::createFromFormat('d M, y',$request->get("subscription_start_from"))->format('Y-m-d');
            $user->subscription_end_date = Carbon::createFromFormat('d M, y',$request->get("subscription_start_to"))->format('Y-m-d');
            $user->is_subscribe = 1;
            $user->business_limit = $subscription->business_limit;
            $user->save();
            
            return redirect()->back();
        }
    }

    public function get_plan(Request $request)
    {
        $data = Subscription::find($request->id);
        $detail['start_date'] = date('d M, y');
        $detail['end_date'] = date('d M, y', strtotime($data->duration." ".$data->duration_type));
        return $detail;
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $business = Business::where("user_id",$id)->get();
        $customFrame = CustomFrame::where("user_id",$id)->get();
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            foreach($business as $b)
            {
                Storage::disk('spaces')->delete('uploads/'.$b->logo);
            }
            foreach($customFrame as $frame)
            {
                Storage::disk('spaces')->delete('uploads/'.$frame->frame_image);
            }
        }
        else
        {
            foreach($business as $b)
            {
                unlink('./uploads/'.$b->logo);
            }
            foreach($customFrame as $frame)
            {
                unlink('./uploads/'.$frame->frame_image);
            }
        }

        $user = User::find($id);
        if($user->user_type != "Super Admin")
        {
            User::find($id)->delete();
            Business::where("user_id",$id)->delete();
            Transaction::where("user_id",$id)->delete();
            WithdrawRequest::where("user_id",$id)->delete();
            CustomFrame::where("user_id",$id)->delete();
            ReferralRegister::where("user_id",$id)->delete();
            EarningHistory::where("user_id",$id)->delete();

            return redirect()->route('user.index');
        }

        return redirect()->route('user.index');
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
}
