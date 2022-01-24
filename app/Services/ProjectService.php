<?php 

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\File;

class ProjectService
{
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

    public function getExtensionFile(string $file)
    {
        return last(explode('.', $file));
    }

    public function formatPath(string $path)
    {
        return str_replace('/', '\\', $path);
    }
}
