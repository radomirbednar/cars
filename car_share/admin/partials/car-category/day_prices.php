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
                <td><input type="text" name="_category_day_prices[<?php echo $day_name ?>]" class="day-price" value="<?php echo isset($category_day_prices[$day_name]) ? $category_day_prices[$day_name] : 0 ?>"></td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>