<?php

namespace App\Livewire\Items;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Inventory;
use Filament\Actions\Action as ActionsAction;
use Filament\Notifications\Notification as NotificationsNotification;
use Livewire\Component;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Notifications\Action;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class ListInventories extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Inventory::query())
            ->columns([
                TextColumn::make('item.name')-> searchable(),
                TextColumn::make('item_id'),
                TextColumn::make('quantity') -> sortable() -> badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ActionsAction::make('create')
    ->url(fn (): string => route('Inventory.create'))
    ->openUrlInNewTab()
            ])
           ->recordActions([
                ActionsAction::make('delete')
    ->requiresConfirmation()
    ->action(fn () => dd('action fired'))
    ->action(fn (Inventory $record) => $record->delete())
    ->successNotification(NotificationsNotification::make()
    ->title('Saved successfully')),
    ActionsAction::make('edit')
    ->url(fn (Inventory $record): string => route('Inventories.edit', $record))
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
        return view('livewire.items.list-inventories');
    }
}
