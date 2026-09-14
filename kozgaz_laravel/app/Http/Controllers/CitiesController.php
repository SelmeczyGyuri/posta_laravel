<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;

use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sort_by = request()->query('sort_by', 'city');
        $sort_dir = request()->query('sort_dir', 'asc');
        $search = request()->query('search');
        $countyFilter = request()->query('county');

        /*$cities = City::with('county')->orderBy($sort_by, $sort_dir)->paginate(20);*/
        $cities = City::with('county')
        ->when($search, function ($query, $search) {
            $query->where('city', 'like', '%' . $search . '%');
        })
        ->when($countyFilter, function ($query, $countyFilter) {
            $query->where('id_county', $countyFilter);
        })
        ->orderBy($sort_by, $sort_dir)
        ->paginate(20);

        $counties = County::orderBy('name')->get();

        /*return view('cities.index', compact('cities'));*/
        return view('cities.index', compact('cities', 'search', 'countyFilter', 'counties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*$counties = County::all();
        return view('cities.create', compact('counties'));*/
        $counties = County::orderBy('name')->get();
        return view('cities.create', compact('counties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'zip_code' => 'required|integer|between:1000,9999',
            'city' => 'required|string|min:3|max:50',
            'id_county' => 'required|integer',
            'population' => 'required|integer',
        ],
        [   'zip_code.required' => 'A irányítószám megadása kötelező!',
            'zip_code.integer' => 'A irányítószám csak egész szám lehet!',
            'zip_code.between' => 'A irányítószám minimum 4, maximum 4 számjegyű lehet!',
            'city.required' => 'A város megadása kötelező!',
            'city.string' => 'A város neve csak szöveg lehet!',
            'city.min' => 'A város neve minimum 3 karakter hosszú lehet!',
            'city.max' => 'A város maximum 50 karakter hosszú lehet!',
            'id_county.required' => 'A megye megadása kötelező!',
            'id_county.integer' => 'A megye csak egész szám lehet!',
            'population.required' => 'A népesség megadása kötelező!',
            'population.integer' => 'A népesség csak egész szám lehet!',
        ]);

        $city = new City();
        $city->zip_code = $request->zip_code;
        $city->city = $request->city;
        $city->id_county = $request->id_county;
        $city->population = $request->population;

        $city->save();

        return redirect()->route('cities.index')
        ->with('success', 'Város sikeresen létrehozva!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $city = City::with('county')->findOrFail($id);
        return view('cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /*$city = City::find($id);
        $counties = County::all();
        return view('cities.edit', compact('city', 'counties'));*/
        $city = City::findOrFail($id);
        $counties = County::orderBy('name')->get();
        return view('cities.edit', compact('city', 'counties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'zip_code' => 'required|integer|between:1000,9999',
            'city' => 'required|string|min:3|max:50',
            'id_county' => 'required|integer',
            'population' => 'required|integer',
        ],
        [   'zip_code.required' => 'A irányítószám megadása kötelező!',
            'zip_code.integer' => 'A irányítószám csak egész szám lehet!',
            'zip_code.between' => 'A irányítószám minimum 4, maximum 4 számjegyű lehet!',
            'city.required' => 'A város megadása kötelező!',
            'city.string' => 'A város neve csak szöveg lehet!',
            'city.min' => 'A város neve minimum 3 karakter hosszú lehet!',
            'city.max' => 'A város maximum 50 karakter hosszú lehet!',
            'id_county.required' => 'A megye megadása kötelező!',
            'id_county.integer' => 'A megye csak egész szám lehet!',
            'population.required' => 'A népesség megadása kötelező!',
            'population.integer' => 'A népesség csak egész szám lehet!',
        ]);

        $city = City::find($id);
        $city->zip_code = $request->zip_code;
        $city->city = $request->city;
        $city->id_county = $request->id_county;
        $city->population = $request->population;

        $city->save();

        return redirect()->route('cities.index')
        ->with('success', 'Város sikeresen módosítva!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::find($id);
        $city->delete();

        return redirect()->route('cities.index')
        ->with('success', 'Város sikeresen törölve!');
    }

    public function export()
    {
        $sort_by = request()->query('sort_by', 'city');
        $sort_dir = request()->query('sort_dir', 'asc');
        $search = request()->query('search');
        $countyFilter = request()->query('county');

        $cities = City::with('county')
            ->when($search, fn($q, $search) => $q->where('city', 'like', '%' . $search . '%'))
            ->when($countyFilter, fn($q, $countyFilter) => $q->where('id_county', $countyFilter))
            ->orderBy($sort_by, $sort_dir)
            ->get();

        $filename = 'varosok.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($cities) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Irányítószám', 'Város', 'Megye', 'Lakosság']);

            foreach ($cities as $city) {
                fputcsv($file, [
                    $city->id,
                    $city->zip_code,
                    $city->city,
                    $city->county?->name ?? 'Ismeretlen megye',
                    $city->population,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
