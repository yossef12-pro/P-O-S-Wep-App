<?php

namespace App\Livewire\Items;

use App\Models\Inventory as ModelsInventory;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Inventory;
use Livewire\Component;

class EditInventories extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ModelsInventory $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('bate limiting')
                ->description('Prevent abuse by limiting the number of requests per period')
                ->columns(2)
                ->schema([
        TextInput::make('name')
        ->label('Item Name'),
        TextInput::make('item_id'),
        TextInput::make('quantity')->numeric(),
    ])
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);
        Notification::make()
        ->title('Data Updated')
        ->body("item {$this->record->name} has been updated")
        ->send()
        ->success()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.edit-inventories');
    }
}
