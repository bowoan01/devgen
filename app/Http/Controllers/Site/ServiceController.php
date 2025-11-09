<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()->ordered()->get();

        return view('site.services', compact('services'));
    }

    public function show(Service $service)
    {
        $related = Service::query()
            ->whereKeyNot($service->getKey())
            ->ordered()
            ->take(3)
            ->get();

        return view('site.service-show', [
            'service' => $service,
            'related' => $related,
        ]);
    }
}
