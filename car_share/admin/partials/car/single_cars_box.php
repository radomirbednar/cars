<div class="single-car">

    <button id="add-single-car" type="button" class="button button-primary"><?php _e('Add single car', $this->car_share) ?></button>        

    <div id="single-car-data">
        <?php if (!empty($locations)): ?>
            <h4><?php _e('Pick-up location:', $this->car_share) ?></h4>
            <?php foreach ($locations as $location): ?>
                <label class="inline-label">
                    <input type="checkbox" name="_pickup_location[]" value="<?php echo $location->ID ?>">
                    <?php _e($location->post_title) ?>
                </label>
            <?php endforeach; ?>
            <div class="clear"></div>
        <?php endif; ?>

        <?php if (!empty($locations)): ?>
            <h4><?php _e('Drop-off Location:', $this->car_share) ?></h4>
            <?php foreach ($locations as $location): ?>
                <label class="inline-label">
                    <input type="checkbox" name="_dropoff_location[]" value="<?php echo $location->ID ?>">
                    <?php _e($location->post_title) ?>
                </label>
            <?php endforeach; ?>
            <div class="clear"></div>
        <?php endif; ?>

    </div>

    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
                <th style="" class="">
                    <?php _e('ID', $this->car_share) ?>
                </th>
                <th style="" class="">
                    <?php _e('Pick up location', $this->car_share) ?>
                </th>
                <th style="" class="">
                    <?php _e('Drop off location', $this->car_share) ?>
                </th>
                <th style="" class="">
                    <?php _e('Nedostupnost', $this->car_share) ?>
                </th>
                <th style="" class="">                   
                </th>
            </tr>
        </thead>

        <tbody id="the-list">
            <tr class="type-post format-standard alternate level-0" id="post-1">
                <td class="">
                    2
                </td>
                <td class="">
                    3
                </td>
                <td class="">
                    4
                </td>
                <td class="">
                    5
                </td>
                <td class="">
                    <a href="#"><?php _e('edit', $this->car_share) ?></a> | <a href="#"><?php _e('delete', $this->car_share) ?></a>
                </td>
            </tr>
        </tbody>
    </table>


</div>
<script>
    jQuery(document).ready(function ($) {
        $("#add-single-car").click(function (event) {

            var form = $(this).parents('form');

            console.log('x' + form.serialize());

            /*
             event.preventDefault();                       
             tb_show('<?php _e('Add single car', $this->car_share) ?>', ajaxurl + '?action=add_single_car&id=<?php echo $post->ID ?>'); 
             */
        });
    });
</script>