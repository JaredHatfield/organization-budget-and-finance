{**
 * Project:     organization-budget-and-finance
 * File:        fundsEdit.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Edit Funds"}

{if $permissions.publicOnly && $source.public == 0}{* PUBLIC ONLY *}
{else}

{if $permissions.fundsEdit}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Edit Funds</legend>
	<p><label>Source:</label>{include file="dropdown.tpl" dd_selection=$source_selections dd_name="funds_source" dd_selected=`$funds.source`}</p>
	<p><label>Amount:</label><input type="text" name="funds_amount" value="{$funds.amount}" /></p>
	<p class="submit">
		<input type="hidden" name="funds_id" value="{$funds.id}" />
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('fundsEdit', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="action" value="fundsEdit" />
		<input type="submit" value="Update" />
	</p>
	</fieldset>
</form>
{/if}

<br />

{if $permissions.fundsDelete}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Delete Funds</legend>
	<p class="submit">
		<input type="hidden" name="funds_id" value="{$funds.id}" />
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('fundsDelete', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="action" value="fundsDelete" />
		<input type="submit" value="Delete" />
	</p>
	</fieldset>
</form>
{/if}

{/if}

{include file="footer.tpl"}
