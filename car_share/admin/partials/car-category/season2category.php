<table id="season-to-category" style="width: 100%;">
    <tbody id="content-season2category">
        <?php include 'content_assigned_season.php'; ?>
    </tbody>
</table>

<a id="assign-new-season" type="button" class="thickbox button button-primary" href="#TB_inline?width=auto&height=350&inlineId=modal-season2category"><?php _e('Add season', $this->car_share) ?></a>


<script>

    jQuery(document).ready(function ($) {

        $('body').on('submit','.update-season2category',function(event) {

                console.log('xxxxxxxxxxxx');

                event.preventDefault();
                var self = $(this);

                jQuery.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function () {
                        //self.find(':submit').attr('disabled','disabled');
                        self.find(':submit').prop("disabled", true);
                    }
                }).done(function (ret) {
                    console.log(ret);
                    self[0].reset()
                    $('#TB_closeWindowButton').trigger('click');
                    //resp.html('<div class="alert alert-success">' + ret + '</div>');
                    //self.find(".clear").val("");
                }).fail(function (ret) {
                    //resp.html('<div class="alert alert-danger">' + ret.responseText + '</div>');
                }).always(function () {
                    self.find(':submit').prop("disabled", false);
                });
            });
        });


    function reload_season2category(car_category_id){
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            action : 'reload_season2category',
            data: {
                'id': car_category_id
            },
            beforeSend: function () {
                //self.find(':submit').attr('disabled','disabled');
                //self.find(':submit').prop("disabled", true);
            }
        }).done(function (ret) {
            $('#content-season2category').html(ret);
            //resp.html('<div class="alert alert-success">' + ret + '</div>');
            //self.find(".clear").val("");
        }).fail(function (ret) {
            //resp.html('<div class="alert alert-danger">' + ret.responseText + '</div>');
        }).always(function () {
            //self.find(':submit').prop("disabled", false);
        });
    }
</script>