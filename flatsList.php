 <?php
class FlatsList extends WP_List_Table {
 
     function __construct(){
         global $status, $page;
                
         //Set parent defaults
         parent::__construct( array(
             'singular'  => 'Mieszkanie',     //singular name of the listed records
             'plural'    => 'Mieszkania',    //plural name of the listed records
             'ajax'      => false        //does this table support ajax?
         ) );
        
     }
 
     function column_default($item, $column_name){
     	if($column_name == 'status')
     		return dict($column_name, $item->$column_name);
        return $item->$column_name;
     }

     function column_cb($item){
         return sprintf(
             '<input type="checkbox" name="%1$s[]" value="%2$s" />',
             $this->_args['singular'],
             $item->id
         );
     }
 
     function column_company_id($item){
        
         //Build row actions
         $actions = array(
             'edit'      => sprintf('<a href="?post_type=portfolio&page=%s&action=%s&flat=%s">Edit</a>',$_REQUEST['page'],'edit',$item->id),
             'delete'    => sprintf('<a href="?post_type=portfolio&page=%s&action=%s&flat=%s">Delete</a>',$_REQUEST['page'],'delete',$item->id),
         );
        
         //Return the title contents
         return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
             /*$1%s*/ $item->company_id,
             /*$2%s*/ $item->id,
             /*$3%s*/ $this->row_actions($actions)
         );
     }
 
     function get_columns(){
         $columns = array(
             'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
             'company_id'     => 'Nr',
             'description'    => 'Opis',
             'status'  => 'Status'
         );
         return $columns;
     }
 
     function get_sortable_columns() {
         $sortable_columns = array(
             'name'     => array('name',false),     //true means it's already sorted
             'description'    => array('description',false),
             'state'  => array('state',false)
         );
         return $sortable_columns;
     }
 
 
     function get_bulk_actions() {
         $actions = array(
             'delete'    => 'Delete'
         );
         return $actions;
     }
 
     function process_bulk_action() {
        
         //Detect when a bulk action is being triggered...
         // if( 'delete'===$this->current_action() ) {
         //     wp_die('Items deleted (or they would be if we had items to delete)!');
         // }
        
     }
 
     function prepare_items() {
         global $wpdb; //This is used only if making any database queries
 
         $columns = $this->get_columns();
         $hidden = array();
         $sortable = $this->get_sortable_columns();
        
         $this->_column_headers = array($columns, $hidden, $sortable);
        
         $this->process_bulk_action();
        
         $query = "SELECT * FROM ".$wpdb->prefix . "flat";

       /* -- Ordering parameters -- */
           //Parameters that are going to be used to order the result
           $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
           $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
           if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }

       /* -- Pagination parameters -- */
            //Number of elements in your table?
            $totalitems = $wpdb->query($query); //return the total number of affected rows
            //How many to display per page?
            $perpage = 5;
            //Which page is this?
            $paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
            //Page Number
            if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; }
            //How many pages do we have in total?
            $totalpages = ceil($totalitems/$perpage);
            //adjust the query to take pagination into account
           if(!empty($paged) && !empty($perpage)){
              $offset=($paged-1)*$perpage;
             $query.=' LIMIT '.(int)$offset.','.(int)$perpage;
           }

       /* -- Register the pagination -- */
          $this->set_pagination_args( array(
             "total_items" => $totalitems,
             "total_pages" => $totalpages,
             "per_page" => $perpage,
          ) );
          //The pagination links are automatically built according to those parameters

       /* -- Register the Columns -- */
          $columns = $this->get_columns();
          $hidden = array();
          $sortable = $this->get_sortable_columns();
         
         
          $this->_column_headers = array($columns, $hidden, $sortable);

       /* -- Fetch the items -- */
          $this->items = $wpdb->get_results($query);


         $data = $wpdb->get_results($query);

         $current_page = $this->get_pagenum();
        
        

         $this->items = $data;
        
        
         /**
          * REQUIRED. We also have to register our pagination options & calculations.
          */
         $this->set_pagination_args( array(
             'total_items' => $totalitems,                  //WE have to calculate the total number of items
             'per_page'    => $perpage,                     //WE have to determine how many items to show on a page
             'total_pages' => ceil($totalitems/$perpage)   //WE have to calculate the total number of pages
         ) );
     }
 
}