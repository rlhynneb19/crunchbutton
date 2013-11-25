<?php

class Controller_tests_hours extends Crunchbutton_Controller_Account {
	public function init() {
		$restaurant = new Restaurant($_REQUEST['r'] ? intval($_REQUEST['r']) : 1);
		// echo '<pre>';var_dump( $restaurant->timezone );exit();
		$now = new DateTime( 'now ', new DateTimeZone($restaurant->timezone));
		$now = $now->format('Y-m-d H:i:s');
		if (!$_REQUEST['t'] || $_REQUEST['t'] == 'NOW') {
			$time = $now;
			c::view()->now = true;
		} else {
			$time = $_REQUEST['t'];
		}
		c::view()->restaurant = $restaurant;
		c::view()->open = $restaurant->open($time);
		c::view()->time = new DateTime( $time, new DateTimeZone( $restaurant->timezone ) );
		c::view()->time->setTimezone( new DateTimeZone( $restaurant->timezone ) );
		c::view()->display('tests/hours/index');
	}
}