<?php

namespace App\Filament\Company\Resources;

use App\Enums\GenericStatus;
use App\Filament\RelationManagers\AuditRelationManager;
use App\Filament\Company\Resources\EmployeeResource\Pages;
use App\Filament\Company\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Rawilk\FilamentPasswordInput\Password;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $label = "Membro da Empresa";

    protected static ?string $pluralLabel = "Membros da Empresa";

    protected static ?string $navigationIcon = 'icon-business-card';

    protected static ?string $navigationGroup = 'Usuarios e Permissões';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', User::TABLE . '.' . User::ATTRIBUTE_NAME)
                    ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name)
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome completo')
                            ->regex('/^[^(\|\]~`!%#¨^&*=\$\@};:+\"\”\“\/\[\\\\\{\}?><’)]*$/u')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->unique(table: User::TABLE)
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('tax_id')
                            ->label('CPF')
                            ->required(),
                        Password::make('password')
                            ->same('passwordConfirmation')
                            ->maxLength(255)
                            ->required(fn ($record) =>  $record === null)
                            ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : "")
                            ->label('Senha'),
                        Password::make('passwordConfirmation')
                            ->dehydrated(false)
                            ->maxLength(255)
                            ->label('Confirmar Senha'),
                    ]),
                Forms\Components\Select::make('company_id')
                    ->label('Empresa')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('role')
                    ->label('Cargo')
                    ->default('active')
                    ->options(function () {
                        $user = Auth::user();
                        if ($user->hasRole('super-admin')) {
                            return [
                                'super-admin' => 'Administrador Total',
                                'admin' => 'Administrador do Sistema',
                                'owner' => 'Administrador',
                                'viewer_finances' => 'Visualizador Financeiro',
                                'viewer' => 'Visualizador',
                                'manager' => 'Gerente',
                                'attendent' => 'Atendente',
                                'finances' => 'Financeiro',
                                'minimal' => 'Minimo',
                            ];
                        } else if ($user->hasRole('admin')) {
                            return [
                                'admin' => 'Administrador do Sistema',
                                'owner' => 'Administrador',
                                'viewer_finances' => 'Visualizador Financeiro',
                                'viewer' => 'Visualizador',
                                'manager' => 'Gerente',
                                'attendent' => 'Atendente',
                                'finances' => 'Financeiro',
                                'minimal' => 'Minimo',
                            ];
                        } else if ($user->hasRole('owner')) {
                            return [
                                'owner' => 'Administrador',
                                'viewer_finances' => 'Visualizador Financeiro',
                                'viewer' => 'Visualizador',
                                'manager' => 'Gerente',
                                'attendent' => 'Atendente',
                                'finances' => 'Financeiro',
                                'minimal' => 'Minimo',
                            ];
                        } else if ($user->hasRole('manager')) {
                            return [
                                'viewer_finances' => 'Visualizador Financeiro',
                                'viewer' => 'Visualizador',
                                'attendent' => 'Atendente',
                                'finances' => 'Financeiro',
                                'minimal' => 'Minimo',
                            ];
                        } else {
                            return [
                                'minimal' => 'Minimo',
                            ];
                        }
                    })
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->default(GenericStatus::Active)
                    ->options(GenericStatus::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Empresa')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.tax_id')
                    ->label('CPF/CNPJ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Cargo')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuditRelationManager::class,
            RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
