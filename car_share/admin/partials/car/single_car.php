<?php if (!empty($locations)): ?>
<h2><?php _e('Pick-up location:', $this->car_share) ?></h2>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="_pickup_location[<?php echo $car_id ?>][]" value="<?php echo $location->ID ?>" <?php echo isset($pickup_location) && in_array($location->ID, $pickup_location) ? ' checked="checked" ' : '' ?>>
            <?php _e($location->post_title) ?>
        </label>
    <?php endforeach; ?>
    <div class="clear"></div>
<?php endif; ?>

<?php if (!empty($locations)): ?>
<h2><?php _e('Drop-off Location:', $this->car_share) ?></h2>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="_dropoff_location[<?php echo $car_id ?>][]" value="<?php echo $location->ID ?>" <?php echo isset($dropoff_location) && in_array($location->ID, $dropoff_location) ? ' checked="checked" ' : '' ?>>
            <?php _e($location->post_title) ?>
        </label>
    <?php endforeach; ?>
    <div class="clear"></div>
<?php endif; ?>

<h2><?php _e('Status', $this->car_share) ?></h2>

<table class="status">
    <thead>
        <tr>
            <td>
                <?php _e('Note', $this->car_share) ?>
            </td>
            <td>
                <?php _e('From', $this->car_share) ?>
            </td>
            <td>
                <?php _e('To', $this->car_share) ?>
            </td>
            <th></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">
                <button id="add-status-<?php echo $car_id ?>" data-car_id="<?php echo $car_id ?>" type="button" class="add-status button button-primary"><?php _e('Add status', $this->car_share) ?></button>
            </td>    
        </tr>    
    </tfoot>    
</table>

<script>
jQuery(document).ready(function ($) {
<?php

if (!empty($statuses)):
    $status_key = 0;
    foreach ($statuses as $status):
        
        
        
        ?>
                var row = statusTableRow('<?php echo $car_id ?>', '<?php echo $status_key ?>', '<?php echo $sp->time_from ?>', '<?php echo $sp->price_value ?>', '<?php echo $sp->time_type ?>');
                document.write(row);                
        <?php
        $status_key++;
    endforeach; 
    ?>
       status_key = <?php echo $status_key ?>    
    <?php endif; ?>
});
</script>   

