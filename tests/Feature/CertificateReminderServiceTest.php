<?php
namespace Tests\Feature;

// Carbon: lets us control today's date during testing.
use Carbon\Carbon;

// Certificate: creates test certificate records.
use App\Models\Certificate;

// Customer: creates test customer records.
use App\Models\Customer;

// CertificateReminder: checks saved reminder records.
use App\Models\CertificateReminder;

// RefreshDatabase: prepares a clean temporary test database.
use Illuminate\Foundation\Testing\RefreshDatabase;

// TestCase: provides Laravel testing tools.
use Tests\TestCase;

// CertificateReminderService: contains the reminder preparation logic.
use App\Services\CertificateReminderService;

class CertificateReminderServiceTest extends TestCase
{
    // Use SQLite in-memory instead of the real MySQL database.
    use RefreshDatabase;

    // Freeze today's date so our tests produce predictable results.
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2026-11-20 10:00:00');
    }

    // Reset the frozen date after each test.
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    // Test that both 30-day and 7-day reminders are created.
    public function test_it_prepares_30_day_and_7_day_reminders(): void
    {
        $this->createCertificate(30, 'CERT-30');
        $this->createCertificate(7, 'CERT-07');

        $service = new CertificateReminderService();

        $createdCount = $service->prepareReminders();

        $this->assertSame(2, $createdCount);

        $this->assertDatabaseHas('certificate_reminders', [
            'reminder_type' => '30_day',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('certificate_reminders', [
            'reminder_type' => '7_day',
            'status' => 'pending',
        ]);
    }

    // Test that certificates outside the reminder dates are ignored.
    public function test_it_does_not_prepare_reminders_for_other_dates(): void
    {
        $this->createCertificate(15, 'CERT-15');

        $service = new CertificateReminderService();

        $createdCount = $service->prepareReminders();

        $this->assertSame(0, $createdCount);

        $this->assertDatabaseCount('certificate_reminders', 0);
    }

    // Test that running the service twice does not create duplicates.
    public function test_it_does_not_create_duplicate_reminders(): void
    {
        $this->createCertificate(30, 'CERT-DUPLICATE');

        $service = new CertificateReminderService();

        $firstRun = $service->prepareReminders();
        $secondRun = $service->prepareReminders();

        $this->assertSame(1, $firstRun);
        $this->assertSame(0, $secondRun);

        $this->assertDatabaseCount('certificate_reminders', 1);
    }

    // Helper: create a customer and a certificate for a chosen date.
    private function createCertificate(
        int $daysUntilInspection,
        string $certificateNumber
    ): Certificate {
        $customer = Customer::create([
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '03001234567',
            'address' => 'Test Address',
        ]);

        return Certificate::create([
            'customer_id' => $customer->id,
            'certificate_number' => $certificateNumber,
            'issue_date' => Carbon::today()->subYear()->toDateString(),
            'next_inspection_date' => Carbon::today()
                ->addDays($daysUntilInspection)
                ->toDateString(),
            'booking_url' => null,
        ]);
    }
}
