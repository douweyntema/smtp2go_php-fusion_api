<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: smtp2go_admin.php
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
require_once "../../maincore.php";
if (!checkrights("SM2P") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../../index.php"); }
require_once THEMES."templates/admin_header.php";
include_once INCLUDES."infusions_include.php";

if (file_exists(INFUSIONS."smtp2go_api/locale/".$settings['locale'].".php")) {
	include INFUSIONS."smtp2go_api/locale/".$settings['locale'].".php";
} else { include INFUSIONS."smtp2go_api/locale/English.php"; }

if(isset($_POST['settings'])){
	$good_count = 0; $bad_count = 0;
	foreach($_POST['settings'] as $setting => $value){
		if(set_setting($setting, $value, "smtp2go_api")){ $good_count++; } else { $bad_count++; }
	}
	if (!$bad_count){
		$message = $smtp2go_locale['admin']['settings_success'];
	} else {
		$message = $smtp2go_locale['admin']['settings_problem'];
	}
}


$stay_open = false;
$smtp2go_settings = get_settings("smtp2go_api");

if(isset($message)){
	if(!$stay_open){ echo "<div id='close-message'>"; }
	echo "<div class='admin-message'>".$message."</div>";
	if(!$stay_open){ echo "</div>\n"; }
}

opentable($smtp2go_locale['admin']['settings']);
	echo "<form name='smtp2go_settings' method='post' action='".FUSION_SELF.$aidlink."' style='display:inline-block;'>";
	echo "<input type='field' class='textbox' style='width:350px;' name='settings[api_key]' placeholder='".$smtp2go_locale['admin']['api_key_placeholder']."' value='".$smtp2go_settings['api_key']."' autocomplete='off' /> ".$smtp2go_locale['admin']['api_key']."<br />";
	echo "<input type='field' class='textbox' style='width:350px;' name='settings[base_url]' placeholder='".$smtp2go_locale['admin']['base_url_placeholder']."' value='".$smtp2go_settings['base_url']."' autocomplete='off' /> ".$smtp2go_locale['admin']['base_url']."<br />";
	echo "<select name='settings[use_api]' class='textbox' style='width:80px;'>\n";
    echo "<option value='1'".($smtp2go_settings['use_api'] == 1 ? " selected='selected'" : "").">".$smtp2go_locale['admin']['use_api_yes']."</option>\n";
    echo "<option value='0'".($smtp2go_settings['use_api'] == 0 ? " selected='selected'" : "").">".$smtp2go_locale['admin']['use_api_no']."</option>\n";
    echo "</select>".$smtp2go_locale['admin']['use_api_title']."<br>";
	echo "<input type='submit' name='Submit' value='".$smtp2go_locale['admin']['submit']."' class='button' />";
	echo "</form>";
closetable();

require_once THEMES."templates/footer.php";
?>