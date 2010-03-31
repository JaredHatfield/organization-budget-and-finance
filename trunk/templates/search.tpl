{**
 * Project:     organization-budget-and-finance
 * File:        search.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Search"}

<h2>Search: {$searchString}</h2>

<h4>Located {$resultReceipts|@count} receipts</h4>
<table>
	<tr class="tablename">
		<td colspan={if $permissions.publicOnly}5{else}6{/if}>Receipt Search Results</td>
	</tr>
	<tr class="tableheaderrow">
		<td>Parents</td>
		<td class="colmedium">Name</td>
		<td class="colmedium">Description</td>
		<td class="colsmall">Amount</td>
		<td class="colsmall">Date</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">Public</td>
		{/if}
	</tr>
{section name=mysec loop=$resultReceipts}
	<tr class="{cycle values="rowTypeA,rowTypeB"}" valign=top>
		<td>
			{foreach from=$resultReceipts[mysec].nav item=entry key=name}
				> {include file="pagelink.tpl" page="`$entry.page`" parms="`$entry.parms`" text="`$entry.text`"}
			{/foreach}
			>
		</td>
		<td class="colmedium">
			{include file="pagelink.tpl" page="budget" parms="lineid=`$resultReceipts[mysec].lineitem`" text="`$resultReceipts[mysec].name`"}
		</td>
		<td class="colmedium">{$resultReceipts[mysec].description}</td>
		<td class="colsmall">${$resultReceipts[mysec].amount}</td>
		<td class="colsmall">{$resultReceipts[mysec].rdate|date_format}</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">{if $resultReceipts[mysec].public eq 1}Yes{/if}</td>
		{/if}
	</tr>
{/section}
</table>

<h4>Located {$resultsLineItem|@count} line items</h4>
<table>
	<tr class="tablename">
		<td colspan={if $permissions.publicOnly}3{else}4{/if}>Line Item Search Results</td>
	</tr>
	<tr class="tableheaderrow">
		<td>Parents</td>
		<td class="colmedium">Name</td>
		<td class="colmedium">Description</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">Public</td>
		{/if}
	</tr>
{section name=mysec loop=$resultsLineItem}
	<tr class="{cycle values="rowTypeA,rowTypeB"}" valign=top>
		 <td>
			{foreach from=$resultsLineItem[mysec].nav item=entry key=name}
				> {include file="pagelink.tpl" page="`$entry.page`" parms="`$entry.parms`" text="`$entry.text`"}
			{/foreach}
			>
		</td>
		<td class="colmedium">
			{include file="pagelink.tpl" page="budget" parms="lineid=`$resultsLineItem[mysec].id`" text="`$resultsLineItem[mysec].name`"}
		</td>
		<td class="colmedium">{$resultsLineItem[mysec].description}</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">{if $resultsLineItem[mysec].public eq 1}Yes{/if}</td>
		{/if}
	</tr>
{/section}
</table>

{include file="footer.tpl"}
