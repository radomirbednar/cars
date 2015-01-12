<table>
    <tbody>
        <tr>
            <td>
                <label for="minimun_driver_age"><?php _e('Minimum driver age:', $this->car_share) ?></label>
            </td>
            <td>
                <input id="minimun_driver_age" class="small-input" type="number" name="_minimum_driver_age" value="<?php echo empty($minimum_driver_age) ? 18 : (int) $minimum_driver_age ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="minimum_age_fee"><?php _e('Minimum age fee:', $this->car_share) ?></label>
            </td>
            <td>
                <input id="minimum_age_fee" class="small-input" type="number" step="0.01" name="_minimum_age_fee" value="<?php echo empty($minimum_age_fee) ? 0 :  floatval($minimum_age_fee) ?>">
            </td>
        </tr>
    </tbody>
</table>