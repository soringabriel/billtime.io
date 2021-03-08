<div x-data="initServices()">
    <div class="form-group row invoice-row">
        <div class="col-md-6">
            <label for="name" class="col-form-label">@lang('Currency')</label>

            <select name="currency" class="form-control" x-model="currency" required>
                @foreach ($currencies as $code => $symbol)
                    <option value="{{ $code }}">{{ $code }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <table id="services">
                <tr class="head">
                    <th>@lang('Service Name')</th>
                    <th>@lang('Unit')</th>
                    <th>@lang('Quantity')</th>
                    <th>@lang('Price')</th>
                    <th>@lang('Discount')</th>
                    <th>@lang('Sub Total')</th>
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
                        <tr class="service-row">
                            <td><input type="text" class="form-control service-name" placeholder="{{ __('IT Services, Consulting...') }}" value="{{ $service->name }}" maxlength="255" required /></td>
                            <td><input type="text" class="form-control service-units" placeholder="{{ __('Hours, Kg...') }}" value="{{ $service->units }}" maxlength="255" required /></td>
                            <td><input type="number" min="1" class="form-control service-quantity" value="{{ $service->quantity }}" required /></td>
                            <td><input type="number" min="0" class="form-control service-price" placeholder="{{ __('Price for one unit') }}" value="{{ $service->price }}" required /></td>
                            <td><input type="number" min="0" class="form-control service-discount" placeholder="{{ __('Discount') }}" value="{{ $service->discount }}" required /></td>
                            <td><span class="service-sub-total">{{ $service->total }}</span></td>
                            <td>
                                <button class="btn btn-danger remove-service-row"><i class="fas fa-times"></i></button>
                                <button class="btn btn-success add-service-row"><i class="fas fa-plus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="service-row">
                        <td><input type="text" class="form-control service-name" placeholder="{{ __('IT Services, Consulting...') }}" maxlength="255" required /></td>
                        <td><input type="text" class="form-control service-units" placeholder="{{ __('Hours, Kg...') }}" maxlength="255" required /></td>
                        <td><input type="number" min="1" class="form-control service-quantity" required /></td>
                        <td><input type="number" min="0" class="form-control service-price" placeholder="{{ __('Price for one unit') }}" required /></td>
                        <td><input type="number" min="0" class="form-control service-discount" placeholder="{{ __('Discount') }}" required /></td>
                        <td><span class="service-sub-total">0</span></td>
                        <td><button class="btn btn-success add-service-row"><i class="fas fa-plus"></i></button></td>
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
            <label for="tax" class="col-form-label">@lang('Tax Percentage')</label>
            <input id="tax" type="number" min="0" max="100" name="tax" class="form-control" placeholder="{{ __('Tax perecentage') }}" x-model="tax" required />
        </div>
        <div class="field-group field-group-required">
            <label for="shipping" class="col-form-label">@lang('Shipping')</label>
            <input id="shipping" type="number" min="0" name="shipping" class="form-control" placeholder="{{ __('Shipping') }}" x-model="shipping" required />
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
            servicesSum -= tax;
        } else {
            $("#totalTax").html(0);
        }
        var shipping = parseFloat($("#shipping").val());
        if (!isNaN(shipping)) {
            $("#shippingVal").html(shipping);
            servicesSum -= shipping;
        } else {
            $("#shippingVal").html(0);
        }
        $("#totalAmount").html(servicesSum);
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
            <tr class="service-row">
                <td><input type="text" class="form-control service-name" placeholder="{{ __('IT Services, Consulting...') }}" maxlength="255" required /></td>
                <td><input type="text" class="form-control service-units" placeholder="{{ __('Hours, Kg...') }}" maxlength="255" required /></td>
                <td><input type="number" min="1" class="form-control service-quantity" required /></td>
                <td><input type="number" min="0" class="form-control service-price" placeholder="{{ __('Price for one unit') }}" required /></td>
                <td><input type="number" min="0" class="form-control service-discount" placeholder="{{ __('Discount') }}" required /></td>
                <td><span class="service-sub-total">0</span></td>
                <td>
                    <button class="btn btn-danger remove-service-row"><i class="fas fa-times"></i></button>
                    <button class="btn btn-success add-service-row"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
        `);
        if ($(".service-row").first().children(".remove-service-row").length == 0) {
            $(".service-row").first().children("td").last().prepend(`
                <button class="btn btn-danger remove-service-row"><i class="fas fa-times"></i></button>
            `);
            $(".service-row").first().children("remove-service-row").on('click', function(){
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

            $("#tax, #shipping").on('change', function(){
                calculateTotal();
            })

            calculateTotal();
        }

        jqueryInit();
        return {
            currency: "{{ isset($invoice) ? $invoice->currency : (old('currency') ?? __('USD')) }}",
            currencies: {!! json_encode($currencies) !!},
            tax: "{{ isset($invoice) ? $invoice->tax : (old('tax') ?? 0) }}",
            shipping: "{{ isset($invoice) ? $invoice->shipping : (old('shipping') ?? 0) }}",
        }
    }
</script>