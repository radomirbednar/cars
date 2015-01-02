<?php

$days = array(
    'Monday' => 'Monday',
    'Tuesday' => 'Tuesday',
    'Wednesday' => 'Wednesday',
    'Thursday' => 'Thursday',
    'Friday' => 'Friday',
    'Saturday' => 'Saturday',
    'Sunday' => 'Sunday',
);

?>

<table id="opening-hours" class="overvies-table">   
    <thead>
        <tr>
            <td></td>
            <td><?php _e('From', $this->car_share) ?></td>
            <td><?php _e('To', $this->car_share) ?></td>
            <td><?php _e('Open', $this->car_share) ?></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($days as $key => $label): ?>
        <tr>
            <td><?php _e($label, $this->car_share) ?></td>
            <td>
                <select name="open[<?php echo $key ?>][from][hour]">
                <?php for($i = 0; $i < 25; $i++): ?>
                    <option value="<?php echo $i ?>"><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select> 
                :
                <select name="open[<?php echo $key ?>][from][min]">
                <?php for($i = 0; $i < 60; $i++): ?>
                    <option value="<?php echo $i ?>"><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select>
            </td>
            <td>
                <select name="open[<?php echo $key ?>][to][hour]">
                <?php for($i = 0; $i < 25; $i++): ?>
                    <option value="<?php echo $i ?>"><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select> 
                :
                <select name="open[<?php echo $key ?>][to][min]">
                <?php for($i = 0; $i < 60; $i++): ?>
                    <option value="<?php echo $i ?>"><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select>            
            </td>
            <td><input type="checkbox" name="open[<?php echo $key ?>][open]" value="1"></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
