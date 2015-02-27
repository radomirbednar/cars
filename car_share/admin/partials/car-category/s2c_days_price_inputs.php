<?php
$days = get_days_of_week();
?>



<?php
if (!empty($season_id)):
    // pokud se jedna o editaci mam predvyplnene season_id
    ?>
    <input type="hidden" name="_season_to_category" value="<?php echo (int) $season_id ?>">
<?php endif; ?>

<div class="edit-new-s2c">
    <table id="session2category">
        <tbody>

            <tr>
                <td></td>
                <?php foreach ($days as $day_name => $label): ?>
                    <td><?php _e($label, $this->car_share) ?>:</td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td></td>
                <?php foreach ($days as $day_name => $label): ?>
                    <td><input type="number" step="0.01" name="_season_to_category_prices[<?php echo $day_name ?>]" class="day-price" value="<?php echo isset($category_day_prices[$day_name]) ? $category_day_prices[$day_name] : 0 ?>"></td>
                <?php endforeach; ?>
            </tr>
            <?php
            
            if (isset($s2c_discount_upon_duration[$season_id])):
                
                ksort($s2c_discount_upon_duration[$season_id]);
            
                /**
                 * 
                 */
                $input_name = '_s2c_discount_upon_duration';
                
                $row_key = 0;
                
                foreach ($s2c_discount_upon_duration[$season_id] as $days_number => $discount) {                    
                    include 'discount_upon_duration_row.php';
                    $row_key++;
                }
            endif;
            
            ?>
        </tbody>
    </table>

    <hr>

    <button id="add-season-2-category-discount" class="button button-primary alignleft" type="button"><?php _e('Add discount', $this->car_share) ?></button>
    <button id="save-season-2-category" class="button button-primary alignright" type="button"><?php _e('Save', $this->car_share) ?></button>

    <div class="clear"></div>
</div>


