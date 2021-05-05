<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Method\PlanMethod;
use App\Models\Traits\Relationship\PlanRelationship;
use Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Plan extends Model
{
    use HasRoles,
        HasFactory,
        PlanMethod,
        PlanRelationship;

    public const BILLING_TYPE_NONE = 'none';
    public const BILLING_TYPE_MONTHLY = 'monthly';
    public const BILLING_TYPE_YEARLY = 'yearly';
    public const BILLING_TYPES = [Plan::BILLING_TYPE_NONE, Plan::BILLING_TYPE_MONTHLY, Plan::BILLING_TYPE_YEARLY];

    /**
     * The guard name that it's neccessary for the permissions association.
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plans';

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
        'name',
        'price',
        'currency',
        'billing_type',
        'subusers_quota',
    ];
                
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PlanFactory::new();
    }
}