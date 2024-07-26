<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UserResource extends Resource
{
    protected static ?string $model                    = User::class;
    protected static ?string $navigationIcon           = 'heroicon-o-users';
    protected static ?string $navigationGroup          = 'Master Data';
    protected static ?string $label                    = 'Daftar Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    Section::make()
                        ->schema(
                            [
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->autofocus()
                                    ->required(),

                                CheckboxList::make(__('filament-shield.column.roles'))
                                    ->label('Jenis Karyawan')
                                    ->required()
                                    ->relationship('roles', 'name')
                                    ->getOptionLabelFromRecordUsing(
                                        fn (Model $record) => str($record->name)->headline(),
                                    ),
                                TextInput::make('username')
                                    ->required()
                                    ->label('Kode Karyawan / Username'),

                                // TextInput::make('email')
                                //     ->email(),
                            ],
                        ),

                    Section::make()
                        ->schema(
                            [
                                TextInput::make('password')
                                    ->hint('isi jika bisa login')
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->password(),
                            ],
                        ),
                ],
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->notAdmin())
            ->columns(
                [
                    TextColumn::make('name')
                        ->searchable()
                        ->toggleable(),
                    TextColumn::make('username')
                        ->label('Kode Karyawan / Username')
                        ->searchable()
                        ->toggleable(),
                    TextColumn::make('roles.name')
                        ->label('Jenis Karyawan')
                        ->searchable()
                        ->toggleable(),
                ],
            )
            ->filters(
                [
                    Tables\Filters\TrashedFilter::make(),
                ],
            )
            ->actions(
                [
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                ],
            )
            ->bulkActions(
                [
                    Tables\Actions\BulkActionGroup::make(
                        [
                            Tables\Actions\DeleteBulkAction::make(),
                            Tables\Actions\RestoreBulkAction::make(),
                            Tables\Actions\ForceDeleteBulkAction::make(),
                        ],
                    ),

                    ExportBulkAction::make(),
                ],
            );
    }

    public static function getRelations(): array
    {
        return [
            // RoleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes(
                [],
            );
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'username'];
    }
}
