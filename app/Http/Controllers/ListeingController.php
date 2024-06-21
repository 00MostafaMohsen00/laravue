<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListeingCreateRequest;
use App\Models\Listeing;
use Illuminate\Http\Request;

class ListeingController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Listeing::class, 'listeing');
    }
    public function index(Request $request)
    {
        $filters = $request->only('priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo');
        $listeings = Listeing::whereNull('sold_at')
            ->filter($filters)
            ->mostRecent()
            ->paginate(10)
            ->withQueryString();

        return inertia('Listeings/Index', [
            'listeings' => $listeings,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Listeings/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListeingCreateRequest $request)
    {
        $listeing = auth()->user()->listeings()->create($request->validated());
        return redirect()->route('listeing.index')->with('success', __('lang.listeing_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Listeing $listeing)
    {
        return inertia('Listeings/Show', [
            'listeing' => $listeing->load(['images', 'offers' => function ($query) {
                return $query->where('user_id', @auth()->id())->first();
            }]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listeing $listeing)
    {

        return inertia('Listeings/Edit', [
            'listeing' => $listeing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListeingCreateRequest $request, Listeing $listeing)
    {
        $listeing->update($request->validated());
        return redirect()->route('listeing.index')->with('success', __('lang.listeing_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listeing $listeing)
    {
        $listeing->delete();
        return redirect()->back()->with('success', __('lang.listeing_deleted'));
    }
}
