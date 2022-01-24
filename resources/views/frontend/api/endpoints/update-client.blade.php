<h2 class="endpoint-title"><span class="patch-tag">PATCH</span> /api/{client_id}/update-client</h2>
<h4 class="short-description">@lang('Updates a specific client')</h4>

<div class="request-body">
    <h3>@lang('Request Body')</h3>

    <ul class="request-parameters">
    <li>
            <span class="parameter">name</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The name of the client.')
            </span>
        </li>
        <li>
            <span class="parameter">company_name</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The company name of the client.')
            </span>
        </li>
        <li>
            <span class="parameter">tax_number</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The tax number of the client.')
            </span>
        </li>
        <li>
            <span class="parameter">vat_number</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The vat number of the client.')
            </span>
        </li>
        <li>
            <span class="parameter">address</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The address of the client.')
            </span>
        </li>
        <li>
            <span class="parameter">bank_account</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The bank account of the client.')
            </span>
        </li>
    </ul>
</div>

<div class="test-api">
    <h3>@lang('Send a Test Request')</h3>

    <div class="test-api-playground">
        <input type="text" class="url form-control mb-3" value="{{ route('user.api.clients.update', ['client' => 10]) }}">
        <input type="hidden" class="method" value="PATCH">
        <ul class="nav nav-tabs"  role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="bodyUpdateClients-tab" data-toggle="tab" href="#bodyUpdateClients" role="tab" aria-controls="home" aria-selected="true">Body</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="headersUpdateClients-tab" data-toggle="tab" href="#headersUpdateClients" role="tab" aria-controls="profile" aria-selected="false">Headers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="codeUpdateClients-tab" data-toggle="tab" href="#codeUpdateClients" role="tab" aria-controls="profile" aria-selected="false">Code</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade params show active" id="bodyUpdateClients" role="tabpanel" aria-labelledby="bodyUpdateClients-tab">
                <div class="tab-content pt-3">
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="name"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="johndoe"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="company_name"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="company_name"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="tax_number"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="tax_number"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="vat_number"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="vat_number"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="address"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="address"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="bank_account"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="bank_account"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade headers" id="headersUpdateClients" role="tabpanel" aria-labelledby="headersUpdateClients-tab">
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
            <div class="tab-pane fade code" id="codeUpdateClients" role="tabpanel" aria-labelledby="codeUpdateClients-tab">
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="code-sample-tab">
                        <div>
                            <div class="col-12">
                                <div class="nav nav-pills" role="tablist">
                                    <a class="nav-link tab-title active" id="updateClients-curl" data-toggle="pill" href="#updateClients-tab-curl" role="tab" aria-controls="updateClients-tab-curl" aria-selected="true">
                                        @lang('Curl')
                                    </a>
                                    <a class="nav-link tab-title" id="updateClients-nodejs" data-toggle="pill" href="#updateClients-tab-nodejs" role="tab" aria-controls="updateClients-tab-nodejs" aria-selected="false">
                                        @lang('NodeJS')
                                    </a>
                                    <a class="nav-link tab-title" id="updateClients-python" data-toggle="pill" href="#updateClients-tab-python" role="tab" aria-controls="updateClients-tab-python" aria-selected="false">
                                        @lang('Python')
                                    </a>
                                    <a class="nav-link tab-title" id="updateClients-php" data-toggle="pill" href="#updateClients-tab-php" role="tab" aria-controls="updateClients-tab-php" aria-selected="false">
                                        @lang('PHP')
                                    </a>
                                    <a class="nav-link tab-title" id="updateClients-golang" data-toggle="pill" href="#updateClients-tab-golang" role="tab" aria-controls="updateClients-tab-golang" aria-selected="false">
                                        @lang('Golang')
                                    </a>
                                    <a class="nav-link tab-title" id="updateClients-java" data-toggle="pill" href="#updateClients-tab-java" role="tab" aria-controls="updateClients-tab-java" aria-selected="false">
                                        @lang('Java')
                                    </a>
                                    <a class="nav-link tab-title" id="updateClients-dotnet" data-toggle="pill" href="#updateClients-tab-dotnet" role="tab" aria-controls="updateClients-tab-dotnet" aria-selected="false">
                                        @lang('.NET')
                                    </a>
                                    <a class="nav-link tab-title" id="updateClients-ruby" data-toggle="pill" href="#updateClients-tab-ruby" role="tab" aria-controls="updateClients-tab-ruby" aria-selected="false">
                                        @lang('Ruby')
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 pt-4">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="updateClients-tab-curl" role="tabpanel" aria-labelledby="curl">
                                        <div>
                                            <pre class="language-curl"><code class="language-bash"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateClients-tab-nodejs" role="tabpanel" aria-labelledby="nodejs">
                                        <div>
                                            <pre class="language-nodejs"><code class="language-javascript"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateClients-tab-python" role="tabpanel" aria-labelledby="python">
                                        <div>
                                            <pre class="language-python"><code class="language-python"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateClients-tab-php" role="tabpanel" aria-labelledby="php">
                                        <div>
                                            <pre class="language-php"><code class="language-php"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateClients-tab-golang" role="tabpanel" aria-labelledby="golang">
                                        <div>
                                            <pre class="language-go"><code class="language-go"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateClients-tab-java" role="tabpanel" aria-labelledby="java">
                                        <div>
                                            <pre class="language-java"><code class="language-java"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateClients-tab-dotnet" role="tabpanel" aria-labelledby="dotnet">
                                        <div>
                                            <pre class="language-csharp "><code class="language-csharp"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateClients-tab-ruby" role="tabpanel" aria-labelledby="ruby">
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