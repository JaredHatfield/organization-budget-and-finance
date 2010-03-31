{**
 * Project:     organization-budget-and-finance
 * File:        myAccount.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="My Account"}

<h2>User: {$user.username}</h2>
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Reset Password</legend>
	<p><label>Password:</label><input type="password" name="user_password" /></p>
	<p><label>Confirm Password:</label><input type="password" name="user_password2" /></p>
	<p class="submit">
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('changePassword', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="user_id" value="{$user.id}" />
		<input type="hidden" name="action" value="changePassword" />
		<input type="submit" value="Update" />
	</p>
	</fieldset>
</form>


<form>
	<fieldset>
	<legend>User Permissions</legend>
	<p><label>Public Records Only: </label>{include file="dropdown.tpl" dd_selected="`$permissions.publicOnly`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Add Company: </label>{include file="dropdown.tpl" dd_selected="`$permissions.companyAdd`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Edit Company: </label>{include file="dropdown.tpl" dd_selected="`$permissions.companyEdit`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Delete Company: </label>{include file="dropdown.tpl" dd_selected="`$permissions.companyDelete`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Add Funds: </label>{include file="dropdown.tpl" dd_selected="`$permissions.fundsAdd`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Edit Funds: </label>{include file="dropdown.tpl" dd_selected="`$permissions.fundsEdit`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Delete Funds: </label>{include file="dropdown.tpl" dd_selected="`$permissions.fundsDelete`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Add Line Item: </label>{include file="dropdown.tpl" dd_selected="`$permissions.lineitemAdd`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Edit Line Item: </label>{include file="dropdown.tpl" dd_selected="`$permissions.lineitemEdit`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Delete Line Item: </label>{include file="dropdown.tpl" dd_selected="`$permissions.lineitemDelete`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Add Receipt: </label>{include file="dropdown.tpl" dd_selected="`$permissions.receiptAdd`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Edit Receipt: </label>{include file="dropdown.tpl" dd_selected="`$permissions.receiptEdit`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Delete Receipt: </label>{include file="dropdown.tpl" dd_selected="`$permissions.receiptDelete`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Add Source: </label>{include file="dropdown.tpl" dd_selected="`$permissions.sourceAdd`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Edit Source: </label>{include file="dropdown.tpl" dd_selected="`$permissions.sourceEdit`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Delete Source: </label>{include file="dropdown.tpl" dd_selected="`$permissions.sourceDelete`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	<p><label>Administrator: </label>{include file="dropdown.tpl" dd_selected="`$permissions.admin`" dd_selection=$booleanOptions dd_name="" disabled="yes"}</p>
	</fieldset>
</form>

{include file="footer.tpl"}
