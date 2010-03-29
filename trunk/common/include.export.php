<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.export.php
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

/// Returns an array of all of the companies
function dumpCompany(){
	global $database;
	$query = "SELECT `id`, `name` FROM company c;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){ 
		$val[] = $row;
	}
	
	return $val;
}

/// Returns an array of all of the documentation
function dumpDocumentation($publicOnly){
	global $database;
	$query = "SELECT `id`, `lineitem`, `name`, `link` FROM documentation d;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){ 
		// If only public records are being accessed, only return those records
		if(!($publicOnly && isLineItemPrivate($row['lineitem']))){
			$val[] = $row;
		}
	}
	
	return $val;
}

/// Returns an array of all of the funds
function dumpFunds($publicOnly){
	global $database;
	$query = "SELECT `id`, `lineitem`, `source`, `amount` FROM funds f;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){ 
		// If only public records are being accessed, only return those records
		if(!($publicOnly && isFundPrivate($row['id']))){
			$val[] = $row;
		}
	}
	
	return $val;
}

/// Returns an array of all of the lineitems
function dumpLineItems($publicOnly){
	global $database;
	$query = "SELECT `id`, `name`, `description`, `parent`, `public` FROM lineitem l;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){ 
		// If only public records are being accessed, only return those records
		if(!($publicOnly && isLineItemPrivate($row['id']))){
				$val[] = $row;
		}
	}
	
	return $val;
}

/// Returns an array of all of the receipts
function dumpReceipt($publicOnly){
	global $database;
	$query = "SELECT `id`, `name`, `description`, `company`, `amount`, `lineitem`, `rdate`, `public` FROM receipt r;";
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){ 
		// If only public records are being accessed, only return those records
		if(!($publicOnly && isReceiptPrivate($row['id']))){
				$val[] = $row;
		}
	}
	
	return $val;
}

/// Returns an array of all of the sources
function dumpSources($publicOnly){
	global $database;
	$query = "";
	if($publicOnly){
		$query .= "SELECT `id`, `name`, `public` FROM source s WHERE `public` = 1;";
	}
	else{
		$query .= "SELECT `id`, `name`, `public` FROM source s;";
	}
	$result = $database->exec($query);
	$val = array();
	while($row = mysql_fetch_assoc($result)){ 
		$val[] = $row;
	}
	
	return $val;
}

?>