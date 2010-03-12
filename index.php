<?php

/**
 * Project:     organization-budget-and-finance
 * File:        index.php
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

include_once("./configs/config.php");
require_once($_CONFIG['smarty']);
include_once("./common/include.index.php");


// Smarty
$smarty = new Smarty;
$smarty->compile_check = true;
//$smarty->debugging = true;
$smarty->assign("pagename", "");


// Process the page
if(!isset($_GET['page'])){
	/*******************************************************************************************************
	 * Main page
	 ******************************************************************************************************/
	$smarty->display('index.tpl');
}
else if($_GET['page'] == "budget"){
	/*******************************************************************************************************
	 * Budget page
	 ******************************************************************************************************/
	$parent = 1;
	if(isset($_GET['line'])){
		$parent = intval($_GET['line']);
		if($parent == 0){
			$parent = 1;
		}
	}
	
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("receipts", getReceiptForLineItem($parent));
	$smarty->assign("funds", getFundsForLineItem($parent));
	$smarty->assign("sources",getSourcesForLineItems($parent));
	$smarty->assign("children", getCompleteLineItemChildren($parent));
	$smarty->display('budget.tpl');
}
else if($_GET['page'] == "editbudget"){
	/*******************************************************************************************************
	 * Edit Budget page
	 ******************************************************************************************************/
	$parent = 1;
	if(isset($_GET['line'])){
		$parent = intval($_GET['line']);
		if($parent == 0){
			$parent = 1;
		}
	}
	
	$smarty->display('editbudget.tpl');
}

?>