<?php


$current_month = new DateTime();

$next_month = new DateTime();
$next_month->modify( 'first day of next month' );

$this->overview($current_month->format('Y'), $current_month->format('n'));