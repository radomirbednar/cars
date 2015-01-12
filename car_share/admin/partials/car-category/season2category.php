<table id="season-to-category" style="width: 100%;">
    <tbody id="content-season2category">
        <?php include 'content_assigned_season.php'; ?>
    </tbody>
</table>


<div id="season2category-response"></div>

<a id="assign-new-season" type="button" class="button button-primary" href="#"><?php _e('Assign new season', $this->car_share) ?></a>



<script>
jQuery(document).ready(function ($) {
    $( "#assign-new-season" ).click(function(event) {
        event.preventDefault();
        var self = $(this);
        
        
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
                $('#season2category-response').html(ret);
                //self[0].reset()
                //$('#TB_closeWindowButton').trigger('click');
                //$('#content-season2category').html(ret);
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