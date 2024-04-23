<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;
use App\Models\Intern;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new project
        $project = new Project;
        $project->subject = 'Project 1';
        $project->description = 'Description for Project 1';
        $project->startDate = Carbon::now()->subDays(rand(1, 365));
        $project->endDate = Carbon::now()->addDays(rand(1, 365));
        $project->status = 'open';
        $project->priority = 'high';
        $project->supervisor_id = 1; // replace with appropriate supervisor ID
        $project->intern_id = 1; // replace with appropriate supervisor ID
        $project->save();

        // Get the intern

        // Attach the intern to the project with a pivot table
        $project->interns()->attach(1);

        // Create a new task associated with the project
        $task = new Task;
        $task->title = 'Task 1';
        $task->description = 'Description for Task 1';
        $task->dueDate = Carbon::now()->addDays(rand(1, 365));
        $task->priority = 'high';
        $task->status = 'open';
        $task->intern_id = 1;
        $task->project_id = 1; // associate the task with the project
        $task->save();

        // Create another task associated with the project
        $task2 = new Task;
        $task2->title = 'Task 2';
        $task2->description = 'Description for Task 2';
        $task2->dueDate = Carbon::now()->addDays(rand(1, 365));
        $task2->priority = 'low';
        $task2->status = 'open';
        $task2->intern_id = 1;
        $task2->project_id =1; // associate the task with the project
        $task2->save();
    }
}
