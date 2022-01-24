@inject('invoice', '\App\Models\Invoice')

<h2 class="endpoint-title"><span class="patch-tag">PATCH</span> /api/{invoice_id}/updateStatus</h2>
<h4 class="short-description">@lang('Updates the status of a specific invoice')</h4>

<div class="request-body">
    <h3>@lang('Request Body')</h3>

    <ul class="request-parameters">
        <li>
            <span class="parameter">status</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The status of the invoice.')
                @lang('Must be a value in:')
                {{ json_encode($invoice::STATUSES) }}
            </span>
        </li>
    </ul>
</div>

<div class="test-api">
    <h3>@lang('Send a Test Request')</h3>

    <div class="test-api-playground">
        <input type="text" class="url form-control mb-3" value="{{ route('user.api.invoices.updateStatus', ['invoice' => 10]) }}">
        <input type="hidden" class="method" value="PATCH">
        <ul class="nav nav-tabs"  role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="bodyUpdateInvoices-tab" data-toggle="tab" href="#bodyUpdateInvoices" role="tab" aria-controls="home" aria-selected="true">Body</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="headersUpdateInvoices-tab" data-toggle="tab" href="#headersUpdateInvoices" role="tab" aria-controls="profile" aria-selected="false">Headers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="codeUpdateInvoices-tab" data-toggle="tab" href="#codeUpdateInvoices" role="tab" aria-controls="profile" aria-selected="false">Code</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade params show active" id="bodyUpdateInvoices" role="tabpanel" aria-labelledby="bodyUpdateInvoices-tab">
                <div class="tab-content pt-3">
                <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="status"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="{{ $invoice::STATUS_PENDING }}"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade headers" id="headersUpdateInvoices" role="tabpanel" aria-labelledby="headersUpdateInvoices-tab">
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
            <div class="tab-pane fade code" id="codeUpdateInvoices" role="tabpanel" aria-labelledby="codeUpdateInvoices-tab">
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="code-sample-tab">
                        <div>
                            <div class="col-12">
                                <div class="nav nav-pills" role="tablist">
                                    <a class="nav-link tab-title active" id="updateInvoices-curl" data-toggle="pill" href="#updateInvoices-tab-curl" role="tab" aria-controls="updateInvoices-tab-curl" aria-selected="true">
                                        @lang('Curl')
                                    </a>
                                    <a class="nav-link tab-title" id="updateInvoices-nodejs" data-toggle="pill" href="#updateInvoices-tab-nodejs" role="tab" aria-controls="updateInvoices-tab-nodejs" aria-selected="false">
                                        @lang('NodeJS')
                                    </a>
                                    <a class="nav-link tab-title" id="updateInvoices-python" data-toggle="pill" href="#updateInvoices-tab-python" role="tab" aria-controls="updateInvoices-tab-python" aria-selected="false">
                                        @lang('Python')
                                    </a>
                                    <a class="nav-link tab-title" id="updateInvoices-php" data-toggle="pill" href="#updateInvoices-tab-php" role="tab" aria-controls="updateInvoices-tab-php" aria-selected="false">
                                        @lang('PHP')
                                    </a>
                                    <a class="nav-link tab-title" id="updateInvoices-golang" data-toggle="pill" href="#updateInvoices-tab-golang" role="tab" aria-controls="updateInvoices-tab-golang" aria-selected="false">
                                        @lang('Golang')
                                    </a>
                                    <a class="nav-link tab-title" id="updateInvoices-java" data-toggle="pill" href="#updateInvoices-tab-java" role="tab" aria-controls="updateInvoices-tab-java" aria-selected="false">
                                        @lang('Java')
                                    </a>
                                    <a class="nav-link tab-title" id="updateInvoices-dotnet" data-toggle="pill" href="#updateInvoices-tab-dotnet" role="tab" aria-controls="updateInvoices-tab-dotnet" aria-selected="false">
                                        @lang('.NET')
                                    </a>
                                    <a class="nav-link tab-title" id="updateInvoices-ruby" data-toggle="pill" href="#updateInvoices-tab-ruby" role="tab" aria-controls="updateInvoices-tab-ruby" aria-selected="false">
                                        @lang('Ruby')
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 pt-4">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="updateInvoices-tab-curl" role="tabpanel" aria-labelledby="curl">
                                        <div>
                                            <pre class="language-curl"><code class="language-bash"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateInvoices-tab-nodejs" role="tabpanel" aria-labelledby="nodejs">
                                        <div>
                                            <pre class="language-nodejs"><code class="language-javascript"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateInvoices-tab-python" role="tabpanel" aria-labelledby="python">
                                        <div>
                                            <pre class="language-python"><code class="language-python"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateInvoices-tab-php" role="tabpanel" aria-labelledby="php">
                                        <div>
                                            <pre class="language-php"><code class="language-php"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateInvoices-tab-golang" role="tabpanel" aria-labelledby="golang">
                                        <div>
                                            <pre class="language-go"><code class="language-go"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateInvoices-tab-java" role="tabpanel" aria-labelledby="java">
                                        <div>
                                            <pre class="language-java"><code class="language-java"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateInvoices-tab-dotnet" role="tabpanel" aria-labelledby="dotnet">
                                        <div>
                                            <pre class="language-csharp "><code class="language-csharp"></code></pre>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="updateInvoices-tab-ruby" role="tabpanel" aria-labelledby="ruby">
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