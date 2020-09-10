<?php


namespace App\Helpers;


class DataHelper
{

    /**
     * @param $data
     * @return array response message
     */
    public static function listDataResponse($data)
    {
        return ['data' => $data];
    }

    /**
     * @param $data object created
     * @return array Response message
     */
    public static function creationDataResponse($data)
    {
        return ['self' => $data->path()];
    }

}