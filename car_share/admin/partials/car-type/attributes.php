<tr class="form-field">
    <th scope="row"><?php _e('Price:', $this->car_share) ?></th>
    <td>

        <table id="price-table">
            <thead>
                <tr>                    
                    <td><?php _e('From days:', $this->car_share) ?></td>
                    <td><?php _e('Price:', $this->car_share) ?></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr>                    
                    <td><input class="small-input" type="text" value="0" readonly=""></td>
                    <td>
                        <label>
                            <input class="small-input" type="text" name="start_price" value="<?php echo empty($start_price) ? '' : $start_price->price_value ?>">
                            <?php _e('amount', $this->car_share) ?>
                        </label>
                    </td>
                    <td></td>                    
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <button id="new_price" type="button" class="button button-primary"><?php _e('Add next', $this->car_share) ?></button>
                    </td>    
                </tr>    
            </tfoot>
        </table>        
    </td>
</tr>    

<tr>
    <th scope="row">
        <label for="minimun_driver_age"><?php _e('Minimum driver age:', $this->car_share) ?></label>
    </th>
    <td>
        <input id="minimun_driver_age" class="small-input" type="number" name="_minimum_driver_age" value="<?php echo empty($minimum_driver_age) ? 18 : (int) $minimum_driver_age ?>">
    </td>
</tr>

<script>
    jQuery(document).ready(function ($) {

        function htmlPriceRow(next_time, next_price, price_type) {

            var str = '<tr class="next-price-row">' +                    
                    '<td><input class="small-input" type="text" name="special_price[next_time][]" value="' + next_time + '"></td>' +
                    '<td>'+
                    '<label>'+
                    '<input class="small-input" type="text" name="special_price[next_price][]" value="' + next_price + '"> '+
                    '<?php _e("percentage", $this->car_share) ?>'+
                    '</label>'+
                    '</td>' +
                    '<td>' +
                    '</td>' +
                    '<td><button class="button button-primary button-delete" type="button"><?php _e("delete", $this->car_share) ?></button></td>' +
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
        $('#new_price').click(function (e) {
            var row = htmlPriceRow('', '', '');
            $('#price-table tbody').append(row);
        });

        $('#price-table').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".next-price-row").remove();
        });
    });
</script>