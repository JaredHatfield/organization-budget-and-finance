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
 * @version 1.0.1
 *}
{include file="header.tpl" title="Organization Budget and Finance" pagename="Budget"}

{if $lineitem.id > 1}
<h2>{$lineitem.name}</h2>
<h4>{$lineitem.description}</h4>

<table>
	<thead>
	<tr class="tablename">
		<td colspan=2>Documentation</td>
	</tr>
	<tr class="tableheaderrow">
		<td>
			{if $permissions.documentationAdd}
				{include file="pagelink.tpl" page="documentationAdd" parms="lineid=`$lineitem.id`" text=#images_add#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">Name</td>
	</tr>
	</thead>
	<tbody>
{section name=mysec loop=$documentation}
	<tr class="{cycle values="rowTypeA,rowTypeB"}">
		<td>
			{if $permissions.documentationEdit || $permissions.documentationDelete}
				{include file="pagelink.tpl" page="documentationEdit" parms="documentationid=`$documentation[mysec].id`" text=#images_edit#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">
			{include file="pagelink.tpl" page="documentation" parms="documentationid=`$documentation[mysec].id`" text=`$documentation[mysec].name`}
		</td>
	</tr>
{/section}
	</tbody>
</table>

<br />

<table>
	<thead>
	<tr class="tablename">
		{if $permissions.publicOnly}
		<td colspan=5>Receipts</td>
		{else}
		<td colspan=6>Receipts</td>
		{/if}
	</tr>
	<tr class="tableheaderrow">
		<td>
			{if $permissions.receiptAdd}
				{include file="pagelink.tpl" page="receiptAdd" parms="lineid=`$lineitem.id`" text=#images_add#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">Company Name</td>
		<td class="colmedium">Line Item Name</td>
		<td class="colsmall">Amount</td>
		<td class="colsmall">Date</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">Public</td>
		{/if}
	</tr>
	</thead>
	<tbody>
{section name=mysec loop=$receipts}
	<tr class="{cycle values="rowTypeA,rowTypeB"}" valign=top>
		<td>
			{if $permissions.receiptEdit || $permissions.receiptDelete}
				{include file="pagelink.tpl" page="receiptEdit" parms="receiptid=`$receipts[mysec].id`" text=#images_edit#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">{$receipts[mysec].company_name}</td>
		<td class="colmedium">
			{$receipts[mysec].name}<br />
			<span>{$receipts[mysec].description}</span>
		</td>
		<td class="colsmall">${$receipts[mysec].amount}</td>
		<td class="colsmall">{$receipts[mysec].rdate|date_format}</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">{if $receipts[mysec].public eq 1}Yes{/if}</td>
		{/if}
	</tr>
{/section}
	</tbody>
</table>

<br />

<table>
	<thead>
	<tr class="tablename">
		{if $permissions.publicOnly}
		<td colspan=4>Funds</td>
		{else}
		<td colspan=5>Funds</td>
		{/if}
	</tr>
	<tr class="tableheaderrow">
		<td>
			{if $permissions.fundsAdd}
				{include file="pagelink.tpl" page="fundsAdd" parms="lineid=`$lineitem.id`" text=#images_add#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">Source</td>
		<td class="colsmall">Available</td>
		<td class="colsmall">Unallocated</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">Public</td>
		{/if}
	</tr>
	</thead>
	<tbody>
{section name=mysec loop=$funds}
	<tr class="{cycle values="rowTypeA,rowTypeB"}">
		<td>
			{if $permissions.fundsEdit || $permissions.fundsDelete}
				{include file="pagelink.tpl" page="fundsEdit" parms="fundsid=`$funds[mysec].id`" text=#images_edit#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">{$funds[mysec].source_name}</td>
		<td class="colsmall">${$funds[mysec].amount}</td>
		<td class="colsmall">${$funds[mysec].amount-$funds[mysec].allocated}</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">{if $funds[mysec].public eq 1}Yes{/if}</td>
		{/if}
	</tr>
{/section}
	</tbody>
</table>


{/if}

{if $treedepth < 3}
<h3>Line Items</h3>
<table>
	<thead>
	<tr class="tableheaderrow">
		<td>
			{if $permissions.lineitemAdd}
				{include file="pagelink.tpl" page="lineitemAdd" parms="lineid=`$lineitem.id`" text=#images_add#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">Item</td>
		<td class="colmedium">Description</td>
		<td class="colsmall">Receipts</td>
		{foreach from=$sources item=entry key=name}<td class="colsmall">{$entry.name}</td>{/foreach}
		<td class="colsmall">Surplus</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">Public</td>
		{/if}
	</tr>
	</thead>
	<tbody>
{section name=mysec loop=$children}
	{if $lineitem.id > 1 || $children[mysec].id > 0}
		<tr class="{cycle values="rowTypeA,rowTypeB"}">
			<td>{strip}
				{if $children[mysec].id > 0 && ($permissions.lineitemEdit || $permissions.lineitemDelete)}
					{include file="pagelink.tpl" page="lineitemEdit" parms="lineid=`$children[mysec].id`" text=#images_edit#}
				{else}
					{#images_blank#}
				{/if}
			{/strip}</td>
			<td class="colmedium">{strip}
				{if $children[mysec].id > 0}
					{include file="pagelink.tpl" page="budget" parms="lineid=`$children[mysec].id`" text="`$children[mysec].name`"}
				{else}
					{$children[mysec].name}
				{/if}
			{/strip}</td>
			<td class="colmedium">{$children[mysec].description}</td>
			<td class="colsmall">${$children[mysec].receipts}</td>
			{foreach from=$children[mysec].funds item=entry key=name}{strip}
			<td class="colsmall">${$entry}</td>
			{/strip}
			{/foreach}<td class="colsmall">${$children[mysec].difference}</td>
			{if !$permissions.publicOnly}
			<td class="colsmall">{if $children[mysec].public eq 1}Yes{/if}</td>
			{/if}
		</tr>
	{/if}
{/section}
	</tbody>
</table>
{/if}

{include file="footer.tpl"}