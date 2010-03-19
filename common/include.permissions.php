<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.permissions.php
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

/// Gets the permission values for the specified user
function getUserPermissions(){
	// TODO: this should vary these values based on the user's permission
	$permissions['cacheBudget'] = false;
	$permissions['publicOnly'] = false;
	$permissions['companyAdd'] = true;
	$permissions['companyEdit'] = true;
	$permissions['companyDelete'] = true;
	$permissions['fundsAdd'] = true;
	$permissions['fundsEdit'] = true;
	$permissions['fundsDelete'] = true;
	$permissions['lineitemAdd'] = true;
	$permissions['lineitemEdit'] = true;
	$permissions['lineitemDelete'] = true;
	$permissions['receiptAdd'] = true;
	$permissions['receiptEdit'] = true;
	$permissions['receiptDelete'] = true;
	$permissions['sourceAdd'] = true;
	$permissions['sourceEdit'] = true;
	$permissions['sourceDelete'] = true;
	return $permissions;
}



?>