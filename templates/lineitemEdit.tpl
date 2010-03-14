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
 {include file="header.tpl" title="Organization Budget and Finance"}

<h2>Edit Line Item</h2>

{include file="pagelink.tpl" page="budget" parms="lineid=`$lineitem.id`" text="Back"}


<h3>Information</h3>	
<form action="./index.php?page=process" method="post">
	<input type="text" name="lineitem_name" value="{$lineitem.name}" /><br />
	<input type="text" name="lineitem_description" value="{$lineitem.description}" /><br />
	<span>Private:</span>
	{if $lineitem.private == 1}
		<input type="checkbox" name="lineitem_private" value="yes" checked="checked" />
	{else}
		<input type="checkbox" name="lineitem_private" value="yes" />
	{/if}
	<br />
	<input type="hidden" name="lineitem_id" value="{$lineitem.id}" />
	<input type="hidden" name="action" value="lineitemEdit" />
	<input type="submit" value="Update" />
</form>


{include file="footer.tpl"}
