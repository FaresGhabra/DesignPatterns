<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduledTransactionResource\Pages;
use App\Filament\Resources\ScheduledTransactionResource\RelationManagers;
use App\Models\ScheduledTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduledTransactionResource extends Resource
{
    protected static ?string $model = ScheduledTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('source_account_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('target_account_id')
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cron_expression')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('next_run_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('last_run_at'),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('source_account_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_account_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cron_expression')
                    ->searchable(),
                Tables\Columns\TextColumn::make('next_run_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_run_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageScheduledTransactions::route('/'),
        ];
    }
}
