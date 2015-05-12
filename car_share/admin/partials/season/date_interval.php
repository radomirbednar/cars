<script>
    jQuery(function ($) {

        //
        $('#date-rows .item').each(function( index ) {
            //console.log( index + ": " + $( this ).text() );
            //console.log(this);
            apply_datepicker($(this));
        })

        // remove status
        $('#date_interval').on('click', 'tbody .remove-row', function (event) {
            //console.log('remove');
            $(this).parents(".item").remove();
        });

        $("#add-new-date").click(function () {

            //console.log('add-new-date');

            var self = $(this);

            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    'action': 'date_interval_row',
                },
                beforeSend: function () {
                    self.prop("disabled", true);
                }
            }).done(function (ret) {
                $('#date-rows').append(ret);
                var element = $('#date-rows').find('.item:last');
                apply_datepicker(element);
            }).fail(function (ret) {

            }).always(function () {
                self.prop("disabled", false);
            });
        });
    });
</script>

<table id="date_interval" class="status date_interval">
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
    <tbody id="date-rows">
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
                <button id="add-new-date" class="add-status button button-primary" type="button"><?php _e('Ajouter un nouvel intervalle de dates', 'car_share') ?></button>
            </td>
        </tr>
    </tfoot>
</table>