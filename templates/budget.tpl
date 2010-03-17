{**
 * Project:     organization-budget-and-finance
 * File:        budget.tpl
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

{if $lineitem.id > 1}
	{include file="pagelink.tpl" page="budget" parms="lineid=`$lineitem.parent`" text="Back"}
{/if}

<br />
{include file="pagelink.tpl" page="lineitemAdd" parms="lineid=`$lineitem.id`" text="Add a Line Item"}<br />
{include file="pagelink.tpl" page="receiptAdd" parms="lineid=`$lineitem.id`" text="Add a Receipt"}<br />
{include file="pagelink.tpl" page="fundsAdd" parms="lineid=`$lineitem.id`" text="Add Funds"}<br />

<h2>Budget</h2>

{if $lineitem.id > 1}
	<h3>Information</h3>
	{include file="pagelink.tpl" page="lineitemEdit" parms="lineid=`$lineitem.id`" text="Edit Line Item"}<br />
	<span>Name:</span> {$lineitem.name}<br />
	<span>Description:</span> {$lineitem.description}<br />
	<br />
{/if}


{if $receipts|@count > 0}
	<h3>Receipts</h3>
	<table width="100%">
		<tr>
			<td></td>
			<td>Company</td>
			<td>Name</td>
			<td>Amount</td>
			<td>Date</td>
		</tr>
	{section name=mysec loop=$receipts}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}" valign=top>
			<td>{include file="pagelink.tpl" page="receiptEdit" parms="receiptid=`$receipts[mysec].id`" text="Edit"}</td>
			<td>{$receipts[mysec].company_name}</td>
			<td>
				{$receipts[mysec].name}<br />
				<span>{$receipts[mysec].description}</span>
			</td>
			<td>${$receipts[mysec].amount}</td>
			<td>{$receipts[mysec].rdate}</td>
		</tr>
	{/section}
	</table>
{/if}


{if $funds|@count > 0}
	<h3>Funds</h3>
	<table width="100%">
		<tr>
			<td></td>
			<td>Source</td>
			<td>Available</td>
			<td>Unallocated</td>
		</tr>
	{section name=mysec loop=$funds}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td>{include file="pagelink.tpl" page="fundsEdit" parms="fundsid=`$funds[mysec].id`" text="Edit"}</td>
			<td>{$funds[mysec].source_name}</td>
			<td>${$funds[mysec].amount}</td>
			<td>${$funds[mysec].amount-$funds[mysec].allocated}</td>
		</tr>
	{/section}
	</table>
{/if}

<h3>Line Items</h3>
{if $children|@count > 1}
	<table width="100%">
		<tr>
			<td>Item</td>
			<td>Description</td>
			<td width=75>Receipts</td>
			{foreach from=$sources item=entry key=name} 
				<td width=75>{$entry.name}</td> 
			{/foreach}
			<td>Surplus</td>
		</tr>
	{section name=mysec loop=$children}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
			<td width=200>
				{if $children[mysec].id > 0}
					{include file="pagelink.tpl" page="budget" parms="lineid=`$children[mysec].id`" text="`$children[mysec].name`"}
				{else}
					{$children[mysec].name}
				{/if}
			</td>
			<td>{$children[mysec].description}</td>
			<td width=75>${$children[mysec].receipts}</td>
			{foreach from=$children[mysec].funds item=entry key=name} 
				<td width=75>${$entry}</td> 
			{/foreach}
			<td width=75>${$children[mysec].difference}</td>
		</tr>
	{/section}
	</table>
{else}
<span>No line items under this budget.</span>
{/if}


{include file="footer.tpl"}