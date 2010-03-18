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
 * @author Cristina Heisler
 * @package organization-budget-and-finance
 * @version 1.0
 */

session_start();
include_once("./configs/config.php");
require_once($_CONFIG['smarty']);
include_once("./common/include.index.php");


// Smarty
$smarty = new Smarty;
$smarty->compile_check = true;
//$smarty->debugging = true;
$smarty->assign("pagename", "");


// Authentication and permission logic
// TODO: Authenticate the user
$permissions = getUserPermissions();
$smarty->assign("permissions", $permissions);


// Navigation higherarchy
$nav[] = Array("page" => "home", "parms" => "", "text" => "Home");

// Process the page
if(!isset($_GET['page']) || $_GET['page'] == "home"){
	/*******************************************************************************************************
	 * Main page
	 ******************************************************************************************************/
	$smarty->assign("nav", $nav);
	$smarty->display('index.tpl');
}
else if($_GET['page'] == "process"){
	/*******************************************************************************************************
	 * Process a submitted form
	 ******************************************************************************************************/
	$url = process($smarty);
	$smarty->assign("url", $url);
	$smarty->display('redirect.tpl');
}
else if($_GET['page'] == "budget"){
	/*******************************************************************************************************
	 * Budget page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	
	if($parent == -1 && isset($_GET['lineid'])){
		// An invalid page was found, so we want to redirect to the main page
		$smarty->assign("url","./index.php?page=budget");
		$smarty->display('redirect.tpl');
		exit();
	}
	else if($parent == -1){
		// Display the main page
		$parent = 1;
	}
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($parent) || ($permissions['publicOnly'] && isLineItemPrivate($parent))){
		pageNotFound();
	}
	
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("receipts", getReceiptForLineItem($parent, $permissions['publicOnly']));
	$smarty->assign("funds", getFundsForLineItem($parent, $permissions['publicOnly']));
	$smarty->assign("sources",getSourcesForLineItems($parent, $permissions['publicOnly']));
	$smarty->assign("children", getCompleteLineItemChildren($parent, $permissions['publicOnly']));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$smarty->assign("nav", $nav);
	$smarty->display('budget.tpl');
}
else if($_GET['page'] == "lineitemAdd"){
	/*******************************************************************************************************
	 * Add lineitem page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($parent) || ($permissions['publicOnly'] && isLineItemPrivate($parent))){
		pageNotFound();
	}
	
	$smarty->assign("lineitemParent", getLineItem($parent));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$nav[] = Array("page" => "lineitemAdd", "parms" => "lineid=".$parent, "text" => "Add Line Item");
	$smarty->assign("nav", $nav);
	$smarty->display('lineitemAdd.tpl');
}
else if($_GET['page'] == "lineitemEdit"){
	/*******************************************************************************************************
	 * Edit lineitem page
	 ******************************************************************************************************/
	$lineitemid = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($lineitemid) || ($permissions['publicOnly'] && isLineItemPrivate($lineitemid))){
		pageNotFound();
	}
	
	$lineiteminfo = getLineItem($lineitemid);
	$smarty->assign("id", $lineitemid);
	$smarty->assign("lineitem", $lineiteminfo);
	$smarty->assign("lineitemCount", getLineItemUseCount($lineitemid));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($lineiteminfo['parent']));
	$name = "Edit Line Item (".$lineiteminfo['name'].")";
	if($lineiteminfo['public'] == 0){
		$name .= "*";
	}
	$nav[] = Array("page" => "lineitemEdit", "parms" => "lineid=".$lineitemid, "text" => $name);
	$smarty->assign("nav", $nav);
	$smarty->display('lineitemEdit.tpl');
}
else if($_GET['page'] == "receiptAdd"){
	/*******************************************************************************************************
	 * Add receipt page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($parent) || ($permissions['publicOnly'] && isLineItemPrivate($parent))){
		pageNotFound();
	}
	
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("company_selections", getCompanySelections());
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$nav[] = Array("page" => "receiptAdd", "parms" => "lineid=".$parent, "text" => "Add Receipt");
	$smarty->assign("nav", $nav);
	$smarty->display('receiptAdd.tpl');
}
else if($_GET['page'] == "receiptEdit"){
	/*******************************************************************************************************
	 * Edit receipt page
	 ******************************************************************************************************/
	$receiptid = getPageId('receiptid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isReceipt($receiptid) || ($permissions['publicOnly'] && isReceiptPrivate($receiptid))){
		pageNotFound();
	}
	
	$receiptinfo = getReceipt($receiptid);
	$smarty->assign("id", $receiptid);
	$smarty->assign("receipt",$receiptinfo);
	$smarty->assign("lineitem", getLineItem($receiptinfo['lineitem']));
	$smarty->assign("company_selections", getCompanySelections());
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($receiptinfo['lineitem']));
	$name = "Edit Receipt (" . $receiptinfo['name'] . ")";
	if($receiptinfo['public'] == 0){
		$name .= "*";
	}
	$nav[] = Array("page" => "receiptEdit", "parms" => "receiptid=".$receiptid, "text" => $name);
	$smarty->assign("nav", $nav);
	$smarty->display('receiptEdit.tpl');
}
else if($_GET['page'] == "fundsAdd"){
	/*******************************************************************************************************
	 * Add funds page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($parent) || ($permissions['publicOnly'] && isLineItemPrivate($parent))){
		pageNotFound();
	}
	
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("source_selections", getSourceSelections($parent, 0, $permissions['publicOnly']));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$nav[] = Array("page" => "fundsAdd", "parms" => "lineid=".$parent, "text" => "Add Funds");
	$smarty->assign("nav", $nav);
	$smarty->display('fundsAdd.tpl');
}
else if($_GET['page'] == "fundsEdit"){
	/*******************************************************************************************************
	 * Edit funds page
	 ******************************************************************************************************/
	$fundsid = getPageId('fundsid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isFund($fundsid) || ($permissions['publicOnly'] && isFundPrivate($fundsid))){
		pageNotFound();
	}
	
	$fundinfo = getFund($fundsid);
	$sourceinfo = getSourceInformation($fundinfo['source']);
	$smarty->assign("id", $fundsid);
	$smarty->assign("funds", $fundinfo);
	$smarty->assign("source", $sourceinfo);
	$smarty->assign("lineitem", getLineItem($fundinfo['lineitem']));
	$smarty->assign("source_selections", getSourceSelections($fundinfo['lineitem'], $fundsid, $permissions['publicOnly']));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($fundinfo['lineitem']));
	$name = "Edit Funds (".$sourceinfo['name'].")";
	if($sourceinfo['public'] == 0){
		$name .= "*";
	}
	$nav[] = Array("page" => "fundsEdit", "parms" => "fundsid=".$fundsid, "text" => $name);
	
	$smarty->assign("nav", $nav);
	$smarty->display('fundsEdit.tpl');
}
else if($_GET['page'] == "company"){
	/*******************************************************************************************************
	 * company page
	 ******************************************************************************************************/
	$smarty->assign("companies", getAllCompanies());
	$nav[] = Array("page" => "company", "parms" => "", "text" => "Companies");
	$smarty->assign("nav", $nav);
	$smarty->display('company.tpl');
}
else if($_GET['page'] == "companyAdd"){
	/*******************************************************************************************************
	 * Add company page
	 ******************************************************************************************************/
	$nav[] = Array("page" => "company", "parms" => "", "text" => "Companies");
	$nav[] = Array("page" => "companyAdd", "parms" => "", "text" => "Add Company");
	$smarty->assign("nav", $nav);
	$smarty->display('companyAdd.tpl');
}
else if($_GET['page'] == "companyEdit"){
	/*******************************************************************************************************
	 * Edit company page
	 ******************************************************************************************************/
	$companyid = getPageId('companyid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isCompany($companyid)){
		pageNotFound();
	}
	
	$companyinfo = getCompanyInformation($companyid);
	$smarty->assign("id", $companyid);
	$smarty->assign("company", $companyinfo);
	$smarty->assign("companyCount", getCompanyUseCount($companyid));
	$nav[] = Array("page" => "company", "parms" => "", "text" => "Companies");
	$nav[] = Array("page" => "companyEdit", "parms" => "companyid=".$companyid, "text" => "Edit Company (".$companyinfo['name'].")");
	$smarty->assign("nav", $nav);
	$smarty->display('companyEdit.tpl');
}
else if($_GET['page'] == "source"){
	/*******************************************************************************************************
	 * source page
	 ******************************************************************************************************/
	$smarty->assign("sources", getAllSources($permissions['publicOnly']));
	$nav[] = Array("page" => "source", "parms" => "", "text" => "Sources");
	$smarty->assign("nav", $nav);
	$smarty->display('source.tpl');
}
else if($_GET['page'] == "sourceAdd"){
	/*******************************************************************************************************
	 * Add source page
	 ******************************************************************************************************/
	$nav[] = Array("page" => "source", "parms" => "", "text" => "Sources");
	$nav[] = Array("page" => "sourceAdd", "parms" => "", "text" => "Add Source");
	$smarty->assign("nav", $nav);
	$smarty->display('sourceAdd.tpl');
}
else if($_GET['page'] == "sourceEdit"){
	/*******************************************************************************************************
	 * Edit source page
	 ******************************************************************************************************/
	$sourceid = getPageId('sourceid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isSource($sourceid)){
		pageNotFound();
	}
	
	$sourceinfo = getSourceInformation($sourceid);
	$smarty->assign("id", $sourceid);
	$smarty->assign("source", $sourceinfo);
	$smarty->assign("sourceCount", getSourceUseCount($sourceid));
	$nav[] = Array("page" => "source", "parms" => "", "text" => "Sources");
	$nav[] = Array("page" => "sourceEdit", "parms" => ("sourceid=".$sourceid), "text" => "Edit Source (".$sourceinfo['name'].")");
	$smarty->assign("nav", $nav);
	$smarty->display('sourceEdit.tpl');
}
else if($_GET['page'] == "error"){
	$smarty->assign("message", "You have reached this page because an error occured.");
	$smarty->display('error.tpl');
}
else{
	$smarty->assign("message","Error: Page not found.");
	$smarty->display('error.tpl');
}

?>