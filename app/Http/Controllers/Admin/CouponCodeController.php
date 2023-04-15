<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CouponCode;
use App\Models\FestivalsFrame;
use App\Models\CategoryFrame;
use App\Models\CustomPostFrame;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CouponCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:CouponCode');
    }

    public function index()
    {
        $index['data'] = CouponCode::get();
        return view("coupon_code.index", $index);
    }

    public function create()
    {
        return view("coupon_code.create");
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'code' => 'required',
            'discount' => 'required',
            'limit' => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            CouponCode::create([
                "code" => $request->get("code"),
                "discount" => $request->get("discount"),
                "limit" => $request->get("limit"),
            ]);

            return redirect()->route("coupon-code.index");
        }
    }

    public function coupon_code_status(Request $request)
    {
        $couponCode = CouponCode::find($request->get("id"));
        $couponCode->status = ($request->get("checked")=="true")?1:0;
        $couponCode->save();
    }

    public function edit($id)
    {
        $couponCode = CouponCode::find($id);
        return view("coupon_code.edit", compact("couponCode"));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'code' => 'required',
            'discount' => 'required',
            'limit' => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $couponCode = CouponCode::find($request->get("id"));
            $couponCode->code = $request->get("code");
            $couponCode->discount = $request->get("discount");
            $couponCode->limit = $request->get("limit");
            $couponCode->save();

            return redirect()->route('coupon-code.index');
        }
    }

    public function destroy($id)
    {
        CouponCode::find($id)->delete();
        return redirect()->route('coupon-code.index');
    }
}
