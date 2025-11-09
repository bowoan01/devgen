<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.services.index');
    }

    public function data()
    {
        return DataTables::of(Service::query()->select(['id', 'title', 'slug', 'display_order', 'is_featured']))
            ->editColumn('is_featured', fn (Service $service) => $service->is_featured ? 'Yes' : 'No')
            ->addColumn('actions', function (Service $service) {
                return view('admin.services.partials.actions', compact('service'))->render();
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function store(ServiceRequest $request)
    {
        $nextOrder = (Service::max('display_order') ?? 0) + 1;

        $service = Service::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'excerpt' => $request->input('excerpt'),
            'body' => $request->input('body'),
            'icon_class' => $request->input('icon_class'),
            'display_order' => (int) $request->input('display_order', $nextOrder),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service created successfully.',
            'data' => $service,
        ]);
    }

    public function show(Service $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'excerpt' => $request->input('excerpt'),
            'body' => $request->input('body'),
            'icon_class' => $request->input('icon_class'),
            'display_order' => (int) $request->input('display_order', $service->display_order),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully.',
            'data' => $service->fresh(),
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service removed.',
        ]);
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $serviceId) {
            Service::whereKey($serviceId)->update(['display_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated.',
        ]);
    }
}
