<?php
$days = get_days_of_week();

$days_row = '<tr>';
foreach ($days as $day_name => $label):
    $days_row .= '<td>';
    $days_row .= __($label, $this->car_share);
    $days_row .= '</td>';
endforeach;
$days_row .= '<td></td></tr>';

foreach ($season2category_prices as $season_id => $season_price):
    ?>
    <tr>
        <td colspan="7"><?php echo get_the_title($season_id) ?></td>
        <td>
            <a href="#TB_inline?width=auto&inlineId=modal-season2category&width=753&height=409" class="thickbox" data-season_id="<?php echo $season_id ?>" data-car_category_id="<?php echo $season_price['car_category_id'] ?>"><?php _e('Edit', $this->car_share) ?></a> | 
            <a href="#" class="thickbox" data-season_id="<?php echo $season_id ?>" data-car_category_id="<?php echo $season_price['car_category_id'] ?>"><?php _e('Delete', $this->car_share) ?></a>
        </td>
    </tr>
    
    <?php echo $days_row; ?>

    <tr>
    <?php foreach ($days as $day_name => $label): ?>
        <td><?php echo isset($season_price['days'][$day_name]) ? esc_attr($season_price['days'][$day_name]) : '' ?></td>
    <?php endforeach; ?>
        <td></td>
    </tr>
<?php endforeach; ?>