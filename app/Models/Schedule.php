<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Method\ScheduleMethod;
use App\Models\Traits\Relationship\ScheduleRelationship;
use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory,
        ScheduleMethod,
        ScheduleRelationship;

    public const MONTHLY = 'monthly';
    public const PERIODS = [Schedule::MONTHLY];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';

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
        'project_id',
        'period',
        'schedule_trigger',
        'price_per_hour',
        'price_currency',
        'discount',
        'tax',
        'shipping',
        'service_fee',
        'notes',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'user',
        'project',
    ];
                
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ScheduleFactory::new();
    }
}