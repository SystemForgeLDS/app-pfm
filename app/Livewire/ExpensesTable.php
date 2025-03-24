<?php

namespace App\Livewire;

use App\Models\Expense;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class ExpensesTable extends BaseWidget
{
    public function getTableHeading(): string
    {
        return 'Lista de Despesas';
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Expense::query()->select(
                    'id',
                    'title',
                    'value',
                    'project_id',
                    'payment_date',
                    'end_date'
                )
            )
            ->columns([
                TextColumn::make('title')
                ->label('Título')
                ->sortable()
                ->searchable()
                ->alignment('center')
                ->url(fn ($record) => route('expense.show', $record->id)),

                TextColumn::make('value')
                ->label('Valor')
                ->sortable()
                ->alignment('center')
                ->money('BRL'),

                TextColumn::make('project.title')
                ->alignment('center'),

                TextColumn::make('payment_date')
                ->placeholder('Aguardando Pagamento')
                ->date()
                ->alignment('center')
                ->sortable()
                ->label('Data de Pagamento'),

                TextColumn::make('end_date')
                ->date()
                ->alignment('center')
                ->sortable()
                ->label('Data de Vencimento'),
            ])
            ->actions([
                EditAction::make()
                    ->url(fn ($record) => route('expense.edit', $record->id))
                    ->label('Editar')
                    ->visible(auth()->user()->isPartner() || auth()->user()->isFinancier()),
                
                DeleteAction::make()
                    ->label('Deletar')
                    ->modalHeading('Tem certeza que deseja excluir este item?')
                    ->modalDescription('Essa ação não pode ser desfeita. Todos os dados relacionados serão perdidos.')
                    ->modalSubmitActionLabel('Sim, excluir') // Altera o nome do botão de confirmação
                    ->modalCancelActionLabel('Cancelar') // Altera o nome do botão de cancelar
                    ->successNotificationTitle('Registro excluído com sucesso!')
                    ->visible(auth()->user()->isPartner() || auth()->user()->isFinancier()),
            ])
            ->filters([
                
            ]);
    }
}
