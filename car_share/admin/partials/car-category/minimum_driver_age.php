<table>
    <tbody>
        <tr>
            <td>
                <label for="young_driver_surcharge"><?php _e('Active:', $this->car_share) ?></label>
            </td>
            <td>
                <input id="young_driver_surcharge" class="small-input" type="checkbox" name="_young_driver_surcharge" value="<?php echo empty($minimum_driver_age) ? 18 : (int) $minimum_driver_age ?>">
            </td>
        </tr>        
        <tr>
            <td>
                <label for="minimun_driver_age"><?php _e('Age:', $this->car_share) ?></label>
            </td>
            <td>
                <input id="minimun_driver_age" class="small-input" type="number" name="_minimum_driver_age" value="<?php echo empty($minimum_driver_age) ? 18 : (int) $minimum_driver_age ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="minimum_age_fee"><?php _e('Fee:', $this->car_share) ?></label>
            </td>
            <td>
                <input id="minimum_age_fee" class="small-input" type="number" step="0.01" name="_surcharge_active" value="<?php echo empty($minimum_age_fee) ? 0 :  floatval($minimum_age_fee) ?>">
            </td>
        </tr>
    </tbody>
</table>