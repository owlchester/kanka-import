<?php

namespace App\Services;

use App\Enums\CampaignImportStatus;
use App\Http\Requests\StoreExports;
use App\Jobs\Campaigns\Import;
use App\Models\Campaign;
use App\Models\CampaignImport;
use Exception;
use App\Exceptions\ValidationExeption;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        $folder = 'campaigns/' . $this->campaign->id . '/imports';
        /** @var UploadedFile $file */
        $files = $this->request->file('files');
        $config = [];
        foreach ($files as $file) {
            $path = $file->storeAs($folder, uniqid() . '.zip');
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

        return $this;
    }
}
