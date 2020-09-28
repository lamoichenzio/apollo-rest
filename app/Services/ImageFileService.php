<?php


namespace App\Services;


use App\ImageFile;

class ImageFileService
{
    /**
     * @param $id
     * @return string|null
     */
    public static function getImageFilePath($id)
    {
        if ($image = ImageFile::find($id)) {
            return $image = $image->path();
        }
        return null;
    }

    /**
     * @param $fileData array of image properties
     * @return ImageFile
     */
    public static function createImageFile(array $fileData)
    {
        return ImageFile::create($fileData);
    }

    /**
     * @param $fileReference
     * @param $fileData
     * @return mixed The updated file
     */
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