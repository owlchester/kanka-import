<?php

namespace App\Jobs\Campaigns;

use App\Models\CampaignImport;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class Import implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    protected int $jobID;

    /**
     * CampaignExport constructor.
     */
    public function __construct(CampaignImport $campaignImport)
    {
        $this->jobID = $campaignImport->id;
    }

    /**
     * Execute the job
     * @throws Exception
     */
    public function handle()
    {
        Log::error('Campaign import should run on kanka queue');
        return 1;
    }

    /**
     *
     */
    public function failed(Throwable $exception)
    {
        throw new Exception('Shouldnt bne called');
    }
}
