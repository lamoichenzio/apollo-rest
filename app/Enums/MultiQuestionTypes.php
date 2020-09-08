<?php


namespace App\Enums;


class MultiQuestionTypes
{
    public static $RADIO = 'RADIO';
    public static $CHECK = 'CHECK';
    public static $SELECT = 'SELECT';

    public static function types()
    {
        return [MultiQuestionTypes::$RADIO, MultiQuestionTypes::$CHECK, MultiQuestionTypes::$SELECT];
    }
}