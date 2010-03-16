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

/// Gets the list of valid choices for a source given a specific lineitem but still allows for the specific fundid
function getSourceSelections($lineitemid, $fundid){
	$query  = "SELECT `id` value, `name` FROM source s WHERE `id` NOT IN (SELECT `source` FROM funds f ";
	$query .= "WHERE `lineitem` = " . intval($lineitemid) . " AND id != " . intval($fundid) . ") ORDER BY `name`;";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/// Gets the list of valid choices for a company
function getCompanySelections(){
	$query = "SELECT `id` value, `name` FROM company c ORDER BY `name`";
	$result = mysql_query($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

?>