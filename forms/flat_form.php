<h2>Edytuj miekszanie </h2>
<div class="wrap">

<form method="post">
<table>
    <tr>
        <td><label for="company_id">Nr mieszkania</label></td></td>
        <td><input type="text" name="company_id" size="30" value="<?php echo $data['company_id']; ?>" id="company_id" /></td>
    </tr>
    <tr>
        <td><label for="floor">Piętro</label></td></td>
        <td><input type="text" name="floor" size="30" value="<?php echo $data['floor']; ?>" id="floor" /></td>
    </tr>
    <tr>
        <td><label for="rooms">Liczba pokoi</label></td></td>
        <td><input type="text" name="rooms" size="30" value="<?php echo $data['rooms']; ?>" id="rooms" /></td>
    </tr>
    <tr>
        <td><label for="area">Powierzchnia</label></td></td>
        <td><input type="text" name="area" size="30" value="<?php echo $data['area']; ?>" id="area" /></td>
    </tr>
    <tr>
        <td><label for="price">Cena</label></td></td>
        <td><input type="text" name="price" size="30" value="<?php echo $data['price']; ?>" id="price" /></td>
    </tr>
    <tr>
        <td><label for="description">Krótki opis</label></td></td>
        <td><input type="text" name="description" size="30" value="<?php echo $data['description']; ?>" id="description" /></td>
    </tr>
    <tr>
        <td><label for="balcony_area">Powierzchnia balkonu</label></td></td>
        <td><input type="text" name="balcony_area" size="30" value="<?php echo $data['balcony_area']; ?>" id="balcony_area" /></td>
    </tr>

    <tr>
        <td><label for="state">Status</label></td>
        <td>
            <select id="state" name="status">
                <option value="1" <?php selected( $data['status'], 1 ); ?>>wolne</option>
                <option value="2" <?php selected( $data['status'], 2 ); ?>>zarezerwowane</option>
                <option value="3" <?php selected( $data['status'], 3 ); ?>>sprzedane</option>
            </select>
        </td>
    </tr>
    <tr>
        <td><label for="building">Budynek</label>
        <td><select id="building" name="building_id"> 
            <?php foreach (get_buildings() as $key => $value): ?>
                <option value="<?php echo $key; ?>" <?php selected( $data['building_id'], $key ); ?>><?php echo $value; ?></option>
            <?php endforeach; ?>  
        </select></td>
    </tr>
    <tr>
        <td><label for="project">Rzut</label></td>
        <td>
            <input id="upload_project" type="text" size="36" name="project" value="<?php echo $data['project']; ?>" />
            <input class="upload_button" id="upload_project_button" type="button" value="Wczytaj obraz" />
        </td>
    </tr>
    <tr>
        <td><label for="upload_photo">Zdjęcie</label></td>
        <td>
            <input id="upload_photo" type="text" size="36" name="photo" value="<?php echo $data['photo']; ?>" />
            <input class="upload_button" id="upload_photo_button" type="button" value="Wczytaj obraz" />
        </td>
    </tr>
    <tr>
        <td><label for="upload_project_pdf">Rzut pdf</label></td>
        <td>
            <input id="upload_project_pdf" type="text" size="36" name="project_pdf" value="<?php echo $data['project_pdf']; ?>" />
            <input class="upload_button" id="upload_project_pdf_button" type="button" value="Wczytaj obraz" />
        </td>
    </tr>
    <tr>
        <td><label for="upload_project_building">Rzut piętra</label></td>
        <td>
            <input id="upload_project_building" type="text" size="36" name="project_building" value="<?php echo $data['project_building']; ?>" />
            <input class="upload_button" id="upload_project_building_button" type="button" value="Wczytaj obraz" />
        </td>
    </tr>
</table>
    <input type="hidden" name="action" value="save"/>
    <input type="submit" value="Zapisz" class="button-primary"/>
</form>
</div>
<?php
function get_buildings(){
    global $wpdb;
    $buildings;
    $query = "SELECT * FROM ".$wpdb->prefix . "buildings";
    $data = $wpdb->get_results($query);
    
    foreach ($data as $building) {
        $buildings[$building->id] = $building->name;
    }
    return $buildings;
}?>