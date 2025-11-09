<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $members = TeamMember::query()->select(['id', 'name', 'role_title', 'linkedin_url', 'sort_order', 'created_at', 'updated_at']);

            return DataTables::of($members)
                ->editColumn('updated_at', fn (TeamMember $member) => $member->updated_at?->format('d M Y H:i'))
                ->toJson();
        }

        return view('admin.teams.index');
    }

    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('uploads/team', 'public');
        }

        $member = TeamMember::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Team member created successfully.',
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

    public function update(UpdateTeamMemberRequest $request, TeamMember $team)
    {
        $data = $request->validated();

        if ($request->boolean('remove_photo') && $team->photo_path) {
            Storage::disk('public')->delete($team->photo_path);
            $data['photo_path'] = null;
        }

        if ($request->hasFile('photo')) {
            if ($team->photo_path) {
                Storage::disk('public')->delete($team->photo_path);
            }

            $data['photo_path'] = $request->file('photo')->store('uploads/team', 'public');
        }

        $team->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Team member updated successfully.',
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
            'message' => 'Team member removed successfully.',
        ]);
    }
}
