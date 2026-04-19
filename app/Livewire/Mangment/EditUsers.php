<?php

namespace App\Livewire\Mangment;

use App\Models\User as ModelsUser;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EditUsers extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ModelsUser $record;

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
        TextInput::make('name')
        ->label('username'),
        TextInput::make('password'),
        TextInput::make('email'),
        Select::make('role')  
    ->options([
        'admin'   => 'Admin',
        'cashier' => 'Cashier',])
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
        return view('livewire.mangment.edit-users');
    }
}
