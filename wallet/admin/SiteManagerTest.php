<?php

    class SiteManagerTest
    {
        protected $page_slug;
        protected $sites;

        public function __construct()
        {
            $this->page_slug = test_config_helper('site_manager_test');
            add_action( 'network_admin_menu', array($this,'addAdminMenu') );
        }

        public function addAdminMenu()
        {
            $menu_hook = add_submenu_page( test_config_helper('net_test_slug'), 'site_manager_pagetitle', 'site_manager_menutitle', 'publish_posts', $this->page_slug, array($this,'showPageHtml') );

            add_action('load-'.$menu_hook,array($this,'preWork'));
            add_action('admin_print_scripts-'.$menu_hook,array($this,'addScript'));
            add_action('admin_print_styles-'.$menu_hook,array($this,'addStyle'));

        }

        public function preWork()
        {

            if(!empty($_POST['action'])){
                $this->handlePostRequest();
            }

            //site:wpdemp.app  blog belong to site
           if (isset($_GET['state_nonce_url'])) {

                if(wp_verify_nonce($_GET['state_nonce_url'],'state_action_url')){

                    switch_to_blog($_GET['site']);
                    update_blog_public($_GET['value'],!$_GET['value']);
                    restore_current_blog();
                }

                  wp_redirect( network_admin_url( //order to  'url' no show nonce data
                    sprintf('admin.php?page=%s', $this->page_slug)));

           }

            $sites = get_sites(array('order' => 'DESC'));//$sales = getUserInfo()

            $result = array_map(function($site) {
                $site->user = ['saler' => userWithRoleAtBlog($site->blog_id,'salesman'),'shopmanage' => userWithRoleAtBlog($site->blog_id,'shop_manager')];
                return $site;
            },$sites);

            $this->sites = $result;

        }

        public function handlePostRequest()
        {

           check_admin_referer('set_profit_test',$this->page_slug);

            if(isset($_POST['action']) && $_POST['action'] == 'set_profit'){

                $profit = number_format(floatval($_POST['profit_value']),2);
                $user_id = substr($_POST['action_user'], 5); //user_id
                $balance  = get_user_meta($user_id, 'foru_balance');
                $balance['profit'] = $profit;
                update_user_meta( $user_id, 'foru_balance', $balance);

            }

        }

        public function showPageHtml()
        {
             include_once(__DIR__.'/html/ShowSiteManageHtml.php');
        }

        public function showTabledata()
        {
            $result = '';
            foreach ($this->sites as $site) {

                $temp = "<tr>";

                $temp .= sprintf("<td>%s</td>",$site->blog_id);

                $temp .= sprintf("<td>%s</td>",$site->domain);

                if ( !empty($site->user['saler']['name'] ) ) {
                    $temp .= sprintf("<td>%s <a href='#' id='user_%s' value=%s class='setProfit'>%.2f%%</a></td>",$site->user['saler']['name'],$site->user['saler']['id'],$site->user['saler']['balance']['profit'],$site->user['saler']['balance']['profit']);
               }
               else{
                    $temp .= '<td></td>';
               }

               if ( !empty($site->user['shopmanage']['name'] ) ) {
                    $temp .= sprintf("<td>%s <a href='#' id='user_%s' value=%s class='setProfit'>%.2f%%</a></td>",$site->user['shopmanage']['name'],$site->user['shopmanage']['id'],$site->user['shopmanage']['balance']['profit'],$site->user['shopmanage']['balance']['profit']);
               }
               else{
                    $temp .= '<td></td>';
               }

                $temp .= sprintf("<td><a href='%s' class='text-%s'>%s</a></td>",wp_nonce_url(network_admin_url(sprintf("admin.php?page=%s&value=%s&site=%s",$this->page_slug,$site->public,$site->blog_id)),'state_action_url','state_nonce_url'),$site->public == 1?'info':'danger',$site->public == 1?'valid':'invalid');

                $temp .= '</tr>';

                $result .= $temp;
            }

            echo $result;
        }

        public function addScript()
        {
            wp_enqueue_script( 'bootstrap-js',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", array('jquery'));
        }
        public function addStyle()
        {
            wp_enqueue_style( 'bootstrap-css',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
        }

    }
    $siteManagerTest = new SiteManagerTest;