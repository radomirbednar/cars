<!--
<div class="row">
    <label><?php _e('Current location', $this->car_share) ?>
        <select name="_current_location">
            <option value="">------</option>
            <?php if(!empty($locations)): ?>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo $location->ID ?>" <?php echo $current_location == $location->ID ? ' selected="selected" ' : '' ?>><?php _e($location->post_title) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </label>
</div>   --> 

<?php if (!empty($locations)): ?>
<h4><?php _e('Pick-up location:', $this->car_share) ?></h4>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="_pickup_location[]" value="<?php echo $location->ID ?>" <?php echo is_array($pickup_location) && in_array($location->ID, $pickup_location) ? ' checked="checked" ' : '' ?>>
            <?php _e($location->post_title) ?>
        </label>
    <?php endforeach; ?>
    <div class="clear"></div>
<?php endif; ?>

<?php if (!empty($locations)): ?>
<h4><?php _e('Drop-off Location:', $this->car_share) ?></h4>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="_dropoff_location[]" value="<?php echo $location->ID ?>" <?php echo is_array($dropoff_location) && in_array($location->ID, $dropoff_location) ? ' checked="checked" ' : '' ?>>
            <?php _e($location->post_title) ?>
        </label>
    <?php endforeach; ?>
    <div class="clear"></div>
<?php endif; ?>
 



