<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Rawilk\FilamentPasswordInput\Password;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = "Perfil";

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Conta';

    protected static string $view = 'filament.pages.profile';

    public $name;

    public $email;

    public $current_password;

    public $new_password;

    public $new_password_confirmation;

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function submit(): void
    {
        $this->form->getState();

        $state = array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->new_password ? Hash::make($this->new_password) : null,
        ]);

        /** @var \App\Models\User */
        $user = auth()->user();

        $user->update($state);

        if ($this->new_password) {
            $this->updateSessionPassword($user);
        }

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        Notification::make()
            ->title('Seu perfil foi atualizado.')
            ->success()
            ->send();
    }

    private function updateSessionPassword(User $user): void
    {
        request()->session()->put([
            'password_hash_' . auth()->getDefaultDriver() => $user->getAuthPassword(),
        ]);
    }

    public function getCancelButtonUrlProperty(): string
    {
        return static::getUrl();
    }

    public function getBreadcrumbs(): array
    {
        return [
            url()->current() => 'Perfil',
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Geral')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required(),
                    TextInput::make('email')
                        ->label('Endereço de Email')
                        ->required(),
                ]),
            Section::make('Atualizar senha')
                ->columns(2)
                ->schema([
                    Password::make('current_password')
                        ->label('Senha atual')
                        ->rules(['required_with:new_password'])
                        ->currentPassword()
                        ->autocomplete('off')
                        ->columnSpan(1),
                    Grid::make()
                        ->schema([
                            Password::make('new_password')
                                ->label('Nova senha')
                                ->rules(['confirmed'])
                                ->autocomplete('new-password'),
                            Password::make('new_password_confirmation')
                                ->label('Confirmar nova senha')
                                ->rules([
                                    'required_with:new_password',
                                ])
                                ->autocomplete('new-password'),
                        ]),
                ]),
        ];
    }
}
