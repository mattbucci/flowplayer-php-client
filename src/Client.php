<?php

namespace Flowplayer;

class Client
{
    protected $api_caller;

    /**
     * Client constructor.
     * @param $api_caller
     */
    public function __construct($api_caller)
    {
        $this->api_caller = $api_caller;
    }
}
