<?php

namespace App\Models;

use App\Notifications\NoticePosted;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    /**
     * Mass-assignable attributes.
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'priority',
        'target_semester',
        'attachment_path',
        'is_active',
        'published_at',
        'user_id',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'is_active'    => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * The user (admin) who posted the notice.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The 12 notice categories used across the portal.
     */
    public static function categories(): array
    {
        return [
            'academic'       => 'Academic Notices',
            'examination'    => 'Examination Notices',
            'admission'      => 'Admission & Registration',
            'event'          => 'Event & Cultural Activities',
            'sports'         => 'Sports Notices',
            'placement'      => 'Placement & Career',
            'administrative' => 'Administrative Notices',
            'library'        => 'Library Notices',
            'scholarship'    => 'Scholarship & Finance',
            'general'        => 'General',
            'urgent'         => 'Urgent Notices',
            'must_read'      => 'Must Read',
        ];
    }

    /**
     * Alias for categories() — supports older code using Notice::CATEGORIES.
     */
    public const CATEGORIES = [
        'academic'       => 'Academic Notices',
        'examination'    => 'Examination Notices',
        'admission'      => 'Admission & Registration',
        'event'          => 'Event & Cultural Activities',
        'sports'         => 'Sports Notices',
        'placement'      => 'Placement & Career',
        'administrative' => 'Administrative Notices',
        'library'        => 'Library Notices',
        'scholarship'    => 'Scholarship & Finance',
        'general'        => 'General',
        'urgent'         => 'Urgent Notices',
        'must_read'      => 'Must Read',
    ];

    /**
     * Scope: only active notices.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: only urgent notices.
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'Urgent');
    }

    /**
     * Send Telegram notification on notice create/update.
     */
    protected static function booted()
    {
        static::created(function ($notice) {
            try {
                Notification::route('telegram', config('services.telegram.chat_id'))
                    ->notify(new NoticePosted($notice->id));
            } catch (\Exception $e) {
                Log::error('Telegram notice failed (created): ' . $e->getMessage());
            }
        });

        static::updated(function ($notice) {
            if ($notice->isDirty(['title', 'description', 'priority'])) {
                try {
                    Notification::route('telegram', config('services.telegram.chat_id'))
                        ->notify(new NoticePosted($notice->id));
                } catch (\Exception $e) {
                    Log::error('Telegram notice failed (updated): ' . $e->getMessage());
                }
            }
        });
    }
}