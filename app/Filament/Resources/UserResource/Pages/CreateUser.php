<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Summary of getRedirectUrl
     * @return string
     * Reference: https://filamentphp.com/docs/3.x/panels/resources/creating-records#customizing-redirects
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Summary of getCreatedNotificationTitle
     * @return string
     * Reference: https://filamentphp.com/docs/3.x/panels/resources/creating-records#customizing-the-save-notification
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'User has been created successfully.';
    }
}
