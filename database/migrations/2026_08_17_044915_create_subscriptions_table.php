<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained();
            $table->unsignedInteger('hours_allocated')->default(160);
            $table->unsignedInteger('hours_used')->default(0);
            $table->string('status', 20)->default('active'); // active | paused | cancelled
            $table->date('started_at')->nullable();
            $table->date('renews_at')->nullable();
            $table->foreignId('account_manager_id')->nullable()->constrained('staff_members')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
