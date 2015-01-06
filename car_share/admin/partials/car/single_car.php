<?php if (!empty($locations)): ?>
<h2><?php _e('Pick-up location:', $this->car_share) ?></h2>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="_pickup_location[]" value="<?php echo $location->ID ?>" <?php echo isset($pickup_location) && in_array($location->ID, $pickup_location) ? ' checked="checked" ' : '' ?>>
            <?php _e($location->post_title) ?>
        </label>
    <?php endforeach; ?>
    <div class="clear"></div>
<?php endif; ?>

<?php if (!empty($locations)): ?>
<h2><?php _e('Drop-off Location:', $this->car_share) ?></h2>
    <?php foreach ($locations as $location): ?>
        <label class="inline-label">
            <input type="checkbox" name="_dropoff_location[]" value="<?php echo $location->ID ?>" <?php echo isset($dropoff_location) && in_array($location->ID, $dropoff_location) ? ' checked="checked" ' : '' ?>>
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
                <button id="add-status-<?php echo $key ?>" type="button" class="add-status button button-primary"><?php _e('Add status', $this->car_share) ?></button>
            </td>    
        </tr>    
    </tfoot>    
</table>

<script>
    jQuery(document).ready(function ($) {

        function statusTableRow(next_time, next_price, price_type) {

            var str = '<tr class="item">' +
                    '<td>' +
                    '<input type="text" name="status[][note]" value="">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="status[][from]" value="">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="status[][to]" value="">' +
                    '</td>' +
                    '<td>' +
                    '<button class="remove-row" type="button"><?php _e("X", $this->car_share) ?></button>' +
                    '</td>' +
                    '</tr>';
            
            return str;
        }

<?php
if (!empty($special_prices)):
    foreach ($special_prices as $sp):
        ?>
                var row = statusTableRow('<?php echo $sp->time_from ?>', '<?php echo $sp->price_value ?>', '<?php echo $sp->time_type ?>');
                $('.status tbody').append(row);
        <?php
    endforeach;
endif;
?>

        $('.add-status').click(function (e) {
            console.log($(this));
            var row = statusTableRow('', '', '');
            console.log('hello');
            $(this).parent('.status').find('tbody').append(row);
        });

        $('#status').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>