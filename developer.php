<?php
/**
 * Plugin Name: Developer
 * Plugin URI: https://github.com/adassow/wordpress-developer-plugin
 * Description: Plugin for building developer company.
 * Version: 0.1
 * Author: Adam Sowiński
 * Author URI: https://github.com/adassow
 * License: GPL2
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

register_activation_hook( __FILE__, 'jal_install' );

if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

require_once("investments.php");
require_once("Pages/buildingPage.php");
require_once("Pages/flatPage.php");

if( is_admin() ){
    add_action( 'admin_menu', 'prepare_menu');
    add_action('admin_print_scripts','add_scripts');
    add_action('admin_print_styles', 'add_styles');
}

function add_scripts(){
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('developer', WP_PLUGIN_URL.'/developer/my-script.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('developer');
}
function add_styles(){
    wp_enqueue_style('thickbox');
}

function prepare_menu()
{
    //add_menu_page( 'Etapy budowy', 'Etapy budowy', 'manage_options', 'building' , 'building_page');
    add_submenu_page('edit.php?post_type=portfolio', 'Etapy budowy', 'Etapy budowy', 'manage_options', 'building', 'building_page' );
    add_submenu_page('edit.php?post_type=portfolio', 'Mieszkania', 'Mieszkania', 'manage_options', 'flats', 'flat_page' );
}
add_action('admin_print_scripts','add_scripts');
add_action('admin_print_styles', 'add_styles');

function flat_page()
{
    $buildingPage = new FlatPage();

    $buildingPage->doAction($_REQUEST['action']);
    $buildingPage->render();
}


function building_page()
{
    $buildingPage = new BuildingPage();


    $buildingPage->doAction($_REQUEST['action']);
    $buildingPage->render();
}


function jal_install () {
    global $wpdb;

    $table_name = $wpdb->prefix . "buildings"; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        investment_id mediumint(9) NOT NULL,
        finish_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        description text NOT NULL,
        state int DEFAULT 0 NOT NULL,
        storey int DEFAULT 0 NOT NULL,
        UNIQUE KEY id (id)
    )  $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function dict($type, $value) {
    $data = array(
        "status" => array(
                "1" => "wolne",
                "2" => "zarezerwowane",
                "3" => "sprzedane",
        ),
        "state" => array(
                "1" => "pozwolenie na budowę",
                "2" => "stan \"0\"",
                "3" => "stan surowy otwarty",
                "4" => "stan surowy zamknięty",
                "5" => "stan surowy zamknięty z instalacjami",
                "6" => "gotowe do oddania",
        ),
    );
    return $data[$type][$value];
}

