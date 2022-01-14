<?php

namespace App;

use FtpClient\FtpClient as FTP;
use App\Config as Config;

class Transfer
{

    protected $config;
    protected $ftp;

    function __construct(string $configPath = '')
    {
        $config = new Config();
        $this->config = $config->getConfig();
        $this->connectFTP();
    }

    public function connectFTP(){
        $this->ftp = new FTP();

        try {
            $this->ftp->connect($this->config['host'], true, $this->config['port']);
        } catch (\Exception $e) {
            die($e);
        }

        try {
            $this->ftp->login($this->config['user'], $this->config['pass']);
        } catch (\Exception $e) {
            die($e);
        }
    }

    public function putAll(){
        $this->ftp->putAll($this->config['safedir'], '/');
    }

}
