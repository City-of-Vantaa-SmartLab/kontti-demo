{*
This file is part of Muuntamo.

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
{include file='globalheader.tpl'}

<div class="col-md-offset-3 col-md-6 col-xs-12 ">
	<div id="info-header" class="default-box-header">
		<span>{translate key='AboutFrontTitle'}</span>
	</div>
	<div class="col-xs-12 default-box straight-top">
		<p>{translate key='AboutFrontText'}</p>
	</div>
</div>

{setfocus key='EMAIL'}

<script type="text/javascript">
	var url = 'index.php?{QueryStringKeys::LANGUAGE}=';
	$(document).ready(function () {
		$('#languageDropDown').change(function () {
			window.location.href = url + $(this).val();
		});

		var langCode = readCookie('{CookieKeys::LANGUAGE}');

		if (!langCode)
		{
		}
	});
</script>
{include file='globalfooter.tpl'}