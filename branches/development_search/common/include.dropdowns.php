<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.dropdowns.php
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

/// Gets a list with only the options true and false
function getBooleanSelections(){
	$options[] = Array("value" => true, "name" => "Yes");
	$options[] = Array("value" => false, "name" => "No");
	return $options;
}

/// Get a list of the months
function getMonthSelections(){
	$months[] = Array("value" => 1, "name" => "January");
	$months[] = Array("value" => 2, "name" => "February");
	$months[] = Array("value" => 3, "name" => "March");
	$months[] = Array("value" => 4, "name" => "April");
	$months[] = Array("value" => 5, "name" => "May");
	$months[] = Array("value" => 6, "name" => "June");
	$months[] = Array("value" => 7, "name" => "July");
	$months[] = Array("value" => 8, "name" => "August");
	$months[] = Array("value" => 9, "name" => "September");
	$months[] = Array("value" => 10, "name" => "October");
	$months[] = Array("value" => 11, "name" => "November");
	$months[] = Array("value" => 12, "name" => "December");
	return $months;
}

/// Get a list of the days
function getDaySelections(){
	$days = Array();
	for($i = 1; $i <= 31; $i++){
		$days[] = Array("value" => $i, "name" => $i);
	}
	return $days;
}

/// Gets the list of valid groups a user can belong to
function getGroups(){
	$group[] = Array("value" => "Anonymous", "name" => "Anonymous"); // Not logged in
	$group[] = Array("value" => "Authenticated", "name" => "Authenticated"); // Logged in but same as Anonymous
	$group[] = Array("value" => "Registered", "name" => "Registered"); // Can see private items
	$group[] = Array("value" => "Contributor", "name" => "Contributor"); // Can add/edit receipts
	$group[] = Array("value" => "Manager", "name" => "Manager"); // Can add/edit/delete anything
	$group[] = Array("value" => "Administrator", "name" => "Administrator"); // Can do anything
	return $group;
}

/// Gets the list of valid choices for a source given a specific lineitem but still allows for the specific fundid
function getSourceSelections($lineitemid, $fundid, $publicOnly){
	global $database;
	$query  = "SELECT `id` value, `name` FROM source s WHERE `id` NOT IN (SELECT `source` FROM funds f ";
	$query .= "WHERE `lineitem` = " . intval($lineitemid) . " AND id != " . intval($fundid) . ") ";
	if($publicOnly){
		$query .= " AND `public` = 1 ";
	}
	$query .= "ORDER BY `name`;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Gets the list of valid choices for a company
function getCompanySelections(){
	global $database;
	$query = "SELECT `id` value, `name` FROM company c ORDER BY `name`";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

?>