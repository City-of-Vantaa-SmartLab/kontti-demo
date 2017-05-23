{*
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler.
This file has been modified for Muuntamo.

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

<div id='page-manage-resource-confs' class='admin-page'>
	<div>
		<h1>{translate key='ManageResourceConfsTitle'}</h1>	
		<div>
			<div class="control-group form-group resourceConfBoxAddLeft">
				<h5>{translate key='AddResourceConfiguration'}</h5>
				<form id='resourceconfForm' role='form' method='POST' action='resourceConf/add_resourceconf.php'>
					<div class='resourceConfLeftBoxAdd'>{translate key='Name'}:</div><div class='resourceConfRightBoxAdd'><input type='text' name='resourceConfName'></div><br/>
					<div class='resourceConfLeftBoxAdd'>{translate key='Description'}:</div><div class='resourceConfRightBoxAdd'><textarea rows='8' cols='2' name='resourceConfDesc'></textarea></div><br/>
					<div class='resourceConfLeftBoxAdd'>{translate key='Price'}:</div><div class='resourceConfRightBoxAdd'><input type="number" min="0" max="30000" step="0.01" name='resourceConfPrice'></textarea></div><br/>
					<div class='resourceConfLeftBoxAdd'>{translate key='Furni'}:</div><div class='resourceConfRightBoxAdd'><textarea rows='8' cols='2' name='resourceConfFurni'></textarea></div><br/>
					<div class='resourceConfBoxAddSend'><input type='submit' value='{translate key='Add'}'></div>
				</form>
			</div>
			<div class="control-group form-group resourceConfBoxAdd">
				<h5>{translate key='ManageResourceConfsTitle'}</h5>
				<div class="resourceConfBoxAdd"> 
					{foreach from=$ResourceConfs item=Conf}
						<div class="resourceConfBoxAdd"> 
							<a href='#{$Conf['conf_id']}-confbox' role='button' data-toggle='collapse'>{$Conf['conf_id']}.{$Conf['name']}</a> {$Conf['price']} €
							<div>
								<div id='{$Conf['conf_id']}-confbox' class='collapse'>
									<div class="resourceConfBoxAdd"><img src='../../uploads/arrangements/{$Conf['conf_id']}.png' alt='{$Conf['name']}' class='resourceConfBoxAdd'></div>
									<div class="resourceConfBoxAdd">
										<form action='resourceConf/update_resourceconf.php' method='POST'>
											<input type='hidden' name='conf_id' value='{$Conf['conf_id']}'>
											<div class='resourceConfLeftBoxAdd'>{translate key='Name'}: 		</div>	<div class='resourceConfRightBoxAdd'><input type='text' name='name' value='{$Conf['name']}'></div><br/>
											<div class='resourceConfLeftBoxAdd'>{translate key='Description'}: 	</div>	<div class='resourceConfBoxUpdate'><textarea rows='4' cols='50' name='description'>{$Conf['description']}</textarea></div><br/>
											<div class='resourceConfLeftBoxAdd'>{translate key='Price'}: 		</div>	<div class='resourceConfBoxUpdate'><input type="number" min="0" max="30000" step="0.01" name='price' value={$Conf['price']}></div><br/>
											<div class='resourceConfLeftBoxAdd'>{translate key='Furni'}: 		</div>	<div class='resourceConfBoxUpdate'><textarea rows='4' cols='50' name='furni'>{$Conf['furniturelist']}</textarea></div>
											<br/><input type='submit' value='{translate key='Edit'}'><br/>
											{translate key='ResourceConfInResources'}:
											{foreach from=$ConfResources item=ResourceTarget}
												{if $ResourceTarget['conf_id'] == $Conf['conf_id']}
													{$ResourceTarget['resource_id']}
												{/if}
											{/foreach}
										</form>
										<form action='resourceConf/remove_resourceconf.php' method='POST'>
											<input type='hidden' value='{$Conf['conf_id']}' name='resourceconfId'>
											<input type='submit' value='{translate key="Delete"}'>
										</form>
									</div>
								</div>
							</div>
						</div><br/>
					{/foreach}
				</div>
			</div>
		</div>
	</div>
</div>

{include file='globalfooter.tpl'}