<table id="season-to-category" style="width: 100%;">
    <tbody>
        <?php include 'content_assigned_season.php'; ?>
    </tbody>
</table>

<a id="assign-new-season" type="button" class="thickbox button button-primary" href="#TB_inline?width=auto&height=350&inlineId=modal-season2category"><?php _e('Add season', $this->car_share) ?></a>


<script>
    function reload_assigned_seasons(){
        jQuery.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            beforeSend: function () {
                //self.find(':submit').attr('disabled','disabled');
                self.find(':submit').prop("disabled", true);
            }
        }).done(function (ret) {
            //resp.html('<div class="alert alert-success">' + ret + '</div>');
            //self.find(".clear").val("");
        }).fail(function (ret) {
            //resp.html('<div class="alert alert-danger">' + ret.responseText + '</div>');
        }).always(function () {
            //self.find(':submit').prop("disabled", false);
        });
    }
</script>