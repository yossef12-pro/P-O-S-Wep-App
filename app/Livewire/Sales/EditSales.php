<?php

namespace App\Livewire\Sales;

use App\Models\Sales as ModelsSales;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;


class EditSales extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ModelsSales $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Edit Users')
                ->description('Edit the role,names,emails of users')
                ->columns(2)
                ->schema([
        TextInput::make('invoice_number')
        ->label('Item Name'),
        TextInput::make('total'),
        TextInput::make('paid_amount')->numeric(),
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
        return view('livewire.sales.edit-sales');
    }
}
