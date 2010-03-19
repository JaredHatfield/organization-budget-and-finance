<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.user.php
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

/// Authenticate a user and return their user id; zero if authentication fails
function authenticateUser($username, $password){
	global $database;
	$query = "SELECT IFNULL(MIN(`id`),0) id FROM users WHERE `username` = '" . $username . "' AND `password` = sha1('" . $password . "') LIMIT 1;";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row['id'];
}

/// Get the information about a user
function getUser($id){
	global $database;
	$query = "SELECT `id`, `username`, `group`, `active` FROM users u WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	return $row;
}

/// Determines if the specified number is a valid user id number
function isUser($id){
	global $database;
	$query = "SELECT COUNT(*) number FROM users u WHERE `id` = " . intval($id) . ";";
	$result = $database->exec($query);
	$row = mysql_fetch_assoc($result);
	if($row['number'] == "1"){
		return true;
	}
	else{
		return false;
	}
}

?>