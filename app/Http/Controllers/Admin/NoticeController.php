<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    /**
     * Admin dashboard — recent notices with per-page + filters.
     * Supports: ?search=, ?category=, ?date_from=, ?date_to=, ?per_page=
     */
    public function dashboard(Request $request)
    {
        if ($request->filled('per_page')) {
            session(['admin_per_page' => (int) $request->per_page]);
        }

        $perPage = (int) session('admin_per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $query = Notice::latest();

        /* ─── Search ─── */
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($w) use ($s) {
                $w->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        /* ─── Category ─── */
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        /* ─── DATE FILTER (published_at) ─── */
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $notices = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total_notices' => Notice::count(),
            'total_users'   => User::count(),
            'students'      => User::where('role', 0)->count(),
            'urgent'        => Notice::where('priority', 'Urgent')->count(),
            'this_week'     => Notice::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
        ];

        return view('admin.dashboard', compact('notices', 'stats'));
    }

    /**
     * Notices index — supports ?priority=urgent, ?category=..., ?per_page=...
     */
    public function index(Request $request)
    {
        if ($request->filled('per_page')) {
            session(['admin_per_page' => (int) $request->per_page]);
        }

        $perPage = (int) session('admin_per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $query = Notice::latest();

        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($w) use ($s) {
                $w->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $notices = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total_notices' => Notice::count(),
            'total_users'   => User::count(),
            'students'      => User::where('role', 0)->count(),
            'urgent'        => Notice::where('priority', 'Urgent')->count(),
            'this_week'     => Notice::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
        ];

        return view('admin.notices.index', [
            'notices'     => $notices,
            'stats'       => $stats,
            'categoryMap' => Notice::categories(),
        ]);
    }

    /**
     * Show the create notice form.
     */
    public function create()
    {
        return view('admin.notices.create', [
            'categories' => Notice::categories(),
        ]);
    }

    /**
     * Store a new notice.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category'        => 'required|string',
            'priority'        => 'required|in:Normal,High,Urgent',
            'target_semester' => 'nullable|string|max:50',
            'attachment'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'published_at'    => 'nullable|date',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')
                ->store('notices', 'public');
        }

        $data['published_at'] = $request->filled('published_at')
            ? $request->published_at
            : now();
        $data['user_id']   = auth()->id();
        $data['is_active'] = true;

        Notice::create($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Notice posted successfully.');
    }

    /**
     * Show the edit notice form.
     */
    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', [
            'notice'     => $notice,
            'categories' => Notice::categories(),
        ]);
    }

    /**
     * Update an existing notice.
     */
    public function update(Request $request, Notice $notice)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'category'        => 'required|string',
            'priority'        => 'required|in:Normal,High,Urgent',
            'target_semester' => 'nullable|string|max:50',
            'attachment'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'published_at'    => 'nullable|date',
        ]);

        if ($request->hasFile('attachment')) {
            if ($notice->attachment_path) {
                Storage::disk('public')->delete($notice->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')
                ->store('notices', 'public');
        }

        $notice->update($data);

        return redirect()
            ->route('admin.dashboard')
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

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Notice deleted successfully.');
    }
}