<h2 class="endpoint-title"><span class="get-tag">GET</span> /api/get-times</h2>
<h4 class="short-description">@lang('Retrieves a list with all the times')</h4>

<div class="test-api">
    <h3>@lang('Send a Test Request')</h3>

    <div class="test-api-playground">
        <input type="text" class="url form-control mb-3" value="{{ route('user.api.time.getTimes') }}">
        <input type="hidden" class="method" value="GET">
        <ul class="nav nav-tabs"  role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="headersListTimes-tab" data-toggle="tab" href="#headersListTimes" role="tab" aria-controls="profile" aria-selected="false">Headers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="codeListTimes-tab" data-toggle="tab" href="#codeListTimes" role="tab" aria-controls="profile" aria-selected="false">Code</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade headers show active" id="headersListTimes" role="tabpanel" aria-labelledby="headersListTimes-tab">
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
            <div class="tab-pane fade code" id="codeListTimes" role="tabpanel" aria-labelledby="codeListTimes-tab">
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="code-sample-tab">
                        <div>
                            <div class="col-12">
                                <div class="nav nav-pills" role="tablist">
                                    <a class="nav-link tab-title active" id="listTimes-curl" data-toggle="pill" href="#listTimes-tab-curl" role="tab" aria-controls="listTimes-tab-curl" aria-selected="true">
                                        @lang('Curl')
                                    </a>
                                    <a class="nav-link tab-title" id="listTimes-nodejs" data-toggle="pill" href="#listTimes-tab-nodejs" role="tab" aria-controls="listTimes-tab-nodejs" aria-selected="false">
                                        @lang('NodeJS')
                                    </a>
                                    <a class="nav-link tab-title" id="listTimes-python" data-toggle="pill" href="#listTimes-tab-python" role="tab" aria-controls="listTimes-tab-python" aria-selected="false">
                                        @lang('Python')
                                    </a>
                                    <a class="nav-link tab-title" id="listTimes-php" data-toggle="pill" href="#listTimes-tab-php" role="tab" aria-controls="listTimes-tab-php" aria-selected="false">
                                        @lang('PHP')
                                    </a>
                                    <a class="nav-link tab-title" id="listTimes-golang" data-toggle="pill" href="#listTimes-tab-golang" role="tab" aria-controls="listTimes-tab-golang" aria-selected="false">
                                        @lang('Golang')
                                    </a>
                                    <a class="nav-link tab-title" id="listTimes-java" data-toggle="pill" href="#listTimes-tab-java" role="tab" aria-controls="listTimes-tab-java" aria-selected="false">
                                        @lang('Java')
                                    </a>
                                    <a class="nav-link tab-title" id="listTimes-dotnet" data-toggle="pill" href="#listTimes-tab-dotnet" role="tab" aria-controls="listTimes-tab-dotnet" aria-selected="false">
                                        @lang('.NET')
                                    </a>
                                    <a class="nav-link tab-title" id="listTimes-ruby" data-toggle="pill" href="#listTimes-tab-ruby" role="tab" aria-controls="listTimes-tab-ruby" aria-selected="false">
                                        @lang('Ruby')
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 pt-4">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="listTimes-tab-curl" role="tabpanel" aria-labelledby="curl">
                                        <div>
                                            <pre class="language-curl"><code class="language-bash"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listTimes-tab-nodejs" role="tabpanel" aria-labelledby="nodejs">
                                        <div>
                                            <pre class="language-nodejs"><code class="language-javascript"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listTimes-tab-python" role="tabpanel" aria-labelledby="python">
                                        <div>
                                            <pre class="language-python"><code class="language-python"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listTimes-tab-php" role="tabpanel" aria-labelledby="php">
                                        <div>
                                            <pre class="language-php"><code class="language-php"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listTimes-tab-golang" role="tabpanel" aria-labelledby="golang">
                                        <div>
                                            <pre class="language-go"><code class="language-go"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listTimes-tab-java" role="tabpanel" aria-labelledby="java">
                                        <div>
                                            <pre class="language-java"><code class="language-java"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listTimes-tab-dotnet" role="tabpanel" aria-labelledby="dotnet">
                                        <div>
                                            <pre class="language-csharp "><code class="language-csharp"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listTimes-tab-ruby" role="tabpanel" aria-labelledby="ruby">
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