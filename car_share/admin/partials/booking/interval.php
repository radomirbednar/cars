<table>
    <tr>
        <th><?php _e('From:', $this->car_share) ?></th>
        <td>
            <?php 
            if(!empty($booking->from())):
                echo $booking->from()->format(get_option('date_format')); ?> <?php echo $booking->from()->format(get_option('time_format')); 
            endif;
            ?>
        </td>
        <th><?php _e('To:', $this->car_share) ?></th>
        <td>
            <?php 
            if(!empty($booking->to())):
                echo $booking->to()->format(get_option('date_format')); ?> <?php echo $booking->to()->format(get_option('time_format')); 
            endif;
            ?>
        </td>
    </tr>    
</table>