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

        function htmlPriceRow(next_time, next_price, price_type) {

            var str = '<tr class="item">' + 
                        '<td>' + 
                        '<label><?php _e('After days:', $this->car_share) ?> ' +
                        '<input type="text" class="small-input" name="discount_upon_duration[][days]" value="">' + 
                        '</label>' + 
                        '</td>' + 
                        '<td>' + 
                        '<label><?php _e('Discount (%) of total amount:', $this->car_share) ?> ' +                         
                        '<input type="text" class="small-input" name="discount_upon_duration[][percentage]" value="">' +
                        '</label>' + 
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
                var row = htmlPriceRow('<?php echo $sp->time_from ?>', '<?php echo $sp->price_value ?>', '<?php echo $sp->time_type ?>');
                $('#price-table tbody').append(row);
        <?php
    endforeach;
endif;
?>

        $('#new-discount').click(function (e) {
            var row = htmlPriceRow('', '', '');
            $('#discount-table tbody').append(row);
        });

        $('#discount-table').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>

