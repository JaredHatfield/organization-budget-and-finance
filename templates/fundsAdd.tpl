{**
 * Project:     organization-budget-and-finance
 * File:        fundsAdd.tpl
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

<h2>Add Funds</h2>

{include file="pagelink.tpl" page="budget" parms="lineid=`$lineitem.id`" text="Back"}<br /><br />

<form action="./index.php?page=process" method="post">
	<span>Source:</span>{include file="dropdown.tpl" dd_selection=$source_selections dd_name="funds_source" dd_selected="-1"}<br />
	<span>Amount:</span><input type="text" name="funds_amount" /><br />
	<input type="hidden" name="action" value="fundsAdd" />
	<input type="submit" value="Update" />
</form>

{include file="footer.tpl"}
