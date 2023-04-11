<?php

namespace App\Http\Controllers;

use App\Enums\Type;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Image;
use App\Models\Pet;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    // Show all pets of an owner
    public function index(){
        $pets = auth()->user()->pets->map(function ($pet){
            return [
                'id' => $pet->id,
                'name' => $pet->name,
                'description' => $pet->description,
                'image' => Storage::url($pet->images->first()->path),
            ];
        });


        return Inertia::render('Owner/Animals', [
            'animals' => $pets,
            'types' => Type::cases(),
        ]);
    }

    // Let owner create a new Pet
    public function store(StorePetRequest $request){
        // Create pet
        $this->authorize('store-pet', Auth::user());
        $pet = Pet::create($request->handleRequest());

        // Save image location
        $image = new Image();
        $path = $request->image->store('pets', 'public');
        $image->path = $path;
        $image->pet_id = $pet->id;
        $image->save();

        return to_route('animals.index')->with('message', 'Huisdier aangemaakt!');
    }

    public function edit($id){
        $pet = Pet::findOrFail($id);
        $pet->image = Storage::url($pet->images->first()->path);

        return Inertia::render('Owner/Animal', [
            'animal' => $pet,
        ]);
    }

    public function update($id, UpdatePetRequest $request){
        $pet = Pet::findOrFail($id);
        $this->authorize('update-pet', $pet);
        $pet->update($request->validated());

        return to_route('animals.index')->with('message', 'Huisdier bijgewerkt!');
    }

    public function destroy($id){
        $pet = Pet::findOrFail($id);
        $this->authorize('update-pet', $pet);
        $pet->delete();

        return to_route('animals.index')->with('message', 'Huisdier verwijdert!');
    }

}
