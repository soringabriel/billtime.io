<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Method\TimeMethod;
use App\Models\Traits\Relationship\TimeRelationship;
use Database\Factories\TimeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Time extends Model
{
    use HasFactory,
        TimeMethod,
        TimeRelationship;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'time';

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
        'start_time',
        'end_time',
        'project_id',
        'task',
        'details',
        'billed',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'user',
        'tags',
        'project',
    ];
                
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TimeFactory::new();
    }
}