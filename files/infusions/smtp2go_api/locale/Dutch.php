<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: Dutch.php
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

//Generic
$smtp2go_locale['inf_title'] = "SMTP2GO API Interface";
$smtp2go_locale['inf_desc'] = "Send email via SMTP2GO API interface";

//Infuse
$smtp2go_locale['infuse']['title'] = $smtp2go_locale['inf_title']." geinfuseerd";

//Defuse
$smtp2go_locale['defuse']['title'] = $smtp2go_locale['inf_title']." gedefuseerd";

//Admin Page
$smtp2go_locale['admin']['settings_success'] = "Instellingen succesvol opgeslagen.";
$smtp2go_locale['admin']['settings_problem'] = "Er is een probleem met het opslaan van de instellingen.";
$smtp2go_locale['admin']['settings'] = $smtp2go_locale['inf_title']." Instellingen";
$smtp2go_locale['admin']['base_url_placeholder'] = "Het basispad naar het eindpunt van de API";
$smtp2go_locale['admin']['api_key'] = "API Key";
$smtp2go_locale['admin']['api_key_placeholder'] = "Vul je API key van SMTP2GO";
$smtp2go_locale['admin']['base_url'] = "Base URL";
$smtp2go_locale['admin']['use_api_title'] = "API Inschakelen?";
$smtp2go_locale['admin']['use_api_yes'] = "Ja";
$smtp2go_locale['admin']['use_api_no'] = "Nee";
$smtp2go_locale['admin']['submit'] = "Opslaan";
	
?>