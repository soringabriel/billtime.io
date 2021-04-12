<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Method\InvoiceMethod;
use App\Models\Traits\Relationship\InvoiceRelationship;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory,
        InvoiceMethod,
        InvoiceRelationship;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_PAST_DUE = 'past_due';
    public const STATUSES = [Invoice::STATUS_PENDING, Invoice::STATUS_PAID, Invoice::STATUS_PAST_DUE];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'number',
        'buyer_company_name',
        'buyer_tax_number',
        'buyer_vat_number',
        'buyer_address',
        'seller_company_name',
        'seller_tax_number',
        'seller_vat_number',
        'seller_address',
        'seller_bank_name',
        'seller_bank_account',
        'services',
        'tax',
        'shipping',
        'currency',
        'price',
        'date',
        'due_date',
        'notes',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'user',
        'times',
    ];
                
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return InvoiceFactory::new();
    }
}