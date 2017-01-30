<?php

namespace Screeenly\Http\Controllers\Api\v1;

use Screeenly\Entities\Url;
use App\Http\Controllers\Controller;
use Screeenly\Services\CaptureService;
use Screeenly\Http\Requests\CreateScreenshotRequest;
use Exception;

class ScreenshotController extends Controller
{
    /**
     * @var Screeenly\Services\CaptureService
     */
    protected $captureService;

    public function __construct(CaptureService $captureService)
    {
        $this->captureService = $captureService;
    }

    /**
     * Create a new Screenshot
     * @param  CreateScreenshotRequest $request
     * @return Illuminate\Http\Response
     */
    public function store(CreateScreenshotRequest $request)
    {
        $apiKey = $request->user()->first()->apiKeys()->where('key', $request->key)->first();

        try {

            $screenshot = $this->captureService
                            ->height($request->get('height', null))
                            ->width($request->get('width', null))
                            ->delay($request->get('delay', 1))
                            ->url(new Url($request->url))
                            ->capture();

            $apiKey->apiLogs()->create([
                'user_id' => $request->user()->first()->id,
                'images' => $screenshot->getPath(),
            ]);

            return response()->json([
                'path'       => $screenshot->getPublicUrl(),
                'base64'     => 'data:image/jpg;base64,'.base64_encode($screenshot->getBase64()),
                'base64_raw' => $screenshot->getBase64(),
            ]);

        } catch (Exception $e) {

            return response()->json([
                'title' => 'An error accoured',
                'message' => 'An internal error accoured.',
                'error' => [
                    'status' => 500,
                    'detail' => $e->getMessage(),
                ]
            ], 500);

        }


    }
}
