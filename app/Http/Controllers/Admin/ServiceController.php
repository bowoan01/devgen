<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::query()->select(['id', 'title', 'slug', 'excerpt', 'icon_class', 'display_order', 'is_featured', 'created_at', 'updated_at']);

            return DataTables::of($services)
                ->addColumn('featured_label', fn (Service $service) => $service->is_featured ? 'Yes' : 'No')
                ->editColumn('updated_at', fn (Service $service) => $service->updated_at?->format('d M Y H:i'))
                ->toJson();
        }

        return view('admin.services.index');
    }

    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->validated());

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

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

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
            'message' => 'Service deleted successfully.',
        ]);
    }
}
