<?php 

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;


class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();


        if ($search = $request->get('q')) {
        $query->where(function ($q) use ($search) {
        $q->where('title', 'like', "%{$search}%")
        ->orWhere('type', 'like', "%{$search}%")
        ->orWhere('features', 'like', "%{$search}%");
        });
    }


    $perPage = $request->get('per_page', 10);
    $rooms = $query->latest()->paginate($perPage);


    return response()->json($rooms);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:standard,junior,class,deluxe',
            'features' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer',
            'status' => 'nullable|string|in:available,unavailable,maintenance',
            'image' => 'nullable|image|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public'); 
            $validated['image'] = $path;
        }

        $room = Room::create($validated);

        return response()->json($room, 201);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:standard,junior,class,deluxe',
            'features' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer',
            'status' => 'nullable|string|in:available,unavailable,maintenance',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $path;
        }

        $room->update($validated);

        return response()->json($room);
    }



    public function show(Room $room)
    {
    return response()->json($room);
    }

}