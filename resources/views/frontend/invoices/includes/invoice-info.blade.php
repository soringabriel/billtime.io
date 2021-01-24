<div x-data="init()">
    <div class="form-group row">
        <label for="name" class="col-md-2 col-form-label">@lang('Currency')</label>

        <div class="col-md-10">
            @php 
                $currencies = currencyToSymbol();
            @endphp
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
                    <th>@lang('Add/Remove Service')</th>
                </tr>
                <tr class="service-row">
                    <td><input type="text" class="form-control service-name" placeholder="{{ __('IT Services, Consulting...') }}" maxlength="255" required /></td>
                    <td><input type="text" class="form-control service-units" placeholder="{{ __('Hours, Kg...') }}" maxlength="255" required /></td>
                    <td><input type="number" min="1" class="form-control service-quantity" required /></td>
                    <td>
                        <span class="currency-symbol" x-text="currencySymbol()"></span>
                        <input type="number" min="0" class="form-control service-price" placeholder="{{ __('Price for one unit') }}" required />
                    </td>
                    <td>
                        <span class="currency-symbol" x-text="currencySymbol()"></span>
                        <input type="number" min="0" class="form-control service-discount" placeholder="{{ __('Discount') }}" required />
                    </td>
                    <td><span class="currency-symbol" x-text="currencySymbol()"></span><span class="service-sub-total">0</span></td>
                    <td>
                        <button class="btn btn-danger remove-service-row"><i class="fas fa-times"></i></button>
                        <button class="btn btn-success add-service-row"><i class="fas fa-plus"></i></button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4">
        <div class="field-group field-group-required">
            <label for="tax" class="col-md-2 col-form-label">@lang('Tax Percentage')</label>
            <input id="tax" type="number" min="0" max="100" name="tax" class="form-control" placeholder="{{ __('Tax perecentage') }}" required />
        </div>
    </div>
    <div class="col-md-4 offset-md-4">
        <div class="field-group field-group-required">
            <label for="taxableAmount" class="col-md-2 col-form-label">@lang('Taxable Amount')</label>
            <span id="taxableAmount">
        </div>
        <div class="field-group field-group-required">
            <label for="totalTax" class="col-md-2 col-form-label">@lang('Total Taxes')</label>
            <span id="totalTax">
        </div>
        <div class="field-group field-group-required">
            <label for="totalTax" class="col-md-2 col-form-label">@lang('Total Amount')</label>
            <span id="totalAmount">
        </div>
    </div>
</div>

<script>
    $(".service-quantity, .service-price, .service-discount").on('change', function(){
        var quantity = $(this).parent('.service-row').find('service-quantity').val();
        var price = $(this).parent('.service-row').find('service-price').val();
        var discount = $(this).parent('.service-row').find('service-discount').val();
        var subTotal = price * quantity - discount;

        $(this).parent('.service-row').find('service-sub-total').html(subTotal);
    })

    $("#tax").on('change', function(){
        
    })

    function init() {
        return {
            currency: 'USD',
            currencies: {!! $currencies !!},
            currencySymbol() {
                for (const property in this.currencies) {
                    if (this.currencies[property] == this.currency) {
                        return property;
                    }
                }
                return this.currency;
            },
        }
    }
</script>