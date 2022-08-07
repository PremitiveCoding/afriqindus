<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\CategoryResource;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with(['category:id,name'])->latest()->simplePaginate(10);

        return Inertia::render('Services/Index', [
            'services' => ServiceResource::collection($services),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Services/Create', [
            'edit' => false,
            'service' => new ServiceResource(new Service()),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    public function store(Request $request, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Service::class)],
            'image' => ['required', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $uploadFile->setFile($request->file('image'))
            ->setUploadPath((new Service())->uploadFolder())
            ->execute();

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service saved successfully.');
    }

    public function edit(Service $service)
    {
        return Inertia::render('Services/Create', [
            'edit' => true,
            'service' => new ServiceResource($service),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    public function update(Request $request, Service $service, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Service::class)->ignore($service->id)],
            'image' => ['nullable', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $service->image;
        if ($request->file('image')) {
            $service->deleteImage();

            $data['image'] = $uploadFile->setFile($request->file('image'))
                ->setUploadPath($service->uploadFolder())
                ->execute();
        }

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->deleteImage();
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
