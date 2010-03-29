{**
 * Project:     organization-budget-and-finance
 * File:        documentationEdit.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Edit Documentation"}

{if $permissions.documentationEdit}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Edit Documentation</legend>
	<p><label>Name:</label><input type="text" name="documentation_name" value="{$documentation.name}" /></p>
	<p><label>Link:</label><input type="text" name="documentation_link" value="{$documentation.link}" /></p>
	<p class="submit">
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('documentationEdit', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="documentation_id" value="{$documentation.id}" />
		<input type="hidden" name="action" value="documentationEdit" />
		<input type="submit" value="Update" />
	</p>
	</fieldset>
</form>
{/if}

<br />

{if $permissions.documentationDelete}
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Delete Documentation</legend>
		<p class="submit">
			<input type="hidden" name="documentation_id" value="{$documentation.id}" />
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('documentationDelete', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="action" value="documentationDelete" />
			<input type="submit" value="Delete" />
		</p>
		</fieldset>
	</form>
{/if}

{include file="footer.tpl"}
