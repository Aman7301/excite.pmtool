<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class AfterCurrentDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function passes($attribute, $value)
    {
        $currentDate = Carbon::today()->subDays(10);
        $inputDate = Carbon::createFromFormat('Y-m-d', $value);

        return $inputDate->gte($currentDate);
    }

    public function message()
    {
        return 'The :attribute cannot be before the current 10 days.';
    }
}
