<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// paquete intervention
use Intervention\Image\Facades\Image;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::paginate(20);
        return view('admin.file.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.file.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Codigo de YouDevs, la quite por que fatla la relación con el usuario
        // $newfile = new File();
        // if($request->hasFile('file')){
        //     $file = $request->file('file');
        //     $destinationPath ='images/';
        //     $filename = time() .'-'. $file->getClientOriginalName();
        //     $uploadSuccess = $request->file('file')->move($destinationPath,$filename);
        //     $newfile->url = $destinationPath . $filename;
        // }
        // $newfile->save();
        // return redirect()->route('admin.files.index');

        // Codigo Coders Free
        // $request->validate([
        //     'file' => 'required|image|max:2048'
        // ]);

        $nombre = Str::random(10) . $request->file('file')->getClientOriginalName();
        $ruta = storage_path() . '\app\public\imagenes/' . $nombre;

        Image::make($request->file('file'))
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta);

        File::create([
            'user_id' => auth()->user()->id,
            'url' => 'storage/imagenes/' . $nombre
        ]);

        return redirect()->route('admin.files.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Pasar variable file
    public function show($file)
    {
        // return view('admin.file.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($file)
    {
        return view('admin.file.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $url = str_replace('storage', 'public', $file->url);
        Storage::delete($url);

        $file->delete();
        return redirect()->route('admin.files.index');
    }
}
