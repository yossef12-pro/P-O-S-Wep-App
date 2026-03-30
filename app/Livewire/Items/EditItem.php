<?php

namespace App\Livewire\Items;

use App\Models\item as ModelsItem;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification as NotificationsNotification;
use Filament\Tables\Columns\Column;
use Illuminate\Notifications\Notification;
use item;

class EditItem extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ModelsItem $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rate limiting')
                ->description('Prevent abuse by limiting the number of requests per period')
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
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);
        NotificationsNotification::make()
        ->title('Data Updated')
        ->body("item {$this->record->name} has been updated")
        ->send()
        ->success()
        ;
    }

    public function render(): View
    {
        return view('livewire.items.edit-item');
    }
}
