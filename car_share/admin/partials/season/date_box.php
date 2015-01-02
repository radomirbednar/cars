<div class="ll-skin-lugo">

    <script>
        jQuery(function ($) {
            /*
             $('.datepicker').datepicker({
             dateFormat: 'dd.mm.yy'
             });*/

            $('#date-from').datepicker({
                dateFormat: 'dd.mm.yy',
                <?php echo empty($date_to) ? '' : "maxDate: '" . $date_to->format('d.m.Y') . "'," ?>
                onSelect: function (date_from) {
                    $('#date-to').datepicker("option","minDate", date_from);
                }
            });

            $('#date-to').datepicker({
                dateFormat: 'dd.mm.yy',
                <?php echo empty($date_from) ? '' : "minDate: '" . $date_from->format('d.m.Y') . "'," ?>
                onSelect: function (date_to) {
                    $('#date-from').datepicker("option","maxDate", date_to);
                }
            });

        });
    </script>

    <label><?php _e('Date from:', $this->car_share) ?><input type="text" id="date-from" class="datepicker" name="_from" value="<?php echo empty($date_from) ? '' : $date_from->format('d.m.Y') ?>"></label>
    <label><?php _e('Date to:', $this->car_share) ?><input type="text" id="date-to" class="datepicker" name="_to" value="<?php echo empty($date_to) ? '' : $date_to->format('d.m.Y') ?>"></label>

</div>
