<?php

namespace App\Filament\Pages;

use App\Models\Team;
use App\Models\Vendor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Store';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('store_name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->required()
                    ->readOnly()
                    ->maxLength(255)
                    ->unique(Vendor::class, 'slug')
                    ->rules(['alpha_dash'])
                    ->helperText('Your store URL will be: ' . config('app.url') . '/vendor/store/{slug}'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),

                Textarea::make('description')
                    ->maxLength(1000)
                    ->rows(4),
            ]);
    }

    protected function handleRegistration(array $data): Vendor
    {
        $vendor = Vendor::create([
            'user_id' => auth()->id(),
            'store_name' => $data['store_name'],
            'slug' => $data['slug'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => 'pending',
        ]);

        // Attach user as owner
        $vendor->members()->attach(auth()->id(), ['role' => 'owner']);

        return $vendor;
    }
}
