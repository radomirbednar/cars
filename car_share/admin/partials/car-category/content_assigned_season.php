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
            <a href="#" class="edit-s2c" data-season_id="<?php echo $season_id ?>" data-car_category_id="<?php echo $season_price['car_category_id'] ?>"><?php _e('Edit', $this->car_share) ?></a> | 
            <a href="#" class="remove-s2c" data-season_id="<?php echo $season_id ?>" data-car_category_id="<?php echo $season_price['car_category_id'] ?>"><?php _e('Delete', $this->car_share) ?></a>
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

<script>
    jQuery(document).ready(function ($) {
        $( ".edit-s2c" ).click(function(event) {
            event.preventDefault();                       
            tb_show('<?php _e('Edit', $this->car_share) ?>', ajaxurl + '?action=edit_season_to_category&season_id=' + $(this).data('season_id') + '&car_category_id=' + $(this).data('car_category_id')); 
        });
    });    
</script>