<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Criteria;
use App\Models\CandidateScore;
use App\Models\SwotEvaluation;
use App\Models\CalculationResult;
use Illuminate\Support\Facades\DB;

class SmartSwotService
{
    /**
     * Run complete SMART & SWOT calculation for all candidates or a specific candidate.
     */
    public function calculateAll()
    {
        $criterias = Criteria::all();
        if ($criterias->isEmpty()) {
            return [];
        }

        // 1. Calculate Normalized Weights (w_j = W_j / Sum(W_k))
        $totalWeight = $criterias->sum('weight');
        $normalizedWeights = [];
        foreach ($criterias as $crit) {
            $normalizedWeights[$crit->id] = $totalWeight > 0 ? ($crit->weight / $totalWeight) : 0;
        }

        $candidates = Candidate::with(['scores.criteria', 'swotEvaluation'])->get();
        $results = [];

        foreach ($candidates as $candidate) {
            // 2. Calculate SMART Utility & Total Score
            $utilityScores = [];
            $smartTotal = 0;

            foreach ($criterias as $crit) {
                $scoreModel = $candidate->scores->firstWhere('criteria_id', $crit->id);
                $rawScore = $scoreModel ? $scoreModel->score_val : 1;

                $min = $crit->min_val > 0 ? $crit->min_val : 1;
                $max = $crit->max_val > 0 ? $crit->max_val : 5;

                // Rumus Utilitas: u_i = (C_i - C_min) / (C_max - C_min)
                if ($crit->type === 'benefit') {
                    $utility = ($max - $min) > 0 ? ($rawScore - $min) / ($max - $min) : 0;
                } else {
                    // Cost criteria
                    $utility = ($max - $min) > 0 ? ($max - $rawScore) / ($max - $min) : 0;
                }

                $utilityScores[$crit->id] = [
                    'raw' => $rawScore,
                    'utility' => round($utility, 4),
                    'weighted_utility' => round($utility * $normalizedWeights[$crit->id], 4),
                ];

                $smartTotal += ($utility * $normalizedWeights[$crit->id]);
            }

            // 3. Calculate SWOT Score & IFAS/EFAS
            $swot = $candidate->swotEvaluation;
            if (!$swot) {
                $swot = SwotEvaluation::create([
                    'candidate_id' => $candidate->id,
                    'strengths_score' => 3.0,
                    'weaknesses_score' => 2.0,
                    'opportunities_score' => 4.0,
                    'threats_score' => 2.0,
                    'ifas_score' => 1.0,
                    'efas_score' => 2.0,
                    'quadrant' => 'SO',
                    'strategy_recommendation' => 'Strategi SO: Memanfaatkan Kekuatan Diri secara Maksimal.',
                ]);
            }

            $S = $swot->strengths_score;
            $W = $swot->weaknesses_score;
            $O = $swot->opportunities_score;
            $T = $swot->threats_score;

            $ifas = $S - $W;
            $efas = $O - $T;

            // Quadrant & Strategy
            if ($ifas >= 0 && $efas >= 0) {
                $quadrant = 'SO';
                $strategy = 'Strategi SO (Agresif): Kandidat sangat berpotensi. Manfaatkan kekuatan integritas & fisik untuk meraih peluang operasional.';
            } elseif ($ifas >= 0 && $efas < 0) {
                $quadrant = 'ST';
                $strategy = 'Strategi ST (Diversifikasi): Kandidat tangguh. Gunakan kekuatan fisik & pengalaman untuk meminimalkan ancaman tugas.';
            } elseif ($ifas < 0 && $efas >= 0) {
                $quadrant = 'WO';
                $strategy = 'Strategi WO (Turnaround): Berikan pelatihan tambahan untuk memperbaiki kelemahan sambil memanfaatkan peluang yang ada.';
            } else {
                $quadrant = 'WT';
                $strategy = 'Strategi WT (Defensif): Kandidat berisiko tinggi. Perlu pertimbangan ulang atau eliminasi.';
            }

            // Update SWOT model
            $swot->update([
                'ifas_score' => round($ifas, 2),
                'efas_score' => round($efas, 2),
                'quadrant' => $quadrant,
                'strategy_recommendation' => $strategy,
            ]);

            // SWOT Score Normalized (0 - 1)
            $swotNormalized = (($S + $O) + (5 - $W) + (5 - $T)) / 20;

            // 4. Combined Final Score (70% SMART + 30% SWOT)
            $finalScore = (0.70 * $smartTotal) + (0.30 * $swotNormalized);

            $results[] = [
                'candidate_id' => $candidate->id,
                'candidate' => $candidate,
                'smart_score' => round($smartTotal, 4),
                'smart_score_pct' => round($smartTotal * 100, 2),
                'swot_score' => round($swotNormalized, 4),
                'swot_score_pct' => round($swotNormalized * 100, 2),
                'final_score' => round($finalScore, 4),
                'final_score_pct' => round($finalScore * 100, 2),
                'utility_details' => $utilityScores,
                'swot' => $swot,
            ];
        }

        // 5. Sort by final score descending to determine ranks
        usort($results, function ($a, $b) {
            return $b['final_score'] <=> $a['final_score'];
        });

        // Assign Rank & Recommendation Status & Save to Database
        DB::transaction(function () use (&$results) {
            foreach ($results as $index => &$res) {
                $rank = $index + 1;
                $res['rank'] = $rank;

                $finalPct = $res['final_score_pct'];
                if ($finalPct >= 75) {
                    $status = 'Diterima';
                } elseif ($finalPct >= 55) {
                    $status = 'Pertimbangan';
                } else {
                    $status = 'Ditolak';
                }
                $res['recommendation_status'] = $status;

                CalculationResult::updateOrCreate(
                    ['candidate_id' => $res['candidate_id']],
                    [
                        'smart_score' => $res['smart_score'],
                        'swot_score' => $res['swot_score'],
                        'final_score' => $res['final_score'],
                        'rank' => $rank,
                        'recommendation_status' => $status,
                    ]
                );

                Candidate::where('id', $res['candidate_id'])->update(['status' => 'Evaluated']);
            }
        });

        return [
            'criterias' => $criterias,
            'total_weight' => $totalWeight,
            'normalized_weights' => $normalizedWeights,
            'results' => $results,
        ];
    }
}
