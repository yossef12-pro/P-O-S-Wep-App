<?php

namespace App\Livewire\Mangment;

use App\Models\User as ModelsUser;
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
use Livewire\Component;
use User;

class CreateUsers extends Component implements HasActions, HasSchemas
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
                Section::make('create Users')
                ->description('create the role,names,emails of users')
                ->columns(2)
                ->schema([
        TextInput::make('name')
        ->label('username'),
        TextInput::make('password'),
        TextInput::make('email'),
        Select::make('role')  
    ->options([
        'admin'   => 'Admin',
        'cashier' => 'Cashier',
    ])
    ->default('cashier')
    ->required(),
    ])
            ])
            ->statePath('data')
            ->model(ModelsUser::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $data['password'] = bcrypt($data['password']);
        $record = ModelsUser::create($data);

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
        return view('livewire.mangment.create-users');
    }
}
