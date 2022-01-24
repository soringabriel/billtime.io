<h2 class="endpoint-title"><span class="patch-tag">PATCH</span> /api/{invoice_id}/update-invoice</h2>
<h4 class="short-description">@lang('Updates a specific invoice')</h4>

<div class="request-body">
    <h3>@lang('Request Body')</h3>

    <ul class="request-parameters">
        <li>
            <span class="parameter">number</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The number of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">buyer_company_name</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The buyer company name of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">buyer_tax_number</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The buyer tax number of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">buyer_vat_number</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The buyer vat number of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">buyer_address</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The buyer address of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">seller_company_name</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The seller company name of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">seller_tax_number</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The seller tax number of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">seller_vat_number</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The seller vat number of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">seller_address</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The seller address of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">seller_bank_name</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The seller bank name of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">seller_bank_account</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The seller bank account of the invoice.')
            </span>
        </li>
        <li>
            <span class="parameter">services</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The JSON with the services sold on the invoice.')
                @lang('Must be in the following format:')
                [{"name": "IT Services", "price": "24", "total": "3672", "units": "Hours", "discount": "0", "quantity": "153"}]
            </span>
        </li>
        <li>
            <span class="parameter">tax</span>
            <span class="type type-number">number</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The tax percentage. Must be a number between 0 and 100')
            </span>
        </li>
        <li>
            <span class="parameter">shipping</span>
            <span class="type type-number">number</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The shipping cost, if any.')
            </span>
        </li>
        <li>
            <span class="parameter">service_fee</span>
            <span class="type type-number">number</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The service fee, if any.')
            </span>
        </li>
        <li>
            <span class="parameter">currency</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The currency as a 3 letter code. For example: EUR or USD')
            </span>
        </li>
        <li>
            <span class="parameter">date</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The date of the invoice in the format Y-m-d')
            </span>
        </li>
        <li>
            <span class="parameter">due_date</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The due date of the invoice (if any) in the format Y-m-d')
            </span>
        </li>
        <li>
            <span class="parameter">notes</span>
            <span class="type type-string">string</span>
            <span class="validation">@lang('optional')</span>
            <span class="description">
                @lang('The notes at the bottom of the invoice')
            </span>
        </li>
        <li>
            <span class="parameter">price</span>
            <span class="type type-number">number</span>
            <span class="validation">@lang('required')</span>
            <span class="description">
                @lang('The total cost of the invocie')
            </span>
        </li>
    </ul>
</div>

<div class="test-api">
    <h3>@lang('Send a Test Request')</h3>

    <div class="test-api-playground">
        <input type="text" class="url form-control mb-3" value="{{ route('user.api.invoices.update', ['invoice' => 10]) }}">
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
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="number"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="INVOICE01"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="buyer_company_name"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="buyer_company_name"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="buyer_tax_number"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="buyer_tax_number"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="buyer_vat_number"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="buyer_vat_number"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="buyer_address"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="buyer_address"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="seller_company_name"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="seller_company_name"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="seller_tax_number"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="seller_tax_number"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="seller_vat_number"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="seller_vat_number"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="seller_address"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="seller_address"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="seller_bank_name"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="seller_bank_name"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="seller_bank_account"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="seller_bank_account"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="services"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value='[{"name": "IT Services", "price": "24", "total": "3672", "units": "Hours", "discount": "0", "quantity": "153"}]'></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="tax"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="5"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="shipping"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="5"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="service_fee"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="5.5"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="currency"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="usd"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="date"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="2021-01-01"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="due_date"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="2021-01-01"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="notes"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="notes"></div>
                    </div>
                    <div class="parameter">
                        <div class="checkbox"><input type="checkbox" checked></div>
                        <div class="name"><input type="text" class="form-control" placeholder="{{ __('parameter name') }}" value="price"></div>
                        <div class="value"><input type="text" class="form-control" placeholder="{{ __('parameter value') }}" value="5"></div>
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