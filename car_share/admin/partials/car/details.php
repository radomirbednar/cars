<?php
$transsition_options = Car::getTransmissionOptions();
?>

<table>
    <tr>
        <td><?php _e('Number of seats', $this->car_share) ?></td>
        <td>
            <select name="_number_of_seats" class="small-input">
                <?php for($i = 0; $i < 12; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><?php _e('Number of doors', $this->car_share) ?></td>
        <td>
            <select name="_number_of_doors" class="small-input">
                <?php for($i = 0; $i < 6; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><?php _e('Number of suitcases', $this->car_share) ?></td>
        <td>
            <select name="_number_of_suitcases" class="small-input">
                <?php for($i = 0; $i < 11; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php endfor; ?>
            </select>            
        </td>
    </tr>
    <tr>
        <td><?php _e('Gear transmission', $this->car_share) ?></td>
        <td>
            <select name="_transmission">
                <?php foreach($transsition_options as $key => $label): ?>
                <option value="<?php echo $key ?>"><?php _e($label, $this->car_share) ?></option>
                <?php endforeach; ?>
            </select>    
        </td>
    </tr>
</table>


