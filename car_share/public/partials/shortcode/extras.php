<?php

$sc_options = get_option('sc-pages');
$extras_car_url = isset($sc_options['checkout']) ? get_page_link($sc_options['checkout']) : '';

?>
<form action="<?php echo $extras_car_url ?>" method="post">  
            <?php
            $args = array(
                'post_type' => 'sc-service',
                'post_status' => 'publish'
            ); 
            $query = new WP_Query($args);

            
            
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
            ?>
            <label>
                <input type="checkbox"  name="service[]" value="<?php the_ID()?>">
                <?php the_title() ?>
            </label>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
    
        <button type="submit" class="btn btn-default"><?php _e('Continue', $this->car_share); ?></button> 
        <input type="hidden" name="car" value="<?php echo isset($_POST["car"]) ? esc_attr($_POST["car"]) : '' ?>">
        <input type="hidden" name="pick_up_location" value="<?php echo isset($_POST["pick_up_location"]) ? esc_attr($_POST["pick_up_location"]) : '' ?>">
        <input type="hidden" name="drop_off_location" value="<?php echo isset($_POST["pick_up_location"]) ?  esc_attr($_POST["pick_up_location"]) : '' ?>">
        <input type="hidden" name="car_datefrom" value="<?php echo isset($_POST["car_datefrom"]) ?  esc_attr($_POST["car_datefrom"]) : '' ?>">
        <input type="hidden" name="car_hoursfrom" value="<?php echo isset($_POST["car_hoursfrom"]) ?  esc_attr($_POST["car_hoursfrom"]) : '' ?>">
        <input type="hidden" name="car_dateto" value="<?php echo isset($_POST["car_dateto"]) ?  esc_attr($_POST["car_dateto"]) : '' ?>">
        <input type="hidden" name="car_hoursto" value="<?php echo isset($_POST["car_hoursto"]) ?  esc_attr($_POST["car_hoursto"]) : '' ?>">
        <input type="hidden" name="car_category" value="<?php echo isset($_POST["car_category"]) ?  esc_attr($_POST["car_category"]) : '' ?>">
</form>    

