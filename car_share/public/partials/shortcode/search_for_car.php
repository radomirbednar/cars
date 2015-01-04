<?php
$sc_options = get_option('sc-pages');
$pick_car_url = isset($sc_options['pick_car']) ? get_page_link($sc_options['pick_car']) : '';
?>

<form name="car_share_search_form" action="<?php echo $pick_car_url ?>" method="post">
    <div class="form-group">
        <label><?php _e('Pickup location:', $this->car_share) ?></label>
        <select class="form-control" name="pick_up_location">
            <option value="">-----</option>
            <?php
            $args = array(
                'post_type' => 'sc-location',
                'post_status' => 'publish'
            );
            $query = new WP_Query($args);
            ?>
            <?php
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
            ?>
                        <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
            <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            ?>
        </select>
    </div>

    <div class="form-group">
        <label><?php _e('Drop off location:', $this->car_share) ?></label>
        <select class="form-control" name="drop_off_location">
            <option value="">-----</option>
            <?php
            $args = array(
                'post_type' => 'sc-location',
                'post_status' => 'publish'
            );
            $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
            ?>
                        <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
            <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            ?>
        </select>
    </div>


    <div class="form-group">
        <label for="car_datefrom"><?php _e('Pick-up date and time', $this->car_share); ?></label>
        <input id="car_datefrom" class="hasdatepicker" name="car_datefrom" value="">
        <select class="form-control" name="car_hoursfrom">
            <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?>:00 </option>
<?php endfor ?>
        </select>
    </div>

    <div class="form-group">
        <label for="car_dateto"><?php _e('Return date and time', $this->car_share); ?></label>
        <input id="car_dateto" class="hasdatepicker" name="car_dateto" value="">
        <select class="form-control" name="car_hoursto">
            <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?>:00 </option>
<?php endfor ?>
        </select>
    </div>

    <div class="form-group">
        <label for="car_category"><?php _e('Category', $this->car_share); ?></label>
        <select class="form-control" name="car_category">
            <option value="">-----</option>
            <?php
            $args = array(
                'post_type' => 'sc-car-category',
                'post_status' => 'publish'
            );
            $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
            ?>
                        <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
            <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            ?>
        </select>
    </div>
    <!-- Standard button -->
    <button type="submit" class="btn btn-default"><?php _e('SEARCH', $this->car_share); ?></button>
</form>