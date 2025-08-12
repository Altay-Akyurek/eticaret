<?php
namespace App\Help;

class Validation
{
    public static function minLength($value,$length)
    {
        return mb_strlen(trim($value))>= $length;
    }
    public static function isEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    public static function isNumeric($value)
    {
        return is_numeric($value);
    }
    public static function required($value)
    {
        return !empty(trim($value));
    }
}
?>