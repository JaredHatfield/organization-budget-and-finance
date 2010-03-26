<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.index.php
 *
 * organization-budget-and-finance is free software: you can redistribute
 * it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the 
 * License, or (at your option) any later version.
 * 
 * organization-budget-and-finance is distributed in the hope that it 
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied 
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with organization-budget-and-finance.  If not, see 
 * http://www.gnu.org/licenses/.
 *
 * @link http://code.google.com/p/organization-budget-and-finance/
 * @copyright 2010 Speed School Student Council
 * @author Jared Hatfield
 * @package organization-budget-and-finance
 * @version 1.0
 */

include_once("./common/class.database.php");
include_once("./common/include.lineitem.php");
include_once("./common/include.receipt.php");
include_once("./common/include.funds.php");
include_once("./common/include.company.php");
include_once("./common/include.source.php");
include_once("./common/include.dropdowns.php");
include_once("./common/include.process.php");
include_once("./common/include.user.php");
include_once("./common/include.admin.php");
include_once("./common/include.search.php");
include_once("./common/include.export.php");
include_once("./common/include.form.protect.php");
include_once("./common/include.permissions.php");

$database = new database($_CONFIG);

/// Gets a numeric value from one of the URL parameters.  Converts field to an int, it cannot return zero, defaults to -1 if nothing is set.
function getPageId($field){
	$id = -1;
	if(isset($_GET[$field])){
		$id = intval($_GET[$field]);
		if($id == 0){
			$id = -1;
		}
	}
	
	return $id;
}

/// Determine if recaptcha is enabled
function isRecaptchaEnabled(){
	global $_CONFIG;
	if(isset($_CONFIG['recaptcha_public']) &&
		strlen($_CONFIG['recaptcha_public']) > 0 &&
		isset($_CONFIG['recaptcha_private']) &&
		strlen($_CONFIG['recaptcha_private'])){
		return true;
	}
	else{
		return false;
	}
}

function smarty_block_dynamic($param, $content, &$smarty) {
	return $content;
}

function pageNotFound(){
	header("HTTP/1.0 404 Not Found");
	exit;
}

function pageForbidden(){
	header("HTTP/1.0 403 Forbidden");
	exit;
}

?>