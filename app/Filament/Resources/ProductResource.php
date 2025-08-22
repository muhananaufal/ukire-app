<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup = 'Shop';

    public static bool $isGloballySearchable = true;

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Category' => $record->category->name,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Product Tabs')->tabs([
                    Forms\Components\Tabs\Tab::make('Information')->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()->maxLength(255)->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        Forms\Components\TextInput::make('slug')
                            ->required()->maxLength(255)->disabled()->dehydrated()
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                        Forms\Components\RichEditor::make('description')
                            ->required()->columnSpanFull(),
                    ]),
                    Forms\Components\Tabs\Tab::make('Images')->schema([
                        Forms\Components\Repeater::make('images')
                            ->relationship()->schema([
                                Forms\Components\FileUpload::make('image_path')->required()->image()->disk('public')->directory('product-images')->columnSpan(2),
                                Forms\Components\Toggle::make('is_featured')->label('Featured')->helperText('Tandai sebagai gambar utama.'),
                            ])
                            ->reorderableWithDragAndDrop()->orderColumn('sort_order')
                            ->columnSpanFull()->columns(3),
                    ]),
                    Forms\Components\Tabs\Tab::make('Details, Pricing & Status')->schema([
                        Forms\Components\TextInput::make('price')
                            ->required()->numeric()->prefix('Rp')
                            ->dehydrateStateUsing(fn($state): int => $state * 100)
                            ->formatStateUsing(fn(?int $state): string => $state ? $state / 100 : ''),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')->required(),
                        Forms\Components\TextInput::make('material')->required(),
                        Forms\Components\TextInput::make('dimensions')->required(),
                        Forms\Components\TextInput::make('preorder_estimate')->required(),

                        // WOW #1: Tambahkan Status Produk (Published / Draft)
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Jika nonaktif, produk akan disembunyikan dari katalog.')
                            ->default(true),
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images.image_path')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->images->first()?->image_path)
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR', divideBy: 100)->sortable(),

                // WOW #2: Tampilkan Status Published / Draft dengan Toggle
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Published'),

                // WOW #3: Tampilkan berapa kali produk ini dipesan
                Tables\Columns\TextColumn::make('order_items_count')
                    ->counts('orderItems')
                    ->label('Times Ordered')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Publication Status')
                    ->boolean()
                    ->trueLabel('Published')
                    ->falseLabel('Drafts'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                // WOW #4: Aksi untuk duplikat produk
                Tables\Actions\ReplicateAction::make()
                    ->label('Duplicate')
                    ->excludeAttributes(['slug']) // Slug harus unik, jadi kita kosongkan
                    ->before(function (Tables\Actions\ReplicateAction $action, Model $record) {
                        $action->fillForm($record->toArray());
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('images');
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
