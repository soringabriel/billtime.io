@inject('projectModel', '\App\Models\Project')

<nav class="sticky-top navbar navbar-expand-md navbar-light bg-light text-dark shadow-sm" x-data="counterInit()" x-init="counterUpdateInterval()" id="counterMenu">
    <div class="container-fluid pt-2 pb-2 pl-3 pr-3">
        <span class="counter" x-text="counter"></span>
        <h6 class="d-md-block d-none">@lang('Track your time using the buttons on the right!')</h6>
        <div class="actions">
            <button class="btn btn-outline-danger" @click="cancelCounter()" x-show="showCancelButton()">
                <i class="fas fa-times mr-1"></i> @lang('Cancel')
            </button>
            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#saveTimeModal" x-show="showStopButton()">
                <i class="far fa-save mr-1"></i> @lang('Stop & Save')
            </button>
            <button class="btn btn-outline-dark" @click="startCounter()" x-show="showStartButton()">
                <i class="fas fa-play-circle mr-1"></i> @lang('Record Time')
            </button>
        </div>
    </div>
</nav>

<div class="modal fade" id="saveTimeModal" tabindex="-1" role="dialog" aria-labelledby="saveTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <x-forms.post id="counterAddTimeForm" :action="route('frontend.time.store')">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saveTimeModalLabel">@lang('Add Time')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="counterStartTime" name="start_time" />
                    <input type="hidden" id="counterEndTime" name="end_time" />

                    <div class="form-group row" x-data="{new_project: false}">
                        <label for="project_id" class="col-md-3 col-form-label">
                            <span class="required-field">@lang('Project')</span>
                            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The project you\'ve been working on') }}"></i>
                        </label>

                        <div class="col-md-9">
                            <select name="project_id" x-show="!new_project" class="form-control select2-project mb-2">
                                @foreach ($projectModel::where('organization_id', $logged_in_user->organization_id)->get() as $project) 
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'checked' : '' }}>{{ $project->name }}</option>    
                                @endforeach
                            </select>
                            <x-utils.link
                                icon="c-icon cil-plus"
                                class="card-header-action"
                                :href="route('frontend.projects.create')"
                                role="button"
                                href="javascript:void(0);"
                                :text="__('Add New Project')"
                                @click="new_project = !new_project"
                                permission="user.access.projects.create"
                                x-show="!new_project"
                            />
                            <x-utils.link
                                icon="c-icon cil-minus"
                                class="card-header-action"
                                role="button"
                                href="javascript:void(0);"
                                :text="__('Select From Existing Projects')"
                                @click="new_project = !new_project"
                                permission="user.access.projects.create"
                                x-show="new_project"
                            />
                        </div>

                        <div class="col-md-12 mt-2" x-show="new_project">
                            <input type="hidden" name="new_project" x-bind:value="new_project ? 1 : 0">
                            @include('frontend.includes.partials.new-project')
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="task" class="col-md-3 col-form-label">
                            @lang('Task')
                            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The task you\'ve been working on') }}"></i>
                        </label>

                        <div class="col-md-9">
                            <input type="text" name="task" class="form-control" placeholder="{{ __('Task') }}" maxlength="255" value="{{ old('task') }}" />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="details" class="col-md-3 col-form-label">
                            @lang('Details')
                            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('A few comments about your work') }}"></i>
                        </label>

                        <div class="col-md-9">
                            <textarea name="details" class="form-control" placeholder="{{ __('Details') }}" maxlength="255" />{{ old('details') }}</textarea>
                        </div>
                    </div><!--form-group-->

                    <div id="alertsWrapper"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-outline-primary">@lang('Add Time')</button>
                </div>
            </div>
        </x-forms>
    </div>
</div>

<script>
    function changeTimezone(date, ianatz) {
        var invdate = new Date(date.toLocaleString('en-US', {
            timeZone: ianatz
        }));
        var diff = date.getTime() - invdate.getTime();
        return new Date(date.getTime() - diff);
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function dateToYYYYMMDDHHIISS(datetime) {
        let month = (datetime.getMonth() + 1);
        let day = datetime.getDate();
        let hour = datetime.getHours();
        let minutes = datetime.getMinutes();
        if (month < 10) {
            month = "0" + month;
        }
        if (day < 10) {
            day = "0" + day;
        }
        if (hour < 10) {
            hour = "0" + hour;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        return datetime.getFullYear() + "-" + month + "-" + day + " " + hour + ":" + minutes;
    }

    let startTime = getCookie('counterStartTime');

    let timezone = '{{ $logged_in_user->timezone }}';

    (function(){
        setTimeout(() => {
            $("#saveTimeModal").on('show.bs.modal', function() {
                document.getElementById("navsWrapper").style.position = "initial";
            })

            $("#saveTimeModal").on('hide.bs.modal', function() {
                document.getElementById("navsWrapper").style.position = "sticky";
            })
        }, 500);

        var addTimeForm = document.getElementById("counterAddTimeForm");

        addTimeForm.addEventListener("submit", function(e){
            e.preventDefault();

            let correctStartTime = changeTimezone(new Date(startTime), timezone)
            let correctEndTime = changeTimezone(new Date(), timezone)

            document.getElementById("counterStartTime").value = dateToYYYYMMDDHHIISS(correctStartTime);
            document.getElementById("counterEndTime").value = dateToYYYYMMDDHHIISS(correctEndTime);

            fetch("{{ route('user.api.time.store') }}", {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer {{ $logged_in_user->api_token }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(new FormData(addTimeForm))),
            })
            .then(response => response.text())
            .then(result => {
                result = JSON.parse(result);
                if (result.success) {
                    setCookie('counterStartTime', "", -1);
                    location.reload();
                } else {
                    document.getElementById("alertsWrapper").innerHTML = "";
                    for (var index in result.errors) {
                        document.getElementById("alertsWrapper").innerHTML += "<div class='alert alert-danger mb-3' role='alert'>" + result.errors[index] + "</div>";
                    }
                    var buttons = document.querySelectorAll(".modal-footer .btn");
                    buttons.forEach(function(button) {
                        button.removeAttribute("disabled");
                    });
                }
            })
        })
    })()

    function counterInit() {
        return {
            startTime: startTime != "" ? new Date(startTime) : false,
            counter: "00:00:00",
            counterUpdateInterval() {
                let counterScript = this;
                counterScript.counterUpdate();
                setInterval(function(){
                    counterScript.counterUpdate();
                }, 1000);
            },
            counterUpdate() {
                if (!this.startTime) {
                    this.counter = "00:00:00";
                    return;
                }
                var difference = new Date() - this.startTime;
                var hours = parseInt(difference / 3600000);
                if (hours < 10) {
                    hours = "0" + hours;
                }
                var minutes = parseInt(difference % 3600000 / 60000);
                if (minutes < 10) {
                    minutes = "0" + minutes;
                }
                var seconds = parseInt(difference % 3600000 % 60000 / 1000);
                if (seconds < 10) {
                    seconds = "0" + seconds;
                }
                this.counter = hours + ":" + minutes + ":" + seconds;
            },
            showCancelButton() {
                return this.startTime;
            },
            showStopButton() {
                return this.startTime;
            },
            showStartButton() {
                return !this.startTime;
            },
            startCounter() {
                this.state = "started";
                setCookie('counterStartTime', new Date(), 1);
                this.startTime = new Date();
                startTime = new Date();
            },
            cancelCounter() {
                if (confirm("{{ __('Are you sure you want to stop the current counter?') }}")) {
                    this.state = "init";
                    setCookie('counterStartTime', "", -1);
                    this.startTime = false;   
                }
            },
        };
    }
</script>