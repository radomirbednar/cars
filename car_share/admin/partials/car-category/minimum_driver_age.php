<label for="minimun_driver_age"><?php _e('Minimum driver age:', $this->car_share) ?>
    <input id="minimun_driver_age" class="small-input" type="number" name="_minimum_driver_age" value="<?php echo empty($minimum_driver_age) ? 18 : (int) $minimum_driver_age ?>">
</label>
<label for="minimun_age_fee">
    <input id="minimun_age_fee" class="small-input" type="number" name="_minimun_age_fee" value="<?php echo empty($minimun_age_fee) ? 0 : (int) $minimun_age_fee ?>">
</label>