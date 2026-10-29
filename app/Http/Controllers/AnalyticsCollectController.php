<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectPageViewRequest;
use App\Support\Analytics\PageViewRecorder;
use Illuminate\Http\Response;
use Throwable;

class AnalyticsCollectController extends Controller
{
    public function store(CollectPageViewRequest $request, PageViewRecorder $recorder): Response
    {
        try {
            $recorder->record($request, $request->validated());
        } catch (Throwable $exception) {
            report($exception);
        }

        return response()->noContent();
    }
}
