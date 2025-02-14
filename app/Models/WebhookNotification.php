<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_id', 'type', 'happened_at', 'has_vcs_info', 'commit_subject','commit_author',
        'event_status','workflow_url'
    ];
}
