<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    public function index()
    {
        return view('admin.teams.index');
    }

    public function data()
    {
        return DataTables::of(TeamMember::query()->select(['id', 'name', 'role_title', 'linkedin_url', 'sort_order']))
            ->addColumn('actions', fn (TeamMember $member) => view('admin.teams.partials.actions', compact('member'))->render())
            ->editColumn('linkedin_url', fn (TeamMember $member) => $member->linkedin_url ? '<a href="'.$member->linkedin_url.'" target="_blank">Profile</a>' : '—')
            ->rawColumns(['actions', 'linkedin_url'])
            ->toJson();
    }

    public function store(TeamMemberRequest $request)
    {
        $photoPath = $request->file('photo')?->store('uploads/team', 'public');
        $nextOrder = (TeamMember::max('sort_order') ?? 0) + 1;
        $sortOrder = $request->filled('sort_order') ? (int) $request->input('sort_order') : $nextOrder;

        $member = TeamMember::create([
            'name' => $request->input('name'),
            'role_title' => $request->input('role_title'),
            'linkedin_url' => $request->input('linkedin_url'),
            'photo_path' => $photoPath,
            'bio' => $request->input('bio'),
            'sort_order' => $sortOrder,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Team member created.',
            'data' => $member,
        ]);
    }

    public function show(TeamMember $team)
    {
        return response()->json([
            'success' => true,
            'data' => $team,
        ]);
    }

    public function update(TeamMemberRequest $request, TeamMember $team)
    {
        $payload = [
            'name' => $request->input('name'),
            'role_title' => $request->input('role_title'),
            'linkedin_url' => $request->input('linkedin_url'),
            'bio' => $request->input('bio'),
            'sort_order' => $request->filled('sort_order') ? (int) $request->input('sort_order') : $team->sort_order,
        ];

        if ($request->hasFile('photo')) {
            if ($team->photo_path) {
                Storage::disk('public')->delete($team->photo_path);
            }
            $payload['photo_path'] = $request->file('photo')->store('uploads/team', 'public');
        }

        $team->update($payload);

        return response()->json([
            'success' => true,
            'message' => 'Team member updated.',
            'data' => $team->fresh(),
        ]);
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo_path) {
            Storage::disk('public')->delete($team->photo_path);
        }

        $team->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team member removed.',
        ]);
    }

    public function reorder()
    {
        $order = request()->input('order', []);

        foreach ($order as $index => $id) {
            TeamMember::whereKey($id)->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Team order updated.',
        ]);
    }
}
