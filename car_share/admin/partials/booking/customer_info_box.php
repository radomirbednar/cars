<?php if (!empty($fields_to_show)): ?>
    <table>
        <?php foreach ($fields_to_show as $field): ?>
            <tr>
                <td>
                    <strong><?php _e($field['label'], $this->car_share) ?>: </strong>
                </td>
                <td>
                    <?php echo esc_attr($field['value']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>