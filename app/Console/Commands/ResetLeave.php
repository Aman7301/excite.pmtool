<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmployeeModel;
use App\Models\TotalLeaveModel;
use Carbon\Carbon;

class ResetLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reset:EmployeeLeave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is Reset the employee leave per Year';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentYear = Carbon::now()->year;
        $employees = EmployeeModel::where("user_type", 2)->get();

        foreach ($employees as $employee) {
            $totalLeave = TotalLeaveModel::where("id", $employee->total_leave_id)->first(['total']);
            
            if ($totalLeave) {
                $employee->emp_leave = $totalLeave->total;
                $employee->save();
            }
       }
       $this->info('Yearly update leave By Year Successfully');
    //    return response()->json(['status' => 200, 'Message' => 'Reset Employee leave By Year']);
    }
}
