<?php

namespace App\Livewire\Mangment;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
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
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
class ListUsers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::query())
            ->columns([
                TextColumn::make('name') -> searchable(),
                TextColumn::make('email'),
                TextColumn::make('password'),
            TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
        Action::make('create')
    ->url(fn (): string => route('User.create'))
    ->openUrlInNewTab()
            ])
            ->recordActions([
                Action::make('delete')
    ->requiresConfirmation()
    ->action(fn () => dd('action fired'))
    ->action(fn (User $record) => $record->delete())
    ->successNotification(Notification::make()
    ->title('Saved successfully')),
    Action::make('edit')
    ->url(fn (User $record): string => route('User.edit', $record))
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
        return view('livewire.mangment.list-users');
    }
}
