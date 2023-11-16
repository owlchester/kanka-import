<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignImport extends Model
{
    public $casts = [
        'config' => 'array'
    ];
}
