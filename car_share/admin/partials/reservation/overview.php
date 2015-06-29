<?php
global $wpdb;

$date = new DateTime();
$date->setDate($year, $month, 1);
$date->setTime(0, 0, 0);

$temp_date = clone $date;

$next_month = new DateTime();
$next_month->modify('first day of next month');

$prev_month = new DateTime();
$prev_month = new DateTime('last day of last month');

$sql = "SELECT * FROM sc_single_car ORDER BY parent ASC";
$all_cars = $wpdb->get_results($sql);
?>


<div id="reservation" class="sc-reservation">

    <div class="overview">
        <div class="loader">
            <div id="fountainG">
                <div id="fountainG_1" class="fountainG">
                </div>
                <div id="fountainG_2" class="fountainG">
                </div>
                <div id="fountainG_3" class="fountainG">
                </div>
                <div id="fountainG_4" class="fountainG">
                </div>
                <div id="fountainG_5" class="fountainG">
                </div>
                <div id="fountainG_6" class="fountainG">
                </div>
                <div id="fountainG_7" class="fountainG">
                </div>
                <div id="fountainG_8" class="fountainG">
                </div>
            </div> 
        </div>
    </div>


    <div class="car-list car-col">
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


    <div id="sc-months" class="sc-months">

    </div>


    <div class="clear"></div>
</div>    

<script>
    jQuery(document).ready(function ($) {

        function load_months(year, month) {

            $.ajax({
                type: 'post',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    'action': 'load_months',
                    'year': year,
                    'month': month
                },
                beforeSend: function () {
                    //self.prop("disabled", true);
                    $('#reservation .overview').show();
                }
            }).done(function (ret) {
                $('#sc-months').html(ret);
            }).fail(function (ret) {

            }).always(function () {
                $('#reservation .overview').hide();
            });
        }

<?php
$now = new DateTime();
?>
        load_months(<?php echo $now->format('Y') ?>, <?php echo $now->format('n') ?>);

        $(".reservation").on("click", "#sc-navigation a", function (e) {
            e.preventDefault();
            load_months($(this).data('year'), $(this).data('month'));
        });

    });
</script>