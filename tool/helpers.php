<?php

    function test_config_helper($configname)
    {
        //dirname(__DIR__) :/home/www/wpdemo/wp-content/plugins/wp-test-plugin
        $result = include(dirname(__DIR__).'/config.php');
        return isset($result[$configname]) ? $result[$configname] : '';
    }

    //accoding to user_id  get specific userdata( format $user)
    function getUserInfo($id)
    {
        $user = get_user_by('ID',$id);

        if(empty($user)){
            return null;
        }

        $default_balance = [
            'method' => [],
            'profit' => '0.00',
            'amount' => '0.00',
            'role' => '',
        ];

        $default_balance_frozen = [
            'type' => 'withdraw',
            'status' => '',
            'date' => '',
            'balance' => '',
            'payment' => [],
            'amount' => '0.00',
        ];

        $data = [
            'id' => $user->data->ID,
            'email' => $user->data->user_email,
            'name' => $user->data->display_name,
            'balance' => (!empty($balance = get_user_meta($id, 'foru_balance', true)) && is_array($balance)) ? $balance : [],
            'balance_frozen' => (!empty($balance = get_user_meta($id, 'foru_balance_frozen', true)) && is_array($balance)) ? $balance : [],
            'balance_record' => (!empty($balance = get_user_meta($id, 'foru_balance_record', true)) && is_array($balance) && $showRecord)? $balance : [],
        ];

        $data['balance'] = array_merge($default_balance,$data['balance']);
        $data['balance_frozen'] = array_merge($default_balance_frozen, $data['balance_frozen']);

        return $data;
    }

    //accoding to role  and user_id to get specific userBlogs
    function getBlogInfo($id,$role)
    {
        $allBlogs = get_blogs_of_user($id);

        return array_map(function($blog)use($id,$role){
            if(userRoleAtBlog($id,$blog->userblog_id,$role))
            return $blog;
        },$allBlogs);

    }

    //判断用户的当前角色是否在该站点下
    function userRoleAtBlog($userId,$blogId,$userRole)
    {
        $roleUserOfBlog = new WP_User($userId,'',$blogId); //WP_User need 'roles' field
        return in_array($userRole,$roleUserOfBlog->roles);
    }

    function userWithRoleAtBlog($blogid,$role)
    {
        $arg = [
            'blog_id' => $blogid,
            'orderby' => 'ID',
            'role' => $role,
            'fields' => 'ID'
        ];

        $userIds = get_users($arg);

        return getUserInfo(reset($userIds));
    }