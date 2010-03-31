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
 * @version 1.0.0
 *}
 {include file="header.tpl" title="Organization Budget and Finance" pagename="Edit Line Item"}

{if $permissions.publicOnly && $lineitem.public == 0}{* PUBLIC ONLY *}
{else}

{if $permissions.lineitemEdit}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Edit Line Item</legend>
	<p><label>Name:</label><input type="text" name="lineitem_name" value="{$lineitem.name}" /></p>
	<p><label>Description:</label><input type="text" name="lineitem_description" value="{$lineitem.description}" /></p>
	<p>
	{if $permissions.publicOnly}
		<input type="hidden" name="lineitem_public" value="yes" />
	{else}
		<label>Public:</label>
		{if $lineitem.public == 1}
			<input type="checkbox" name="lineitem_public" value="yes" checked="checked" />
		{else}
			<input type="checkbox" name="lineitem_public" value="yes" />
		{/if}
		<br />
	{/if}
	</p>
	<p class="submit">
		<input type="hidden" name="lineitem_id" value="{$lineitem.id}" />
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('lineitemEdit', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="action" value="lineitemEdit" />
		<input type="submit" value="Update" />
	</p>
	</fieldset>
</form>
{/if}

<br />

{if $lineitemCount == 0 && $permissions.lineitemDelete}
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Delete Line Item</legend>
		<p class="submit">
			<input type="hidden" name="lineitem_id" value="{$lineitem.id}" />
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('lineitemDelete', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="action" value="lineitemDelete" />
			<input type="submit" value="Delete" />
		</p>
		</fieldset>
	</form>
{/if}

{/if}

{include file="footer.tpl"}
