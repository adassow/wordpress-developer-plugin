<h2>Edytuj etap budowy </h2>
<div class="wrap">

<form method="post">
<table>
    <tr>
        <td><label for="name">Nazwa</label></td></td>
        <td><input type="text" name="name" size="30" value="<?php echo $data['name']; ?>" id="name" spellcheck="true" autocomplete="off" /></td>
    </tr><tr>
        <td><label for="investments">Inwestycja</label>
        <td><select id="investments" name="investment_id"> 
            <?php foreach (get_investments() as $key => $value): ?>
                <option value="<?php echo $key; ?>" <?php selected( $data['investment_id'], $key ); ?>><?php echo $value; ?></option>
            <?php endforeach; ?>  
        </select></td>
    </tr><tr>
        <td><label for="storey">Liczba kondygnacji</label></td>
        <td><input type="text" name="storey" size="30" value="<?php echo $data['storey']; ?>" id="storey" spellcheck="true" autocomplete="off" /></td>
    </tr>

    <!---<tr>
        <td><label for="upload_plan">Plan budynku</label></td>
        <td>
            <input id="upload_image" type="text" size="36" name="upload_plan" value="" />
            <input id="upload_image_button" type="button" value="Wczytaj obraz" />
        </td>
    </tr>--><tr>
        <td><label for="finish_date">Data zakończenia</label></td>
        <td><input type="date" id="finish_date" name="finish_date" value="<?php echo $data['finish_date']; ?>" class="example-datepicker" /></td>
    </tr><tr>
        <td><label for="state">Etap budowy</label></td>
        <td>
            <select id="state" name="state">
                <option value="1" <?php selected( $data['state'], 1 ); ?>>pozwolenie na budowę</option>
                <option value="2" <?php selected( $data['state'], 2 ); ?>>stan "0"</option>
                <option value="3" <?php selected( $data['state'], 3 ); ?>>stan surowy otwarty</option>
                <option value="4" <?php selected( $data['state'], 4 ); ?>>stan surowy zamknięty</option>
                <option value="5" <?php selected( $data['state'], 5 ); ?>>stan surowy zamknięty z instalacjami</option>
                <option value="6" <?php selected( $data['state'], 6 ); ?>>gotowe do oddania</option>
            </select>
        </td>
    </tr>
</table>

    <?php
        wp_editor( $data['description'], 'description', array(
            '_content_editor_dfw' => $_content_editor_dfw,
            'drag_drop_upload' => true,
            'tabfocus_elements' => 'content-html,save-post',
            'editor_height' => 300,
            'tinymce' => array(
                'resize' => false,
                'wp_autoresize_on' => $_wp_editor_expand,
                'add_unload_trigger' => false,
            ),
        ));
    ?>
    <input type="hidden" name="action" value="save"/>
    <input type="submit" value="Submit" class="button-primary"/>
</form>
</div>
<?php
function get_investments(){
    $investments = array();
    $type = 'portfolio';
    $args=array(
      'post_type' => $type,
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    );
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      while ($my_query->have_posts()){
        $my_query->the_post(); 
        $investments[$my_query->post->ID] = get_the_title();
      }
    }
    wp_reset_query();
    return $investments;
}
