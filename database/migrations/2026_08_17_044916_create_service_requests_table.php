<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('type', 40)->default('general'); // bookkeeping | accounting | payroll | vat | reporting | secretarial | consulting | general
            $table->text('description')->nullable();
            $table->string('status', 20)->default('pending'); // pending | in_progress | completed | cancelled
            $table->string('priority', 20)->default('normal'); // low | normal | high
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
