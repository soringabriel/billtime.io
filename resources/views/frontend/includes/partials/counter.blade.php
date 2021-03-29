<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" x-data="counterInit()">
    <div class="container">
        <span class="counter" x-text="counter()"></span>
        <button class="btn btn-warning" @click="cancelCounter()" x-show="showCancelButton()">@lang('Cancel')</button>
        <button class="btn btn-danger" x-show="showStopButton()">@lang('Stop Counter')</button>
        <button class="btn btn-success" @click="startCounter()" x-show="showStartButton()">@lang('Start Counter')</button>
    </div>
</nav>

<script>
    function counterInit() {
        return {
            startTime: false,
            counter: "00:00:00",
            state: "init",
            counterTimeout: false,
            counter() {
                clearTimeout(this.counterTimeout);
                this.counterTimeout = setTimeout(function(){ this.counter(); }, 1000);
                if (!this.startTime) {
                    return "00:00:00";
                }
                var difference = new Date() - this.startTime;
                console.log(difference);
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
                return hours + ":" + minutes + ":" + seconds;
            },
            showCancelButton() {
                return this.state == "started";
            },
            showStopButton() {
                return this.state == "started";
            },
            showStartButton() {
                return this.state == "init";
            },
            startCounter() {
                this.state = "started";
                this.startTime = new Date();
            },
            cancelCounter() {
                if (confirm("{{ __('Are you sure you want to stop the current counter?') }}")) {
                    this.state = "init";
                    this.startTime = false;   
                }
            },
        };
    }
</script>