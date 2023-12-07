<x-filament::page>
    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap items-center gap-4 justify-start">
            <x-filament::button type="submit">
                Salvar
            </x-filament::button>

            <x-filament::button type="button" color="secondary" tag="a" :href="$this->cancel_button_url">
                Cancelar
            </x-filament::button>
        </div>
    </form>

    <x-slot name="title">
        {{ __('filament-2fa::two-factor.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('filament-2fa::two-factor.description') }}
    </x-slot>

    <div class="space-y-3">
        <x-filament::card>
            <livewire:filament-two-factor-form>
        </x-filament::card>
    </div>
</x-filament::page>
