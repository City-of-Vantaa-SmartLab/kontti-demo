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

class es extends en_us
{
    public function __construct()
    {
		parent::__construct();
    }

    protected function _LoadDates()
    {
		$dates = parent::_LoadDates();

		$dates['general_date'] = 'd/m/Y';
		$dates['general_datetime'] = 'd/m/Y H:i:s';
		$dates['short_datetime'] = 'n/j/y g:i A';
		$dates['schedule_daily'] = 'l, d/m/Y';
		$dates['reservation_email'] = 'd/m/Y @ g:i A (e)';
		$dates['res_popup'] = 'd/m/Y g:i A';
		$dates['short_reservation_date'] = 'n/j/y g:i A';
		$dates['dashboard'] = 'd/m/Y g:i A';
		$dates['period_time'] = "g:i A";
		$dates['mobile_reservation_date'] = 'n/j g:i A';
		$dates['general_date_js'] = "dd/mm/yy";
		$dates['general_time_js'] = 'h:mm tt';
		$dates['momentjs_datetime'] = 'D/M/YY h:mm A';
		$dates['calendar_time'] = 'h:mmt';
		$dates['calendar_dates'] = 'd/M';

		$this->Dates = $dates;
    }

    protected function _LoadStrings()
    {
		$strings = parent::_LoadStrings();

		$strings['FirstName'] = 'Nombre';
		$strings['LastName'] = 'Apellido';
		$strings['Timezone'] = 'Zona horaria';
		$strings['Edit'] = 'Editar';
		$strings['Change'] = 'Cambiar';
		$strings['Rename'] = 'Renombrar';
		$strings['Remove'] = 'Eliminar';
		$strings['Delete'] = 'Borrar';
		$strings['Update'] = 'Actualizar';
		$strings['Cancel'] = 'Cancelar';
		$strings['Add'] = 'Agregar';
		$strings['Name'] = 'Nombre';
		$strings['Yes'] = 'Sí';
		$strings['No'] = 'No';
		$strings['FirstNameRequired'] = 'Se requiere un nombre.';
		$strings['LastNameRequired'] = 'Se requiere un apellido.';
		$strings['PwMustMatch'] = 'La contraseña de confirmación debe coincidir.';
		$strings['ValidEmailRequired'] = 'Se requiere una dirección válida de correo.';
		$strings['UniqueEmailRequired'] = 'Esa dirección de correo ya está registrada.';
		$strings['UniqueUsernameRequired'] = 'Ese nombre de usuario ya está registrado.';
		$strings['UserNameRequired'] = 'Se requiere un nombre de usuario.';
		$strings['CaptchaMustMatch'] = 'Por favor, introduce los caracteres de seguridad tal como aparecen.';
		$strings['Today'] = 'Hoy';
		$strings['Week'] = 'Semana';
		$strings['Month'] = 'Mes';
		$strings['BackToCalendar'] = 'Regreso al calendario';
		$strings['BeginDate'] = 'Inicio';
		$strings['EndDate'] = 'Fin';
		$strings['Username'] = 'Nombre de usuario';
		$strings['Password'] = 'Contraseña';
		$strings['PasswordConfirmation'] = 'Confirmar contraseña';
		$strings['DefaultPage'] = 'Página de inicio predeterminada';
		$strings['MyCalendar'] = 'Mi calendario';
		$strings['ScheduleCalendar'] = 'Calendario de reservas';
		$strings['Registration'] = 'Registro';
		$strings['NoAnnouncements'] = 'No hay anuncios';
		$strings['Announcements'] = 'Anuncios';
		$strings['NoUpcomingReservations'] = 'No tienes reservas próximas';
		$strings['UpcomingReservations'] = 'Próximas reservas';
		$strings['AllNoUpcomingReservations'] = 'No tienes reservas en los próximos %s días';
		$strings['AllUpcomingReservations'] = 'Todas las reservas próximas';
		$strings['ShowHide'] = 'Mostrar/Ocultar';
		$strings['Error'] = 'Error';
		$strings['ReturnToPreviousPage'] = 'Volver a la página anterior';
		$strings['UnknownError'] = 'Error desconocido';
		$strings['InsufficientPermissionsError'] = 'No tienes permiso para acceder a este recurso';
		$strings['MissingReservationResourceError'] = 'No se ha seleccionado un recurso';
		$strings['MissingReservationScheduleError'] = 'No se ha seleccionado una planificación';
		$strings['DoesNotRepeat'] = 'No se repite';
		$strings['Daily'] = 'Diario';
		$strings['Weekly'] = 'Semanal';
		$strings['Monthly'] = 'Mensual';
		$strings['Yearly'] = 'Anual';
		$strings['RepeatPrompt'] = 'Repetir';
		$strings['hours'] = 'horas';
		$strings['days'] = 'días';
		$strings['weeks'] = 'semanas';
		$strings['months'] = 'meses';
		$strings['years'] = 'años';
		$strings['day'] = 'día';
		$strings['week'] = 'semana';
		$strings['month'] = 'mes';
		$strings['year'] = 'año';
		$strings['repeatDayOfMonth'] = 'día del mes';
		$strings['repeatDayOfWeek'] = 'día de la semana';
		$strings['RepeatUntilPrompt'] = 'Hasta';
		$strings['RepeatEveryPrompt'] = 'Cada';
		$strings['RepeatDaysPrompt'] = 'En';
		$strings['CreateReservationHeading'] = 'Crear una nueva reserva';
		$strings['EditReservationHeading'] = 'Editando reserva %s';
		$strings['ViewReservationHeading'] = 'Viendo reserva %s';
		$strings['ReservationErrors'] = 'Cambiar reserva';
		$strings['Create'] = 'Crear';
		$strings['ThisInstance'] = 'Sólo esta instancia';
		$strings['AllInstances'] = 'Todas las instancias';
		$strings['FutureInstances'] = 'Instancias futuras';
		$strings['Print'] = 'Imprimir';
		$strings['ShowHideNavigation'] = 'Mostrar/Ocultar navegación';
		$strings['ReferenceNumber'] = 'Número de referencia';
		$strings['Tomorrow'] = 'Mañana';
		$strings['LaterThisWeek'] = 'Más tarde esta semana';
		$strings['NextWeek'] = 'Siguiente semana';
		$strings['SignOut'] = 'Cerrar';
		$strings['LayoutDescription'] = 'Empieza en %s, mostrando %s días cada vez';
		$strings['AllResources'] = 'Todos los recursos';
		$strings['TakeOffline'] = 'Deshabilitar';
		$strings['BringOnline'] = 'Habilitar';
		$strings['AddImage'] = 'Agregar imagen';
		$strings['NoImage'] = 'Sin imagen asignada';
		$strings['Move'] = 'Mover';
		$strings['AppearsOn'] = 'Aparece en %s';
		$strings['Location'] = 'Localización';
		$strings['NoLocationLabel'] = '(no se ha fijado una localización)';
		$strings['Contact'] = 'Contacto';
		$strings['NoContactLabel'] = '(sin información de contacto)';
		$strings['Description'] = 'Descripción';
		$strings['NoDescriptionLabel'] = '(sin descripción)';
		$strings['Notes'] = 'Notas';
		$strings['NoNotesLabel'] = '(sin notas)';
		$strings['NoTitleLabel'] = '(sin título)';
		$strings['UsageConfiguration'] = 'Configuración de uso';
		$strings['ChangeConfiguration'] = 'Cambiar configuración';
		$strings['ResourceMinLength'] = 'Las reservas deben durar por lo menos %s';
		$strings['ResourceMinLengthNone'] = 'No hay duración mínima de reserva';
		$strings['ResourceMaxLength'] = 'Las reservas no pueden durar más de %s';
		$strings['ResourceMaxLengthNone'] = 'No hay duración máxima de reserva';
		$strings['ResourceRequiresApproval'] = 'Las reservas deben ser aprobadas';
		$strings['ResourceRequiresApprovalNone'] = 'Las reservas no requieren ser aprobadas';
		$strings['ResourcePermissionAutoGranted'] = 'El permiso se concede automáticamente';
		$strings['ResourcePermissionNotAutoGranted'] = 'El permiso no se concede automáticamente';
		$strings['ResourceMinNotice'] = 'Las reservas deben realizarse al menos %s antes del tiempo de inicio';
		$strings['ResourceMinNoticeNone'] = 'Las reservas se pueden realizar hasta la hora actual';
		$strings['ResourceMaxNotice'] = 'Las reservas no deben durar más de %s desde la hora actual';
		$strings['ResourceMaxNoticeNone'] = 'Las reservas pueden terminar en cualquier momento futuro';
		$strings['ResourceBufferTime'] = 'Debe de haber %s entre reservas';
		$strings['ResourceBufferTimeNone'] = 'No hay tiempo entre reservas';
		$strings['ResourceAllowMultiDay'] = 'Las reservas pueden extenderse a lo largo de días';
		$strings['ResourceNotAllowMultiDay'] = 'Las reservas no pueden extenderse a lo largo de días';
		$strings['ResourceCapacity'] = 'Este recurso tiene una capacidad de %s personas';
		$strings['ResourceCapacityNone'] = 'Este recurso tiene capacidad ilimitada';
		$strings['AddNewResource'] = 'Agregar nuevo recurso';
		$strings['AddNewUser'] = 'Agregar nuevo usuario';
		$strings['AddUser'] = 'Agregar usuario';
		$strings['Schedule'] = 'Planificación';
		$strings['AddResource'] = 'Agregar recurso';
		$strings['Capacity'] = 'Capacidad';
		$strings['Access'] = 'Acceso';
		$strings['Duration'] = 'Duración';
		$strings['Active'] = 'Activo';
		$strings['Inactive'] = 'Inactivo';
		$strings['ResetPassword'] = 'Restablecer contraseña';
		$strings['LastLogin'] = 'Último inicio de sesión';
		$strings['Search'] = 'Buscar';
		$strings['ResourcePermissions'] = 'Permisos del recurso';
		$strings['Reservations'] = 'Reservas';
		$strings['Groups'] = 'Grupos';
		$strings['Users'] = 'Usuarios';
		$strings['ResetPassword'] = 'Restablecer contraseña';
		$strings['AllUsers'] = 'Todos los usuarios';
		$strings['AllGroups'] = 'Todos los grupos';
		$strings['AllSchedules'] = 'Todas las planificaciones';
		$strings['UsernameOrEmail'] = 'Nombre de usuario o correo electrónico';
		$strings['Members'] = 'Miembros';
		$strings['QuickSlotCreation'] = 'Crear un intervalo de tiempo cada %s minutos entre %s y %s';
		$strings['ApplyUpdatesTo'] = 'Aplicar actualizaciones a';
		$strings['CancelParticipation'] = 'Cancelar participación';
		$strings['Attending'] = 'Asistencia';
		$strings['QuotaConfiguration'] = 'En %s para %s usuarios en %s están limitados a %s %s por cada %s';
		$strings['QuotaEnforcement'] = 'Impuesto %s %s';
		$strings['reservations'] = 'reservas';
		$strings['reservation'] = 'reserva';
		$strings['ChangeCalendar'] = 'Cambiar calendario';
		$strings['AddQuota'] = 'Agregar cuota';
		$strings['FindUser'] = 'Encontrar usuario';
		$strings['Created'] = 'Creado';
		$strings['LastModified'] = 'Última modificación';
		$strings['GroupName'] = 'Nombre de grupo';
		$strings['GroupMembers'] = 'Miembros del grupo';
		$strings['GroupRoles'] = 'Roles del grupo';
		$strings['GroupAdmin'] = 'Administrador del grupo';
		$strings['Actions'] = 'Acciones';
		$strings['CurrentPassword'] = 'Contraseña actual';
		$strings['NewPassword'] = 'Nueva contraseña';
		$strings['InvalidPassword'] = 'La contraseña actual es incorrecta';
		$strings['PasswordChangedSuccessfully'] = 'Tu contraseña se ha modificado correctamente';
		$strings['SignedInAs'] = 'Sesión iniciada por ';
		$strings['NotSignedIn'] = 'No has iniciado sesión';
		$strings['ReservationTitle'] = 'Título de la reserva';
		$strings['ReservationDescription'] = 'Descripción de la reserva';
		$strings['ResourceList'] = 'Recursos a reservar';
		$strings['Accessories'] = 'Accesorios';
		$strings['ParticipantList'] = 'Participantes';
		$strings['InvitationList'] = 'Invitados';
		$strings['AccessoryName'] = 'Nombre de accesorio';
		$strings['QuantityAvailable'] = 'Cantidad disponible';
		$strings['Resources'] = 'Recursos';
		$strings['Participants'] = 'Participantes';
		$strings['User'] = 'Usuario';
		$strings['Resource'] = 'Recurso';
		$strings['Status'] = 'Estado';
		$strings['Approve'] = 'Aprobado';
		$strings['Page'] = 'Página';
		$strings['Rows'] = 'Filas';
		$strings['Unlimited'] = 'Ilimitado';
		$strings['Email'] = 'Correo';
		$strings['EmailAddress'] = 'Direción de Correo';
		$strings['Phone'] = 'Teléfono';
		$strings['Organization'] = 'Organización';
		$strings['Position'] = 'Posición';
		$strings['Language'] = 'Idioma';
		$strings['Permissions'] = 'Permisos';
		$strings['Reset'] = 'Reiniciar';
		$strings['FindGroup'] = 'Encontrar grupo';
		$strings['Manage'] = 'Gestionar';
		$strings['None'] = 'Ninguno';
		$strings['AddToOutlook'] = 'Agregar a Outlook';
		$strings['Done'] = 'Hecho';
		$strings['RememberMe'] = 'Recuérdame';
		$strings['FirstTimeUser?'] = '¿Eres un usuario nuevo?';
		$strings['CreateAnAccount'] = 'Crear cuenta';
		$strings['ViewSchedule'] = 'Ver planificación';
		$strings['ForgotMyPassword'] = 'He olvidado mi contraseña';
		$strings['YouWillBeEmailedANewPassword'] = 'Se te enviará una contraseña generada aleatoriamente.';
		$strings['Close'] = 'Cerrar';
		$strings['ExportToCSV'] = 'Exportar a CSV';
		$strings['OK'] = 'OK';
		$strings['Working'] = 'Trabajando...';
		$strings['Login'] = 'Iniciar sesión';
		$strings['AdditionalInformation'] = 'Información adicional';
		$strings['AllFieldsAreRequired'] = 'Se requieren todos los campos';
		$strings['Optional'] = 'opcional';
		$strings['YourProfileWasUpdated'] = 'Se ha actualizado el perfil';
		$strings['YourSettingsWereUpdated'] = 'Se han actualizado los ajustes';
		$strings['Register'] = 'Registrar';
		$strings['SecurityCode'] = 'Código de seguridad';
		$strings['ReservationCreatedPreference'] = 'Cuando creo una reserva o una reserva se crea en mi nombre';
		$strings['ReservationUpdatedPreference'] = 'Cuando actualizo una reserva o una reserva se actualiza en mi nombre';
		$strings['ReservationDeletedPreference'] = 'Cuando borro una reserva o se borra una reserva en mi nombre';
		$strings['ReservationApprovalPreference'] = 'Cuando mi reserva pendiente ha sido aprobada';
		$strings['PreferenceSendEmail'] = 'Envíame un correo';
		$strings['PreferenceNoEmail'] = 'No me notifiques';
		$strings['ReservationCreated'] = '¡Tu reserva se ha creado correctamente!';
		$strings['ReservationUpdated'] = '¡Tu reserva se ha actualizado correctamente!';
		$strings['ReservationRemoved'] = 'Tu reserva se ha eliminado';
		$strings['ReservationRequiresApproval'] = 'Uno o más de los recursos reservados requieren aprobación antes de su uso. Esta reserva queará pendiente hasta que sea aprobada.';
		$strings['YourReferenceNumber'] = 'Tu número de referencia es %s';
		$strings['UpdatingReservation'] = 'Actualizando reserva';
		$strings['ChangeUser'] = 'Cambiar usuario';
		$strings['MoreResources'] = 'Más recursos';
		$strings['ReservationLength'] = 'Duración de la reserva';
		$strings['ParticipantList'] = 'Lista de participantes';
		$strings['AddParticipants'] = 'Agregar participantes';
		$strings['InviteOthers'] = 'Invitar a otros';
		$strings['AddResources'] = 'Agregar recursos';
		$strings['AddAccessories'] = 'Agregar Accesorios';
		$strings['Accessory'] = 'Accesorio';
		$strings['QuantityRequested'] = 'Cantidad requerida';
		$strings['CreatingReservation'] = 'Creando reserva';
		$strings['UpdatingReservation'] = 'Actualizando reserva';
		$strings['DeleteWarning'] = '¡Esta acción es permanente e irrecuperable!';
		$strings['DeleteAccessoryWarning'] = 'Al borrar este accesorio se eliminará de todas las reservas.';
		$strings['AddAccessory'] = 'Agregar accesorio';
		$strings['AddBlackout'] = 'Agregar No Disponibilidad';
		$strings['AllResourcesOn'] = 'Todos los recursos habilitados';
		$strings['Reason'] = 'Razón';
		$strings['BlackoutShowMe'] = 'Muéstrame reservas en conflicto';
		$strings['BlackoutDeleteConflicts'] = 'Borrar las reservas en conflicto';
		$strings['Filter'] = 'Filtrar';
		$strings['Between'] = 'Entre';
		$strings['CreatedBy'] = 'Creada por';
		$strings['BlackoutCreated'] = 'Se ha creado la no disponibilidad';
		$strings['BlackoutNotCreated'] = 'No se ha podido crear la no disponibilidad';
		$strings['BlackoutUpdated'] = 'Se ha actualizado la no disponibilidad';
		$strings['BlackoutNotUpdated'] = 'No se pudo actualizar la no disponibilidad';
		$strings['BlackoutConflicts'] = 'Hay tiempos de no disponibilidad en conflicto';
		$strings['ReservationConflicts'] = 'Hay tiempos de reserva en conflicto';
		$strings['UsersInGroup'] = 'Usuarios en este grupo';
		$strings['Browse'] = 'Navegar';
		$strings['DeleteGroupWarning'] = 'Al borrar este grupo se eliminarán todos los permisos de los recursos asociados.  Los usuarios en este grupo pueden perder acceso a los recursos.';
		$strings['WhatRolesApplyToThisGroup'] = '¿Qué roles aplican a este grupo?';
		$strings['WhoCanManageThisGroup'] = '¿Quién puede gestionar este grupo?';
		$strings['WhoCanManageThisSchedule'] = '¿Quién puede gestionar esta planificación?';
		$strings['AddGroup'] = 'Agregar grupo';
		$strings['AllQuotas'] = 'Todas las cuotas';
		$strings['QuotaReminder'] = 'Recordatorio: las cuotas se fijan basándose en la zona horaria de las planificaciones.';
		$strings['AllReservations'] = 'Todas las reservas';
		$strings['PendingReservations'] = 'Reservas pendientes';
		$strings['Approving'] = 'Aprobando';
		$strings['MoveToSchedule'] = 'Mover a planificación';
		$strings['DeleteResourceWarning'] = 'Al borrar este recurso se eliminarán todos los datos asociados, incluyendo';
		$strings['DeleteResourceWarningReservations'] = 'todos las reservas pasadas, actuales y futuras asociadas';
		$strings['DeleteResourceWarningPermissions'] = 'todas las asignaciones de permisos';
		$strings['DeleteResourceWarningReassign'] = 'Por favor reasigna todo lo que no quieras que sea borrado antes de continuar';
		$strings['ScheduleLayout'] = 'Distribución horaria (todas las veces %s)';
		$strings['ReservableTimeSlots'] = 'Intervalos de tiempo reservables';
		$strings['BlockedTimeSlots'] = 'Intervalos de tiempo bloqueados';
		$strings['ThisIsTheDefaultSchedule'] = 'Esta es la planificación predeterminada';
		$strings['DefaultScheduleCannotBeDeleted'] = 'La planificación predeterminada no se puede eliminar';
		$strings['MakeDefault'] = 'Hacer predeterminada';
		$strings['BringDown'] = 'Deshabilitar';
		$strings['ChangeLayout'] = 'Cambiar distribución horaria';
		$strings['AddSchedule'] = 'Agregar planificación';
		$strings['StartsOn'] = 'Comienza en';
		$strings['NumberOfDaysVisible'] = 'Números de días visibles';
		$strings['UseSameLayoutAs'] = 'Usar la misma distribución horaria que';
		$strings['Format'] = 'Formato';
		$strings['OptionalLabel'] = 'Etiqueta opcional';
		$strings['LayoutInstructions'] = 'Introduce un intervalo de tiempo por línea. Se deben proporcionar intervalos de tiempo para las 24 horas del día comenzando y terminando a las 12:00 AM.';
		$strings['AddUser'] = 'Agregar usuario';
		$strings['UserPermissionInfo'] = 'El acceso real a los recursos puede ser diferente dependiendo de los roles del usuario, permisos de grupo, o ajustes externos de permisos';
		$strings['DeleteUserWarning'] = 'Al borrar este usuario se eliminarán todas sus reservas actuales, futuras y pasadas.';
		$strings['AddAnnouncement'] = 'Agregar anuncio';
		$strings['Announcement'] = 'Anuncio';
		$strings['Priority'] = 'Prioridad';
		$strings['Reservable'] = 'Reservable';
		$strings['Unreservable'] = 'No reservable';
		$strings['Reserved'] = 'Reservado';
		$strings['MyReservation'] = 'Mi reserva';
		$strings['Pending'] = 'Pendiente';
		$strings['Past'] = 'Pasado';
		$strings['Restricted'] = 'Restringido';
		$strings['ViewAll'] = 'Ver todo';
		$strings['MoveResourcesAndReservations'] = 'Mover recursos y reservas a';
		$strings['TurnOffSubscription'] = 'Desactivar suscripciones en calendario';
		$strings['TurnOnSubscription'] = 'Activar suscripciones en calendario';
		$strings['SubscribeToCalendar'] = 'Subscribirse a este calendario';
		$strings['SubscriptionsAreDisabled'] = 'El administrador ha deshabilitado las suscripciones a este calendario';
		$strings['NoResourceAdministratorLabel'] = '(No hay administrador de recurso)';
		$strings['WhoCanManageThisResource'] = '¿Quién puede administrar este recurso?';
		$strings['ResourceAdministrator'] = 'Administrador de recurso';
		$strings['Private'] = 'Privado';
		$strings['Accept'] = 'Aceptar';
		$strings['Decline'] = 'Rechazar';
		$strings['ShowFullWeek'] = 'Mostrar semana completa';
		$strings['CustomAttributes'] = 'Personalizar atributos';
		$strings['AddAttribute'] = 'Agregar un atributo';
		$strings['EditAttribute'] = 'Editar un atributo';
		$strings['DisplayLabel'] = 'Etiqueta visible';
		$strings['Type'] = 'Tipo';
		$strings['Required'] = 'Requerido';
		$strings['ValidationExpression'] = 'Expresión de validación';
		$strings['PossibleValues'] = 'Posibles valores';
		$strings['SingleLineTextbox'] = 'Caja de texto de una sola línea';
		$strings['MultiLineTextbox'] = 'Caja de texto de múltiples líneas';
		$strings['Checkbox'] = 'Casilla de verificación';
		$strings['SelectList'] = 'Lista de selección';
		$strings['CommaSeparated'] = 'separado por comas';
		$strings['Category'] = 'Categoría';
		$strings['CategoryReservation'] = 'Reserva';
		$strings['CategoryGroup'] = 'Grupo';
		$strings['SortOrder'] = 'Orden';
		$strings['Title'] = 'Título';
		$strings['AdditionalAttributes'] = 'Atributos adicionales';
		$strings['True'] = 'Verdadero';
		$strings['False'] = 'Falso';
		$strings['ForgotPasswordEmailSent'] = 'Se ha enviado un correo electrónico a la dirección proporcionada, con instrucciones para restablecer la contraseña';
		$strings['ActivationEmailSent'] = 'Pronto recibirás un correo de activación.';
		$strings['AccountActivationError'] = 'Lo siento, no hemos podido activar la cuenta.';
		$strings['Attachments'] = 'Adjuntos';
		$strings['AttachFile'] = 'Adjuntar archivo';
		$strings['Maximum'] = 'máximo';
		$strings['NoScheduleAdministratorLabel'] = 'No hay administrador de calendario';
		$strings['ScheduleAdministrator'] = 'Administrador de calendario';
		$strings['Total'] = 'Total';
		$strings['QuantityReserved'] = 'Cantidad Reservada';
		$strings['AllAccessories'] = 'Todos los accesorios';
		$strings['GetReport'] = 'Obtener informe';
		$strings['NoResultsFound'] = 'No hemos encontrado coincidencias';
		$strings['SaveThisReport'] = 'Guardar este informe';
		$strings['ReportSaved'] = '¡Informe guardado!';
		$strings['EmailReport'] = 'Enviar informe por correo';
		$strings['ReportSent'] = '¡Informe enviado!';
		$strings['RunReport'] = 'Generar informe';
		$strings['NoSavedReports'] = 'No has guardado el informe.';
		$strings['CurrentWeek'] = 'Semana actual';
		$strings['CurrentMonth'] = 'Mes actual';
		$strings['AllTime'] = 'Todo el tiempo';
		$strings['FilterBy'] = 'Filtrar por';
		$strings['Select'] = 'Seleccionar';
		$strings['List'] = 'Lista';
		$strings['TotalTime'] = 'Tiempo total';
		$strings['Count'] = 'Cuenta';
		$strings['Usage'] = 'Uso';
		$strings['AggregateBy'] = 'Agregar por';
		$strings['Range'] = 'Rango';
		$strings['Choose'] = 'Elegir';
		$strings['All'] = 'Todo';
		$strings['ViewAsChart'] = 'Ver como gráfico';
		$strings['ReservedResources'] = 'Recurso reservado';
		$strings['ReservedAccessories'] = 'Accesorio reservado';
		$strings['ResourceUsageTimeBooked'] = 'Uso de recurso - tiempo reservado';
		$strings['ResourceUsageReservationCount'] = 'Uso de recurso - número de reservas';
		$strings['Top20UsersTimeBooked'] = 'Top 20 - Tiempo reservado';
		$strings['Top20UsersReservationCount'] = 'Top 20 - Número de reservas';
		$strings['ConfigurationUpdated'] = 'Se actualizó el fichero de configuración';
		$strings['ConfigurationUiNotEnabled'] = 'No se puede acceder a esta página porque $conf[\'settings\'][\'pages\'][\'enable.configuration\'] está configurado a Falso.';
		$strings['ConfigurationFileNotWritable'] = 'El fichero de configuración no es editable. Por favor compruebe los permisos de este fichero e inténtelo de nuevo.';
		$strings['ConfigurationUpdateHelp'] = 'Vaya a la sección de Configuración del <a target=_blank href=%s>Archivo de ayuda</a> para documentación sobre estas opciones.';
		$strings['GeneralConfigSettings'] = 'opciones';
		$strings['UseSameLayoutForAllDays'] = 'Usar la misma distribución horaria para todos los días';
		$strings['LayoutVariesByDay'] = 'La distribución horaria varía por días';
		$strings['ManageReminders'] = 'Recordatorios';
		$strings['ReminderUser'] = 'ID de usuario';
		$strings['ReminderMessage'] = 'Mensaje';
		$strings['ReminderAddress'] = 'Direcciones';
		$strings['ReminderSendtime'] = 'Hora de envío';
		$strings['ReminderRefNumber'] = 'Número de referencia de la reserva';
		$strings['ReminderSendtimeDate'] = 'Fecha del recordatorio';
		$strings['ReminderSendtimeTime'] = 'Hora del recordatorio (HH:MM)';
		$strings['ReminderSendtimeAMPM'] = 'AM / PM';
		$strings['AddReminder'] = 'Agregar recordatorio';
		$strings['DeleteReminderWarning'] = '¿Estás seguro?';
		$strings['NoReminders'] = 'No tienes recordatorios próximos.';
		$strings['Reminders'] = 'Recordatorios';
		$strings['SendReminder'] = 'Enviar recordatorio';
		$strings['minutes'] = 'minutos';
		$strings['hours'] = 'horas';
		$strings['days'] = 'días';
		$strings['ReminderBeforeStart'] = 'antes de la hora de inicio';
		$strings['ReminderBeforeEnd'] = 'antes de la hora de finalización';
		$strings['Logo'] = 'Logo';
		$strings['CssFile'] = 'Archivo CSS';
		$strings['ThemeUploadSuccess'] = 'Se han guardado los cambios. Actualiza la página para hacer efectivos los cambios.';
		$strings['MakeDefaultSchedule'] = 'Hacer esta planificación mi planificación predeterminada';
		$strings['DefaultScheduleSet'] = 'Ahora ésta es tu planificación predeterminada';
		$strings['FlipSchedule'] = 'Girar la distribución de la planificación';
		$strings['Next'] = 'Siguiente';
		$strings['Success'] = 'Éxito';
		$strings['Participant'] = 'Participante';
		$strings['ResourceFilter'] = 'Filtro de recursos';
		$strings['ResourceGroups'] = 'Grupos de recursos';
		$strings['AddNewGroup'] = 'Agregar un nuevo grupo';
		$strings['Quit'] = 'Salir';
		$strings['AddGroup'] = 'Agregar grupo';
		$strings['StandardScheduleDisplay'] = 'Usar la vista de programación estándar';
		$strings['TallScheduleDisplay'] = 'Usar la vista de programación alargada';
		$strings['WideScheduleDisplay'] = 'Usar la vista de programación ancha';
		$strings['CondensedWeekScheduleDisplay'] = 'Usar la vista de programación de semana condensada';
		$strings['ResourceGroupHelp1'] = 'Arrastra los grupos de recursos a organizar.';
		$strings['ResourceGroupHelp2'] = 'Haz clic con el botón derecho sobre el nombre de un grupo de recursos para acciones adicionales.';
		$strings['ResourceGroupHelp3'] = 'Arrastra los recursos para agregarlos a los grupos.';
		$strings['ResourceGroupWarning'] = 'Si usas los grupos de recursos, cada recurso debe estar asignado al menos a un grupo. Los recursos no asignados no estarán disponibles para ser reservados.';
		$strings['ResourceType'] = 'Tipo de recurso';
		$strings['AppliesTo'] = 'Aplica a';
		$strings['UniquePerInstance'] = 'Único por instancia';
		$strings['AddResourceType'] = 'Agregar tipo de recurso';
		$strings['NoResourceTypeLabel'] = '(no está establecido el tipo de recurso)';
		$strings['ClearFilter'] = 'Limpiar filtro';
		$strings['MinimumCapacity'] = 'Capacidad mínima';
		$strings['Color'] = 'Color';
		$strings['Available'] = 'Disponible';
		$strings['Unavailable'] = 'No disponible';
		$strings['Hidden'] = 'Oculto';
		$strings['ResourceStatus'] = 'Estado del recurso';
		$strings['CurrentStatus'] = 'Estado actual';
		$strings['AllReservationResources'] = 'Todos los recursos de las reservas';
		$strings['File'] = 'Fichero';
		$strings['BulkResourceUpdate'] = 'Actualización masiva de recursos';
		$strings['Unchanged'] = 'Sin cambios';
		$strings['Common'] = 'Común';
		$strings['AdminOnly'] = 'Solo administradores';
		$strings['AdvancedFilter'] = 'Filtro avanzado';
		$strings['MinimumQuantity'] = 'Cantidad mínima';
		$strings['MaximumQuantity'] = 'Cantidad máxima';
		$strings['ChangeLanguage'] = 'Cambiar idioma';
		$strings['AddRule'] = 'Agregar regla';
		$strings['Attribute'] = 'Atributo';
		$strings['RequiredValue'] = 'Valor requerido';
		$strings['ReservationCustomRuleAdd'] = 'Si %s entonces la reserva será de color';
		$strings['AddReservationColorRule'] = 'Agregar regla de color de reserva';
		$strings['LimitAttributeScope'] = 'Recopilar en casos específicos';
		$strings['CollectFor'] = 'Recopilar para';
		$strings['SignIn'] = 'Iniciar sesión';
		$strings['AllParticipants'] = 'Todos los participantes';
		$strings['RegisterANewAccount'] = 'Registrar una nueva cuenta';
		$strings['Dates'] = 'Fechas';
		$strings['More'] = 'Más';
		$strings['ResourceAvailability'] = 'Disponibilidad del recurso';
		$strings['UnavailableAllDay'] = 'No disponible en todo el día';
		$strings['AvailableUntil'] = 'Disponible hasta las';
		$strings['AvailableBeginningAt'] = 'Disponible desde las';
		$strings['AllResourceTypes'] = 'Todos los tipos de recursos';
		$strings['AllResourceStatuses'] = 'Todos los estados de los recursos';
		$strings['AllowParticipantsToJoin'] = 'Permitir a los participantes unirse';
		$strings['Join'] = 'Unirse';
		$strings['YouAreAParticipant'] = 'Participas en esta reserva';
		$strings['YouAreInvited'] = 'Estás invitado a esta reserva';
		$strings['YouCanJoinThisReservation'] = 'Puedes unirte a esta reserva';
		$strings['Import'] = 'Importar';
		$strings['GetTemplate'] = 'Obtener plantilla';
		$strings['UserImportInstructions'] = 'El archivo debe estar en formato CSV. El nombre de usuario y el correo son campos obligatorios. Dejar otros campos en blanco establecerá valores predeterminados y \'password\' como la contraseña del usuario. Usa la plantilla proporcionada como ejemplo.';
		$strings['RowsImported'] = 'Filas importadas';
		$strings['RowsSkipped'] = 'Columnas omitidas';
		$strings['Columns'] = 'Columnas';
		$strings['Reserve'] = 'Reservar';
		$strings['AllDay'] = 'Todo el día';
		$strings['Everyday'] = 'Todos los días';
		$strings['IncludingCompletedReservations'] = 'Incluyendo las reservas completadas';
		$strings['NotCountingCompletedReservations'] = 'Sin incluir las reservas completadas';
		$strings['RetrySkipConflicts'] = 'Omitir las reservas que entran en conflicto';
		$strings['Retry'] = 'Reintentar';
		$strings['RemoveExistingPermissions'] = '¿Eliminar los permisos existentes?';
		$strings['Continue'] = 'Continuar';
		$strings['WeNeedYourEmailAddress'] = 'Necesitamos el correo electrónico para reservar';
		$strings['ResourceColor'] = 'Color del recurso';
		$strings['DateTime'] = 'Fecha Hora';
		$strings['AutoReleaseNotification'] = 'Automáticamente liberado si no se hace «check in» en %s minutos';
		$strings['RequiresCheckInNotification'] = 'Requiere «check in»/«check out»';
		$strings['NoCheckInRequiredNotification'] = 'No requiere «check in»/«check out»';
		$strings['RequiresApproval'] = 'Requiere aprobación';
		$strings['CheckingIn'] = 'Haciendo «check in»';
		$strings['CheckingOut'] = 'Haciendo «check out»';
		$strings['CheckIn'] = '«Check in»';
		$strings['CheckOut'] = '«Check out»';
		$strings['ReleasedIn'] = 'Liberado en ';
		$strings['CheckedInSuccess'] = '«Check in» realizado';
		$strings['CheckedOutSuccess'] = '«Check out» realizado';
		$strings['CheckInFailed'] = 'No se pudo hacer el «check in»';
		$strings['CheckOutFailed'] = 'No se pudo hacer el «check out»';
		$strings['CheckInTime'] = 'Hora de «check in»';
		$strings['CheckOutTime'] = 'Hora de «check out»';
		$strings['OriginalEndDate'] = 'Finalización original';
		$strings['SpecificDates'] = 'Mostrar fechas específicas';
		$strings['Users'] = 'Usuarios';
		$strings['Guest'] = 'Invitado';
		$strings['ResourceDisplayPrompt'] = 'Recurso a mostrar';
		$strings['Credits'] = 'Créditos';
		$strings['AvailableCredits'] = 'Créditos disponibles';
		$strings['CreditUsagePerSlot'] = 'Requiere %s créditos por por intervalo (valle)';
		$strings['PeakCreditUsagePerSlot'] = 'Requiere %s créditos por intervalo (pico)';
		$strings['CreditsRule'] = 'No tienes crédito suficiente. Créditos necesarios: %s. Créditos en cuenta: %s';
		$strings['PeakTimes'] = 'Horas pico';
		$strings['AllYear'] = 'Todo el año';
		$strings['MoreOptions'] = 'Más opciones';
		$strings['SendAsEmail'] = 'Enviar por correo';
		$strings['UsersInGroups'] = 'Usuarios en grupos';
		$strings['UsersWithAccessToResources'] = 'Usuarios con acceso a recursos';
		$strings['AnnouncementSubject'] = '%s ha publicado un nuevo anuncio';
		$strings['AnnouncementEmailNotice'] = 'los usuarios recibirán este anuncio por correo';
		// End Strings

		// Install
		$strings['InstallApplication'] = 'Instalar Booked Scheduler (solo MySQL)';
		$strings['IncorrectInstallPassword'] = 'Lo siento, la contraseña no es correcta.';
		$strings['SetInstallPassword'] = 'Debes establecer una contraseña de instalación antes de iniciar la instalación.';
		$strings['InstallPasswordInstructions'] = 'En %s por favor establece %s a una contraseña aleatoria y difícil de adivinar, entonces vuelve a esta página.<br/>Puedes usar %s';
		$strings['NoUpgradeNeeded'] = 'No es necesaria una actualización. ¡Ejecutar el proceso de instalación borrará todos los datos existentes e instalará una copia nueva de Booked Scheduler!';
		$strings['ProvideInstallPassword'] = 'Por favor proporciona la contraseña de instalación.';
		$strings['InstallPasswordLocation'] = 'Puede encontrarse en %s en %s.';
		$strings['VerifyInstallSettings'] = 'Verifica las siguientes opciones predeterminadas antes de continuar. O puedes cambiarlas en %s.';
		$strings['DatabaseName'] = 'Nombre de la base de datos';
		$strings['DatabaseUser'] = 'Usuario de la base de datos';
		$strings['DatabaseHost'] = 'Servidor de la base de datos';
		$strings['DatabaseCredentials'] = 'Debes proporcionar credenciales de un usuario de MySQL que tenga privilegios para crear bases de datos. Si no sabes cuá, contacta con el administrador de bases de datos. Em muchos casos, «root» funcionará.';
		$strings['MySQLUser'] = 'Usuario de MySQL';
		$strings['InstallOptionsWarning'] = 'Las siguientes opciones probablemente no funcionen en un entorno alojado. Si estás instalando en un entorno alojado, usa las herramientas de asistencia de MySQL para completar estos pasos.';
		$strings['CreateDatabase'] = 'Crear la base de datos';
		$strings['CreateDatabaseUser'] = 'Crear el usuario de la base de datos';
		$strings['PopulateExampleData'] = 'Importar datos de ejemplo. Crea la cuenta de administrador: admin/password y la cuenta de usuario: user/password';
		$strings['DataWipeWarning'] = 'Aviso: esto borrará los datos existentes';
		$strings['RunInstallation'] = 'Ejecutar la instalación';
		$strings['UpgradeNotice'] = 'Estás actualizando desde la versión <b>%s</b> a la versión <b>%s</b>';
		$strings['RunUpgrade'] = 'Ejecutar actualización';
		$strings['Executing'] = 'Ejecutando';
		$strings['StatementFailed'] = 'Error. Detalles:';
		$strings['SQLStatement'] = 'Sentencia SQL:';
		$strings['ErrorCode'] = 'Código de error:';
		$strings['ErrorText'] = 'Texto del error:';
		$strings['InstallationSuccess'] = '¡La instalación se ha completado correctamente!';
		$strings['RegisterAdminUser'] = 'Registra tu usuario administrador. Esto es necesario si no importaste los datos de ejemplo. Asegúrate de que  $conf[\'settings\'][\'allow.self.registration\'] = \'true\' en el archivo %s.';
		$strings['LoginWithSampleAccounts'] = 'Si importaste los datos de ejemplo, puedes iniciar sesión con admin/password para usuario administrador o user/password para usuario básico.';
		$strings['InstalledVersion'] = 'Ahora estás ejecutando la versión %s de Booked Scheduler';
		$strings['InstallUpgradeConfig'] = 'Se recomienda actualizar el archivo de configuración';
		$strings['InstallationFailure'] = 'Hubo problemas con la instalación. Por favor, corrígelos y reintenta la instalación.';
		$strings['ConfigureApplication'] = 'Configurar Booked Scheduler';
		$strings['ConfigUpdateSuccess'] = '¡El archivo de configuración se ha actualizado!';
		$strings['ConfigUpdateFailure'] = 'No pudimos actualizar automáticamente el archivo de configuración. Por favor sobreescribe el contenido de config.php con lo siguiente:';
		$strings['SelectUser'] = 'Seleccionar usuario';
		// End Install


		// Errors
		$strings['LoginError'] = 'No se ha encontrado una correspondencia para tu Nombre de Usuario (Identificador) y contraseña';
		$strings['ReservationFailed'] = 'Tu reserva no se ha podido realizar';
		$strings['MinNoticeError'] = 'Esta reserva se debe realizar por anticipado.  La fecha más temprana que puede ser reservada %s.';
		$strings['MaxNoticeError'] = 'Esta reserva no se puede alargar tan lejos en el futuro. La última fecha en la que se puede reservar es %s.';
		$strings['MinDurationError'] = 'Esta reserva debe durar al menos %s.';
		$strings['MaxDurationError'] = 'Esta reserva no puede durar más de %s.';
		$strings['ConflictingAccessoryDates'] = 'No hay suficientes de los siguientes accesorios:';
		$strings['NoResourcePermission'] = 'No tienes permisos para acceder uno o más de los recursos requeridos';
		$strings['ConflictingReservationDates'] = 'Hay conflictos en las reservas de las siguientes fechas:';
		$strings['StartDateBeforeEndDateRule'] = 'La fecha de inicio debe ser anterior a la fecha final';
		$strings['StartIsInPast'] = 'La fecha inicial no puede ser pasada';
		$strings['EmailDisabled'] = 'El administrador ha desactivado las notificaciones por correo';
		$strings['ValidLayoutRequired'] = 'Se deben proporcionar intervalos de tiempo para las 24 horas del día comenzando y terminando a las 12:00 AM.';
		$strings['CustomAttributeErrors'] = 'Hay problemas con los atributos adicionales que proporcionaste:';
		$strings['CustomAttributeRequired'] = '%s es un campo requerido.';
		$strings['CustomAttributeInvalid'] = 'El valor proporcionado para %s no es válido.';
		$strings['AttachmentLoadingError'] = 'Lo siento, hubo un problema con el fichero solicitado.';
		$strings['InvalidAttachmentExtension'] = 'Solamente puedes subir ficheros de tipo: %s';
		$strings['InvalidStartSlot'] = 'La fecha y hora de comienzo solicitada no es válida.';
		$strings['InvalidEndSlot'] = 'La fecha y hora de finalización solicitada no es válido.';
		$strings['MaxParticipantsError'] = '%s puede soportar %s participantes solamente.';
		$strings['ReservationCriticalError'] = 'Hubo un error crítico guardando tu reserva. Si continúa, contacta con el administrador del sistema.';
		$strings['InvalidStartReminderTime'] = 'La hora de comienzo del recordatorio no es válida.';
		$strings['InvalidEndReminderTime'] = 'La hora de finalización del recordatorio no es válida.';
		$strings['QuotaExceeded'] = 'Límite de cuota excedido.';
		$strings['MultiDayRule'] = '%s no permite reservar a través de días.';
		$strings['InvalidReservationData'] = 'Hubo problemas con tu solicitud de reserva.';
		$strings['PasswordError'] = 'La contraseña debe contener al menos %s letras y al menos %s números.';
		$strings['PasswordErrorRequirements'] = 'La contraseña debe contener una combinación de al menos %s letras mayúsculas y minúsculas y %s números.';
		$strings['NoReservationAccess'] = 'No tienes permisos para cambiar esta reserva.';
		$strings['PasswordControlledExternallyError'] = 'La contraseña se controla con un sistema externo y no se puede actualizar desde aquí.';
		$strings['AccessoryResourceRequiredErrorMessage'] = 'El accesorio %s solamente puede reservarse con los recursos %s';
		$strings['AccessoryMinQuantityErrorMessage'] = 'Debes reservar al menos %s del accesorio %s';
		$strings['AccessoryMaxQuantityErrorMessage'] = 'No puedes reservar más de %s del accesorio %s';
		$strings['AccessoryResourceAssociationErrorMessage'] = 'El accesorio \'%s\' no puede reservarse con los recursos solicitados';
		$strings['NoResources'] = 'No has agregado ningún recurso.';
		$strings['ParticipationNotAllowed'] = 'No tienes permiso para unirte a esta reserva.';
		$strings['ReservationCannotBeCheckedInTo'] = 'No se puede hacer «check in» en esta reserva.';
		$strings['ReservationCannotBeCheckedOutFrom'] = 'No se puede hacer «check out» en esta reserva.';

		// End Errors

		// Page Titles
		$strings['CreateReservation'] = 'Crear reserva';
		$strings['EditReservation'] = 'Editar reserva';
		$strings['LogIn'] = 'Iniciar sesión';
		$strings['ManageReservations'] = 'Gestionar reservas';
		$strings['AwaitingActivation'] = 'Esperando activación';
		$strings['PendingApproval'] = 'Pendiente de aprobación';
		$strings['ManageSchedules'] = 'Planificaciones';
		$strings['ManageResources'] = 'Recursos';
		$strings['ManageAccessories'] = 'Accesorios';
		$strings['ManageUsers'] = 'Usuarios';
		$strings['ManageGroups'] = 'Grupos';
		$strings['ManageQuotas'] = 'Cuotas';
		$strings['ManageBlackouts'] = 'Agenda de no disponibilidad';
		$strings['MyDashboard'] = 'Mi tablón';
		$strings['ServerSettings'] = 'Ajustes de servidor';
		$strings['Dashboard'] = 'Tablón';
		$strings['Help'] = 'Ayuda';
		$strings['Administration'] = 'Administración';
		$strings['About'] = 'Acerca de';
		$strings['Bookings'] = 'Reservas';
		$strings['Schedule'] = 'Planificación';
		$strings['Reservations'] = 'Reservas';
		$strings['Account'] = 'Cuenta';
		$strings['EditProfile'] = 'Editar mi perfil';
		$strings['FindAnOpening'] = 'Encontrar un hueco';
		$strings['OpenInvitations'] = 'Invitaciones pendientes';
		$strings['MyCalendar'] = 'Mi calendario';
		$strings['ResourceCalendar'] = 'Calendario de recursos';
		$strings['Reservation'] = 'Nueva reserva';
		$strings['Install'] = 'Instalación';
		$strings['ChangePassword'] = 'Cambiar contraseña';
		$strings['MyAccount'] = 'Mi cuenta';
		$strings['Profile'] = 'Perfil';
		$strings['ApplicationManagement'] = 'Gestión de la aplicación';
		$strings['ForgotPassword'] = 'Contraseña olvidada';
		$strings['NotificationPreferences'] = 'Preferencias de notificación';
		$strings['ManageAnnouncements'] = 'Anuncios';
		$strings['Responsibilities'] = 'Responsabilidades';
		$strings['GroupReservations'] = 'Reservas del grupo';
		$strings['ResourceReservations'] = 'Reservas de recursos';
		$strings['Customization'] = 'Personalización';
		$strings['Attributes'] = 'Atributos';
		$strings['AccountActivation'] = 'Activación de cuenta';
		$strings['ScheduleReservations'] = 'Programar reservas';
		$strings['Reports'] = 'Informes';
		$strings['GenerateReport'] = 'Crear nuevo informe';
		$strings['MySavedReports'] = 'Mis informes guardados';
		$strings['CommonReports'] = 'Informes comunes';
		$strings['ViewDay'] = 'Ver día';
		$strings['Group'] = 'Grupo';
		$strings['ManageConfiguration'] = 'Configuración de la aplicación';
		$strings['LookAndFeel'] = 'Apariencia';
		$strings['ManageResourceGroups'] = 'Grupos de recursos';
		$strings['ManageResourceTypes'] = 'Tipos de recursos';
		$strings['ManageResourceStatus'] = 'Estados de recursos';
		$strings['ReservationColors'] = 'Colores de las reservas';
		// End Page Titles

		// Day representations
		$strings['DaySundaySingle'] = 'D';
		$strings['DayMondaySingle'] = 'L';
		$strings['DayTuesdaySingle'] = 'M';
		$strings['DayWednesdaySingle'] = 'X';
		$strings['DayThursdaySingle'] = 'J';
		$strings['DayFridaySingle'] = 'V';
		$strings['DaySaturdaySingle'] = 'S';

		$strings['DaySundayAbbr'] = 'Dom';
		$strings['DayMondayAbbr'] = 'Lun';
		$strings['DayTuesdayAbbr'] = 'Mar';
		$strings['DayWednesdayAbbr'] = 'Mié';
		$strings['DayThursdayAbbr'] = 'Jue';
		$strings['DayFridayAbbr'] = 'Vie';
		$strings['DaySaturdayAbbr'] = 'Sáb';
		// End Day representations

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'Se ha aprobado tu reserva';
		$strings['ReservationCreatedSubject'] = 'Se ha creado tu reserva';
		$strings['ReservationUpdatedSubject'] = 'Se ha actualizado tu reserva';
		$strings['ReservationDeletedSubject'] = 'Se ha eliminado tu reserva';
		$strings['ReservationCreatedAdminSubject'] = 'Notificación: se ha creado una reserva';
		$strings['ReservationUpdatedAdminSubject'] = 'Notificación: se ha actualizado una reserva';
		$strings['ReservationDeleteAdminSubject'] = 'Notificación: se ha eliminado una reserva';
		$strings['ReservationApprovalAdminSubject'] = 'Notificación: una reserva necesita aprobación';
		$strings['ParticipantAddedSubject'] = 'Notificación de participación en reserva';
		$strings['ParticipantDeletedSubject'] = 'Eliminación de participación en reserva';
		$strings['InviteeAddedSubject'] = 'Invitación a reserva';
		$strings['ResetPassword'] = 'Petición de reinicio de contraseña';
		$strings['ActivateYourAccount'] = 'Por favor, activa tu cuenta';
		$strings['ReportSubject'] = 'El informe solicitado (%s)';
		$strings['ReservationStartingSoonSubject'] = 'La reserva de %s comienza pronto';
		$strings['ReservationEndingSoonSubject'] = 'La reserva de %s finaliza pronto';
		$strings['UserAdded'] = 'Se ha agregado un nuevo usuario';
		$strings['UserDeleted'] = 'La cuenta de usuario de %s fue borrada por %s';
		$strings['GuestAccountCreatedSubject'] = 'Detalles de la cuenta';
		// End Email Subjects
		
				
		$this->Strings = $strings;
    }

    protected function _LoadDays()
    {
		$days = parent::_LoadDays();

		/***
		DAY NAMES
		All of these arrays MUST start with Sunday as the first element
		and go through the seven day week, ending on Saturday
		 ***/
		// The full day name
		$days['full'] = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
		// The three letter abbreviation
		$days['abbr'] = array('Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb');
		// The two letter abbreviation
		$days['two'] = array('Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa');
		// The one letter abbreviation
		$days['letter'] = array('D', 'L', 'M', 'X', 'J', 'V', 'S');

		$this->Days = $days;
    }

    protected function _LoadMonths()
    {
		$months = parent::_LoadMonths();

		/***
		MONTH NAMES
		All of these arrays MUST start with January as the first element
		and go through the twelve months of the year, ending on December
		 ***/
		// The full month name
		$months['full'] = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		// The three letter month name
		$months['abbr'] = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');

		$this->Months = $months;
    }

    protected function _LoadLetters()
    {
		$this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    protected function _GetHtmlLangCode()
    {
		return 'es';
    }
}

