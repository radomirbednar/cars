<?php if (!empty($fields_to_show)): ?>
    <table>
        <?php foreach ($fields_to_show as $key => $field): ?>
            <tr>
                <td>
                    <strong><?php _e($field['label'], $this->car_share) ?>: </strong>
                </td>
                <td>
                    <?php 
                    switch($key): 
                        case 'cart_pick_up':
                        case 'cart_drop_off':
                        case 'cart_car_category':    
                            echo get_the_title($field['value']);
                            break;
                        default:
                            echo empty($field['value']) ? '-' : esc_attr($field['value']);
                    endswitch; 
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>