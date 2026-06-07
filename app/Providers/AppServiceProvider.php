<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;
use App\Models\PersonRoleMapping;
use App\Models\UnitPeople;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Inertia::share('auth.user', function () {
            if (Auth::check()) {
                $user = Auth::user();
                $person = Person::find($user->person_id);

                if (!$person) {
                    return ['id' => '0000-0000-0000', 'fullname' => 'TelUtizen', 'firstname' => 'TelUtizen'];
                }

                return [
                    'id'       => $person->id,
                    'fullname' => $person->person,
                    'firstname' => explode(' ', $person->person)[0], // ← fix bug: explode butuh 2 argumen
                ];
            }
            else{
                return [
                    'id'       => '0000-0000-0000',
                    'fullname' => 'TelUtizen',
                    'firstname' => 'TelUtizen'
                ];
            }
        });

        Inertia::share('profile', function () {
            if (Auth::check()) {
                $user = Auth::user();
                $person = Person::with('unitPeople.unit')->find($user->person_id);

                if (!$person) {
                    return ['id' => '0000-0000-0000'];
                }

                $role = PersonRoleMapping::where('person_id', $person->id)->first();

                return [
                    'id'       => $person->id,
                    'fullname' => $person->person,
                    'username' => $person->per_id,
                    'email' => $person->per_email,
                    'phone' => $person->per_phone,
                    'photo' => $person->per_photo,
                    'nim' => $person->per_num,
                    'role_id' => $role?->role_id ?? null,
                    'unit_id' => $person->unitPeople?->unit->id
                ];
            } else {
                return [
                    'id' => '0000-0000-0000',
                ];
            }
        });
    }
}
