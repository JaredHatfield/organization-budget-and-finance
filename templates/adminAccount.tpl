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

{include file="pagelink.tpl" page="adminConsole" parms="" text=#images_back#}<br /><br />

{if $permissions.admin}
	<div style="max-width: 500px;">
	<h2>User: {$user.username}</h2>
	<h3>Reset Password</h3>
	<form action="./index.php?page=process" method="post">
		<span>Password:</span><input type="password" name="user_password" /><br />
		<span>Confirm Password:</span><input type="password" name="user_password2" /><br />
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('resetPassword', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="user_id" value="{$user.id}" />
		<input type="hidden" name="action" value="resetPassword" />
		<input type="submit" value="Update" />
	</form>
	
	<h3>Change Group</h3>
	<form action="./index.php?page=process" method="post">
		<span>Group: </span>{include file="dropdown.tpl" dd_selection=$group_selections dd_name="user_group" dd_selected="`$user.group`"}<br />
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('changeGroup', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="user_id" value="{$user.id}" />
		<input type="hidden" name="action" value="changeGroup" />
		<input type="submit" value="Update" />
	</form>
	
	<h3>Account Status</h3>
	{if $user.active eq 1}
	<form action="./index.php?page=process" method="post">
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('setUserInactive', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="user_id" value="{$user.id}" />
		<input type="hidden" name="action" value="setUserInactive" />
		<input type="submit" value="Switch to Inactive" />
	</form>
	{else}
	<form action="./index.php?page=process" method="post">
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('setUserActive', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="user_id" value="{$user.id}" />
		<input type="hidden" name="action" value="setUserActive" />
		<input type="submit" value="Switch to Active" />
	</form>
	{/if}
	
	</div>
{/if}

{include file="footer.tpl"}
