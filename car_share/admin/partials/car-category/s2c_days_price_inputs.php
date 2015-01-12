<?php
$days = get_days_of_week();
?>
<table>
    <tbody>
        <tr>
            <?php foreach ($days as $day_name => $label): ?>
                <td><?php _e($label, $this->car_share) ?>:</td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <?php foreach ($days as $day_name => $label): ?>
                <td><input type="number" step="0.01" name="_season_to_category_prices[<?php echo $day_name ?>]" class="day-price" value="<?php echo isset($category_day_prices[$day_name]) ? $category_day_prices[$day_name]->price : 0 ?>"></td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>

<input type="submit" id="assign_new_season" class="button button-primary" value="<?php _e('Save', $this->car_share) ?>">

<script>
    jQuery(document).ready(function ($) {
        $('#car_category_assign_season').on('click', '#assign_new_season', function (event) {

            event.preventDefault();

            var self = $(this);
            var id = <?php echo (int) $post_id; ?>; // category id
            var form_data = $(this).parents('form').serialize()

            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                //dataType: "json",
                data: {
                    'id': id,
                    'action': 'assign_new_season',
                    'form' : form_data,
                },
                beforeSend: function () {
                    self.prop("disabled", true);                    
                }
            }).done(function (ret) {
                //var new_element = $('#single_car_box_' + id).after(ret);
            }).fail(function (ret) {
                //alert('<?php _e('Create new car failed', $this->car_share) ?>');
            }).always(function () {
                self.prop("disabled", false);
            });

        });
    });

</script>
