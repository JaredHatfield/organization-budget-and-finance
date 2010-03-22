{**
 * Project:     organization-budget-and-finance
 * File:        sourceAdd.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Add Source"}

{if $permissions.sourceAdd}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Add Source</legend>
	<p><label>Name:</label><input type="text" name="source_name" /></p>
	<p>
	{if $permissions.publicOnly}
	<input type="hidden" name="source_public" value="yes" />
	{else}
	<label>Public:</label><input type="checkbox" name="source_public" value="yes" checked="checked" /><br />
	{/if}
	</p>
	<p class="submit">
		<input type="hidden" name="key" value="{php}echo secureform_add('sourceAdd', 60){/php}" />
		<input type="hidden" name="action" value="sourceAdd" />
		<input type="submit" value="Add" />
	</p>
	</fieldset>
</form>
{/if}

{include file="footer.tpl"}
