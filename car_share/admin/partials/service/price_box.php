<label><?php _e('Service fee:', $this->car_share) ?>
  <input class="small-input " type="text" value="<?php echo empty($service_fee) ? 0 : esc_attr($service_fee) ?>" name="_service_fee">
</label>
 

 
<div class="radio">
    <label><input type="radio" name="optradioper"><?php _e('Per day', $this->car_share) ?></label>
    </div> 
    <div class="radio">
        <label><input type="radio" name="optradioper"><?php _e('Per rental', $this->car_share) ?></label>
</div> 
