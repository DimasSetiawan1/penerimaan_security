<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Services\SmartSwotService;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    protected $smartSwotService;

    public function __construct(SmartSwotService $smartSwotService)
    {
        $this->smartSwotService = $smartSwotService;
    }

    public function index()
    {
        $criterias = Criteria::with('subCriterias')->get();
        $totalWeight = $criterias->sum('weight');

        return view('criteria.index', compact('criterias', 'totalWeight'));
    }

    public function updateWeight(Request $request, $id)
    {
        $request->validate([
            'weight' => ['required', 'numeric', 'min:1', 'max:100'],
        ]);

        $criteria = Criteria::findOrFail($id);
        $criteria->update(['weight' => $request->weight]);

        // Recalculate results
        $this->smartSwotService->calculateAll();

        return redirect()->back()->with('success', "Bobot kriteria {$criteria->code} berhasil diperbarui.");
    }

    public function updateSubCriteria(Request $request, $id)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:255'],
        ]);

        $sub = SubCriteria::findOrFail($id);
        $sub->update(['description' => $request->description]);

        return redirect()->back()->with('success', "Sub-kriteria Nilai {$sub->value} berhasil diperbarui.");
    }
}
