<select name="_car_category">    
    <option value="">----</option>
    <?php if(!empty($car_categories)): 
        foreach($car_categories as $car_category):
        ?>
        <option value="<?php echo $car_category->ID ?>" <?php echo $current_car_category == $car_category->ID ? ' selected="selected" ' : '' ?>><?php _e($car_category->post_title) ?></option>
        <?php 
        endforeach;
    endif; 
    ?>
</select>    

