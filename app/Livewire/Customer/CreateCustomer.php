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

class CreateCustomer extends Component implements HasActions, HasSchemas
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
                Section::make('Create Customers')
                ->description('Create the names,emails of Customers')
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
            ->model(ModelsCustomer::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = ModelsCustomer::create($data);

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
        return view('livewire.customer.create-customer');
    }
}
