<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index');
    }

    public function data()
    {
        return DataTables::of(ContactMessage::query()->select(['id', 'name', 'email', 'company', 'status', 'created_at']))
            ->editColumn('created_at', fn (ContactMessage $message) => $message->created_at->format('d M Y H:i'))
            ->addColumn('actions', fn (ContactMessage $message) => view('admin.contacts.partials.actions', compact('message'))->render())
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function show(ContactMessage $contact)
    {
        return response()->json([
            'success' => true,
            'data' => $contact,
        ]);
    }

    public function updateStatus(ContactMessage $contact)
    {
        $status = request('status');
        abort_unless(in_array($status, [ContactMessage::STATUS_NEW, ContactMessage::STATUS_READ, ContactMessage::STATUS_ARCHIVED], true), 422);

        $contact->update(['status' => $status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated.',
            'data' => $contact->fresh(),
        ]);
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message removed.',
        ]);
    }

    public function export(): StreamedResponse
    {
        $filename = 'contact-messages-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Company', 'Phone', 'Status', 'Created At']);

            ContactMessage::orderByDesc('created_at')->chunk(200, function ($messages) use ($handle) {
                foreach ($messages as $message) {
                    fputcsv($handle, [
                        $message->id,
                        $message->name,
                        $message->email,
                        $message->company,
                        $message->phone,
                        $message->status,
                        $message->created_at->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
