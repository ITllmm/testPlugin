<?php

    require_once __DIR__.'/SalesmanTableList.php';

    class SalesmanTable
    {
        public function __construct()
        {
            $this->pageSlug = test_config_helper('net_salesmantable_slug');
            add_action('network_admin_menu',array($this,'addNetAdminMenu'));
        }

        public function addNetAdminMenu()
        {

            // if ( ! empty($_REQUEST['_wp_http_referer']) ) { //url params
            //          wp_redirect( remove_query_arg( array('_wp_http_referer', '_wpnonce'), wp_unslash($_SERVER['REQUEST_URI']) ) );
            //          exit;
            // }

            $menu_hook = add_submenu_page(test_config_helper('net_salesmantable_slug'),'saletable_pagetitle','saletable_menutitle','publish_posts',$this->pageSlug,array($this,'salesman_table_interface'));
        }

        public function salesman_table_interface()
        {
             $wp_list_table = new SalesmanTableList;

             ?>
            <form id="posts-filter"  action="<?php  echo admin_url('/network/admin.php?page='.$this->pageSlug);?>" method="get" > <!--自动生成_wpnonce-->
            <input type="hidden" name="page" value="<?php echo $this->pageSlug; ?>">
             <?php
             $wp_list_table ->prepare_items();
             $wp_list_table->search_box('search', 'id');
             $wp_list_table->display();
             ?>
              </form>
              <?php
        }
    }

    $salesmanTable = new SalesmanTable;