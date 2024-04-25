<?php

namespace App\Traits;
use App\Models\Project;
use Illuminate\Validation\Rules\Password;


trait Update
{
    use Refactor;
    public function updateProfile($data,$profile){
            $validatedData = $data->validate([
                    'email' => 'email',
                    'firstName' =>'string',
                    'lastName' =>'string',
                    'phone' =>'string',
                    'password' => [
                            'string',
                            Password::min(8)->mixedCase()->numbers()->symbols(),
                            'confirmed',
                        ],    
                        "files"=>'array'            
                    ]); 
                    if ($profile->email!==$data['email']){
            $validatedData = $data->validate([
                        'email' => 'email|unique:profiles,email',
                        'firstName' =>'string',
                        'lastName' =>'string',
                        'phone' =>'string',
                        "files"=>'array',            
                        'password' => [
                            'string',
                            Password::min(8)->mixedCase()->numbers()->symbols(),
                            'confirmed',
                        ],                
            ]);
        }   
        $profile->update($validatedData);
         if (isset($validatedData['files'])) {
            foreach ($validatedData['files'] as $file) {
                $profile->files()->create( ['url' => $file['url'],'type' => $file['type']]);
            }
        }
        if ($data->role=='user') {
            $user = $profile->user;
             $updateData = array_filter([
            'academicLevel' => $data['academicLevel'] ?? null,
            'establishment' => $data['establishment'] ?? null,
            'startDate' => $data['startDate'] ?? null,
            'endDate' => $data['endDate'] ?? null,
        ]);
            $user->update($updateData);
        }
        if ($data->role=='intern') {
            $intern = $profile->intern;
             $updateData = array_filter([
            'academicLevel' => $data['academicLevel'] ?? null,
            'establishment' => $data['establishment'] ?? null,
            'startDate' => $data['startDate'] ?? null,
            'endDate' => $data['endDate'] ?? null,
        ]);
            $intern->update($updateData);
        }
        return response()->json($this->refactorProfile($profile));
    }
    public function updateProject($data,$project){
        $tasks=$project->tasks;
        $validatedProject = $data->validate([
            'subject' => 'string',
            'description' => 'string',
            'startDate' => 'date',
            'endDate' => 'date',
            'status' => 'string',
            'priority' => 'in:Low,Medium,High,None',
            'supervisor_id' => 'exists:supervisors,id',
            'intern_id' => 'nullable|exists:interns,id',
            'teamMembers' => 'array|exists:interns,id',
        ]);
        $project->update($validatedProject);
        if ($data->has('teamMembers')){
            foreach($tasks as $task){
                if(!in_array($task->intern_id ,$data['teamMembers'])){
                    $task->intern_id = null;
                    $task->save();
                }  
            }
            $project->interns()->detach();
            $project->interns()->attach($data['teamMembers']);
        }
        return $project;
    }

    public function updateTask($request,$task){
        $validatedData = $request->validate([
        'title' => 'nullable|max:255',
        'description' => 'nullable|text',
        'dueDate' => 'nullable|date',
        'priority' => 'in:Low,Medium,High,None',
        'status' => 'in:To Do,Done,In Progress',
        'intern_id' => 'nullable|exists:interns,id',
        'project_id' => 'exists:projects,id',
    ]);
        $task->update($validatedData);
        $this->updateProjectStatus($task->project_id);
        return $task;
    }
    public function updateProjectStatus($project_id){
        $project = Project::find($project_id);
        $todoCount = $project->tasks()->where('status', 'To Do')->count();
        $progressCount = $project->tasks()->where('status', 'In Progress')->count();
        $doneCount = $project->tasks()->where('status', 'Done')->count();

        if ($doneCount > 0 && $todoCount == 0 && $progressCount == 0) {
            $project->status = "Completed";
        } elseif ($progressCount > 0 || $doneCount > 0) {
            $project->status = "In Progress";
        } else {
            $project->status = "Not Started";
        }

        $project->save();
    }
    public function updateOffer($request,$offer){
           $updateData = array_filter([
                "title"=>   $request['title'] ?? null,
                "description"=>   $request['description'] ?? null,
                'sector'=> $request['sector'] ?? null,
                'experience'=> $request['experience'] ?? null,
                'skills'=>  $request['skills'] ?? null,
                'duration'=>  $request['duration'] ?? null,
                'direction'=>  $request['direction'] ?? null,
                'visibility'=>  $request['visibility'] ?? null,
                'status'=> $request['status'] ?? null,
                'city'=>  $request['city'] ?? null,
                'type'=> $request['type'] ?? null,
            ]);
        $offer->update($updateData);
        return $offer;
    }
    public function updateDemand($request,$demand){
         $updateData = array_filter([
                "user_id"=>   $request['user_id'] ?? null,
                "offer_id"=>   $request['offer_id'] ?? null,
                'startDate'=> $request['startDate'] ?? null,
                'endDate'=> $request['endDate'] ?? null,
            ]);
        $demand->update($updateData);
        return $demand;
    }
}