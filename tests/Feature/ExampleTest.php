<?php
namespace Tests\Feature;

// RefreshDatabase: prepares a clean temporary database for each test.
use Illuminate\Foundation\Testing\RefreshDatabase;

// User: creates a test administrator account.
use App\Models\User;

// TestCase: provides Laravel's testing tools.
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // Use the temporary test database, not the actual MySQL database.
    use RefreshDatabase;

    // Guests should be redirected to login when visiting the homepage.
    public function test_homepage_redirects_guests_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    // Guests should not be able to open customer management.
    public function test_customer_management_redirects_guests_to_login(): void
    {
        $response = $this->get('/customers');

        $response->assertRedirect('/login');
    }

    // Authenticated administrators should reach customer management from the homepage.
    public function test_authenticated_homepage_redirects_to_customers(): void
    {
        // Create a test administrator.
        $user = User::factory()->create();

        // Act as the administrator and visit the homepage.
        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect('/customers');
    }

    // Authenticated administrators should be able to open customer management.
    public function test_authenticated_customer_management_page_loads(): void
    {
        // Create a test administrator.
        $user = User::factory()->create();

        // Act as the administrator and open the customer page.
        $response = $this->actingAs($user)->get('/customers');

        $response->assertStatus(200);
    }

        // Guests should not access certificate management.
    public function test_certificate_management_redirects_guests_to_login(): void
    {
        $response = $this->get('/certificates');

        $response->assertRedirect('/login');
    }

    // Guests should not access reminder management.
    public function test_reminder_management_redirects_guests_to_login(): void
    {
        $response = $this->get('/reminders');

        $response->assertRedirect('/login');
    }
}