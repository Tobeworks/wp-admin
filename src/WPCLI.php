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

    public function export()
    {
        $this->dbExport();
        $this->fileExport();
        $this->mkDir();
        shell_exec("mv *.tgz {$this->path}/tmp/" . $this->getSiteURL() . '-' . $this->fileName . '/');
    }

    public function mkDir()
    {
        shell_exec("mkdir -p {$this->path}/tmp/" . $this->getSiteURL() . '-' . $this->fileName);
    }

    public function getSiteURL()
    {
        return  preg_replace('#http://|https://#', '', $this->exec('option get siteurl'));
    }

    public function dbExport()
    {

        $res = $this->exec('db export --porcelain');
        $expl = explode('.', $res);

        $this->fileName = $expl[0];
        $this->tgzName = $this->fileName . '.tgz';


        shell_exec('tar -czf ' . $this->tgzName . ' ' . $res);
        shell_exec('rm -rf ' . $res);
    }

    public function fileExport()
    {
        $siteUrl = $this->getSiteURL();

        return  shell_exec('tar -vczf ' . date('Y-m-d', time()) . '_files.tgz ' . $this->wordpressPath);
    }

    public function checkUpdate()
    {
        $json = $this->exec('core check-update --format=json');
        $res = json_decode($json);
        if (isset($res[0])) {
            return $res[0]->version;
        } else {
            return false;
        }
    }


    public function CoreUpdate()
    {
        return $this->exec('core update');
    }

    public function PluginsUpdate()
    {
        return $this->exec('plugin update --all');
    }

    public function ThemesUpdate()
    {
        return $this->exec('theme update --all');
    }
}
