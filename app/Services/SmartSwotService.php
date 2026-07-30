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

            // 3. Automatically Calculate SWOT Scores from Sub-Criteria Scores (C1 - C4)
            $c1Val = 1; $c2Val = 1; $c3Val = 1; $c4Val = 1;
            foreach ($criterias as $crit) {
                $scoreModel = $candidate->scores->firstWhere('criteria_id', $crit->id);
                $rawScore = $scoreModel ? $scoreModel->score_val : 1;
                if ($crit->code === 'C1') $c1Val = $rawScore;
                elseif ($crit->code === 'C2') $c2Val = $rawScore;
                elseif ($crit->code === 'C3') $c3Val = $rawScore;
                elseif ($crit->code === 'C4') $c4Val = $rawScore;
            }

            // Derive S, W, O, T from sub-criteria
            $S = round(($c1Val + $c2Val + $c3Val) / 3, 2);
            $W = round(6 - $S, 2);
            $O = round((float) $c4Val, 2);
            $T = round(6 - (float) $c4Val, 2);

            $ifas = $S - $W;
            $efas = $O - $T;

            // Professional Profile Qualification & Strategy Recommendation
            if ($ifas >= 0 && $efas >= 0) {
                $quadrant = 'SO';
                $strategy = 'Kualifikasi Sangat Layak: Memiliki integritas tinggi, fisik prima, serta tingkat fleksibilitas operasional yang sangat baik.';
            } elseif ($ifas >= 0 && $efas < 0) {
                $quadrant = 'ST';
                $strategy = 'Kualifikasi Layak: Memiliki fisik & pengalaman yang baik, siap mengantisipasi tantangan tugas lapangan.';
            } elseif ($ifas < 0 && $efas >= 0) {
                $quadrant = 'WO';
                $strategy = 'Kualifikasi Pertimbangan: Memerlukan pelatihan tambahan untuk meningkatkan kompetensi fisik & kedisiplinan.';
            } else {
                $quadrant = 'WT';
                $strategy = 'Kualifikasi Tidak Layak: Profil kandidat belum memenuhi standar kualifikasi & fleksibilitas kerja minimal.';
            }

            // Create or update SWOT model
            $swot = $candidate->swotEvaluation;
            if (!$swot) {
                $swot = SwotEvaluation::create([
                    'candidate_id' => $candidate->id,
                    'strengths_score' => $S,
                    'weaknesses_score' => $W,
                    'opportunities_score' => $O,
                    'threats_score' => $T,
                    'ifas_score' => round($ifas, 2),
                    'efas_score' => round($efas, 2),
                    'quadrant' => $quadrant,
                    'strategy_recommendation' => $strategy,
                ]);
            } else {
                $swot->update([
                    'strengths_score' => $S,
                    'weaknesses_score' => $W,
                    'opportunities_score' => $O,
                    'threats_score' => $T,
                    'ifas_score' => round($ifas, 2),
                    'efas_score' => round($efas, 2),
                    'quadrant' => $quadrant,
                    'strategy_recommendation' => $strategy,
                ]);
            }

            // SWOT Score Normalized (0 - 1)
            $swotNormalized = (($S + $O) + (5 - $W) + (5 - $T)) / 20;

            // 4. Combined Final Score (70% Bobot Kriteria + 30% Bobot Evaluasi Potensi)
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
