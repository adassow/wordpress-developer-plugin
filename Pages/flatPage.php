<?php

require_once(__DIR__."/../flatsList.php");
require_once("page.php");

class FlatPage extends Page{

	protected $toRender = 'main';
	public function __construct(){
		parent::__construct();
		$this->id = isset($_REQUEST['flat']) ? $_REQUEST['flat'] : null;
	}

	protected function renderMain(){
		?>
		    <div class="wrap">
		    <h2>Mieszkania: <a href="/wp-admin/admin.php?page=flats&action=add" class="add-new-h2">Nowe mieszkanie</a></h2>
		<?php
		    $wp_list_table = new FlatsList();
		    $wp_list_table->prepare_items();
		    $wp_list_table->display();
	    ?></div><?php
	}


	protected function renderForm(){
		if($this->id !== null){
		    $table_name = $this->wpdb->prefix . "flat";
		    $flat = $this->wpdb->get_row("SELECT * FROM $table_name WHERE ID = ".$this->id);
		    $data = array(
		        'area' => $flat->area,
		        'rooms' => $flat->rooms,
		        'price' => $flat->price,
		        'status' => $flat->status,
		        'balcony_area' => $flat->balcony_area,
		        'company_id' => $flat->company_id,
		        'floor' => $flat->floor,
		        'project' => $flat->project,
		        'photo' => $flat->photo,
		        'project_pdf' => $flat->project_pdf,
		        'project_building' => $flat->project_building,
		        'building_id' => $flat->building_id,
		        'description' => $flat->description,
		        );
		}
	    require_once(__DIR__."/../forms/flat_form.php");
	}

	protected function delete(){
	    $table_name = $this->wpdb->prefix . "flat"; 
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
	    $table_name = $this->wpdb->prefix . "flat"; 
	    //catch error (false)
	    if($this->id != null) {
	        $this->wpdb->update( 
	            $table_name, 
	            array( 
	                'area' => $_REQUEST['area'],
			        'rooms' => $_REQUEST['rooms'],
			        'price' => $_REQUEST['price'],
			        'status' => $_REQUEST['status'],
			        'balcony_area' => $_REQUEST['balcony_area'],
			        'company_id' => $_REQUEST['company_id'],
			        'floor' => $_REQUEST['floor'],
			        'project' => $_REQUEST['project'],
			        'photo' => $_REQUEST['photo'],
			        'project_pdf' => $_REQUEST['project_pdf'],
			        'project_building' => $_REQUEST['project_building'],
			        'building_id' => $_REQUEST['building_id'],
			        'description' => $_REQUEST['description'],
	            ), 
	            array( 'id' => $this->id ), 
	            array( 
	                '%f', '%d', '%d', '%d', '%f', '%s','%d', '%s', '%s', '%s', '%s', '%d', '%s'
	            ),  
	            array( '%d' ) 
	        );
	    } else {
	        $this->wpdb->insert( 
	            $table_name, 
	            array( 
	                'area' => $_REQUEST['area'],
			        'rooms' => $_REQUEST['rooms'],
			        'price' => $_REQUEST['price'],
			        'status' => $_REQUEST['status'],
			        'balcony_area' => $_REQUEST['balcony_area'],
			        'company_id' => $_REQUEST['company_id'],
			        'floor' => $_REQUEST['floor'],
			        'project' => $_REQUEST['project'],
			        'photo' => $_REQUEST['photo'],
			        'project_pdf' => $_REQUEST['project_pdf'],
			        'project_building' => $_REQUEST['project_building'],
			        'building_id' => $_REQUEST['building_id'],
			        'description' => $_REQUEST['description'],
	            ), 
	            array( 
	                '%f', '%d', '%d', '%d', '%f', '%s','%d', '%s', '%s', '%s', '%s', '%d', '%s'
	            ) 
	        );
	    }
	}

	protected function validateForm($data){
		//TODO validate
		return [];
	}

	
}