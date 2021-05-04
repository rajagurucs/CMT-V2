<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    //
    public function create()
    {

    }

    // public function store(Request $request)
    // {
    //     $path = $request->file(key: 'image')->store(path: 'profile_images', options: 's3');

    //     Storage::disk(name: 's3')->setVisibility($path, visiblity: 'public');
        
    //     $image = Image::create([
    //         'filename' =>basename($path),
    //         'url' => Storage::disk(name: 's3')->url($path)
    //     ]);

    //     return $image;
    // }

    public function show(Image $image)
    {
        return Storage::disk('s3')->response('images/' . $image->filename);
    }

}
