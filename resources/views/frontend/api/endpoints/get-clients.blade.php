<h2 class="endpoint-title"><span class="get-tag">GET</span> /api/client</h2>
<h4 class="short-description">@lang('Retrieves a list with all the clients')</h4>

<div class="test-api">
    <h3>@lang('Send a Test Request')</h3>

    <div class="test-api-playground">
        <input type="text" class="url form-control mb-3" value="{{ route('user.api.clients.getClients') }}">
        <input type="hidden" class="method" value="GET">
        <ul class="nav nav-tabs"  role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="bodyListClients-tab" data-toggle="tab" href="#bodyListClients" role="tab" aria-controls="home" aria-selected="true">Body</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="headersListClients-tab" data-toggle="tab" href="#headersListClients" role="tab" aria-controls="profile" aria-selected="false">Headers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="codeListClients-tab" data-toggle="tab" href="#codeListClients" role="tab" aria-controls="profile" aria-selected="false">Code</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade params show active" id="bodyListClients" role="tabpanel" aria-labelledby="bodyListClients-tab">
                <div class="tab-content pt-3">
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="search"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value=""></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="sort_field"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="username"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="sort_direction"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="asc"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="page"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="1"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade headers" id="headersListClients" role="tabpanel" aria-labelledby="headersListClients-tab">
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
            <div class="tab-pane fade code" id="codeListClients" role="tabpanel" aria-labelledby="codeListClients-tab">
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="code-sample-tab">
                        <div>
                            <div class="col-12">
                                <div class="nav nav-pills" role="tablist">
                                    <a class="nav-link tab-title active" id="listClients-curl" data-toggle="pill" href="#listClients-tab-curl" role="tab" aria-controls="listClients-tab-curl" aria-selected="true">
                                        @lang('Curl')
                                    </a>
                                    <a class="nav-link tab-title" id="listClients-nodejs" data-toggle="pill" href="#listClients-tab-nodejs" role="tab" aria-controls="listClients-tab-nodejs" aria-selected="false">
                                        @lang('NodeJS')
                                    </a>
                                    <a class="nav-link tab-title" id="listClients-python" data-toggle="pill" href="#listClients-tab-python" role="tab" aria-controls="listClients-tab-python" aria-selected="false">
                                        @lang('Python')
                                    </a>
                                    <a class="nav-link tab-title" id="listClients-php" data-toggle="pill" href="#listClients-tab-php" role="tab" aria-controls="listClients-tab-php" aria-selected="false">
                                        @lang('PHP')
                                    </a>
                                    <a class="nav-link tab-title" id="listClients-golang" data-toggle="pill" href="#listClients-tab-golang" role="tab" aria-controls="listClients-tab-golang" aria-selected="false">
                                        @lang('Golang')
                                    </a>
                                    <a class="nav-link tab-title" id="listClients-java" data-toggle="pill" href="#listClients-tab-java" role="tab" aria-controls="listClients-tab-java" aria-selected="false">
                                        @lang('Java')
                                    </a>
                                    <a class="nav-link tab-title" id="listClients-dotnet" data-toggle="pill" href="#listClients-tab-dotnet" role="tab" aria-controls="listClients-tab-dotnet" aria-selected="false">
                                        @lang('.NET')
                                    </a>
                                    <a class="nav-link tab-title" id="listClients-ruby" data-toggle="pill" href="#listClients-tab-ruby" role="tab" aria-controls="listClients-tab-ruby" aria-selected="false">
                                        @lang('Ruby')
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 pt-4">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="listClients-tab-curl" role="tabpanel" aria-labelledby="curl">
                                        <div>
                                            <pre class="language-curl"><code class="language-bash"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listClients-tab-nodejs" role="tabpanel" aria-labelledby="nodejs">
                                        <div>
                                            <pre class="language-nodejs"><code class="language-javascript"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listClients-tab-python" role="tabpanel" aria-labelledby="python">
                                        <div>
                                            <pre class="language-python"><code class="language-python"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listClients-tab-php" role="tabpanel" aria-labelledby="php">
                                        <div>
                                            <pre class="language-php"><code class="language-php"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listClients-tab-golang" role="tabpanel" aria-labelledby="golang">
                                        <div>
                                            <pre class="language-go"><code class="language-go"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listClients-tab-java" role="tabpanel" aria-labelledby="java">
                                        <div>
                                            <pre class="language-java"><code class="language-java"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listClients-tab-dotnet" role="tabpanel" aria-labelledby="dotnet">
                                        <div>
                                            <pre class="language-csharp "><code class="language-csharp"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="listClients-tab-ruby" role="tabpanel" aria-labelledby="ruby">
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