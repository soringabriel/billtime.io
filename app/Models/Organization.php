<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Method\OrganizationMethod;
use App\Models\Traits\Relationship\OrganizationRelationship;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Paddle\Billable;

class Organization extends Model
{
    use HasFactory,
        OrganizationMethod,
        OrganizationRelationship,
        Billable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organizations';

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
        'owner_id',
        'plan_id',
        'next_plan_id',
        'company_name',
        'tax_number',
        'vat_number',
        'address',
        'bank_name',
        'bank_account',
        'subusers_quota',
    ];
                
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return OrganizationFactory::new();
    }
}