<?php
    //http://wpengineer.com/2426/wp_list_table-a-step-by-step-guide/

    require_once __DIR__.'/SalesmanTableList.php';

    class SalesmanTable
    {
        public function __construct()
        {
            $this->pageSlug = test_config_helper('net_test_slug');
            add_action('network_admin_menu',array($this,'addNetAdminMenu'));
        }

        public function addNetAdminMenu()
        {
            $menu_hook = add_submenu_page(test_config_helper('net_test_slug'),'saler_table_pagetitle','saler_table_menutitle','publish_posts',$this->pageSlug,array($this,'salesman_table_interface'));
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