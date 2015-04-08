<script>
    /*
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
     */
</script>

<table class="status date_interval">
    <thead>
        <tr>
            <td>
                <?php _e('From', $this->car_share) ?>
            </td>
            <td>
                <?php _e('To', $this->car_share) ?>
            </td>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $season_dates = sc_Season::get_dates($post->ID);

        if (empty($season_dates)):
            echo Car_share_Season::date_row_static('', '');
        else:
            foreach ($season_dates as $val):
                $date_from = DateTime::createFromFormat('Y-m-d H:i:s', $val->date_from);
                $date_to = DateTime::createFromFormat('Y-m-d H:i:s', $val->date_to);
                echo Car_share_Season::date_row_static($date_from, $date_to, true);
            endforeach;
        endif;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <button id="add-new-date" type="button" class="add-status button button-primary"><?php _e('Add new date interval', 'car_share') ?></button>
            </td>
        </tr>
    </tfoot>
</table>

<script>
    jQuery(function ($) {
        $("#add-new-date").click(function () {
            
           jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                //dataType: "json",
                data: {
                    'id': id,
                    'action': 'date_interval_row',
                },
                beforeSend: function () {
                        self.prop("disabled", true);
                    }
                }).done(function (ret) {
                    console.log(ret);
                    //var new_element = $('#single_car_box_' + id).after(ret);
                }).fail(function (ret) {
                    //alert('<?php esc_attr_e('Create new car failed', $this->car_share) ?>');
                }).always(function () {
                    self.prop("disabled", false);
                });            
            
            //console.log('add new date');
            //var inputs = '<?php echo Car_share_Season::date_row('', '', true); ?>';
        });
    });
</script>