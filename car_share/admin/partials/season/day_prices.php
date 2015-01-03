<?php
$days = get_days_of_week();
?>

<table>
    <tbody>
        <?php foreach($days as $day_name => $label): ?>
        <tr>
            <td><?php _e($label, $this->car_share) ?>:</td>
            <td>
                <input type="text" name="_season_day_prices[<?php echo $day_name ?>]" class="small-input" value="<?php echo isset($season_day_prices[$day_name]) ? $season_day_prices[$day_name]->price : 0 ?>">
            </td>
        </tr>        
        <?php endforeach; ?>
    </tbody>    
</table>