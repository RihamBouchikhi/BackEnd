<?php

namespace App\Traits;
use App\Models\Admin;
use App\Models\Demand;
use App\Models\Intern;
use App\Models\Offer;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Supervisor;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

trait Store
{
    use Update;
    public function storeProfile($request) {
        $validatedProfile = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email|max:255',
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols(),
                'confirmed',
            ],
            'role'=>'required|in:admin,supervisor,intern'
        ]);
            $profile = new Profile;
            $profile->firstName = $validatedProfile['firstName'];
            $profile->lastName = $validatedProfile['lastName'];
            $profile->email = $validatedProfile['email'];
            $profile->phone = $validatedProfile['phone'];
            $profile->password = bcrypt($validatedProfile['password']);
            $profile->role = $request->role;
            $profile->save();
        if ($request->role == 'admin') {
           $admin = new Admin;
            $admin->profile_id = $profile->id;
            $admin->save();
        }
        if ($request->role == 'supervisor') {
            $supervisor = new Supervisor;
            $supervisor->profile_id = $profile->id;
            $supervisor->save();
        }
        if ($request->role == 'intern') {
                $validatedIntern = $request->validate([
                'academicLevel' => 'required|string',
                'establishment' => 'required|string',
                'startDate' => 'required',
                'endDate' => 'required',
            ]);
            $intern = new Intern;
            $intern->profile_id = $profile->id;
            $intern->academicLevel = $validatedIntern['academicLevel'];
            $intern->establishment = $validatedIntern['establishment'];
            $intern->startDate = $validatedIntern['startDate'];
            $intern->endDate = $validatedIntern['endDate'];
            $intern->save();
        }
        return $profile;
    }
    public function storeUser($request){
         $validatedData = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email|max:255',
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols(),
                'confirmed',
            ],
            'academicLevel' => 'required|string',
                'establishment' => 'required|string',
                'role'=>'required|in:user'
        ]);
            $profile = new Profile;
            $profile->firstName = $validatedData['firstName'];
            $profile->lastName = $validatedData['lastName'];
            $profile->email = $validatedData['email'];
            $profile->phone = $validatedData['phone'];
            $profile->password = bcrypt($validatedData['password']);
            $profile->role = $validatedData['role'];
            $profile->save();
           
            $user = new User;
            $user->profile_id = $profile->id;
            $user->academicLevel = $validatedData['academicLevel'];
            $user->establishment = $validatedData['establishment'];
            $user->save();
    }
    public function storeProject($request){
        $validatedProject = $request->validate([
            'subject' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'status' => 'required|in:Not Started,Completed,In Progress',
            'priority' => 'required|in:Low,Medium,High,None',
            'supervisor_id' => 'required|exists:supervisors,id',
            'intern_id' => 'nullable|exists:interns,id',
            'tasks' => 'array',
            'teamMembers' => 'array|exists:interns,id',
        ]);
            $project = new Project;
            $project->subject = $validatedProject['subject'];
            $project->description = $validatedProject['description'];
            $project->startDate = $validatedProject['startDate'];
            $project->endDate = $validatedProject['endDate'];
            $project->status = $validatedProject['status'];
            $project->priority = $validatedProject['priority'];
            $project->supervisor_id = $validatedProject['supervisor_id'];
            $project->intern_id = $validatedProject['intern_id']; 
            $project->save();
        foreach ($validatedProject['teamMembers'] as $teamMemberId) {
            $project->interns()->attach($teamMemberId);
        }
        foreach ($request->tasks  as $taskData) {
            $task = new Task;
            $task->title = $taskData['title'];
            $task->description = $taskData['description'];
            $task->dueDate = $taskData['dueDate'];
            $task->priority = $taskData['priority'];
            $task->status = $taskData['status'];
            $task->intern_id = $taskData['intern_id']; 
            $task->project_id = $project->id; 
            $task->save();
        }
        return $project;
    }
    public function storeTask($request){
        $validatedData = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable|text',
        'dueDate' => 'nullable|date',
        'priority' => 'required|in:Low,Medium,High,None',
        'status' => 'required|in:To Do,Done,In Progress',
        'intern_id' => 'nullable|exists:interns,id',
        'project_id' => 'required|exists:projects,id',
    ]);
        $task = new Task;
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->dueDate = $validatedData['dueDate'];
        $task->priority = $validatedData['priority'];
        $task->status = $validatedData['status'];
        $task->intern_id = $validatedData['intern_id']; 
        $task->project_id = $validatedData['project_id']; 
        $task->save();
        $this->updateProjectStatus($task->project_id);
        return $task;
    }
    public function storeOffer($request){
    // Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'sector' => 'required|max:255',
        'experience' => 'required|in:Expert,Intermediate,Beginner',
        'skills' => 'nullable',
        'duration' => 'numeric|min:1|max:24',
        'direction' => 'required|string',
        'visibility'=>'required|in:Visible,Hidden',
        'status'=>'required|in:Normal,Urgent',
        'city'=>'required|string',
        'type'=>'required|in:Remote,Onsite,Hybrid',
    ]);
    // Create a new offer with the validated data
        $offer = new Offer;
        $offer->title = $validatedData['title'];
        $offer->description = $validatedData['description'];
        $offer->sector = $validatedData['sector'];
        $offer->experience = $validatedData['experience'];
        $offer->skills = $validatedData['skills'];
        $offer->duration = $validatedData['duration'];
        $offer->direction = $validatedData['direction'];
        $offer->visibility = $validatedData['visibility'];
        $offer->status = $validatedData['status'];
        $offer->city = $validatedData['city'];
        $offer->type = $validatedData['type'];
        $offer->save();

        return $offer;
    }
    public function storeDemand($request){
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'offer_id' => 'required|exists:offers,id',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            //'files.*' => 'file|mimes:jpg,jpeg,png,doc,docx,pdf,txt|max:2048', // Validate each file
        ]);
        $demande = new Demand;
        $demande->offer_id = $validatedData['offer_id'];
        $demande->user_id = $validatedData['user_id'];
        $demande->startDate = $validatedData['startDate'];
        $demande->endDate = $validatedData['endDate'];
        $demande->save();
        // If files are provided, store them
    // if ($request->hasFile('files')) {
    //     foreach ($request->file('files') as $file) {
    //         $path = $file->store('public/files'); // Store the file in the public/files directory
    //         $url = Storage::url($path); // Get the URL of the stored file
    //         $demande->files()->create(['url' => $url, 'type' => $file->getClientOriginalExtension()]);
    //     }
    // }

    return $demande;
    }
}