<?php
namespace App\Services;

// Certificate: lets us find certificates and their inspection dates.
use App\Models\Certificate;

// CertificateReminder: lets us save reminder records in the database.
use App\Models\CertificateReminder;

// Carbon: helps us compare dates.
use Carbon\Carbon;

class CertificateReminderService
{
    /**
     * Find certificates that need renewal reminders.
     * Create a reminder record without sending an SMS.
     */
    public function prepareReminders(): int
    {
        // Start with today's date, without the current time.
        $today = Carbon::today();

        // Get all certificates together with their customers.
        $certificates = Certificate::with('customer')->get();

        // Count how many new reminders we create.
        $createdCount = 0;

        // Check each certificate one by one.
        foreach ($certificates as $certificate) {

            // Get the next inspection date.
            $inspectionDate = $certificate->next_inspection_date;

            // Calculate how many days remain until inspection.
            $daysRemaining = (int) $today->diffInDays(
                $inspectionDate->copy()->startOfDay(),
                false
            );

            // Decide which reminder is required.
            if ($daysRemaining === 30) {
                $reminderType = '30_day';
            } elseif ($daysRemaining === 7) {
                $reminderType = '7_day';
            } else {
                // No reminder is required for this certificate today.
                continue;
            }

            // Check for an existing reminder using only the date portion.
            $existingReminder = CertificateReminder::where(
                'certificate_id',
                $certificate->id
            )
                ->where('reminder_type', $reminderType)
                ->whereDate('inspection_date', $inspectionDate->toDateString())
                ->first();

            // Only create a record when one does not already exist.
            if (!$existingReminder) {
                CertificateReminder::create([
                    'certificate_id' => $certificate->id,
                    'reminder_type' => $reminderType,
                    'inspection_date' => $inspectionDate->toDateString(),
                    'status' => 'pending',
                ]);

                // Count this newly created reminder.
                $createdCount++;
            }
        }

        // Return the number of new reminders.
        return $createdCount;
    }

    /**
     * Prepare the SMS text for a certificate.
     * This method does not send anything.
     */
    public function createMessage(Certificate $certificate): string
    {
        return "Reminder: Your electrical certificate "
            . $certificate->certificate_number
            . " is due for inspection on "
            . $certificate->next_inspection_date->format('d M Y')
            . ". Please arrange your next inspection.";
    }
}
