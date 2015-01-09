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
    function getItemPrice($car_category) {
     
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