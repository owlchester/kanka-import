<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $campaign_id
 * @property int $status_id
 */
class CampaignImport extends Model
{
    public $casts = [
        'config' => 'array'
    ];
}
