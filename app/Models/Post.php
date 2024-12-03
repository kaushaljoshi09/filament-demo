<?php

namespace App\Models;

use App\Trait\ActivityLogger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];


    // Activity Log Configuration
    public function logActivity(string $eventName)
    {

        $logData = [
            'log_name' => 'Posts',
            'event' => $eventName,
            'model' => $this,
        ];

        ActivityLogger::log($logData);
    }
}
