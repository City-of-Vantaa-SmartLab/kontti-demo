{*
Copyright 2012-2016 Nick Korbel

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
<div class="form-group {$class}{if basename($smarty.server.PHP_SELF) == "register.php"} registercheckbox{/if}">
    {if $readonly}
        <label class="customAttribute" for="{$attributeId}">{$attribute->Label()}</label>
        <span class="attributeValue {$class}">{if $attribute->Value() == "1"}{translate key='True'}{else}{translate key='False'}{/if}</span>
    {elseif $searchmode}
        <label class="customAttribute" for="{$attributeId}">{$attribute->Label()}</label>
        <select id="{$attributeId}" name="{$attributeName}" class="customAttribute form-control {$inputClass}">
            <option value="">--</option>
            <option value="0" {if $attribute->Value() == "0"}selected="selected"{/if}>{translate key=No}</option>
            <option value="1" {if $attribute->Value() == "1"}selected="selected"{/if}>{translate key=Yes}</option>
        </select>
    {else}
        <div class="checkbox{if basename($smarty.server.PHP_SELF) == "register.php"} registercheckbox pull-left{/if}">
            <input type="checkbox" value="1" id="{$attributeId}" name="{$attributeName}"
                   {if $attribute->Value() == "1"}checked="checked"{/if} class="{$inputClass}"/>
            <label class="customAttribute" for="{$attributeId}">
			  {if strcmp($attribute->Label(),"Järjestyssäännöt")==0}Olen lukenut ja hyväksyn <a type="button" data-toggle="modal" data-target="#modal{$attribute->Label()}">Muuntamon järjestyssäännöt</a>.
			{elseif strcmp($attribute->Label(),"Vuokrasopimukset")==0}Olen lukenut ja hyväksyn <a type="button" data-toggle="modal" data-target="#modal{$attribute->Label()}">Muuntamon vuokrasopimuksen</a>.
			{elseif strcmp($attribute->Label(),"Tutkimus")==0}Olen lukenut <a type="button" data-toggle="modal" data-target="#modal{$attribute->Label()}">tutkimus- ja tietosuojaselosteen</a>, <a type="button" data-toggle="modal" data-target="#modal{$attribute->Label()}3">tiedotteen tutkimuksesta</a> ja annan <a type="button" data-toggle="modal" data-target="#modal{$attribute->Label()}2">suostumukseni tutkimukseen osallistumiseen</a>.
			{else}{$attribute->Label()}{/if}
                {if $attribute->Required() && !$searchmode}
                    <i class="glyphicon glyphicon-asterisk checkboxglyphicon"></i>
                {/if}
            </label>
        </div>
    {/if}
</div>
{if strcmp($attribute->Label(),"Järjestyssäännöt")==0}
	<div id="modal{$attribute->Label()}" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content registerPageDeals">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">VANTAAN KAUPUNKI<br/>Tilakeskus</h4>
		  </div>
			<div class="modal-body registerModalBoxBody">
				<div class="registerModalBoxBodyOwn">
					<ol>
						<li>
							Vuokralainen sitoutuu noudattamaan Muuntamon järjestyssääntöjä, turvallisuusohjeita ja 
							henkilökunnan antamia ohjeita. Vuokralainen huolehtii, että tiloja, kalustoa ja välineitä 
							käytetään annettujen ohjeiden mukaisesti. Vuokralainen on itse vastuussa henkilökohtaisista 
							tavaroistaan. Vuokralainen on velvollinen korvaamaan aiheuttamansa vahingot ja sitoutuu 
							ilmoittamaan sattuneesta vahingosta välittömästi vuokranantajalle.
						</li><br/>
						<li>
							Vuokralainen huolehtii, että Muuntamon käyttö tapahtuu vain vuokra-aikana, muuntautuva 
							työtila pysyy suljettuna muilta käyttäjiltä, ovet lukitaan ja valot sammutetaan vuokra-ajan 
							päätyttyä ja ettei Muuntamoon jää ketään vuokra-ajan jälkeen.
						</li><br/>
						<li>
							Vuokra-aikana Muuntamon valvonnasta ja turvallisuudesta vastaa käyttäjän nimeämä 
							vastuuhenkilö, jonka tulee olla ko. vuokra-aikana läsnä Muuntamossa. Henkilön tulee olla 
							täysi-ikäinen, lisäksi hän on perehtynyt tilan turvallisuussuunnitelmaan. Vuokralainen sitoutuu 
							noudattamaan Muuntamon avaus- ja lukitsemiskäytäntöjä. 
						</li><br/>
						<li>
							Vuokrasopimuksen vakituiset käyttövuorot ovat sitovia. Jos vuokralainen peruuttaa
							käyttövuoron kesken vuokrasopimuskauden, on siitä tehtävä viipymättä kirjallinen ilmoitus
							vuokranantajalle. 
						</li><br/>
						<li>
							Vuokrasopimuksen käyttövuoroja ei saa siirtää toiselle yhteisölle tai henkilölle ilman 
							vuokranantajan lupaa.
						</li><br/>
						<li>
							Vuokranantaja voi peruuttaa vakituisen käyttövuoron käytössä ilmenevien epäkohtien tai 
							väärinkäytön vuoksi. 
						</li><br/>
						<li>
							Muuntamo on siivottava sinne kuulumattomista roskista tilan käytön päättyessä. 
							Laiminlyönneistä veloitetaan hinnaston mukaisesti.
						</li>
					</ol>
				</div>
			</div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Sulje</button>
		  </div>
		</div>

	  </div>
	</div>
{elseif strcmp($attribute->Label(),"Vuokrasopimukset")==0}
	<div id="modal{$attribute->Label()}" class="modal fade" role="dialog">
	  <div class="modal-dialog registerModalBox">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">MUUNTAMON VUOKRAUKSEN KÄYTTÖEHDOT</h4>
		  </div>
			<div class="modal-body registerModalBoxBody">
				<span class="registerModalBoxBodyOwn">
					Sopijapuolet<br/>
					<br/>
					1. Vuokranantaja: Vantaan kaupunki, Tilakeskus, y-tunnus 0124610-9, Kielotie 13, 01300 Vantaa<br/>
					2. Vuokralainen: <br/>
					<br/>
					Osoite:		Asematie 3 B, 01300 Vantaa	<br/>
					Muuntamo	 <br/>
					<br/>
					Vuokralainen sitoutuu järjestönsä / yhteisönsä puolesta noudattamaan seuraavia ehtoja ja järjestyssääntöjä käyttäessään Muuntamoa:<br/>
					<br/>
					<br/>
				<ol>
					<li>
						Muuntautuvaa toimitilaa käytetään yksinomaan varatulla ajalla sekä määriteltyyn tarkoitukseen 
						vuokralaisen omassa valvonnassa. Vuokralainen on itse vastuussa henkilökohtaisista tavaroistaan, 
						Vantaan kaupunki ei korvaa esim. varastettuja tavaroita.
					</li>
					<br/>
					<br/>
					<li>
						Vuokralainen korvaa käyttöaikanaan tapahtuvat henkilö- ja muut vahingot ja sitoutuu ilmoittamaan 
						sattuneesta vahingosta välittömästi Vantaan kaupungin yhteyshenkilölle. Vuokralainen vastaa 
						toiminnan turvallisuudesta ja valvonnasta vuokra-aikana. Vuokralainen on velvollinen noudattamaan 
						Muuntamon järjestyssääntöjä, turvallisuus- ja muita annettuja ohjeita.
					</li>
				<br/>
				<br/>
					<li>
						Vuokralainen huolehtii siitä, että Muuntamo pysyy suljettuna muilta käyttäjiltä, ovet on pidettävä 
						lukittuina. 
					</li>
				<br/>
				<br/>
					<li>
						Muuntamossa noudatetaan toimintaan kuuluvaa siisteyttä ja järjestystä. Vuokralainen siivoaa 
						aiheuttamansa epäpuhtaudet ja palauttaa Muuntamon järjestykseen niin, että tila on samassa 
						kunnossa kuin käytön alkaessa.
					</li>
				<br/>
				<br/>
					<li>
						Vantti vastaa catering-tuotteistaan niiden toimitukseen asti. Mikäli catering-tuotteille on sattunut 
						Muuntamon säilytyksessä jotain, ei Vantti ole enää vastuussa niistä.
					</li>
				</ol>
				<br/><br/>
					Käyttöehdot ovat voimassa vuokralaisen varaamina ajankohtina. Muuntamon käyttöehdot ovat voimassa 31.8.2017 asti.<br/>
					<br/>
					Vantaalla 8.5.2017<br/>
					<br/>
					Liite 1		Järjestyssäännöt<br/>
					<br/>
					Yhteyshenkilö		Nealeena Hällfors, puh. (09) 839 23819<br/>

				
				</span>
				<br/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Sulje</button>
			</div>
		</div>

	  </div>
	</div>
{elseif strcmp($attribute->Label(),"Tutkimus")==0}
	<div id="modal{$attribute->Label()}" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Tieteellisen tutkimuksen rekisteriseloste, Henkilötietolaki (523/1999) 10 § ja 14 § </h4>
		  </div>
		  <div class="modal-body registerModalBoxBody">
			<p>
			Päivämäärä: 8.5.2017<br/>
<br/>
<b>Tutkimusrekisterin ylläpitäjä</b><br/>
<br/>
Nimi: Matti Luhtala<br/>
<br/>
Osoite: Kielotie 14 B 01300 Vantaa<br/>
<br/>
Muut yhteystiedot: Puh: +358 50 357 2265, S-posti: matti.luhtala@vantaa.fi<br/>
<br/>
<b>Yhteistyöhankkeena tehtävän tutkimuksen osapuolet ja vastuujako</b><br/>
<br/>
SmartLab: tutkimuksen ohjaus<br/>
<br/>
Metropolia Electria: Muuntamo-teknologioiden kehitys<br/>
<br/>
Vantaan kaupungin Tilakeskus: Palvelun pääomistaja<br/>
<br/>
<b>Tutkimuksellisen vastuullinen johtaja tai siitä vastaava ryhmä</b><br/>
<br/>
SmartLab Vantaa, Matti Luhtala<br/>
<br/>
<b>Tutkimuksen suorittajat</b><br/>
<br/>
Matti Luhtala<br/>
<br/>
<b>Yhteyshenkilö rekisteriä koskevissa asiossa</b><br/>
<br/>
Nimi: Matti Luhtala<br/>
<br/>
Osoite: Kielotie 14 B 01300 Vantaa<br/>
<br/>
Muut yhteystiedot: Puh: +358 50 357 2265, S-posti: matti.luhtala@vantaa.fi<br/>
<br/>
<b>Tutkimusrekisteri</b><br/>
<br/>
Rekisterin nimi: SmartLab-tutkimusrekisteri<br/>
<br/>
Tutkimusmuoto: kertatutkimus<br/>
<br/>
Tutkimuksen kesto: 31.12.2020 saakka<br/>
<br/>
<b>Henkilötietojen käsittelyn tarkoitus</b><br/>
<br/>
Tässä tutkimuksessa kehitetään Vantaan Tietohallinnon muotoilulaboratorio SmartLabin ja Vantaan Tilakeskuksen toimesta muuntautuvia toimitiloja. Testaukset järjestetään Tikkurilan keskustaan rakennettavassa Muuntamossa 5.6.-31.8. Kohderyhmänä tässä tapaustutkimuksessa ovat Vantaan kaupungin työntekijät, Kuntapalveluiden tuottajat, StartUp-yritykset ja Vantaan kaupungin yhteistyökumppanit.<br/>
<br/>
<b>Rekisterin tietosisältö</b><br/>
<br/>
Henkilötietorekisteriin kerätään tutkimukseen osallistuvien nimi- ja osoitetiedot. Tutkimusaineistoa kerätään Muuntamo-demon aikana järjestämällä suunnitelutyöpajoja, kehittämällä prototyyppeja sekä keräämällä palautetta osallistujilta lomakekyselyiden ja haastatteluiden kautta. Kerätty<br/>
<br/>
tutkimusmateriaali voi olla muodoltaan kirjallinen dokumentti, audio- ja/ tai visuaalinen tallenne sekä fyysinen/digitaalinen artefakti.<br/>
<br/>
<b>Säännönmukaiset tietolähteet</b><br/>
<br/>
Tiedot saadaan osallistujien suostumuksella pyytämällä vahvistus erillisellä tutkimuslupa-lomakkeella. Muita taustatietoja ei kerätä muista rekistereistä tai tiedostoista.<br/>
<br/>
<b>Tietojen säännönmukaiset luovutukset</b><br/>
<br/>
Tietoja ei luovuteta<br/>
<br/>
<b>Tietojen siirto EU:n tai ETA:n ulkopuolelle</b><br/>
<br/>
Tietoja ei siirretä<br/>
<br/>
<b>Rekisterin suojauksen periaatteet</b><br/>
<br/>
Tiedostot ovat salassa pidettäviä: kyllä<br/>
<br/>
Manuaalinen aineisto: Työpajoissa syntynyttä aineistoa säilytetään Vantaan Tietohallinnon SmartLabin työtilassa lukolla suljetussa kaapissa sijaitsevalla ulkoisella kovalevyllä.<br/>
<br/>
ATK:lla käsiteltävät tiedot<br/>
<br/>
Käyttäjätunnus: kyllä<br/>
<br/>
Salasana: kyllä<br/>
<br/>
Kulun valvonta: kyllä<br/>
<br/>
Tunnistetiedot poistetaan analysointivaiheessa: Kyllä<br/>
<br/>
<b>Tutkimusaineiston hävittäminen tai arkistointi</b><br/>
<br/>
Tutkimusrekisteri arkistoidaan: kyllä<br/>
<br/>
Tunnistetiedoin: kyllä<br/>
<br/>
Mihin: Vantaan Tietohallinnon SmartLabin työtilassa sijaitsevaan lukolliseen kaappiin ja siellä sijaitsevaan ulkoiseen kovalevyyn. <br/>
			</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Sulje</button>
		  </div>
		</div>

	  </div>
	</div>
	<div id="modal{$attribute->Label()}2" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<center><h4 class="modal-title">SUOSTUMUS OSALLISTUMISESTA<br/>
			TILAT PALVELUNA, MUUNTAUTUVAT TOIMITILAT -TUTKIMUKSEEN
			</h4></center>
		  </div>
		  <div class="modal-body registerModalBoxBody">
			<div class="registerModalBoxBodyLeft"></div>
			<div class="registerModalBoxBodyRight">
				<p>Tässä tutkimuksessa kehitetään Vantaan Tietohallinnon muotoilulaboratorio SmartLabin ja Vantaan Tilakeskuksen toimesta muuntautuvia toimitiloja. Kaikki tutkimuksessa kerätty tieto on luottamuksellista eikä tutkimustuloksista voi tunnistaa yksittäistä henkilöä. Ainoa rekisteriin jäävä tieto on tässä tutkimuksessa syntyvää, taustatietoja ei kerätä muista rekistereistä tai tiedostoista. Kaikki tutkimuksen aikana kerättävät tiedot käsitellään henkilötietolain (523/1999) mukaisesti. Tutkimuksen vastuuhenkilönä toimii Matti Luhtala (matti.luhtala@vantaa.fi).
				<br/><br/>
				Olen saanut, lukenut ja ymmärtänyt tutkimuksesta kertovan tiedotteen ja tietosuojaselosteen, joista olen saanut riittävän selvityksen tutkimuksesta ja sen yhteydessä suoritettavasta tietojen keräämisestä ja käsittelystä. Minulla on ollut mahdollisuus esittää tutkimusta koskevia kysymyksiä, ja olen saanut riittävän vastauksen kaikkiin tutkimusta koskeviin kysymyksiini. 
				<br/><br/>
				Osallistun tutkimukseen vapaaehtoisesti. Voin halutessani peruuttaa tai keskeyttää osallistumiseni tai kieltäytyä mittauksista missä vaiheessa tahansa tutkimusta ilmoittamalla siitä Matti Luhtalalle (matti.luhtala@vantaa.fi). Voin myös peruuttaa tämän suostumuksen, jolloin tietojani ei enää käytetä tutkimuksessa. Olen tietoinen siitä, että keskeyttämiseen mennessä kerättyjä tietoja käytetään osana tutkimusaineistoa. Tutkimustuloksiani saa käyttää tieteelliseen raportointiin (esim. julkaisuihin) vain sellaisessa muodossa, jossa yksittäistä tutkittavaa ei voi tunnistaa. 
				<br/><br/>
				Yhteistyöstä kiittäen<br/>
				Matti Luhtala<br/>
				Helsingissä 8.5.2017<br/>
				S-posti: matti.luhtala@vantaa.fi<br/>
				Puh: +358503572265<br/>
				Vantaan kaupunki, <br/>
				Tietohallinnon palvelukeskus, <br/>
				Kielotie 14 B, 01300 Vantaa<br/>
				</p>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Sulje</button>
		  </div>
		</div>

	  </div>
	</div>
	<div id="modal{$attribute->Label()}3" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Tiedote tutkimuksesta</h4>
		  </div>
		  <div class="modal-body registerModalBoxBody">
			<div class="registerModalBoxBodyLeft"></div>
			<div class="registerModalBoxBodyRight">
				
			<p>

Tässä projektissa suunnitellaan uudenlainen monitoimitila yhdessä Vantaan työntekijöiden, StartUp-yritysten ja Vantaan kumppanien kanssa. Suunnittelun lähtökohtana on luoda ketterästi muuntautuva toimitila, joka tukee uudenlaisten yhteistyökäytäntöjen ja jaettujen aktiviteettien syntymistä toimijoiden kohdatessa tilassa. Muuntamo-tilan käyttäjät voivat varata ja muokata tilan tarpeitaan vastaavaksi Muuntamo-varausjärjestelmän kautta. Kohderyhmänä tässä tapaustutkimuksessa ovat Vantaan kaupungin työntekijät, Kuntapalveluiden tuottajat, Start Up -yritykset ja Vantaan kaupungin yhteistyökumppanit. 
<br/><br/>
 

<b>Testausasetelma</b><br/>
<br/>
Testattava palvelu pitää Muuntamo-ajanvarausjärjestelmän sekä Muuntamo-tilan ja siihen kytkeytyvät materiaaliset ja teknologiset ratkaisut. Testaukset järjestetään Tikkurilan keskustaan rakennettavassa Muuntamossa 5.6.-31.8. Testauksen aikana palvelun käyttäjiltä kerätään tietoa kyselylomakkeiden sekä avoimien haastatteluiden kautta. Lisäksi palvelun käyttäjistä tallennetaan tietoja ajanvarausjärjestelmän lokitietojen sekä videokuvaamalla tilassa tapahtuvaa toimintaa. 
<br/><br/>
 

<b>Tuloksien hyödyntäminen</b><br/>
<br/>
Kokeilun kautta luodaan ymmärrystä uudenlaisista toimitilaratkaisuista, niihin kytkeytyvistä palvelumalleista ja palveluita tukevista teknologioista. Tutkimukse tuloksia hyödynnetään Vantaan kaupungin Tilakeskuksen Tilat palveluna, muuntautuvat toimitilat palvelun kehittämiseen. Projektin aikana synnytetyt tuotokset voivat konkretisoitua kuntapalveluiksi, uudenlaiseksi liiketoiminnaksi tai kunta- ja sektorirajat ylittäviksi verkostomalleiksi. Tuloksia voidaan hyödyntää myös laajemmin soveltavasti tilanteisiin, joissa muuntautuville toimitiloille on tarvetta, kuten esimerkiksi Vantaan kaupungin uuden toimitalon suunnittelussa. 
<br/><br/>
 

<b>Tuloksien hyödyntäminen tieteelliseen tutkimukseen </b><br/>
<br/>
Projektin tuottamia tuloksia käytetään tieteelliseen tutkimukseen. Tuloksia julkaistaan kansallisissa ja kansainvälisissä Journal-lehdissä ja Matti Luhtalan väitöskirjatutkimuksessa. Tieteellistä tutkimusta ohjaa Tampereen yliopiston professori Markku Turunen, joka toimii Matti Luhtalan väitöskirjan ohjaaja.  
<br/><br/>
 

<b>Tutkimuksen toteuttajat</b><br/>
<br/>
Tämän tutkimuksen toteuttaa Vantaan kaupungin Tietohallinnon muotoilulaboratorio SmartLab. Tutkimuksellista kehitystoimintaa toteutetaan yhteistyössä Metropolian Electrian tutkimus- ja kehitysyksikön kanssa. SmartLab koordinoi ja fasilitoi tutkimuksellista kehittämistoimintaa ja Electria vastaa teknologisten prototyyppien toteutuksesta. 
<br/><br/>
 

Yhteistyöstä kiittäen <br/>
<br/>
 <br/>

Matti Luhtala <br/>

Helsingissä 28.11.2016 <br/>

S-posti: matti.luhtala@vantaa.fi <br/>

Puh: +358503572265 <br/>

Vantaan kaupunki Tietohallinnon palvelukeskus, Kielotie 14 B, 01300 Vantaa <br/>
			</p>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Sulje</button>
		  </div>
		</div>

	  </div>
	</div>
{/if}