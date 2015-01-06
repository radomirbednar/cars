



<?php if (!empty($cars)): ?> 

    <div>
        <?php _e('1. Search for a car', $this->car_share); ?>
        <?php _e('2. Pick a car', $this->car_share); ?>
        <?php _e('3. Pick a car', $this->car_share); ?>
    </div>


    <form action="<?php echo $extras_car_url ?>" method="post">
        
        
        <?php foreach ($cars as $car): ?>

        <div class="col-md-12"> 
            
            <h2><?php the_title() ?></h2> 
            
            <?php 
              $post_thumbnail =  get_the_post_thumbnail($car->ID,'thumbnail'); 
            ?> 
 
            <?php  
            
            //predefinovane informace k autu 
             $number_of_seats = get_post_meta($car->ID, '_number_of_seats', true);
             $number_of_doors = get_post_meta($car->ID, '_number_of_doors', true);
             $number_of_suitcases = get_post_meta($car->ID, '_number_of_suitcases', true);
             $transmission = get_post_meta($car->ID, '_transmission', true); 
             
             
             $number_of_seats = esc_attr($number_of_seats);
             $number_of_doors = esc_attr($number_of_doors);
             $number_of_suitcases = esc_attr($number_of_suitcases);
             $transmission = esc_attr($transmission); 
           
            //predefinovane informace k autu 
            ?> 
            
            
             <label>                     
                <input type="radio" name="car" value="<?php echo $car->ID ?>">
             </label> 
            

            <?php echo $post_thumbnail; ?>  
            
            <h2><?php echo get_the_title($car->ID) ?></h2>  
            
                <table> 
                <?php if(!empty ($number_of_seats)) { ?>  
                    <tr>
                        <th><?php _e('Seats', $this->car_share); ?></th> 
                        <td><?php echo $number_of_seats; ?></td>
                    </tr>        
                <?php }; ?> 
                <?php if(!empty ($number_of_doors)) { ?>                  
                    <tr>
                        <th><?php _e('Doors', $this->car_share); ?></th>
                        
                        <td><?php echo $number_of_doors; ?></td>
                    </tr>       
                <?php }; ?>        
                <?php if(!empty ($number_of_suitcases)) { ?>  
                    <tr>
                        <th><?php _e('Bags', $this->car_share); ?></th> 
                        <td><?php echo $number_of_suitcases; ?></td>
                    </tr>        
                <?php }; ?>     
                 <?php if(!empty ($transmission)) { ?>  
                    <tr>
                        <th><?php _e('Transmission', $this->car_share); ?></th> 
                       <td><?php echo $transmission; ?></td>
                    </tr>        
                <?php }; ?>  
                </table>     
                
                
                
        </div>   
        
        <?php endforeach; ?>
        
        <button type="submit" class="btn btn-default"><?php _e('Continue', $this->car_share); ?></button>              
    </form>    


<?php else: ?>
    <p><?php _e('Sorry, there is no car meeting your requirements.', $this->car_share); ?></p>
<?php endif; ?>



