@inject('projectModel', '\App\Models\Project')

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" x-data="counterInit()" x-init="counterUpdateInterval()" id="counterMenu">
    <div class="container">
        <span class="counter" x-text="counter"></span>
        <h5 class="d-md-block d-none">@lang('Track your time by using the buttons on the right!')</h5>
        <div class="actions">
            <button class="btn btn-danger" @click="cancelCounter()" x-show="showCancelButton()">@lang('Cancel')</button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#saveTimeModal" x-show="showStopButton()">@lang('Stop & Save')</button>
            <button class="btn btn-primary" @click="startCounter()" x-show="showStartButton()">@lang('Start Tracking Time')</button>
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

                    <div class="form-group row">
                        <label for="project_id" class="col-md-2 col-form-label">@lang('Project')</label>

                        <div class="col-md-10">
                            <select name="project_id" class="form-control select2-project">
                                @foreach ($projectModel::all() as $project) 
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'checked' : '' }}>{{ $project->name }}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="task" class="col-md-2 col-form-label">@lang('Task')</label>

                        <div class="col-md-10">
                            <input type="text" name="task" class="form-control" placeholder="{{ __('Task') }}" maxlength="255" value="{{ old('task') }}" />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="details" class="col-md-2 col-form-label">@lang('Details')</label>

                        <div class="col-md-10">
                            <textarea name="details" class="form-control" placeholder="{{ __('Details') }}" />{{ old('details') }}</textarea>
                        </div>
                    </div><!--form-group-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Add Time')</button>
                </div>
            </div>
        </x-forms>
    </div>
</div>

<script>
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

    (function(){
        var addTimeForm = document.getElementById("counterAddTimeForm");

        addTimeForm.addEventListener("submit", function(e){
            let startTimeValue = document.getElementById("counterStartTime").value;
            let endTimeValue = document.getElementById("counterEndTime").value;

            if (startTimeValue == "" || endTimeValue == "") {
                e.preventDefault();
            }

            document.getElementById("counterStartTime").value = dateToYYYYMMDDHHIISS(new Date(startTime));
            document.getElementById("counterEndTime").value = dateToYYYYMMDDHHIISS(new Date());

            setCookie('counterStartTime', "", -1);
            
            addTimeForm.submit();
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