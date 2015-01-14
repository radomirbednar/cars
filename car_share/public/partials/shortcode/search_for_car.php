<?php echo $this->warning; ?>
<form name="car_share_search_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">  
    <?php $count_posts = wp_count_posts( 'sc-location' )->publish; ?>  
    <?php echo $count_posts; ?> 
    
    
    <?php if($count_posts > 1){ ?> 
    <div class="form-group">
        <label><?php _e('Pickup location:', $this->car_share) ?></label>
        <select class="form-control" name="pick_up_location"> 
            <?php
            $args = array(
                'post_type' => 'sc-location',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC'  
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
    <label for="returnlocationcheck"><?php _e('Returning to different location', $this->car_share) ?></label>
    <input type="checkbox" name="returnlocation" id="returnlocationcheck" /> 
    <div class="form-group" id="car_drop_of_location">
        <label><?php _e('Drop off location:', $this->car_share) ?></label>
        <select class="form-control" name="drop_off_location">
            <?php
            $args = array(
                'post_type' => 'sc-location',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC' 
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
    <?php } else { ?>  
        <?php
            $args = array(
                'post_type' => 'sc-location',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC' 
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    ?>
                    <input type="hidden" name="pick_up_location" value="<?php the_ID(); ?>"/> 
                    <input type="hidden" name="drop_off_location" value="<?php the_ID(); ?>"/>
     
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?> 
    <?php } ?> 
    <div class="form-group">
        <label for="car_datefrom"><?php _e('Pick-up date and time:', $this->car_share); ?></label>
        <input id="car_datefrom" class="hasdatepicker" required name="car_datefrom" value="">
        <select class="form-control" name="car_hoursfrom">
            <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?>:00 </option>
            <?php endfor ?>
        </select>
    </div>
    <div class="form-group">
        <label for="car_dateto"><?php _e('Return date and time:', $this->car_share); ?></label>
        <input id="car_dateto" class="hasdatepicker" required name="car_dateto" value="">
        <select class="form-control" name="car_hoursto">
            <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?>:00 </option>
            <?php endfor ?>
        </select>
    </div>

    <?php $options = get_option('car_plugin_options_arraykey'); ?>
    <?php if ($options['showcategory'] == 1) { ?>
        <div class="form-group">
            <label for="car_category"><?php _e('Category:', $this->car_share); ?></label>
            <select class="form-control" name="car_category">
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
    <?php } ?>
    <!-- Standard button -->
    <button type="submit" class="btn btn-default"><?php _e('SEARCH', $this->car_share); ?></button>
</form>
