<?php

use App\Enums\RequestStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('initiator_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('target_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            //$table->enum('type', []);
            $table->enum('status', RequestStatuses::toArray())
                ->default(RequestStatuses::SENT);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
