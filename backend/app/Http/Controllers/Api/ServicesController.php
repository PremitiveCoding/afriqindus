<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with(['category:id,name'])->latest()->simplePaginate($request->get('limit', 6));

        return ServiceResource::collection($services);
    }

    public function show(Request $request, Service $service)
    {
        $service->load(['category:id,name']);

        return new ServiceResource($service);
    }
}
