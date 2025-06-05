<?php

namespace App\Observers;

use App\Models\Skt;

class SktObserver
{
    /**
     * Handle the Skt "created" event.
     */
    public function created(Skt $skt): void
    {
        //
    }

    /**
     * Handle the Skt "updated" event.
     */
    public function updated(Skt $skt): void
    {
        //
    }

    /**
     * Handle the Skt "deleted" event.
     */
    public function deleted(Skt $skt): void
    {
        //
    }

    /**
     * Handle the Skt "restored" event.
     */
    public function restored(Skt $skt): void
    {
        //
    }

    /**
     * Handle the Skt "force deleted" event.
     */
    public function forceDeleted(Skt $skt): void
    {
        //
    }
}
