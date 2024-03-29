{**
 * Project:     organization-budget-and-finance
 * File:        receiptAdd.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Add Receipt"}

{if $permissions.receiptAdd}
<form action="./index.php?page=process" method="post">
	<fieldset>
	<legend>Add Receipt</legend>
	<p><label>Name:</label><input type="text" name="receipt_name" /></p>
	<p><label>Description:</label><input type="text" name="receipt_description" /></p>
	<p><label>Company</label>{include file="dropdown.tpl" dd_selection=$company_selections dd_name="receipt_company" dd_selected="-1"}</p>
	<p><label>Amount:</label><input type="text" name="receipt_amount" /></p>
	<p>
		<label>Date:</label>
		{include file="dropdown.tpl" dd_selection=$month_selections dd_name="receipt_month" dd_selected="$current_month"} /
		{include file="dropdown.tpl" dd_selection=$day_selections dd_name="receipt_day" dd_selected="$current_day"} /
		<input type="text" name="receipt_year" value="{$current_year}" maxlength=4 size="4" />
	</p>
	<p>
	{if $permissions.publicOnly}
	<input type="hidden" name="receipt_public" value="yes" />
	{else}
	<label>Public:</label><input type="checkbox" name="receipt_public" value="yes" checked="checked" />
	{/if}
	</p>
	<p class="submit">
		<input type="hidden" name="receipt_lineitem" value="{$lineitem.id}" />
		<input type="hidden" name="key" value="{php}echo secureform_add('receiptAdd', 60){/php}" />
		<input type="hidden" name="action" value="receiptAdd" />
		<input type="submit" value="Add" />
	</p>
	</fieldset>
</form>
{/if}

{include file="footer.tpl"}
