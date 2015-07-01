<?php if (!empty($fields_to_show)): ?>
    <table>
        <?php foreach ($fields_to_show as $key => $field): ?>
            <tr>
                <td>
                    <strong><?php _e($field['label'], $this->car_share) ?>: </strong>
                </td>
                <td>
                    <?php
                    switch($field['type']):

                        case 'price':
                            echo $currency->format($field['value'], $currency_iso);
                            break;                            
                        case 'text':
                            echo isset($field['value']) ? esc_attr($field['value']) : '';
                            ?>
                            <!--<input type="text" name="<?php echo esc_attr($key) ?>" value="<?php echo isset($field['value']) ? esc_attr($field['value']) : '' ?>">-->
                            <?php
                            break;
                        case 'percentage':
                            echo esc_attr($field['value']) . ' %';
                            break;                        
                        case 'email':
                            echo isset($field['value']) ? esc_attr($field['value']) : '';
                            ?>
                            <!--<input type="email" name="<?php echo esc_attr($key) ?>" value="<?php echo isset($field['value']) ? esc_attr($field['value']) : '' ?>">-->
                            <?php
                            break;
                        case 'country':
                            $countries = sc_get_countries();
                            $country_iso = $field['value'];
                            echo isset($countries[$country_iso]) ? $countries[$country_iso] : esc_attr($country_iso);
                            break;
                        case 'title':
                            echo empty($field['value']) ? '' : get_the_title($field['value']);
                            break;                        
                        default:
                            echo empty($field['value']) ? '-' : esc_attr($field['value']);

                        /*
                        case 'cart_pick_up':
                        case 'cart_drop_off':
                        case 'cart_car_category':
                            echo empty($field['value']) ? '-' : get_the_title($field['value']);
                            break;
                        default:
                            echo empty($field['value']) ? '-' : esc_attr($field['value']);
                            */
                    endswitch;
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>