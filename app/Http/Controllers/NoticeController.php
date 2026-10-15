<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
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