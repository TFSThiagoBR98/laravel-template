<?php

namespace App\Filament\Resources;

use App\Filament\RelationManagers\AuditRelationManager;
use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use App\Enums;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $label = "Empresa";

    protected static ?string $pluralLabel = "Empresas";

    protected static ?string $navigationIcon = 'icon-business-r';

    protected static ?string $navigationGroup = 'Gestão';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Forms\Components\TextInput::make('tax_id')
                    ->label('CNPJ')
                    ->required(),
                Forms\Components\Toggle::make('visible_to_client')
                    ->label('Visível')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->default(Enums\GenericStatus::Active)
                    ->options(Enums\GenericStatus::class)
                    ->required(),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('Endereço'),
                        FilamentPtbrFormFields\Cep::make('extra_attributes.address.postal_code')
                            ->label('CEP')
                            ->viaCep(
                                mode: 'suffix',
                                errorMessage: 'CEP inválido.',
                                setFields: [
                                    'extra_attributes.address.address' => 'logradouro',
                                    'extra_attributes.address.number' => 'numero',
                                    'extra_attributes.address.complement' => 'complemento',
                                    'extra_attributes.address.neighborhood' => 'bairro',
                                    'extra_attributes.address.city' => 'localidade',
                                    'extra_attributes.address.uf' => 'uf'
                                ]
                            )
                            ->required(),
                        Forms\Components\TextInput::make('extra_attributes.address.address')
                            ->label('Logradouro')
                            ->required(),
                        Forms\Components\TextInput::make('extra_attributes.address.number')
                            ->label('Número')
                            ->required(),
                        Forms\Components\TextInput::make('extra_attributes.address.complement')
                            ->label('Complemento'),
                        Forms\Components\TextInput::make('extra_attributes.address.neighborhood')
                            ->label('Bairro')
                            ->required(),
                        Forms\Components\TextInput::make('extra_attributes.address.city')
                            ->label('Cidade')
                            ->required(),
                        Forms\Components\TextInput::make('extra_attributes.address.state')
                            ->label('UF')
                            ->required(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('Configurações gerais'),
                        Forms\Components\Select::make('extra_attributes.settings.cashflow_method')
                            ->label('Modelo de Caixa')
                            ->default('global')
                            ->options([
                                'global' => 'Um Caixa para Todos os Usuários',
                                'per_user' => 'Um Caixa por Usuário',
                            ])
                            ->required(),
                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('Domínios e Bancos de Dados'),
                        Forms\Components\Repeater::make('domains')
                            ->label('Domínio')
                            ->relationship()
                            ->defaultItems(0)
                            ->schema([
                                Forms\Components\TextInput::make('domain')
                                    ->label('Nome do Host')
                                    ->required(),
                            ])
                            ->disableLabel(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tax_id')
                    ->label('CNPJ')
                    ->searchable(),
                Tables\Columns\IconColumn::make('visible_to_client')
                    ->label('Vísivel')
                    ->boolean(),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
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
