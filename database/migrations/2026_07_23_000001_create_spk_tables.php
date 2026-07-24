<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Criteria Table
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // C1, C2, C3, C4
            $table->string('name'); // Integritas, Kesehatan Fisik, Pengalaman Kerja, Kesiapan Shift
            $table->enum('type', ['benefit', 'cost'])->default('benefit');
            $table->float('weight'); // e.g. 25, 30, 25, 20 (Nilai Bobot Asli Wj)
            $table->float('min_val')->default(1.0);
            $table->float('max_val')->default(5.0);
            $table->timestamps();
        });

        // 2. Sub-Criteria Table
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->integer('value'); // 1 - 5
            $table->text('description');
            $table->timestamps();
        });

        // 3. Candidate / Pelamar Table
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // K01, K02, etc.
            $table->string('nik')->nullable();
            $table->string('name');
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['Draft', 'Evaluated'])->default('Draft');
            $table->timestamps();
        });

        // 4. Candidate Scores Table (Nilai Kriteria 1-5 per kandidat)
        Schema::create('candidate_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->integer('score_val'); // 1 - 5
            $table->timestamps();
        });

        // 5. SWOT Evaluations Table
        Schema::create('swot_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->float('strengths_score')->default(3.0); // 1.0 - 5.0
            $table->float('weaknesses_score')->default(2.0); // 1.0 - 5.0
            $table->float('opportunities_score')->default(4.0); // 1.0 - 5.0
            $table->float('threats_score')->default(2.0); // 1.0 - 5.0
            $table->float('ifas_score')->default(0.0); // X = S - W
            $table->float('efas_score')->default(0.0); // Y = O - T
            $table->enum('quadrant', ['SO', 'ST', 'WO', 'WT'])->default('SO');
            $table->string('strategy_recommendation')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 6. Final Calculation Results Table
        Schema::create('calculation_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->float('smart_score')->default(0.0); // Total Skor SMART
            $table->float('swot_score')->default(0.0); // Total Skor SWOT
            $table->float('final_score')->default(0.0); // Combined Score
            $table->integer('rank')->default(0);
            $table->enum('recommendation_status', ['Diterima', 'Pertimbangan', 'Ditolak'])->default('Pertimbangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_results');
        Schema::dropIfExists('swot_evaluations');
        Schema::dropIfExists('candidate_scores');
        Schema::dropIfExists('candidates');
        Schema::dropIfExists('sub_criterias');
        Schema::dropIfExists('criterias');
    }
};
