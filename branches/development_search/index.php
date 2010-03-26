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
require_once("./recaptcha/recaptchalib.php");
include_once("./common/include.index.php");


// Smarty
$smarty = new Smarty;
$smarty->compile_check = true;
//$smarty->debugging = true;
$smarty->assign("pagename", "");
$smarty->assign("selectedTab","Home");
$smarty->register_block('dynamic', 'smarty_block_dynamic', false);



// Navigation higherarchy
$nav[] = Array("page" => "home", "parms" => "", "text" => "Home");
$smarty->assign_by_ref("nav",$nav);



// Authentication and permission logic
$permissions = Array();
if(!isset($_SESSION['budget_authentication'])){
	$_SESSION['budget_authentication'] = 0; // Set user to anonymous
	$permissions = getUserPermissions("Anonymous");
	$smarty->assign("isAuthenticated", false);
}
else if(isUser($_SESSION['budget_authentication'])){
	$userInformation = getUser($_SESSION['budget_authentication']);
	$smarty->assign("userInformation", $userInformation);
	$smarty->assign("isAuthenticated", true);
	$permissions = getUserPermissions($userInformation['group']);
	
	if($userInformation['active'] == 0){
		$_SESSION['budget_authentication'] = 0;
		$smarty->assign("message", "Your account has been disabled.");
		$smarty->display('error.tpl');
		exit();
	}
}
else{
	$permissions = getUserPermissions("Anonymous");
	$smarty->assign("isAuthenticated", false);
}
$smarty->assign("permissions", $permissions);



// Query information
$smarty->assign_by_ref("database", $database);

// Process the page
if(!isset($_GET['page']) || $_GET['page'] == "home"){
	/*******************************************************************************************************
	 * Main page
	 ******************************************************************************************************/
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
	if(!isLineItem($parent)){
		pageNotFound();
	}
	else if($permissions['publicOnly'] && isLineItemPrivate($parent)){
		pageForbidden();
	}
	
	if($permissions['cacheBudget']){
		$smarty->caching = 1;
		$smarty->cache_lifetime = (60 * 60 * 24); // Keep the page for a day
	}
	else{
		$smarty->clear_cache('budget.tpl', $parent);
	}
	
	if(!$smarty->is_cached('budget.tpl', $parent)) {
		$smarty->assign("lineitem", getLineItem($parent));
		$smarty->assign("receipts", getReceiptForLineItem($parent, $permissions['publicOnly']));
		$smarty->assign("funds", getFundsForLineItem($parent, $permissions['publicOnly']));
		$smarty->assign("sources",getSourcesForLineItems($parent, $permissions['publicOnly']));
		$smarty->assign("children", getCompleteLineItemChildren($parent, $permissions['publicOnly']));
	}
	else{
		$smarty->assign("pagecache",true);
	}
	
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$smarty->assign("selectedTab","Budget");
	$smarty->display('budget.tpl', $parent);
}
else if($_GET['page'] == "lineitemAdd"){
	/*******************************************************************************************************
	 * Add lineitem page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($parent)){
		pageNotFound();
	}
	else if($permissions['publicOnly'] && isLineItemPrivate($parent)){
		pageForbidden();
	}
	
	$smarty->assign("lineitemParent", getLineItem($parent));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$nav[] = Array("page" => "lineitemAdd", "parms" => "lineid=".$parent, "text" => "Add Line Item");
	$smarty->assign("selectedTab","Budget");
	$smarty->display('lineitemAdd.tpl');
}
else if($_GET['page'] == "lineitemEdit"){
	/*******************************************************************************************************
	 * Edit lineitem page
	 ******************************************************************************************************/
	$lineitemid = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($lineitemid)){
		pageNotFound();
	}
	else if($permissions['publicOnly'] && isLineItemPrivate($lineitemid)){
		pageForbidden();
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
	$smarty->assign("selectedTab","Budget");
	$smarty->display('lineitemEdit.tpl');
}
else if($_GET['page'] == "receiptAdd"){
	/*******************************************************************************************************
	 * Add receipt page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($parent)){
		pageNotFound();
	}
	else if($permissions['publicOnly'] && isLineItemPrivate($parent)){
		pageForbidden();
	}
	
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("company_selections", getCompanySelections());
	$smarty->assign("month_selections", getMonthSelections());
	$smarty->assign("day_selections", getDaySelections());
	$smarty->assign("current_day", date("j"));
	$smarty->assign("current_month", date("n"));
	$smarty->assign("current_year", date("Y"));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$nav[] = Array("page" => "receiptAdd", "parms" => "lineid=".$parent, "text" => "Add Receipt");
	$smarty->assign("selectedTab","Budget");
	$smarty->display('receiptAdd.tpl');
}
else if($_GET['page'] == "receiptEdit"){
	/*******************************************************************************************************
	 * Edit receipt page
	 ******************************************************************************************************/
	$receiptid = getPageId('receiptid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isReceipt($receiptid)){
		pageNotFound();
	}
	else if($permissions['publicOnly'] && isReceiptPrivate($receiptid)){
		pageForbidden();
	}
	
	$receiptinfo = getReceipt($receiptid);
	$smarty->assign("id", $receiptid);
	$smarty->assign("receipt",$receiptinfo);
	$smarty->assign("lineitem", getLineItem($receiptinfo['lineitem']));
	$smarty->assign("company_selections", getCompanySelections());
	$smarty->assign("month_selections", getMonthSelections());
	$smarty->assign("day_selections", getDaySelections());
	$smarty->assign("current_day", date("j", strtotime($receiptinfo['rdate'])));
	$smarty->assign("current_month", date("n", strtotime($receiptinfo['rdate'])));
	$smarty->assign("current_year", date("Y", strtotime($receiptinfo['rdate'])));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($receiptinfo['lineitem']));
	$name = "Edit Receipt (" . $receiptinfo['name'] . ")";
	if($receiptinfo['public'] == 0){
		$name .= "*";
	}
	$nav[] = Array("page" => "receiptEdit", "parms" => "receiptid=".$receiptid, "text" => $name);
	$smarty->assign("selectedTab","Budget");
	$smarty->display('receiptEdit.tpl');
}
else if($_GET['page'] == "fundsAdd"){
	/*******************************************************************************************************
	 * Add funds page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isLineItem($parent)){
		pageNotFound();
	}
	else if($permissions['publicOnly'] && isLineItemPrivate($parent)){
		pageForbidden();
	}
	
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("source_selections", getSourceSelections($parent, 0, $permissions['publicOnly']));
	$nav[] = Array("page" => "budget", "parms" => "", "text" => "Budget");
	$nav = array_merge($nav, getNavigationForLineItem($parent));
	$nav[] = Array("page" => "fundsAdd", "parms" => "lineid=".$parent, "text" => "Add Funds");
	$smarty->assign("selectedTab","Budget");
	$smarty->display('fundsAdd.tpl');
}
else if($_GET['page'] == "fundsEdit"){
	/*******************************************************************************************************
	 * Edit funds page
	 ******************************************************************************************************/
	$fundsid = getPageId('fundsid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isFund($fundsid)){
		pageNotFound();
	}
	else if($permissions['publicOnly'] && isFundPrivate($fundsid)){
		pageForbidden();
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
	$smarty->assign("selectedTab","Budget");
	$smarty->display('fundsEdit.tpl');
}
else if($_GET['page'] == "company"){
	/*******************************************************************************************************
	 * company page
	 ******************************************************************************************************/
	$smarty->assign("companies", getAllCompanies());
	$nav[] = Array("page" => "company", "parms" => "", "text" => "Companies");
	$smarty->assign("selectedTab","Company");
	$smarty->display('company.tpl');
}
else if($_GET['page'] == "companyAdd"){
	/*******************************************************************************************************
	 * Add company page
	 ******************************************************************************************************/
	$nav[] = Array("page" => "company", "parms" => "", "text" => "Companies");
	$nav[] = Array("page" => "companyAdd", "parms" => "", "text" => "Add Company");
	$smarty->assign("selectedTab","Company");
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
	$smarty->assign("selectedTab","Company");
	$smarty->display('companyEdit.tpl');
}
else if($_GET['page'] == "source"){
	/*******************************************************************************************************
	 * source page
	 ******************************************************************************************************/
	$smarty->assign("sources", getAllSources($permissions['publicOnly']));
	$nav[] = Array("page" => "source", "parms" => "", "text" => "Sources");
	$smarty->assign("selectedTab","Source");
	$smarty->display('source.tpl');
}
else if($_GET['page'] == "sourceAdd"){
	/*******************************************************************************************************
	 * Add source page
	 ******************************************************************************************************/
	$nav[] = Array("page" => "source", "parms" => "", "text" => "Sources");
	$nav[] = Array("page" => "sourceAdd", "parms" => "", "text" => "Add Source");
	$smarty->assign("selectedTab","Source");
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
	$smarty->assign("selectedTab","Source");
	$smarty->display('sourceEdit.tpl');
}
else if($_GET['page'] == "register"){
	/*******************************************************************************************************
	 * Register page
	 ******************************************************************************************************/
	$error = "";
	if(isRecaptchaEnabled()){
		$smarty->assign("recaptcha", recaptcha_get_html($_CONFIG['recaptcha_public'], $error));
	}
	else{
		$smarty->assign("recaptcha", "");
	}
	
	$nav[] = Array("page" => "register", "parms" => "", "text" => "Register New Account");
	$smarty->assign("selectedTab","Register");
	$smarty->display('register.tpl');
}
else if($_GET['page'] == "myAccount"){
	/*******************************************************************************************************
	 * My Account page
	 ******************************************************************************************************/
	
	if(!isUser($_SESSION['budget_authentication'])){
		pageForbidden();
	}
	
	$smarty->assign("user", getUser($_SESSION['budget_authentication']));
	$smarty->assign("id", $_SESSION['budget_authentication']);
	$smarty->assign("booleanOptions", getBooleanSelections());
	$nav[] = Array("page" => "myAccount", "parms" => "", "text" => "My Account");
	$smarty->assign("selectedTab","My Account");
	$smarty->display('myAccount.tpl');
}
else if($_GET['page'] == "adminConsole"){
	/*******************************************************************************************************
	 * Admin Console page
	 ******************************************************************************************************/
	if(!$permissions['admin']){
		pageForbidden();
	}
	
	$smarty->assign("users", getAllUsers());
	
	$nav[] = Array("page" => "adminConsole", "parms" => "", "text" => "Admin Console");
	$smarty->assign("selectedTab","Admin");
	$smarty->display('adminConsole.tpl');
}
else if($_GET['page'] == "adminAccount"){
	/*******************************************************************************************************
	 * Admin Account page
	 ******************************************************************************************************/
	$userid = getPageId('userid');
	
	// Make sure the page exists and the user as permission to see it
	if(!isUser($userid)){
		pageNotFound();
	}
	
	if(!$permissions['admin']){
		pageForbidden();
	}
	
	$smarty->assign("user", getUser($userid));
	$smarty->assign("group_selections", getGroups());
	$smarty->assign("id", $userid);
	$nav[] = Array("page" => "adminConsole", "parms" => "", "text" => "Admin Console");
	$nav[] = Array("page" => "adminAccount", "parms" => "", "text" => "Admin Account");
	$smarty->assign("selectedTab","Admin");
	$smarty->display('adminAccount.tpl');
}
else if($_GET['page'] == "search"){
	/*******************************************************************************************************
	 * Search page
	 ******************************************************************************************************/
	$searchString = mysql_real_escape_string($_GET['search']);
	$smarty->assign("resultsLineItem", searchLineItems($searchString, $permissions['publicOnly']));
	$smarty->assign("resultReceipts", searchReceipts($searchString, $permissions['publicOnly']));
	
	$smarty->assign("searchString", $searchString);
	$nav[] = Array("page" => "search", "parms" => "", "text" => "Search");
	$smarty->assign("selectedTab", "Search");
	$smarty->display('search.tpl');
}
else if($_GET['page'] == "dump"){
	/*******************************************************************************************************
	 * Dump XML Data
	 ******************************************************************************************************/
	if(!$permissions['dump']){
		pageForbidden();
	}
	
	// We cache the public only dump for a day because it is very, very expensive to generate
	if($permissions['publicOnly']){
		$smarty->caching = 1;
		$smarty->cache_lifetime = (60 * 60 * 24);
	}
	
	if(!$smarty->is_cached('dump.tpl', $permissions['publicOnly'])) {
		$smarty->assign("company", dumpCompany());
		$smarty->assign("funds", dumpFunds($permissions['publicOnly']));
		$smarty->assign("lineitem", dumpLineItems($permissions['publicOnly']));
		$smarty->assign("receipt", dumpReceipt($permissions['publicOnly']));
		$smarty->assign("sources", dumpSources($permissions['publicOnly']));
	}
	
	header ("content-type: text/xml");
	$smarty->display('dump.tpl', $permissions['publicOnly']);
}
else if($_GET['page'] == "logout"){
	$_SESSION['budget_authentication'] = 0;
	secureform_logout();
	$smarty->assign("url","./index.php");
	$smarty->display('redirect.tpl');
}
else if($_GET['page'] == "error"){
	/*******************************************************************************************************
	 * Error page
	 ******************************************************************************************************/
	$smarty->assign("message", "You have reached this page because an error occured.");
	$smarty->display('error.tpl');
}
else{
	/*******************************************************************************************************
	 * 404 Page Not Found
	 ******************************************************************************************************/
	pageNotFound();
}

?>