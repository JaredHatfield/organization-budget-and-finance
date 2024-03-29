{**
 * Project:     organization-budget-and-finance
 * File:        footer.tpl
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
	</div>
	<div id="footerwrapper">
		{dynamic}
			<p>The page was generated with {$database->getQueryCount()} queries.</p>
			{if isset($pagecache)}
				<p>The contents of this page have been cached to improve performance.</p>
			{/if}
		{/dynamic}
		<p>Powered By: <a href="http://code.google.com/p/organization-budget-and-finance/">organization-budget-and-finance</a></p>
	</div>
</div>
</body>
</html>
