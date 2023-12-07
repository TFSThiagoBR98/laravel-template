<?php

namespace App\Filament\Resources\CashFlowResource\RelationManagers;

use App\Enums\CashFlowTransactionType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $title = 'Sangria e Despesas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Descrição')
                    ->required(),
                Forms\Components\Select::make('operation_type')
                    ->label('Motivo da Retirada')
                    ->options(CashFlowTransactionType::class)
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Valor Retirado')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Observações'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modelLabel('Transação de Caixa')
            ->pluralModelLabel('Transações de Caixa')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Descrição'),
                Tables\Columns\TextColumn::make('operation_type')
                    ->label('Tipo de Operação')
                    ->badge(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Montante'),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Observações')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                //
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
