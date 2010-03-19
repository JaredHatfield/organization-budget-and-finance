{**
 * Project:     organization-budget-and-finance
 * File:        receiptEdit.tpl
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
{include file="header.tpl" title="Organization Budget and Finance" pagename="Edit Receipt"}

{include file="pagelink.tpl" page="budget" parms="lineid=`$lineitem.id`" text=#images_back#}<br /><br />

{if $permissions.publicOnly && $receipt.public == 0}{* PUBLIC ONLY *}
{else}

{if $permissions.receiptDelete}
<form action="./index.php?page=process" method="post">
	<input type="hidden" name="receipt_id" value="{$receipt.id}" />
	<input type="hidden" name="key" value="{php}echo secureform_add_pk('receiptDelete', 60, $this->get_template_vars('id')){/php}" />
	<input type="hidden" name="action" value="receiptDelete" />
	<input type="submit" value="Delete" />
</form>
{/if}

{if $permissions.receiptEdit}
<form action="./index.php?page=process" method="post">
	<span>Name:</span><input type="text" name="receipt_name" value="{$receipt.name}" /><br />
	<span>Description:</span><input type="text" name="receipt_description" value="{$receipt.description}" /><br />
	<span>Company:</span>{include file="dropdown.tpl" dd_selection=$company_selections dd_name="receipt_company" dd_selected=$receipt.company}<br />
	<span>Amount:</span><input type="text" name="receipt_amount" value="{$receipt.amount}" /><br />
	<span>Date:</span><input type="text" name="receipt_rdate" value="{$receipt.rdate}" /><br />
	{if $permissions.publicOnly}
		<input type="hidden" name="receipt_public" value="yes" />
	{else}
		<span>Public:</span>
		{if $receipt.public == 1}
			<input type="checkbox" name="receipt_public" value="yes" checked="checked" />
		{else}
			<input type="checkbox" name="receipt_public" value="yes" />
		{/if}
		<br />
	{/if}
	<input type="hidden" name="receipt_id" value="{$receipt.id}" />
	<input type="hidden" name="key" value="{php}echo secureform_add_pk('receiptEdit', 60, $this->get_template_vars('id')){/php}" />
	<input type="hidden" name="action" value="receiptEdit" />
	<input type="submit" value="Update" />
</form>
{/if}

{/if}


{include file="footer.tpl"}
