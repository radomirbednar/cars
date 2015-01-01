<div class="ll-skin-lugo">

    <script>
        jQuery(function ($) {
            /*
             $('.datepicker').datepicker({
             dateFormat: 'dd.mm.yy'
             });*/

            $('#date-from').datepicker({
                dateFormat: 'dd.mm.yy',
                minDate: 0,
                onSelect: function (date_from) {
                    $('#date-to').datepicker("option","minDate", date_from);
                }
            });

            $('#date-to').datepicker({
                dateFormat: 'dd.mm.yy',
                onSelect: function (date_to) {
                    $('#date-from').datepicker("option","maxDate", date_to);
                }
            });

        });
    </script>

    <label><?php _e('Date from:', $this->car_share) ?><input type="text" id="date-from" class="datepicker" name="_from" value=""></label>
    <label><?php _e('Date to:', $this->car_share) ?><input type="text" id="date-to" class="datepicker" name="_to" value=""></label>

</div>

