<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.source.php
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

/// Gets a list of all of the sources
function getAllSources(){
	$query = "SELECT `id`, `name`, `public` FROM source s;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Gets the information for a specific source
function getSourceInformation($id){
	$query = "SELECT `id`, `name`, `public` FROM source s WHERE `id` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function getSourceUseCount($id){
	$query = "SELECT COUNT(*) number FROM funds WHERE `source` = " . intval($id) . ";";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	return $row['number'];
}

/*******************************************************************************************************
 * Insert/Update Queries
 ******************************************************************************************************/


function insertSource($name, $public){
	$query = "INSERT INTO source (`name`, `public`) VALUES('" . $name . "', " . intval($public) . ");";
	$result = mysql_query($query);
}


function updateSource($id, $name, $public){
	$query = "UPDATE source SET `name` = '" . $name . "', `public` = " . intval($public) . " WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = mysql_query($query);
}


function deleteSource($id){
	$query = "DELETE FROM source WHERE `id` = " . intval($id) . " LIMIT 1;";
	$result = mysql_query($query);
}

?>