<?php

class AdminMenuManage
{
    public function  __construct()
    {
        add_action( 'admin_menu',   array($this, 'addAdminMenu') );
        add_action('network_admin_menu',array($this,'addNetAdminMenu'));
    }

    public function addNetAdminMenu()
    {
        $menu_hook = add_menu_page('test_pagetitle','test_menutitle','publish_posts','net_test_slug',null);
    }

    public function addAdminMenu()
    {
        $menu_hook = add_menu_page('test_pagetitle','test_menutitle','publish_posts','admin_test_slug',null);
    }

}

$adminMeneManage  = new AdminMenuManage;