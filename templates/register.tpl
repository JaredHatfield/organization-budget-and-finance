{**
 * Project:     organization-budget-and-finance
 * File:        register.tpl
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
 *}
{include file="header.tpl" title="Organization Budget and Finance" pagename="Register"}

{if $permissions.register}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Register a New Account</legend>
	<p><label>Username:</label><input class="insmall" type="text" name="register_username" /></p>
	<p><label>Password:</label><input class="insmall" type="password" name="register_password" /></p>
	<p><label>Confirm Password:</label><input class="insmall" type="password" name="register_password2" /></p>
	<p>{$recaptcha}</p>
	<p class="submit">
		<input type="hidden" name="key" value="{php}echo secureform_add('register', 60){/php}" />
		<input type="hidden" name="action" value="register" />
		<input type="submit" value="Register" />
	</p>
	</fieldset>
</form>
{else}
<h3>Registration disabled.</h3>
{/if}


{include file="footer.tpl"}
