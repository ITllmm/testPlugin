<?php

  class SubMenuTest2
  {
    public function __construct()
    {
      $this->pageSlug = test_config_helper('test2_sulg');
      add_action( 'admin_menu',   array($this, 'addAdminMenu') );
      add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
      //add_action('wp_enqueue_scripts', array($this,'enqueue_scripts');
   }

    public function addAdminMenu()
    {
      $menu_hook = add_submenu_page( test_config_helper('admin_test_slug'),'sub2_pagetitle','sub2_menutitle','publish_posts',$this->pageSlug,array($this,'showPageHtml'));

      add_action('admin_print_styles-'.$menu_hook,array($this,'addStyle'));
      add_action('admin_print_scripts-'.$menu_hook,array($this,'addScript'));
    }

    public function addScript()
    {
      wp_enqueue_script( 'bootstrap-js',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", array('jquery'));
      // wp_enqueue_script( 'jquery-ui-datepicker' );
      // wp_enqueue_script('jquery-ui-tabs');
    }

    public function addStyle()
    {
      //var_dump(plugins_url()); -> http://template1.wpdemo.app/wp-content/plugins ->a hrefs
      //var_dump(__DIR__);-> /home/www/wpdemo/wp-content/plugins/wp-test-plugin/content
      wp_enqueue_style( 'bootstrap-css',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
     // 加载wordpress的jquery-ui-css 凡是涉及到样式以　ui-这样形式开头的都是调用这里的样式
      wp_enqueue_style('jquery-ui-css','/wp-content/plugins/wordpress-admin-style/inc/../css/jquery-ui-fresh.css');
    }

    public function showPageHtml()
    {
      include(__DIR__.'/html/submenutest2Html.php');
    }

    //Enqueue date picker UI from WP core:
    public function enqueue_scripts( $hook_suffix )
    {
      $screen = get_current_screen();

      if ( $screen->id == $hook_suffix ) {
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script('jquery-ui-tabs');
      }

    }

  }

  $subMenuTest2 = new SubMenuTest2;