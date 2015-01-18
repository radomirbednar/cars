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
                            echo esc_attr($field['value']);
                            break;
                        case 'status':
                            if($field['value']==1)
                            {
                                echo 'Completed'; 
                            }
                            elseif($field['value']==2)
                            {
                                echo 'Pending';
                                
                            }
                            elseif($field['value']==3)
                            {
                                echo 'Failed';
                                
                            }    
                        
                    endswitch;
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>