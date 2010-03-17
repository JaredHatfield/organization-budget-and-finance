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


// Process the page
if(!isset($_GET['page'])){
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
	
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("receipts", getReceiptForLineItem($parent));
	$smarty->assign("funds", getFundsForLineItem($parent));
	$smarty->assign("sources",getSourcesForLineItems($parent));
	$smarty->assign("children", getCompleteLineItemChildren($parent));
	$smarty->display('budget.tpl');
}
else if($_GET['page'] == "lineitemAdd"){
	/*******************************************************************************************************
	 * Add lineitem page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	$smarty->assign("lineitemParent", getLineItem($parent));
	$smarty->display('lineitemAdd.tpl');
}
else if($_GET['page'] == "lineitemEdit"){
	/*******************************************************************************************************
	 * Edit lineitem page
	 ******************************************************************************************************/
	$lineitemid = getPageId('lineid');
	$smarty->assign("id", $lineitemid);
	$smarty->assign("lineitem", getLineItem($lineitemid));
	$smarty->assign("lineitemCount", getLineItemUseCount($lineitemid));
	$smarty->display('lineitemEdit.tpl');
}
else if($_GET['page'] == "receiptAdd"){
	/*******************************************************************************************************
	 * Add receipt page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("company_selections", getCompanySelections());
	$smarty->display('receiptAdd.tpl');
}
else if($_GET['page'] == "receiptEdit"){
	/*******************************************************************************************************
	 * Edit receipt page
	 ******************************************************************************************************/
	$receiptid = getPageId('receiptid');
	$receiptinfo = getReceipt($receiptid);
	$smarty->assign("id", $receiptid);
	$smarty->assign("receipt",$receiptinfo);
	$smarty->assign("lineitem", getLineItem($receiptinfo['lineitem']));
	$smarty->assign("company_selections", getCompanySelections());
	$smarty->display('receiptEdit.tpl');
}
else if($_GET['page'] == "fundsAdd"){
	/*******************************************************************************************************
	 * Add funds page
	 ******************************************************************************************************/
	$parent = getPageId('lineid');
	$smarty->assign("lineitem", getLineItem($parent));
	$smarty->assign("source_selections", getSourceSelections($parent, 0));
	$smarty->display('fundsAdd.tpl');
}
else if($_GET['page'] == "fundsEdit"){
	/*******************************************************************************************************
	 * Edit funds page
	 ******************************************************************************************************/
	$fundsid = getPageId('fundsid');
	$fundinfo = getFund($fundsid);
	$smarty->assign("id", $fundsid);
	$smarty->assign("funds", $fundinfo);
	$smarty->assign("lineitem", getLineItem($fundinfo['lineitem']));
	$smarty->assign("source_selections", getSourceSelections($fundinfo['lineitem'], $fundsid));
	$smarty->display('fundsEdit.tpl');
}
else if($_GET['page'] == "company"){
	/*******************************************************************************************************
	 * company page
	 ******************************************************************************************************/
	$smarty->assign("companies", getAllCompanies());
	$smarty->display('company.tpl');
}
else if($_GET['page'] == "companyAdd"){
	/*******************************************************************************************************
	 * Add company page
	 ******************************************************************************************************/
	$smarty->display('companyAdd.tpl');
}
else if($_GET['page'] == "companyEdit"){
	/*******************************************************************************************************
	 * Edit company page
	 ******************************************************************************************************/
	$companyid = getPageId('companyid');
	$smarty->assign("id", $companyid);
	$smarty->assign("company", getCompanyInformation($companyid));
	$smarty->assign("companyCount", getCompanyUseCount($companyid));
	$smarty->display('companyEdit.tpl');
}
else if($_GET['page'] == "source"){
	/*******************************************************************************************************
	 * source page
	 ******************************************************************************************************/
	$smarty->assign("sources", getAllSources());
	$smarty->display('source.tpl');
}
else if($_GET['page'] == "sourceAdd"){
	/*******************************************************************************************************
	 * Add source page
	 ******************************************************************************************************/
	$smarty->display('sourceAdd.tpl');
}
else if($_GET['page'] == "sourceEdit"){
	/*******************************************************************************************************
	 * Edit source page
	 ******************************************************************************************************/
	$sourceid = getPageId('sourceid');
	$smarty->assign("id", $sourceid);
	$smarty->assign("source", getSourceInformation($sourceid));
	$smarty->assign("sourceCount", getSourceUseCount($sourceid));
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