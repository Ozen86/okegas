<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Barang'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('product-images') // Optional - specify a directory
                    ->visibility('public')        // Optional - ensure images are publicly accessible
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->label('Deskripsi Barang'),
                TextInput::make('stock')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required()
                    ->label('Stok Barang')
                    ->minValue(1),
                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->label('Price'),
                                                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            ImageColumn::make('image')
                ->label('Image')
                ->disk('public') // Sesuaikan dengan storage disk
                ->height(50)
                ->width(50),

            TextColumn::make('name')
                ->label('Nama Barang')
                ->sortable()
                ->searchable(),

            TextColumn::make('stock')
                ->label('Stok')
                ->sortable()
                ->numeric(decimalPlaces: 0),  // Proper formatting for numbers

            TextColumn::make('price')
                ->label('Harga')
                ->sortable()
                ->money('IDR')
                ->alignRight(),  
                
            TextColumn::make('created_at')
                ->label('Tanggal Dibuat')
                ->dateTime('d/m/Y H:i')  // Better date format
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
