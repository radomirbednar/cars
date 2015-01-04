<?php
var_dump($_POST);

$car = isset($_POST['car']) ? get_the_title($_POST['car']) : '';

$pick_up_loation = isset($_POST['pick_up_location']) ? get_the_title($_POST['pick_up_location']) : '';
$drop_off_location = isset($_POST['drop_off_location']) ? get_the_title($_POST['drop_off_location']) : '';

$date_from = isset($_POST['car_datefrom']) ? esc_attr($_POST['car_datefrom']) : '';
$date_to = isset($_POST['car_dateto']) ? esc_attr($_POST['car_dateto']) : '';

$hour_to = isset($_POST['car_hoursfrom']) ? esc_attr($_POST['car_hoursfrom']) : '';
$hour_from = isset($_POST['car_hoursto']) ? esc_attr($_POST['car_hoursto']) : '';
?>

<form action="" method="post">

    <table>
        <tbody>
            <tr>
                <td><?php _e('Car: ', $this->car_share); ?></td>
                <td><?php echo $car ?></td>
            </tr>
            <tr>
                <td><?php _e('Pick up loation: ', $this->car_share); ?></td>
                <td><?php echo $pick_up_loation ?></td>
            </tr>
            <tr>
                <td><?php _e('Drop off location: ', $this->car_share); ?></td>
                <td><?php echo $drop_off_location ?></td>
            </tr>
            <tr>
                <td><?php _e('From date: ', $this->car_share); ?></td>
                <td><?php echo $date_from ?> <?php echo $hour_from ?></td>
            </tr>        
            <tr>
                <td><?php _e('To date: ', $this->car_share); ?></td>
                <td><?php echo $date_to ?> <?php echo $hour_to ?></td>
            </tr>        
            <tr>
                <td><?php _e('Extras: ', $this->car_share); ?></td>
                <td>
                    <?php if (!empty($_POST['service'])): ?>
                        <?php foreach ($_POST['service'] as $service_id): ?>
                            <?php echo get_the_title($service_id) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
            </tr>        
        </tbody>
    </table>
    
    <button type="submit" class="btn btn-default"><?php _e('Book car', $this->car_share); ?></button>

    <input type="hidden" name="car" value="<?php echo isset($_POST["car"]) ? esc_attr($_POST["car"]) : '' ?>">
    <input type="hidden" name="pick_up_location" value="<?php echo isset($_POST["pick_up_location"]) ? esc_attr($_POST["pick_up_location"]) : '' ?>">
    <input type="hidden" name="drop_off_location" value="<?php echo isset($_POST["pick_up_location"]) ? esc_attr($_POST["pick_up_location"]) : '' ?>">
    <input type="hidden" name="car_datefrom" value="<?php echo isset($_POST["car_datefrom"]) ? esc_attr($_POST["car_datefrom"]) : '' ?>">
    <input type="hidden" name="car_hoursfrom" value="<?php echo isset($_POST["car_hoursfrom"]) ? esc_attr($_POST["car_hoursfrom"]) : '' ?>">
    <input type="hidden" name="car_dateto" value="<?php echo isset($_POST["car_dateto"]) ? esc_attr($_POST["car_dateto"]) : '' ?>">
    <input type="hidden" name="car_hoursto" value="<?php echo isset($_POST["car_hoursto"]) ? esc_attr($_POST["car_hoursto"]) : '' ?>">
    <input type="hidden" name="car_category" value="<?php echo isset($_POST["car_category"]) ? esc_attr($_POST["car_category"]) : '' ?>">    

</form>