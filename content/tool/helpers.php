<?php

    function test_config_helper($configname)
    {
        $result = include(dirname(__DIR__).'/config.php');
        return $result[$configname];
    }