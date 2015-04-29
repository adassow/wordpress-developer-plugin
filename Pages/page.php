<?php
abstract class page{
 	protected $toRender = 'main';

 	protected $id = null;
	public function __construct(){
		global $wpdb;
		$this->wpdb = $wpdb;
		
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
}
