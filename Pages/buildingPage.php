<?php

require_once(__DIR__."/../buildingList.php");

class BuildingPage{

	protected $toRender = 'main';
	public function __construct(){
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->id = isset($_REQUEST['budynek']) ? $_REQUEST['budynek'] : null;
	}
	public function doAction($action){
		switch ($action) {
	        case 'edit':
	        case 'add':
	            $this->toRender  = 'form';
	            break;
	        case 'save':	        	     
	            $this->save();	        	            
	            break;
	        case 'delete':
	            $this->delete();
	            $this->toRender  = 'main';
	            break;
	        default:
	            $this->toRender  = 'main';
	            break;
	    }
	}
	public function render(){
		switch ($this->toRender) {
			case 'main':
				$this->renderMain();
				break;
			case 'form':
				$this->renderForm();
				break;
			default:
				$this->renderMain();
				break;
		}
	}

	protected function renderMain(){
		?>
		    <div class="wrap">
		    <h2>Etapy budowy: <a href="/wp-admin/admin.php?page=building&action=add" class="add-new-h2">Nowy Etap</a></h2>
		<?php
		    $wp_list_table = new BuildingsList();
		    $wp_list_table->prepare_items();
		    $wp_list_table->display();
	    ?></div><?php
	}
	protected function renderForm(){
		if($this->id !== null){
		    $table_name = $this->wpdb->prefix . "buildings";
		    $building = $this->wpdb->get_row("SELECT * FROM $table_name WHERE ID = ".$this->id);
		    $data = array(
		        'name' => $building->name,
		        'investment_id' => $building->investment_id,
		        'storey' => $building->storey,
		        'finish_date' => $building->finish_date,
		        'state' => $building->state,
		        'description' => $building->description,
		        );
		}
	    require_once(__DIR__."/../forms/building_form.php");
	}

	protected function delete(){
	    $table_name = $this->wpdb->prefix . "buildings"; 
	    $this->wpdb->delete( $table_name, array( 'ID' => $id ) );
	}

	protected function save(){
		$validateError = $this->validateForm($_REQUEST);
        if(empty($validateError)){
            $this->saveDb();
            $this->toRender  = 'main';
        } else {
            $this->toRender  = 'form';
        }
	}

	protected function saveDb(){
	    $table_name = $this->wpdb->prefix . "buildings"; 
	    //catch error (false)
	    if($this->id != null) {
	        $this->wpdb->update( 
	            $table_name, 
	            array( 
	                'name' => $_REQUEST["name"], 
	                'investment_id' => $_REQUEST["investment_id"], 
	                'storey' => $_REQUEST["storey"],
	                'finish_date' => $_REQUEST["finish_date"],
	                'state' => $_REQUEST["state"],
	                'description' => $_REQUEST["description"],
	            ), 
	            array( 'id' => $this->id ), 
	            array( 
	                '%s', '%d', '%d', '%s', '%d', '%s',
	            ),  
	            array( '%d' ) 
	        );
	    } else {
	        $this->wpdb->insert( 
	            $table_name, 
	            array( 
	                'name' => $_REQUEST["name"], 
	                'investment_id' => $_REQUEST["investment_id"], 
	                'storey' => $_REQUEST["storey"],
	                'finish_date' => $_REQUEST["finish_date"],
	                'state' => $_REQUEST["state"],
	                'description' => $_REQUEST["description"],
	            ), 
	            array( 
	                '%s', '%d', '%d', '%s', '%d', '%s',
	            ) 
	        );
	    }
	}

	protected function validateForm($data){
		//TODO validate
		return [];
	}

	public function add_scripts(){
		wp_enqueue_script('media-upload');
	    wp_enqueue_script('thickbox');
	    wp_register_script('developer', WP_PLUGIN_URL.'/developer/my-script.js', array('jquery','media-upload','thickbox'));
	    wp_enqueue_script('developer');
	}
	public function add_styles(){
		wp_enqueue_style('thickbox');
	}
}