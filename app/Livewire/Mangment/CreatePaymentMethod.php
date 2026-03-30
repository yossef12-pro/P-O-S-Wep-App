<?php

namespace App\Livewire\Mangment;

use App\Models\PaymentMethod as ModelsPaymentMethod;
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
use PaymentMethod;

class CreatePaymentMethod extends Component implements HasActions, HasSchemas
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
                Section::make('Edit PaymentMethod')
                ->description('Edit the Method of Payment')
                ->columns(2)
                ->schema([
        TextInput::make('name')
        ->label('Item Name'),
        TextInput::make('Description'),
    ])
            ])
            ->statePath('data')
            ->model(ModelsPaymentMethod::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = ModelsPaymentMethod::create($data);

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
        return view('livewire.mangment.create-payment-method');
    }
}
