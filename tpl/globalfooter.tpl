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

	</div><!-- close main-->

	<footer class="footer navbar">	
		<div class="partnercontainer">
			<div class="partnerlogo">
				<img src="{$Path}partners/vantaa.png" alt="Vantaa" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/smartlab.png" alt="Smartlab" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/metropolia.png" alt="Metropolia AMK" class="partnerlogo">
			</div>
		</div>
		
		<div class="partnercontainer">
			<div class="partnerlogoBig">
				<img src="{$Path}partners/digitalist.png" alt="Digitalist" class="partnerlogoBig">
			</div>
		</div>
		<div class="partnercontainer">
			<div class="partnerlogo">
				<img src="{$Path}partners/ibm.png" alt="IBM" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/watson.png" alt="Watson" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/tikkuri.png" alt="Tikkuri" class="partnerlogo">
			</div>
		</div>
		<div class="partnercontainer">
			<div class="partnerlogo">
				<img src="{$Path}partners/genelec.png" alt="Genelec" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/tampereen-yliopisto.png" alt="Tampereen Yliopisto" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/murmur.png" alt="Murmur" class="partnerlogo">
			</div>
		</div>
		<div class="partnercontainer">
			<div class="partnerlogo">
				<img src="{$Path}partners/barco.png" alt="Barco" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/lyreco.png" alt="Lyreco" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/clickshare.png" alt="Clickshare" class="partnerlogo">
			</div>
		</div>
		<div class="partnercontainer">
			<div class="partnerlogo">
				<img src="{$Path}partners/art4u-fi.png" alt="Art4u.fi" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/lg.png" alt="LG" class="partnerlogo">
			</div>
			<div class="partnerlogo">
				<img src="{$Path}partners/tkp-print.png" alt="TKP-print" class="partnerlogo">
			</div>
		</div>
		<div class="footerCopyrightContainer">
			<div class="footercopyright">
				<p class="footercopyright">&copy; 2017 <a href="http://smartlabvantaa.fi/">Smartlab</a>, <a href="https://github.com/City-of-Vantaa-SmartLab/kontti-demo">Muuntamo v0.3</a></p>
			</div>
			<div class="footercopyright">
				<p class="footercopyright">&copy; 2017 <a href="http://www.twinkletoessoftware.com">Twinkle Toes Software</a>, <a href="http://www.bookedscheduler.com">Booked Scheduler v{$Version}</a></p>
			</div>
		</div>
	</footer>

	<script type="text/javascript">
		init();
		$.blockUI.defaults.css.border = 'none';
		$.blockUI.defaults.css.top = '25%';
	</script>

	{if !empty($GoogleAnalyticsTrackingId)}
		{literal}
			<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  {/literal}
			  ga('create', '{$GoogleAnalyticsTrackingId}', 'auto');
			  ga('send', 'pageview');
			</script>
	{/if}
	</body>
</html>