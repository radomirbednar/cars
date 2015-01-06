<div class="single-car">    

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

    <button id="add-single-car" type="button" class="button button-primary"><?php _e('Add single car', $this->car_share) ?></button>        
</div>