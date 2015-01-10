<?php 




if(isset($_POST['sc-checkout']))
{
 
$sc_options = get_option('sc-pages');
$extras_car_url = isset($sc_options['checkout']) ? get_page_link($sc_options['checkout']) : '';
 

 
 
 