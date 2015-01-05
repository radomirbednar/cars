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

        $service_fee = get_post_meta(get_the_ID(), '_service_fee', true);
        $_per_service = get_post_meta(get_the_ID(), '_per_service', true);
        $_service_quantity_box = get_post_meta(get_the_ID(), '_service_quantity_box', true);
        ?>

            
        <h2><?php the_title() ?></h2>
        
            <?php
            if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
                the_post_thumbnail('thumbnail');
            }
            ?> 
    
            <?php
            // check if the custom field has a value
            if (!empty($service_fee)) {
                echo $service_fee;
            }
            ?> 
            <?php
            // check if the custom field has a value
            if (!empty($_per_service)) {
                $per_service = array();                   
            }
            ?>

            <?php
            // check if the custom field has a value
            if (!empty($_service_quantity_box)) {
 
                echo '<input type="checkbox"  name="service[]" value="'. get_the_ID() .'">';
                    
           
            }
            ?>
    
            <br>

            <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?> 
    <button type="submit" class="btn btn-default"><?php _e('Continue', $this->car_share); ?></button>
    <input type="hidden" name="car" value="<?php echo isset($_POST["car"]) ? esc_attr($_POST["car"]) : '' ?>">
    <input type="hidden" name="pick_up_location" value="<?php echo isset($_POST["pick_up_location"]) ? esc_attr($_POST["pick_up_location"]) : '' ?>">
    <input type="hidden" name="drop_off_location" value="<?php echo isset($_POST["pick_up_location"]) ? esc_attr($_POST["pick_up_location"]) : '' ?>">
    <input type="hidden" name="car_datefrom" value="<?php echo isset($_POST["car_datefrom"]) ? esc_attr($_POST["car_datefrom"]) : '' ?>">
    <input type="hidden" name="car_hoursfrom" value="<?php echo isset($_POST["car_hoursfrom"]) ? esc_attr($_POST["car_hoursfrom"]) : '' ?>">
    <input type="hidden" name="car_dateto" value="<?php echo isset($_POST["car_dateto"]) ? esc_attr($_POST["car_dateto"]) : '' ?>">
    <input type="hidden" name="car_hoursto" value="<?php echo isset($_POST["car_hoursto"]) ? esc_attr($_POST["car_hoursto"]) : '' ?>">
    <input type="hidden" name="car_category" value="<?php echo isset($_POST["car_category"]) ? esc_attr($_POST["car_category"]) : '' ?>">
</form>

