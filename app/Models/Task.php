<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'customer_id',
        'technician_id',
        'status',
        'completed_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'completed_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function scopeVisibleFor(Builder $query, User $user): Builder
    {
        if ($user->hasRole(\App\Constants\Roles::TECHNICIAN)) {
            $query->where('technician_id', $user->id);
        }

        return $query;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
