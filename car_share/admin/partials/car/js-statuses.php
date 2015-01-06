<script>

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

    jQuery(document).ready(function ($) {

        $('.add-status').click(function (e) {
            console.log($(this));
            var row = statusTableRow('', '', '');             
            $(this).parents('.status').find('tbody').append(row);
        });

        $('.status').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>