<?php

namespace App\Livewire\Items;

use App\Models\item as ModelsItem;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification as NotificationsNotification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\Notification;
use Item;
use Livewire\Component;

class CreateItem extends Component implements HasActions, HasSchemas
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
                Section::make('create an item')
                ->description('create a item name and price')
                ->columns(2)
                ->schema([
        TextInput::make('name')
        ->label('Item Name'),
        TextInput::make('sku'),
        TextInput::make('price')->numeric(),
        ToggleButtons::make('status')
    ->label('is this item active')
    ->options(['active' => 'Active','inactive' => 'In Active']
    )
    ])
            ])
            ->statePath('data')
            ->model(ModelsItem::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = ModelsItem::create($data);

        $this->form->model($record)->saveRelationships();
        NotificationsNotification::make()
        ->title('Item created')
        ->body("item  has been created")
        ->send()
        ->success()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.create-item');
    }
}
