<script>

    var special_price_key = 0;

    function statusTableRow(car_id, key, next_time, next_price, price_type) {

        special_price_key = key;

        var str = '<tr class="item">' +
                '<td>' +
                '<input type="text" name="status[' + car_id + '][' + special_price_key + '][note]" value="">' +
                '</td>' +
                '<td>' +
                '<input type="text" name="status[' + car_id + '][' + special_price_key + '][from]" value="">' +
                '</td>' +
                '<td>' +
                '<input type="text" name="status[' + car_id + '][' + special_price_key + '][to]" value="">' +
                '</td>' +
                '<td>' +
                '<button class="remove-row" type="button"><?php _e("X", $this->car_share) ?></button>' +
                '</td>' +
                '</tr>';
        
        special_price_key++;
        return str;
    }

    jQuery(document).ready(function ($) {

        $('.add-status').click(function (e) {            
            var car_id = $(this).data('car_id');
            var row = statusTableRow(car_id, special_price_key, '', '', '');
            $(this).parents('.status').find('tbody').append(row);
        });

        $('.status').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>