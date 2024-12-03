<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

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
     * Summary of getSavedNotificationTitle
     * @return string
     * Reference: https://filamentphp.com/docs/3.x/panels/resources/creating-records#customizing-the-save-notification
     */
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Permission has been updated successfully.';
    }
}
