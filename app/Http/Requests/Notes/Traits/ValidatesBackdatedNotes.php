<?php

namespace App\Http\Requests\Notes\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;

trait ValidatesBackdatedNotes
{
    protected function validateBackdatedNotes(Validator $validator)
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();

            if (!isset($data['session_date'])) {
                return;
            }

            // Skip validation if user has permission to ignore time limits
            if (Gate::allows('ignore_time_limits')) {
                return;
            }

            $sessionDate = Carbon::parse($data['session_date']);
            $twoWeeksAgo = Carbon::now()->subWeeks(2)->startOfDay();

            if ($sessionDate->lt($twoWeeksAgo)) {
                $validator->errors()->add(
                    'session_date',
                    'Notes cannot be created for sessions more than 2 weeks in the past. Please contact your supervisor if you need to create a note for an older session.'
                );
            }
        });
    }
}
