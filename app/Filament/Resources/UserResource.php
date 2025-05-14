<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

     // PERUBAHAN: Mengubah icon navigasi menjadi lebih sesuai untuk user
    protected static ?string $navigationIcon = 'heroicon-o-users'; // Sebelumnya: 'heroicon-o-rectangle-stack'
    
    // PERUBAHAN: Menambahkan label navigasi
    protected static ?string $navigationLabel = 'Users'; // Baru ditambahkan
    
    // PERUBAHAN: Menambahkan label model
    protected static ?string $modelLabel = 'User'; // Baru ditambahkan
    
    // PERUBAHAN: Menambahkan label plural model
    protected static ?string $pluralModelLabel = 'Users'; // Baru ditambahkan
    
    // PERUBAHAN: Menambahkan urutan navigasi
    protected static ?int $navigationSort = 1; // Baru ditambahkan

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()    
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()    
                    ->required()    
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->nullable()
                    ->label('Email Verified At')
                    ->displayFormat('d/m/Y H:i'),
                Forms\Components\TextInput::make('password')
                    ->password()    
                    ->required(fn ($record) => ! $record)    
                    ->confirmed()    
                    ->maxLength(255)
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn ($record) => ! $record)
                    ->maxLength(255)
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    // PERUBAHAN: Menambahkan sortable
                    ->sortable(), // Baru ditambahkan
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    // PERUBAHAN: Menambahkan sortable
                    ->sortable(), // Baru ditambahkan
                    
                // PERUBAHAN: Memindahkan created_at ke posisi ke-3 dan menampilkannya
                Tables\Columns\TextColumn::make('created_at')
                    // PERUBAHAN: Mengubah label
                    ->label('Registration Date') // Sebelumnya tidak ada label khusus
                    // PERUBAHAN: Mengubah format tanggal
                    ->dateTime('d/m/Y H:i') // Sebelumnya hanya ->dateTime()
                    ->sortable()
                    // PERUBAHAN: Mengubah agar selalu terlihat
                    ->toggleable(), // Sebelumnya: ->toggleable(isToggledHiddenByDefault: true)
                    
                // PERUBAHAN: Mengubah cara tampilan email_verified_at
                Tables\Columns\IconColumn::make('email_verified_at') // Sebelumnya: TextColumn
                    ->label('Verified') // Sebelumnya tidak ada label khusus
                    ->boolean() // Mengubah tampilan menjadi boolean
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->toggleable(), // Sebelumnya tidak ada toggleable
                    
                Tables\Columns\TextColumn::make('updated_at')
                    // PERUBAHAN: Mengubah format tanggal
                    ->dateTime('d/m/Y H:i') // Sebelumnya hanya ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc') 
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
