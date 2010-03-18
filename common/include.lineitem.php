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
function getCompleteLineItemChildren($parent, $publicOnly){
	
	$items = getLineItemChildren($parent, $publicOnly);
	$sources = getSourcesForLineItems($parent, $publicOnly);
	
	$receipts = 0;
	for($j = 0; $j < sizeof($sources); $j++){
		$sources[$j]['sum'] = 0;
	}
	
	for($i = 0; $i < sizeof($items); $i++){
		$items[$i]['receipts'] = getReceiptTotalForLineItemAndChildren($items[$i]['id'], $publicOnly);
		$receipts += $items[$i]['receipts'];
		for($j = 0; $j < sizeof($sources); $j++){
			$items[$i]['funds'][$j] = getFundsFor($items[$i]['id'], $sources[$j]['id'], $publicOnly);
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
function getLineItemChildren($parent, $publicOnly){
	$query = "SELECT `id`, `name`, `description`, `public` FROM lineitem l WHERE `parent` = " . intval($parent) . " ";
	if($publicOnly){
		$query .= "AND l.`public` = 1 ";
	}
	$query .= "AND `id` != 1;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Returns the ids for the children of the specified parent
function getLineItemChildrenIds($parent, $publicOnly){
	$query = "SELECT `id` FROM lineitem l WHERE `parent` = " . intval($parent) . " ";
	if($publicOnly){
		$query .= "AND l.`public` = 1 ";
	}
	$query .= "AND `id` != 1;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row['id'];
	}
	
	return $val;
}

/// Returns the information about a line item
function getLineItem($id){
	$query = "SELECT `id`, `name`, `description`, `parent`, `public` FROM lineitem l WHERE `id` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

/// Returns the number of items that depend on the specified lineitem
function getLineItemUseCount($id){
	$total = 0;
	$query = "SELECT COUNT(*) number FROM funds f WHERE `lineitem` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$total += $row['number'];
	$query = "SELECT COUNT(*) number FROM receipt r WHERE `lineitem` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$total += $row['number'];
	$query = "SELECT COUNT(*) number FROM lineitem l WHERE `parent` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$total += $row['number'];
	return $total;
}

/// Checks to see if the specified lineitem is not public.  Recursively checks the parents.
function isLineItemPrivate($id){
	$line = getLineItem($id);
	if($line['public'] == 0){
		return true;
	}
	else if($line['parent'] != 1){
		return isLineItemPrivate($line['parent']);
	}
	else{
		return false;
	}
}

/// Determines if the specified number is a valid lineitem id number
function isLineItem($id){
	$query = "SELECT COUNT(*) number FROM lineitem l WHERE `id` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if($row['number'] == "1"){
		return true;
	}
	else{
		return false;
	}
}

/// Gets an array of the navigation information for a specific lineitem
function getNavigationForLineItem($lineitemid){
	$line = getLineItem($lineitemid);
	$nav = Array();
	
	// We don't want to ever list the root
	if($line['id'] == 1){
		return $nav;
	}
	
	// Add this to the list
	$nav[] = Array("page" => "budget", "parms" => "lineid=".$line['id'], "text" => $line['name']);
	
	// Add all of the parents
	if($line['parent'] != 1){
		$nav = array_merge(getNavigationForLineItem($line['parent']), $nav);
	}
	
	return $nav;
}

/*******************************************************************************************************
 * Insert/Update Queries
 ******************************************************************************************************/


function insertLineitem($name, $description, $parent, $public){
	$query = "INSERT INTO lineitem (`name`, `description`, `parent`, `public`) VALUES('" . $name . "', '" . $description . "', " . intval($parent) . ", " . intval($public) . ");";
	$result = mysql_query($query);
}


function updateLineitem($id, $name, $description, $public){
	$query = "UPDATE lineitem SET `name` = '" . $name . "', `description` = '" . $description . "', `public` = " . intval($public) . " WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = mysql_query($query);
}


function deleteLineitem($id){
	$query = "DELETE FROM lineitem WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = mysql_query($query);
}

?>