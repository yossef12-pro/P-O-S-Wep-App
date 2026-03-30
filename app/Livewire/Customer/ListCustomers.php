<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Filament\Tables\Columns\TextColumn;

class ListCustomers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Customer::query())
            ->columns([
                TextColumn::make('name') -> searchable(),
                TextColumn::make('age') -> sortable(),
                TextColumn::make('phone') -> searchable(),
                TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
    ->url(fn (): string => route('Customers.create'))
    ->openUrlInNewTab()
            ])
            ->recordActions([
                Action::make('delete')
    ->requiresConfirmation()
    ->action(fn () => dd('action fired'))
    ->action(fn (Customer $record) => $record->delete())
    ->successNotification(Notification::make()
    ->title('Saved successfully')),
    Action::make('edit')
    ->url(fn (Customer $record): string => route('Customers.edit', $record))
    ->openUrlInNewTab()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.customer.list-customers');
    }
}
