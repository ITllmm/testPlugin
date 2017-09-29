<?php

class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->messages = [];
        $this->pageSlug = test_config_helper('create_option_slug');
        add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action('admin_notices' , array($this, 'showPageNotice'));
    }

    /**
     * Add options page
     */
    public function addAdminMenu()
    {
        $menu_hook = add_submenu_page(
            test_config_helper('test1_sulg'),
            'create_option_page',
            'create_option_menu',
            'publish_posts',
            $this->pageSlug,array($this,'create_admin_page'));
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>My Create Option Page</h1>
             <form action='options.php' method="post"><!--wp-admin/option.php: 'check_admin_referer' in opsition 157-->
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' ); //Output nonce, action, and option_page fields for a settings page.
                do_settings_sections( 'my-setting-admin' ); //Prints out all settings sections added to a particular settings page
                submit_button(); //Echoes a submit button, with provided text and appropriate class
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting( //Register a setting and its data.
            'my_option_group', // Option group (与settings_fields的命名一直)
            'my_option_name', // Option name (数据库表wp_option添加新的字段'my_option_name')
            array( $this, 'sanitize' )// Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            null, //  My Custom Settings Title ->heading for the section
            null, // Callback  print_section_info ->between heading and fields
            'my-setting-admin' // Page
        );

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'title',
            'Title',
            array( $this, 'title_callback' ),
            'my-setting-admin',
            'setting_section_id'
        );

        add_settings_field(
            'name',
            'Name',
            array( $this, 'name_callback' ),
            'my-setting-admin',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ))
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        if( isset( $input['name'] ) )
            $new_input['name'] = sanitize_text_field( $input['name'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }

    public function name_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[name]" value="%s" />',
            isset( $this->options['name'] ) ? esc_attr( $this->options['name']) : ''
        );
    }

    //显示notic信息
    public function showPageNotice()
    {
        foreach ($this->messages  as $message){
            if ($message['status'] == 'success'){
            echo sprintf("<div class='notice notice-success'><p><strong>%s</strong></p></div>",$message['message']);
            }
            else {
            echo sprintf("<div class='notice notice-warning'><p><strong>%s</strong></p></div>",$message['message']);
            }
        }
    }

}

if( is_admin() )
    $my_settings_page = new MySettingsPage();