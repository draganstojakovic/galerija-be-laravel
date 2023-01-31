<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Requests\GalleryRequest;
use App\Models\User;

class GalleriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Gallery::paginate(10);
    }

    public function show($id)
    {
        return Gallery::with('comments', 'user')->findOrFail($id);
    }

    public function store(GalleryRequest $request, $id)
    {
        $validated = $request->validated();
        $user = User::findOrFail($id);
        $user->createPost(
            $validated['title'], 
            $validated['description'], 
            $validated['image_url']
        );
        return $user;
    }

    public function update(GalleryRequest $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->update($request->all());
        return $gallery;
    }

    public function destroy($id)
    {
        Gallery::destroy($id);
    }
}