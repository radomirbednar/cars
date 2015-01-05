<?php

function htmlSeasonToCategoryRow($name, $key, $day_prices, $slug) {
    $days = get_days_of_week();
}
?>
<table id="assign-season">
    <tbody>
        <?php //echo htmlSeasonToCategoryRow('', array(), $this->car_share); ?>
    </tbody>
</table>

<button id="assign-new-season" type="button" class="button button-primary"><?php _e('Add season', $this->car_share) ?></button>

<script>
    jQuery(document).ready(function ($) {

    }
</script>

<div id="new-season-to-category">    
    <?php
    $days = get_days_of_week();
    ?>
    
    <select name="_season_to_cateogory">
        <?php foreach($seasons as $season): ?>
            <option value="<?php echo $season->ID ?>"><?php _e($season->post_title, $this->car_share) ?></option>
        <?php endforeach; ?>
    </select>    
    
    <table>
        <tbody>
            <tr>
                <?php foreach ($days as $day_name => $label): ?>
                    <td><?php _e($label, $this->car_share) ?>:</td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <?php foreach ($days as $day_name => $label): ?>
                    <td><input type="text" name="_season_to_category_prices[<?php echo $day_name ?>]" class="day-price" value="<?php echo isset($category_day_prices[$day_name]) ? $category_day_prices[$day_name]->price : 0 ?>"></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>    

    <div id="message-place" class="alignleft green">

    </div>


</div>
<!-- /thickbox -->