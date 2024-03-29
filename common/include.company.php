<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.company.php
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

/// Gets a list of all of the companies
function getAllCompanies(){
	global $database;
	$query = "SELECT `id`, `name` FROM company c;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Gets the information for a specific company
function getCompanyInformation($id){
	global $database;
	$query = "SELECT `id`, `name` FROM company c WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

/// Gets the number of times a company was listed as used by a receipt
function getCompanyUseCount($id){
	global $database;
	$query = "SELECT COUNT(*) number FROM receipt WHERE `company` = " .  intval($id). ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row['number'];
}

/// Determines if the specified number is a valid company id number
function isCompany($id){
	global $database;
	$query = "SELECT COUNT(*) number FROM company c WHERE `id` = " . intval($id) . ";";
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


function insertCompany($name){
	global $database;
	$query = "INSERT INTO company (`name`) VALUES('" . $name . "');";
	$result = $database->exec($query);
}


function updateCompany($id, $name){
	global $database;
	$query = "UPDATE company SET `name` = '" . $name . "' WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = $database->exec($query);
}


function deleteCompany($id){
	global $database;
	$query = "DELETE FROM company WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = $database->exec($query);
}

?>