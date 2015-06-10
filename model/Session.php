<?php

class Session {

    public static function setFlashData($class, $text)
    {
        $_SESSION['flashData'] = serialize(array('alert-class' => $class, 'text' => $text));
    }

    public static function getFlashData()
    {
        $value = unserialize((string)$_SESSION['flashData']);
        $_SESSION['flashData'] = null;

        if (is_array($value)) {
            return $value;
        }

        return false;
    }
}