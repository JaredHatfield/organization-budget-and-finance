{**
 * Project:     organization-budget-and-finance
 * File:        header.tpl
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
{config_load file=images.conf}
<html>
<head>
	<title>{$title} - {$pagename}</title>
	<link rel="stylesheet" type="text/css" href="./static/style.css" />
</head>
<body bgcolor="#ffffff">
<div id="bodywrapper">
	<div id="topgraphic">
		<img src="./static/budgetr_graphic.png" />
	</div>
	<div id="headerwrapper">
		<h1><a href="./index.php">Organization Budget and Finance</a></h1>
		<br />
		<ul id="tabmenu">
			<li id="{if $selectedTab eq "Home"}selectedtab{/if}">
				{include file="pagelink.tpl" page="home" parms="" text="Home"}
			</li>
			<li id="{if $selectedTab eq "Budget"}selectedtab{/if}">
				{include file="pagelink.tpl" page="budget" parms="" text="Budget"}
			</li>
			<li id="{if $selectedTab eq "Company"}selectedtab{/if}">
				{include file="pagelink.tpl" page="company" parms="" text="Companies"}
			</li>
			<li id="{if $selectedTab eq "Source"}selectedtab{/if}">
				{include file="pagelink.tpl" page="source" parms="" text="Sources"}
			</li>
			{if $isAuthenticated}
				{if $permissions.admin}
					<li id="{if $selectedTab eq "Admin"}selectedtab{/if}">
						{include file="pagelink.tpl" page="adminConsole" parms="" text="Admin Console"}
					</li>
				{/if}
				<li id="{if $selectedTab eq "My Account"}selectedtab{/if}">
					{include file="pagelink.tpl" page="myAccount" parms="" text="My Account"}
				</li>
				<li>
					{include file="pagelink.tpl" page="logout" parms="" text="Logout"}
				</li>
			{else}
				{if $permissions.register}
					<li id="{if $selectedTab eq "Register"}selectedtab{/if}">
						{include file="pagelink.tpl" page="register" parms="" text="Register New Account"}
					</li>
				{/if}
			{/if}
		</ul>
	</div>
	<div id="mainwrapper">
	<h2>
	{foreach from=$nav item=entry key=name}
		> {include file="pagelink.tpl" page="`$entry.page`" parms="`$entry.parms`" text="`$entry.text`"}
	{/foreach}
	</h2>
		