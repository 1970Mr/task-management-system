<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'deadline',
        'user_id',
        'parent_task_id'
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_task_id');
    }

    public function parentTask(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_task_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
