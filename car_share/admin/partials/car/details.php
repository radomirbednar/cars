<?php 
    $transsition_options = sc_Car::getTransmissionOptions(); 
    $fuel_option = sc_Car::getFuelOptions();
    $air_option = sc_Car::getAirOptions(); 
?>

<table>
    <tr>
        <td><?php _e('Number of seats', $this->car_share) ?></td>
        <td>
            <select name="_number_of_seats" class="small-input">
                <?php for($i = 0; $i < 12; $i++): ?>
                <option value="<?php echo $i ?>" <?php echo $number_of_seats == $i ? ' selected="selected" ' : '' ?>><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><?php _e('Number of doors', $this->car_share) ?></td>
        <td>
            <select name="_number_of_doors" class="small-input">
                <?php for($i = 0; $i < 6; $i++): ?>
                <option value="<?php echo $i ?>" <?php echo $number_of_doors == $i ? ' selected="selected" ' : '' ?>><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><?php _e('Number of suitcases', $this->car_share) ?></td>
        <td>
            <select name="_number_of_suitcases" class="small-input">
                <?php for($i = 0; $i < 11; $i++): ?>
                    <option value="<?php echo $i ?>" <?php echo $number_of_suitcases == $i ? ' selected="selected" ' : '' ?>><?php echo $i ?></option>
                <?php endfor; ?>
            </select>            
        </td>
    </tr>
    <tr>
        <td><?php _e('Gear transmission', $this->car_share) ?></td>
        <td>
            <select name="_transmission">
                <?php foreach($transsition_options as $key => $label): ?>
                    <option value="<?php echo $key ?>" <?php echo $transmission == $key ? ' selected="selected" ' : '' ?>><?php _e($label, $this->car_share) ?></option>
                <?php endforeach; ?>
            </select>    
        </td>
    </tr>  
    
    <tr>
        <td><?php _e('Air condition', $this->car_share) ?></td>
        <td>        
            <select name="_aircondition">
                <?php foreach($air_option as $key => $label): ?>
                    <option value="<?php echo $key ?>" <?php echo $aircondition == $key ? ' selected="selected" ' : '' ?>><?php _e($label, $this->car_share) ?></option>
                <?php endforeach; ?>
            </select> 
        </td> 
    </tr> 
    
    <tr>  
        <td><?php _e('Fuel', $this->car_share) ?></td>
        <td>
            <select name="_fuel">
                <?php foreach($fuel_option as $key => $label): ?>
                    <option value="<?php echo $key ?>" <?php echo $fuel == $key ? ' selected="selected" ' : '' ?>><?php _e($label, $this->car_share) ?></option>
                <?php endforeach; ?>
            </select>    
        </td> 
    </tr>
    
</table> 