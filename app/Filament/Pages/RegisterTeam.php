<?php

namespace App\Filament\Pages;

use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RegisterTeam extends RegisterTenant
{
//    protected string $view = 'filament.pages.register-team';

    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $data['slug'] = Str::slug($data['name'] . '-' . Str::random(5));
        $team = Team::create($data);

        $team->members()->attach(auth()->user());

        return $team;
    }
}
