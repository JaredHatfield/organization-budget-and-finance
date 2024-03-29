{**
 * Project:     organization-budget-and-finance
 * File:        fundsAdd.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Add Funds"}

{if $permissions.fundsAdd}
{if $source_selections|@count > 0}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Add Funds</legend>
	<p><label>Source:</label>{include file="dropdown.tpl" dd_selection=$source_selections dd_name="funds_source" dd_selected="-1"}</p>
	<p><label>Amount:</label><input type="text" name="funds_amount" /></p>
	<p class="submit">
		<input type="hidden" name="funds_lineitem" value="{$lineitem.id}" />
		<input type="hidden" name="key" value="{php}echo secureform_add('fundsAdd', 60){/php}" />
		<input type="hidden" name="action" value="fundsAdd" />
		<input type="submit" value="Update" />
	</p>
	</fieldset>
</form>
{else}
<h3>There are no unused fund sources.</h3>
{/if}
{/if}

{include file="footer.tpl"}
