<?php
$days = get_days_of_week();

foreach ($season2category_prices as $season_id => $season_price):
    $season = new sc_Season($season_id);
    //$from = $season->from();
    //$to = $season->to();
    ?>
    <tr id="s2c-label-<?php echo $season_id ?>" class="s2c-row assigned-session-<?php echo esc_attr($season_id) ?>">
        <td colspan="1">
            <strong><?php echo get_the_title($season_id) ?></strong>
        </td>
        <td colspan="7" class="season-dates">
            <?php
            $dates = sc_Season::date_to_column($season_id);

            foreach ($dates as $date):
                $from = DateTime::createFromFormat('Y-m-d H:i:s', $date->date_from);
                $to = DateTime::createFromFormat('Y-m-d H:i:s', $date->date_to);

                //$str = $from->format(get_option('date_format')) . ' - ' . $to->format(get_option('date_format'));
                $str = $from->format(SC_DATE_FORMAT) . ' - ' . $to->format(SC_DATE_FORMAT);                
                
                echo $str . '<br>';
            endforeach; ?>
        </td>
        <td>
            <a href="#" class="edit-s2c" data-season_id="<?php echo $season_id ?>" data-car_category_id="<?php echo $season_price['car_category_id'] ?>">
                <?php _e('Edit', $this->car_share) ?>
            </a> |
            <a href="#" class="remove-s2c" data-season_id="<?php echo $season_id ?>" data-car_category_id="<?php echo $season_price['car_category_id'] ?>">
                <?php _e('Delete', $this->car_share) ?>
            </a>
        </td>
    </tr>

    <tr id="s2c-day-<?php echo $season_id ?>" class="assigned-session-<?php echo esc_attr($season_id) ?>">
        <td></td>
        <?php foreach ($days as $day_name => $label): ?>
            <td><?php _e($label, $this->car_share); ?></td>
        <?php endforeach; ?>
        <td></td>
    </tr>

    <tr id="s2c-price-<?php echo $season_id ?>" class="assigned-session-<?php echo esc_attr($season_id) ?>">
        <td><?php _e('Price in season:', $this->car_share) ?></td>
        <?php foreach ($days as $day_name => $label): ?>
            <td><?php echo isset($season_price['days'][$day_name]) ? esc_attr($season_price['days'][$day_name]) : '' ?></td>
        <?php endforeach; ?>
        <td></td>
    </tr>

    <?php
    if (isset($s2c_discount_upon_duration[$season_id])):
        foreach ($s2c_discount_upon_duration[$season_id] as $day_number => $discount):
            ?>
            <tr class="assigned-session-<?php echo esc_attr($season_id) ?>">

                <td><?php _e('Price from days:', $this->car_share) ?> <?php echo (int) $day_number ?></td>

                <?php foreach ($discount as $day_key => $day_discount): ?>
                    <td><?php echo esc_attr($day_discount['discount']) ?></td>
                <?php endforeach; ?>
                <td></td>
            </tr>
            <?php
        endforeach;
    endif;
    ?>


<?php endforeach; ?>