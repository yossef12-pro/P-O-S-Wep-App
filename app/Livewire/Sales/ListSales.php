<?php

namespace App\Livewire\Sales;

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
use App\Models\Sales;
use Filament\Actions\Action;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;

class ListSales extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Sales::query())
            ->columns([
    TextColumn::make('invoice_number')
        ->label('Invoice #')
        ->searchable()
        ->sortable(),

    TextColumn::make('total')
        ->label('Total')
        ->money('USD') // غير العملة حسب مشروعك
        ->sortable(),

    TextColumn::make('paid_amount')
        ->label('Paid')
        ->money('USD')
        ->sortable(),
    TextColumn::make('payment_method')
        ->label('Payment Method')
        ->sortable(),
    TextColumn::make('discount')
        ->label('Discount')
        ->sortable(),

])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
    ->url(fn (): string => route('Sales.create'))
    ->openUrlInNewTab()
            ])
            ->recordActions([

            //DELETE BUTTON
                Action::make('delete')
    ->requiresConfirmation()
    ->action(fn () => dd('action fired'))
    ->action(fn (Sales $record) => $record->delete())
    ->successNotification(Notification::make()
    ->title('Saved successfully')),

    //EDIT BUTTON
    Action::make('edit')
    ->url(fn (Sales $record): string => route('Sales.edit', $record))
    ->openUrlInNewTab(),


    // VIEW RECEIPT
    Action::make('view')
    ->label('View')
    ->modalHeading(fn (Sales $record) => 'Invoice: ' . $record->invoice_number)
    ->modalContent(fn (Sales $record) => view(
        'livewire.sales.sale-details',
        ['sale' => $record->load('saleItems.item')]
    ))
    ->modalSubmitAction(false) // no submit button needed
    ->modalCancelActionLabel('Close'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.sales.list-sales');
    }
}
