<?php

namespace App\Filament\Resources\CashFlowResource\RelationManagers;

use App\Models\Company;
use App\Models\Courtyard;
use App\Models\Employee;
use App\Models\RemovalOrder;
use App\Models\Payment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\PaymentMethod;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Pagamentos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->label('Empresa')
                    ->default(Auth::user()->employees->first()?->company?->{Company::ATTRIBUTE_ID})
                    ->relationship('company', 'name')
                    ->required(),
                Forms\Components\Select::make('creator_id')
                    ->label('Usuário')
                    ->native(false)
                    ->default(Auth::id())
                    ->relationship('creator', 'name', function (Builder $query) {
                        return $query->withGlobalScope('PerCompany', new \App\Scopes\EmployeeScope());
                    })
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->required(),
                Forms\Components\Select::make('method')
                    ->label('Método de Pagamento')
                    ->relationship('paymentMethod', 'name')
                    ->required(),
                Forms\Components\KeyValue::make('payment_data')
                    ->label('Dados de Pagamento')
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('confirmation_data')
                    ->label('Dados de Confirmação')
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('chargeback_data')
                    ->label('Dados de Estorno')
                    ->columnSpanFull(),
                \App\Filament\Fields\Money::make('price')
                    ->label('Preço Pago')
                    ->required(),
                Forms\Components\DateTimePicker::make('paid_at')
                    ->label('Data e Hora do Pagamento'),
                Forms\Components\TextInput::make('acquirer')
                    ->label('Adquirente')
                    ->default('manual')
                    ->required(),
                Forms\Components\MorphToSelect::make('payable')
                    ->label('Item Pago')
                    ->types([
                    ]),
                Forms\Components\MorphToSelect::make('payer')
                    ->label('Entidade Pagante')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(User::class)
                            ->label('Usuário')
                            ->titleAttribute('email'),
                        Forms\Components\MorphToSelect\Type::make(Employee::class)
                            ->label('Membro da Empresa')
                            ->titleAttribute('name'),
                    ]),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->default('paid')
                    ->options([
                        'pending' => 'Pagamento Pendente',
                        'paid' => 'Pago',
                        'chargeback' => 'Estornado',
                        'canceled' => 'Cancelado',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('Observações'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->modelLabel('Pagamento')
            ->pluralModelLabel('Pagamentos')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paymentMethod.name')
                    ->label('Método de Pagamento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Valor Pago')
                    ->formatStateUsing(static function (Tables\Columns\TextColumn $column, $state): ?string {
                        if (blank($state)) {
                            return null;
                        }

                        return Str::formatMoney($state);
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('payable_type')
                    ->label('Entidade Paga')
                    ->getStateUsing(function (Payment $record): string {
                         if ($record->payable instanceof RemovalOrder) {
                             return 'Liberação';
                         } else {
                             return $record->payable_type;
                         }
                    })
                    ->url(function (Payment $record): ?string {
                        if ($record->payable instanceof RemovalOrder) {
                            return route('filament.admin.resources.removal-orders.view', ['record' => $record->payable->getKey()]);
                        } else {
                            return null;
                        }
                    }, true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Feito por')
                    ->searchable(),
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
                Tables\Filters\SelectFilter::make('payment_method')
                    ->form([
                        Forms\Components\Radio::make('payment_method_id')
                            ->label('Forma de Pagamento')
                            ->default('all')
                            ->options(fn () => array_merge([
                                'all' => 'Todos',
                            ], PaymentMethod::query()
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(static fn (PaymentMethod $record) => [
                                    $record->id => $record->name ?? 'Vazio',
                                ])
                                ->toArray())),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $entry_type = $data['payment_method_id'] ?? 'all';
                        if ($entry_type != 'all') {
                            return $query->where(Payment::ATTRIBUTE_FK_PAYMENT_METHOD, ($entry_type ?? ''));
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
                                fn (Builder $query, $date): Builder => $query->whereDate(Payment::ATTRIBUTE_CREATED_AT, '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate(Payment::ATTRIBUTE_CREATED_AT, '<=', $date),
                            );
                    }),
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
