<label><?php _e('Service fee:', $this->car_share) ?>
  <input class="small-input " type="text" value="<?php echo empty($service_fee) ? 0 : esc_attr($service_fee) ?>" name="_service_fee">
</label>
  
<?php    
    $values =  array(
        0    => "Per day",
        1  => "Per rental", 
    );  
foreach ($values as $key=>$value)
{       
    if($key == $per_service)
    {
        $checked = 'checked'; 
    }  
 else {     
    $checked = ''; 
    }  
?> 
<div class="radio"> 
    <label><input <?php echo $checked; ?> type="radio" name="_per_service" value="<?php echo $key; ?>"><?php _e($value, $this->car_share) ?></label> 
</div>      
<?php    
}
?>  
 
