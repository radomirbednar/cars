<?php 
 
class Car_Cart {
     
    private $cart_name;       // The name of the cart/session variable
    private $items = array(); // The array for storing items in the cart
  
    /**
     * __construct() - Constructor. This assigns the name of the cart
     *                 to an instance variable and loads the cart from
     *                 session.
     *
     * @param string $name The name of the cart.
     */
    function __construct($name) {       
        $hash=sha1('whatsthecallme063214056*'); 
        $this->cart_name = $name.$hash; 
        $this->items = empty($_SESSION[$this->cart_name]) ? array() : $_SESSION[$this->cart_name];    
    }
     
    /**
     * setItemQuantity() - Set the quantity of an item.
     *
     * @param string $order_code The order code of the item.
     * @param int $quantity The quantity.
     */
    function setItemSearch($pick_up_location, $drop_off_location, $car_datefrom, $car_dateto, $car_category) { 
        $this->items['pick_up_location'] = $pick_up_location;
        $this->items['drop_off_location'] = $drop_off_location;
        $this->items['car_datefrom'] = $car_datefrom;
        $this->items['car_dateto'] = $car_dateto;
        $this->items['car_category'] = $car_category;    
    }
     
    function getItemSearch(){    
        return $this->items;  
    }
 
    /**
     * getItemPrice() - Get the price of an item.
     *
     * @param string $order_code The order code of the item.
     * @return int The price.
     */
   
        
    function sc_get_price($single_car_id, DateTime $from, DateTime $to) {        
        
        global $wpdb; 
        
        $car_id = $wpdb->get_var("SELECT parent FROM sc_single_car WHERE single_car_id = '" . (int) $single_car_id . "'");
        
        $day_interval = DateInterval::createFromDateString('1 day'); 
        $period = new DatePeriod($from, $day_interval, $to);
        $diff = $to->diff($from);
        $days = $diff->days;

        $category_id = (int)get_post_meta($car_id, '_car_category', true); 
        /**
         *
         */
        if (empty($category_id)) {
            // auto nema kategorii, nemam ceny
        }

        $car_category = new sc_Category($category_id);
        $category_prices = $car_category->day_prices_indexed_with_dayname();

        // find all assigned season
        $sql = "SELECT
                    ID,
                    start.meta_value as date_from,
                    end.meta_value as date_to
                FROM
                    $wpdb->posts s
                JOIN
                    postmeta_date start ON s.ID = start.post_id AND start.meta_key = '_from'
                JOIN
                    postmeta_date end ON s.ID = end.post_id AND end.meta_key = '_to'
                JOIN
                    day_prices dp ON dp.season_id = s.ID AND car_category_id = '" . (int) $category_id . "'
                WHERE
                    s.post_status = 'publish' AND s.post_type='sc-season'
                AND
                (
                    (start.meta_value BETWEEN '" . $from->format('Y-m-d  H:i:s') . "' AND '" . $to->format('Y-m-d  H:i:s') . "')
                        OR
                    ('" . $from->format('Y-m-d  H:i:s') . "' BETWEEN start.meta_value AND end.meta_value)
                )
                GROUP BY s.ID
                ";

        $seasons = $wpdb->get_results($sql);

        $applied_sessions = array();
        foreach ((array) $seasons as $session) {
            $begin = DateTime::createFromFormat('Y-m-d H:i:s', $session->date_from . ' 00:00:00');
            $end = DateTime::createFromFormat('Y-m-d H:i:s', $session->date_to . ' 23:59:59');        

            $season_prices = $car_category->day_prices_indexed_with_dayname($session->ID);

            $applied_sessions[] = array(
                'start' => $begin,
                'end' => $end,
                'prices' => $season_prices
            );
        }

        $total_price = 0;

        foreach ($period as $day) {

            // find out if day belongs to some season
            $day_name = $day->format("l");

            $day_price = 0;
            $mam = false;

            foreach ($applied_sessions as $applied_season) {
                if (($applied_season['start'] < $day) && ($day < $applied_season['end'])) {
                    $mam = true;
                    $day_price = isset($applied_season['prices'][$day_name]) ? $applied_season['prices'][$day_name] : 0;
                }
            }

            if ($mam == false) {
                if (isset($category_prices[$day_name])) {
                    $day_price = isset($category_prices[$day_name]) ? $category_prices[$day_name] : 0;
                }
            }

            $total_price += floatval($day_price);
        }

        // apply time discount
        $time_discount = get_post_meta($category_id, '_discount_upon_duration', true);

        $discount = 0;
        if (!empty($time_discount)) {
            ksort($time_discount);
            foreach ($time_discount as $key => $val) {
                if ($key < $days) {
                    $discount = $val;
                } else {
                    break;
                }
            }
        }

        //
        if ($discount > 0) {
            $total_price = $total_price - $total_price * $discount / 100;
        } 
        //
        return $total_price;
    }
        
     
     
    /**
     * getItemName() - Get the name of an item.
     *
     * @param string $order_code The order code of the item.
     */ 
    function setItemId($id_code) { 
        $this->items['car_ID'] = $id_code;    
    }  
    function setItemService($service) { 
       $this->items['service'] = $service;      
    }
   
    /**
     * getItems() - Get all items.
     *
     * @return array The items.
     */
    function getItems() {
        return $this->items; 
    } 
    /**
     * hasItems() - Checks to see if there are items in the cart.
     *
     * @return bool True if there are items.
     */
    function hasItems() {
        return (bool) $this->items;
    } 
    /**
     * getItemQuantity() - Get the quantity of an item in the cart.
     *
     * @param string $order_code The order code.
     * @return int The quantity.
     */
    function getItemQuantity($order_code) {
        return (int) $this->items[$order_code];
    } 
    /**
     * clean() - Cleanup the cart contents. If any items have a
     *           quantity less than one, remove them.
     */
    function clean() {
        
        foreach ( $this->items as $order_code=>$quantity ) {
            if ( $quantity < 1 )
                unset($this->items[$order_code]);
        }
    } 
    /**
     * save() - Saves the cart to a session variable.
     */
    function save() { 
        $_SESSION[$this->cart_name] = $this->items;
    } 
} 