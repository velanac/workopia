<?php

namespace Framework;

class Session
{
    /**
     * Start the session
     * 
     * @return void
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
