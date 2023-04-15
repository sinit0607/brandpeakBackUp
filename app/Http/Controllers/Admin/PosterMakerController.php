<?php

namespace App\Http\Controllers\Admin;

use App\Models\PosterMaker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PosterCategory;
use App\Models\StorageSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PosterMakerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:PosterMaker');
    }

    public function index()
    {
        $index['data'] = PosterMaker::orderBy('id', 'DESC')->paginate(12);
        return view("poster_maker.index", $index);
    }

    public function create()
    {
        $index['category'] = PosterCategory::where('status',1)->get();
        return view("poster_maker.create",$index);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'poster_category_id' => 'required',
            'template_type' => 'required',
            'zip' => 'required|mimes:zip',
            'post_thumb' => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } 
        else 
        {
            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                $zip_name = "Frame".date("YmdHis");
                $zip_original_name = pathinfo($request->file("zip")->getClientOriginalName(),PATHINFO_FILENAME);
                $extension = $request->file("zip")->getClientOriginalExtension();
                $file_name = $zip_name.".".$extension;
                $request->file("zip")->move('./uploads/template', $file_name);
        
                File::makeDirectory('./uploads/template/'.$zip_name);

                $zip = new \ZipArchive;
                if ($zip->open('./uploads/template/'.$file_name) === TRUE) {
                    $zip->extractTo('./uploads/template/'.$zip_name);
                    $zip->close();
                } 
                unlink('./uploads/template/'.$file_name);
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/fonts', './uploads/template/'.$zip_name.'/fonts');
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/json', './uploads/template/'.$zip_name.'/json');
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/logs', './uploads/template/'.$zip_name.'/logs');
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/skins', './uploads/template/'.$zip_name.'/skins');
                $this->rrmdir('./uploads/template/'.$zip_name.'/'.$zip_original_name);

                // $local = File::allFiles('./uploads/template/'.$zip_name);
                // foreach($local as $l)
                // {
                //     Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/'.$l->getrelativePathname(), file_get_contents($l), 'public');
                // }

                $fonts = File::allFiles('./uploads/template/'.$zip_name.'/fonts/');
                foreach($fonts as $f)
                {
                    Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/fonts/'.$f->getrelativePathname(), file_get_contents($f), 'public');
                }

                $json = File::allFiles('./uploads/template/'.$zip_name.'/json/');
                foreach($json as $j)
                {
                    Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/json/'.$j->getrelativePathname(), file_get_contents($j), 'public');
                }

                $logs = File::allFiles('./uploads/template/'.$zip_name.'/logs/');
                Storage::disk('spaces')->makeDirectory('/uploads/template/'.$zip_name.'/logs/');
                foreach($logs as $log)
                {
                    Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/logs/'.$log->getrelativePathname(), file_get_contents($log), 'public');
                }

                $skins = File::allFiles('./uploads/template/'.$zip_name.'/skins/');
                foreach($skins as $s)
                {
                    Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/skins/'.$s->getrelativePathname(), file_get_contents($s), 'public');
                }

                $this->rrmdir('./uploads/template/'.$zip_name);
            }
            else
            {
                $zip_name = "Frame".date("YmdHis");
                $zip_original_name = pathinfo($request->file("zip")->getClientOriginalName(),PATHINFO_FILENAME);
                $extension = $request->file("zip")->getClientOriginalExtension();
                $file_name = $zip_name.".".$extension;
                $request->file("zip")->move('./uploads/template', $file_name);
                File::makeDirectory('./uploads/template/'.$zip_name);

                $zip = new \ZipArchive;
                if ($zip->open('./uploads/template/'.$file_name) === TRUE) {
                    $zip->extractTo('./uploads/template/'.$zip_name);
                    $zip->close();
                } 
                unlink('./uploads/template/'.$file_name);
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/fonts', './uploads/template/'.$zip_name.'/fonts');
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/json', './uploads/template/'.$zip_name.'/json');
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/logs', './uploads/template/'.$zip_name.'/logs');
                rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/skins', './uploads/template/'.$zip_name.'/skins');
                $this->rrmdir('./uploads/template/'.$zip_name.'/'.$zip_original_name);
            }

            $id = PosterMaker::create([
                "poster_category_id" => $request->get("poster_category_id"),
                "template_type" => $request->get("template_type"),
                "zip_name" => $zip_name,
            ])->id;

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("post_thumb") && $request->file('post_thumb')->isValid()) {
                    $image = $request->file('post_thumb');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $poster = PosterMaker::find($id);
                    $poster->post_thumb = $file;
                    $poster->save();
                }
            }
            else
            {
                if ($request->file("post_thumb") && $request->file('post_thumb')->isValid()) {
                    $this->upload_image($request->file("post_thumb"),"post_thumb", $id);
                }
            }

            return redirect()->route("poster-maker.index");
        }
    }

    public function poster_maker_frame_type(Request $request)
    {
        $poster = PosterMaker::find($request->get("id"));
        $poster->paid = ($request->get("checked")=="true")?1:0;
        $poster->save();

        if($poster->paid == 1)
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
        $poster = PosterMaker::find($id);
        $category = PosterCategory::where('status',1)->get();
        return view("poster_maker.edit", compact("poster","category"));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'poster_category_id' => 'required',
            'template_type' => 'required',
            'zip' => 'nullable|mimes:zip',
            'post_thumb' => "nullable|mimes:jpg,png,jpeg",
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } else {
            $poster = PosterMaker::find($request->get("id"));
            $poster->poster_category_id = $request->get("poster_category_id");
            $poster->template_type = $request->get("template_type");
            $poster->save();

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if($request->file("zip"))
                {
                    $this->rrmdir('./uploads/template/'.$poster->zip_name);
                    $zip_name = "Frame".date("YmdHis");
                    $zip_original_name = pathinfo($request->file("zip")->getClientOriginalName(),PATHINFO_FILENAME);
                    $extension = $request->file("zip")->getClientOriginalExtension();
                    $file_name = $zip_name.".".$extension;
                    $request->file("zip")->move('./uploads/template', $file_name);
                    File::makeDirectory('./uploads/template/'.$zip_name);
        
                    $zip = new \ZipArchive;
                    if ($zip->open('./uploads/template/'.$file_name) === TRUE) {
                        $zip->extractTo('./uploads/template/'.$zip_name);
                        $zip->close();
                    } 
                    unlink('./uploads/template/'.$file_name);
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/fonts', './uploads/template/'.$zip_name.'/fonts');
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/json', './uploads/template/'.$zip_name.'/json');
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/logs', './uploads/template/'.$zip_name.'/logs');
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/skins', './uploads/template/'.$zip_name.'/skins');
                    $this->rrmdir('./uploads/template/'.$zip_name.'/'.$zip_original_name);

                    // $local = File::allFiles('./uploads/template/'.$zip_name);
                    // foreach($local as $l)
                    // {
                    //     Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/'.$l->getrelativePathname(), file_get_contents($l), 'public');
                    // }

                    $fonts = File::allFiles('./uploads/template/'.$zip_name.'/fonts/');
                    foreach($fonts as $f)
                    {
                        Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/fonts/'.$f->getrelativePathname(), file_get_contents($f), 'public');
                    }

                    $json = File::allFiles('./uploads/template/'.$zip_name.'/json/');
                    foreach($json as $j)
                    {
                        Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/json/'.$j->getrelativePathname(), file_get_contents($j), 'public');
                    }

                    $logs = File::allFiles('./uploads/template/'.$zip_name.'/logs/');
                    Storage::disk('spaces')->makeDirectory('/uploads/template/'.$zip_name.'/logs/');
                    foreach($logs as $log)
                    {
                        Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/logs/'.$log->getrelativePathname(), file_get_contents($log), 'public');
                    }

                    $skins = File::allFiles('./uploads/template/'.$zip_name.'/skins/');
                    foreach($skins as $s)
                    {
                        Storage::disk('spaces')->put('/uploads/template/'.$zip_name.'/skins/'.$s->getrelativePathname(), file_get_contents($s), 'public');
                    }

                    $this->rrmdir('./uploads/template/'.$zip_name);
                    
                    $poster_one = PosterMaker::find($request->get("id"));
                    $poster_one->zip_name = $zip_name;
                    $poster_one->save();
                }
            }
            else
            {
                if($request->file("zip"))
                {
                    $this->rrmdir('./uploads/template/'.$poster->zip_name);
                    $zip_name = "Frame".date("YmdHis");
                    $zip_original_name = pathinfo($request->file("zip")->getClientOriginalName(),PATHINFO_FILENAME);
                    $extension = $request->file("zip")->getClientOriginalExtension();
                    $file_name = $zip_name.".".$extension;
                    $request->file("zip")->move('./uploads/template', $file_name);
                    File::makeDirectory('./uploads/template/'.$zip_name);
        
                    $zip = new \ZipArchive;
                    if ($zip->open('./uploads/template/'.$file_name) === TRUE) {
                        $zip->extractTo('./uploads/template/'.$zip_name);
                        $zip->close();
                    } 
                    unlink('./uploads/template/'.$file_name);
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/fonts', './uploads/template/'.$zip_name.'/fonts');
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/json', './uploads/template/'.$zip_name.'/json');
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/logs', './uploads/template/'.$zip_name.'/logs');
                    rename('./uploads/template/'.$zip_name.'/'.$zip_original_name.'/skins', './uploads/template/'.$zip_name.'/skins');
                    $this->rrmdir('./uploads/template/'.$zip_name.'/'.$zip_original_name);

                    $poster_one = PosterMaker::find($request->get("id"));
                    $poster_one->zip_name = $zip_name;
                    $poster_one->save();
                }
            }

            if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
            {
                if ($request->file("post_thumb") && $request->file('post_thumb')->isValid()) {
                    $image = $request->file('post_thumb');
                    $file = Str::uuid().'.'.$image->getClientOriginalExtension();
            
                    $path = Storage::disk('spaces')->put('uploads/'.$file, file_get_contents($image),'public');
                    
                    $poster = PosterMaker::find($request->get("id"));
                    $poster->post_thumb = $file;
                    $poster->save();
                }
            }
            else
            {
                if ($request->file("post_thumb") && $request->file('post_thumb')->isValid()) {
                    $this->upload_image($request->file("post_thumb"),"post_thumb", $id);
                }
            }

            return redirect()->route('poster-maker.index');
        }
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


    public function destroy($id)
    {
        $posterMaker = PosterMaker::find($id);
        if(StorageSetting::getStorageSetting("storage") == "DigitalOcean")
        {
            Storage::disk('spaces')->delete('uploads/'.$posterMaker->post_thumb);
        }
        else
        {
            unlink('./uploads/'.$posterMaker->post_thumb);
        }

        $poster = PosterMaker::find($id);
        $this->rrmdir('./uploads/template/'.$poster->zip_name);
        PosterMaker::find($id)->delete();

        return redirect()->route('poster-maker.index');
    }

    private function upload_image($file,$field,$id)
    {
        $destinationPath = './uploads';
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        
        $image = PosterMaker::find($id);
        $image->$field = $fileName;
        $image->save();
    }
}
