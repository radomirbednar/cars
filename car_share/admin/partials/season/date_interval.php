<script>
    jQuery(function ($) {

        $('#date-from').datepicker({
        dateFormat: 'dd.mm.yy',
<?php echo empty($date_to) ? '' : "maxDate: '" . $date_to->format('d.m.Y') . "'," ?>
        onSelect: function (date_from) {
            $('#date-to').datepicker("option", "minDate", date_from);
            }
        });
                $('#date-to').datepicker({
            dateFormat: 'dd.mm.yy',
<?php echo empty($date_from) ? '' : "minDate: '" . $date_from->format('d.m.Y') . "'," ?>
            onSelect: function (date_to) {
                $('#date-from').datepicker("option", "maxDate", date_to);
            }
        });
    });
</script>

<?php
$season_dates = sc_Season::get_dates($post->ID);

if (empty($season_dates)):
    ?>
    <div class="season-date-row">
        <label class="label-inline"><?php _e('Date from:', $this->car_share) ?> <input type="text" class="datepicker" name="_from[]" value="<?php echo empty($date_from) ? '' : $date_from->format('d.m.Y') ?>"></label>
        <label class="label-inline"><?php _e('Date to:', $this->car_share) ?> <input type="text" class="datepicker" name="_to[]" value="<?php echo empty($date_to) ? '' : $date_to->format('d.m.Y') ?>"></label>
    </div>
<?php else: ?>
    <?php
    foreach ($season_dates as $val):
        $date_from = DateTime::createFromFormat('Y-m-d H:i:s', $val->date_from);
        $date_to = DateTime::createFromFormat('Y-m-d H:i:s', $val->date_to);
        ?>
        <div class="season-date-row">
            <label class="label-inline"><?php _e('Date from:', $this->car_share) ?> <input type="text" class="datepicker" name="_from[]" value="<?php echo $date_from->format('d.m.Y') ?>"></label>
            <label class="label-inline"><?php _e('Date to:', $this->car_share) ?> <input type="text" class="datepicker" name="_to[]" value="<?php echo $date_to->format('d.m.Y') ?>"></label>
        </div>
    <?php endforeach; ?>
<?php endif; ?>