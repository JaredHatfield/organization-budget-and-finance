{**
 * Project:     organization-budget-and-finance
 * File:        companyEdit.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Edit Company"}

{if $permissions.companyEdit}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Edit Company</legend>
	<p><label>Name:</label><input type="text" name="company_name" value="{$company.name}" /></p>
	<p class="submit">
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('companyEdit', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="company_id" value="{$company.id}" />
		<input type="hidden" name="action" value="companyEdit" />
		<input type="submit" value="Update" />
	</p>
	</fieldset>
</form>
{/if}

<br />

{if $companyCount == 0 && $permissions.companyDelete}
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Delete Company</legend>
		<p class="submit">
			<input type="hidden" name="company_id" value="{$company.id}" />
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('companyDelete', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="action" value="companyDelete" />
			<input type="submit" value="Delete" />
		</p>
		</fieldset>
	</form>
{/if}

{include file="footer.tpl"}
