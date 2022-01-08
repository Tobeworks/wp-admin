<?php

namespace App;


class Config
{

    protected $config;

    function __construct(string $configPath = '')
    {
        if($configPath == ''){
            $this->config = parse_ini_file('config/app.ini');
        }
    }

    public function getConfig(){
        return $this->config;
    }

}
