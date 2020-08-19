<?php

namespace App\Http\Controllers;

use App\ImageFile;

class ImageFileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param ImageFile $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ImageFile $image)
    {
        return response()->json($image);
    }

}
