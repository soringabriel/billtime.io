<div x-data="initServices()">
    <div class="form-group row invoice-row">
        <div class="col-md-6">
            <label for="name" class="col-form-label">
                <span class="required-field">@lang('Currency')</span>
                <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The currency of the amount of the invoice') }}"></i>
            </label>

            <select name="currency" class="form-control select2" x-model="currency" required>
                @foreach ($currencies as $currency => $symbol)
                    <option value="{{ currencyCode($currency) }}">{{ $currency }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="alert alert-info" x-show="associatedTime != null && associatedTime != '1 second'">
        @lang('The total associated times to this invoice amount to') <span id="associatedTimeInvoice" x-text="associatedTime" x-on:change="resetAssociatedTime()"></span>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <table id="services">
                <tr class="head">
                    <th>
                        @lang('Service/Product Name')
                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the service/product sold. Ex: IT Service') }}"></i>
                    </th>
                    <th>
                        @lang('Unit')
                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The unit in which this service/product is measured. Ex: hours') }}"></i>
                    </th>
                    <th>
                        @lang('Quantity')
                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The amount of units of the service/product. Must be a numerical value') }}"></i>
                    </th>
                    <th>
                        @lang('Price per unit')
                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The price for one unit of the service/product') }}"></i>
                    </th>
                    <th>
                        @lang('Discount')
                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The total discount for the service. Must be a numerical value. Percentages are not allowed') }}"></i>
                    </th>
                    <th>
                        @lang('Sub Total')
                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The total amount for one service/product. This is calculated as quantity * price per unit - discount') }}"></i>
                    </th>
                    <th></th>
                </tr>
                @if (isset($invoice) || old('services'))
                    @php
                        if (old('services')) {
                            $services = json_decode(old('services'));
                        } else {
                            $services = json_decode($invoice->services);
                        }
                    @endphp
                    @foreach ($services as $service)
                        <tr class="service-row mb-2">
                            <td>
                                <label for="service-name" class="d-md-none">@lang('Service/Product Name')</label>
                                <input type="text" class="form-control service-name" placeholder="{{ __('IT Services, Consulting...') }}" value="{{ $service->name }}" maxlength="255" required />
                            </td>
                            <td>
                                <label for="serivce-units" class="d-md-none">@lang('Unit')</label>
                                <input type="text" class="form-control service-units" placeholder="{{ __('Hours, Kg...') }}" value="{{ $service->units }}" maxlength="255" required />
                            </td>
                            <td>
                                <label for="service-quantity" class="d-md-none">@lang('Quantity')</label>
                                <input type="number" min="1" class="form-control service-quantity" value="{{ $service->quantity }}" required />
                            </td>
                            <td>
                                <label for="service-price" class="d-md-none">@lang('Price per unit')</label>    
                                <input type="number" min="0" step="0.01" class="form-control service-price" placeholder="{{ __('Gross price for one unit') }}" value="{{ $service->price }}" required />
                            </td>
                            <td>
                                <label for="service-discount" class="d-md-none">@lang('Discount')</label>
                                <input type="number" min="0" step="0.01" class="form-control service-discount" placeholder="{{ __('Discount') }}" value="{{ $service->discount }}" required />
                            </td>
                            <td>
                                <label for="service-sub-total" class="d-md-none">@lang('Sub Total')</label>
                                <span class="service-sub-total">{{ $service->total }}</span>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm remove-service-row mr-1" title="{{ __('Remove Row') }}"><i class="fas fa-times"></i></button>
                                <button class="btn btn-outline-success btn-sm add-service-row" title="{{ __('Add Row') }}"><i class="fas fa-plus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="service-row mb-2">
                        <td>
                            <label for="service-name" class="d-md-none">@lang('Service/Product Name')</label>
                            <input type="text" class="form-control service-name" placeholder="{{ __('IT Services, Consulting...') }}" maxlength="255" required />
                        </td>
                        <td>
                            <label for="serivce-units" class="d-md-none">@lang('Unit')</label>
                            <input type="text" class="form-control service-units" placeholder="{{ __('Hours, Kg...') }}" maxlength="255" required />
                        </td>
                        <td>
                            <label for="service-quantity" class="d-md-none">@lang('Quantity')</label>
                            <input type="number" min="1" class="form-control service-quantity" required />
                        </td>
                        <td>
                            <label for="service-price" class="d-md-none">@lang('Price per unit')</label>    
                            <input type="number" min="0" step="0.01" class="form-control service-price" placeholder="{{ __('Gross price for one unit') }}" required />
                        </td>
                        <td>
                            <label for="service-discount" class="d-md-none">@lang('Discount')</label>
                            <input type="number" min="0" step="0.01" class="form-control service-discount" placeholder="{{ __('Discount') }}" required />
                        </td>
                        <td>
                            <label for="service-sub-total" class="d-md-none">@lang('Sub Total')</label>
                            <span class="service-sub-total">0</span>
                        </td>
                        <td><button class="btn btn-outline-success btn-sm add-service-row" title="{{ __('Add Row') }}"><i class="fas fa-plus"></i></button></td>
                    </tr>
                @endif
            </table>
            <input type="hidden" value="" name="services" id="servicesValue">
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4">
        <div class="field-group field-group-required">
            <label for="tax" class="col-form-label">
                <span class="required-field">@lang('Tax Percentage')</span>
                <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The tax percentage for the invoice. Must be a percentage between 0 to 100') }}"></i>
            </label>
            <input id="tax" type="number" min="0" max="100" step="0.01" name="tax" class="form-control" placeholder="{{ __('Tax perecentage') }}" x-model="tax" value="{{ isset($invoice) ? $invoice->tax : (old('tax') ?? 0) }}" required />
        </div>
        <div class="field-group field-group-required">
            <label for="shipping" class="col-form-label">
                @lang('Shipping')
                <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The cost for shipping. This sum will be added to the total amount of the invoice') }}"></i>
            </label>
            <input id="shipping" type="number" min="0" step="0.01" name="shipping" class="form-control" placeholder="{{ __('Shipping') }}" x-model="shipping" value="{{ isset($invoice) ? $invoice->shipping : (old('shipping') ?? 0) }}" />
        </div>
        <div class="field-group field-group-required">
            <label for="serviceFee" class="col-form-label">
                @lang('Service Fee')
                <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The service fee. This sum will be added to the total amount of the invoice but it will not be taxed.') }}"></i>
            </label>
            <input id="serviceFee" type="number" min="0" step="0.01" name="service_fee" class="form-control" placeholder="{{ __('Service Fee') }}" x-model="service_fee" value="{{ isset($invoice) ? $invoice->service_fee : (old('service_fee') ?? 0) }}" />
        </div>
    </div>
    <div class="col-md-4 offset-md-4">
        <div class="field-group field-group-required" x-show="tax > 0">
            <label for="taxableAmount" class="col-form-label">@lang('Taxable Amount')</label>
            <span id="taxableAmount"></span>
        </div>
        <div class="field-group field-group-required" x-show="tax > 0">
            <label for="totalTax" class="col-form-label">@lang('Total Taxes')</label>
            <span id="totalTax"></span>
        </div>
        <div class="field-group field-group-required" x-show="shipping > 0">
            <label for="totalTax" class="col-form-label">@lang('Shipping')</label>
            <span id="shippingVal"></span>
        </div>
        <div class="field-group field-group-required" x-show="service_fee > 0">
            <label for="totalTax" class="col-form-label">@lang('Service Fee')</label>
            <span id="serviceFeeVal"></span>
        </div>
        <div class="field-group field-group-required">
            <label for="totalTax" class="col-form-label">@lang('Total Amount')</label>
            <span id="totalAmount"></span><input type="hidden" id="totalAmountValue" name="price">
        </div>
    </div>
</div>

<script>
    function setServices() {
        var services = [];
        $(".service-row").each(function(){
            var service = {
                name: $(this).find(".service-name").first().val(),
                units: $(this).find(".service-units").first().val(),
                quantity: $(this).find(".service-quantity").first().val(),
                price: $(this).find(".service-price").first().val(),
                discount: $(this).find(".service-discount").first().val(),
                total: $(this).find(".service-sub-total").first().html(),
            };
            services.push(service);
        })
        $("#servicesValue").val(JSON.stringify(services));
    }

    function calculateTotal() {
        var servicesSum = 0;
        $(".service-sub-total").each(function(){
            servicesSum += parseFloat($(this).html());
        })
        $("#taxableAmount").html(servicesSum);
        var taxPercentage = parseFloat($("#tax").val());
        if (!isNaN(taxPercentage)) {
            var tax = (taxPercentage * servicesSum / 100);
            $("#totalTax").html(tax);
            servicesSum += tax;
        } else {
            $("#totalTax").html(0);
        }
        var shipping = parseFloat($("#shipping").val());
        if (!isNaN(shipping)) {
            $("#shippingVal").html(shipping);
            servicesSum += shipping;
        } else {
            $("#shippingVal").html(0);
        }
        var servicesSumDisplayed = servicesSum;
        var serviceFee = parseFloat($("#serviceFee").val());
        if (!isNaN(serviceFee)) {
            $("#serviceFeeVal").html(serviceFee);
            servicesSumDisplayed += serviceFee;
        } else {
            $("#serviceFeeVal").html(0);
        }
        $("#totalAmount").html(servicesSumDisplayed);
        $("#totalAmountValue").val(servicesSum);
        setServices();
    }

    function removeServiceRow(element) {
        if ($(".service-row").length > 1) {
            element.parents(".service-row").first().remove();
        }
        if ($(".service-row").length == 1) {
            $(".remove-service-row").first().remove();
        }
        calculateTotal();
    }

    function addServiceRow() {
        $("#services").append(`
            <tr class="service-row mb-2">
                <td>
                    <label for="service-name" class="d-md-none">@lang('Service/Product Name')</label>
                    <input type="text" class="form-control service-name" placeholder="{{ __('IT Services, Consulting...') }}" maxlength="255" required />
                </td>
                <td>
                    <label for="serivce-units" class="d-md-none">@lang('Unit')</label>
                    <input type="text" class="form-control service-units" placeholder="{{ __('Hours, Kg...') }}" maxlength="255" required />
                </td>
                <td>
                    <label for="service-quantity" class="d-md-none">@lang('Quantity')</label>
                    <input type="number" min="1" class="form-control service-quantity" required />
                </td>
                <td>
                    <label for="service-price" class="d-md-none">@lang('Price per unit')</label>    
                    <input type="number" min="0" step="0.01" class="form-control service-price" placeholder="{{ __('Gross price for one unit') }}" required />
                </td>
                <td>
                    <label for="service-discount" class="d-md-none">@lang('Discount')</label>
                    <input type="number" min="0" step="0.01" class="form-control service-discount" placeholder="{{ __('Discount') }}" required />
                </td>
                <td>
                    <label for="service-sub-total" class="d-md-none">@lang('Sub Total')</label>
                    <span class="service-sub-total">0</span>
                </td>
                <td>
                    <button class="btn btn-outline-danger btn-sm remove-service-row mr-1" title="{{ __('Remove Row') }}"><i class="fas fa-times"></i></button>
                    <button class="btn btn-outline-success btn-sm add-service-row" title="{{ __('Add Row') }}"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
        `);
        if ($(".service-row").first().find(".remove-service-row").length == 0) {
            $(".service-row").first().find("td").last().prepend(`
                <button class="btn btn-outline-danger btn-sm remove-service-row mr-1"><i class="fas fa-times"></i></button>
            `);
            $(".service-row").first().find(".remove-service-row").first().on('click', function(e){
                e.preventDefault();
                removeServiceRow($(this));
            })
        }
        calculateTotal();
        $(".remove-service-row").last().on('click', function(e){
            e.preventDefault();
            removeServiceRow($(this));
        })
        $(".add-service-row").last().on('click', function(e){
            e.preventDefault();
            addServiceRow();
        })
        $(".service-row").last().find(".service-quantity, .service-price, .service-discount").on('change', function(){
            var quantity = parseFloat($(this).parents('.service-row').first().find('.service-quantity').first().val());
            var price = parseFloat($(this).parents('.service-row').first().find('.service-price').first().val());
            var discount = parseFloat($(this).parents('.service-row').first().find('.service-discount').first().val());
            var subTotal = price * quantity - discount;

            $(this).parents('.service-row').find('.service-sub-total').html(subTotal);
            calculateTotal();
        })
    }

    function initServices() {
        var associatedTime = $("#checkedTimesValues").val() ?? null;

        function jqueryInit() {
            $(".remove-service-row").on('click', function(e){
                e.preventDefault();
                removeServiceRow($(this));
            })

            $(".add-service-row").on('click', function(e){
                e.preventDefault();
                addServiceRow();
            })

            $(".service-quantity, .service-price, .service-discount").on('change', function(){
                var quantity = parseFloat($(this).parents('.service-row').first().find('.service-quantity').first().val());
                var price = parseFloat($(this).parents('.service-row').first().find('.service-price').first().val());
                var discount = parseFloat($(this).parents('.service-row').first().find('.service-discount').first().val());
                var subTotal = price * quantity - discount;

                $(this).parents('.service-row').find('.service-sub-total').html(subTotal);
                calculateTotal();
            })

            $("#tax, #shipping, #serviceFee").on('change', function(){
                calculateTotal();
            })

            $("#checkedTimesValues").on('change', function(){
                $("#associatedTimeInvoice")[0].dispatchEvent(new Event('change'));
            })

            calculateTotal();
        }

        jqueryInit();
        return {
            currency: "{{ isset($invoice) ? $invoice->currency : (old('currency') ?? __('USD')) }}",
            currencies: {!! json_encode($currencies) !!},
            tax: "{{ isset($invoice) ? $invoice->tax : (old('tax') ?? 0) }}",
            shipping: "{{ isset($invoice) ? $invoice->shipping : (old('shipping') ?? 0) }}",
            serviceFee: "{{ isset($invoice) ? $invoice->service_fee : (old('service_fee') ?? 0) }}",
            associatedTime: associatedTime,
            resetAssociatedTime() {
                this.associatedTime = $("#checkedTimesValues").val();
            },
        }
    }
</script>