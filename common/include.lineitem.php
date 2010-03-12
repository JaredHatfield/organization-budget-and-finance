<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.lineitem.php
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


/// Returns a fully supplemented list of lineitems for a specified parent
function getCompleteLineItemChildren($parent){
	$items = getLineItemChildren($parent);
	$sources = getSourcesForLineItems($parent);
	
	$receipts = 0;
	for($j = 0; $j < sizeof($sources); $j++){
		$sources[$j]['sum'] = 0;
	}
	
	for($i = 0; $i < sizeof($items); $i++){
		$items[$i]['receipts'] = getReceiptTotalForLineItemAndChildren($items[$i]['id']);
		$receipts += $items[$i]['receipts'];
		for($j = 0; $j < sizeof($sources); $j++){
			$items[$i]['funds'][$j] = getFundsFor($items[$i]['id'], $sources[$j]['id']);
			$sources[$j]['sum'] += $items[$i]['funds'][$j];
		}
		
		$items[$i]['difference'] = -$items[$i]['receipts'];
		for($j = 0; $j < sizeof($sources); $j++){
			$items[$i]['difference'] += $items[$i]['funds'][$j];
		}
	}
	
	// Add a last row for the total
	$items[$i]['id'] = -1;
	$items[$i]['name'] = "Totals";
	$items[$i]['description'] = "---";
	$items[$i]['public'] = 1;
	$items[$i]['receipts'] = $receipts;
	$items[$i]['difference'] = -$items[$i]['receipts'];
	for($j = 0; $j < sizeof($sources); $j++){
		$items[$i]['funds'][$j] = $sources[$j]['sum'];
		$items[$i]['difference'] += $items[$i]['funds'][$j];
	}
	
	return $items;
}

/// Returns the lineitem information for the children of the specified lineitem
function getLineItemChildren($parent){
	$query = "SELECT `id`, `name`, `description`, `public` FROM lineitem l WHERE `parent` = " . intval($parent) . " AND `id` != 1;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Returns the ids for the children of the specified parent
function getLineItemChildrenIds($parent){
	$query = "SELECT `id` FROM lineitem l WHERE `parent` = " . intval($parent) . " AND `id` != 1;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row['id'];
	}
	
	return $val;
}

// Returns the information about a line item
function getLineItem($id){
	$query = "SELECT `id`, `name`, `description`, `public` FROM lineitem l WHERE `id` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

?>