<?php

namespace App;

use App\Config as Config;

class DataSource
{

    protected $options = ['datasource' => 'CSV'];
    protected $config;

    function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->setOptions($options);
        } else {
            $options = $this->options;
        }
    }

    function getSources(){
        if($this->options['datasource'] == 'CSV'){
            $config = new Config();
            $this->config = $config->getConfig();
            $res = [];
            if (($handle = fopen($this->config['csv'], "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    //$data = fgetcsv($handle, 100, ";");
                   $res[] = $data[0];
                }
                return $res;
            }
            //$csv = file($this->config['csv']);

            //$csvdata = str_getcsv($csv);
            
        }

        if ($this->options['datasoruce'] == 'database') {
            // to do
        }        
    }

    function setOptions(array $options): void
    {
        $this->options = $options;
    }


    function getOptions(): array
    {
        return $this->options;
    }
}
