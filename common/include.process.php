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
	
	if(!isset($_POST['action']) || !isset($_POST['key'])){
		return "./index.php?page=error";
	}
	
	$form_key = mysql_real_escape_string($_POST['key']);
	$form_action = mysql_real_escape_string($_POST['action']);
	
	if($_POST['action'] == "lineitemEdit"){
		$id = mysql_real_escape_string($_POST['lineitem_id']);
		$name = mysql_real_escape_string($_POST['lineitem_name']);
		$description = mysql_real_escape_string($_POST['lineitem_description']);
		$public  = 0;
		if(isset($_POST['lineitem_public'])){
			$public = 1;
		}
		
		if(!secureform_test_pk($form_key, "lineitemEdit", $id)){
			return "./index.php?page=error";
		}
		
		$lineitem = getLineItem($id);
		updateLineitem($id, $name, $description, $public);
		return "./index.php?page=budget&lineid=" . $lineitem['parent'];
	}
	else if($_POST['action'] == "lineitemAdd"){
		$parent = mysql_real_escape_string($_POST['lineitem_parent']);
		$name = mysql_real_escape_string($_POST['lineitem_name']);
		$description = mysql_real_escape_string($_POST['lineitem_description']);
		$public  = 0;
		if(isset($_POST['lineitem_public'])){
			$public = 1;
		}
		
		if(!secureform_test($form_key, "lineitemAdd")){
			return "./index.php?page=error";
		}
		
		insertLineitem($name, $description, $parent, $public);
		return "./index.php?page=budget&lineid=" . $parent;
	}
	else if($_POST['action'] == "lineitemDelete"){
		$id = mysql_real_escape_string($_POST['lineitem_id']);
		$lineitem = getLineItem($id);
		
		if(!secureform_test_pk($form_key, "lineitemDelete", $id)){
			return "./index.php?page=error";
		}
		
		deleteLineitem($id);
		return "./index.php?page=budget&lineid=" . $lineitem['parent'];
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
		
		if(!secureform_test_pk($form_key, "receiptEdit", $id)){
			return "./index.php?page=error";
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
		
		if(!secureform_test($form_key, "receiptAdd")){
			return "./index.php?page=error";
		}
		
		insertReceipt($name, $description, $company, $amount, $lineitem, $rdate, $public);
		return "./index.php?page=budget&lineid=" . $lineitem;
	}
	else if($_POST['action'] == "receiptDelete"){
		$id = mysql_real_escape_string($_POST['receipt_id']);
		
		if(!secureform_test_pk($form_key, "receiptDelete", $id)){
			return "./index.php?page=error";
		}
		
		$receipt = getReceipt($id);
		deleteReceipt($id);
		return "./index.php?page=budget&lineid=" . $receipt['lineitem'];
	}
	else if($_POST['action'] == "fundsEdit"){
		$id = mysql_real_escape_string($_POST['funds_id']);
		$source = mysql_real_escape_string($_POST['funds_source']);
		$amount = mysql_real_escape_string($_POST['funds_amount']);
		
		if(!secureform_test_pk($form_key, "fundsEdit", $id)){
			return "./index.php?page=error";
		}
		
		updateFunds($id, $source, $amount);
		$fund = getFund($id);
		return "./index.php?page=budget&lineid=" . $fund['lineitem'];
	}
	else if($_POST['action'] == "fundsAdd"){
		$source = mysql_real_escape_string($_POST['funds_source']);
		$amount = mysql_real_escape_string($_POST['funds_amount']);
		$lineitem = mysql_real_escape_string($_POST['funds_lineitem']);
		
		if(!secureform_test($form_key, "fundsAdd")){
			return "./index.php?page=error";
		}
		
		insertFunds($lineitem, $source, $amount);
		return "./index.php?page=budget&lineid=" . $lineitem;
	}
	else if($_POST['action'] == "fundsDelete"){
		$id = mysql_real_escape_string($_POST['funds_id']);
		
		if(!secureform_test_pk($form_key, "fundsDelete", $id)){
			return "./index.php?page=error";
		}
		
		$fund = getFund($id);
		deleteFunds($id);
		return "./index.php?page=budget&lineid=" . $fund['lineitem'];
	}
	else if($_POST['action'] == "companyEdit"){
		$id = mysql_real_escape_string($_POST['company_id']);
		$name = mysql_real_escape_string($_POST['company_name']);
		if(!secureform_test_pk($form_key, "companyEdit", $id)){
			return "./index.php?page=error";
		}
		
		updateCompany($id, $name);
		return "./index.php?page=company";
	}
	else if($_POST['action'] == "companyAdd"){
		$name = mysql_real_escape_string($_POST['company_name']);
		if(!secureform_test($form_key, "companyAdd")){
			return "./index.php?page=error";
		}
		
		insertCompany($name);
		return "./index.php?page=company";
	}
	else if($_POST['action'] == "companyDelete"){
		$id = mysql_real_escape_string($_POST['company_id']);
		if(!secureform_test_pk($form_key, "companyDelete", $id)){
			return "./index.php?page=error";
		}
		
		deleteCompany($id);
		return "./index.php?page=company";
	}
	else if($_POST['action'] == "sourceEdit"){
		$id = mysql_real_escape_string($_POST['source_id']);
		$name = mysql_real_escape_string($_POST['source_name']);
		$public  = 0;
		if(isset($_POST['source_public'])){
			$public = 1;
		}
		
		if(!secureform_test_pk($form_key, "sourceEdit", $id)){
			return "./index.php?page=error";
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
		
		if(!secureform_test($form_key, "sourceAdd")){
			return "./index.php?page=error";
		}
		
		insertSource($name, $public);
		return "./index.php?page=source";
	}
	else if($_POST['action'] == "sourceDelete"){
		$id = mysql_real_escape_string($_POST['source_id']);
		if(!secureform_test_pk($form_key, "sourceDelete", $id)){
			return "./index.php?page=error";
		}
		
		deleteSource($id);
		return "./index.php?page=source";
	}
	else if($_POST['action'] == "login"){
		$username = mysql_real_escape_string($_POST['login_username']);
		$password = mysql_real_escape_string($_POST['login_password']);
		
		if(!secureform_test($form_key, "login")){
			return "./index.php?page=error";
		}
		
		$_SESSION['budget_authentication'] = authenticateUser($username, $password);
		secureform_logout();
		
		if($_SESSION['budget_authentication'] == 0){
			return "./index.php?page=error";
		}
		else{
			return "./index.php";
		}
	}
	else if($_POST['action'] == "register"){
		$username = mysql_real_escape_string($_POST['register_username']);
		$password = mysql_real_escape_string($_POST['register_password']);
		$password2 = mysql_real_escape_string($_POST['register_password2']);
		
		if(!secureform_test($form_key, "register")){
			return "./index.php?page=error";
		}
		else if(!isValidUsername($username) || $password != $password2 || !isValidPassword($password)){
			return "./index.php?page=error";
		}
		else{
			registerUser($username, $password);
			$_SESSION['budget_authentication'] = authenticateUser($username, $password);
			secureform_logout();
			return "./index.php";
		}
	}
	else if($_POST['action'] == "changePassword"){
		$userid = $_SESSION['budget_authentication'];
		$password = mysql_real_escape_string($_POST['user_password']);
		$password2 = mysql_real_escape_string($_POST['user_password2']);
		
		if(!secureform_test_pk($form_key, "changePassword", $userid)){
			return "./index.php?page=error";
		}
		else if($password != $password2 || !isValidPassword($password)){
			return "./index.php?page=error";
		}
		else{
			changePassword($userid, $password);
			return "./index.php";
		}
	}
	else if($_POST['action'] == "resetPassword"){
		$userid = mysql_real_escape_string($_POST['user_id']);
		$password = mysql_real_escape_string($_POST['user_password']);
		$password2 = mysql_real_escape_string($_POST['user_password2']);
		
		if(!secureform_test_pk($form_key, "resetPassword", $userid)){
			return "./index.php?page=error";
		}
		else if($password != $password2 || !isValidPassword($password)){
			return "./index.php?page=error";
		}
		else{
			changePassword($userid, $password);
			return "./index.php";
		}
	}
	else if($_POST['action'] == "changeGroup"){
		$userid = mysql_real_escape_string($_POST['user_id']);
		$group = mysql_real_escape_string($_POST['user_group']);
		
		if(!secureform_test_pk($form_key, "changeGroup", $userid)){
			return "./index.php?page=error";
		}
		else{
			setUserGroup($userid, $group);
			return "./index.php?page=adminAccount&userid=" . $userid;
		}
	}
	else if($_POST['action'] == "setUserActive"){
		$userid = mysql_real_escape_string($_POST['user_id']);
		
		if(!secureform_test_pk($form_key, "setUserActive", $userid)){
			return "./index.php?page=error";
		}
		else{
			setUserActive($userid);
			return "./index.php?page=adminAccount&userid=" . $userid;
		}
	}
	else if($_POST['action'] == "setUserInactive"){
		$userid = mysql_real_escape_string($_POST['user_id']);
		
		if(!secureform_test_pk($form_key, "setUserInactive", $userid)){
			return "./index.php?page=error";
		}
		else{
			setUserInactive($userid);
			return "./index.php?page=adminAccount&userid=" . $userid;
		}
	}
	else{
		echo "<h1>Process not implemented</h1>"; // DEBUG
		print_r($_POST); // DEBUG
		exit(); // DEBUG
		return "./index.php";
	}
	
	return "./index.php?page=error";
}

?>