{**
 * Project:     organization-budget-and-finance
 * File:        index.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Home"}

{if !$isAuthenticated}
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Login</legend>
		<p><label>Username:</label><input class="insmall" type="text" name="login_username" /></p>
		<p><label>Password:</label><input class="insmall" type="password" name="login_password" /></p>
		<p class="submit">
			<input type="hidden" name="key" value="{php}echo secureform_add('login', 60){/php}" />
			<input type="hidden" name="action" value="login" />
			<input type="submit" value="Login" />
		</p>
		</fieldset>
	</form>
{else}
You have successfully logged in!
{/if}

{include file="footer.tpl"}
