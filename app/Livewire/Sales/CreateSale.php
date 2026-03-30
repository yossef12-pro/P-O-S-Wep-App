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
use Sales;

class CreateSale extends Component implements HasActions, HasSchemas
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
                Section::make('Create sales')
                ->description('Create the sales')
                ->columns(2)
                ->schema([
        TextInput::make('invoice_number')
        ->label('Item Name'),
        TextInput::make('total'),
        TextInput::make('paid_amount')->numeric(),
    ])
            ])
            ->statePath('data')
            ->model(ModelsSales::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = ModelsSales::create($data);

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
        return view('livewire.sales.create-sale');
    }
}
