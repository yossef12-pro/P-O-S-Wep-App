<?php

namespace App\Livewire\Mangment;

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
use Livewire\Component;
use App\Models\PaymentMethod;
use Filament\Actions\Action as ActionsAction;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Notifications\Action;

class ListPaymentMethods extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => PaymentMethod::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                 ActionsAction::make('create')
    ->url(fn (): string => route('PaymentMethod.create'))
    ->openUrlInNewTab()
            ])
            ->recordActions([
                ActionsAction::make('delete')
    ->requiresConfirmation()
    ->action(fn () => dd('action fired'))
    ->action(fn (PaymentMethod $record) => $record->delete())
    ->successNotification(Notification::make()
    ->title('Saved successfully')),
    ActionsAction::make('edit')
    ->url(fn (PaymentMethod $record): string => route('PaymentMethod.edit', $record))
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
        return view('livewire.mangment.list-payment-methods');
    }
}
