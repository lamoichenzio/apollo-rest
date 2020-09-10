<?php


namespace App\Enums;


class MatrixQuestionTypes
{
    public static $CHECK = "CHECK";
    public static $RADIO = "RADIO";

    public static function types()
    {
        return [MatrixQuestionTypes::$CHECK, MatrixQuestionTypes::$RADIO];
    }
}