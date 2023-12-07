<?php

namespace App\Filament\Resources;

use App\Enums\CashFlowStatus;
use App\Enums\CashFlowTransactionType;
use App\Enums\GenericStatus;
use App\Filament\Resources\CashFlowResource\Pages;
use App\Filament\Resources\CashFlowResource\RelationManagers;
use App\Models\CashFlow;
use App\Models\CashFlowTransaction;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CashFlowResource extends Resource
{
    protected static ?string $model = CashFlow::class;

    protected static ?string $label = "Fluxo de Caixa";

    protected static ?string $pluralLabel = "Fluxos de Caixa";

    protected static ?string $navigationGroup = 'Financeiro';

    protected static ?string $navigationIcon = 'icon-cash-register-solid';

    public static function openFlowForm(): array
    {
        return [
            Forms\Components\Select::make('company_id')
                ->label('Empresa')
                ->default(Auth::user()->employees->first()?->company?->{Company::ATTRIBUTE_ID})
                ->relationship('company', 'name')
                ->required(),
            Forms\Components\Hidden::make('employee_open_id')
                ->label('Aberto por')
                ->default(Auth::id())
                ->required(),
            Forms\Components\DatePicker::make('work_date')
                ->label('Data do Caixa')
                ->default(Carbon::now())
                ->required(),
            Forms\Components\DateTimePicker::make('start_date')
                ->label('Data e Hora de Abertura')
                ->default(Carbon::now()),
            \App\Filament\Fields\Money::make('start_amount')
                ->label('Valor Inicial em Caixa')
                ->required(),
        ];
    }

    public static function doWithdrawForm(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Descrição')
                ->required(),
            Forms\Components\Select::make('operation_type')
                ->label('Motivo da Retirada')
                ->options(CashFlowTransactionType::class)
                ->required(),
            \App\Filament\Fields\Money::make('amount')
                ->label('Valor Retirado')
                ->required(),
            Forms\Components\Textarea::make('notes')
                ->columnSpanFull()
                ->label('Observações'),
        ];
    }

    public static function closeFlowForm(): array
    {
        return [
            Forms\Components\Hidden::make('employee_close_id')
                ->label('Aberto por')
                ->default(Auth::id())
                ->required(),
            Forms\Components\DateTimePicker::make('end_date')
                ->label('Data e Hora de Fechamento')
                ->default(Carbon::now())
                ->readOnly()
                ->required(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->label('Empresa')
                    ->default(Auth::user()->employees->first()?->company?->{Company::ATTRIBUTE_ID})
                    ->relationship('company', 'name')
                    ->required(),
                Forms\Components\Select::make('employee_open_id')
                    ->label('Aberto por')
                    ->default(Auth::id())
                    ->relationship('openedBy', 'name', function (Builder $query) {
                        return $query->withGlobalScope('PerCompany', new \App\Scopes\EmployeeScope());
                    })
                    ->required(),
                Forms\Components\Select::make('employee_close_id')
                    ->label('Fechado por')
                    ->relationship('closedBy', 'name', function (Builder $query) {
                        return $query->withGlobalScope('PerCompany', new \App\Scopes\EmployeeScope());
                    }),
                Forms\Components\DatePicker::make('work_date')
                    ->label('Data do Caixa')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Data e Hora de Abertura'),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('Data e Hora de Fechamento'),
                \App\Filament\Fields\Money::make('start_amount')
                    ->label('Valor Inicial em Caixa')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->default(CashFlowStatus::Open)
                    ->options(CashFlowStatus::class)
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Observações'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Empresa')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('openedBy.name')
                    ->label('Aberto por')
                    ->searchable(),
                Tables\Columns\TextColumn::make('closedBy.name')
                    ->label('Fechado por')
                    ->searchable(),
                Tables\Columns\TextColumn::make('work_date')
                    ->label('Data do Caixa')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_amount')
                    ->label('Valor inicial')
                    ->numeric()
                    ->formatStateUsing(static function (Tables\Columns\TextColumn $column, $state): ?string {
                        if (blank($state)) {
                            return null;
                        }

                        return Str::formatMoney($state);
                    })
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('cash_status')
                    ->form([
                        Forms\Components\Radio::make('cash_status')
                            ->label('Estado do Caixa')
                            ->default('all')
                            ->options([
                                'all' => 'Todos',
                                'open' => 'Caixa Aberto',
                                'close' => 'Caixa Fechado',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $entry_type = $data['cash_status'] ?? 'all';
                        if ($entry_type != 'all') {
                            return $query->where('status', ($entry_type ?? ''));
                        }

                        return $query;
                    }),
                Tables\Filters\Filter::make('entry_timestamp')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Período a partir de')
                            ->timezone('America/Sao_Paulo'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Período até')
                            ->timezone('America/Sao_Paulo'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('report')
                        ->label('Imprimir')
                        ->icon('heroicon-m-printer')
                        ->url(fn ($record) => route('reports.print.cashflow', ['id' => $record->getKey()]), true),
                    Tables\Actions\Action::make('add_withdraw')
                        ->label('Fazer Sangria')
                        ->form(self::doWithdrawForm())
                        ->visible(fn (CashFlow $record) =>
                            $record->{CashFlow::ATTRIBUTE_STATUS} == CashFlowStatus::Open)
                        ->requiresConfirmation()
                        ->action(function (CashFlow $record, array $data) {
                            $transaction = new CashFlowTransaction();
                            $transaction->{CashFlowTransaction::ATTRIBUTE_DESCRIPTION} = $data[CashFlowTransaction::ATTRIBUTE_DESCRIPTION];
                            $transaction->{CashFlowTransaction::ATTRIBUTE_OPERATION_TYPE} = $data[CashFlowTransaction::ATTRIBUTE_OPERATION_TYPE];
                            $transaction->{CashFlowTransaction::ATTRIBUTE_AMOUNT} = $data[CashFlowTransaction::ATTRIBUTE_AMOUNT];
                            $transaction->{CashFlowTransaction::ATTRIBUTE_NOTES} = $data[CashFlowTransaction::ATTRIBUTE_NOTES];
                            $transaction->{CashFlowTransaction::ATTRIBUTE_FK_CREATOR} = Auth::id();
                            $transaction->{CashFlowTransaction::ATTRIBUTE_FK_CASH_FLOW} = $record->{CashFlow::ATTRIBUTE_ID};
                            $transaction->{CashFlowTransaction::ATTRIBUTE_FK_COMPANY} = $record->{CashFlow::ATTRIBUTE_FK_COMPANY};
                            $transaction->status = GenericStatus::Active;
                            $transaction->save();
                        })
                        ->icon('heroicon-s-credit-card')
                        ->color('danger'),
                    Tables\Actions\Action::make('close_cashflow')
                        ->label('Fechar Caixa')
                        ->form(self::closeFlowForm())
                        ->visible(fn (CashFlow $record) =>
                            $record->{CashFlow::ATTRIBUTE_STATUS} == CashFlowStatus::Open)
                        ->requiresConfirmation()
                        ->action(function (CashFlow $record, array $data) {
                            $record->employee_close_id = $data['employee_close_id'];
                            $record->end_date = $data['end_date'];
                            $record->status = CashFlowStatus::Close;
                            $record->save();
                        })
                        ->icon('heroicon-s-credit-card')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('work_date', 'desc')
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
            \App\Filament\RelationManagers\AuditRelationManager::class,
            RelationManagers\TransactionsRelationManager::class,
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCashFlow::route('/'),
            'view' => Pages\ViewCashFlow::route('/{record}'),
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
