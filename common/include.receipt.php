<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.receipt.php
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
 * @version 1.0.1
 */

/// Returns all of the information for the receipts for a specified lineitem
function getReceiptForLineItem($lineitem, $publicOnly){
	global $database;
	$query  = "SELECT r.`id`, r.`lineitem`, r.`name`, r.`description`, c.`id` company_id, c.`name` company_name, r.`amount`, r.`rdate`, r.`public` ";
	$query .= "FROM receipt r JOIN company c ON r.company = c.id WHERE `lineitem` = " . intval($lineitem) . " ";
	if($publicOnly){
		$query .= "AND r.`public` = 1 ";
	}
	$query .= "ORDER BY r.`rdate`;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}


/// Returns the total amount of receipts for a specified lineitems and its children
function getReceiptTotalForLineItemAndChildren($lineitem, $publicOnly){
	global $database;
	$query  = "SELECT IFNULL(SUM(amount),0) total FROM receipt r WHERE r.`lineitem` IN ( ";
	$query .= "SELECT n.`id` FROM `lineitem` l LEFT JOIN `lineitem` m ON l.id = m.parent LEFT JOIN `lineitem` n ON m.id = n.parent ";
	$query .= "WHERE l.`id` = " . $lineitem . " ";
	if($publicOnly){
		$query .= "AND l.`public` = 1 AND m.`public` = 1 AND n.`public` = 1 ";
	}
	
	$query .= "UNION SELECT m.`id` FROM `lineitem` l LEFT JOIN `lineitem` m ON l.id = m.parent ";
	$query .= "WHERE l.`id` = " . $lineitem . " ";
	if($publicOnly){
		$query .= " AND l.`public` = 1 AND m.`public` = 1 ";
	}
	
	$query .= "UNION SELECT l.`id` FROM `lineitem` l ";
	$query .= "WHERE l.`id` = " . $lineitem . " ";
	if($publicOnly){
		$query .= " AND l.`public` = 1 ";
	}
	
	$query .= ")";
	if($publicOnly){
		$query .= " AND r.`public` = 1;";
	}
	
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row['total'];
}


/// Gets the information for a specific receipt
function getReceipt($id){
	global $database;
	$query = "SELECT `id`, `name`, `description`, `company`, `amount`, `lineitem`, `rdate`, `public` FROM receipt r WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

/// Checks to see if the specified receipt is not public.  Recursively checks the lineitem parents.
function isReceiptPrivate($id){
	$receipt = getReceipt($id);
	if($receipt['public'] == 0){
		return true;
	}
	else{
		return isLineItemPrivate($receipt['lineitem']);
	}
}

/// Determines if the specified number is a valid receipt id number
function isReceipt($id){
	global $database;
	$query = "SELECT COUNT(*) number FROM receipt r WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	if($row['number'] == "1"){
		return true;
	}
	else{
		return false;
	}
}

/*******************************************************************************************************
 * Insert/Update Queries
 ******************************************************************************************************/


function insertReceipt($name, $description, $company, $amount, $lineitem, $rdate, $public){
	global $database;
	$query  = "INSERT INTO receipt (`name`, `description`, `company`, `amount`, `lineitem`, `rdate`, `public`) ";
	$query .= "VALUES('" . $name . "', '" . $description . "', " . intval($company) . ", " . $amount . ", " . intval($lineitem) . ", '" . $rdate . "', " . $public . ");";
	$result = $database->exec($query);
}


function updateReceipt($id, $name, $description, $company, $amount, $rdate, $public){
	global $database;
	$query = "UPDATE receipt SET `name` = '" . $name . "', `description` = '" . $description . "', `company` = " . intval($company) . ", `amount` = " . $amount . ", `rdate` = '" . $rdate . "', `public` = " . intval($public) . " WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = $database->exec($query);
}


function deleteReceipt($id){
	global $database;
	$query = "DELETE FROM receipt WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = $database->exec($query);
}

?>