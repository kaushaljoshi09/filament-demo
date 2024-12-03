<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Filament\Resources\ActivityLogResource\RelationManagers;
use App\Models\Activity;
use App\Models\ActivityLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('log_name')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title Name')
                    ->getStateUsing(function ($record) {
                        $subject = $record->subject;
                        if ($subject?->name) {
                            return $subject->name;
                        }
                        if ($subject?->title) {
                            return $subject->title;
                        }
                        return 'No Title Available';
                }),
                Tables\Columns\TextColumn::make('event_by')
                    ->label('Event By')
                    ->getStateUsing(function ($record) {
                        $causerBy = $record->causer;
                        if ($causerBy?->name) {
                            return $causerBy->name;
                        }
                        if ($causerBy?->title) {
                            return $causerBy->title;
                        }
                        return 'No record Available';
                }),
                Tables\Columns\TextColumn::make('event_type')
                    ->label('Event Method')
                    ->getStateUsing(function ($record) {
                        return ucfirst($record->event);
                }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'create' => Pages\CreateActivityLog::route('/create'),
            'edit' => Pages\EditActivityLog::route('/{record}/edit'),
        ];
    }
}
