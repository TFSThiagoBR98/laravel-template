<?php

use App\Models\Company;
use App\Models\AcquirerTransaction as Model;
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

            $table->string(Model::ATTRIBUTE_DESCRIPTION)->nullable();
            $table->string(Model::ATTRIBUTE_OPERATION)->nullable();
            $table->string(Model::ATTRIBUTE_METHOD);
            $table->json(Model::ATTRIBUTE_REQUEST);
            $table->json(Model::ATTRIBUTE_RESPONSE);
            $table->string(Model::ATTRIBUTE_HTTP_CODE);
            $table->string(Model::ATTRIBUTE_ACQUIRER)->nullable();

            $table->nullableUuidMorphs(Model::MORPH_PAYABLE);
            $table->nullableUuidMorphs(Model::MORPH_PAYER);

            $table->string(Model::ATTRIBUTE_STATUS);
            $table->longText(Model::ATTRIBUTE_NOTES)->nullable();
            $table->schemalessAttributes(Model::ATTRIBUTE_EXTRA_ATTRIBUTES);
            $table->timestampsTz(6);
            $table->softDeletesTz(Model::ATTRIBUTE_DELETED_AT, 6);

            $table->foreignIdFor(Company::class, Model::ATTRIBUTE_FK_COMPANY)
                ->constrained(Company::TABLE, Company::ATTRIBUTE_ID)->cascadeOnDelete();
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
