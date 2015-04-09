<!--<form id="save-session-to-category" class="update-season2category" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">-->
    <!--<input type="hidden" name="action" value="add_season_to_category">-->
    <input type="hidden" name="_car_category_id" value="<?php echo (int) $post_id ?>">

    <label>
        <select id="season2category-select" name="_season_to_category">
            <option value=""><?php _e('--Pick a season--', $this->car_share) ?></option>
            <?php foreach ($seasons as $season): ?>
                <option value="<?php echo $season->ID ?>"><?php _e($season->post_title, $this->car_share) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    
    <div id="pick-season-response"></div>

    <div id="message-place" class="alignleft green"></div>
<!--</form>-->

<script>    
    jQuery(document).ready(function ($) {
        $('#poststuff').on('change', '#season2category-select', function (event) {
            
            var self = $(this);
            
            var season_id = $(this).val();
            
            if('' == season_id){
                return;
            }

            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                //dataType: "json",
                data: {
                    'season_id' : season_id,
                    'id': <?php echo (int) $post_id ?>,
                    'action': 'season2category_days',
                },
                beforeSend: function () {
                        //self.prop("disabled", true);
                    }
                }).done(function (ret) {
                    $('#pick-season-response').html(ret);                    
                }).fail(function (ret) {
                    $('#pick-season-response').html(ret.responseText);
                    
                }).always(function () {
                    
                });            
        });
    });
</script>
