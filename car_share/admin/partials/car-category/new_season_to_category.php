<?php
$days = get_days_of_week();


?>
<div id="modal-season2category" style="display: none;">
    <form id="save-session-to-category" class="update-season2category" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
        <input type="hidden" name="action" value="add_season_to_category">    
        <input type="hidden" name="_car_category_id" value="<?php echo (int) $post->ID ?>">    
        <select name="_season_to_category">
            <?php foreach ($seasons as $season): ?>
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
        <input type="submit" class="button button-primary" value="<?php _e('Save', $this->car_share) ?>">
        <div id="message-place" class="alignleft green"></div>    
    </form>
</div>

