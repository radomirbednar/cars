<script>

    var status_key = 0;

    function statusTableRow(car_id, key, next_time, next_price, price_type) {

        status_key = key;

        var str = '<tr class="item">' +
                '<td>' +
                '<select name="status[' + car_id + '][' + status_key + '][status]">'+
                '<option value="<?php echo Car_share::UNAVAILABLE ?>"><?php _e('Unavailable', $this->car_share) ?></option>' +
                '<option value="<?php echo Car_share::RENTED ?>"><?php _e('Rented', $this->car_share) ?></option>' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<input id="status-date-from-' + car_id + '_'+ status_key +'" class="status-date-from" type="text" name="status[' + car_id + '][' + status_key + '][from]" value="">' +
                '</td>' +
                '<td>' +
                '<input id="status-date-to-' + car_id + '_'+ status_key +'" class="status-date-to" type="text" name="status[' + car_id + '][' + status_key + '][to]" value="">' +
                '</td>' +
                '<td>' +
                '<button class="remove-row" type="button"><?php _e("X", $this->car_share) ?></button>' +
                '</td>' +
                '</tr>';

        status_key++;
        return str;
    }

    function reload_date_picker(){
        $( "li" ).each(function( index ) {
          console.log( index + ": " + $( this ).text() );
        });
    }

    jQuery(document).ready(function ($) {

        $('.add-status').click(function (e) {
            var car_id = $(this).data('car_id');
            var row = statusTableRow(car_id, status_key, '', '', '');
            $(this).parents('.status').find('tbody').append(row);
        });

        $('.status').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>