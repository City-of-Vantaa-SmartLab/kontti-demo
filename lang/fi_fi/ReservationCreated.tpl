{*
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
Kiitos varauksestasi!<br/><br/>
Tarkista varauksesi tiedot ja muista päivittää tapahtumasi tiedot ennen kesäkuuta.<br/>
Toivottavasti tapahtumasi onnistuu!<br/>
<br/>
Varauksen tiedot:
<br/>
<br/>

Alkaa: {formatdate date=$StartDate key=reservation_email}<br/>
Loppuu: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
	Tilat:
	<br/>
	{foreach from=$ResourceNames item=resourceName}
		{$resourceName}
		<br/>
	{/foreach}
{else}
	Tila: {$ResourceName}
	<br/>
{/if}

{if $ResourceImage}
	<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Tapahtuman nimi: {$Title}<br/>
Tapahtuman kuvaus: {$Description|nl2br}

{if count($RepeatDates) gt 0}
	<br/>
	Varaus toistuu seuraavina päivämäärinä:
	<br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
	{formatdate date=$date}
	<br/>
{/foreach}

{if $Accessories|count > 0}
	<br/>
	Lisävarusteet:
	<br/>
	{foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
	{/foreach}
{/if}

{if $Attributes|count > 0}
	<br/>
	{foreach from=$Attributes item=attribute}
		<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	{/foreach}
{/if}

{if $RequiresApproval}
	<br/>

	Yksi tai useampi varattu tila vaatii hyväksynnän ennen käyttöä.  Varaus on odottavassa tilassa kunnes se hyväksytään.
{/if}

{if $CheckInEnabled}
	<br/>
	Yksi tai useampi varattu tila vaatii sisään- ja uloskirjautumisen varaukseen/varauksesta.
	{if $AutoReleaseMinutes != null}
		Tämä varaus perutaan jos siihen ei sisäänkirjauduta {$AutoReleaseMinutes} minuuttia varauksen alkamisesta.
	{/if}
{/if}

{if !empty($ApprovedBy)}
	<br/>
	Hyväksyjä: {$ApprovedBy}
{/if}


{if !empty($CreatedBy)}
	<br/>
	Varaaja: {$CreatedBy}
{/if}

<br/>
Varausnumero: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Näytä varaus</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Lisää Outlookiin/kalenteriin</a> |
<a href="{$ScriptUrl}">Kirjaudu Muuntamoon</a>