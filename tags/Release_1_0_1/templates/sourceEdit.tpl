{**
 * Project:     organization-budget-and-finance
 * File:        sourceEdit.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Edit Source"}

{if $permissions.publicOnly && $source.public == 0}{* PUBLIC ONLY *}
{else}

{if $permissions.sourceEdit}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Edit Source</legend>
	<p><label>Name:</label><input type="text" name="source_name" value="{$source.name}" /></p>
	<p>
	{if $permissions.publicOnly}
		{if $source.public == 1}
			<input type="hidden" name="source_public" value="yes" />
		{/if}
	{else}
		<label>Public:</label>
		{if $source.public == 1}
			<input type="checkbox" name="source_public" value="yes" checked="checked" />
		{else}
			<input type="checkbox" name="source_public" value="yes" />
		{/if}
		<br />
	{/if}
	</p>
	<p class="submit">
		<input type="hidden" name="source_id" value="{$source.id}" />
		<input type="hidden" name="key" value="{php}echo secureform_add_pk('sourceEdit', 60, $this->get_template_vars('id')){/php}" />
		<input type="hidden" name="action" value="sourceEdit" />
		<input type="submit" value="Update" />
	</p>
	</fieldset>
</form>
{/if}

<br />

{if $sourceCount == 0 && $permissions.sourceDelete}
	<form action="./index.php?page=process" method="post">
		<fieldset>
		<legend>Delete Source</legend>
		<p class="submit">
			<input type="hidden" name="source_id" value="{$source.id}" />
			<input type="hidden" name="key" value="{php}echo secureform_add_pk('sourceDelete', 60, $this->get_template_vars('id')){/php}" />
			<input type="hidden" name="action" value="sourceDelete" />
			<input type="submit" value="Delete" />
		</p>
		</fieldset>
	</form>
{/if}

{/if}{* PUBLIC ONLY *}

{include file="footer.tpl"}
