<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\CategoryResource;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['category:id,name'])->latest()->simplePaginate(10);

        return Inertia::render('Projects/Index', [
            'projects' => ProjectResource::collection($projects),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Projects/Create', [
            'edit' => false,
            'project' => new ProjectResource(new Project()),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    public function store(Request $request, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Project::class)],
            'image' => ['required', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $uploadFile->setFile($request->file('image'))
            ->setUploadPath((new Project())->uploadFolder())
            ->execute();

        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Project saved successfully.');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Create', [
            'edit' => true,
            'project' => new ProjectResource($project),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    public function update(Request $request, Project $project, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Project::class)->ignore($project->id)],
            'image' => ['nullable', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $project->image;
        if ($request->file('image')) {
            $project->deleteImage();

            $data['image'] = $uploadFile->setFile($request->file('image'))
                ->setUploadPath($project->uploadFolder())
                ->execute();
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->deleteImage();
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
