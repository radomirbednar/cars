<table>
    <tr>
        <th><?php _e('From:', $this->car_share) ?></th>
        <td>
            <?php 
            if(!empty($from)):
                echo $from->format(get_option('date_format')); ?> <?php echo $from->format(get_option('time_format')); 
            endif;
            ?>
        </td>
        <th><?php _e('To:', $this->car_share) ?></th>
        <td>
            <?php 
            if(!empty($to)):
                echo $to->format(get_option('date_format')); ?> <?php echo $to->format(get_option('time_format')); 
            endif;
            ?>
        </td>
    </tr>    
</table>