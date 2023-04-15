<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Language;
use App\Models\Festivals;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FestivalsFrame;
use App\Models\StorageSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FestivalsFrameController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:FestivalFrame');
    }

    public function index()
    {
        $index['festivals'] = Festivals::get();
        $index['data'] = FestivalsFrame::orderBy('id', 'DESC')->paginate(12);
        return view("festivals_frame.index", $index);
    }

    public function create()
    {
        $index['festivals'] = Festivals::where('status',1)->get();
        $index['language'] = Language::where('status',1)->get();
        return view("festivals_frame.create", $index);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(), [
            "festivals_id" => 'required',
            "language_id" => 'required',
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

                    $id = FestivalsFrame::create([
                        "festivals_id" => $request->get("festivals_id"),
                        "language_id" => $request->get("language_id"),
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
                        
                        $f = FestivalsFrame::find($id);
                        $f->frame_image = $file;
                        $f->save();
                    }
                    else
                    {
                        $this->upload_image($image,"frame_image", $id);
                    }
                }
            }

            if($request->total)
            {
                $arr = explode(",",$request->total);
                foreach($arr as $tt)
                {
                    if ($request->file("frame_image".$tt)) 
                    {
                        $images = $request->file('frame_image'.$tt);
                        foreach($images as $image) 
                        {
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

                            $id = FestivalsFrame::create([
                                "festivals_id" => $request->get("festivals_id"),
                                "language_id" => $request->get("language_id".$tt),
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
                                
                                $f = FestivalsFrame::find($id);
                                $f->frame_image = $file;
                                $f->save();
                            }
                            else
                            {
                                $this->upload_image($image,"frame_image", $id);
                            }
                        }
                    }
                }
            }

            return redirect()->route("festivals-frame.index");
        }
    }

    public function festivals_frame_status(Request $request)
    {
        $festivals = FestivalsFrame::find($request->get("id"));
        $festivals->status = ($request->get("checked")=="true")?1:0;
        $festivals->save();
    }

    public function festivals_frame_action(Request $request)
    {
        $ids = explode(",",$request->select_post);
        if($request->select_post != null)
        {
            if($request->action_type == "enable")
            {
                foreach($ids as $id){
                    $category = FestivalsFrame::find($id);
                    $category->status = 1;
                    $category->save();
                }
            }
    
            if($request->action_type == "disable")
            {
                foreach($ids as $id){
                    $category = FestivalsFrame::find($id);
                    $category->status = 0;
                    $category->save();
                }
            }
    
            if($request->action_type == "delete")
            {
                foreach($ids as $id){
                    FestivalsFrame::find($id)->delete();
                }
            }
        }

        return redirect()->route("festivals-frame.index");
    }

    public function festival_filter($id)
    {
        $index['festivals'] = Festivals::get();
        $index['data'] = FestivalsFrame::where('festivals_id',$id)->paginate(12);
        $f_name=Festivals::find($id);
        $index['name'] = $f_name->title;
        return view("festivals_frame.index", $index);
    }

    public function festivals_frame_type(Request $request)
    {
        $festivals = FestivalsFrame::find($request->get("id"));
        $festivals->paid = ($request->get("checked")=="true")?1:0;
        $festivals->save();

        if($festivals->paid == 1)
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
        $index['festivalsFrame'] = FestivalsFrame::find($id);
        $index['festivals'] = Festivals::get();
        $index['language'] = Language::get();
        return view("festivals_frame.edit", $index);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "festivals_id" => 'required',
            "language_id" => 'required',
            "frame_image" => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $festivals = FestivalsFrame::find($request->get("id"));
            $festivals->festivals_id = $request->get("festivals_id");
            $festivals->language_id = $request->get("language_id");
            $festivals->save();

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

                $festival_frame = FestivalsFrame::find($request->get("id"));
                $festival_frame->height = $size[1];
                $festival_frame->width = $size[0];
                $festival_frame->image_type = $type;
                $festival_frame->aspect_ratio = $this->getAspectRatio($size[0],$size[1]);
                $festival_frame->save();

                if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
                {
                    if ($request->file("frame_image")) {
                        $image = $request->file('frame_image');
                        $file = Str::uuid().'.'.$image->getClientOriginalExtension();
                
                        $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                        
                        $user = FestivalsFrame::find($request->get("id"));
                        $user->frame_image = $file;
                        $user->save();
                    }
                }
                else
                {
                    $this->upload_image($request->file("frame_image"),"frame_image", $id);
                }
            }

            return redirect()->route('festivals-frame.index');
        }
    }

    public function destroy($id)
    {
        $festivalsFrame = FestivalsFrame::find($id);
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            Storage::disk('spaces')->delete('uploads/'.$festivalsFrame->frame_image);
        }
        else
        {
            unlink('./uploads/'.$festivalsFrame->frame_image);
        }

        FestivalsFrame::find($id)->delete();
        return redirect()->route('festivals-frame.index');
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        $image = FestivalsFrame::find($id);
        $image->$field = $fileName;
        $image->save();
    }

    public function getAspectRatio(int $width, int $height)
    {
        $divisor = gmp_intval(gmp_gcd($width,$height));
        return $width / $divisor . ':' . $height / $divisor;
    }
}
