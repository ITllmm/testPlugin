<?php

    if( !defined('ABSPATH')){
        exit;
    }

    class SalerManagerTest
    {
        protected $pageSlug;

        function __construct()
        {
            $this->pageSlug = test_config_helper('saler_manager_test');
            add_action('network_admin_menu',array($this,'addNetAdminMenu'));
        }

        public function addNetAdminMenu()
        {
            $menu_hook = add_submenu_page(test_config_helper('net_test_slug'),'saler_manager_pagetitle','saler_manager_menutitle','publish_posts',$this->pageSlug,array($this,'showPageHtml'));
        }

        public function showPageHtml()
        {
            echo '<p>tidfhidfodfhi</p>';
        }

    }

    $salermanagertest = new SalerManagerTest;