<?php

use App\Models\User;

function user(): ?User
{
    if (auth()->check()) {

        /** @var User */
        return auth()->user();
    }

    return null;
}
