<?php

namespace App\Http\Controllers;

use App\Services\SmartSwotService;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    protected $smartSwotService;

    public function __construct(SmartSwotService $smartSwotService)
    {
        $this->smartSwotService = $smartSwotService;
    }

    public function index()
    {
        $calculationData = $this->smartSwotService->calculateAll();

        return view('calculation.index', compact('calculationData'));
    }
}
