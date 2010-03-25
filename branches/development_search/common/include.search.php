<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.search.php
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

/// Get the raw search results for receipts
function searchReceipts($searchString, $publicOnly){
	global $database;
	$query  = "SELECT `id`, `name`, `description`, `company`, `amount`, `lineitem`, `rdate`, `public` FROM `receipt` ";
	$query .= "WHERE (`name` LIKE '%" . $searchString . "%' OR `description` LIKE '%" . $searchString . "%') ";
	if($publicOnly){
		$query .= "AND `public` = 1 ";
	}
	$query .= "ORDER BY `rdate` DESC;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Get the raw search results for lineitems
function searchLineItems($searchString, $publicOnly){
	global $database;
	$query  = "SELECT `id`, `name`, `description`, `parent`, `public` FROM lineitem ";
	$query .= "WHERE (`name` LIKE '%" . $searchString . "%' OR `description` LIKE '%" . $searchString . "%')";
	if($publicOnly){
		$query .= "AND `public` = 1 ";
	}
	$query .= "ORDER BY `name`;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

?>