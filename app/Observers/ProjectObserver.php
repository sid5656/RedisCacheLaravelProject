<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class ProjectObserver
{
    public function created(Project $project)
    {
        Cache::tags('projects')->flush();
    }

    public function updated(Project $project)
    {
        Cache::tags('projects')->flush();
    }

    public function deleted(Project $project)
    {
        Cache::tags('projects')->flush();
    }
}

