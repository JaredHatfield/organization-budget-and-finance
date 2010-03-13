{**
 * Project:     organization-budget-and-finance
 * File:        editbudget.tpl
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
 {include file="header.tpl" title="Organization Budget and Finance"}

<h2>Edit Budget</h2>

<h3>Information</h3>	
	<form action="./index.php?page=process" method="post">
		<input type="text" name="lineitem_name" value="{$lineitem.name}" /><br />
		<input type="text" name="lineitem_description" value="{$lineitem.description}" /><br />
		<span>Private:</span>
		{if $lineitem.private == 1}
			<input type="checkbox" name="lineitem_private" value="yes" checked="checked" />
		{else}
			<input type="checkbox" name="lineitem_private" value="yes" />
		{/if}
		<br />
		<input type="hidden" name="lineitem_id" value="{$lineitem.id}" />
		<input type="hidden" name="action" value="editbudgetinfo" />
		<input type="submit" value="Update" />
	</form>

	
<h3>Receipts</h3>
{if $receipts|@count > 0}
	<table width="100%">
	{section name=mysec loop=$receipts}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}" valign=top>
			<td>{$receipts[mysec].id}</td>
			<td>{$receipts[mysec].name}</td>
			<td>{$receipts[mysec].description}</td>
			<td>{include file="dropdown.tpl" dd_selection=$company_selections dd_name="company_id" dd_selected=$receipts[mysec].company_id}</td>
			<td>{$receipts[mysec].amount}</td>
			<td>{$receipts[mysec].rdate}</td>
			<td>{$receipts[mysec].public}</td>
		</tr>
	{/section}
	</table>
{/if}

<h3>Funds</h3>
{if $funds|@count > 0}
	<table width="100%">
		<tr>
			<td>Source</td>
			<td>Allocated Funds</td>
		</tr>
	{section name=mysec loop=$funds}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td>{include file="dropdown.tpl" dd_selection=$status_selections dd_name="source" dd_selected=$funds[mysec].source_id}</td>
			<td>${$funds[mysec].amount}</td>
		</tr>
	{/section}
	</table>
{/if}





{include file="footer.tpl"}
