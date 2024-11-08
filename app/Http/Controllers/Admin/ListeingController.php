<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listeing;

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
        $filters = [
            'deleted' => request()->boolean('deleted'),
            'soled' => request()->boolean('soled'),
            ...request()->only(['by', 'order', 'page', 'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo']),
        ];
        return inertia('Admin/Listeings/Index', [
            'listeings' => Listeing::filter($filters)->mostRecent()->withCount('images', 'offers')->paginate(10)->withQueryString(),
            'filters' => $filters
        ]);
    }


    public function show(string $id)
    {
        $listeing = Listeing::findOrFail($id)->load('images', 'offers.user');

        return inertia('Admin/Listeings/Show', [
            'listeing' => $listeing,
        ]);
    }


    public function destroy(string $id)
    {
        $listeing = Listeing::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()->with('success', __('lang.success'));
    }
}
