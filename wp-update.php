#!/usr/bin/php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\WPBackup as Backup;

define('WP','/usr/local/bin/wp');

$backup = new Backup();
$application = new Application();
$application->add($backup);
$application->run();