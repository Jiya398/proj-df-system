<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Faker\Provider\Person;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->collapsible()
                    ->columns(6)
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('middle_name')
                            ->columnSpan(2)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('display_name')
                            ->columnSpanFull()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->columnSpan(3)
                            ->required()
                            ->email()
                            ->unique()
                            ->maxLength(255),

                        Forms\Components\Select::make('gender')
                            ->options([
                                ucfirst(Person::GENDER_MALE) => ucfirst(Person::GENDER_MALE),
                                ucfirst(Person::GENDER_FEMALE) => ucfirst(Person::GENDER_FEMALE)
                            ])
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('password')
                            ->required()
                            ->columnSpan(3)
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('display_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\EditAction::make(),
                    ])->dropdown(false),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

}
