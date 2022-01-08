<?php

namespace App;


class Config
{

    protected $config;

    function __construct(string $configPath = '')
    {
        if($configPath == ''){
            $inifile = dirname(__DIR__) . '/config/app.ini';
            if(file_exists($inifile)){
               $this->config = parse_ini_file($inifile); 
            }else{
                die('ini file not found. Aborting,');
            }
            
        }
    }

    public function getConfig(){
        return $this->config;
    }

}
