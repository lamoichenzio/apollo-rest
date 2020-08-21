<?php


namespace App\Services;


use App\ImageFile;

class ImageFileService
{
    public static function getImageFilePath($id)
    {
        if ($image = ImageFile::find($id)) {
            return $image = $image->path();
        }
        return null;
    }

    public static function createImageFile($fileData)
    {
        return new ImageFile($fileData);
    }

    public static function updateImageFile($fileReference, $fileData)
    {
        if ($fileReference) {
            $icon = ImageFile::find($fileReference);
            $icon->update($fileData);
        } else {
            $icon = ImageFile::create($fileData);
        }
        return $icon;
    }

}