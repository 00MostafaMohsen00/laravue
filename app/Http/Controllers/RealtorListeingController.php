<?php

namespace App\Http\Controllers;

use App\Models\Listeing;
use Illuminate\Http\Request;

class RealtorListeingController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Listeing::class, 'listeing');
    }
    public function index()
    {
        $filters = ['deleted' => request()->boolean('deleted'), ...request()->only(['by', 'order', 'page'])];
        return inertia('Realtor/index', [
            'listeings' => auth()->user()->listeings()->filter($filters)->withCount('images', 'offers')->paginate(5)->withQueryString(),
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listeing $listeing)
    {
        $listeing->deleteOrFail();
        return redirect()->back()->with('success', __('lang.listeing_deleted'));
    }

    public function restore(string $id)
    {
        auth()->user()->listeings()->withTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('success', __('lang.listeing_restored'));
    }
}
