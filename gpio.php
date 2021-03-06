﻿<!-- This page is requested by the JavaScript, it updates the pin's status and then print it -->
<?php
	include_once '/var/www/html/log.php';
	//Getting and using values
	if (isset ($_GET["pin"]) && isset($_GET["status"]) ) {
		$pin = strip_tags($_GET["pin"]);
		$status = strip_tags($_GET["status"]);
		logToFile("define pins", $pin, $status);

		//Testing if values are numbers
		if ((is_numeric($pin)) && (is_numeric($status)) && ($pin <= 7) && ($pin >= 0) && ($status == "0") || ($status == "1") ) {

			//set the gpio's mode to output
			system("gpio mode ".$pin." out");
			logToFile("set pins", $pin, $status);

			//set the gpio to high/low
			if ($status == "0" ) {
				$status = "1";
				logToFile("set pin 0-1", $pin, $status);
			}
			else if ($status == "1" ) {
				$status = "0";
				logToFile("set pin 1-0", $pin, $status);
			}
			system("gpio write $pin $status");
			logToFile("write pins", $pin, $status);

			//reading pin's status
			exec ("gpio read ".$pin, $status, $return );

			//printing it
			logToFile( "pin status", $pin, $status[0] );
		}
		else { logToFile("fail 1",$pin,$status); }
	} //print fail if cannot use values
	else { logToFile("fail 2",'','');
	}
?>