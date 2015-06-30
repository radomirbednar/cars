<?php
$date = new DateTime();
$date->setDate($year, $month, 1);
$date->setTime(0, 0, 0);

global $wpdb;

$sql = "
    SELECT
        *
    FROM
        sc_single_car as sc
    LEFT JOIN
        " . $wpdb->postmeta . " as m
    ON
        m.post_id = sc.parent AND m.meta_key = '_car_category'
    LEFT JOIN
        " . $wpdb->posts . " as cat
    ON
        cat.ID = m.meta_value
        ";

if (!empty($form_data['sc_spz'])) {

    $sql .= "
        WHERE
            spz LIKE '%" . esc_sql(trim($form_data['sc_spz'])) . "%'
    ";
}


$order = "ASC";

if (isset($form_data['sc-order']) && 'desc' == $form_data['sc-order']) {
    $order = "DESC";
}

$sql .= "
        GROUP BY
            sc.single_car_id
        ORDER BY
            cat.post_title
        $order
        ";


$all_cars = $wpdb->get_results($sql);
?>


<?php if ($show_cars): ?>
    <div class="car-list car-col">

        <div id="sc-car-sorting" class="sc-car-sorting">
            <?php _e('Sort category:', 'car_share') ?>
            <a id="sc-cat-up" data-order="asc" class="asc" href="#"><span class="sorting-indicator"></span></a>
            <a id="sc-cat-down" data-order="desc" class="desc" href="#"><span class="sorting-indicator"></span></a>
        </div>

        <?php foreach ($all_cars as $car): ?>
            <div class="car-label car-<?php echo esc_attr($car->single_car_id) ?>">
                <span class="car-category">
                    <?php echo get_the_title(get_post_meta($car->parent, '_car_category', true)) ?>
                </span>
                |
                <span class="car-name">
                    <a href="<?php echo admin_url('post.php?post=' . $car->parent . '&action=edit') ?>">
                        <?php echo get_the_title($car->parent) ?>
                    </a>
                </span>
                |
                <span class="sc-spz">
                    <?php echo esc_attr($car->spz) ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>



<div class="sc-month">
    <div class="sc-month-label">
        <?php
        //echo $date->format('F');

        echo date_i18n("F", $date->getTimestamp());

        echo ' ' . $date->format("Y");
        ?>
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
                <a href="#" class="day-cell car free  day-<?php echo $date->format("j"); ?>">
                    <?php
                    if (array_key_exists($car->single_car_id, $shared_cars)):

                        $shared_car = $shared_cars[$car->single_car_id];

                        $class = '';

                        switch ($shared_car->status):
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
                </a>
            <?php endforeach; ?>
        </div>

        <?php
        $date->add(new DateInterval('P1D'));
    endwhile;
    ?>
    <div class="clear"></div>
</div>