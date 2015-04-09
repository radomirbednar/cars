<?php $days = get_days_of_week(); ?>

<tr class="item">
    <td>
        <label><?php _e('from days:', $this->car_share) ?>
            <input type="number" class="small-input" name="<?php echo $input_name ?>[<?php echo esc_attr($row_key) ?>][days]" value="<?php echo isset($days_number) ? esc_attr($days_number) : '' ?>">
        </label>
    </td>    

    <?php foreach ($days as $day_name => $day): ?>
        <td>
            <label><?php _e($day, $this->car_share) ?>
                <input type="number" step="0.5" class="day-price" name="<?php echo $input_name ?>[<?php echo esc_attr($row_key) ?>][<?php echo esc_attr($day_name) ?>][discount]" value="<?php echo isset($discount[$day_name]['discount']) ? esc_attr($discount[$day_name]['discount']) : '' ?>">
            </label>
        </td>
    <?php endforeach; ?>  

    <td>
        <label>&nbsp; 
            <button class="remove-row" type="button"><?php _e("X", $this->car_share) ?></button>
        </label>
    </td>
</tr>








