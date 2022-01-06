<?php

namespace App;

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
        return exec($exec);
    }
}
