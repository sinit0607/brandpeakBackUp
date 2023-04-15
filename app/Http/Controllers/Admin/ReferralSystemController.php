<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Cache;
use App\Models\WithdrawRequest;
use App\Models\EarningHistory;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ReferralSystem;

class ReferralSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ReferralSystem',['only' => ['referral_system','post_referral_system']]);
        $this->middleware('permission:WithdrawRequest',['only' => ['withdraw_request','post_withdraw_request']]);
    }

    public function referral_system()
    {
        return view('backend.referralSystem');
    }

    public function post_referral_system(Request $request)
    {
        ReferralSystem::where('key_name', 'referral_system_enable')->update(['key_value' => 0]);
        foreach ($request->name as $key => $val) {
            $setting = ReferralSystem::where('key_name', $key)->first();
            if (is_null($setting)) 
            {
                $id = ReferralSystem::create([
                    'key_name' => $key,
                    'key_value' =>$val,
                ]);
            } 
            else 
            {
                ReferralSystem::where('key_name', $key)->update(['key_value' => $val]);
            }
		}

		return redirect('admin/referral-system');
    }

    public function withdraw_request()
    {
        $index['data'] = WithdrawRequest::get();
        return view('backend.withdrawRequest',$index);
    }

    public function post_withdraw_request(Request $request)
    {
        $req = WithdrawRequest::find($request->id);
        $req->status = 1;
        $req->save();

        return redirect('admin/withdraw-request');
    }
}
