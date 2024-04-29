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
use Illuminate\Validation\Rules\Password;

trait Store
{
    use Update,Delete;
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
            'establishment' => 'required|string'
                    ]);
            $profile = new Profile;
            $profile->firstName = $validatedData['firstName'];
            $profile->lastName = $validatedData['lastName'];
            $profile->email = $validatedData['email'];
            $profile->phone = $validatedData['phone'];
            $profile->password = bcrypt($validatedData['password']);
            $profile->role = 'user';
            $profile->save();
           
            $user = new User;
            $user->profile_id = $profile->id;
            $user->academicLevel = $validatedData['academicLevel'];
            $user->establishment = $validatedData['establishment'];
            $user->save();
        return $profile;
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
        'description' => 'nullable|string',
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
        $demande = new Demand;
        $demande->offer_id = $request->input('offer_id');
        $demande->user_id = $request->input('user_id');
        $demande->startDate = $request->input('startDate');
        $demande->endDate =  $request->input('endDate');
        $demande->motivationLetter =  $request->input('motivationLetter');
        $demande->save();
        $profile=$demande->user->profile;
        if ($request->hasFile('cv')&&$profile) {
            $this->storeOneFile($request, $profile, 'cv');            
        }
        if ($request->hasFile('demandeStage')&&$demande) {
            $this->storeOneFile($request, $demande, 'demandeStage');            
        }
        return response()->json($this->refactorDemand($demande));
    }
    public function storeAcceptedIntern($demand){
        $user = $demand->user;
        $offer = $demand->offer;
        $profile = $user->profile;
        $demand->status = 'Accepted';
        $demand->save();
       // dd($user);
        $intern = new Intern;
        $intern->profile_id = $profile->id;
        $intern->academicLevel = $user['academicLevel'];
        $intern->establishment = $user['establishment'];
        $intern->endDate = $demand['endDate'];
        $intern->startDate = $demand['startDate'];
        $intern->speciality = $offer['title'];
        $user->delete();

        $profile->role = 'intern';
        $profile->save();
        
        $intern->save();

        $demand->intern_id = $intern->id;
        $demand->save();
        
        return response()->json($this->refactorDemand($demand)) ;
    }
    public function storeFile($request, $id){
        $profile=Profile::find($id);
        $intern=Intern::find($id);
        if (!$profile&&!$intern) {
            return response()->json(['message' => 'cannot store files for undefined data'], 400);
        }
            if ($request->hasFile('avatar')&& $profile) {
                    $this->storeOneFile($request,$profile,'avatar');
            }else{
                if (!$request->hasFile('avatar')&& $profile) {
                    $this->deletOldFiles($profile, 'avatar');
                    return;
                }   
        }
        return response()->json(['message' => 'files stored successfully'], 200);
    }  
    public function storeOneFile($request,$element,$fileType){
          $files = $request->file($fileType);
          $name =$files->getClientOriginalName();
          $unique = uniqid();
        if ($fileType === 'avatar') {
            $request->validate([
                $fileType => 'file|mimes:jpg,jpeg,png|max:5120',
            ]);
        } else {
            $request->validate([
                $fileType => 'file|mimes:doc,docx,pdf|max:5120',
            ]);
        }
        if ($element->files->count()>0){
            $this->deletOldFiles($element, $fileType);
        }
         $element->files()->create(
                    ['url' =>'/'.$fileType.'/'.$unique.$name,
                        'type' => $fileType]
        );
        $files->move(public_path('/'.$fileType),$unique.$name);

    }
}