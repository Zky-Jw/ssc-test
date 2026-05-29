<?php

namespace App\Http\Requests\Auth;

use App\Models\Person;
use App\Models\User;
use App\Models\PersonRoleMapping;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Services\SatuService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'captcha' => ['required', 'captcha']
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $request = $this;

        $data = [
            'username' => explode("@", $request->username)[0],
            'password' => $request->password
        ];

        if (config('app.env') === 'local') {
            if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'username' => trans('auth.failed'),
                ]);
            }
        } else {
            $satuService = new SatuService;
            $login = $satuService->login($data);

            if (isset($login->error)) {
                throw ValidationException::withMessages([
                    'username' => $login->error,
                ]);
}

            if (!isset($login->token)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'username' =>  $login->message ?? trans('auth.failed'),
                ]);
            } else {
                View::share('TOKEN', $login->token);
                $profile = $satuService->profile(View::shared('TOKEN'));

                if (!isset($profile->numberid)) {
                    RateLimiter::hit($this->throttleKey());

                    throw ValidationException::withMessages([
                        'password' => trans('auth.failed'),
                    ]);
                }

                $exUser = User::where('username', $profile->user)->first();
                $exPerson = Person::where('per_id', $profile->user)->first();

                // Check user
                if ($exUser) {
                    $exUser->username = $profile->user;
                    $exPerson->per_num = $profile->numberid;
                    $exPerson->per_id = $profile->user;
                    $exPerson->per_photo = $profile->photo;
                    $exUser->save();
                    $exPerson->save();
                } else {
                    $exUser = new User;
                    $exPerson = new Person;

                    $exPerson->person = $profile->fullname; //fullname
                    $exPerson->per_num = $profile->numberid; //nim / nip
                    $exPerson->per_id = $profile->user; //username
                    $exPerson->per_phone = $profile->phone ?? '-';
                    $exPerson->per_group = $profile->studyprogram ? "MAHASISWA" :  "PEGAWAI";
                    $exPerson->per_photo = $profile->photo;
                    $exPerson->per_major = $profile->studyprogram;
                    $exPerson->per_faculty = $profile->faculty;
                    $exPerson->per_email = $profile->email ?? $profile->user . "@telkomuniversity.ac.id"; //email
                    $exUser->username = $profile->user;
                    $exPerson->save();

                    $newPerson = Person::where('person', $profile->fullname)->first();

                    $exUser->person_id = $newPerson->id;
                    $exUser->password = Hash::make($profile->numberid);
                    $exUser->save();

                    $roleId = $profile->studyprogram ? '101' : '102';
                    $newPerson->roles()->syncWithoutDetaching([$roleId]);
                }
                Auth::login($exUser, true);
            }
        }


        // if(explode("@", $request->username)[0] == "admin" &&  $request->password = "@admin"){
        // }



        // $postdata = http_build_query(
        //     array(
        //         'textUsername' => $this->input('username'),
        //         'textPassword' => $this->input('password'),
        //     )
        // );
        // $opts = array('http' => array(
        //     'method' => 'POST',
        //     'header' => 'Content-Type: application/x-www-form-urlencoded',
        //     'content' => $postdata,
        // ),
        // );
        // $context = stream_context_create($opts);

        // $user = file_get_contents("https://igracias.ittelkom-sby.ac.id/api_login.php", false, $context);
        // switch ($user) {
        //     case '404':
        //         RateLimiter::hit($this->throttleKey());
        //         throw ValidationException::withMessages([
        //             'account' => trans('auth.failed'),
        //         ]);
        //         break;
        //     case '500':
        //         RateLimiter::hit($this->throttleKey());
        //         throw ValidationException::withMessages([
        //             'access' => trans('auth.failed'),
        //         ]);
        //         break;
        //     case '401':
        //         RateLimiter::hit($this->throttleKey());
        //         throw ValidationException::withMessages([
        //             'account' => trans('auth.failed'),
        //         ]);
        //         break;
        //     case '202':
        //         RateLimiter::hit($this->throttleKey());
        //         throw ValidationException::withMessages([
        //             'empty' => trans('auth.failed'),
        //         ]);
        //         break;
        //     default:
        //         $userCheck = User::where('username', $this->input('username'))->first();
        //         Auth::login($userCheck, $this->boolean('remember'));
        //         break;
        // }

        RateLimiter::clear($this->throttleKey());
    }
    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('username')) . '|' . $this->ip());
    }
}