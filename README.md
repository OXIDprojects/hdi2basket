hdi2basket
==========


HDI 2Basket
for Oxid eShop 4.5.0
   
What it does: 
	This modul extends the possibility to insert Articles to the basket
	just by visiting a URL, with
		- inserting multiple items
		- inserting items by article number


Installation: 

	1. Copy content of folder "copy_this" into /  (=> rootfolder)
	
	2. Go to Shopadmin in Modul section insert: oxcmp_basket => hdi2basket/hdi2basket

	3. Be Happy :)

Usage: 
	The usual way to put things into the basket via url is to append it with ?fnc=tobasket&aid={oxarticles__OXID}&am=1
	Now you can use following additional URL Parameters: 
	- fast: while fast=1 is set in the url you can use artnum={oxarticles__oxartnum} instead of "aid"
	- multiple: multiple=1 indicates that you want to insert more than 1 item into the basket
		- by using multiple you have to provide an id and am array in the url, ie: id[0]={OXID1}&am[0]=1&id[1]={OXID2}&am[1]=3...
		- or in combiantion with "fast=1": artnum[0]=1234&am[0]=2&artnum[1]=2345&am[1]=1

Example: 
	http://www.shop.com?fnc=tobasket&fast=1&multiple=1&artnum[0]=12345&am[0]=1&artnum[1]=23456&am[1]=3
	This Example puts 1 * 12345 and 3 * 23456 into the basket



Changelog: 
	- v0.8.1b: Fixed some secutity issues.


Licensing: 

	HEINER DIRECT GmbH & Co KG
	Author: Rafael Dabrowski

	Copyright 2011 HEINER DIRECT GmbH & Co KG

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
