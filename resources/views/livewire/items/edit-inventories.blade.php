<div>
    <form wire:submit="save">
        {{ $this->form }}

        <x-filament::button type='submit' color="info" class="text-xl rounded-xl border-black border-2 ml-2 shadow-xl">
            Submit
        </x-filament::button>
    </form>

    <x-filament-actions::modals />
</div>
