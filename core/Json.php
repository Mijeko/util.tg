<?php

namespace SmallJedi\Core;

class Json
{

    /**
     * @param $data array
     * @return string
     *
     */
    public static function encode($data)
    {
        return json_encode($data);
    }

    /**
     * @param $data string
     * @return array | object
     *
     */
    public static function decode($data, bool $asObject = false)
    {
        return json_decode($data, !$asObject);
    }
}
