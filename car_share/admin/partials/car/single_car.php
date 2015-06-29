<label>
    <?php _e('Vehicle registration plate:', $this->car_share) ?>
    <input type="text" name="car[<?php echo $car_id ?>][spz]" value="<?php echo isset($spz) ? esc_attr($spz) : '' ?>">
</label> 
<h2><?php _e('Calendar:', $this->car_share) ?></h2> 
 <?php $this->calendar_single_car_ajax($car_id); ?> 
<?php if (!empty($locations)): ?>
    <h2><?php _e('Pick-up location:', $this->car_share) ?></h2>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="car[<?php echo $car_id ?>][pickup_location][]" value="<?php echo $location->ID ?>" <?php echo isset($pickup_location) && in_array($location->ID, $pickup_location) ? ' checked="checked" ' : '' ?>>
            <?php _e($location->post_title) ?>
        </label>
    <?php endforeach; ?>
    <div class="clear"></div>
<?php endif; ?>
<?php if (!empty($locations)): ?>
    <h2><?php _e('Drop-off Location:', $this->car_share) ?></h2>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="car[<?php echo $car_id ?>][dropoff_location][]" value="<?php echo $location->ID ?>" <?php echo isset($dropoff_location) && in_array($location->ID, $dropoff_location) ? ' checked="checked" ' : '' ?>>
            <?php _e($location->post_title) ?>
        </label>
    <?php endforeach; ?>
    <div class="clear"></div>
<?php endif; ?>

<h2><?php _e('Status', $this->car_share) ?></h2>

<table id="car-status-<?php echo $car_id ?>" class="status">
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
    <?php //the_content(); ?> 
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <button id="add-status-<?php echo $car_id ?>" data-car_id="<?php echo $car_id ?>" type="button" class="add-status alignleft button button-primary"><?php _e('Add status', $this->car_share) ?></button>
            </td>
        </tr>
    </tfoot>
</table>

<hr> 
<button id="delete-car-<?php echo $car_id ?>" data-car_id="<?php echo $car_id ?>" type="button" class="delete-car alignright button button-primary"><?php _e('Delete', $this->car_share) ?></button>
<button id="clone-car-<?php echo $car_id ?>" data-car_id="<?php echo $car_id ?>" type="button" class="clone-car alignright button button-primary"><?php _e('Clone', $this->car_share) ?></button>
<button id="new-car-<?php echo $car_id ?>" data-car_id="<?php echo $car_id ?>" type="button" class="new-car alignright button button-primary"><?php _e('New', $this->car_share) ?></button>

<div class="clear"></div>
<script>
    jQuery(document).ready(function($) {
<?php
if (!empty($statuses)):
    $status_key = 0;
    foreach ($statuses as $status):

        $status = (object) $status;

        $date_from = isset($status->date_from) ? DateTime::createFromFormat('Y-m-d H:i:s', $status->date_from) : '';
        $date_to = isset($status->date_to) ? DateTime::createFromFormat('Y-m-d H:i:s', $status->date_to) : '';
        ?>

                var row = statusTableRow(
                        '<?php echo $car_id ?>',
                        '<?php echo $status_key ?>',
                        '<?php echo empty($date_from) ? '' : $date_from->format(SC_DATE_FORMAT) ?>',
                        '<?php echo empty($date_from) ? '' : $date_from->format('H') ?>',
                        '<?php echo empty($date_from) ? '' : $date_from->format('i') ?>',
                        '<?php echo empty($date_to) ? '' : $date_to->format('d-m-Y') ?>',
                        '<?php echo empty($date_to) ? '' : $date_to->format('H') ?>',
                        '<?php echo empty($date_to) ? '' : $date_to->format('i') ?>',
                        '<?php echo $status->status ?>'
                        );

                $('#post-body').find("#car-status-<?php echo $car_id ?> tbody").append(row);

                var element = $("#car-status-<?php echo $car_id ?> tbody").find('.item:last');
                apply_datepicker(element);

        <?php
        $status_key++;
    endforeach;
    ?>
            status_key = <?php echo $status_key ?>;
<?php endif; ?>
    });
</script>
