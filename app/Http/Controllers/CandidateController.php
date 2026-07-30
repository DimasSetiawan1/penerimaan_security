<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criteria;
use App\Models\CandidateScore;
use App\Models\SwotEvaluation;
use App\Services\SmartSwotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    protected $smartSwotService;

    public function __construct(SmartSwotService $smartSwotService)
    {
        $this->smartSwotService = $smartSwotService;
    }

    public function index(Request $request)
    {
        $query = Candidate::with(['scores.criteria', 'swotEvaluation', 'calculationResult']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $candidates = $query->latest()->paginate(10);
        $criterias = Criteria::all();

        return view('candidates.index', compact('candidates', 'criterias'));
    }

    public function create()
    {
        $criterias = Criteria::with('subCriterias')->get();
        // Generate auto candidate code e.g. K06
        $latest = Candidate::orderBy('id', 'desc')->first();
        $nextNum = $latest ? ((int) str_replace('K', '', $latest->code) + 1) : 1;
        $nextCode = 'K' . str_pad($nextNum, 2, '0', STR_PAD_LEFT);

        return view('candidates.create', compact('criterias', 'nextCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:candidates,code'],
            'nik' => ['nullable', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'scores' => ['required', 'array'],
            'scores.*' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        DB::transaction(function () use ($request) {
            $candidate = Candidate::create([
                'code' => $request->code,
                'nik' => $request->nik,
                'name' => $request->name,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => 'Evaluated',
            ]);

            foreach ($request->scores as $critId => $val) {
                CandidateScore::create([
                    'candidate_id' => $candidate->id,
                    'criteria_id' => $critId,
                    'score_val' => $val,
                ]);
            }
        });

        // Recalculate Evaluation Scores
        $this->smartSwotService->calculateAll();

        return redirect()->route('candidates.index')->with('success', 'Data pelamar security berhasil ditambahkan dan dievaluasi.');
    }

    public function edit($id)
    {
        $candidate = Candidate::with(['scores', 'swotEvaluation'])->findOrFail($id);
        $criterias = Criteria::with('subCriterias')->get();

        return view('candidates.edit', compact('candidate', 'criterias'));
    }

    public function update(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        $request->validate([
            'code' => ['required', 'string', 'unique:candidates,code,' . $id],
            'nik' => ['nullable', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'scores' => ['required', 'array'],
            'scores.*' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        DB::transaction(function () use ($request, $candidate) {
            $candidate->update([
                'code' => $request->code,
                'nik' => $request->nik,
                'name' => $request->name,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => 'Evaluated',
            ]);

            foreach ($request->scores as $critId => $val) {
                CandidateScore::updateOrCreate(
                    [
                        'candidate_id' => $candidate->id,
                        'criteria_id' => $critId,
                    ],
                    ['score_val' => $val]
                );
            }
        });

        // Recalculate Evaluation Scores
        $this->smartSwotService->calculateAll();

        return redirect()->route('candidates.index')->with('success', "Data pelamar {$candidate->name} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);
        $name = $candidate->name;
        $candidate->delete();

        // Recalculate SMART & SWOT
        $this->smartSwotService->calculateAll();

        return redirect()->route('candidates.index')->with('success', "Data kandidat {$name} berhasil dihapus.");
    }
}
