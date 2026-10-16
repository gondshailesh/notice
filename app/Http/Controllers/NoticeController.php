<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a single notice.
     */
    public function show(Notice $notice)
    {
        // Only show active notices to students
        abort_unless($notice->is_active, 404);

        // Related notices (same category, excluding current)
        $related = Notice::where('category', $notice->category)
            ->where('id', '!=', $notice->id)
            ->where('is_active', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('notices.show', compact('notice', 'related'));
    }

    /**
     * Download the attachment for a notice.
     */
    public function download(Notice $notice)
    {
        abort_unless(
            $notice->attachment_path && Storage::disk('public')->exists($notice->attachment_path),
            404,
            'Attachment not found.'
        );

        return Storage::disk('public')->download($notice->attachment_path);
    }
}