<?php 

namespace App\Services;

use App\Models\Project;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\File;

class ProjectService
{
    public function lists(Authenticatable $user)
    {
        if ($user->can('create-teams') || $user->can('create-tasks')) {
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
}
