<?php

/**
 * Created by PhpStorm.
 * User: devonpapandrew
 * Date: 10/26/17
 * Time: 6:37 PM
 */
class DB
{
    /**
     * Connects to database, returns $mysqli object
     * @return \mysqli
     */
    public static function connect(){

        $host = 'sitelite.cqre5u0pvjqm.us-east-1.rds.amazonaws.com';
        $user = 'bar.golf';
        $password = 'ebM4yFTzfMG0HYj5';
        $schema = 'bar_golf';

        $mysqli = new \mysqli($host, $user, $password, $schema);

        return $mysqli;
    }

}