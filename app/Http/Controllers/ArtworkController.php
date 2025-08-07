<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artwork;
use Inertia\Inertia;

class ArtworkController extends Controller
{
    public function index()
    {
        $artworks = Artwork::latest()->get();
        
        return Inertia::render('Dashboard', [
            'artworks' => $artworks

        ]);
    }
    
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('artworks', 'public');

        Artwork::create([
            'user_id' => auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Artwork uploaded successfully!');
    }
}
