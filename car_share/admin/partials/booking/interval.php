<table>
    <tr>
        <td><strong><?php _e('From:', $this->car_share) ?></strong></td>
        <td>
            <?php
            if (!empty($booking->from())):
                echo $booking->from()->format(get_option('date_format'));                
                echo $booking->from()->format(get_option('time_format'));
            endif;
            ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php _e('To:', $this->car_share) ?></strong></td>
        <td>
            <?php
            if (!empty($booking->to())):
                echo $booking->to()->format(get_option('date_format'));                
                echo $booking->to()->format(get_option('time_format'));
            endif;
            ?>
        </td>
    </tr>    
</table>
<hr>