<?php

namespace App\Filament\Resources;

use App\Exports\RegistrationExport;
use App\Filament\Resources\InternationalRegistrationResource\Pages;
use App\Filament\Resources\InternationalRegistrationResource\RelationManagers;
use App\Models\Registration;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class InternationalRegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'International Registration';

    public static function getBreadcrumb(): string
    {
        return 'International Registration';
    }

    public static function getModelLabel(): string
    {
        return 'International Registration';
    }

    public static function getPluralModelLabel(): string
    {
        return 'International Registration List';
    }

    public static function getEloquentQuery(): Builder
    {
        $records = parent::getEloquentQuery()->where('register_type', 'international'); // or 'vietnamese'
        return $records;
    }

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
                Tables\Columns\TextColumn::make('registration_code')->label('Registration Code')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->formatStateUsing(function ($state, $record) {
                        // $state là array (do được cast)
                        if (!is_array($state)) return $state;

                        // Nếu có 'Other' thì trả về other_title
                        if (in_array('Other', $state)) {
                            return $record->other_title ?: 'Other';
                        }

                        // Ngược lại nối lại thành chuỗi
                        return implode(', ', $state);
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fullname')->label('Full Name')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('position')->label('Position'),

                Tables\Columns\TextColumn::make('organization')->label('Organization')->searchable(),

                Tables\Columns\TextColumn::make('address')->label('Address'),

                Tables\Columns\TextColumn::make('display_country')->label('Country'),

                Tables\Columns\TextColumn::make('phone')->label('Phone'),

                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),

                Tables\Columns\TextColumn::make('display_dietary_requirement')->label('Dietary'),

                Tables\Columns\TextColumn::make('display_conference')
                    ->formatStateUsing(function ($state) {
                        $data = json_decode($state, true);
                        return $data
                            ? "{$data['label']}"
                            : 'Invalid JSON';
                    })
                    ->label('Conference Type')
                    ->wrap(), // Nếu label dài quá thì cho xuống dòng

                Tables\Columns\TextColumn::make('paper_title')->label('Paper Title')->wrap(),

                Tables\Columns\TextColumn::make('payment_method')->label('Payment Method'),

                Tables\Columns\TextColumn::make('payment_status')->label('Payment Status'),

                // Tables\Columns\TextColumn::make('register_type')->label('Register Type'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($action) {
                        $query = $action->getLivewire()->getFilteredTableQuery();

                        return Excel::download(new RegistrationExport($query, 'international'), 'registration_international_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
                    }),
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
            'index' => Pages\ListInternationalRegistrations::route('/')
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
