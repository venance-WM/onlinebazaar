<?php

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Redirect user when login according to roles
        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request): RedirectResponse
            {
                $role = Auth::user()->role;
                $hashedPassword = Auth::user()->password;

                if ($role === 0) {
                    return redirect()->to('/dashboard');
                } elseif ($role === 1) {
                    if (Hash::check('123456', $hashedPassword)) {
                        return redirect()->route('agent.dashboard')->with('login-alert', 'Change your password to continue.');
                    } else {
                        return redirect()->route('agent.dashboard');
                    }
                } elseif ($role === 2) {
                    return redirect()->route('seller.dashboard');
                } else {
                    return redirect()->route('home');
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // Check if the user's status is enabled
                if ($user->status == 'disabled') {
                    throw ValidationException::withMessages([
                        'email' => ['Your account has been disabled by the admin. Please contact your admin.'],
                    ]);
                }
                if (Hash::check($request->password, $user->password)) {
                    return $user;
                }
            }

            return null;
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
