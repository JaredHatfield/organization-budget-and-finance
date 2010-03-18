<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.form.protect.php
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

///Given the form's name and time to live, add it as a valid key in the database
function secureform_add($name, $ttl){
	global $database;
	$uuid = uniqid("U",true);
	$query = "INSERT INTO form (`key`, `expires`, `name`, `session`) VALUES('" . $uuid . "', DATE_ADD(NOW(), INTERVAL " . $ttl . " MINUTE), '" . $name . "', '" . session_id() . "');";
	$result = $database->exec($query);
	return $uuid;
}

///Test if a key for a given form is valid, if so, invalidate it (one time use) and return true, otherwise return false
function secureform_test($key, $name){
	global $database;
	//Remove expired sessions
	secureform_purge();
	//Is the key valid?
	$query = "SELECT COUNT(*) num FROM form WHERE `key` = '" . $key . "'";
	$result = $database->exec($query);
	$row = mysql_fetch_row($result);
	$found = $row[0];
	//The key was found, lets do some more processing...
	if($found == 1){
		$query = "SELECT `name`, `session` FROM form WHERE `key` = '" . $key . "';";
		$result = $database->exec($query);
		$row = mysql_fetch_row($result);
		//Test if the session expired...
			//We don't do this because we just removed all of the expired sessions from the database
		//Test if the form name matches
		if($row[0] != $name){
			return false; //INVALID
		}
		//Test if the session matches
		if($row[1] != session_id()){
			return false; //INVALID
		}
	}
	//The key was not found so we are done...
	else{
		return false; //INVALID
	}
	//Invalidate the current key
	$query = "DELETE FROM form WHERE `key` = '" . $key . "' LIMIT 1;";
	$result = $database->exec($query);
	//After all of those test, we are sure the session is valid!
	return true; //VALID
}


// FORM VALIDATION THAT IS BOUND TO A PRIMARY KEY

///Given the form's name and time to live, add it as a valid choice in the database
function secureform_add_pk($name, $ttl, $pk){
	global $database;
	$uuid = uniqid("U",true);
	$query = "INSERT INTO form (`key`, `expires`, `name`, `session`, `pk`) VALUES('" . $uuid . "', DATE_ADD(NOW(), INTERVAL " . $ttl . " MINUTE), '" . $name . "', '" . session_id() . "', '" . $pk . "');";
	$result = $database->exec($query);
	return $uuid;
}

//Test if a key for a given form is valid, if so, invalidate it (one time use) and return true, otherwise return false
function secureform_test_pk($key, $name, $pk){
	global $database;
	//Remove expired sessions
	secureform_purge();
	//Is the key valid?
	$query = "SELECT COUNT(*) num FROM form WHERE `key` = '" . $key . "'";
	$result = $database->exec($query);
	$row = mysql_fetch_row($result);
	$found = $row[0];
	//The key was found, lets do some more processing...
	if($found == 1){
		$query = "SELECT `name`, `session`, `pk` FROM form WHERE `key` = '" . $key . "';";
		$result = $database->exec($query);
		$row = mysql_fetch_row($result);
		//Test if the session expired...
			//We don't do this because we just removed all of the expired sessions from the database
		//Test if the form name matches
		if($row[0] != $name){
			return false; //INVALID
		}
		//Test if the session matches
		if($row[1] != session_id()){
			return false; //INVALID
		}
		//Test if the pk matches
		if($row[2] != $pk){
			return false; //INVALID
		}
	}
	//The key was not found so we are done...
	else{
		return false; //INVALID
	}
	//Invalidate the current key
	$query = "DELETE FROM form WHERE `key` = '" . $key . "' LIMIT 1;";
	$result = $database->exec($query);
	//After all of those test, we are sure the session is valid!
	return true; //VALID
}

//Remove all of the exired sessions from the database
function secureform_purge(){
	global $database;
	$query = "DELETE FROM form WHERE `expires` < NOW();";
	$result = $database->exec($query);
}

?>