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
 * @version 1.0
 *}
{include file="header.tpl" title="Organization Budget and Finance" pagename="Search"}

<h2>Search: {$searchString}</h2>

<h4>Located {$resultReceipts|@count} receipts</h4>
<table>
	<tr class="tablename">
		<td colspan=2>Receipt Search Results</td>
	</tr>
	<tr class="tableheaderrow">
		<td class="colmedium">Name</td>
		<td class="colmedium">Description</td>
	</tr>
{section name=mysec loop=$resultReceipts}
	<tr class="{cycle values="rowTypeA,rowTypeB"}" valign=top>
		<td class="colmedium">{$resultReceipts[mysec].name}</td>
		<td class="colmedium">{$resultReceipts[mysec].description}</td>
	</tr>
{/section}
</table>

<h4>Located {$resultsLineItem|@count} line items</h4>
<table>
	<tr class="tablename">
		<td colspan=2>Line Item Search Results</td>
	</tr>
	<tr class="tableheaderrow">
		<td class="colmedium">Name</td>
		<td class="colmedium">Description</td>
	</tr>
{section name=mysec loop=$resultsLineItem}
	<tr class="{cycle values="rowTypeA,rowTypeB"}" valign=top>
		<td class="colmedium">{$resultsLineItem[mysec].name}</td>
		<td class="colmedium">{$resultsLineItem[mysec].description}</td>
	</tr>
{/section}
</table>

{include file="footer.tpl"}
