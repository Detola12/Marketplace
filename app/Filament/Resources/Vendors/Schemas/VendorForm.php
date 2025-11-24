<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('store_name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('logo'),
                TextInput::make('banner'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone_no')
                    ->tel(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('city'),
                TextInput::make('state'),
                TextInput::make('country'),
                TextInput::make('postal_code'),
                TextInput::make('business_registration_number'),
                TextInput::make('tax_number'),
                TextInput::make('business_details'),
                TextInput::make('payment_details'),
                TextInput::make('commission_rate')
                    ->required()
                    ->numeric()
                    ->default(10.0),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'active' => 'Active',
            'suspended' => 'Suspended',
            'rejected' => 'Rejected',
        ])
                    ->default('pending')
                    ->required(),
                Toggle::make('is_verified')
                    ->required(),
                DateTimePicker::make('verified_at'),
                TextInput::make('rating')
                    ->numeric(),
                TextInput::make('total_sales')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('plan_id')
                    ->numeric(),
                DateTimePicker::make('plan_expires_at'),
            ]);
    }
}
