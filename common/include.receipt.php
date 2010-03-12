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
 * @version 1.0
 */

/// Returns all of the information for the receipts for a specified lineitem
function getReceiptForLineItem($lineitem){
	$query = "SELECT `id`, `name`, `description`, `company`, `amount`, `lineitem`, `rdate` FROM receipt r WHERE `lineitem` = " . intval($lineitem) . ";";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Returns the total amount of receipts for a specified lineitem
function getReceiptTotalForLineItem($lineitem){
	$total = 0;
	$query = "SELECT `amount` FROM receipt r WHERE `lineitem` = " . intval($lineitem) . ";";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$total += $row['amount'];
	}
	
	return $total;
}

/// Returns the total amount of receipts for a specified lineitems and its children
function getReceiptTotalForLineItemAndChildren($lineitem){
	$total = getReceiptTotalForLineItem($lineitem);
	$children = getLineItemChildrenIds($lineitem);
	for($i = 0; $i < sizeof($children); $i++){
		$total += getReceiptTotalForLineItemAndChildren($children[$i]);
	}
	
	return $total;
}





?>