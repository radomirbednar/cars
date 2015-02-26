<table id="discount-table" class="">
    <tbody>
        <?php
        
        $row_key = 0;
        
        if (!empty($discount_upon_duration)):
            foreach ($discount_upon_duration as $days_number => $discount):
                include 'discount_upon_duration_row.php';        
                $row_key++;
            endforeach;
        endif;
        ?>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <button id="new-discount" type="button" class="button button-primary"><?php _e('Add discount', $this->car_share) ?></button>
            </td>
        </tr>
    </tfoot>
</table>

<script>
    var row_key = <?php echo empty($discount_upon_duration) ? 0 : count($discount_upon_duration) ?>;

    jQuery(document).ready(function ($) {
        $('#new-discount').click(function (e) {

            var self = $(this);

            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                //dataType: "json",
                data: {
                    'row_key': row_key,
                    'action': 'discount_upon_duration_row',
                },
                beforeSend: function () {
                    self.prop("disabled", true);
                }
            }).done(function (ret) {
                $('#discount-table tbody').append(ret);
                row_key++;
            }).fail(function (ret) {
                alert('<?php esc_attr_e('Error', $this->car_share) ?>');
            }).always(function () {
                self.prop("disabled", false);
            });
        });

        $('#discount-table').on('click', 'tbody .remove-row', function (event) {
            $(this).parents(".item").remove();
        });
    });
</script>

