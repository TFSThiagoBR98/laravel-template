<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $title = 'Empresas';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modelLabel('Empresa')
            ->pluralModelLabel('Empresas')
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Empresa')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Cargo')
                    ->searchable()
                    ->enum([
                        'super-admin' => 'Administrador Total',
                        'admin' => 'Administrador do Sistema',
                        'owner' => 'Administrador',
                        'viewer_finances' => 'Visualizador Financeiro',
                        'viewer' => 'Visualizador',
                        'manager' => 'Gerente',
                        'attendent' => 'Atendente',
                        'finances' => 'Financeiro',
                        'checker' => 'Porteiro',
                        'minimal' => 'Minimo',
                    ])
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
            ->filters([])
            ->headerActions([])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
