<table>
    <tr>
        <td><strong><?php _e('From:', $this->car_share) ?></strong></td>
        <td>
            <?php
            
              $booking_from = $booking->from();

            if (!empty($booking_from)):
                echo $booking_from->format(SC_DATETIME_FORMAT);
                //echo $booking_from->format(SC_DATE_FORMAT);
            endif;
            ?>
        </td>
    </tr>
    <tr>
        <td><strong><?php _e('To:', $this->car_share) ?></strong></td>
        <td>
            <?php
            
            $booking_to = $booking->to();

            if (!empty($booking_to)):
                echo $booking_to->format(SC_DATETIME_FORMAT);
                //echo $booking_to->format(get_option('time_format'));
            endif;
            ?>
        </td>
    </tr>
</table>