<?php
$days = get_days_of_week();
?>
<!--<form id="save-session-to-category" class="update-season2category" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">-->
    <!--<input type="hidden" name="action" value="add_season_to_category">-->
    <input type="hidden" name="_car_category_id" value="<?php echo (int) $post_id ?>">
    <input type="hidden" name="_season_to_category" value="<?php echo (int) $season_id ?>">
    <table>
        <tbody>
            <tr>
<?php foreach ($days as $day_name => $label): ?>
                    <td><?php _e($label, $this->car_share) ?>:</td>
                <?php endforeach; ?>
            </tr>

            <tr>
<?php foreach ($days as $day_name => $label): ?>
                    <td><input type="number" step="0.01" name="_season_to_category_prices[<?php echo $day_name ?>]" class="day-price" value="<?php echo isset($season2category[$day_name]) ? $season2category[$day_name] : 0 ?>"></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

    <button id="update-season2category" type="submit" class="thickbox button button-primary"><?php _e('Update', $this->car_share) ?></button>
<!--</form>-->

