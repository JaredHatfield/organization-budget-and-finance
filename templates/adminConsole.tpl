{**
 * Project:     organization-budget-and-finance
 * File:        adminConsole.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Admin Console"}

{if $permissions.admin}
<table>
	<tr class="tablename">
		<td colspan=4>Users</td>
	</tr>
	<tr class="tableheaderrow">
		<td>
			{#images_blank#}
		</td>
		<td class="colmedium">User</td>
		<td class="colmedium">Group</td>
		<td class="colsmall">Active</td>
	</tr>
{section name=mysec loop=$users}
	<tr class="{cycle values="rowTypeA,rowTypeB"}" valign=top>
		<td>
			{include file="pagelink.tpl" page="adminAccount" parms="userid=`$users[mysec].id`" text=#images_edit#}
		</td>
		<td class="colmedium">{$users[mysec].username}</td>
		<td class="colmedium">{$users[mysec].group}</td>
		<td class="colsmall">{if $users[mysec].active eq 1}Yes{/if}</td>
	</tr>
{/section}
</table>
{/if}

{include file="footer.tpl"}
