<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.admin.php
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

/// Gets an array of all of the users
function getAllUsers(){
	global $database;
	$query = "SELECT `id`, `username`, `group`, `active` FROM users;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){
		$val[] = $row;
	}
	
	return $val;
}

/*******************************************************************************************************
 * Insert/Update Queries
 ******************************************************************************************************/

/// Change a user's group
function setUserGroup($userid, $group){
	global $database;
	$query = "UPDATE users SET `group` = '" . $group . "' WHERE `id` = " . intval($userid) . " LIMIT 1;";
	$result = $database->exec($query);
}

/// Change a user to active
function setUserActive($userid){
	global $database;
	$query = "UPDATE users SET `active` = 1 WHERE `id` = " . intval($userid) . " LIMIT 1;";
	$result = $database->exec($query);
}

/// Change a user to inactive
function setUserInactive($userid){
	global $database;
	$query = "UPDATE users SET `active` = 0 WHERE `id` = " . intval($userid) . " LIMIT 1;";
	$result = $database->exec($query);
}
 
?>