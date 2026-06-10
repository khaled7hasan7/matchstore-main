<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\PromoCard;
use App\Models\PromoCardTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promoCards = PromoCard::with(['translations'])
            ->orderBy('order', 'asc')
            ->get();

        return view('admin.promo-cards.index', compact('promoCards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::where('active', 1)->get();

        return view('admin.promo-cards.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $activeLanguages = Language::where('active', 1)->pluck('code')->toArray();

        $rules = [
            'size' => 'required|in:large,small',
            'order' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ];

        foreach ($activeLanguages as $code) {
            $rules["languages.$code.badge_text"] = 'nullable|string|max:255';
            $rules["languages.$code.title"] = 'required|string|max:255';
            $rules["languages.$code.button_text"] = 'nullable|string|max:255';
            $rules["languages.$code.button_url"] = 'nullable|string|max:255';
            $rules["languages.$code.image_url"] = 'nullable|url|max:500';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($request, $activeLanguages) {
            $promoCard = PromoCard::create([
                'size' => $request->size,
                'order' => $request->order,
                'status' => $request->status,
            ]);

            foreach ($activeLanguages as $code) {
                $langInput = $request->input("languages.$code");

                PromoCardTranslation::create([
                    'promo_card_id' => $promoCard->id,
                    'language_code' => $code,
                    'badge_text' => $langInput['badge_text'] ?? null,
                    'title' => $langInput['title'],
                    'button_text' => $langInput['button_text'] ?? null,
                    'button_url' => $langInput['button_url'] ?? null,
                    'image_url' => $langInput['image_url'] ?? null,
                ]);
            }
        });

        return redirect()->route('admin.promo-cards.index')
            ->with('success', __('cms.promo_cards.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promoCard = PromoCard::findOrFail($id);
        $languages = Language::where('active', 1)->get();
        $translations = PromoCardTranslation::where('promo_card_id', $promoCard->id)
            ->get()
            ->keyBy('language_code');

        return view('admin.promo-cards.edit', compact('promoCard', 'languages', 'translations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $promoCard = PromoCard::findOrFail($id);

        $activeLanguages = Language::where('active', 1)->pluck('code')->toArray();

        $rules = [
            'size' => 'required|in:large,small',
            'order' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ];

        foreach ($activeLanguages as $code) {
            $rules["languages.$code.badge_text"] = 'nullable|string|max:255';
            $rules["languages.$code.title"] = 'required|string|max:255';
            $rules["languages.$code.button_text"] = 'nullable|string|max:255';
            $rules["languages.$code.button_url"] = 'nullable|string|max:255';
            $rules["languages.$code.image_url"] = 'nullable|url|max:500';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($request, $promoCard, $activeLanguages) {
            $promoCard->update([
                'size' => $request->size,
                'order' => $request->order,
                'status' => $request->status,
            ]);

            foreach ($activeLanguages as $code) {
                $langInput = $request->input("languages.$code");

                PromoCardTranslation::updateOrCreate(
                    [
                        'promo_card_id' => $promoCard->id,
                        'language_code' => $code,
                    ],
                    [
                        'badge_text' => $langInput['badge_text'] ?? null,
                        'title' => $langInput['title'],
                        'button_text' => $langInput['button_text'] ?? null,
                        'button_url' => $langInput['button_url'] ?? null,
                        'image_url' => $langInput['image_url'] ?? null,
                    ]
                );
            }
        });

        return redirect()->route('admin.promo-cards.index')
            ->with('success', __('cms.promo_cards.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $promoCard = PromoCard::findOrFail($id);
            $promoCard->delete();

            return response()->json([
                'success' => true,
                'message' => __('cms.promo_cards.deleted'),
            ]);
        } catch (\Exception $e) {
            \Log::error("Error deleting promo card with ID {$id}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the promo card.',
            ]);
        }
    }

    /**
     * Update the status of a promo card.
     */
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:promo_cards,id',
            'status' => 'required|in:0,1',
        ]);

        try {
            $promoCard = PromoCard::findOrFail($request->id);
            $promoCard->status = $request->status;
            $promoCard->save();

            return response()->json([
                'success' => true,
                'message' => __('cms.promo_cards.status_updated'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating promo card status.',
            ]);
        }
    }
}
