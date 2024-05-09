<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\DynamicForm; // Import the DynamicForm model

class SendFormCreationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $form;

    /**
     * Create a new job instance.
     */
    public function __construct(DynamicForm $form)
    {
        $this->form = $form;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Logic to send email notification
        try {
            $formName = $this->form->form_name;
            $userEmail = "rpv19852000@gmail.com"; // Assuming there's a user relationship

            $data = [
                'form_name' => $formName,
                // Add more data as needed for the email template
            ];

            // Send email using Laravel's Mail facade
            \Mail::to($userEmail)->send(new \App\Mail\FormCreationNotification($data));
        } catch (\Exception $e) {
            // Handle email sending failure (log error, notify admin, etc.)
            \Log::error('Failed to send form creation notification: '.$e->getMessage());
        }
    }
}
