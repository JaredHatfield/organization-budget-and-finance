<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.documentation.php
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
 * @version 1.0.0
 */

/// Returns all of the information for the receipts for a specified lineitem
function getDocumentationForLineItem($lineitem){
	global $database;
	$query = "SELECT `id`, `lineitem`, `name`, `link` FROM documentation d WHERE `lineitem` = " . $lineitem . ";";
	$result = $database->exec($query);
	$val = array();
	if($result){
		while($row = mysql_fetch_assoc($result)){
			$val[] = $row;
		}
	}
	
	return $val;
}

/// Gets the information for a specific document
function getDocumentation($id){
	global $database;
	$query = "SELECT `id`, `lineitem`, `name`, `link` FROM documentation d WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

/// Determines if the specified number is a valid documentation id number
function isdocumentation($id){
	global $database;
	$query = "SELECT COUNT(*) number FROM documentation d WHERE `id` = " . intval($id) . ";";
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


function insertDocumentation($lineitem, $name, $link){
	global $database;
	$query  = "INSERT INTO documentation (`lineitem`, `name`, `link`) ";
	$query .= "VALUES(" . intval($lineitem) . ", '" . $name . "', '" . $link . "');";
	$result = $database->exec($query);
}


function updateDocumentation($id, $name, $link){
	global $database;
	$query = "UPDATE documentation SET `name` = '" . $name . "', `link` = '" . $link . "' WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = $database->exec($query);
}


function deleteDocumentation($id){
	global $database;
	$query = "DELETE FROM documentation WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = $database->exec($query);
}


?>