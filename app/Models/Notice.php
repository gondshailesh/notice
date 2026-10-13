<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'target_semester',
        'priority',
        'attachment_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
}