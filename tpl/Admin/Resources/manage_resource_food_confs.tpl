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
		<h1>{translate key='ManageResourceFoodConfsTitle'}</h1>	
		<div>
			<div class="control-group form-group resourceConfBoxAddLeft">
				<h5>{translate key='AddResourceFoodConfiguration'}</h5>
				<form id='resourcefoodconfForm' role='form' method='POST' action='resourceFoodConf/add_resourcefoodconf.php'>
					<div class='resourceConfLeftBoxAdd'>{translate key='Name'}:</div><div class='resourceConfRightBoxAdd'><input type='text' name='resourceFoodConfName'></div><br/>
					<div class='resourceConfLeftBoxAdd'>{translate key='Description'}:</div><div class='resourceConfRightBoxAdd'><textarea rows='8' cols='2' name='resourceFoodConfDesc'></textarea></div><br/>
					<div class='resourceConfLeftBoxAdd'>{translate key='Price'}:</div><div class='resourceConfRightBoxAdd'><input type="number" min="0" max="30000" step="0.01" name='resourceFoodConfPrice'></textarea></div><br/>
					<div class='resourceConfLeftBoxAdd'>{translate key='contentlist'}:</div><div class='resourceConfRightBoxAdd'><textarea rows='8' cols='2' name='resourceFoodConfContentlist'></textarea></div><br/>
					<div class='resourceConfBoxAddSend'><input type='submit' value='{translate key='Add'}'></div>
				</form>
			</div>
			<div class="control-group form-group resourceConfBoxAdd">
				<h5>{translate key='ManageResourceFoodConfsTitle'}</h5>
				<div class="resourceConfBoxAdd"> 
					{foreach from=$ResourceFoodConfs item=Conf}
						<div class="resourceConfBoxAdd"> 
							<a href='#{$Conf['foodconf_id']}-confbox' role='button' data-toggle='collapse'>{$Conf['foodconf_id']}.{$Conf['name']}</a> {$Conf['price']} €
							<div>
								<div id='{$Conf['foodconf_id']}-confbox' class='collapse'>
									<div class="resourceConfBoxAdd"><img src='../../uploads/foodarrangements/{$Conf['foodconf_id']}.png' alt='{$Conf['name']}' class='resourceConfBoxAdd'></div>
									<div class="resourceConfBoxAdd">
										<form action='resourceFoodConf/update_resourcefoodconf.php' method='POST'>
											<input type='hidden' name='foodconf_id' value='{$Conf['foodconf_id']}'>
											<div class='resourceConfLeftBoxAdd'>{translate key='Name'}: 		</div>	<div class='resourceConfRightBoxAdd'><input type='text' name='name' value='{$Conf['name']}'></div><br/>
											<div class='resourceConfLeftBoxAdd'>{translate key='Description'}: 	</div>	<div class='resourceConfBoxUpdate'><textarea rows='4' cols='50' name='description'>{$Conf['description']}</textarea></div><br/>
											<div class='resourceConfLeftBoxAdd'>{translate key='Price'}: 		</div>	<div class='resourceConfBoxUpdate'><input type="number" min="0" max="30000" step="0.01" name='price' value={$Conf['price']}></div><br/>
											<div class='resourceConfLeftBoxAdd'>{translate key='contentlist'}: 		</div>	<div class='resourceConfBoxUpdate'><textarea rows='4' cols='50' name='contentlist'>{$Conf['contentlist']}</textarea></div>
											<br/><input type='submit' value='{translate key='Edit'}'><br/>
											{translate key='ResourceFoodConfInResources'}:
											{foreach from=$ConfResources item=ResourceTarget}
												{if $ResourceTarget['foodconf_id'] == $Conf['foodconf_id']}
													{$ResourceTarget['resource_id']}
												{/if}
											{/foreach}
										</form>
										<form action='resourceConf/remove_resourceconf.php' method='POST'>
											<input type='hidden' value='{$Conf['foodconf_id']}' name='resourceconfId'>
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