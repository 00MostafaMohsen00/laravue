<?php

namespace App\Http\Controllers;

use App\Events\NewOffer;
use App\Http\Requests\OfferRequest;
use App\Models\Listeing;
use App\Models\Offer;
use App\Notifications\OfferMade;

class OfferController extends Controller
{
    public function index($id)
    {

        $listeing = auth()->user()->listeings()->withTrashed()->findOrFail($id);
        $offers = $listeing->offers;
        return inertia('Offers/Index', [
            'offers' => $offers->load('user'),
            'listeing' => $listeing
        ]);
    }
    public function store(OfferRequest $request, $id)
    {

        $listeing = Listeing::findOrFail($id);
        $this->authorize('view', $listeing);
        if ($listeing->user_id == auth()->user()->id)
            abort(403);
        $offer  = $listeing->offers()->create([
            'amount' => $request->amount,
            'user_id' => auth()->user()->id,
        ]);
        $listeing->owner->notify(new OfferMade($offer));
        event(new NewOffer($listeing->user_id));

        return redirect()->back()->with('success', __('lang.offer_created'));
    }

    public function accept($id)
    {
        $offer = Offer::findOrFail($id);

        $this->authorize('update', $offer->listeing);

        $offer->listeing->sold_at = now();
        $offer->listeing->save();
        $offer->update([
            'accepted_at' => now(),
        ]);
        $offer->listeing->offers()->where('id', '!=', $offer->id)->update([
            'rejected_at' => now(),
        ]);

        return redirect()->back()->with('success', __('lang.offer_accepted'));
    }
}
