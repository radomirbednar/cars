<?php
$days = get_days_of_week();
?>



<?php
if (!empty($season_id)):
    // pokud se jedna o editaci mam predvyplnene season_id
    ?>
    <input type="hidden" name="_season_to_category" value="<?php echo (int) $season_id ?>">
<?php endif; ?>

<div class="edit-new-s2c">
    <table id="session2category">
        <tbody>
            
            <tr>
                <td></td>
                <?php foreach ($days as $day_name => $label): ?>
                    <td><?php _e($label, $this->car_share) ?>:</td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td></td>
                <?php foreach ($days as $day_name => $label): ?>
                    <td><input type="number" step="0.01" name="_season_to_category_prices[<?php echo $day_name ?>]" class="day-price" value="<?php echo isset($category_day_prices[$day_name]) ? $category_day_prices[$day_name] : 0 ?>"></td>
                <?php endforeach; ?>
            </tr>
            
        </tbody>
    </table>

    <hr>
    
    <button id="add-season-2-category-discount" class="button button-primary alignright" type="button"><?php _e('Add discount', $this->car_share) ?></button>
    <button id="save-season-2-category" class="button button-primary alignleft" type="button"><?php _e('Save', $this->car_share) ?></button>
    
    <div class="clear"></div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $('#car_category_assign_season').on('click', '#save-season-2-category', function (event) {

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
                    //'season_id' : season_id,
                    'action': 'save_season2category',
                    'form': form_data,
                },
                beforeSend: function () {
                    self.prop("disabled", true);
                    $('#season2category-response').html('');
                }
            }).done(function (ret) {
                // reload content
                $('#content-season2category').html(ret);

                //var new_element = $('#single_car_box_' + id).after(ret);
            }).fail(function (ret) {

            }).always(function () {
                self.prop("disabled", false);
            });

        });

        /**
         * 
         */
        $('#car_category_assign_season').on('click', '#add-season-2-category-discount', function (event) {           

            event.preventDefault();

            var self = $(this);
            var id = <?php echo (int) $post_id; ?>; // category id
            var form_data = $(this).parents('form').serialize()

            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                //dataType: "json",
                data: {
                    'category_id': id,
                    //'season_id' : season_id,
                    'action': 's2c_discount_upon_duration_row',
                    'form': form_data,
                },
                beforeSend: function () {
                    self.prop("disabled", true);
                    //$('#season2category-response').html('');
                }
            }).done(function (ret) {
                // reload content
                $('#session2category tbody').append(ret);

                //var new_element = $('#single_car_box_' + id).after(ret);
            }).fail(function (ret) {

            }).always(function () {
                self.prop("disabled", false);
            });

        });



    });

</script>
