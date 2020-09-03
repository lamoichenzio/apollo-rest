<?php


namespace App\Enums;


class InputQuestionType
{

    public static $TEXT = 'TEXT';
    public static $TEXTAREA = 'TEXTAREA';
    public static $NUMBER = 'NUMBER';
    public static $DATE = 'DATE';

    public static function types()
    {
        return ['TEXT', 'TEXTAREA', 'NUMBER', 'DATE'];
    }
}