{**
 * Project:     organization-budget-and-finance
 * File:        adminAccount.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Admin Account"}

{if $permissions.admin}
	<h2>User: {$user.username}</h2>
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Reset Password</legend>
		<p><label>Password:</label><input type="password" name="user_password" /></p>
		<p><label>Confirm Password:</label><input type="password" name="user_password2" /></p>
		<p class="submit">
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('resetPassword', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="user_id" value="{$user.id}" />
			<input type="hidden" name="action" value="resetPassword" />
			<input type="submit" value="Update" />
		</p>
		</fieldset>
	</form>
	
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Change Group</legend>
		<p><label>Group: </label>{include file="dropdown.tpl" dd_selection=$group_selections dd_name="user_group" dd_selected="`$user.group`"}</p>
		<p class="submit">
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('changeGroup', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="user_id" value="{$user.id}" />
			<input type="hidden" name="action" value="changeGroup" />
			<input type="submit" value="Update" />
		</p>
		</fieldset>
	</form>
	
	{if $user.active eq 1}
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Account Status</legend>
		<p class="submit">
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('setUserInactive', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="user_id" value="{$user.id}" />
			<input type="hidden" name="action" value="setUserInactive" />
			<input type="submit" value="Switch to Inactive" />
		</p>
		</fieldset>
	</form>
	{else}
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Account Status</legend>
		<p class="submit">
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('setUserActive', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="user_id" value="{$user.id}" />
			<input type="hidden" name="action" value="setUserActive" />
			<input type="submit" value="Switch to Active" />
		</p>
		</fieldset>
	</form>
	{/if}
	
{/if}

{include file="footer.tpl"}
