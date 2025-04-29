<?php

namespace App\Models;

use App\Enums\UserAction;
use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 *
 * @property int $id
 * @property int $user_id
 * @property int $type_id
 * @property int $campaign_id
 * @property string $ip
 * @property string $country
 * @property Carbon $created_at
 * @property array $data
 */
class UserLog extends Model
{
    use MassPrunable;

    public $connection = 'logs';

    public $table = 'user_logs';

    protected $casts = [
        'type_id' => UserAction::class,
        'data' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'type_id',
        'ip',
        'campaign_id',
        'data',
        'impersonated_by',
    ];
}
