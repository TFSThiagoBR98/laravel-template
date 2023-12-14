<?php

use App\Models\Company;
use App\Models\PaymentMethod as Model;
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
        Schema::create(Model::TABLE, function (Blueprint $table) {
            $table->uuid(Model::ATTRIBUTE_ID)->primary();

            $table->string(Model::ATTRIBUTE_NAME);

            $table->string(Model::ATTRIBUTE_STATUS);
            $table->longText(Model::ATTRIBUTE_NOTES)->nullable();
            $table->schemalessAttributes(Model::ATTRIBUTE_EXTRA_ATTRIBUTES);
            $table->timestampsTz(6);
            $table->softDeletesTz(Model::ATTRIBUTE_DELETED_AT, 6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Model::TABLE);
    }
};
