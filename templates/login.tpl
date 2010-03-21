{**
 * Project:     organization-budget-and-finance
 * File:        login.tpl
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
 *}

{if $permissions.register}
	{include file="pagelink.tpl" page="register" parms="" text="Register New Account"}
{/if}

{if !$isAuthenticated}
	<form action="./index.php?page=process" method="post">
		<span>Username:</span><input class="insmall" type="text" name="login_username" />
		<br />
		<span>Password:</span><input class="insmall" type="password" name="login_password" />
		<input type="hidden" name="key" value="{php}echo secureform_add('login', 60){/php}" />
		<input type="hidden" name="action" value="login" />
		<input type="submit" value="Login" />
	</form>
{else}
	<div style="text-align:right;">
	({$userInformation.group}) {include file="pagelink.tpl" page="myAccount" parms="" text="`$userInformation.username`"}<br />
	{if $permissions.admin}
		{include file="pagelink.tpl" page="adminConsole" parms="" text="Admin Console"}<br />
	{/if}
	{include file="pagelink.tpl" page="logout" parms="" text="Logout"}
	</div>
{/if}