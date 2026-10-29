<?php

namespace App\Models\Contracts;

/**
 * A record that has a public counterpart on the front end.
 */
interface PubliclyViewable
{
    /**
     * Whether the record is currently reachable on the front end, i.e. whether
     * it would be returned by the model's `published` scope.
     */
    public function isPubliclyVisible(): bool;

    public function url(): string;
}
