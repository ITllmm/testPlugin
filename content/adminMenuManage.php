<?php

class AdminMenuManage
{
    public function  __construct()
    {
        add_action( 'admin_menu',   array($this, 'addAdminMenu') );
    }

    public function addAdminMenu()
    {
        $menu_hook = add_menu_page('test_pagetitle','test_menutitle','publish_posts','test1_menuslug',null);
    }

}

$adminMeneManage  = new AdminMenuManage;