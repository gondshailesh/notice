<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Override the trait's register() so we can:
     *  1. Fire the Registered event (triggers verification email)
     *  2. Log the user in
     *  3. Redirect to /home
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 1. Full name as per 12th marksheet
            'name' => [
                'required','string','min:3','max:100',
                'regex:/^[A-Za-z][A-Za-z .\'-]*$/',
            ],

            // 2. Email linked with Aadhaar
            'email' => [
                'required','string','email:rfc,dns','max:255','unique:users',
            ],

            // 3. Phone — 10 digits, starts 6-9
            'phone' => [
                'required','digits:10','unique:users',
                'regex:/^[6-9]\d{9}$/',
            ],

            // 4. Aadhaar — 12 digits, cannot start with 0/1
            'aadhaar_no' => [
                'required','digits:12','unique:users',
                'regex:/^[2-9]\d{11}$/',
            ],

            // 5. DOB — 18+ only
            'dob' => ['required','date','before:-18 years'],

            // 6. Course dropdown (year-wise)
            'course' => [
                'required','string',
                'in:BCA - First Year,BCA - Second Year,BCA - Third Year,' .
                     'BSc CS - First Year,BSc CS - Second Year,BSc CS - Third Year,' .
                     'BSc IT - First Year,BSc IT - Second Year,BSc IT - Third Year,' .
                     'BSc Computer Application - First Year,BSc Computer Application - Second Year,BSc Computer Application - Third Year,' .
                     'MCA - First Year,MCA - Second Year,' .
                     'MSc CS - First Year,MSc CS - Second Year,' .
                     'MSc IT - First Year,MSc IT - Second Year,' .
                     'MSc Data Science - First Year,MSc Data Science - Second Year,' .
                     'PG Diploma,Other',
            ],

            // 7. College Internet ID (optional)
            'college_internet_id' => ['nullable','string','max:100'],

            // 8. Username
            'username' => [
                'required','string','min:4','max:20','unique:users',
                'regex:/^[a-zA-Z][a-zA-Z0-9._]*$/',
            ],

            // 9. Password — 8–16 chars strong
            'password' => [
                'required','string','min:8','max:16','confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            ],
        ], [
            'name.regex'         => 'Full name must match your 12th marksheet (letters, spaces and dots only).',
            'email.email'        => 'Enter a valid email address linked with your Aadhaar.',
            'phone.digits'       => 'Phone number must be exactly 10 digits.',
            'phone.regex'        => 'Phone number must start with 6, 7, 8 or 9.',
            'aadhaar_no.digits'  => 'Aadhaar number must be exactly 12 digits.',
            'aadhaar_no.regex'   => 'Aadhaar number cannot start with 0 or 1.',
            'dob.before'         => 'You must be at least 18 years old to register.',
            'course.in'          => 'Please select a valid course from the list.',
            'username.regex'     => 'Username must start with a letter and may contain letters, numbers, dots or underscores.',
            'password.regex'     => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
            'password.min'       => 'Password must be at least 8 characters.',
            'password.max'       => 'Password cannot be longer than 16 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name'                => $data['name'],
            'username'            => $data['username'],
            'email'               => $data['email'],
            'phone'               => $data['phone'],
            'aadhaar_no'          => $data['aadhaar_no'],
            'dob'                 => $data['dob'],
            'course'              => $data['course'],
            'college_internet_id' => $data['college_internet_id'] ?? null,
            'password'            => Hash::make($data['password']),
            'role'                => 0,
        ]);
    }

    /**
     * After registration (and auto-login), redirect by role.
     * New registrations are always students → /dashboard.
     */
    protected function redirectTo()
    {
        return '/dashboard';
    }
}