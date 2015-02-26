<?php
$days = get_days_of_week();
/*
  $days_row = '<tr>';
  foreach ($days as $day_name => $label):
  $days_row .= '<td>';
  $days_row .= __($label, $this->car_share);
  $days_row .= '</td>';
  endforeach;
  $days_row .= '<td></td></tr>';
 */

foreach ($season2category_prices as $season_id => $season_price):
    $season = new sc_Season($season_id);
    $from = $season->from();
    $to = $season->to();
    ?>
    <tr id="s2c-label-<?php echo $season_id ?>" class="s2c-row assigned-session-<?php echo esc_attr($season_id) ?>">
        <td colspan="7">
            <strong><?php echo get_the_title($season_id) ?></strong>
            ( <?php echo empty($from) ? '' : $from->format(get_option('date_format')) ?> - <?php echo empty($from) ? '' : $to->format(get_option('date_format')) ?> )
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
        <?php foreach ($days as $day_name => $label): ?>
            <td><?php _e($label, $this->car_share); ?></td>
        <?php endforeach; ?>
        <td></td>
    </tr>

    <tr id="s2c-price-<?php echo $season_id ?>" class="assigned-session-<?php echo esc_attr($season_id) ?>">
        <?php foreach ($days as $day_name => $label): ?>
            <td><?php echo isset($season_price['days'][$day_name]) ? esc_attr($season_price['days'][$day_name]) : '' ?></td>
        <?php endforeach; ?>
        <td></td>
    </tr>
    
    
    
<?php endforeach; ?>