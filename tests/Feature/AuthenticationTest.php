<?php
namespace Tests\Feature;

// RefreshDatabase: prepares a clean temporary database for each test.
use Illuminate\Foundation\Testing\RefreshDatabase;

// User: creates test administrator accounts.
use App\Models\User;

// TestCase: provides Laravel testing tools.
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    // Keep authentication tests separate from the real database.
    use RefreshDatabase;

    // The login page should be visible to guests.
    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    // Correct credentials should authenticate the administrator.
    public function test_administrator_can_log_in(): void
    {
        // Create a test account using the factory.
        $user = User::factory()->create();

        // Submit the correct login details.
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Confirm successful login and redirection.
        $response->assertRedirect(route('customers.index'));

        // Confirm Laravel recognizes this administrator as logged in.
        $this->assertAuthenticatedAs($user);
    }

    // Incorrect credentials must not authenticate anyone.
    public function test_administrator_cannot_log_in_with_wrong_password(): void
    {
        // Create a test administrator.
        $user = User::factory()->create();

        // Submit an incorrect password.
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        // Confirm that the login form displays an email error.
        $response->assertSessionHasErrors('email');

        // Confirm the visitor remains unauthenticated.
        $this->assertGuest();
    }

    // Logging out should end the authenticated session.
    public function test_administrator_can_log_out(): void
    {
        // Create a test administrator.
        $user = User::factory()->create();

        // Log in as that administrator and submit the logout request.
        $response = $this->actingAs($user)->post('/logout');

        // Confirm the browser is redirected to the login page.
        $response->assertRedirect(route('login'));

        // Confirm the administrator is no longer authenticated.
        $this->assertGuest();
    }
}