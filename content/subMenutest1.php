<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    class SubMenuTest1
    {
        function __construct()
        {
            $this->messages = [];
            $this->pageSlug = test_config_helper('admin_test_slug');
            add_action( 'admin_menu',   array($this, 'addAdminMenu') );
            add_action ('wp_head',array($this,'head')); //set theme head
            add_action('wp_footer',array($this,'footer'));//set theme footer
            add_action('admin_notices' , array($this, 'showPageNotice'));
        }

        public function addAdminMenu()
        {
            $menu_hook = add_submenu_page( test_config_helper('admin_test_slug'),'sub1_pagetitle','sub1_menutitle','publish_posts', $this->pageSlug,array($this,'showPageHtml'));

            add_action('load-'.$menu_hook,array($this,'preWork'));
         }

        public function preWork()
        {
            if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->pageSlug) {
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == $this->pageSlug) {
                    $this->handlePost();
                }
            }
        }

        public function handlePost()
        {

            if (isset($_POST['my-menu-test1-submit'])) {
                check_admin_referer( 'add-noncefield', '_wpnonce_add-noncefield' );
                if (isset($_POST['my-menu-test1-input1']) && ($_POST['my-menu-test1-input1'])) {
                    update_option('testdata1',absint($_POST['my-menu-test1-input1']));
                }
                if (isset($_POST['my-menu-test1-input2']) && ($_POST['my-menu-test1-input2'])) {
                    update_option('testdata2',sanitize_text_field($_POST['my-menu-test1-input2']));
                }
            }

        }

        public function showPageHtml()
        {
            $testdata1 = absint(get_option('testdata1'));
            $testdata2 = sanitize_text_field(get_option('testdata2'));
            include(__DIR__.'/html/subMenutestHtml.php');
        }

        public function head()
        {
            $id = get_option('testdata1');
            printf('<script async src="https://www.googletagmanager1.com/gtag1/js?id=%s"></script>', $id);
        }

        public function footer()
        {
        }

        public function showPageNotice()
        {
            foreach ($this->messages as $message) {
                 sprintf('<div class="notice"><p class="text-%s">%s<p></div>', $message['status'], $message['message']);
            }
        }
    }

    $subMenuTest1 = new SubMenuTest1;