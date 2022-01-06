<?php

namespace App;

use Symfony\Component\Console\Helper\Dumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;


class WPCLI
{

    protected string $wordpressPath;
    protected string $fileName;
    protected string $tgzName;
    protected string $path;

    const WP = '/usr/local/bin/wp';

    function __construct(string $path)
    {
        $this->wordpressPath = $path;
        $this->path = dirname(__DIR__);       
    }

    public function exec(string $command)
    {
        $exec = self::WP . " " . $command . ' --path=' . $this->wordpressPath . ' --allow-root';
        return shell_exec($exec);
    }

    public function export(){
        $this->dbExport();
        $this->fileExport();
        $this->mkDir();
        shell_exec("mv *.tgz {$this->path}/tmp/". $this->fileName.'/');
    }

    public function mkDir(){
        shell_exec("mkdir {$this->path}/tmp/" . $this->fileName);
    }

    public function dbExport(){
        $res = $this->exec('db export --porcelain');
        $expl = explode('.',$res);

        $this->fileName = $expl[0];
        $this->tgzName = $this->fileName.'.tgz';
        

        shell_exec('tar -czf '. $this->tgzName .' '.$res );
        shell_exec('rm -rf ' . $res );
        
    }

    public function fileExport(){
        shell_exec('tar --exclude='. $this->tgzName .' -vczf '. $this->fileName.'_files.tgz '. $this->wordpressPath);
    }

    public function checkUpdate(){
        $json = $this->exec('core check-update --format=json');
        $res = json_decode($json);
       return $res[0]->version;
    }
}
