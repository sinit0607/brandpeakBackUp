<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BusinessFrame;
use App\Models\StorageSetting;
use App\Models\BusinessCategory;
use App\Models\BusinessSubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BusinessFrameController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:BusinessFrame');
    }

    public function index()
    {
        $index['category'] = BusinessCategory::get();
        $index['data'] = BusinessFrame::orderBy('id', 'DESC')->paginate(12);
        return view("business_frame.index", $index);
    }

    public function create()
    {
        $index['category'] = BusinessCategory::where('status',1)->get();
        return view("business_frame.create", $index);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validation = Validator::make($request->all(), [
            "business_category_id" => 'required',
            // "business_sub_category_id" => 'required',
            "frame_image" => "required",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            if ($request->file("frame_image")) 
            {
                $removedImages = json_decode($request->get("deleted_file_ids"), true);
                $images = $request->file('frame_image');
                foreach($images as $image) 
                {
                    if($removedImages != null)
                    {
                        if (in_array($image->getClientOriginalName(), $removedImages)) {
                            continue;
                        }
                    }
                    
                    $size = getimagesize($image);
                    if($size[0] > $size[1])
                    {
                        $type = "landscape";
                    }
                    if($size[0] < $size[1])
                    {
                        $type = "portrait";
                    }
                    if($size[0] == $size[1])
                    {
                        $type = "square";
                    }

                    $id = BusinessFrame::create([
                        "business_category_id" => $request->get("business_category_id"),
                        "business_sub_category_id" => $request->get("business_sub_category_id"),
                        "user_id" => Auth::User()->id,
                        "paid" => 1,
                        "height" => $size[1],
                        "width" => $size[0],
                        "image_type" => $type,
                        "aspect_ratio" => $this->getAspectRatio($size[0],$size[1]),
                    ])->id;

                    if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
                    {
                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                        $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                            
                        $f = BusinessFrame::find($id);
                        $f->frame_image = $file;
                        $f->save();
                    }
                    else
                    {
                        $this->upload_image($image,"frame_image", $id);
                    }
                }
            }

            return redirect()->route("business-frame.index");
        }
    }

    public function business_frame_status(Request $request)
    {
        $category = BusinessFrame::find($request->get("id"));
        $category->status = ($request->get("checked")=="true")?1:0;
        $category->save();
    }

    public function get_business_sub_category(Request $request)
    {
        $category = BusinessSubCategory::where("business_category_id",$request->get("id"))->get();
        return $category;
    }

    public function business_frame_action(Request $request)
    {
        $ids = explode(",",$request->select_post);
        if($request->select_post != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $category = BusinessFrame::find($id);
                    $category->status = 1;
                    $category->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $category = BusinessFrame::find($id);
                    $category->status = 0;
                    $category->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    BusinessFrame::find($id)->delete();
                }
            }
        }

        return redirect()->route("business-frame.index");
    }

    public function business_category_get($id)
    {
        $index['category'] = BusinessCategory::get();
        $index['data'] = BusinessFrame::where('business_category_id',$id)->paginate(12);
        $c_name=BusinessCategory::find($id);
        $index['name'] = $c_name->name;

        return view("business_frame.index", $index);
    }

    public function business_frame_type(Request $request)
    {
        $category = BusinessFrame::find($request->get("id"));
        $category->paid = ($request->get("checked")=="true")?1:0;
        $category->save();

        if($category->paid == 1)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function edit($id)
    {
        $index['businessFrame'] = BusinessFrame::find($id);
        $index['businessSubCategory'] = BusinessSubCategory::where("business_category_id",$index['businessFrame']->business_category_id)->where('status',1)->get();
        $index['category'] = BusinessCategory::where('status',1)->get();
        return view("business_frame.edit", $index);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "business_category_id" => 'required',
            // "business_sub_category_id" => 'required',
            "frame_image" => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $category = BusinessFrame::find($request->get("id"));
            $category->business_category_id = $request->get("business_category_id");
            $category->business_sub_category_id = $request->get("business_sub_category_id");
            $category->save();

            if ($request->file("frame_image") && $request->file('frame_image')->isValid()) {
                $size = getimagesize($request->file('frame_image'));
                if($size[0] > $size[1])
                {
                    $type = "landscape";
                }
                if($size[0] < $size[1])
                {
                    $type = "portrait";
                }
                if($size[0] == $size[1])
                {
                    $type = "square";
                }

                $frame = BusinessFrame::find($request->get("id"));
                $frame->height = $size[1];
                $frame->width = $size[0];
                $frame->image_type = $type;
                $frame->aspect_ratio = $this->getAspectRatio($size[0],$size[1]);
                $frame->save();

                if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
                {
                    if ($request->file("frame_image")) {
                        $image = $request->file('frame_image');
                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                
                        $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                        
                        $f = BusinessFrame::find($request->get("id"));
                        $f->frame_image = $file;
                        $f->save();
                    }
                }
                else
                {
                    $this->upload_image($request->file("frame_image"),"frame_image", $id);
                }
            }

            return redirect()->route('business-frame.index');
        }
    }

    public function destroy($id)
    {
        $businessFrame = BusinessFrame::find($id);
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            Storage::disk('spaces')->delete('uploads/'.$businessFrame->frame_image);
        }
        else
        {
            unlink('./uploads/'.$businessFrame->frame_image);
        }

        BusinessFrame::find($id)->delete();
        return redirect()->route('business-frame.index');
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        $image = BusinessFrame::find($id);
        $image->$field = $fileName;
        $image->save();
    }

    public function getAspectRatio(int $width, int $height)
    {
        $divisor = gmp_intval(gmp_gcd($width,$height));
        return $width / $divisor . ':' . $height / $divisor;
    }
}
