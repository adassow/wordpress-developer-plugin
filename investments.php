<?php
function investments_post_type() {

    $labels = array(
        'name'                => _x( 'Inwestycje', 'Inwestycje', 'text_domain' ),
        'singular_name'       => _x( 'Inwestycja', 'Inwestycja', 'text_domain' ),
        'menu_name'           => __( 'Inwestycje', 'text_domain' ),
        'name_admin_bar'      => __( 'Inwestycja', 'text_domain' ),
        'parent_item_colon'   => __( 'Inwestycja nadrzędna:', 'text_domain' ),
        'all_items'           => __( 'Wszystkie inwestycje', 'text_domain' ),
        'add_new_item'        => __( 'Dodaj nową inwestycję', 'text_domain' ),
        'add_new'             => __( 'Nowa inwestycja', 'text_domain' ),
        'new_item'            => __( 'New Item', 'text_domain' ),
        'edit_item'           => __( 'Edytuj inwestycje', 'text_domain' ),
        'update_item'         => __( 'Zaktualizuj inwestycje', 'text_domain' ),
        'view_item'           => __( 'Podgląd inwestycji', 'text_domain' ),
        'search_items'        => __( 'Wyszukaj inwestycje', 'text_domain' ),
        'not_found'           => __( 'nie znaleziono inwestycji', 'text_domain' ),
        'not_found_in_trash'  => __( 'Brak inwestycji w koszu', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'investments', 'text_domain' ),
        'description'         => __( 'Inwestycje', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', ),
        //'taxonomies'          => array( 'category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'investments', $args );

}

// Hook into the 'init' action
//add_action( 'init', 'investments_post_type', 0 );