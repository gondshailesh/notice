<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Admin dashboard — list all notices with stats.
     */
    public function dashboard()
    {
        $notices = Notice::with('user')->latest()->paginate(15);

        $stats = [
            'total_notices' => Notice::count(),
            'total_users'   => \App\Models\User::count(),
            'urgent'        => Notice::where('priority', 'Urgent')->count(),
            'must_read'     => Notice::where('category', 'must_read')->count(),
            'this_week'     => Notice::where('created_at', '>=', now()->subDays(7))->count(),
            'students'      => \App\Models\User::where('role', 0)->count(),
        ];

        return view('admin.dashboard', compact('notices','stats'));
    }

    /**
     * Show the create-notice form.
     */
    public function create()
    {
        return view('admin.notices.create');
    }

    /**
     * Store a new notice.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category'        => 'required|in:' . implode(',', array_keys(Notice::CATEGORIES)),
            'target_semester' => 'nullable|string|max:50',
            'priority'        => 'nullable|in:Normal,Urgent',
            'attachment'      => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('notices', 'public');
        }

        Notice::create([
            'user_id'         => Auth::id(),
            'title'           => $data['title'],
            'description'     => $data['description'],
            'category'        => $data['category'],
            'target_semester' => $data['target_semester'] ?? 'all',
            'priority'        => $data['priority'] ?? 'Normal',
            'attachment_path' => $path,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Notice posted successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    /**
     * Update a notice.
     */
    public function update(Request $request, Notice $notice)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category'        => 'required|in:' . implode(',', array_keys(Notice::CATEGORIES)),
            'target_semester' => 'nullable|string|max:50',
            'priority'        => 'nullable|in:Normal,Urgent',
            'attachment'      => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        if ($request->hasFile('attachment')) {
            if ($notice->attachment_path) {
                Storage::disk('public')->delete($notice->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')->store('notices', 'public');
        }

        $notice->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Notice updated successfully.');
    }

    /**
     * Delete a notice.
     */
    public function destroy(Notice $notice)
    {
        if ($notice->attachment_path) {
            Storage::disk('public')->delete($notice->attachment_path);
        }
        $notice->delete();

        return back()->with('success', 'Notice deleted.');
    }
}