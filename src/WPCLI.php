<?php

namespace App;

use Symfony\Component\Console\Helper\Dumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;

use App\Config as Config;


class WPCLI
{

    protected string $wordpressPath = '';
    protected string $fileName = '';
    protected string $tgzName = '';
    protected string $path = '';
    protected string $domainDir = '';
    public $config;

    const WP = '/usr/local/bin/wp';

    function __construct(string $path)
    {
        $this->getConfig();
        $this->wordpressPath = $path;
        $this->path = dirname(__DIR__);
    }

    public function getConfig()
    {
        $config = new Config();
        $this->config = $config->getConfig();
    }

    public function exec(string $command)
    {
        $exec = self::WP . " " . $command . ' --path=' . $this->wordpressPath . ' --allow-root';
        return shell_exec($exec);
    }

    public function export()
    {
        chdir($this->config['safedir']);
        $this->mkDir();
        $this->dbExport();
        $this->fileExport();
    }

    public function mkDir()
    {
        $this->domainDir = "{$this->config['safedir']}/" . $this->getSiteURL();
        shell_exec("mkdir -p {$this->domainDir}");
    }

    public function getSiteURL()
    {
        $siteUrl = preg_replace('#http://|https://#', '', $this->exec('option get siteurl'));
        $siteUrl = str_replace("\n", '', $siteUrl);
        return $siteUrl;
    }

    public function dbExport()
    {

        $res = $this->exec('db export --porcelain');
        $expl = explode('.', $res);

        $this->fileName = $expl[0];
        $this->tgzName = $this->fileName . '.tgz';

        shell_exec('tar -czf ' . $this->tgzName . ' ' . $res);
        shell_exec('rm -rf ' . $res);
        shell_exec("mv {$this->tgzName} {$this->domainDir}");
    }

    public function fileExport()
    {
        $filename = date('Y-m-d-H-i', time()) . '_files.tgz';
        shell_exec("tar -vczf {$filename} --exclude={$filename} -C {$this->wordpressPath} .");
        shell_exec("mv {$filename} {$this->domainDir}");
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

    public function getName(){
        if($this->tgzName !== ''){
            return $this->tgzName;
        }
        return false;
    }

    public function getDomainDir(){
        if ($this->domainDir !== '') {
            return $this->domainDir;
        }
        return false;
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
