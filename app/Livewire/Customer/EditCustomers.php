<?php

namespace App\Livewire\Customer;

use App\Models\Customer as ModelsCustomer;
use Customer;
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

class EditCustomers extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ModelsCustomer $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Edit Customers')
                ->description('Edit the names,emails of Customers')
                ->columns(2)
                ->schema([
        TextInput::make('name')
        ->label('Customer Name'),
        TextInput::make('age'),
        TextInput::make('phone')->numeric(),
        TextInput::make('email')
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
        return view('livewire.customer.edit-customers');
    }
}
