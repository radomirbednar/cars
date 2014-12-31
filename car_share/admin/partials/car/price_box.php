<label> <?php _e('Define price by:', $this->car_share) ?>
    <select name="price_by">
        <option value="<?php echo Car_share::TIME_TYPE_DAYS ?>" <?php echo !empty($start_price) && $start_price->time_type == Car_share::TIME_TYPE_DAYS ? ' selected="selected" ' : '' ?>><?php _e('days', $this->car_share) ?></option>
        <option value="<?php echo Car_share::TIME_TYPE_HOURS ?>" <?php echo !empty($start_price) && $start_price->time_type == Car_share::TIME_TYPE_HOURS ? ' selected="selected" ' : '' ?>><?php _e('hours', $this->car_share) ?></option>
    </select>
</label>


<table id="price-table">
    <thead>
        <tr>
            <th></th>
            <th><?php _e('From:', $this->car_share) ?></th>
            <th><?php _e('Price:', $this->car_share) ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php _e('Start price:', $this->car_share) ?></td>
            <td><input class="small-input" type="text" value="0" readonly=""></td>
            <td><input class="small-input" type="text" name="start_price" value="<?php echo empty($start_price) ? '' : $start_price->price_value ?>"></td>
            <td></td>
            <td></td>
        </tr>

    </tbody>
</table>

<button id="new_price" type="button" class="button button-small"><?php _e('Add next', $this->car_share) ?></button>

<script>
    jQuery(document).ready(function ($) {
        
        function htmlPriceRow(next_time, next_price, price_type){

            var str =   '<tr class="next-price-row">' +
                            '<td><?php _e("Next price:", $this->car_share) ?></td>' +
                            '<td><input class="small-input" type="text" name="special_price[next_time][]" value="' +  next_time + '"></td>' +
                            '<td><input class="small-input" type="text" name="special_price[next_price][]" value="' + next_price + '"></td>' +
                            '<td>' +
                                '<select name="special_price[price_type][]">' +
                                    '<option value="1"' + (<?php echo Car_share::PRICE_TYPE_AMOUNT ?> == price_type ? ' selected="selected" ' : '' ) + '><?php _e("amount", $this->car_share) ?></option>' +
                                    '<option value="2"' + (<?php echo Car_share::PRICE_TYPE_PERCENTAGE ?> == price_type ? ' selected="selected" ' : '' ) + '><?php _e("percentage", $this->car_share) ?></option>' +
                                '</select>' +
                            '</td>' +
                            '<td><button class="remove-row" type="button"><?php _e("X", $this->car_share) ?></button></td>' +
                        '</tr>';
            return str;
        }
        
        <?php 
        if(!empty($special_prices)):
            foreach($special_prices as $sp):             
                ?>
                    var row = htmlPriceRow('<?php echo $sp->time_from ?>', '<?php echo $sp->price_value ?>', '<?php echo $sp->time_type ?>');
                    $('#price-table').append(row);                
                <?php
            endforeach;
        endif;
        ?>
        
        $('#new_price').click(function (e) {
            var row = htmlPriceRow('', '', '');
            $('#price-table').append(row);
        });
        
        $('#price-table').on('click', 'tbody .remove-row', function( event ){
            $(this).parents(".next-price-row").remove();
        });        
    });
</script>