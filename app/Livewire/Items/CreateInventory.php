<?php

namespace App\Livewire\Items;

use App\Models\Inventory as ModelsInventory;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Inventory;
use Livewire\Component;

use function Laravel\Prompts\select;

class CreateInventory extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Create Inventory')
                ->description('Create ne name and quantity of an item')
                ->columns(2)
                ->schema([
        Select::make('item_id') -> relationship('item','name') -> searchable() -> preload(),
        TextInput::make('quantity')->numeric(),
    ])
            ])
            ->statePath('data')
            ->model(ModelsInventory::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $record = ModelsInventory::create($data);

        $this->form->model($record)->saveRelationships();
        Notification::make()
        ->title('Data created')
        ->body("item  has been created")
        ->send()
        ->success()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.create-inventory');
    }
}
