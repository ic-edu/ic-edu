<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopUpRequestResource\Pages;
use App\Models\TopUpRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;

class TopUpRequestResource extends Resource
{
    protected static ?string $model = TopUpRequest::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static string|\UnitEnum|null $navigationGroup = 'Financial & Revenue';
    protected static ?string $navigationLabel = 'Top Up Requests';

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->isSuperAdmin();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Tokens')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Total Price (IDR)')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->label('Method')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'transfer' => 'info',
                        'cash' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordActions([
                Action::make('view_proof')
                    ->label('View Proof')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->visible(fn (TopUpRequest $record): bool => $record->method === 'transfer' && $record->proof_path)
                    ->modalContent(fn (TopUpRequest $record) => view('filament.pages.view-proof', ['path' => $record->proof_path]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (TopUpRequest $record): bool => $record->status === 'pending')
                    ->action(function (TopUpRequest $record) {
                        \Illuminate\Support\Facades\DB::transaction(function () use ($record) {
                            $record->update(['status' => 'approved']);
                            
                            $user = $record->user;
                            $user->increment('tokens', $record->amount);
                            
                            \App\Models\TokenTransaction::create([
                                'user_id' => $user->id,
                                'type' => 'purchase',
                                'amount' => $record->amount,
                                'description' => 'Top Up ' . ucfirst($record->method),
                                'reference_id' => 'TOPUP-' . $record->id . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                                'status' => 'completed',
                            ]);
                            
                            $user->notify(new \App\Notifications\GeneralNotification([
                                'title' => 'Top Up Approved',
                                'desc' => 'Your top up of ' . $record->amount . ' tokens has been approved.',
                                'type' => 'system',
                                'category' => 'Token Top Up',
                                'action_url' => route('test_taker.wallet'),
                                'action_text' => 'View Wallet'
                            ]));
                        });
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Request approved successfully')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (TopUpRequest $record): bool => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Rejection Reason')
                            ->required()
                    ])
                    ->action(function (array $data, TopUpRequest $record) {
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['reason']
                        ]);
                        
                        $record->user->notify(new \App\Notifications\GeneralNotification([
                            'title' => 'Top Up Rejected',
                            'desc' => 'Your top up was rejected. Reason: ' . $data['reason'],
                            'type' => 'system',
                            'category' => 'Token Top Up',
                            'action_url' => route('test_taker.wallet'),
                            'action_text' => 'View Wallet'
                        ]));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Request rejected')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTopUpRequests::route('/'),
        ];
    }
}
