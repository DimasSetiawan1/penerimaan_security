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
        return redirect()->back()->with('error', 'Data kriteria bersifat standar tetap (fixed database) dan tidak dapat diubah.');
    }

    public function updateSubCriteria(Request $request, $id)
    {
        return redirect()->back()->with('error', 'Indikator penilaian bersifat standar tetap (fixed database) dan tidak dapat diubah.');
    }
}
