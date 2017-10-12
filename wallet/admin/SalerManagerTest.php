<?php

    if( !defined('ABSPATH')){
        exit;
    }

    include_once(__DIR__.'/function/AddSalersClass.php');

    use Admin\AddSaler\AddSalersClass;

    class SalerManagerTest
    {
        protected $pageSlug;
        protected $users;
        protected $messages;

        function __construct()
        {
            $this->messages = [];
            $this->pageSlug = test_config_helper('saler_manager_test');
            add_action('network_admin_menu',array($this,'addNetAdminMenu'));
        }

        public function addNetAdminMenu()
        {
            $menu_hook = add_submenu_page(test_config_helper('net_test_slug'),'saler_manager_pagetitle','saler_manager_menutitle','publish_posts',$this->pageSlug,array($this,'showPageHtml'));

            add_action('load-'.$menu_hook,array($this,'preWork'));
            add_action('admin_print_scripts-'.$menu_hook,array($this,'addScript'));
            add_action('admin_print_styles-'.$menu_hook,array($this,'addStyle'));
            add_action('network_admin_notices',array($this,'showNotice'));
        }

        //get saler datas
        public function preWork()
        {

            if(!empty($_POST)){
                $this->handlePostRequest();
            }

            $root_blog_id = get_blog_id_from_url(test_config_helper('saler_root_blog_domain')); //get  blog_id of template

            if(empty($root_blog_id)){
                $this->messages[] = ['status' => 'error', 'message' => 'Cant find root domain, please contact the developer.'];
                return;
            }

            $arg = [
                'blog_id' => $root_blog_id,
                'role' => 'salesman',
                'orderby' => 'ID',
                'fields' => 'ID' // accoding to wp_users table fields
            ];

            $salesIds = get_users($arg); //由站点template下的角色'salesman'获取所有的站点

            $this->salers = array_map(function($id){
                return ['user' => getUserInfo($id), 'blogs' => getBlogInfo($id, 'salesman')];
            }, $salesIds);

        }

        public function handlePostRequest()
        {

            check_admin_referer('add_saler', $this->pageSlug);

            if (isset($_POST['confirm_new_saler'])) {

                $requestData = [
                    'name' => sanitize_text_field($_POST['saler_name']),
                    'email' => validate_email($_POST['saler_email']),
                    'oldEamil' => sanitize_email($_POST['old_saler_email'])
                ];

                try {

                    $addSaler = new AddSalersClass;
                    $addSaler -> setBlogSaler($requestData);
                    $this->messages[] = ['status' => 'success', 'message' => 'add sailer success.'];

                } catch (Exception $e) {

                    $this->messages[] = ['status' => 'error', 'message' => 'add salesman failure: '. $e->getMessage()];

                }

            }

        }

        public function showPageHtml()
        {
            include_once(__DIR__.'/html/ShowSalerManageHtml.php');
        }

        public function showTabledata()
        {
            $result = '';
            foreach ($this->salers as $salers) {
                $temp = '';
                $temp .= sprintf('<td>%s</td>',$salers['user']['id']);
                $temp .= sprintf('<td>%s</td>',$salers['user']['name']);
                $temp .= sprintf('<td>%s</td>',$salers['user']['email']);
                $temp .= sprintf('<td>%s</td>',$this->outBlogInfo($salers['blogs']));
                $result .= sprintf('<tr>%s</tr>',$temp);
            }
            echo $result;
        }

        public function outBlogInfo($blogs)
        {
            $temp = '';
            foreach($blogs as $blog)
            {
                $temp.= sprintf('<div>%s</div>',$blog->blogname);
            }
            return $temp;
        }

        public function addScript()
        {
            wp_enqueue_script( 'bootstrap-js',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js", array('jquery'));
        }

        public function addStyle()
        {
            wp_enqueue_style( 'bootstrap-css',"//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
        }

        public function showNotice()
        {
            foreach($this->messages as $message)
            {
                echo sprintf('<div class="notice notice-%s"><p>%s</p></div>',$message['status'],$message['message']);
            }
        }

    }

    $salermanagertest = new SalerManagerTest;