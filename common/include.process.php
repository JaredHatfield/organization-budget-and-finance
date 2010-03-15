<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.process.php
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


function process(){
	if(!isset($_POST['action'])){
		return "./index.php";
	}
	else if($_POST['action'] == "lineitemEdit"){
		$id = mysql_real_escape_string($_POST['lineitem_id']);
		$name = mysql_real_escape_string($_POST['lineitem_name']);
		$description = mysql_real_escape_string($_POST['lineitem_description']);
		$public  = 0;
		if(isset($_POST['lineitem_public'])){
			$public = 1;
		}
		
		updateLineitem($id, $name, $description, $public);
		return "./index.php?page=budget&lineid=" . $id;
	}
	else if($_POST['action'] == "lineitemAdd"){
		$parent = mysql_real_escape_string($_POST['lineitem_parent']);
		$name = mysql_real_escape_string($_POST['lineitem_name']);
		$description = mysql_real_escape_string($_POST['lineitem_description']);
		$public  = 0;
		if(isset($_POST['lineitem_public'])){
			$public = 1;
		}
		
		insertLineitem($name, $description, $parent, $public);
		return "./index.php?page=budget&lineid=" . $parent;
	}
	else if($_POST['action'] == "receiptEdit"){
		$id = mysql_real_escape_string($_POST['receipt_id']);
		$name = mysql_real_escape_string($_POST['receipt_name']);
		$description = mysql_real_escape_string($_POST['receipt_description']);
		$company = mysql_real_escape_string($_POST['receipt_company']);
		$amount = mysql_real_escape_string($_POST['receipt_amount']);
		$rdate = mysql_real_escape_string($_POST['receipt_rdate']);
		$public  = 0;
		if(isset($_POST['receipt_public'])){
			$public = 1;
		}
		
		updateReceipt($id, $name, $description, $company, $amount, $rdate, $public);
		$receipt = getReceipt($id);
		return "./index.php?page=budget&lineid=" . $receipt['lineitem'];
	}
	else if($_POST['action'] == "receiptAdd"){
		$lineitem = mysql_real_escape_string($_POST['receipt_lineitem']);
		$name = mysql_real_escape_string($_POST['receipt_name']);
		$description = mysql_real_escape_string($_POST['receipt_description']);
		$company = mysql_real_escape_string($_POST['receipt_company']);
		$amount = mysql_real_escape_string($_POST['receipt_amount']);
		$rdate = mysql_real_escape_string($_POST['receipt_rdate']);
		$public  = 0;
		if(isset($_POST['receipt_public'])){
			$public = 1;
		}
		
		insertReceipt($name, $description, $company, $amount, $lineitem, $rdate, $public);
		return "./index.php?page=budget&lineid=" . $lineitem;
	}
	else if($_POST['action'] == "fundsEdit"){
		$id = mysql_real_escape_string($_POST['funds_id']);
		$source = mysql_real_escape_string($_POST['funds_source']);
		$amount = mysql_real_escape_string($_POST['funds_amount']);
		updateFunds($id, $source, $amount);
		$lineiteminfo = getFund($id);
		return "./index.php?page=budget&lineid=" . $lineiteminfo['lineitem'];
	}
	else if($_POST['action'] == "fundsAdd"){
		$source = mysql_real_escape_string($_POST['funds_source']);
		$amount = mysql_real_escape_string($_POST['funds_amount']);
		$lineitem = mysql_real_escape_string($_POST['funds_lineitem']);
		insertFunds($lineitem, $source, $amount);
		return "./index.php?page=budget&lineid=" . $lineitem;
	}
	else if($_POST['action'] == "companyEdit"){
		$id = mysql_real_escape_string($_POST['company_id']);
		$name = mysql_real_escape_string($_POST['company_name']);
		updateCompany($id, $name);
		return "./index.php?page=company";
	}
	else if($_POST['action'] == "companyAdd"){
		$name = mysql_real_escape_string($_POST['company_name']);
		insertCompany($name);
		return "./index.php?page=company";
	}
	else if($_POST['action'] == "sourceEdit"){
		$id = mysql_real_escape_string($_POST['source_id']);
		$name = mysql_real_escape_string($_POST['source_name']);
		$public  = 0;
		if(isset($_POST['source_public'])){
			$public = 1;
		}
		
		updateSource($id, $name, $public);
		return "./index.php?page=source";
	}
	else if($_POST['action'] == "sourceAdd"){
		$name = mysql_real_escape_string($_POST['source_name']);
		$public  = 0;
		if(isset($_POST['source_public'])){
			$public = 1;
		}
		
		insertSource($name, $public);
		return "./index.php?page=source";
	}
	else{
		return "./index.php";
	}
}
?>