<?php

/**
 * Project:     organization-budget-and-finance
 * File:        include.index.php
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

include_once("./common/include.lineitem.php");
include_once("./common/include.receipt.php");
include_once("./common/include.funds.php");
include_once("./common/include.dropdowns.php");

$conn = mysql_connect($_CONFIG['host'], $_CONFIG['username'] , $_CONFIG['password'] ) or die ('Error connecting to mysql');
$selected = mysql_select_db($_CONFIG['database'], $conn) or die ('Database unavailable');


?>