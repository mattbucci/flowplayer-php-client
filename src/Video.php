<?php

namespace Flowplayer;

class Video
{
    //TODO: add properties


    public function __construct($attributes)
    {
        foreach($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function fromArray($attributes)
    {
        return new static($attributes);
    }
}
