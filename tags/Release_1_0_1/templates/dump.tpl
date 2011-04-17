{**
 * Project:     organization-budget-and-finance
 * File:        dump.tpl
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
<tables>
	<company>
{section name=mysec loop=$company}
		<record>
{foreach from=$company[mysec] item=entry key=name}
			<{$name}>{$entry}</{$name}>
{/foreach}
		</record>
{/section}
	</company>
	<documentation>
{section name=mysec loop=$documentation}
		<record>
{foreach from=$documentation[mysec] item=entry key=name}
			<{$name}>{$entry}</{$name}>
{/foreach}
		</record>
{/section}
	</documentation>
	<funds>
{section name=mysec loop=$funds}
		<record>
{foreach from=$funds[mysec] item=entry key=name}
			<{$name}>{$entry}</{$name}>
{/foreach}
		</record>
{/section}
	</funds>
	<lineitem>
{section name=mysec loop=$lineitem}
		<record>
{foreach from=$lineitem[mysec] item=entry key=name}
			<{$name}>{$entry}</{$name}>
{/foreach}
		</record>
{/section}
	</lineitem>
	<receipt>
{section name=mysec loop=$receipt}
		<record>
{foreach from=$receipt[mysec] item=entry key=name}
			<{$name}>{$entry}</{$name}>
{/foreach}
		</record>
{/section}
	</receipt>
	<sources>
{section name=mysec loop=$sources}
		<record>
{foreach from=$sources[mysec] item=entry key=name}
			<{$name}>{$entry}</{$name}>
{/foreach}
		</record>
{/section}
	</sources>
</tables>