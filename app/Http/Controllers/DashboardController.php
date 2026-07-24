<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criteria;
use App\Models\CalculationResult;
use App\Models\SwotEvaluation;
use App\Services\SmartSwotService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $smartSwotService;

    public function __construct(SmartSwotService $smartSwotService)
    {
        $this->smartSwotService = $smartSwotService;
    }

    public function index()
    {
        // Re-run calculations for up-to-date data
        $this->smartSwotService->calculateAll();

        $totalCandidates = Candidate::count();
        $totalCriterias = Criteria::count();
        $evaluatedCount = Candidate::where('status', 'Evaluated')->count();

        $topResults = CalculationResult::with(['candidate.swotEvaluation'])
            ->orderBy('rank', 'asc')
            ->take(5)
            ->get();

        $quadrantsCount = [
            'SO' => SwotEvaluation::where('quadrant', 'SO')->count(),
            'ST' => SwotEvaluation::where('quadrant', 'ST')->count(),
            'WO' => SwotEvaluation::where('quadrant', 'WO')->count(),
            'WT' => SwotEvaluation::where('quadrant', 'WT')->count(),
        ];

        $statusCount = [
            'Diterima' => CalculationResult::where('recommendation_status', 'Diterima')->count(),
            'Pertimbangan' => CalculationResult::where('recommendation_status', 'Pertimbangan')->count(),
            'Ditolak' => CalculationResult::where('recommendation_status', 'Ditolak')->count(),
        ];

        return view('dashboard', compact(
            'totalCandidates',
            'totalCriterias',
            'evaluatedCount',
            'topResults',
            'quadrantsCount',
            'statusCount'
        ));
    }
}
