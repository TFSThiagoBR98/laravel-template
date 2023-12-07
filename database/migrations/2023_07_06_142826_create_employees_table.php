<?php

declare(strict_types=1);

use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Employee;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(Employee::TABLE, function (Blueprint $table) {
            $table->uuid(Employee::ATTRIBUTE_ID)->primary();

            $table->string(Employee::ATTRIBUTE_ROLE)->nullable();
            $table->string(Employee::ATTRIBUTE_STATUS)->default('active');

            $table->foreignIdFor(User::class, Employee::ATTRIBUTE_FK_USER)->nullable()->constrained(User::TABLE, User::ATTRIBUTE_ID)->cascadeOnDelete();
            $table->foreignIdFor(Company::class, Employee::ATTRIBUTE_FK_COMPANY)->constrained(Company::TABLE, Company::ATTRIBUTE_ID)->cascadeOnDelete();

            $table->unique([Employee::ATTRIBUTE_FK_USER, Employee::ATTRIBUTE_FK_COMPANY]);

            $table->schemalessAttributes(Employee::ATTRIBUTE_EXTRA_ATTRIBUTES);
            $table->timestampsTz(6);
            $table->softDeletesTz(Employee::ATTRIBUTE_DELETED_AT, 6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Employee::TABLE);
    }
};
