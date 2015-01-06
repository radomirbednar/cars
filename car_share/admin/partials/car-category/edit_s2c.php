<?php

$days = get_days_of_week();

?>

<table>
    <tbody>
        <tr>
            <?php foreach ($days as $day_name => $label): ?>
                <td><?php _e($label, $this->car_share) ?>:</td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <?php foreach ($days as $day_name => $label): ?>
                <td><input type="text" name="_s2c_prices[<?php echo $day_name ?>]" class="day-price" value="<?php echo isset($season2category[$day_name]) ? $season2category[$day_name]->price : 0 ?>"></td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>

<a id="update-season2category" type="button" class="thickbox button button-primary" href="#"><?php _e('update', $this->car_share) ?></a>