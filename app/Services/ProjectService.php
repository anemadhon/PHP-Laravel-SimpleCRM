<?php 

namespace App\Services;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectState;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Auth\Authenticatable;

class ProjectService
{
    public function lists(Authenticatable $user)
    {
        if ($user->can('manage-products') || $user->can('develop-products')) {
            return $user->projects()->with(['state', 'level', 'client', 'users'])->withCount(['tasks', 'users'])->paginate(4);
        }
        
        return Project::with(['state', 'level', 'client', 'users'])->withCount(['tasks', 'users'])->paginate(4);
    }

    public function attachment(array $files, Project $project, string $flag = '')
    {
        if ($flag === 'edit') {
            File::deleteDirectory(storage_path('app\public\project\attachments\\').$project->slug);

            $project->attachments()->delete();
        }

        foreach ($files as $file) {
            $project->attachments()->create([
                'path' => $file->storeAs('project', "attachments/{$project->slug}/{$file->getClientOriginalName()}", 'public'),
                'filename' => $file->getClientOriginalName()
            ]);
        }
    }

    public function extensionFile(string $file)
    {
        return last(explode('.', $file));
    }

    public function formatPath(string $path)
    {
        return 'app\\public\\'.str_replace('/', '\\', $path);
    }

    public function team(array $ids)
    {
        $users = [];

        $users[] = $ids['pm'];

        foreach ($ids['dev'] as $id) {
            $users[] = $id;
        }
        
        $users[] = $ids['qa'];

        return $users;
    }

    public function availabilityStatusCheck(array $ids)
    {
        $idle = [];
        $arrayID = [];
        $teams = $ids['dev'];

        $teams[] = $ids['qa'];

        foreach ($teams as $id) {
            $onTeams = ProjectUser::where('user_id', $id)->where('status', ProjectUser::ON_START)->first();

            if ($onTeams === null) {
                $idle[] = 'idle';
            }
            
            if ($onTeams) {
                $projects = Project::find($onTeams->project_id);

                if ($projects->state_id !== ProjectState::LIVE) {
                    $arrayID[] = $id;
                }
                
            }
        }

        if (count($idle) === count($teams)) {
            return [
                'ids' => 0,
                'status' => 'available'
            ];
        }

        return [
            'ids' => $arrayID,
            'status' => 'on_project'
        ];
    }

    public function formatErrors(array $ids)
    {
        $errors = [];

        foreach ($ids as $id) {
            $user = User::find($id, ['name']);

            $errors[] = "{$user->name} has assigned on others Project";
        }

        return $errors;
    }
}
