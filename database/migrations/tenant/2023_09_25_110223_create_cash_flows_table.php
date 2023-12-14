<?php

use App\Models\Company;
use App\Models\CashFlow as Model;
use App\Models\Payment;
use App\Models\PaymentChargeBack;
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

            $table->date(Model::ATTRIBUTE_WORK_DATE);
            $table->dateTimeTz(Model::ATTRIBUTE_START_DATE, 6)->nullable();
            $table->dateTimeTz(Model::ATTRIBUTE_END_DATE, 6)->nullable();
            $table->unsignedBigInteger(Model::ATTRIBUTE_START_AMOUNT)->default(0);

            $table->string(Model::ATTRIBUTE_STATUS);
            $table->longText(Model::ATTRIBUTE_NOTES)->nullable();
            $table->schemalessAttributes(Model::ATTRIBUTE_EXTRA_ATTRIBUTES);
            $table->timestampsTz(6);
            $table->softDeletesTz(Model::ATTRIBUTE_DELETED_AT, 6);

            $table->foreignIdFor(User::class, Model::ATTRIBUTE_FK_OPEN_EMPLOYEE)
                ->nullable();

            $table->foreignIdFor(User::class, Model::ATTRIBUTE_FK_CLOSE_EMPLOYEE)
                ->nullable();
        });

        Schema::table(Payment::TABLE, function (Blueprint $table) {
            $table->foreignIdFor(Model::class, Payment::ATTRIBUTE_FK_CASH_FLOW)
                ->nullable()
                ->constrained(Model::TABLE, Model::ATTRIBUTE_ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Payment::TABLE, function (Blueprint $table) {
            $table->dropForeignIdFor(Model::class, Payment::ATTRIBUTE_FK_CASH_FLOW);
        });

        Schema::dropIfExists(Model::TABLE);
    }
};
