<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;


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
        return 'Post has been created successfully.';
    }

    protected function afterCreate(): void
    {
        $this->record->logActivity('created');
    }
}
