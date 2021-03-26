<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" x-data="counterInit()">
    <div class="container">
        <span class="counter" x-text="counter"></span>
        <button class="btn btn-primary" x-show="showUpdateButton()">@lang('Update Information')</button>
        <button class="btn btn-warning" x-show="showCancelButton()">@lang('Cancel')</button>
        <button class="btn btn-danger" x-show="showStopButton()">@lang('Stop Counter')</button>
        <button class="btn btn-success" x-show="showStartButton()">@lang('Start Counter')</button>
    </div>
</nav>

<script>
    function counterInit() {
        return {
            counter: "00:00:00",
            state: "init",
            showUpdateButton() {
                return this.state == "started";
            },
            showCancelButton() {
                return this.state == "started";
            },
            showStopButton() {
                return this.state == "started";
            },
            showStartButton() {
                return this.state == "init";
            }
        };
    }
</script>