<?php

namespace App;

use Symfony\Component\Console\Helper\Dumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;


class WPCLI
{

    protected $wordpressPath;

    function __construct(string $path)
    {
        $this->wordpressPath = $path;
       
    }

    public function exec(string $command)
    {
        $exec = WP . " " . $command . ' --path=' . $this->wordpressPath . ' --allow-root';
        return shell_exec($exec);
    }

    public function dbExport(){
        $res = $this->exec('db export --porcelain');
        $expl = explode('.',$res);
        
        shell_exec('tar -czf '.$expl[0].'.tgz '.$res );
        shell_exec('rm -rf ' . $res );
        shell_exec('mv ' . $expl[0] . '.tgz  tmp/');
    }
}
