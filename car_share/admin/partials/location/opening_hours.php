<?php
$days = get_days_of_week();
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
        <?php foreach($days as $day_name => $day_label): 
            $day_opening_hours = isset($opening_hours[$day_name]) ? $opening_hours[$day_name] : new stdClass();
            ?>
        <tr>
            <td><?php _e($day_label, $this->car_share) ?></td>
            <td>
                <select name="open[<?php echo $day_name ?>][from][hour]">
                <?php for($i = 0; $i < 25; $i++): ?>
                    <option value="<?php echo $i ?>" <?php echo isset($day_opening_hours->from_hour) && $i == $day_opening_hours->from_hour ? ' selected="selected" ' : '' ?>><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select> 
                :
                <select name="open[<?php echo $day_name ?>][from][min]">
                <?php for($i = 0; $i < 60; $i++): ?>
                    <option value="<?php echo $i ?>" <?php echo isset($day_opening_hours->from_min) && $i == $day_opening_hours->from_min ? ' selected="selected" ' : '' ?>><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select>
            </td>
            <td>
                <select name="open[<?php echo $day_name ?>][to][hour]">
                <?php for($i = 0; $i < 25; $i++): ?>
                    <option value="<?php echo $i ?>" <?php echo isset($day_opening_hours->to_hour) && $i == $day_opening_hours->to_hour ? ' selected="selected" ' : '' ?>><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select> 
                :
                <select name="open[<?php echo $day_name ?>][to][min]">
                <?php for($i = 0; $i < 60; $i++): ?>
                    <option value="<?php echo $i ?>" <?php echo isset($day_opening_hours->to_min) && $i == $day_opening_hours->to_min ? ' selected="selected" ' : '' ?>><?php echo sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
                </select>            
            </td>
            <td><input type="checkbox" name="open[<?php echo $day_name ?>][open]" value="1" <?php echo isset($day_opening_hours->open) && 1 == $day_opening_hours->open ? ' checked="checked" ' : '' ?>></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

   
