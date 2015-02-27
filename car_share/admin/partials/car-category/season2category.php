<table id="season-to-category" style="width: 100%;">
    <tbody id="content-season2category">
        <?php include 'content_assigned_season.php'; ?>
    </tbody>
</table>

<hr>
<a id="assign-new-season" type="button" class="button button-primary alignright" href="#"><?php _e('Assign new season', $this->car_share) ?></a>
<div class="clear"></div>
<div id="season2category-response"></div>
<script>

    jQuery(document).ready(function ($) {

        var s2c_row_key = <?php echo isset($s2c_discount_upon_duration[$season_id]) ? count($s2c_discount_upon_duration[$season_id]) : 0; ?>;

        /**
         *
         */
        $('#car_category_assign_season').on('click', '.remove-s2c', function (event) {

            event.preventDefault();
            var r = confirm("<?php _e('Are you sure?', $this->car_share) ?>");
            if (r == false) {
                return false;
            }

            var season_id = $(this).data('season_id');
            var self = $(this);

            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    'season_id': season_id,
                    'id': <?php echo (int) $post->ID ?>,
                    'action': 'delete_season_to_category',
                },
                beforeSend: function () {
                    //self.prop("disabled", true);
                }
            }).done(function (ret) {
                self.parents('.s2c-row').next().next().remove();
                self.parents('.s2c-row').next().remove();
                self.parents('.s2c-row').remove();
            }).fail(function (ret) {

            }).always(function () {
                //self.prop("disabled", false);
            });
        });
        /**
         *
         */
        $('#car_category_assign_season').on('click', '.edit-s2c', function (event) {
            event.preventDefault();
            var car_category_id = $(this).data('car_category_id');
            var season_id = $(this).data('season_id');
            var self = $(this);
            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    'car_category_id': car_category_id,
                    'season_id': season_id,
                    'id': <?php echo (int) $post->ID ?>,
                    'action': 'edit_season_to_category',
                },
                beforeSend: function () {
                    //self.prop("disabled", true);
                }
            }).done(function (ret) {
                $('#season2category-response').html('<div class="new-edit-s2c">' + ret + '</div>');
            }).fail(function (ret) {
                //
            }).always(function () {
                //
            });
        });

        $("#assign-new-season").click(function (event) {

            event.preventDefault();
            var self = $(this);

            $('#season2category-response').html('');

            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    'id': <?php echo (int) $post->ID ?>,
                    'action': 'new_season_to_category',
                },
                beforeSend: function () {
                    self.prop("disabled", true);
                }
            }).done(function (ret) {
                $('#season2category-response').html('<div class="new-edit-s2c">' + ret + '</div>');
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
            var id = <?php echo (int) $post->ID ?>; // category id
            var form_data = $(this).parents('form').serialize();

            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                //dataType: "json",
                data: {
                    'category_id': id,
                    //'season_id' : season_id,
                    'action': 's2c_discount_upon_duration_row',
                    'form': form_data,
                    'row_key': s2c_row_key
                },
                beforeSend: function () {
                    self.prop("disabled", true);
                    //$('#season2category-response').html('');
                }
            }).done(function (ret) {
                // reload content
                $('#session2category tbody').append(ret);
                s2c_row_key++;
            }).fail(function (ret) {

            }).always(function () {
                self.prop("disabled", false);
            });
        });

        /**
         *
         */
        $('#car_category_assign_season').on('click', '#save-season-2-category', function (event) {        

            //console.log('s2c season discount');
            
            event.preventDefault();

            var self = $(this);
            var id = <?php echo (int) $post->ID ?>; // category id
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
    });
</script>

<?php
/*
<script>

    jQuery(document).ready(function ($) {

        $('body').on('submit','.update-season2category',function(event) {

                event.preventDefault();
                var self = $(this);

                jQuery.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function () {
                        self.find(':submit').prop("disabled", true);
                    }
                }).done(function (ret) {
                    self[0].reset()
                    $('#TB_closeWindowButton').trigger('click');
                    $('#content-season2category').html(ret);
                }).fail(function (ret) {

                }).always(function () {
                    self.find(':submit').prop("disabled", false);
                });
            });
        });
</script>
 *
 */
