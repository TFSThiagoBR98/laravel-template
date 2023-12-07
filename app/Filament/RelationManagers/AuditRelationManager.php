<?php

namespace App\Filament\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class AuditRelationManager extends RelationManager
{
    protected static string $relationship = 'audits';

    protected static ?string $title = 'Registros de Auditoria';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('user')
                    ->label('Usuário')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(User::class)
                            ->titleColumnName('name'),
                    ]),
                Forms\Components\TextInput::make('event')
                    ->label('Evento')
                    ->required(),
                Forms\Components\KeyValue::make('old_values')
                    ->label('Valores Antigos'),
                Forms\Components\KeyValue::make('new_values')
                    ->label('Valores novos'),
                Forms\Components\Textarea::make('url')
                    ->label('URL'),
                Forms\Components\TextInput::make('ip_address')
                    ->label('Endereço de IP'),
                Forms\Components\TextInput::make('user_agent')
                    ->label('Agente do Usúario'),
                Forms\Components\TextInput::make('tags')
                    ->label('Tags'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('event')
            ->modelLabel('Registro de Auditoria')
            ->pluralModelLabel('Registros de Auditoria')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->placeholder('Usuário do Sistema')
                    ->label('Nome de usuário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->placeholder('Automático')
                    ->label('Email do usuário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event')
                    ->label('Evento'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Efetuado em')
                    ->dateTime(),
            ])
            ->filters([
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
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }
}
