<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use Carbon\Carbon;
use App\Enums\Type;
use Inertia\Inertia;
use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRequestRequest;

class RequestController extends Controller
{
    // SITTER & ADMIN GET FUNCTIONS
    public function index($filter){
        if($filter !== 'Alle'){
            $null = Request::whereRelation('pet', 'type', $filter)->get()->where('sitter_id', '==', NULL);
            $false = Request::whereRelation('pet', 'type', $filter)->get()->where('status', '===', 0);
            $requests = $null->merge($false);
        }else{
            $null = Request::all()->where('sitter_id', '==', NULL);
            $false = Request::all()->where('status', '===', 0);
            $requests = $null->merge($false);
        }

        $requests = $requests->map(function ($request){
            return [
                'id' => $request->id,
                'name' => $request->pet->name,
                'from' => date('d-m-Y', strtotime($request->from)),
                'till' => date('d-m-Y', strtotime($request->till)),
                'rate' => $request->hourly_rate,
                'image' => Storage::url($request->pet->images->first()->path),
            ];
        });

        if(Auth::user()->role->value == Role::Admin->value){
            return Inertia::render('Admin/Requests', [
                'requests' => $requests,
                'types' => Type::cases(),
                'filter' => $filter ? $filter : 'Alle',
            ]);
        }

        return Inertia::render('Sitter/Overview', [
            'requests' => $requests,
            'types' => Type::cases(),
            'filter' => $filter ? $filter : 'Alle',
        ]);
    }

    public function show($id){
        $request = Request::findOrFail($id);
        $pet = $request->pet;
        $pet->image = Storage::url($pet->images->first()->path);

        return Inertia::render('Sitter/Request', [
            'request' => $request,
            'animal' => $pet
        ]);
    }

    public function sitter_index(){
        $requests = Request::all()->where('sitter_id', '==', Auth::user()->id);

        $requests = $requests->map(function ($request){
            return [
                'id' => $request->id,
                'name' => $request->pet->name,
                'from' => date('d-m-Y', strtotime($request->from)),
                'till' => date('d-m-Y', strtotime($request->till)),
                'status' => $request->status,
                'image' => Storage::url($request->pet->images->first()->path),
            ];
        });

        return Inertia::render('Sitter/Inbox', [
            'requests' => $requests,
        ]);
    }

    // OWNER GET FUNCTIONS
    public function owner_index(){
        $requests = Auth::user()->requests->map(function ($request){
            return [
                'id' => $request->id,
                'name' => $request->pet->name,
                'from' => date('d-m-Y', strtotime($request->from)),
                'till' => date('d-m-Y', strtotime($request->till)),
                'rate' => $request->hourly_rate,
                'image' => Storage::url($request->pet->images->first()->path),
            ];
        });

        $animals = Auth::user()->pets->map(function ($pet){
            return [
                'name' => $pet->name,
                'id' => $pet->id,
            ];
        });

        return Inertia::render('Owner/Requests', [
            'requests' => $requests,
            'animals' => $animals,
        ]);
    }

    public function inbox(){
        $requests = Auth::user()->requests->where('sitter_id', '!=', NULL)->where('status', '!==', 0)->map(function ($request){
            return [
                'id' => $request->id,
                'sitter_id' => $request->sitter_id,
                'sitter_name' => $request->sitter->name,
                'pet_name' => $request->pet->name,
                'image' => $request->sitter->images->isNotEmpty() ? Storage::url($request->sitter->images->first()->path) : null,
                'accepted' => $request->status,
                'reviewable' => $request->status == true
                                && $request->till < Carbon::now()
                                && !$request->review  ? true : false,
                'reviewed' => $request->review  ? true : false,
            ];
        });

        return Inertia::render('Owner/Inbox', [
            'requests' => $requests,
        ]);
    }

    // HANDLING REQUEST CHANGES
    public function store(StoreRequestRequest $request){
        Request::create($request->handleRequest());
        return to_route('owner.requests.index')->with('message', 'Aanvraag aangemaakt!');
    }

    public function destroy($id){
        $request = Request::find($id);
        $request->delete();

        if(Auth::user()->role->value == Role::Admin->value){
            return to_route('requests.index', 'Alle')->with('message', 'Aanvraag verwijdert!');
        }
        return to_route('owner.requests.index')->with('message', 'Aanvraag verwijdert!');
    }

    public function accept($id){
        $request = Request::find($id);
        $request->status = true;
        $request->save();
        return to_route('requests.inbox');
    }

    public function reject($id){
        $request = Request::find($id);
        $request->status = false;
        $request->save();
        return to_route('requests.inbox');
    }

    public function sign_up($id){
        $request = Request::find($id);
        $request->sitter_id = Auth::user()->id;
        $request->save();
        return to_route('requests.index', 'Alle');
    }
}
