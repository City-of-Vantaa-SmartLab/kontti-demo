{include file='globalheader.tpl' Select2=true}


<div class="page-search-availability">

    <form role="form" name="searchForm" id="searchForm" method="post"
          action="{$smarty.server.SCRIPT_NAME}?action=search">
        <div class="form-group col-xs-12 col-sm-3">
            <div class="checkbox">
                <input type="checkbox" id="anyResource" checked="checked"/>
                <label for="anyResource">{translate key=AnyResource}</label>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-9">
            <label for="resourceGroups" class="no-show">{translate key=Resources}</label>
            <select id="resourceGroups" class="form-control" multiple="multiple" {formname key=RESOURCE_ID multi=true}
                    disabled="disabled">
                {foreach from=$Resources item=resource}
                    <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                {/foreach}
            </select>
        </div>

        <div class="clearfix"></div>

        <div class="form-group col-xs-12 col-sm-3">
            <div class="input-group margin-bottom-15">
                <input type="number" min="0" step="1" value="0" class="form-control hours-minutes"
                       id="hours" {formname key=HOURS}" />
                <span class="input-group-addon hours-minutes">{translate key=Hours}</span>
            </div>
            <div class="input-group">
                <input type="number" min="0" step="30" value="30" class="form-control hours-minutes"
                       id="minutes" {formname key=MINUTES}"/>
                <span class="input-group-addon hours-minutes">{translate key=Minutes}</span>
            </div>
        </div>

        <div class="form-group col-xs-12 col-sm-9">
            <div class="btn-group margin-bottom-15" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input type="radio" id="today" checked="checked"
                           value="today" {formname key=AVAILABILITY_RANGE} />
                    <span class="hidden-xs">{translate key=Today},</span>
                    <span> {format_date date=$Today key=calendar_dates}</span>
                </label>
                <label class="btn btn-default">
                    <input type="radio" id="tomorrow" value="tomorrow" {formname key=AVAILABILITY_RANGE} />
                    <span class="hidden-xs">{translate key=Tomorrow},</span>
                    <span> {format_date date=$Tomorrow key=calendar_dates}</span>
                </label>
                <label class="btn btn-default">
                    <input type="radio" id="thisweek" value="thisweek" {formname key=AVAILABILITY_RANGE} />
                    <span class="hidden-xs">{translate key=ThisWeek}</span>
                    <span class="visible-xs">{translate key=Week}</span>
                </label>
                <label class="btn btn-default">
                    <input type="radio" id="daterange" value="daterange" {formname key=AVAILABILITY_RANGE} />
                    <i class="fa fa-calendar"></i><span class="hidden-xs"> {translate key=DateRange}</span>
                </label>
            </div>
            <div class="">
                <input type="text" id="beginDate" class="form-control inline dateinput"
                       placeholder="{translate key=BeginDate}" disabled="disabled"/>
                <input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE} />
                -
                <input type="text" id="endDate" class="form-control inline dateinput"
                       placeholder="{translate key=EndDate}" disabled="disabled"/>
                <input type="hidden" id="formattedEndDate" {formname key=END_DATE} />
                <a href="#" data-toggle="collapse" data-target="#advancedSearchOptions">{translate key=MoreOptions}</a>
            </div>
            <div class="clearfix"></div>

        </div>

        <div class="clearfix"></div>

        <div class="collapse" id="advancedSearchOptions">
            <div class="form-group col-xs-6">
                <label for="maxCapacity" class="hidden">{translate key=MinimumCapacity}</label>
                <input type='number' id='maxCapacity' min='0' size='5' maxlength='5'
                       class="form-control input-sm" {formname key=MAX_PARTICIPANTS}
                       value="{$MaxParticipantsFilter}" placeholder="{translate key=MinimumCapacity}"/>

            </div>
            <div class="form-group col-xs-6">
                <label for="resourceType" class="hidden">{translate key=ResourceType}</label>
                <select id="resourceType" {formname key=RESOURCE_TYPE_ID} {formname key=RESOURCE_TYPE_ID}
                        class="form-control input-sm">
                    <option value="">- {translate key=ResourceType} -</option>
                    {object_html_options options=$ResourceTypes label='Name' key='Id' selected=$ResourceTypeIdFilter}
                </select>
            </div>

            <div>
                {foreach from=$ResourceAttributes item=attribute}
                    {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='r' class="col-sm-6 col-xs-12" inputClass="input-sm"}
                {/foreach}
                {if $ResourceAttributes|count%2 != 0}
                    <div class="col-sm-6 hidden-xs">&nbsp;</div>
                {/if}
            </div>

            <div>
                {foreach from=$ResourceTypeAttributes item=attribute}
                    {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='rt' class="col-sm-6 col-xs-12" inputClass="input-sm"}
                {/foreach}
                {if $ResourceTypeAttributes|count%2 != 0}
                    <div class="col-sm-6 hidden-xs">&nbsp;</div>
                {/if}
            </div>
        </div>

        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-success col-xs-12"
                    value="submit" {formname key=SUBMIT}>{translate key=FindATime}</button>
            {indicator}
        </div>
    </form>

    <div class="clearfix"></div>
    <div id="availability-results"></div>


    {csrf_token}


    {jsfile src="js/tree.jquery.js"}
    {jsfile src="js/jquery.cookie.js"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="availability-search.js"}
    {jsfile src="resourcePopup.js"}

    {control type="DatePickerSetupControl" ControlId="beginDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
    {control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate" DefaultDate=$StartDate}

    <script type="text/javascript">

        $(document).ready(function () {
            var opts = {
                reservationUrlTemplate: "{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}=[rid]&{QueryStringKeys::START_DATE}=[sd]&{QueryStringKeys::END_DATE}=[ed]"
            };
            var search = new AvailabilitySearch(opts);
            search.init();

            $('#resourceGroups').select2({
                placeholder: '{translate key=Resources}'
            });
        });


    </script>

</div>

{include file='globalfooter.tpl'}
