<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listeing;
use Illuminate\Http\Request;

class ListeingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view listeings')->only(['index']);
        $this->middleware('permission:create listeings')->only(['create', 'store']);
        $this->middleware('permission:edit listeings')->only(['edit', 'update']);
        $this->middleware('permission:delete listeings')->only(['destroy']);
    }
    public function index()
    {
        $filters = ['deleted' => request()->boolean('deleted'), ...request()->all()];
        return inertia('Admin/Listeings/Index', [
            'listeings' => Listeing::filter($filters)->withCount('images', 'offers')->paginate(10)->withQueryString(),
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
    public function destroy(string $id)
    {
        //
    }
}
