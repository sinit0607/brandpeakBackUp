<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Business;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StorageSetting;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Businesses');
    }

    public function index()
    {
        $index['data'] = Business::select('id','name','user_id','mobile_no','logo','status')->get();
        return view("business.index", $index);
    }

    // public function create()
    // {
    //     return view("business.create");
    // }

    public function user_business($id)
    {
        $index['data'] = $id;
        $index['category'] =  BusinessCategory::where('status',1)->get();
        return view("business.create",$index);
    }

    public function show($id)
    {
        $index['data'] = Business::find($id);
        return view('business.show',$index);
    }

    public function business_status(Request $request)
    {
        $business = Business::find($request->get("id"));
        $business->status = ($request->get("checked")=="true")?1:0;
        $business->save();
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            "mobile_no" => 'required|numeric',
            'email' => 'required|email|unique:business,email,' . \Request::get("id"),
            "logo" => "nullable|mimes:jpg,png,jpeg",
            "website" => 'required',
            "business_category_id" => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } 
        else 
        {
            $business_data = Business::where('user_id',$request->get("user_id"))->where('is_default',1)->get();
            if(!$business_data->isEmpty())
            {
                foreach ($business_data as $value){
                    $b = Business::find($value->id);
                    $b->is_default = 0;
                    $b->save();
                }
            }

            $id = Business::create([
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "mobile_no" => $request->get("mobile_no"),
                "address" => $request->get("address"),
                "website" => $request->get("website"),
                "user_id" => $request->get("user_id"),
                "business_category_id" => $request->get("business_category_id"),
                "is_default" => 1,
            ])->id;

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("logo") && $request->file('logo')->isValid()) {
                    $image = $request->file('logo');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $b = Business::find($id);
                    $b->logo = $file;
                    $b->save();
                }
            }
            else
            {
                if ($request->file("logo") && $request->file('logo')->isValid()) {
                    $this->upload_image($request->file("logo"),"logo", $id);
                }
            }
           
            if($request->get("user_id") == Auth::user()->id)
            {
                return redirect()->route("business.index");
            }
            else
            {
                return redirect('admin/user/'.$request->get("user_id"));
            }
        }
    }

    public function edit($id)
    {
        $business = Business::find($id);
        $category =  BusinessCategory::where('status',1)->get();
        return view("business.edit", compact("business","category"));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            "mobile_no" => 'required|numeric',
            'email' => 'required|email|unique:business,email,' . \Request::get("id"),
            "logo" => "nullable|mimes:jpg,png,jpeg",
            "website" => 'required',
            'address' => 'required',
            "business_category_id" => 'required',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $business = Business::whereId($request->get("id"))->first();
            $business->name = $request->get("name");
            $business->email = $request->get("email");
            $business->mobile_no = $request->get("mobile_no");
            $business->website = $request->get("website");
            $business->address = $request->get("address");
            $business->business_category_id = $request->get("business_category_id");
            $business->save();

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("logo") && $request->file('logo')->isValid()) {
                    $image = $request->file('logo');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $b = Business::find($request->get("id"));
                    $b->logo = $file;
                    $b->save();
                }
            }
            else
            {
                if($request->file("logo") && $request->file('logo')->isValid()) {
                    $this->upload_image($request->file("logo"),"logo", $id);
                }
            }

            return redirect()->route('business.index');
        }
    }

    public function destroy($id)
    {
        $business = Business::find($id);
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            Storage::disk('spaces')->delete('uploads/'.$business->logo);
        }
        else
        {
            unlink('./uploads/'.$business->logo);
        }

        Business::find($id)->delete();
        return redirect()->route('business.index');
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        $image = Business::find($id);
        $image->$field = $fileName;
        $image->save();
    }
}
