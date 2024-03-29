<?php

/**
 * Project:     organization-budget-and-finance
 * File:        config.php
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
/****************************************************************************
 * INSTRUCTIONS
 * 
 * Fill in the following information and then rename this file to config.php
 * 
 ****************************************************************************/

// Smarty Library
$_CONFIG['smarty'] = '../libs/Smarty.class.php';

// Database Settings
$_CONFIG['host'] = 'localhost';
$_CONFIG['database'] = 'budget';
$_CONFIG['username'] = 'username';
$_CONFIG['password'] = 'password';

// reCAPTCHA Settings
$_CONFIG['recaptcha_public'] = ""; // To enable, fill in public key
$_CONFIG['recaptcha_private'] = ""; // To enable, fill in private key

?>