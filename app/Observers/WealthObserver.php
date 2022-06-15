<?php

namespace App\Observers;

use App\Models\Wealth;

class WealthObserver
{
    /**
     * Handle the Wealth "created" event.
     *
     * @param  \App\Models\Wealth  $wealth
     * @return void
     */
    public function created(Wealth $wealth)
    {
        //
    }

    /**
     * Handle the Wealth "updated" event.
     *
     * @param  \App\Models\Wealth  $wealth
     * @return void
     */
    public function updated(Wealth $wealth)
    {
        //
    }

    /**
     * Handle the Wealth "deleted" event.
     *
     * @param  \App\Models\Wealth  $wealth
     * @return void
     */
    public function deleted(Wealth $wealth)
    {
        //
    }

    /**
     * Handle the Wealth "deleting" event.
     *
     * @param  \App\Models\Wealth  $wealth
     * @return void
     */
    public function deleting(Wealth $wealth)
    {
        $files = $wealth->files;
        $wealth->files()->detach();
        foreach ($files as $file) {
            $file->delete();
        }
    }

    /**
     * Handle the Wealth "restored" event.
     *
     * @param  \App\Models\Wealth  $wealth
     * @return void
     */
    public function restored(Wealth $wealth)
    {
        //
    }

    /**
     * Handle the Wealth "force deleted" event.
     *
     * @param  \App\Models\Wealth  $wealth
     * @return void
     */
    public function forceDeleted(Wealth $wealth)
    {
        //
    }
}
