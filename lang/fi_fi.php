<?php
/**
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
 */

require_once('Language.php');
require_once('en_us.php');
class fi_fi extends en_us
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return array
	 */
	protected function _LoadDates()
	{
		$dates = parent::_LoadDates();

		$dates['general_date'] = 'j.n.Y';
		$dates['general_datetime'] = 'j.n.Y G.i.s';
		$dates['short_datetime'] = 'n/j/y g:i A';
		$dates['schedule_daily'] = 'l, j.n.Y';
		$dates['reservation_email'] = 'j.n.Y @ G.i';
		$dates['res_popup'] = 'j.n.Y G.i';
		$dates['res_popup_time'] = 'D, n/d g:i A';
		$dates['short_reservation_date'] = 'n/j/y g:i A';
		$dates['dashboard'] = 'l, j.n.Y G.i';
		$dates['period_time'] = 'G.i';
		$dates['mobile_reservation_date'] = 'n/j g:i A';
		$dates['general_date_js'] = 'd.M.yyyy';
		$dates['general_time_js'] = 'h:mm tt';
		$dates['momentjs_datetime'] = 'M/D/YY h:mm A';
		$dates['calendar_time'] = 'h.mmt';
		$dates['calendar_dates'] = 'M d';

		$this->Dates = $dates;
		
	}

	/**
	 * @return array
	 */
	 //Linecount should match en_us.php so it's easier to notice missing lines
	protected function _LoadStrings()
	{
		$strings = parent::_LoadStrings();

		$strings['About'] = 'Lisätietoa palvelusta';
		$strings['FirstName'] = 'Etunimi';
		$strings['LastName'] = 'Sukunimi';
		$strings['Timezone'] = 'Aikavyöhyke';
		$strings['Edit'] = 'Muokkaa';
		$strings['Change'] = 'Vaihda';
		$strings['Rename'] = 'Nimeä uudelleen';
		$strings['Remove'] = 'Poista';
		$strings['Delete'] = 'Poista';
		$strings['Update'] = 'Päivitä';
		$strings['Cancel'] = 'Peruuta';
		$strings['Add'] = 'Lisää';
		$strings['Name'] = 'Nimi';
		$strings['Yes'] = 'Kyllä';
		$strings['No'] = 'Ei';
		$strings['FirstNameRequired'] = 'Etunimi vaaditaan.';
		$strings['LastNameRequired'] = 'Sukunimi vaaditaan.';
		$strings['PwMustMatch'] = 'Salasanan varmistuksen täytyy vastata salasanaan.';
		$strings['ValidEmailRequired'] = 'Voimassa oleva sähköpostiosoite vaaditaan.';
		$strings['UniqueEmailRequired'] = 'Kyseisellä sähköpostiosoitteella on jo rekisteröidytty.';
		$strings['UniqueUsernameRequired'] = 'Käyttäjänimi on jo käytössä.';
		$strings['UserNameRequired'] = 'Käyttäjänimi vaaditaan.';
		$strings['CaptchaMustMatch'] = 'Ole hyvä ja kirjoita kuvakentässä olevat kirjaimet.';
		$strings['Today'] = 'Tänään';
		$strings['Week'] = 'Viikko';
		$strings['Month'] = 'Kuukausi';
		$strings['BackToCalendar'] = 'Takaisin kalenteriin';
		$strings['BeginDate'] = 'Alkaa';
		$strings['EndDate'] = 'Loppuu';
		$strings['Username'] = 'Käyttäjänimi';
		$strings['Password'] = 'Salasana';
		$strings['PasswordConfirmation'] = 'Varmista salasana';
		$strings['DefaultPage'] = 'Aloitussivu';
		$strings['MyCalendar'] = 'Oma kalenteri';
		$strings['ScheduleCalendar'] = 'Varauskalenteri';
		$strings['Registration'] = 'Rekisteröityminen';
		$strings['NoAnnouncements'] = 'Ei uusia ilmoituksia';
		$strings['Announcements'] = 'Ilmoitukset';
		$strings['NoUpcomingReservations'] = 'Sinulla ei ole tulossa olevia varauksia';
		$strings['UpcomingReservations'] = 'Omat varaukset'; //Translation for dashboard box, original translation: 'Tulossa olevat varaukset'
		$strings['AllNoUpcomingReservations'] = 'Tulevia varauksia ei ole seuraavalle %s päivälle';
		$strings['AllUpcomingReservations'] = 'Kaikki tulevat varaukset';
		$strings['ShowHide'] = 'Näytä/Piilota';
		$strings['Error'] = 'Virhe';
		$strings['ReturnToPreviousPage'] = 'Palaa edelliselle sivulle';
		$strings['UnknownError'] = 'Tuntematon virhe';
		$strings['InsufficientPermissionsError'] = 'Sinulla ei ole pääsyä tälle alueelle';
		$strings['MissingReservationResourceError'] = 'Resurssia ei valittu';
		$strings['MissingReservationScheduleError'] = 'Varausaikaa ei valittu';
		$strings['DoesNotRepeat'] = 'Ei toistuva';
		$strings['Daily'] = 'Päivittäinen';
		$strings['Weekly'] = 'Viikoittainen';
		$strings['Monthly'] = 'Kuukausittainen';
		$strings['Yearly'] = 'Vuosittainen';
		$strings['RepeatPrompt'] = 'Toistuva';
		$strings['hours'] = 'tunnit';
		$strings['days'] = 'päivät';
		$strings['weeks'] = 'viikot';
		$strings['months'] = 'kuukaudet';
		$strings['years'] = 'vuodet';
		$strings['day'] = 'päivä';
		$strings['week'] = 'viikko';
		$strings['month'] = 'kuukausi';
		$strings['year'] = 'vuosi';
		$strings['repeatDayOfMonth'] = 'kuukaudenpäivä';
		$strings['repeatDayOfWeek'] = 'viikonpäivä';
		$strings['RepeatUntilPrompt'] = 'Asti';
		$strings['RepeatEveryPrompt'] = 'Joka';
		$strings['RepeatDaysPrompt'] = '';
		$strings['CreateReservationHeading'] = 'Tee uusi varaus';
		$strings['EditReservationHeading'] = 'Muokkaa varausta %s';
		$strings['ViewReservationHeading'] = 'Katso varausta %s';
		$strings['ReservationErrors'] = 'Vaihda varausta';
		$strings['Create'] = 'Luo';
		$strings['ThisInstance'] = 'Vain tämä kerta';
		$strings['AllInstances'] = 'Joka kerta';
		$strings['FutureInstances'] = 'Tulossa olevat kerrat';
		$strings['Print'] = 'Tulosta';
		$strings['ShowHideNavigation'] = 'Näytä/piilota navigointi';
		$strings['ReferenceNumber'] = 'Varausnumero';
		$strings['Tomorrow'] = 'Huomenna';
		$strings['LaterThisWeek'] = 'Myöhemmin tällä viikolla';
		$strings['NextWeek'] = 'Seuraava viikko';
		$strings['SignOut'] = 'Kirjaudu ulos';
		$strings['LayoutDescription'] = 'Alkaa %s, näyttäen %s päivää kerralla';
		$strings['AllResources'] = 'Kaikki tilat';
		$strings['TakeOffline'] = 'Sulje';
		$strings['BringOnline'] = 'Aloita';
		$strings['AddImage'] = 'Lisää kuva';
		$strings['NoImage'] = 'Ei kuvaa määriteltynä';
		$strings['Move'] = 'Siirrä';
		$strings['AppearsOn'] = 'Näkyy kohteessa %s';
		$strings['Location'] = 'Sijainti';
		$strings['NoLocationLabel'] = '(Sijaintia ei ole määritelty)';
		$strings['Contact'] = 'Yhteystiedot';
		$strings['NoContactLabel'] = '(ei yhtystietoja)';
		$strings['Description'] = 'Kuvaus';
		$strings['NoDescriptionLabel'] = '(ei kuvausta)';
		$strings['Notes'] = 'Huomioitavaa';
		$strings['NoNotesLabel'] = '(ei huomioitavaa)';
		$strings['NoTitleLabel'] = '(ei otsikkoa)';
		$strings['UsageConfiguration'] = 'Käyttöasetukset';
		$strings['ChangeConfiguration'] = 'Vaihda asetuksia';
		$strings['ResourceMinLength'] = 'Varauksien pitää kestää vähintään %s';
		$strings['ResourceMinLengthNone'] = 'Varauksella ei ole vähittäiskestoa';
		$strings['ResourceMaxLength'] = 'Varaukset eivät voi kestää pitempään kuin %s';
		$strings['ResourceMaxLengthNone'] = 'Varauksilla ei ole maksimikestoa';
		$strings['ResourceRequiresApproval'] = 'Varaukset täytyy hyväksyä';
		$strings['ResourceRequiresApprovalNone'] = 'Varaukset eivät vaadi hyväksyntää';
		$strings['ResourcePermissionAutoGranted'] = 'Oikeudet hyväksytään automaattisesti';
		$strings['ResourcePermissionNotAutoGranted'] = 'Oikeudet myönnetään automaattisesti';
		$strings['ResourceMinNotice'] = 'Varaukset täytyy tehdä ennen %s aloitusaikaa';
		$strings['ResourceMinNoticeNone'] = 'Varauksia voidaan tehdä tähän aikaan asti';
		$strings['ResourceMaxNotice'] = 'Varaukset eivät voi loppua %s enempää tästä hetkestä katsoen';
		$strings['ResourceMaxNoticeNone'] = 'Varaukset voivat loppua milloin vain tulevaisuudessa';
		$strings['ResourceAllowMultiDay'] = 'Varauksia voi tehdä useiksi päiviksi';
		$strings['ResourceNotAllowMultiDay'] = 'Varauksia ei voi tehdä yön ajaksi';
		$strings['ResourceCapacity'] = 'Tällä resurssilla on kapasiteetti %s henkilölle';
		$strings['ResourceCapacityNone'] = 'Tällä resurssilla on rajoittamaton kapasiteetti';
		$strings['AddNewResource'] = 'Lisää uusi tila';
		$strings['AddNewUser'] = 'Lisää uusi käyttäjä';
		$strings['AddUser'] = 'Lisää käyttäjä';
		$strings['Schedule'] = 'Aikataulu';
		$strings['AddResource'] = 'Lisää tila';
		$strings['Capacity'] = 'Kapasiteetti';
		$strings['Access'] = 'Pääsy';
		$strings['Duration'] = 'Kesto';
		$strings['Active'] = 'Aktiivinen';
		$strings['Inactive'] = 'Ei-aktiivinen';
		$strings['ResetPassword'] = 'Resetoi salasana';
		$strings['LastLogin'] = 'Viimeinen kirjautuminen';
		$strings['Search'] = 'Etsi';
		$strings['ResourcePermissions'] = 'Tilan käyttöoikeidet';
		$strings['Reservations'] = 'Varaukset';
		$strings['Groups'] = 'Ryhmät';
		$strings['Users'] = 'Käyttäjät';
		$strings['AllUsers'] = 'Kaikki käyttäjät';
		$strings['AllGroups'] = 'Kaikki ryhmät';
		$strings['AllSchedules'] = 'Kaikki aikataulut';
		$strings['UsernameOrEmail'] = 'Käyttäjänimi tai sähköpostiosoite';
		$strings['Members'] = 'Jäsenet';
		$strings['QuickSlotCreation'] = 'Luo kohta jokaiselle %s minuutille välillä %s - %s'; // TODO
		$strings['ApplyUpdatesTo'] = 'Lisää päivitykset';
		$strings['CancelParticipation'] = 'Peruuta osallistuminen';
		$strings['Attending'] = 'Osallistumassa';
		$strings['QuotaConfiguration'] = 'Kohteessa %s %s käyttäjälle %s on rajoitettu %s %s per %s'; // TODO
		$strings['reservations'] = 'varaukset';
		$strings['ChangeCalendar'] = 'Vaihda kalenteria';
		$strings['AddQuota'] = 'Lisää kiintiö';
		$strings['FindUser'] = 'Etsi käyttäjä';
		$strings['Created'] = 'Luotu';
		$strings['LastModified'] = 'Muokattu viimeksi';
		$strings['GroupName'] = 'Ryhmän nimi';
		$strings['GroupMembers'] = 'Ryhmän jäenet';
		$strings['GroupRoles'] = 'Ryhmän roolit';
		$strings['GroupAdmin'] = 'Ryhmän ylläpitäjä';
		$strings['Actions'] = 'Toiminnot';
		$strings['CurrentPassword'] = 'Nykyinen salasana';
		$strings['NewPassword'] = 'Uusi salasana';
		$strings['InvalidPassword'] = 'Väärä salasana';
		$strings['PasswordChangedSuccessfully'] = 'Salasanan vaihto onnistui';
		$strings['SignedInAs'] = 'Kirjautunut käyttäjänä: ';
		$strings['NotSignedIn'] = 'Et ole kirjautunut sisään';
		$strings['ReservationTitle'] = 'Varauksen otsikko';
		$strings['ReservationDescription'] = 'Varauksen kuvaus';
		$strings['ResourceList'] = 'Tilat varattaviksi';
		$strings['Accessories'] = 'Lisävarusteet';
		$strings['Add'] = 'Lisää';
		$strings['ParticipantList'] = 'Osallistujat';
		$strings['InvitationList'] = 'Kutsutut';
		$strings['AccessoryName'] = 'Tarvike';
		$strings['QuantityAvailable'] = 'Käytettävissä oleva määrä';
		$strings['Resources'] = 'Tilat';
		$strings['Participants'] = 'Osallistujat';
		$strings['User'] = 'Käyttäjä';
		$strings['Resource'] = 'Tila';
		$strings['Status'] = 'Tila';
		$strings['Approve'] = 'Hyväksy';
		$strings['Page'] = 'Sivu';
		$strings['Rows'] = 'Rivit';
		$strings['Unlimited'] = 'Rajoittamaton';
		$strings['Email'] = 'Sähköposti';
		$strings['EmailAddress'] = 'Sähköpostisoite';
		$strings['Phone'] = 'Puhelin';
		$strings['Organization'] = 'Organisatio';
		$strings['Position'] = 'Rooli';
		$strings['Language'] = 'Kieli';
		$strings['Permissions'] = 'Oikeudet';
		$strings['Reset'] = 'Resetoi';
		$strings['FindGroup'] = 'Etsi ryhmä';
		$strings['Manage'] = 'Hallitse';
		$strings['None'] = 'Ei mitään';
		$strings['AddToOutlook'] = 'Lisää Outlookiin';
		$strings['Done'] = 'Valmis';
		$strings['RememberMe'] = 'Muista minut';
		$strings['FirstTimeUser?'] = 'Uusi käyttäjä?';
		$strings['CreateAnAccount'] = 'Luo tili';
		$strings['ViewSchedule'] = 'Näytä aikataulu';
		$strings['ForgotMyPassword'] = 'Olen unohtanut salasanani';
		$strings['YouWillBeEmailedANewPassword'] = 'Sinulle lähetetään sähköpostilla uusi satunnainen salasana';
		$strings['Close'] = 'Sulje';
		$strings['ExportToCSV'] = 'Vie CSV-muotoon';
		$strings['OK'] = 'OK';
		$strings['Working'] = 'Työskennellään...';
		$strings['Login'] = 'Kirjaudu';
		$strings['AdditionalInformation'] = 'Lisätieto';
		$strings['AllFieldsAreRequired'] = 'kaikki kentät vaaditaan';
		$strings['Optional'] = 'valinnainen';
		$strings['YourProfileWasUpdated'] = 'Profiilisi on päivitetty';
		$strings['YourSettingsWereUpdated'] = 'Asetuksesi on päivitetty';
		$strings['Register'] = 'Rekisteröidy';
		$strings['SecurityCode'] = 'Turvakoodi';
		$strings['ReservationCreatedPreference'] = 'Kun teen varauksen tai varaus tehdään puolestani';
		$strings['ReservationUpdatedPreference'] = 'Kun päivitän varauksen tai varaus päivitetään puolestani';
		$strings['ReservationDeletedPreference'] = 'Kun poistan varauksen tai varaus poistetaan minun puolestani';
		$strings['ReservationApprovalPreference'] = 'Kun odottava varaukseni on hyväksytty';
		$strings['PreferenceSendEmail'] = 'Lähetä minulle sähköposti';
		$strings['PreferenceNoEmail'] = 'En tarvite muistutusta';
		$strings['ReservationCreated'] = 'Varauksesi on onnistuneesti luotu!';
		$strings['ReservationUpdated'] = 'Varauksesi on onnistuneesti päivitetty!';
		$strings['ReservationRemoved'] = 'Varauksesi on poistettu';
		$strings['ReservationRequiresApproval'] = 'Yksi tai useampi varatuista tiloista vaatii hyväksyntää ennen käyttöä.  Tämä varaus on odottavassa tilassa kunnes se on hyväksytty.';
		$strings['YourReferenceNumber'] = 'Varauskoodisi on: %s';
		$strings['ChangeUser'] = 'Vaihda käyttäjä';
		$strings['MoreResources'] = 'Lisää varattavia tiloja';
		$strings['ReservationLength'] = 'Varauksen pituus';
		$strings['ParticipantList'] = 'Osallistujalista';
		$strings['AddParticipants'] = 'Lisää osallistujia';
		$strings['InviteOthers'] = 'Kutsu muita';
		$strings['AddResources'] = 'Lisää tiloja';
		$strings['AddAccessories'] = 'Lisää lisävarusteita';
		$strings['Accessory'] = 'Lisävaruste';
		$strings['QuantityRequested'] = 'Pyydetty määrä';
		$strings['CreatingReservation'] = 'Varauksen luominen';
		$strings['UpdatingReservation'] = 'Varauksen päivittäminen';
		$strings['DeleteWarning'] = 'Tämä toiminto on pysyvä ja peruuttamaton!';
		$strings['DeleteAccessoryWarning'] = 'Tämän lisävarusteen poistaminen poistaa sen kaikista varauksista.';
		$strings['AddAccessory'] = 'Lisää lisävaruste';
		$strings['AddBlackout'] = 'Lisää varauksilta suljettu aika';
		$strings['AllResourcesOn'] = 'Kaikki tilat käytössä';
		$strings['Reason'] = 'Syy';
		$strings['BlackoutShowMe'] = 'Näytä ristiriitaiset varaukset';
		$strings['BlackoutDeleteConflicts'] = 'Poista ristiriidassa olevat varaukset';
		$strings['Filter'] = 'Suodata';
		$strings['Between'] = 'Välillä';
		$strings['CreatedBy'] = 'Tehnyt';
		$strings['BlackoutCreated'] = 'Suljettu aikaväli lisätty!';
		$strings['BlackoutNotCreated'] = 'Suljettua aikaväliä ei voitu luoda!';
		$strings['BlackoutUpdated'] = 'Suljettu aikaväli päivitetty';
		$strings['BlackoutNotUpdated'] = 'Suljettua aikaväliä ei voitu päivittää';
		$strings['BlackoutConflicts'] = 'Ristiriidan aiheuttavat suljetut aikavälit';
		$strings['ReservationConflicts'] = 'Ristiriidassa olevat varaukset';
		$strings['UsersInGroup'] = 'Käyttäjät tässä ryhmässä';
		$strings['Browse'] = 'Selaa';
		$strings['DeleteGroupWarning'] = 'Tämän ryhmän poistaminen poistaa myös kaikki määritellyt resurssioikeudet.  Käyttäjät tässä ryhmässä menettävät oikeudet resursseihin.';
		$strings['WhatRolesApplyToThisGroup'] = 'Mitkä roolit koskevat tätä ryhmää?';
		$strings['WhoCanManageThisGroup'] = 'Kuka voi ylläpitää tätä ryhmää?';
		$strings['WhoCanManageThisSchedule'] = 'Kuka voi hallita tätä aikatalua?';
		$strings['AllQuotas'] = 'Kaikki kiintiöt';
		$strings['QuotaReminder'] = 'Muista: rajoituksia sovelletaan varauskalenterin aikavyöhykkeen mukaisesti.';
		$strings['AllReservations'] = 'Kaikki varaukset';
		$strings['PendingReservations'] = 'Odottavat varaukset';
		$strings['Approving'] = 'Hyväksytään';
		$strings['MoveToSchedule'] = 'Siirry varauskalenteriin';
		$strings['DeleteResourceWarning'] = 'Tämän tilan poistaminen poistaa kaikki siihen liittyvät tiedot, mukaanlukien';
		$strings['DeleteResourceWarningReservations'] = 'kaikki siihen liittyvät menneet, nykyiset ja tulevat varaukset';
		$strings['DeleteResourceWarningPermissions'] = 'kaikki käyttöoikeusmääritykset';
		$strings['DeleteResourceWarningReassign'] = 'Määritä mitä et halua poistettavan ennen jatkamista';
		$strings['ScheduleLayout'] = 'Asettelu (kaikki ajat %s)';
		$strings['ReservableTimeSlots'] = 'Varattavat ajankohdat';
		$strings['BlockedTimeSlots'] = 'Estetyt ajankohdat';
		$strings['ThisIsTheDefaultSchedule'] = 'Tämä on oletusvarauskalenteri';
		$strings['DefaultScheduleCannotBeDeleted'] = 'Oletusvarauskalenteria ei voi poistaa';
		$strings['MakeDefault'] = 'Aseta oletukseksi';
		$strings['BringDown'] = 'Tyhjennä';
		$strings['ChangeLayout'] = 'Muuta ulkoasua';
		$strings['AddSchedule'] = 'Lisää kalenteri';
		$strings['StartsOn'] = 'Alkaa';
		$strings['NumberOfDaysVisible'] = 'Näkyvillä olevat päivät';
		$strings['UseSameLayoutAs'] = 'Käytä samaa ulkoasua kuin';
		$strings['Format'] = 'Tyyppi';
		$strings['OptionalLabel'] = 'Valinnainen rivi';
		$strings['LayoutInstructions'] = 'Lisää yksi kohta per rivi. Kohdat täytyy asettaa kaikille 24 tunnille alkaen ja loppuen 12:00.';
		$strings['AddUser'] = 'Lisää käyttäjä';
		$strings['UserPermissionInfo'] = 'Käyttöoikeus resurssiin voi olla erilainen riippuen käyttäjäroolista, ryhmäoikeuksista tai ylimääräisistä käyttöoikeusasetuksista';
		$strings['DeleteUserWarning'] = 'Poistamalla tämän käyttäjän poistat samalla kaikki hänen tulevat, menneet ja nykyiset varauksensa.';
		$strings['AddAnnouncement'] = 'Lisää ilmoitus';
		$strings['Announcement'] = 'Ilmoitus';
		$strings['Priority'] = 'Priotiteetti';
		$strings['Reservable'] = 'Varaamaton';
		$strings['Unreservable'] = 'Ei varattavissa';
		$strings['Reserved'] = 'Varattu';
		$strings['MyReservation'] = 'Minun varaukseni';
		$strings['Pending'] = 'Odottava';
		$strings['Past'] = 'Menneet';
		$strings['Restricted'] = 'Rajoitettu';
		$strings['ViewAll'] = 'Näytä kaikki';
		$strings['MoveResourcesAndReservations'] = 'Siirrä resurssit ja varaukset:';
		$strings['TurnOffSubscription'] = 'Lopeta kalenterin tilaus';
		$strings['TurnOnSubscription'] = 'Salli tämän kalenterin tilaaminen';
		$strings['SubscribeToCalendar'] = 'Tilaa kalenteri';
		$strings['SubscriptionsAreDisabled'] = 'Ylläpitäjä on poistanut tilaukset käytöstä';
		$strings['NoResourceAdministratorLabel'] = '(Ei resurssien ylläpitäjä)';
		$strings['WhoCanManageThisResource'] = 'Kuka ylläpitää tätä resurssia?';
		$strings['ResourceAdministrator'] = 'Resurssin ylläpitäjä';
		$strings['Private'] = 'Yksityinen';
		$strings['Accept'] = 'Hyväksy';
		$strings['Decline'] = 'Hylkää';
		$strings['ShowFullWeek'] = 'Näytä täysi viikko';
		$strings['CustomAttributes'] = 'Erikoisattribuutit';
		$strings['AddAttribute'] = 'Lisää attribuutti';
		$strings['EditAttribute'] = 'Päivitä attribuutti';
		$strings['DisplayLabel'] = 'Näytä nimike';
		$strings['Type'] = 'Tyyppi';
		$strings['Required'] = 'Vaadittu';
		$strings['ValidationExpression'] = 'Validationti-ilmaisu?';
		$strings['PossibleValues'] = 'Mahdolliset arvot';
		$strings['SingleLineTextbox'] = 'Yhden rivin tekstilaatikko';
		$strings['MultiLineTextbox'] = 'usean rivin tekstilaatikko';
		$strings['Checkbox'] = 'Valintaruutu';
		$strings['SelectList'] = 'Valintalista';
		$strings['CommaSeparated'] = 'pilkulla erotettuna';
		$strings['Category'] = 'Kategoria';
		$strings['CategoryReservation'] = 'Varaus';
		$strings['CategoryGroup'] = 'Ryhmä';
		$strings['SortOrder'] = 'Järjestys';
		$strings['Title'] = 'Otsikko';
		$strings['AdditionalAttributes'] = 'Lisäattribuutteja';
		$strings['True'] = 'Tosi';
		$strings['False'] = 'Epätosi';
		$strings['ForgotPasswordEmailSent'] = 'Ohjeet salasanan resetointiin on lähetetty annettuun sähköpostiosoitteeseen';
		$strings['ActivationEmailSent'] = 'Saat aktivointiviestin sähköpostiisi vähän ajan päästä.';
		$strings['AccountActivationError'] = 'Pahoittelumme, emme pystyneet aktivoimaan käyttäjätiliäsi.';
		$strings['Attachments'] = 'Liitteet';
		$strings['AttachFile'] = 'Liitä tiedosto';
		$strings['Maximum'] = 'maksimi';
		$strings['NoScheduleAdministratorLabel'] = 'Ei aikatauluylläpitäjä';
		$strings['ScheduleAdministrator'] = 'Aikatauluylläpitäjä';
		$strings['Total'] = 'Yhteensä';
		$strings['QuantityReserved'] = 'Määrä varattu';
		$strings['AllAccessories'] = 'Kaikki lisätarvikkeet';
		$strings['GetReport'] = 'Luo raportti';
		$strings['NoResultsFound'] = 'Ei tuloksia';
		$strings['SaveThisReport'] = 'Tallenna tämä raportti';
		$strings['ReportSaved'] = 'Raportti tallennettu!';
		$strings['EmailReport'] = 'Lähetä raportti sähköpostiin';
		$strings['ReportSent'] = 'Raportti lähetetty!';
		$strings['RunReport'] = 'Suorita raportti';
		$strings['NoSavedReports'] = 'Sinulla ei ole tallennettuja raportteja.';
		$strings['CurrentWeek'] = 'Nykyinen viikko';
		$strings['CurrentMonth'] = 'Nykyinen kuukausi';
		$strings['AllTime'] = 'Kaikki aika';
		$strings['FilterBy'] = 'Suodata seuraavien mukaan';
		$strings['Select'] = 'Valitse';
		$strings['List'] = 'Lista';
		$strings['TotalTime'] = 'Aika yhteensä';
		$strings['Count'] = 'Laske';
		$strings['Usage'] = 'Käyttö';
		$strings['AggregateBy'] = 'Kerää seuraavien mukaan';
		$strings['Range'] = 'Alue';
		$strings['Choose'] = 'Valitse';
		$strings['All'] = 'Kaikki';
		$strings['ViewAsChart'] = 'Tarkastele diagrammina';
		$strings['ReservedResources'] = 'Varatut tilat';
		$strings['ReservedAccessories'] = 'Varatut lisätarvikkeet';
		$strings['ResourceUsageTimeBooked'] = 'Tilan käyttö - Aika varattuna';
		$strings['ResourceUsageReservationCount'] = 'Tilan käyttö - Varausten määrä';
		$strings['Top20UsersTimeBooked'] = 'Top 20 Käyttäjää - Aika varattuna';
		$strings['Top20UsersReservationCount'] = 'Top 20 Käyttäjää - Varausten määrä';
		$strings['ConfigurationUpdated'] = 'Konfiguraatiotiedosto päivitettiin';
		$strings['ConfigurationUiNotEnabled'] = 'Tätä sivue ei voi avata koska $conf[\'settings\'][\'pages\'][\'enable.configuration\'] on asetettu epätodeksi (false) tai puuttuu kokonaan.';
		$strings['ConfigurationFileNotWritable'] = 'Tähän konfiguraatiotiedostoon ei voi kirjoittaa. Ole hyvä ja tarkista oikeudet tiedostossa ja yritä uudelleen.';
		$strings['ConfigurationUpdateHelp'] = 'Lue konfiguraatio-osio <a target=_blank href=%s>Aputiedostossa</a> näiden asetusten dokumentointiin.';
		$strings['GeneralConfigSettings'] = 'asetukset';
		$strings['UseSameLayoutForAllDays'] = 'Käytä samaa asettelua kaikille päiville';
		$strings['LayoutVariesByDay'] = 'Asettelu vaihtelee päivittäin';
		$strings['ManageReminders'] = 'Muistutukset';
		$strings['ReminderUser'] = 'Käyttäjä ID';
		$strings['ReminderMessage'] = 'Viesti';
		$strings['ReminderAddress'] = 'Osoitteet';
		$strings['ReminderSendtime'] = 'Aika lähetykseen';
		$strings['ReminderRefNumber'] = 'Varauksen viitenumero';
		$strings['ReminderSendtimeDate'] = 'Muistutuksen päiväys';
		$strings['ReminderSendtimeTime'] = 'Muistutuksen aika (TT:MM)';
		$strings['ReminderSendtimeAMPM'] = 'AM / PM';
		$strings['AddReminder'] = 'Lisää muistutus';
        $strings['DeleteReminderWarning'] = 'Oletko varma, että haluat poistaa tämän?';
        $strings['NoReminders'] = 'Sinulla ei ole tulevia muistutuksia.';
		$strings['Reminders'] = 'Muistutukset';
		$strings['SendReminder'] = 'Lähetä muistutus';
		$strings['minutes'] = 'minuuttia';
		$strings['hours'] = 'tuntia';
		$strings['days'] = 'päivää';
		$strings['ReminderBeforeStart'] = 'ennen aloitusaikaa';
		$strings['ReminderBeforeEnd'] = 'ennen loppumisaikaa';
		$strings['Logo'] = 'Logo';
		$strings['CssFile'] = 'CSS tiedosto';
		$strings['ThemeUploadSuccess'] = 'Muutoksesi on tallennettu. Päivitä sivu nähdäksesi muutokset.';
		$strings['MakeDefaultSchedule'] = 'Tee tästä oletusaikatauluni';
		$strings['DefaultScheduleSet'] = 'Tämä on nyt oletusaikataulusi';
		$strings['FlipSchedule'] = 'Käännä aikataulun asettelu';
		$strings['Next'] = 'Edellinen';
		$strings['Success'] = 'Onnistui';
		$strings['Participant'] = 'Osallistuja';
		$strings['ResourceFilter'] = 'Tilasuodatin';
		$strings['ResourceGroups'] = 'Tilaryhmät';
		$strings['AddNewGroup'] = 'Lisää uusi ryhmä';
		$strings['Quit'] = 'Poistu';		//Not used?
		$strings['AddGroup'] = 'Lisää ryhmä';
		$strings['StandardScheduleDisplay'] = 'Käytä standardia aikataulunäkymää';
		$strings['TallScheduleDisplay'] = 'Käytä pitkää aikataulunäkymää';
		$strings['WideScheduleDisplay'] = 'Käytä leveää aikataulunäkymää';
		$strings['CondensedWeekScheduleDisplay'] = 'Käytä tiivistettyä aikataulunäkymää';
		$strings['ResourceGroupHelp1'] = 'Drag and drop resource groups to reorganize.';
		$strings['ResourceGroupHelp2'] = 'Right click a resource group name for additional actions.';
		$strings['ResourceGroupHelp3'] = 'Drag and drop resources to add them to groups.';
		$strings['ResourceGroupWarning'] = 'If using resource groups, each resource must be assigned to at least one group. Unassigned resources will not be able to be reserved.';
		$strings['ResourceType'] = 'Tilan tyyppi';
		$strings['AppliesTo'] = 'Liittyy tiloihin...';
		$strings['UniquePerInstance'] = 'Ainutlaatuinen varaukseen';
		$strings['AddResourceType'] = 'Lisää tilatyyppi';
		$strings['NoResourceTypeLabel'] = '(tilatyyppiä ei säädetty)';
		$strings['ClearFilter'] = 'Tyhjennä suodattimet';
		$strings['MinimumCapacity'] = 'Minimi kapasiteetti';
		$strings['Color'] = 'Väri';
		$strings['Available'] = 'Saatavissa';
		$strings['Unavailable'] = 'Ei saatavissa';
		$strings['Hidden'] = 'Piilotettu';
		$strings['ResourceStatus'] = 'Tilan tila';
		$strings['CurrentStatus'] = 'Nykyinen tila';
		$strings['AllReservationResources'] = 'Kaikki varauksen tilat';
		$strings['File'] = 'Tiedosto';
		$strings['BulkResourceUpdate'] = 'Bulkki Tilojen päivitys';
		$strings['Unchanged'] = 'Muuttamaton';
		$strings['Common'] = 'Yleinen';
		$strings['AdminOnly'] = 'Vain ylläpidolle';
		$strings['AdvancedFilter'] = 'Suodatin lisäasetuksilla';
		$strings['MinimumQuantity'] = 'Minimimäärä';
		$strings['MaximumQuantity'] = 'Maksimimäärä';
		$strings['ChangeLanguage'] = 'Vaihda kieltä';
		$strings['AddRule'] = 'Lisää sääntö';
		$strings['Attribute'] = 'Ominaisuus';
		$strings['RequiredValue'] = 'Vaadittu arvo';
		$strings['ReservationCustomRuleAdd'] = 'Jos %s niin varauksen väri tulee olemaan';
		$strings['AddReservationColorRule'] = 'Lisää varauksiin värisääntö';
		$strings['LimitAttributeScope'] = 'Kerää tietyissä tilanteissa';
		$strings['CollectFor'] = 'Kerää käyttäjille:';
		$strings['SignIn'] = 'Kirjaudu sisään';
		$strings['AllParticipants'] = 'Kaikki osallistujat';
		$strings['RegisterANewAccount'] = 'Rekisteröi uusi käyttäjätili';
		$strings['Dates'] = 'Päiväykset';
		$strings['More'] = 'Lisää';
		$strings['ResourceAvailability'] = 'Varaa tila';	//Original translation: Tilojen saatavuus
		$strings['UnavailableAllDay'] = 'Varattu koko päivänä';
		$strings['AvailableUntil'] = 'Vapaa'; //... $s asti
		$strings['AvailableBeginningAt'] = 'Vapaa alkaen';
		$strings['AllResourceTypes'] = 'Kaikki tilatyppit';
		$strings['AllResourceStatuses'] = 'Kaikki tilojen tilat';
		$strings['AllowParticipantsToJoin'] = 'Merkitse tapahtuma avoimeksi';
		$strings['Join'] = 'Osallistu';
		$strings['YouAreAParticipant'] = 'Olet osallistumassa tähän varaukseen';
		$strings['YouAreInvited'] = 'Sinut on kutsuttu tähän varaukseen';
		$strings['YouCanJoinThisReservation'] = 'Voit osallistua tähän varaukseen';
		$strings['Import'] = 'Tuo';
		$strings['GetTemplate'] = 'Lataa malli';
		$strings['UserImportInstructions'] = 'Tiedoston pitää olla CSV formaatissa. Käyttäjänimi ja sähköposti ovat pakollisia. Jättäminen tyhjäksi asettaa muuttujille oletusarvot ja \'password\' käyttäjän salasanaksi. Käytä annettua mallia esimerkkinä.';
		$strings['RowsImported'] = 'Rivejä tuotu';
		$strings['RowsSkipped'] = 'Rivejä ohitettu';
		$strings['Columns'] = 'Sarakkeet';
		$strings['Reserve'] = 'Varaa';
		$strings['AllDay'] = 'Koko päivän';
		$strings['Everyday'] = 'Joka päivä';
		$strings['IncludingCompletedReservations'] = 'Sisältäen menneet varaukset';
		$strings['NotCountingCompletedReservations'] = 'Sisältämättä menneitä varauksia';
		$strings['RetrySkipConflicts'] = 'Ohita ristiriitaiset varaukset';
		$strings['Retry'] = 'Yritä uudelleen';
		$strings['RemoveExistingPermissions'] = 'Poista olemassa olevat oikeudet?';
		$strings['Continue'] = 'Jatka';
		$strings['WeNeedYourEmailAddress'] = 'Tarvitsemme sähköpostiosoitteesi varauksiin';
		$strings['ResourceColor'] = 'Tilan väri';
		$strings['DateTime'] = 'Date Time';		//context not known
		$strings['AutoReleaseNotification'] = 'Automaattisesti vapautettu jos ei sisäänkirjauduttu (check in) %s minuutin sisään';
		$strings['RequiresCheckInNotification'] = 'Vaatii ilmoittautumisen (check in)/poistumisilmoittautumisen (check out)';
		$strings['NoCheckInRequiredNotification'] = 'Ei vaadi ilmoittautumista (check in)/poistumisilmoittautumista (check out)';
		$strings['RequiresApproval'] = 'Vaatii hyväksynnän';
		$strings['CheckingIn'] = 'Sisäänkirjaudutaan varaukseen...';
		$strings['CheckingOut'] = 'Uloskirjaudutaan varauksesta...';
		$strings['CheckIn'] = 'Sisäänkirjaudu varaukseen';
		$strings['CheckOut'] = 'Uloskirjaudu varauksesta';
		$strings['ReleasedIn'] = 'Vapautetaan:'; //...$s päästä
		$strings['CheckedInSuccess'] = 'Olet sisäänkirjautunut varaukseen';
		$strings['CheckedOutSuccess'] = 'Olet uloskirjautunut varauksesta';
		$strings['CheckInFailed'] = 'Sisäänkirjautuminen varaukseen ei onnistunut';
		$strings['CheckOutFailed'] = 'Uloskirjautuminen varauksesta ei onnistunut';
		$strings['CheckInTime'] = 'Sisäänkirjautumisaika';
		$strings['CheckOutTime'] = 'Uloskirjautumisaika';
		$strings['OriginalEndDate'] = 'Alkuperäinen loppuaika';
		$strings['SpecificDates'] = 'Näytä tietyt päivämäärät';
		$strings['Users'] = 'Käyttäjät';
		$strings['Guest'] = 'Vieraat';
		$strings['ResourceDisplayPrompt'] = 'Näytettävät tilat';
		$strings['Credits'] = 'Krediitit';
		$strings['AvailableCredits'] = 'Käytettävissä olevat krediitit';
		$strings['CreditUsagePerSlot'] = 'Vaatii %s krediittiä jokaista aikaikkunaa kohden (ei ruuhka)';
		$strings['PeakCreditUsagePerSlot'] = 'Vaatii %s krediittiä jokaista aikaikkunaa kohden (ruuhka)';
		$strings['CreditsRule'] = 'Sinulla ei ole tarpeeksi krediittejä. Krediitit vaadittu: %s. Krediittisi: %s';
		$strings['PeakTimes'] = 'Ruuhka-ajat';
		$strings['AllYear'] = 'Koko vuoden';
		$strings['MoreOptions'] = 'Lisäasetukset';
		$strings['SendAsEmail'] = 'Lähetä sähköpostina';
		$strings['UsersInGroups'] = 'Käyttäjiä ryhmässä';
		$strings['UsersWithAccessToResources'] = 'Käyttäjiä joilla oikeudet Tiloihin';
		$strings['AnnouncementSubject'] = '%s lisäsi uuden ilmoituksen';
		$strings['AnnouncementEmailNotice'] = 'käyttäjille lähetetään tämä ilmoitus sähköpostina';
		$strings['Day'] = 'Päivä';
		$strings['NotifyWhenAvailable'] = 'Ilmoita minulle kun vapautuu';
		$strings['AddingToWaitlist'] = 'Lisätään sinut odotuslistalle';
		$strings['WaitlistRequestAdded'] = 'Sinulle ilmoitetaan jos tämä aika vapautuu';
		$strings['PrintQRCode'] = 'Tulosta QR-koodi';
		$strings['FindATime'] = 'Etsi aika';
		$strings['AnyResource'] = 'Mikä tahansa tila';
		$strings['ThisWeek'] = 'Tällä viikolla';
		$strings['Hours'] = 'Tuntia';
		$strings['Minutes'] = 'Minuuttia';
        $strings['ImportICS'] = 'Tuo ICS-tiedostosta';
        $strings['ImportQuartzy'] = 'Tuo Quartzysta';
        $strings['OnlyIcs'] = 'Vain *.ics -tiedostoja voi lisätä.';
        $strings['IcsLocationsAsResources'] = 'Sijainteja tuodaan tiloiksi.';
        $strings['IcsMissingOrganizer'] = 'Tapahtumiin joista puuttuu järjestäjä asetetaan nykyinen kirjautunut käyttäjä omistajaksi.';
        $strings['IcsWarning'] = 'Varaussääntöjä ei huomioida - ristiriidat, duplikaatit, jne. ovat mahdollisia.';
		$strings['BlackoutAroundConflicts'] = 'Suljettu aika ristiriidassa olevien varausten ympärille';
		$strings['DuplicateReservation'] = 'Duplikaatti';
		$strings['UnavailableNow'] = 'Ei saatavissa nyt';
		$strings['ReserveLater'] = 'Varaa myöhemmin';
		$strings['CollectedFor'] = 'Kerätty käyttäjälle';
		$strings['IncludeDeleted'] = 'Sisällytä poistetut varaukset';
		$strings['Deleted'] = 'Poistettu';
		$strings['Back'] = 'Takaisin';
		$strings['Forward'] = 'Eteenpäin';
		$strings['DateRange'] = 'Päivämääräalue';
		$strings['Copy'] = 'Kopioi';
		$strings['Detect'] = 'Tunnista aikavyöhyke';
		$strings['Autofill'] = 'Automaattinen täyttö';
		// End Strings

		// Install
		$strings['InstallApplication'] = 'Asenna Muuntamo (MySQL pelkästään)';
		$strings['IncorrectInstallPassword'] = 'Pahoittelumme, salasana oli väärin.';
		$strings['SetInstallPassword'] = 'Sinun täytyy asettaa asennussalasana ennen kuin asennusta voidaan suorittaa.';
		$strings['InstallPasswordInstructions'] = '%s:ssa aseta %s salasanksi mikä on satunnainen ja vaikea arvata, palaa sen jälkeen tälle sivulle.<br/>Voit käyttää %s';
		$strings['NoUpgradeNeeded'] = 'Muuntamo on jo uusimmasssa päivityksessä. Ei ole tarvetta päivitykselle.';
		$strings['ProvideInstallPassword'] = 'Ole hyvä ja anna asennussalasanasi.';
		$strings['InstallPasswordLocation'] = 'Tämä löytyy %s:sta kohdasta %s.';
		$strings['VerifyInstallSettings'] = 'Varmista seuraavat oletusasetukset. Tai voit vaihtaa niitä %s:ssä.';
		$strings['DatabaseName'] = 'Tietokannan nimi (name)';
		$strings['DatabaseUser'] = 'Tietokannan käyttäjä (user)';
		$strings['DatabaseHost'] = 'tietokannan isäntä (host)';
		$strings['DatabaseCredentials'] = 'Sinun täytyy antaa tunnukset MySQL käyttäjään jolla on oikeudet luoda tietokantoja. Jos sinulla ei ole näitä, ole yhteydessä tietokantaylläpitäjääsi. Useimmissa tapauksissa root-käyttäjä toimii.';
		$strings['MySQLUser'] = 'MySQL Käyttäjä (user)';
		$strings['InstallOptionsWarning'] = 'Seuraavat asetukset eivät luultavasti toimi ulkopuolisessa hostauspalvelussa. Jos asennat hostauspalveluun, käytä annettuja MySQL wizard työkaluja suorittaaksesi nämä askeleet.';
		$strings['CreateDatabase'] = 'Luo tietokanta (database)';
		$strings['CreateDatabaseUser'] = 'Luo tietokannan käyttäjä (user)';
		$strings['PopulateExampleData'] = 'Tuo esimerkkidata. Luo ylläpitokäyttäjän: admin/password ja peruskäyttäjätilin: user/password';
		$strings['DataWipeWarning'] = 'Varoitus: Tämä poistaa kaiken olemassaolevan datan';
		$strings['RunInstallation'] = 'Suorita asennus';
		$strings['UpgradeNotice'] = 'Asennat versiosta <b>%s</b> versioon <b>%s</b>';
		$strings['RunUpgrade'] = 'Suorita päivitys';
		$strings['Executing'] = 'Suoritetaan';
		$strings['StatementFailed'] = 'Epäonnistui. Tiedot:';
		$strings['SQLStatement'] = 'SQL Statement:';
		$strings['ErrorCode'] = 'Virhekoodi:';
		$strings['ErrorText'] = 'Virheteksti:';
		$strings['InstallationSuccess'] = 'Asennus suoritettiin onnistuneesti!';
		$strings['RegisterAdminUser'] = 'Rekisteröi ylläpitokäyttäjäsi. Tämä on vaadittua jos et tuonut esimerkkidataa. Varmista että $conf[\'settings\'][\'allow.self.registration\'] = \'true\' on asetettu %s tiedostossasi.';
		$strings['LoginWithSampleAccounts'] = 'Jos toit esimerkkidatan, voit kirjautua admin/password ylläpitokäyttäjään tai user/password peruskäyttäjään.';
		$strings['InstalledVersion'] = 'Versio %s Muuntamosta';
		$strings['InstallUpgradeConfig'] = 'On suositeltavaa päivittää \'config\' tiedostosi.';
		$strings['InstallationFailure'] = 'Asennuksessa oli ongelmia.  Ole hyvä ja korjaa ne ja yritä asennusta uudelleen.';
		$strings['ConfigureApplication'] = 'Konfiguroi Muuntamo';
		$strings['ConfigUpdateSuccess'] = 'Konfigurointitiedostosi on ajan tasalla!';
		$strings['ConfigUpdateFailure'] = 'Emme pystyneet automaattisesti päivittämään konfigurointitiedostoasi. Ole hyvä ja korvaa config.php sisältö seuraavalla:';	
		$strings['SelectUser'] = 'Valitse käyttäjä';
		$strings['InviteUsers'] = 'Kutsu käyttäjä';
		$strings['InviteUsersLabel'] = 'Anna kutsuttavien käyttäjien sähköpostiosoitteet';
		// End Install

		// Errors
		$strings['LoginError'] = 'Käyttäjänimi tai salasana on virheellinen';
		$strings['ReservationFailed'] = 'Varaustasi ei voitu toteuttaa';
		$strings['MinNoticeError'] = 'Tämä varaus on ilmoitettava etukäteen.  Aikaisin mahdollinen päivä varauksen tekemiseen on %s.';
		$strings['MaxNoticeError'] = 'Tätä varausta ei voi tehdä näin kauas tulevaisuuteen.  Viimeisin ajankohta joka voidaan varata on %s.';
		$strings['MinDurationError'] = 'Tämän varauksen tulee olla vähintään %s.';
		$strings['MaxDurationError'] = 'Tämä varaus ei voi kestää pitempään kuin %s.';
		$strings['ConflictingAccessoryDates'] = 'Seuraavia lisävarusteita ei ole tarpeeksi: ';
		$strings['NoResourcePermission'] = 'Sinulla ei ole käyttöoikeutta yhteen tai useampaan tilaan';
		$strings['ConflictingReservationDates'] = 'Seuraavina päivinä on ristiriidan aiheuttavia toisia varauksia: ';
		$strings['StartDateBeforeEndDateRule'] = 'Aloituspäivän tulee olla ennen varauksen loppumispäivää';
		$strings['StartIsInPast'] = 'Aloituspäivä ei voi olla menneisyydessä';
		$strings['EmailDisabled'] = 'Moderaattori on estänyt automaattiset sähköposti-ilmoitukset';
		$strings['ValidLayoutRequired'] = 'Varaa kaikki 24 tuntia alkaen ja päättyen klo 00:00.';
		$strings['CustomAttributeErrors'] = 'Ongelmia seuraavien antamiesi lisäominaisuuksien kanssa:';
		$strings['CustomAttributeRequired'] = '%s on vaadittu kenttä.';
		$strings['CustomAttributeInvalid'] = '%s:n arvo on vääränlainen.';
		$strings['AttachmentLoadingError'] = 'Pahoittelumme, pyydetyn tiedoston lataamisessa oli ongelmia.';
		$strings['InvalidAttachmentExtension'] = 'Voit vain tallettaa seuraavan tyyppisiä tiedostoja: %s';
		$strings['InvalidStartSlot'] = 'Alkupäivämäärä ja pyydetty aika ovat vääränlaisia.';
		$strings['InvalidEndSlot'] = 'Loppupäivämäärä ja pyydetty aika ovat vääränlaisia.';
		$strings['MaxParticipantsError'] = 'Tila %s voi tukea vain %s osallistujaa.';
		$strings['ReservationCriticalError'] = 'Kriittinen virhe tallettaessa varaustasi. Jos tämä toistuu, ole yhteydessä ylläpitoon.';
		$strings['InvalidStartReminderTime'] = 'Alkumuistutusaika on vääränlainen.';
		$strings['InvalidEndReminderTime'] = 'Loppumuistutusaika on vääränlainen.';
		$strings['QuotaExceeded'] = 'Kiintiöraja ylitetty.';
		$strings['MultiDayRule'] = 'Tila %s ei salli varauksia päivien yli.';
		$strings['InvalidReservationData'] = 'Varauspyynnössäsi oli virhe.';
		$strings['PasswordError'] = 'Salasanassa täytyy olla vähintään %s kirjainta ja %s numeroa.';
		$strings['PasswordErrorRequirements'] = 'Salasanassa täytää olla vähintään yhdistelmä %s isoja ja pieniä kirjaimia ja %s numeroa.';
		$strings['NoReservationAccess'] = 'Sinulla ei ole oikeuksia muuttaa tätä varausta.';
		$strings['PasswordControlledExternallyError'] = 'Salasanaasi kontrolloi ulkopuolinen järjestelmä ja ei pystytä muuttamaan täällä.';
		$strings['AccessoryResourceRequiredErrorMessage'] = 'Lisävarusteen %s voi vain varata tiloihin %s';
		$strings['AccessoryMinQuantityErrorMessage'] = 'Sinun täytää varata vähintään %s lisävarustetta %s';
		$strings['AccessoryMaxQuantityErrorMessage'] = 'Et voi varata enempää kuin %s lisävarustetta %s';
		$strings['AccessoryResourceAssociationErrorMessage'] = 'Lisävarustetta \'%s\' ei voi varata pyydetyissä tiloissa';
		$strings['NoResources'] = 'Et ole lisännyt yhtään tilaan.';
		$strings['ParticipationNotAllowed'] = 'Et pysty osallistumaan tähän varaukseen.';
		$strings['ReservationCannotBeCheckedInTo'] = 'Tähän varaukseen ei voi sisäänkirjautua.';
		$strings['ReservationCannotBeCheckedOutFrom'] = 'Tästä varauksesta ei voi uloskirjautua.';
		$strings['InvalidEmailDomain'] = 'Sähköpostiosoite ei ole sallituissa verkkotunnuksissa';
		// End Errors

		// Page Titles
		$strings['CreateReservation'] = 'Tee varaus';
		$strings['EditReservation'] = 'Muokkaa varausta';
		$strings['LogIn'] = 'Kirjaudu';
		$strings['ManageReservations'] = 'Varaukset';
		$strings['AwaitingActivation'] = 'Odottaa aktivointia';
		$strings['PendingApproval'] = 'Odottaa hyväksymistä';
		$strings['ManageSchedules'] = 'Varauskalenterit';
		$strings['ManageResources'] = 'Varattavat tilat';
		$strings['ManageAccessories'] = 'Lisävarusteet';
		$strings['ManageUsers'] = 'Käyttäjät';
		$strings['ManageGroups'] = 'Ryhmät';
		$strings['ManageQuotas'] = 'Kiintiöt';
		$strings['ManageBlackouts'] = 'Estetyt ajankohdat';
		$strings['MyDashboard'] = 'Oma etusivu';		//Original translation: 'Oma työpöytä'
		$strings['ServerSettings'] = 'Palvelinasetukset';
		$strings['Dashboard'] = 'Etusivu';		//Original translation: 'Työpöytä'
		$strings['Help'] = 'Ohje';
		$strings['Bookings'] = 'Tilatut varaukset';
		$strings['Schedule'] = 'Varauskalenteri';
		$strings['Reservations'] = 'Varaukset';
		$strings['Account'] = 'Tili';
		$strings['EditProfile'] = 'Muokkaa profiilia';
		$strings['FindAnOpening'] = 'Etsi alkukohta';
		$strings['OpenInvitations'] = 'Avaa kutsut';
		$strings['MyCalendar'] = 'Oma kalenteri';
		$strings['ResourceCalendar'] = 'Tilankäyttökalenteri';
		$strings['Reservation'] = 'Uusi varaus';
		$strings['Install'] = 'Asennus';
		$strings['ChangePassword'] = 'Vaihda salasana';
		$strings['MyAccount'] = 'Käyttäjätili';
		$strings['Profile'] = 'Profiili';
		$strings['ApplicationManagement'] = 'Ylläpito';
		$strings['ForgotPassword'] = 'Olen unohtanut salasanani';
		$strings['NotificationPreferences'] = 'Ilmoitusten asetukset';
		$strings['ManageAnnouncements'] = 'Ilmoitukset';
		$strings['Responsibilities'] = 'Vastuut';
		$strings['GroupReservations'] = 'Ryhmävaraukset';
		$strings['ResourceReservations'] = 'Tilojen varaukset';
		$strings['Customization'] = 'Kustomisointi';
		$strings['Attributes'] = 'Ominaisuudet';
		$strings['AccountActivation'] = 'Käyttäjätunnusten aktivointi';
		$strings['ScheduleReservations'] = 'Aikatauluvaraukset';
		$strings['Reports'] = 'Raportit';
		$strings['GenerateReport'] = 'Luo uusi varaus';
		$strings['MySavedReports'] = 'Raporttini';
		$strings['CommonReports'] = 'Yleiset raportit';
		$strings['ViewDay'] = 'Näytä päivä';
		$strings['Group'] = 'Ryhmä';
		$strings['ManageConfiguration'] = 'Sovelluksen konfiguraatio';
		$strings['LookAndFeel'] = 'Look and Feel';
		$strings['ManageResourceGroups'] = 'Tilaryhmät';
		$strings['ManageResourceTypes'] = 'Tilatyypit';
		$strings['ManageResourceStatus'] = 'Tilatilat';
		$strings['ReservationColors'] = 'Tilavärit';
		// End Page Titles

		// Day representations
		$strings['DaySundaySingle'] = 'S';
		$strings['DayMondaySingle'] = 'M';
		$strings['DayTuesdaySingle'] = 'T';
		$strings['DayWednesdaySingle'] = 'K';
		$strings['DayThursdaySingle'] = 'T';
		$strings['DayFridaySingle'] = 'P';
		$strings['DaySaturdaySingle'] = 'L';

		$strings['DaySundayAbbr'] = 'Su';
		$strings['DayMondayAbbr'] = 'Ma';
		$strings['DayTuesdayAbbr'] = 'Ti';
		$strings['DayWednesdayAbbr'] = 'Ke';
		$strings['DayThursdayAbbr'] = 'To';
		$strings['DayFridayAbbr'] = 'Pe';
		$strings['DaySaturdayAbbr'] = 'La';
		// End Day representations

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'Varauksesi on hyväksytty';
		$strings['ReservationCreatedSubject'] = 'Varauksesi on tehty';
		$strings['ReservationUpdatedSubject'] = 'Varauksesi on päivitetty';
		$strings['ReservationDeletedSubject'] = 'Varauksesi on poistettu';
		$strings['ReservationCreatedAdminSubject'] = 'Ilmoitus: Varaus on tehty';
		$strings['ReservationUpdatedAdminSubject'] = 'Ilmoitus: Varaus on päivitetty';
		$strings['ReservationDeleteAdminSubject'] = 'Ilmoitus: Varaus on poistettu';
		$strings['ReservationApprovalAdminSubject'] = 'Ilmoitus: Varaus vaatii hyväksyntääsi';
		$strings['ParticipantAddedSubject'] = 'Ilmoitus varaukseen osallistumisesta';
		$strings['ParticipantDeletedSubject'] = 'Varaus poistettu';
		$strings['InviteeAddedSubject'] = 'Varauskutsu';
		$strings['ResetPassword'] = 'Salasanan resetointipyyntö';
		$strings['ActivateYourAccount'] = 'Ole hyvä ja aktivoi käyttäjätunnuksesi';
		$strings['ReportSubject'] = 'Pyytämäsi raportti (%s)';
		$strings['ReservationStartingSoonSubject'] = 'Varauksesi %s on alkamassa';
		$strings['ReservationEndingSoonSubject'] = 'Varauksesi %s on loppumassa';
		$strings['UserAdded'] = 'Uusi käyttäjä on lisätty';
		$strings['UserDeleted'] = 'Käyttäjätunnus %s poistettiin %s toimesti';
		$strings['GuestAccountCreatedSubject'] = 'Käyttäjätunnuksesi tiedot';
		$strings['InviteUserSubject'] = '%s on kutsunut sinut liittymään %s';
	
		$strings['ReservationApprovedSubjectWithResource'] = 'Varauksesi tilaan %s on hyväksytty';
		$strings['ReservationCreatedSubjectWithResource'] = 'Varauksesi tilaan %s on luotu';
		$strings['ReservationUpdatedSubjectWithResource'] = 'Varauksesi tilaan %s päivitettiin';
		$strings['ReservationDeletedSubjectWithResource'] = 'Varauksesi tilaan %s on poistettu';
		$strings['ReservationCreatedAdminSubjectWithResource'] = 'Ilmoitus: Varaus tilaan %s luotu';
		$strings['ReservationUpdatedAdminSubjectWithResource'] = 'Ilmoitus: Varaus tilassa %s päivitetty';
		$strings['ReservationDeleteAdminSubjectWithResource'] = 'Ilmoitus: Varaus tilassa %s poistettu';
		$strings['ReservationApprovalAdminSubjectWithResource'] = 'Ilmoitus: Varaus tilaan %s vaatii hyväksyntääsi';
		$strings['ParticipantAddedSubjectWithResource'] = '%s lisäsi sinut varaukseen tilassa %s';
		$strings['ParticipantDeletedSubjectWithResource'] = '%s poisti sinut varauksesta tilassa %s';
		$strings['InviteeAddedSubjectWithResource'] = '%s kutsui sinut varaukseen tilassa %s';
		// End Email Subjects

		$strings['ForgotPasswordEmailSent'] = 'Ohjeet salasanan palauttamiseksi lähetettiin antamaasi sähköpostiosoitteeseen';
		// End Email Subjects

		$this->Strings = $strings;

		return $this->Strings;
	}

	/**
	 * @return array
	 */
	protected function _LoadDays()
	{
		$days = parent::_LoadDays();

		/***
		DAY NAMES
		All of these arrays MUST start with Sunday as the first element
		and go through the seven day week, ending on Saturday
		 ***/
		// The full day name
		$days['full'] = array('Sunnuntai', 'Maanantai', 'Tiistai', 'Keskiviikko', 'Torstai', 'Perjantai', 'Lauantai');
		// The three letter abbreviation
		$days['abbr'] = array('Sun', 'Maa', 'Tii', 'Kes', 'Tor', 'Per', 'Lau');
		// The two letter abbreviation
		$days['two'] = array('Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La');
		// The one letter abbreviation
		$days['letter'] = array('S', 'M', 'T', 'K', 'T', 'P', 'L');

		$this->Days = $days;
	}

	/**
	 * @return array
	 */
	protected function _LoadMonths()
	{
		$months = parent::_LoadMonths();

		/***
		MONTH NAMES
		All of these arrays MUST start with January as the first element
		and go through the twelve months of the year, ending on December
		 ***/
		// The full month name
		$months['full'] = array('Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu');
		// The three letter month name
		$months['abbr'] = array('Tam', 'Hel', 'Maa', 'Huh', 'Tou', 'Kes', 'Hei', 'Elo', 'Syy', 'Lok', 'Mar', 'Jou');

		$this->Months = $months;
	}

	/**
	 * @return array
	 */
	protected function _LoadLetters()
	{
		$this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	}

	protected function _GetHtmlLangCode()
	{
		return 'fi';
	}
}
