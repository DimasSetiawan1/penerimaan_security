<?php

namespace App\Http\Controllers;

use App\Models\CalculationResult;
use App\Models\Criteria;
use App\Services\SmartSwotService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $smartSwotService;

    public function __construct(SmartSwotService $smartSwotService)
    {
        $this->smartSwotService = $smartSwotService;
    }

    public function index(Request $request)
    {
        $this->smartSwotService->calculateAll();

        $query = CalculationResult::with(['candidate.scores.criteria', 'candidate.swotEvaluation']);

        if ($request->filled('status')) {
            $query->where('recommendation_status', $request->status);
        }

        $results = $query->orderBy('rank', 'asc')->get();
        $criterias = Criteria::all();

        return view('reports.index', compact('results', 'criterias'));
    }

    public function print(Request $request)
    {
        $this->smartSwotService->calculateAll();

        $query = CalculationResult::with(['candidate.scores.criteria', 'candidate.swotEvaluation']);

        if ($request->filled('status')) {
            $query->where('recommendation_status', $request->status);
        }

        $results = $query->orderBy('rank', 'asc')->get();
        $criterias = Criteria::all();

        return view('reports.print', compact('results', 'criterias'));
    }
}
