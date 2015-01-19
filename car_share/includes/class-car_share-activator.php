<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Car_share
 * @subpackage Car_share/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Car_share
 * @subpackage Car_share/includes
 * @author     My name <mail@example.com>
 */
class Car_share_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            
            global $wpdb;
            
            // define tables for plugin
            $sql = "

                CREATE TABLE IF NOT EXISTS `day_prices` (
                  `car_category_id` bigint(20) NOT NULL,
                  `season_id` bigint(20) NOT NULL,
                  `dayname` char(10) NOT NULL,
                  `price` decimal(10,2) NOT NULL,
                  PRIMARY KEY (`car_category_id`,`season_id`,`dayname`),
                  KEY `season_id` (`season_id`),
                  KEY `dayname` (`dayname`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `opening_hours` (
                  `location_id` bigint(20) unsigned NOT NULL,
                  `dayname` char(10) NOT NULL,
                  `open_from` time NOT NULL,
                  `open_to` time NOT NULL,
                  `open` tinyint(1) NOT NULL,
                  `dayindex` tinyint(4) NOT NULL,
                  PRIMARY KEY (`location_id`,`dayname`),
                  KEY `open` (`open`),
                  KEY `dayindex` (`dayindex`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;            


                CREATE TABLE IF NOT EXISTS `postmeta_date` (
                  `post_id` bigint(20) unsigned NOT NULL,
                  `meta_key` varchar(60) NOT NULL,
                  `meta_value` datetime NOT NULL,
                  PRIMARY KEY (`post_id`,`meta_key`),
                  KEY `meta_key` (`meta_key`),
                  KEY `meta_value` (`meta_value`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                

                CREATE TABLE IF NOT EXISTS `sc_single_car` (
                  `single_car_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `parent` bigint(20) unsigned NOT NULL,
                  `spz` varchar(160) NOT NULL,
                  PRIMARY KEY (`single_car_id`),
                  UNIQUE KEY `single_car_id_2` (`single_car_id`,`parent`),
                  KEY `parent` (`parent`),
                  KEY `spz` (`spz`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
                
                CREATE TABLE IF NOT EXISTS `sc_single_car_location` (
                  `single_car_location_id` bigint(20) NOT NULL AUTO_INCREMENT,
                  `single_car_id` bigint(20) unsigned NOT NULL,
                  `location_id` bigint(20) unsigned NOT NULL,
                  `location_type` tinyint(1) NOT NULL COMMENT '1 - pick up / 2 drop off',
                  PRIMARY KEY (`single_car_location_id`),
                  KEY `single_car_id` (`single_car_id`,`location_id`,`location_type`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
                
                CREATE TABLE IF NOT EXISTS `sc_single_car_status` (
                  `single_car_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `single_car_id` bigint(20) unsigned NOT NULL,
                  `booking_id` bigint(20) DEFAULT NULL,
                  `date_from` datetime NOT NULL,
                  `date_to` datetime NOT NULL,
                  `status` tinyint(1) NOT NULL,
                  PRIMARY KEY (`single_car_status_id`),
                  KEY `single_car_id` (`single_car_id`,`date_from`,`date_to`,`status`),
                  KEY `booking_id` (`booking_id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

            ";
            
            //reference to upgrade.php file
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );      
            dbDelta( $sql );
	}

}
