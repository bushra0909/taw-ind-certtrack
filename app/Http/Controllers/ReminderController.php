<?php
namespace App\Http\Controllers;

// CertificateReminder: retrieves prepared reminder records.
use App\Models\CertificateReminder;

// CertificateReminderService: prepares 30-day and 7-day reminders.
use App\Services\CertificateReminderService;

// RedirectResponse: describes the response after preparing reminders.
use Illuminate\Http\RedirectResponse;

class ReminderController extends Controller
{
    // Display all prepared reminder records.
    public function index()
    {
        // Load certificate and customer details for every reminder.
        $reminders = CertificateReminder::with('certificate.customer')
            ->latest()
            ->get();

        // Show the reminder page with its records.
        return view('reminders.index', compact('reminders'));
    }

    // Prepare reminder records for certificates approaching inspection.
    public function prepare(CertificateReminderService $reminderService): RedirectResponse
    {
        // Ask the service to create any missing 30-day or 7-day reminders.
        $createdCount = $reminderService->prepareReminders();

        // Return to the reminder page with a clear result message.
        return redirect()
            ->route('reminders.index')
            ->with(
                'success',
                $createdCount . ' new reminder record(s) prepared.'
            );
    }
}
