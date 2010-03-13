{**
 * Project:     organization-budget-and-finance
 * File:        dropdown.tpl
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
 
{* 
 * To use the dropdown list three variables need to be set.  They are:
 * $dd_name - the name of the dropdown list
 * $dd_selection - an array of the values in the list with the attributes value and name set
 * $dd_selected - the value in the array that is selected
 *}
 
<select name="{$dd_name}">
	{section name=ddloop loop=$dd_selection}
		{if $dd_selection[ddloop].value == $dd_selected}
			<option value="{$dd_selection[ddloop].value}" selected="selected">{$dd_selection[ddloop].name}</option>
		{else}
			<option value="{$dd_selection[ddloop].value}">{$dd_selection[ddloop].name}</option>
		{/if}
	{/section}
</select>