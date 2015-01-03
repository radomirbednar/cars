<table id="discount-table" class="overvies-table">
    <tbody>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <button id="new-discount" type="button" class="button button-primary"><?php _e('Add discount', $this->car_share) ?></button>
            </td>    
        </tr>
    </tfoot>    
</table>

<script>
    jQuery(document).ready(function ($) {

        var row_key = 0;

        function htmlPriceRow(key, days, percentage) {

            var str = '<tr class="item">' +
                    '<td>' +
                    '<label><?php _e('After days:', $this->car_share) ?> ' +
                    '<input type="text" class="small-input" name="_discount_upon_duration[' + key + '][days]" value="' + days + '">' +
                    '</label>' +
                    '</td>' +
                    '<td>' +
                    '<label><?php _e('Discount (%) of total amount:', $this->car_share) ?> ' +
                    '<input type="text" class="small-input" name="_discount_upon_duration[' + key + '][percentage]" value="' + percentage + '">' +
                    '</label>' +
                    '</td>' +
                    '<td>' +
                    '<button class="remove-row" type="button"><?php _e("X", $this->car_share) ?></button>' +
                    '</td>' +
                    '</tr>';
            return str;
        }

<?php
if (!empty($discount_upon_duration)):
    foreach ($discount_upon_duration as $days => $percentage):
        ?>
                var row = htmlPriceRow('<?php echo $days ?>', '<?php echo $days ?>', '<?php echo $percentage ?>');
                $('#discount-table tbody').append(row);
                row_key++;
        <?php
    endforeach;
endif;
?>

        $('#new-discount').click(function (e) {
            var row = htmlPriceRow(row_key, '', '');
            $('#discount-table tbody').append(row);
            row_key++;
        });

        $('#discount-table').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>

