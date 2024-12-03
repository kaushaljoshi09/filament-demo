<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

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
        return 'Role has been updated successfully.';
    }
}
