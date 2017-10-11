<?php
    namespace Admin\AddSaler;
    use \Exception;

    class AddSalersClass
    {
        public function setBlogSaler($salerData)
        {
            $saler = get_user_by('email',$salerData['email']); //通过新的email来获取salesman信息

            //得到新的user_id或当前存在的user_id
            if ( empty($saler) ) { //add new user

                if ( username_exists( $salerData['name'] ) )
                {
                     throw new Exception("user login name already existed.");
                }
                if( strlen($salerData['name']) < 4 )
                { //用户名字符不能少于
                    throw new Exception("user login name may not be shorter than 4.");
                }
                if( !is_email( $salerData['email'] ) )
                {
                    throw new Exception("invalid email.");
                }

                $random_password = wp_generate_password($length=8, $include_standard_special_chars=false);
                $user_id = wp_create_user($salerData['name'], $random_password, $salerData['email']);

            } else { // replace exsit user
                $user_id = $saler->ID;
            }

            //template 站点分配用户
            if( !empty( $salerData['oldEamil'])) { //替换用户

                $oldsaler = get_user_by('email',$salerData['oldEamil']);

                $blogs =  getBlogInfo($oldsaler->ID,'salesman');
                foreach ($blogs as $blog) {
                    remove_user_from_blog($oldsaler->ID, $blog->userblog_id );
                    add_user_to_blog( $blog->userblog_id, $user_id, 'salesman' );
                }


            } else { //新增用户

                $blog_id = get_blog_id_from_url(test_config_helper('saler_root_blog_domain'));
                add_user_to_blog( $blog_id, $user_id, 'salesman' );

            }

        }
    }