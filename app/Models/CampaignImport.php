<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $campaign_id
 */
class CampaignImport extends Model
{
    public $casts = [
        'config' => 'array'
    ];
}
