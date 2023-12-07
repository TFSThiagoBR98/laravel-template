<?php

namespace App\Filament\Resources\CashFlowResource\Pages;

use App\Filament\Resources\CashFlowResource;
use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class ManageCashFlow extends ManageRecords
{
    protected static string $resource = CashFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function configureCreateAction(CreateAction|\Filament\Tables\Actions\CreateAction $action): void
    {
        $resource = static::getResource();

        $model = $this->getModel();
        $action
            ->authorize($resource::canCreate())
            ->model($this->getModel())
            ->using(function (array $data, HasActions $livewire) use ($model): Model {
                $data = $this->mutateFormDataBeforeCreate($data);

                if ($translatableContentDriver = $livewire->makeFilamentTranslatableContentDriver()) {
                    $record = $translatableContentDriver->makeRecord($model, $data);
                } else {
                    $record = new $model();
                    $record->fill($data);
                }

                $record->save();

                return $record;
            })
            ->modelLabel($this->getModelLabel() ?? static::getResource()::getModelLabel())
            ->form(fn (Form $form): Form => $form
                ->columns(2)
                ->schema($resource::openFlowForm())
            );

        if ($action instanceof CreateAction) {
            $action->relationship(($tenant = Filament::getTenant()) ? fn (): Relation => static::getResource()::getTenantRelationship($tenant) : null);
        }

        if ($resource::hasPage('create')) {
            $action->url(fn (): string => $resource::getUrl('create'));
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'open';

        return $data;
    }
}
