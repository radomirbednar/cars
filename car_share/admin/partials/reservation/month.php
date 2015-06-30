<?php
$date = new DateTime();
$date->setDate($year, $month, 1);
$date->setTime(0, 0, 0);

global $wpdb;

$sql = "SELECT * FROM sc_single_car ORDER BY parent ASC";
$all_cars = $wpdb->get_results($sql);
?>

<div class="sc-month">
    <div class="sc-month-label">
        <?php echo $date->format('F'); ?> <?php echo $date->format("Y"); ?>
    </div>    
    <?php
    while ($month == $date->format('n')):


        // all cars rented for this day
        $sql = " 
                SELECT 
                    * 
                FROM 
                    sc_single_car_status 
                WHERE                     
                    (date_from BETWEEN '" . $date->format('Y-m-d 00:00:00') . "' AND '" . $date->format('Y-m-d 23:59:59') . "')
                        OR
                    ('" . $date->format('Y-m-d 00:00:00') . "' BETWEEN date_from AND date_to)";

        $result = $wpdb->get_results($sql);

        $shared_cars = array();

        foreach ($result as $r) {
            $shared_cars[$r->single_car_id] = $r;
        }
        ?>

        <div class="car-col state-col">
            <div class="day-cell day day-<?php echo $date->format("j"); ?>">
                <?php echo $date->format("j"); ?> 
            </div>    
            <?php foreach ($all_cars as $car): ?>
                <div class="day-cell car free  day-<?php echo $date->format("j"); ?>">
                    <?php if (array_key_exists($car->single_car_id, $shared_cars)): 
                        
                        $shared_car = $shared_cars[$car->single_car_id];                        
                    
                        $class = '';
                        
                        switch($shared_car->status):
                            case car_share::STATUS_RENTED:
                                $class = 'rented';
                                break;
                            case car_share::STATUS_UNAVAILABLE:
                                $class = 'unavailable';
                                break;
                            case car_share::STATUS_BOOKED:
                                $class = 'booked';
                                break;                            
                        endswitch;
                        
                        
                        $from = DateTime::createFromFormat('Y-m-d H:i:s', $shared_car->date_from);
                        $to = DateTime::createFromFormat('Y-m-d H:i:s', $shared_car->date_to);
                        
                        ?>
                    
                        <div class="car <?php echo $class ?>">
                            <div class="sc-reservation-info">
                                <div class="sc-from"><?php _e('from:', 'car_share') ?> <?php echo $from->format(SC_DATETIME_FORMAT); ?></div>
                                <div class="sc-to"><?php _e('to:', 'car_share') ?> <?php echo $to->format(SC_DATETIME_FORMAT); ?></div>
                            </div>    
                        </div>
                    
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
        $date->add(new DateInterval('P1D'));
    endwhile;
    ?>
    <div class="clear"></div>
</div>