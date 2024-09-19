<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Listeing;
use App\Models\ListeingImage;
use Illuminate\Support\Facades\Storage;

class ListeingImageController extends Controller
{
    public function create(Listeing $listeing)
    {
        $this->authorize('delete', $listeing);
        return inertia('Realtor/ListeingImage/Create', [
            'listeing' => $listeing->load('images'),
        ]);
    }

    public function store(ImageRequest $request, Listeing $listeing)
    {
        $this->authorize('delete', $listeing);
        foreach ($request->images as $image) {
            $path = $image->store('images', 'public');
            $listeing->images()->create(['filename' => $path]);
        }

        return redirect()->back()->with('success', __('lang.image_uploaded'));
    }

    public function destroy(ListeingImage $image)
    {
        $this->authorize('delete', $image->listeing);
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->back()->with('success', __('lang.image_deleted'));
    }
}
