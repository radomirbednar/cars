<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>  
<div> 
    <label>
        <?php _e('Max quantity for this service: ', $this->car_share) ?> 
        <input type="number"  value="<?php echo empty($service_quantity_box) ? 0 : esc_attr($service_quantity_box) ?>" name="_service_quantity_box">  
    </label> 
</div> 