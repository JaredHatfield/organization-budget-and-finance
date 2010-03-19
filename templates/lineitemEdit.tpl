{**
 * Project:     organization-budget-and-finance
 * File:        lineitemEdit.tpl
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
 {include file="header.tpl" title="Organization Budget and Finance" pagename="Edit Line Item"}

{include file="pagelink.tpl" page="budget" parms="lineid=`$lineitem.parent`" text=#images_back#}<br /><br />

{if $permissions.publicOnly && $lineitem.public == 0}{* PUBLIC ONLY *}
{else}

{if $lineitemCount == 0 && $permissions.lineitemDelete}
	<form action="./index.php?page=process" method="post">
		<input type="hidden" name="lineitem_id" value="{$lineitem.id}" />
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('lineitemDelete', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="action" value="lineitemDelete" />
		<input type="submit" value="Delete" />
	</form>
{/if}

{if $permissions.lineitemEdit}
<form action="./index.php?page=process" method="post">
	<span>Name:</span><input type="text" name="lineitem_name" value="{$lineitem.name}" /><br />
	<span>Description:</span><input type="text" name="lineitem_description" value="{$lineitem.description}" /><br />
	{if $permissions.publicOnly}
		<input type="hidden" name="lineitem_public" value="yes" />
	{else}
		<span>Public:</span>
		{if $lineitem.public == 1}
			<input type="checkbox" name="lineitem_public" value="yes" checked="checked" />
		{else}
			<input type="checkbox" name="lineitem_public" value="yes" />
		{/if}
		<br />
	{/if}
	<input type="hidden" name="lineitem_id" value="{$lineitem.id}" />
	<input type="hidden" name="key" value="{php}echo secureform_add_pk('lineitemEdit', 60, $this->get_template_vars('id')){/php}" />
	<input type="hidden" name="action" value="lineitemEdit" />
	<input type="submit" value="Update" />
</form>
{/if}

{/if}

{include file="footer.tpl"}
