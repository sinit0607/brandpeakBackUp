<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use App\Models\Story;
use App\Models\Business;
use App\Models\CustomFrame;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\EarningHistory;
use App\Models\StorageSetting;
use App\Models\WithdrawRequest;
use App\Models\ReferralRegister;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:SubscriptionPlan');
    }

    public function index()
    {
        $index['data'] = Subscription::get();
        return view("subscription.index", $index);
    }

    public function create()
    {
        return view("subscription.create");
    }

    public function show($id)
    {
        $index['data'] = Subscription::find($id);
        return view('subscription.show',$index);
    }

    public function subscription_status(Request $request)
    {
        $subscription = Subscription::find($request->get("id"));
        $subscription->status = ($request->get("checked")=="true")?1:0;
        $subscription->save();
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'plan_name' => 'required',
            'plan_price' => 'required',
            "discount_price" => 'required',
            'duration' => 'required|numeric',
            "duration_type" => 'required',
            'business_limit' => 'required'
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {

            $id = Subscription::create([
                "plan_name" => $request->get("plan_name"),
                "plan_price" => $request->get("plan_price"),
                "discount_price" => $request->get("discount_price"),
                "duration" => $request->get("duration"),
                "duration_type" => $request->get("duration_type"),
                "plan_detail" => serialize($request->get('detail')),
                "business_limit" =>  $request->get("business_limit"),
                "google_product_enable" => ($request->get("google_product_enable"))?1:0,
                "google_product_id" =>  $request->get("google_product_id"),
            ])->id;
           
            return redirect()->route("subscription-plan.index");
        }
    }

    public function edit($id)
    {
        $index['subscription'] = Subscription::find($id);
        $index['plan_detail'] = unserialize($index['subscription']->plan_detail);
        return view("subscription.edit", $index);
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validation = Validator::make($request->all(), [
            'plan_name' => 'required',
            'plan_price' => 'required',
            "discount_price" => 'required',
            'duration' => 'required|numeric',
            "duration_type" => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $subscription = Subscription::find($request->get("id"));
            $subscription->plan_name = $request->plan_name;
            $subscription->plan_price = $request->plan_price;
            $subscription->discount_price = $request->discount_price;
            $subscription->duration = $request->duration;
            $subscription->duration_type = $request->duration_type;
            $subscription->plan_detail = serialize($request->detail);
            $subscription->business_limit = $request->business_limit;
            $subscription->google_product_enable = ($request->google_product_enable)?1:0;
            $subscription->google_product_id = $request->google_product_id;
            $subscription->save();

            return redirect()->route('subscription-plan.index');
        }
    }

    public function destroy($id)
    {
        $story = Story::where("subscription_id",$id)->get();
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            foreach($story as $s)
            {
                Storage::disk('spaces')->delete('uploads/'.$s->image);
            }
        }
        else
        {
            foreach($story as $s)
            {
                unlink('./uploads/'.$s->image);
            }
        }

        Subscription::find($id)->delete();
        Transaction::where("subscription_id",$id)->delete();
        Story::where("subscription_id",$id)->delete();
        $user = User::where("subscription_id",$id)->get();
        foreach($user as $u)
        {
            if($u->user_type != "Super Admin")
            {
                $business = Business::where("user_id",$u->id)->get();
                $customFrame = CustomFrame::where("user_id",$u->id)->get();
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
                User::find($u->id)->delete();
                Business::where("user_id",$u->id)->delete();
                Transaction::where("user_id",$u->id)->delete();
                WithdrawRequest::where("user_id",$u->id)->delete();
                CustomFrame::where("user_id",$u->id)->delete();
                ReferralRegister::where("user_id",$u->id)->delete();
                EarningHistory::where("user_id",$u->id)->delete();
            }
        }

        return redirect()->route('subscription-plan.index');
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        $image = Subscription::find($id);
        $image->$field = $fileName;
        $image->save();
    }
}
