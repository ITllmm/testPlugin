<?php

    if (!class_exists('WP_List_Table')) {
        include(ABSPATH.'/wp-admin/includes/class-wp-list-table.php');
    }

    class SalesmanTableList extends  WP_List_Table
    {
        protected $per_page;
        public function __construct()
        {
            $this->per_page = 4; //set pagenum
             parent::__construct(array(
                'singular' => 'salesmanTable',     // Singular name of the listed records.
                'plural'   => 'salesmanTable',    // Plural name of the listed records.
                'ajax'     => true,       // Does this table support ajax?
            ));
        }

        //The definition of the header column field
        public function get_columns()
        {
            return [
            //If you don't want to display the checkbox in the title you simply set the value to an empty string
                'cb' => "<input type='checkbox'>", //need function 'column_cb'
                'id' => 'Id',
                'name' => 'Name',
                'sex' => 'Sex',
                'date' => 'Date'
            ];
        }

        // Handles the default column output.
        public function  column_default($item, $column_name )
        {
            switch($column_name) {
                case 'id':
                    return $item['id'];
                case 'name':
                    return $item['name'];
                case 'sex':
                    return $item['sex'];
                case 'date':
                    return $item['date'];
                default:
                    break;
            }
        }

        //Prepares the list of items for displaying.
        public function prepare_items()
        {
            //1.set table header
            $columns  = $this->get_columns();
            $hidden   = array();//hidden table field
            $sortable = $this->get_sortable_columns();
            $this->_column_headers = array( $columns, $hidden, $sortable );

            //2.deal with actions

            //3.fetch data and set this->items
            $items = self::get_customers($this->per_page,$this->get_pagenum());
            $this->items = $items['data'];

            //4.set pagination info
            $total_items = $items['total'];
            $per_page = $this->per_page;
            $total_pages = ceil( $total_items / $per_page );
            $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page' => $per_page,
                'total_pages' => $total_pages
            ));
        }

        //Retrieve customer’s data from the database
        public static function get_customers($per,$page_num)
        {
            global $wpdb;
            $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
            $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'id';

            $sql = 'select * from `salesmantable`  order by '.$orderby.' '.$order ;
            $sql .= " LIMIT ".$per;
            $sql .= " OFFSET ".($page_num - 1) * $per;

            $data = $wpdb->get_results($sql, 'ARRAY_A');

             $totalSql = $wpdb->prepare("select  count(*)  from `salesmantable` where %s",1);
             $total = $wpdb->get_var($totalSql);
            return ['data' => $data, 'total' => $total];
        }

        //Render the bulk edit checkbox
        public function column_cb($item)
        {
            return sprintf("<input type='checkbox' name='%s[]' value='%s' />", $this->_args['singular'],$item['id']);
        }

        //Text displayed when no customer data is available
        public function no_items()
        {
             _e( 'No salesman items found.' );
        }

        public function get_sortable_columns()
        {
            return [
                'date' => array('date',true)//如果为true，则假定该列按升序排列，如果为false，则该列假定为下降或无序。
            ];
        }

        public function get_bulk_actions()
        {
            $actions = ['bulk-delete' => 'Delete'];
            return $actions;
        }

        public function column_id($item) //column_fieldname(不区分大小写) <??怎么执行这个函数>
        {
            $actions = array(
                'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>',$REQUEST['page'],'edit',$item['id']),
                'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>',$REQUEST['page'],'delete',$item['id'])
            );

           return sprintf('%s %s', $item['id'], $this->row_actions($actions) );
        }


    }