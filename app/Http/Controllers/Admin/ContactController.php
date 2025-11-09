<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $messages = ContactMessage::query()->select(['id', 'name', 'email', 'company', 'phone', 'status', 'created_at']);

            return DataTables::of($messages)
                ->editColumn('created_at', fn (ContactMessage $message) => $message->created_at->format('d M Y H:i'))
                ->toJson();
        }

        return view('admin.contacts.index');
    }

    public function show(ContactMessage $contact)
    {
        return response()->json([
            'success' => true,
            'data' => $contact,
        ]);
    }

    public function updateStatus(Request $request, ContactMessage $contact)
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,read,archived'],
        ]);

        $contact->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Message updated successfully.',
            'data' => $contact,
        ]);
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully.',
        ]);
    }

    public function export()
    {
        $filename = 'contact-messages-' . now()->format('Ymd-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Company', 'Phone', 'Status', 'Message', 'Created At']);

            ContactMessage::orderByDesc('created_at')->chunk(200, function ($messages) use ($handle) {
                foreach ($messages as $message) {
                    fputcsv($handle, [
                        $message->id,
                        $message->name,
                        $message->email,
                        $message->company,
                        $message->phone,
                        $message->status,
                        $message->message,
                        optional($message->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
