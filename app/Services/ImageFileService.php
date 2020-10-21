<?php


namespace App\Services;


use App\ImageFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageFileService
{
    /**
     * @param $id
     * @return string|null
     */
    public static function getImageFilePath($id)
    {
        if ($image = ImageFile::find($id)) {
            return $image['data'];
        }
        return null;
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
            File::delete(public_path($icon->data));
            $fileData['name'] = self::validateName($fileData['name']);
            $file = Image::make($fileData['data'])->save('images/' . $fileData['name']);
            $icon->update(['name' => $fileData['name'], 'data' => $file->basePath()]);
        } else {
            $icon = self::createImageFile($fileData);
        }
        return $icon;
    }

    private static function validateName($filename)
    {
        if (!(strpos($filename, '.png') || strpos($filename, '.jpg') ||
            strpos($filename, '.jpeg'))) {
            $filename = $filename . '.png';
        }
        return time() . '$' . $filename;
    }

    /**
     * @param $fileData array of images properties
     * @return ImageFile
     */
    public static function createImageFile(array $fileData)
    {
        $fileData['name'] = self::validateName($fileData['name']);
        $file = Image::make($fileData['data'])->save('images/' . $fileData['name']);
        return ImageFile::create(['name' => $fileData['name'], 'data' => $file->basePath()]);
    }

    public static function deleteFile($file)
    {
        $file = ImageFile::find($file);
        File::delete('public/' . $file->data);
        ImageFile::destroy($file);
    }

}