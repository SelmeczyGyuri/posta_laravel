<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;

use Illuminate\Http\Request;

class CountiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sort_by = request()->query('sort_by', 'name');
        $sort_dir = request()->query('sort_dir', 'asc');
        $search = request()->query('search');

        /*$counties = County::orderBy($sort_by, $sort_dir)->get();*/
        $counties = County::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy($sort_by, $sort_dir)
        ->get();
        
        /*return view('counties.index', compact('counties'));*/
        return view('counties.index', compact('counties', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('counties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:75',
            'crest_url' => 'string|max:255',
        ],
        [   'name.required' => 'A megye nevének megadása kötelező!',
            'name.string' => 'A megye neve csak szöveg lehet!',
            'name.min' => 'A megye neve minimum 3 karakter hosszú lehet!',
            'name.max' => 'A megye neve maximum 75 karakter hosszú lehet!',
            'crest_url.string' => 'A címer url-je csak szöveg lehet!',
            'crest_url.max' => 'A címer maximum 255 karakter hosszú lehet!',
        ]);

        $county = new County();
        $county->name = $request->name;
        $county->crest_url = $request->crest_url;

        $county->save();

        return redirect()->route('counties.index')
        ->with('success', 'Megye sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sort_by = request()->query('sort_by', 'city');
        $sort_dir = request()->query('sort_dir', 'asc');

        $county = County::findOrFail($id);
        $cities = $county->cities()->orderBy($sort_by, $sort_dir)->paginate(10);

        return view('counties.show', compact('county', 'cities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $county = County::find($id);
        return view('counties.edit', compact('county'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:75',
            'crest_url' => 'string|max:255',
        ],
        [   'name.required' => 'A megye nevének megadása kötelező!',
            'name.string' => 'A megye neve csak szöveg lehet!',
            'name.min' => 'A megye neve minimum 3 karakter hosszú lehet!',
            'name.max' => 'A megye neve maximum 75 karakter hosszú lehet!',
            'crest_url.string' => 'A címer url-je csak szöveg lehet!',
            'crest_url.max' => 'A címer maximum 255 karakter hosszú lehet!',
        ]);

        $county = County::find($id);
        $county->name = $request->name;
        $county->crest_url = $request->crest_url;

        $county->save();

        return redirect()->route('counties.index')
        ->with('success', 'Megye sikeresen módosítva!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $county = County::find($id);
        $county->delete();

        return redirect()->route('counties.index')->with('success', $county->name . ' sikeresen törölve!');
    }
}
