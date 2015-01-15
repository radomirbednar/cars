<table>
    <tbody>
        <tr>
            <td>
                <label for="young_driver_surcharge"><?php _e('Active:', $this->car_share) ?></label>
            </td>
            <td>
                <input id="young_driver_surcharge" class="small-input" type="checkbox" name="_surcharge_active" value="1" <?php echo isset($surcharge_active) && 1 == $surcharge_active ? ' checked="checked"' : '' ?>>
            </td>
        </tr>        
        <tr>
            <td>
                <label for="minimun_driver_age"><?php _e('Age:', $this->car_share) ?></label>
            </td>
            <td>
                <input id="minimun_driver_age" class="small-input" type="number" name="_surcharge_age" value="<?php echo empty($surcharge_age) ? '' : (int) $surcharge_age ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="minimum_age_fee"><?php _e('Increase price (percentage):', $this->car_share) ?></label>
            </td>
            <td>
                <input id="minimum_age_fee" class="small-input" type="number" step="0.01" name="_surcharge_fee" value="<?php echo empty($surcharge_fee) ? 0 :  floatval($surcharge_fee) ?>">
            </td>
        </tr>
    </tbody>
</table>