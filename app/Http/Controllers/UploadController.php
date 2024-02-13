<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExports;
use App\Models\CampaignImport;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Exception;

class UploadController extends Controller
{
    protected UploadService $service;

    public function __construct(UploadService $uploadService)
    {
        $this->service = $uploadService;
    }

    public function index()
    {
        if (app()->isProduction()) {
            abort(404);
        }

        return response()->json([
            'error' => 'You need to POST to this endpoint',
        ]);
    }

    public function config()
    {
        if (app()->isProduction()) {
            abort(404);
        }

        phpinfo();
    }

    public function upload(StoreExports $request)
    {
        try {
            $this->service
                ->request($request)
                ->handle();

            return response()->json([
                'success' => true,
                'job_id' => $this->service->id(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
