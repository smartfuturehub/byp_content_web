<?php

namespace App\Filament;

use App\Models\Contracts\PubliclyViewable;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class ViewOnSiteAction
{
    /**
     * Opens the record's public page on the front end in a new tab.
     *
     * The action is deliberately not named `view`: Filament reserves that name
     * to derive a table's row-click URL, so naming it that would send row
     * clicks to the front end instead of to the edit form.
     */
    public static function make(): Action
    {
        return Action::make('viewOnSite')
            ->label('View')
            ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
            ->color('gray')
            ->visible(fn (Model $record): bool => $record instanceof PubliclyViewable && $record->isPubliclyVisible())
            ->url(fn (Model $record): ?string => $record instanceof PubliclyViewable ? $record->url() : null, shouldOpenInNewTab: true);
    }
}
