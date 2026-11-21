<?php
namespace App\Http\Controllers\Auth;
// Controller: provides the base class for application controllers.
use App\Http\Controllers\Controller;
// Auth: checks login credentials and manages the login session.
use Illuminate\Support\Facades\Auth;

// Request: receives the submitted email and password.
use Illuminate\Http\Request;

// RedirectResponse: describes the response after login or logout.
use Illuminate\Http\RedirectResponse;

// View: describes the login page response.
use Illuminate\View\View;

// AuthenticatedSessionController: handles administrator login and logout.
class AuthenticatedSessionController extends Controller
{
    // Display the administrator login page.
    public function create(): View
    {
        return view('auth.login');
    }

    // Check the submitted credentials and log in the administrator.
    public function store(Request $request): RedirectResponse
    {
        // Validate the email and password fields.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate the user using Laravel.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // Regenerate the session ID after successful login.
            $request->session()->regenerate();

            // Redirect to the page the administrator originally requested.
            return redirect()->intended(route('customers.index'));
        }

        // Return an error if the email or password is incorrect.
        return back()
            ->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ])
            ->onlyInput('email');
    }

    // Log out the administrator securely.
    public function destroy(Request $request): RedirectResponse
    {
        // Log out the currently authenticated user.
        Auth::logout();

        // Invalidate the old session.
        $request->session()->invalidate();

        // Generate a new CSRF token.
        $request->session()->regenerateToken();

        // Return to the login page.
        return redirect()->route('login');
    }
}
