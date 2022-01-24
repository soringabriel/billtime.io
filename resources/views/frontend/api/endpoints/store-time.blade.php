<h2 class="endpoint-title"><span class="post-tag">POST</span> /api/store-time</h2>
<h4 class="short-description">@lang('Create a time')</h4>

<div class="usage-notes">
    <h3>@lang('Usage Notes')</h3>
    <ul>
        <li>
            @lang('The start_time should always be smaller or equal than the end_time.')
        </li>
        <li>
            @lang('The time in between start_time and end_time should not overlap existing times.')
        </li>
    </ul>
</div>

<div class="request-body">
    <h3>@lang('Request Body')</h3>

    <ul class="request-parameters">
        <li>
            <span class="parameter">start_time</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The start time in format Y-m-d H:i.')
            </span>
        </li>
        <li>
            <span class="parameter">end_time</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The end time in format Y-m-d H:i.')
            </span>
        </li>
        <li>
            <span class="parameter">project_id</span>
            <span class="type type-number">number</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The id of the project associated to the time record.')
            </span>
        </li>
        <li>
            <span class="parameter">task</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The task associated to the time record.')
            </span>
        </li>
        <li>
            <span class="parameter">details</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The time record details.')
            </span>
        </li>
    </ul>
</div>

<div class="test-api">
    <h3>@lang('Send a Test Request')</h3>

    <div class="test-api-playground">
        <input type="text" class="url form-control mb-3" value="{{ route('user.api.time.store') }}">
        <input type="hidden" class="method" value="POST">
        <ul class="nav nav-tabs"  role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="bodyStoreTimes-tab" data-toggle="tab" href="#bodyStoreTimes" role="tab" aria-controls="home" aria-selected="true">Body</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="headersStoreTimes-tab" data-toggle="tab" href="#headersStoreTimes" role="tab" aria-controls="profile" aria-selected="false">Headers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="codeStoreTimes-tab" data-toggle="tab" href="#codeStoreTimes" role="tab" aria-controls="profile" aria-selected="false">Code</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade params show active" id="bodyStoreTimes" role="tabpanel" aria-labelledby="bodyStoreTimes-tab">
                <div class="tab-content pt-3">
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="start_time"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="{{ now()->subHour()->format('Y-m-d H:i') }}"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="end_time"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="{{ now()->format('Y-m-d H:i') }}"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="project_id"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="1"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="task"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="task-name-or-url"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="details"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="details"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade headers" id="headersStoreTimes" role="tabpanel" aria-labelledby="headersStoreTimes-tab">
                <div class="tab-content pt-3">
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('header name') }}" value="authorization"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('header value') }}" value="Bearer {{ $logged_in_user->api_token }}"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('header name') }}" value="accept"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('header value') }}" value="application/json"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade code" id="codeStoreTimes" role="tabpanel" aria-labelledby="codeStoreTimes-tab">
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="code-sample-tab">
                        <div>
                            <div class="col-12">
                                <div class="nav nav-pills" role="tablist">
                                    <a class="nav-link tab-title active" id="storeTimes-curl" data-toggle="pill" href="#storeTimes-tab-curl" role="tab" aria-controls="storeTimes-tab-curl" aria-selected="true">
                                        @lang('Curl')
                                    </a>
                                    <a class="nav-link tab-title" id="storeTimes-nodejs" data-toggle="pill" href="#storeTimes-tab-nodejs" role="tab" aria-controls="storeTimes-tab-nodejs" aria-selected="false">
                                        @lang('NodeJS')
                                    </a>
                                    <a class="nav-link tab-title" id="storeTimes-python" data-toggle="pill" href="#storeTimes-tab-python" role="tab" aria-controls="storeTimes-tab-python" aria-selected="false">
                                        @lang('Python')
                                    </a>
                                    <a class="nav-link tab-title" id="storeTimes-php" data-toggle="pill" href="#storeTimes-tab-php" role="tab" aria-controls="storeTimes-tab-php" aria-selected="false">
                                        @lang('PHP')
                                    </a>
                                    <a class="nav-link tab-title" id="storeTimes-golang" data-toggle="pill" href="#storeTimes-tab-golang" role="tab" aria-controls="storeTimes-tab-golang" aria-selected="false">
                                        @lang('Golang')
                                    </a>
                                    <a class="nav-link tab-title" id="storeTimes-java" data-toggle="pill" href="#storeTimes-tab-java" role="tab" aria-controls="storeTimes-tab-java" aria-selected="false">
                                        @lang('Java')
                                    </a>
                                    <a class="nav-link tab-title" id="storeTimes-dotnet" data-toggle="pill" href="#storeTimes-tab-dotnet" role="tab" aria-controls="storeTimes-tab-dotnet" aria-selected="false">
                                        @lang('.NET')
                                    </a>
                                    <a class="nav-link tab-title" id="storeTimes-ruby" data-toggle="pill" href="#storeTimes-tab-ruby" role="tab" aria-controls="storeTimes-tab-ruby" aria-selected="false">
                                        @lang('Ruby')
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 pt-4">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="storeTimes-tab-curl" role="tabpanel" aria-labelledby="curl">
                                        <div>
                                            <pre class="language-curl"><code class="language-bash"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeTimes-tab-nodejs" role="tabpanel" aria-labelledby="nodejs">
                                        <div>
                                            <pre class="language-nodejs"><code class="language-javascript"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeTimes-tab-python" role="tabpanel" aria-labelledby="python">
                                        <div>
                                            <pre class="language-python"><code class="language-python"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeTimes-tab-php" role="tabpanel" aria-labelledby="php">
                                        <div>
                                            <pre class="language-php"><code class="language-php"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeTimes-tab-golang" role="tabpanel" aria-labelledby="golang">
                                        <div>
                                            <pre class="language-go"><code class="language-go"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeTimes-tab-java" role="tabpanel" aria-labelledby="java">
                                        <div>
                                            <pre class="language-java"><code class="language-java"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeTimes-tab-dotnet" role="tabpanel" aria-labelledby="dotnet">
                                        <div>
                                            <pre class="language-csharp "><code class="language-csharp"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="storeTimes-tab-ruby" role="tabpanel" aria-labelledby="ruby">
                                        <div>
                                            <pre class="language-ruby"><code class="language-ruby"></code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="execute btn btn-primary">@lang('Send')</button>
        <div class="result">
            <h3>@lang('Response')</h3>
            <div class="text-center loader">
                <div class="container-loader"></div>
                <p>@lang('Sending API request')...</p>
            </div>
            <div class="code-block"><code><pre></pre></code><span class="status"></span></div>
        </div>
    </div>
</div>