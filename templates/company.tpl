{**
 * Project:     organization-budget-and-finance
 * File:        company.tpl
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

<h2>Companies</h2>

<table>
	<tr class="tableheaderrow">
		<td>
			{if $permissions.companyAdd}
				{include file="pagelink.tpl" page="companyAdd" text=#images_add#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">Company Name</td>
	</tr>
{section name=mysec loop=$companies}
	<tr bgcolor="{cycle values="#eeeeee,#dddddd"}" valign=top>
		<td>
			{if $permissions.companyEdit || $permissions.companyDelete}
				{include file="pagelink.tpl" page="companyEdit" parms="companyid=`$companies[mysec].id`" text=#images_edit#}
			{else}
				{#images_blank#}
			{/if}
		</td>
		<td class="colmedium">{$companies[mysec].name}</td>
	</tr>
{/section}
</table>

{include file="footer.tpl"}