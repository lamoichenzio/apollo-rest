<?php


namespace App\Helpers;


class DataHelper
{

    public static function listDataResponse($data)
    {
        return ['data' => $data];
    }

    public static function creationDataResponse($data)
    {
        return ['self' => $data->path()];
    }

}