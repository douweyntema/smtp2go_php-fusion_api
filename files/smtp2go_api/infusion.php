<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: Douwe Yntema
| Copyright 2021 hulpteugel.nl
+--------------------------------------------------------+
| This integrates the sending via AMTP2GO API into
| PHP-Fusion.
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

if (!defined("IN_FUSION")) { die("Access Denied"); } //No outside access...
require_once INCLUDES."infusions_include.php"; //for... stuff
$smtp2go_settings = get_settings("smtp2go_api"); //Grab settings from local DB if possible

if (file_exists(INFUSIONS."smtp2go_api/locale/".$settings['locale'].".php")) {
	include INFUSIONS."smtp2go_api/locale/".$settings['locale'].".php";
} else { include INFUSIONS."smtp2go_api/locale/English.php"; }

// Infusion general information
$inf_title = $smtp2go_locale['inf_title'];
$inf_description = $smtp2go_locale['inf_desc'];
$inf_version = "1.0";
$inf_developer = "D. Yntema";
$inf_email = "beheerder@hulpteugel.nl";
$inf_weburl = "https://www.hulpteugel.nl";
$inf_folder = "smtp2go_api";

//Infuse///////////////////////////////////////////////////////////////
$inf_insertdbrow[1] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('api_key', '12345', '".$inf_folder."')";
$inf_insertdbrow[2] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('base_url', 'https://api.smtp2go.com/v3/', '".$inf_folder."')";
$inf_insertdbrow[3] = DB_SETTINGS_INF." (settings_name, settings_value, settings_inf) VALUES('use_api', '0', '".$inf_folder."')";

//set the admin panel options
$inf_adminpanel[1] = array(
	"title" => $inf_title,
	"image" => "../../infusions/smtp2go_api/smtp2go.png",
	"panel" => "smtp2go_admin.php",
	"rights" => "SM2P"
);

//Defuse///////////////////////////////////////////////////////////////


$inf_deldbrow[1] = DB_SETTINGS_INF." WHERE settings_inf='".$inf_folder."'";

?>
