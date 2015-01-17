<?php if (!empty($this->cars)): ?>  
    <?php if ( get_option('permalink_structure') ) { $sc_pr = '?'; }
          else { $sc_pr = '&'; }      
    ?> 
    <?php foreach ($this->cars as $car): ?>  
          <div class="col-md-12">  
            <?php   
                $post_thumbnail = get_the_post_thumbnail($car->ID, 'thumbnail');
                //predefinovane informace k autu
                $number_of_seats = get_post_meta($car->ID, '_number_of_seats', true);
                $number_of_doors = get_post_meta($car->ID, '_number_of_doors', true);
                $number_of_suitcases = get_post_meta($car->ID, '_number_of_suitcases', true);
                $transmission = get_post_meta($car->ID, '_transmission', true);            
                $aircondition = get_post_meta($car->ID, '_aircondition', true);
                $fuel = get_post_meta($car->ID, '_fuel', true); 
                $number_of_seats = esc_attr($number_of_seats);
                $number_of_doors = esc_attr($number_of_doors);
                $number_of_suitcases = esc_attr($number_of_suitcases);
                $transmission = esc_attr($transmission); 
                $aircondition = esc_attr($aircondition);
                $fuel = esc_attr($fuel);
 
                $Cars_cart = new Car_Cart('shopping_cart');
                $Cars_cart_items = $Cars_cart->getItems();  
                //improve for sanitize 
                $pick_up_location = $Cars_cart_items['pick_up_location'];
                $drop_off_location = $Cars_cart_items['drop_off_location']; 
                $car_dfrom = $Cars_cart_items['car_datefrom'];
                $car_dto = $Cars_cart_items['car_dateto'];   
                $car_category = $Cars_cart_items['car_category'];                    
                
                $currency = sc_Currency::get_instance();
                 
            ?> 
              <table> 
               <tr><td><h3><?php echo get_the_title($car->ID) ?></h3> </td><td><?php echo $post_thumbnail; ?> </td></tr>
              </table> 
                <h3><?php _e('Price: ', $this->car_share); ?>    
                <?php $price = $Cars_cart->get_car_price($car->single_car_id, $car_dfrom, $car_dto); ?> 
                <?php echo !empty($price) ?  $currency->format($price) : ''; ?></h3>  
            
            <table>
                <?php if (!empty($number_of_seats)) { ?>
                    <tr>
                        <th><?php _e('Seats', $this->car_share); ?></th> 
                        <td><?php echo $number_of_seats; ?></td> 
                    </tr>
                <?php }; ?>
                <?php if (!empty($number_of_doors)) { ?>
                    <tr>
                        <th><?php _e('Doors', $this->car_share); ?></th>  
                        <td><?php echo $number_of_doors; ?></td> 
                    </tr>
                <?php }; ?>
                <?php if (!empty($number_of_suitcases)) { ?>
                    <tr>
                        <th><?php _e('Bags', $this->car_share); ?></th> 
                        <td><?php echo $number_of_suitcases; ?></td> 
                    </tr>
                <?php }; ?>
                <?php if (!empty($transmission)) { ?>
                    <tr>
                        <th><?php _e('Transmission', $this->car_share); ?></th> 
                        <td><?php echo $transmission; ?></td> 
                    </tr>
                <?php }; ?> 
                <?php if (!empty($fuel)) { ?>
                    <tr>
                        <th><?php _e('Fuel', $this->car_share); ?></th> 
                        <td><?php echo $fuel; ?></td> 
                    </tr>
                <?php }; ?>
                <?php if (!empty($aircondition)) { ?>
                    <tr>
                        <th><?php _e('Air condition', $this->car_share); ?></th> 
                        <td><?php echo $aircondition; ?></td> 
                    </tr>
                <?php }; ?>         
            </table>  
            <a class="continue btn btn-default" href="<?php echo $this->extras_car_url; ?><?php echo $sc_pr; ?>chcar=<?php echo $car->single_car_id; ?>"><?php _e('Book a car', $this->car_share); ?></a> 
        </div>
    <?php endforeach; ?> 
    <a href="#" type="submit" class="btn btn-default"><?php _e('BACK', $this->car_share); ?></a>            
<?php else: ?>
    <p><?php _e('Sorry, there is no car meeting your requirements.', $this->car_share); ?></p>
<?php endif; ?>
