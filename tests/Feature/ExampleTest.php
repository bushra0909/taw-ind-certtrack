<?php
namespace Tests\Feature;

// RefreshDatabase prepares a clean test database for each test.
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    // Use the temporary test database, not your actual MySQL database.
    use RefreshDatabase;

    public function test_homepage_redirects_to_customers(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/customers');
    }

    public function test_customer_management_page_loads(): void
    {
        $response = $this->get('/customers');

        $response->assertStatus(200);
    }
}
