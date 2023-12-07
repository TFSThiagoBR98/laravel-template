<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\GenericStatus;
use Carbon\Carbon;
use App\Models;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /** @var Models\User */
        $admin = Models\User::firstOrCreate([
            'email' => "admin@tfs.dev.br",
        ], [
            'name' => "Administração",
            'tax_id' => '032.373.180-51',
            'activated_at' => Carbon::now(),
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('super-admin');

        $company = Models\Company::firstOrCreate([
            Models\Company::ATTRIBUTE_NAME => 'Empresa de Teste Ltda.',
        ], [
            Models\Company::ATTRIBUTE_TAX_ID => '75.594.841/0001-73',
            Models\Company::ATTRIBUTE_STATUS => GenericStatus::Active,
            Models\Company::ATTRIBUTE_VISIBLE_TO_CLIENT => true,
            Models\Company::ATTRIBUTE_EXTRA_ATTRIBUTES => [
                'address' => [
                    'address' => 'Rua Morro da Pedra',
                    'number' => '10',
                    'complement' => '',
                    'reference_point' => '',
                    'neighborhood' => 'Vilar dos Teles',
                    'city' => 'São João de Meriti',
                    'state' => 'RJ',
                    'country' => 'BR',
                    'postal_code' => '25560-371',
                    'latitude' => '0.0',
                    'longitude' => '0.0',
                ],
            ],
        ]);

        Models\Employee::firstOrCreate([
            Models\Employee::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
            Models\Employee::ATTRIBUTE_FK_USER => $admin->{Models\User::ATTRIBUTE_ID},
        ], [
            'role' => 'super-admin',
            'status' => 'active',
        ]);


        $companyId = $company->id;

        $this->command->info("Default company id $companyId\n");

        Models\PaymentMethod::firstOrCreate([
            Models\PaymentMethod::ATTRIBUTE_NAME => 'Dinheiro',
        ], [
            Models\PaymentMethod::ATTRIBUTE_STATUS => 'active',
            Models\PaymentMethod::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
        ]);

        Models\PaymentMethod::firstOrCreate([
            Models\PaymentMethod::ATTRIBUTE_NAME => 'Cartão de Crédito',
        ], [
            Models\PaymentMethod::ATTRIBUTE_STATUS => 'active',
            Models\PaymentMethod::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
        ]);

        Models\PaymentMethod::firstOrCreate([
            Models\PaymentMethod::ATTRIBUTE_NAME => 'Cartão de Débito',
        ], [
            Models\PaymentMethod::ATTRIBUTE_STATUS => 'active',
            Models\PaymentMethod::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
        ]);

        Models\PaymentMethod::firstOrCreate([
            Models\PaymentMethod::ATTRIBUTE_NAME => 'TED/DOC',
        ], [
            Models\PaymentMethod::ATTRIBUTE_STATUS => 'active',
            Models\PaymentMethod::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
        ]);

        Models\PaymentMethod::firstOrCreate([
            Models\PaymentMethod::ATTRIBUTE_NAME => 'PIX',
        ], [
            Models\PaymentMethod::ATTRIBUTE_STATUS => 'active',
            Models\PaymentMethod::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
        ]);

        Models\PaymentMethod::firstOrCreate([
            Models\PaymentMethod::ATTRIBUTE_NAME => 'Boleto',
        ], [
            Models\PaymentMethod::ATTRIBUTE_STATUS => 'active',
            Models\PaymentMethod::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
        ]);

        Models\PaymentMethod::firstOrCreate([
            Models\PaymentMethod::ATTRIBUTE_NAME => 'Outro',
        ], [
            Models\PaymentMethod::ATTRIBUTE_STATUS => 'active',
            Models\PaymentMethod::ATTRIBUTE_FK_COMPANY => $company->{Models\Company::ATTRIBUTE_ID},
        ]);

        DB::table('oauth_clients')->insertOrIgnore([
            'id' => config('lighthouse-graphql-passport.client_id'),
            'name' => 'System Password Grant Client',
            'secret' => config('lighthouse-graphql-passport.client_secret'),
            'provider' => 'users',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'created_at' => '2022-06-22 13:44:07',
            'updated_at' => '2022-06-22 13:44:07',
        ]);
    }
}
