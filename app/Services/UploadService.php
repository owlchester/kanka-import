<?php

namespace App\Services;

use App\Enums\CampaignImportStatus;
use App\Enums\UserAction;
use App\Http\Requests\StoreExports;
use App\Jobs\Campaigns\Import;
use App\Models\Campaign;
use App\Models\CampaignImport;
use App\Models\UserLog;
use Illuminate\Http\UploadedFile;

class UploadService
{
    protected StoreExports $request;
    protected Campaign $campaign;
    protected CampaignImport $campaignImport;

    public function request(StoreExports $request): self
    {
        $this->request = $request;

        $this->campaignImport = CampaignImport::findOrFail($request->token);
        $this->campaign = Campaign::findOrFail($request->campaign);
        return $this;
    }

    public function id(): int
    {
        return $this->campaignImport->id;
    }

    public function handle(): void
    {
        $this
            ->validate()
            ->upload()
            ->queue();
    }

    protected function validate(): self
    {
        return $this;
    }

    protected function upload(): self
    {
        $folder = 'imports/' . $this->campaign->id . '';
        /** @var UploadedFile $file */
        $files = $this->request->file('files');
        $config = [];
        foreach ($files as $file) {
            $path = $file->storeAs($folder, uniqid() . '.zip', 'export');
            $config['files'][] = $path;
        }
        $this->campaignImport->config = $config;
        return $this;
    }

    protected function queue(): self
    {

        $this->campaignImport->status_id = CampaignImportStatus::QUEUED;
        $this->campaignImport->save();

        Import::dispatch($this->campaignImport);

        $this->log();

        return $this;
    }

    protected function log(): self
    {
        $log = new UserLog([
            'user_id' => $this->campaignImport->user_id,
        ]);
        $log->type_id = UserAction::campaign;
        $log->campaign_id = $this->campaign->id;
        $first = [];
        $first['module'] = 'import';
        $first['action'] = 'queued';
        $log->data = $first;
        $log->save();

        return $this;
    }
}
