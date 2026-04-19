<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $navigationGroup = 'social';

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('content')->required(),
                Forms\Components\Toggle::make('is_published'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Author'),
                Tables\Columns\TextColumn::make('content'),
                SelectColumn::make('is_published')
                    ->label('status')
                    ->options([
                        1 => 'published',
                        0 => 'Draft',
                    ])->rules(['required', 'in:1,0'])
                    ->placeholder('Select an option')->default(fn($record) => $record?->is_published),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn(Post $record) => auth()->user()->can('delete post')),
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
            'index' => Pages\ListPosts::route('/'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view');
    }
    public static function canView(Model $record): bool
    {
        return auth()->user()->can('view');
    }



    public static function canCreate(): bool
    {
        return auth()->user()->can('create');
    }
    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('edit');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete');
    }
}
