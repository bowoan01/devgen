<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'serviceCount' => Service::count(),
            'projectCount' => Project::count(),
            'teamCount' => TeamMember::count(),
            'unreadContacts' => ContactMessage::query()->where('status', ContactMessage::STATUS_NEW)->count(),
        ]);
    }
}
