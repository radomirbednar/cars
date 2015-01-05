<table id="unavailability">
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
                <button id="add-unavailability" type="button" class="button button-primary"><?php _e('Add unavailability', $this->car_share) ?></button>
            </td>    
        </tr>    
    </tfoot>    
</table>

<script>
    jQuery(document).ready(function ($) {

        function unavailabilityTableRow(next_time, next_price, price_type) {

            var str = '<tr class="item">' +
                    '<td>' +
                    '<input type="text" name="unavailability[][note]" value="">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="unavailability[][from]" value="">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" name="unavailability[][to]" value="">' +
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
                var row = unavailabilityTableRow('<?php echo $sp->time_from ?>', '<?php echo $sp->price_value ?>', '<?php echo $sp->time_type ?>');
                $('#unavailability tbody').append(row);
        <?php
    endforeach;
endif;
?>

        $('#add-unavailability').click(function (e) {
            var row = unavailabilityTableRow('', '', '');
            $('#unavailability tbody').append(row);
        });

        $('#unavailability').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>