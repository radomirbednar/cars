<label><?php _e('Service fee:', $this->car_share) ?> <input class="small-input " type="text" value="<?php echo empty($service_fee) ? 0 : esc_attr($service_fee) ?>" name="_service_fee"></label>

<?php
$options = array(
    Car_share::ONE_TIME_FEE => 'one time fee',
    Car_share::HOURLY_FEE => 'hourly fee',
    Car_share::DAILY_FEE => 'daily fee',
);
?>
<select name="_service_fee_type">
    <?php foreach ($options as $key => $label): ?>
        <option value="<?php echo $key ?>"><?php _e($label, $this->car_share) ?></option>
    <?php endforeach; ?>
</select>    

