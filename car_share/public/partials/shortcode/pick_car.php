<?php

global $wpdb;

$sc_options = get_option('sc-pages');
$extras_car_url = isset($sc_options['extras']) ? get_page_link($sc_options['extras']) : '';

$sql = "
    SELECT
        *
    FROM
        wp_posts 
    WHERE
        post_type = 'sc-car'
    AND
        post_status = 'publish'        
";

$cars = $wpdb->get_results($sql);
?>


<?php if (!empty($cars)): ?>
    <form action="<?php echo $extras_car_url ?>" method="post">
        <?php foreach ($cars as $car): ?> 
        <div>
            <label>                
                <input type="radio" name="car" value="<?php echo $car->ID ?>">
                <?php echo get_the_title($car->ID) ?>
            </label>
        </div>     
        <?php endforeach; ?>
        
        <button type="submit" class="btn btn-default"><?php _e('Continue', $this->car_share); ?></button>
        
        <input type="hidden" name="pick_up_location" value="<?php echo esc_attr($_POST["pick_up_location"]) ?>">
        <input type="hidden" name="drop_off_location" value="<?php echo esc_attr($_POST["pick_up_location"]) ?>">
        <input type="hidden" name="car_datefrom" value="<?php echo esc_attr($_POST["car_datefrom"]) ?>">
        <input type="hidden" name="car_hoursfrom" value="<?php echo esc_attr($_POST["car_hoursfrom"]) ?>">
        <input type="hidden" name="car_dateto" value="<?php echo esc_attr($_POST["car_dateto"]) ?>">
        <input type="hidden" name="car_hoursto" value="<?php echo esc_attr($_POST["car_hoursto"]) ?>">
        <input type="hidden" name="car_category" value="<?php echo esc_attr($_POST["car_category"]) ?>">
        
    </form>    
<?php else: ?>
    <p><?php _e('Sorry, there is no car meeting your requirements.', $this->car_share); ?></p>
<?php endif; ?>



