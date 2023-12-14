<?php

use App\Models\Company;
use App\Models\Payment as Model;
use App\Models\User;
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

            $table->string(Model::ATTRIBUTE_DESCRIPTION);
            $table->string(Model::ATTRIBUTE_METHOD);
            $table->json(Model::ATTRIBUTE_PAYMENT_DATA)->nullable();
            $table->json(Model::ATTRIBUTE_CONFIRMATION_DATA)->nullable();
            $table->json(Model::ATTRIBUTE_CHARGEBACK_DATA)->nullable();
            $table->bigInteger(Model::ATTRIBUTE_PRICE);
            $table->timestampTz(Model::ATTRIBUTE_PAID_AT, 6)->nullable();
            $table->string(Model::ATTRIBUTE_ACQUIRER);

            $table->nullableUuidMorphs(Model::MORPH_PAYABLE);
            $table->nullableUuidMorphs(Model::MORPH_PAYER);

            $table->string(Model::ATTRIBUTE_STATUS);
            $table->longText(Model::ATTRIBUTE_NOTES)->nullable();
            $table->schemalessAttributes(Model::ATTRIBUTE_EXTRA_ATTRIBUTES);
            $table->timestampsTz(6);
            $table->softDeletesTz(Model::ATTRIBUTE_DELETED_AT, 6);

            $table->foreignIdFor(User::class, Model::ATTRIBUTE_FK_CREATOR)
                ->nullable();
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
