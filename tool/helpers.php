<?php

    function test_config_helper($configname)
    {
        //dirname(__DIR__) :/home/www/wpdemo/wp-content/plugins/wp-test-plugin
        $result = include(dirname(__DIR__).'/config.php');
        return isset($result[$configname]) ? $result[$configname] : '';
    }