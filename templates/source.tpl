{**
 * Project:     organization-budget-and-finance
 * File:        source.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Sources"}

<table>
	<tr class="tablename">
		<td colspan=3>Sources</td>
	</tr>
	<tr class="tableheaderrow">
		<td >
			{if $permissions.sourceAdd}
				{include file="pagelink.tpl" page="sourceAdd" text=#images_add#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">Source Name</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">Public</td>
		{/if}
	</tr>
{section name=mysec loop=$sources}
	<tr class="{cycle values="rowTypeA,rowTypeB"}" valign=top>
		<td>
			{if $permissions.sourceEdit || $permissions.sourceDelete}
				{include file="pagelink.tpl" page="sourceEdit" parms="sourceid=`$sources[mysec].id`" text=#images_edit#}</td>
			{else}
				{#images_blank#}
			{/if}
		<td class="colmedium">{$sources[mysec].name}</td>
		{if !$permissions.publicOnly}
		<td class="colsmall">{if $sources[mysec].public eq 1}Yes{/if}</td>
		{/if}
	</tr>
{/section}
</table>

{include file="footer.tpl"}