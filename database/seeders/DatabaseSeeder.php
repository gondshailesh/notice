<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create the admin user (no factory needed)
        $admin = User::updateOrCreate(
            ['email' => 'admin@scs.edu'],
            [
                'name'                => 'Admin User',
                'username'            => 'admin',
                'phone'               => '9999999999',
                'aadhaar_no'          => '111122223333',
                'dob'                 => '1990-01-01',
                'course'              => 'Staff',
                'college_internet_id' => 'admin.scs.edu',
                'password'            => Hash::make('admin123'),
                'role'                => 1,
                'email_verified_at'   => now(),
            ]
        );

        // Create one sample notice per category
        $categories = array_keys(Notice::CATEGORIES ?? [
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
        ]);

        foreach ($categories as $cat) {
            Notice::create([
                'user_id'         => $admin->id,
                'title'           => 'Sample ' . ucfirst(str_replace('_', ' ', $cat)) . ' Notice',
                'description'     => "This is a demo notice for the '{$cat}' category. You can delete this and post real notices from the admin panel.",
                'category'        => $cat,
                'target_semester' => 'all',
                'priority'        => ($cat === 'urgent') ? 'Urgent' : 'Normal',
            ]);
        }
    }
}