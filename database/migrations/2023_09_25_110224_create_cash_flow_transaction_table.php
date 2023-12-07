<?php

use App\Models\CashFlow;
use App\Models\Company;
use App\Models\CashFlowTransaction as Model;
use App\Models\Employee;
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
            $table->string(Model::ATTRIBUTE_OPERATION_TYPE);
            $table->unsignedBigInteger(Model::ATTRIBUTE_AMOUNT)->default(0);

            $table->string(Model::ATTRIBUTE_STATUS);
            $table->longText(Model::ATTRIBUTE_NOTES)->nullable();
            $table->schemalessAttributes(Model::ATTRIBUTE_EXTRA_ATTRIBUTES);
            $table->timestampsTz(6);
            $table->softDeletesTz(Model::ATTRIBUTE_DELETED_AT, 6);

            $table->foreignIdFor(Company::class, Model::ATTRIBUTE_FK_COMPANY)
                ->constrained(Company::TABLE, Company::ATTRIBUTE_ID)
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class, Model::ATTRIBUTE_FK_CREATOR)
                ->nullable()
                ->constrained(User::TABLE, User::ATTRIBUTE_ID)
                ->cascadeOnDelete();

            $table->foreignIdFor(CashFlow::class, Model::ATTRIBUTE_FK_CASH_FLOW)
                ->constrained(CashFlow::TABLE, CashFlow::ATTRIBUTE_ID)
                ->cascadeOnDelete();
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
