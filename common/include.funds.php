<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.funds.php
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

/// Gets all of the funding sources for a specific lineitem
function getFundsForLineItem($lineitem, $publicOnly){
	global $database;
	$query  = "SELECT f.`id`, f.`lineitem`, f.`source`, f.`amount`, s.`id` source_id, s.`name` source_name, s.`public`, ";
	$query .= "IFNULL((SELECT sum(f2.amount) allocated FROM lineitem l2 JOIN funds f2 ON l2.id = f2.lineitem WHERE l2.`parent` = f.`lineitem` AND f2.source = f.source),0) allocated ";
	$query .= "FROM funds f JOIN source s ON f.source = s.id WHERE f.`lineitem` = " . intval($lineitem) . " ";
	if($publicOnly){
		$query .= "AND s.`public` = 1 ";
	}
	$query .= "ORDER BY s.`name`;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Gets all of the sources that are used by lineitems under a parent
function getSourcesForLineItems($parent, $publicOnly){
	global $database;
	$query = "SELECT DISTINCT(f.source) id, s.name FROM lineitem l JOIN funds f ON l.id = f.lineitem ";
	$query .= "JOIN source s ON f.source = s.id WHERE `parent` = " . intval($parent) . " ";
	if($publicOnly){
		$query .= "AND s.`public` = 1 ";
	}
	$query .= ";";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Get the information for a specific fund
function getFund($id){
	global $database;
	$query = "SELECT `id`, `lineitem`, `source`, `amount` FROM funds f WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

/// Checks to see if the specified fund is not public.  Recursively checks the lineitem parents.
function isFundPrivate($id){
	global $database;
	$fund = getFund($id);
	$source = getSourceInformation($fund['source']);
	if($source['public'] == 0){
		return true;
	}
	else{
		return isLineItemPrivate($fund['lineitem']);
	}
}

/// Determines if the specified number is a valid funds id number
function isFund($id){
	global $database;
	$query = "SELECT COUNT(*) number FROM funds f WHERE `id` = " . intval($id) . ";";
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


function insertFunds($lineitem, $source, $amount){
	global $database;
	$query = "INSERT INTO funds (`lineitem`, `source`, `amount`) VALUES(" . intval($lineitem) . ", " . intval($source) . ", " . $amount . ");";
	$result = $database->exec($query);
}


function updateFunds($id, $source, $amount){
	global $database;
	$query = "UPDATE funds SET `source` = " . intval($source) . ", `amount` = " . $amount . " WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
}


function deleteFunds($id){
	global $database;
	$query = "DELETE FROM funds WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = $database->exec($query);
}

?>