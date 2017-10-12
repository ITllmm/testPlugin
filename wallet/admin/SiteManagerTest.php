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

            $sites = get_sites(array('order' => 'DESC'));//$sales = getUserInfo()

            $result = array_map(function($site) {
                $site->user = ['saler' => userWithRoleAtBlog($site->blog_id,'salesman'),'shopmanage' => userWithRoleAtBlog($site->blog_id,'shop_manager')];
                return $site;
            },$sites);

            $this->sites = $result;

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
                $temp .= sprintf("<td>%s <a href='#'>%.2f%%</a></td>",$site->user['saler']['name'],$site->user['saler']['balance']['profit']);
                $temp .= sprintf("<td>%s <a href='#'>%.2f%%</a></td>",$site->user['shopmanage']['name'],$site->user['shopmanage']['balance']['profit']);
                $temp .= sprintf("<td><a href='#' class='text-%s'>%s</a></td>",$site->public == 1?'info':'danger',$site->public == 1?'valid':'invalid');
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