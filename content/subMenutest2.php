<?php

  class SubMenuTest2
  {
    public function __construct()
    {
      $this->pageSlug = test_config_helper('test2_sulg');
      add_action( 'admin_menu',   array($this, 'addAdminMenu') );
              // $base = basename(__DIR__);
// echo '<pre>';
// print_r(plugins_url().'/'.$base.'/css/table.css');
// print_r(__DIR__.'/css/table.css');
// exit;
   }

    public function addAdminMenu()
    {
      $menu_hook = add_submenu_page(test_config_helper('test1_sulg'),'sub2_pagetitle','sub2_menutitle','publish_posts',$this->pageSlug,array($this,'showPageHtml'));

      add_action('admin_print_styles-'.$menu_hook,array($this,'addStyle'));
      add_action('admin_print_scripts-'.$menu_hook,array($this,'addScript'));
    }

    public function addScript()
    {
      wp_enqueue_script( 'bootstrap-js',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", array('jquery'));
    }

    public function addStyle()
    {
      //var_dump(plugins_url()); -> http://template1.wpdemo.app/wp-content/plugins ->a hrefs
      //var_dump(__DIR__);-> /home/www/wpdemo/wp-content/plugins/wp-test-plugin/content
      wp_enqueue_style( 'bootstrap-css',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
    }

    public function showPageHtml()
    {
      include(__DIR__.'/html/submenutest2Html.php');
    }
  }

  $subMenuTest2 = new SubMenuTest2;