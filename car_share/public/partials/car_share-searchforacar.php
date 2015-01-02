<form name="car_share_search_form" action=""> 
    <div class="form-group">
        <label>Pickup location:</label> 
        <select class="form-control"> 
            <?php
            /*
             * Take me all locations 
             */ 
             $querylocations = new WP_Query( array( 'post_type' => 'location') ); ?>
            <?php if ( $querylocations->have_posts() ) : ?> 
            <?php while ( $querylocations->have_posts() ) : $querylocations->the_post(); ?>	 
                <option value="<?php the_ID(); ?>"><?php the_title(); ?></option> 
            <?php endwhile; wp_reset_postdata(); ?>
            <?php endif; ?>    
        </select>
    </div>
     
    <div class="form-group">
        
        
        
        <label for="car_datefrom"><?php _e('Pick-up date and time', $this->car_share); ?></label>
        <input id="car_datefrom" class="hasdatepicker" name="car_datefrom" />

        <select class="form-control" name="car_hoursfrom">
            <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?>:00 </option>
            <?php endfor ?>
        </select> 
    </div>
    <div class="form-group">
        <label>Return location:</label>
        <select class="form-control">    
            <?php
            /*
             * Take me all locations 
             */ 
            $querylocations = new WP_Query( array( 'post_type' => 'location') ); ?>
            <?php if ( $querylocations->have_posts() ) : ?> 
            <?php while ( $querylocations->have_posts() ) : $querylocations->the_post(); ?>	 
                <option value="<?php the_ID(); ?>"><?php the_title(); ?></option> 
            <?php endwhile; wp_reset_postdata(); ?>
            <?php endif; ?>   
        </select>
    </div>
    <div class="form-group">
        <label for="car_dateto"><?php _e('Return date and time', $this->car_share); ?></label>
        <input id="car_dateto" class="hasdatepicker" name="car_dateto" />  
        <select class="form-control" name="car_hoursto">
            <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?>:00 </option>
            <?php endfor ?>
        </select>
    </div> 
    
    
    
    <div class="form-group">
         
    
        
        
        
         
         
    </div>    
    
    
    <!-- Standard button -->
    <button type="button" class="btn btn-default"><?php _e('SEARCH', $this->car_share); ?></button> 
</form>