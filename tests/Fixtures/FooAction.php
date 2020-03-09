<?php

namespace Pdmfc\NovaTestAssertions\Tests\Fixtures;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class FooAction extends Action implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return string|void
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function ($user) {
            $user->update(['name' => 'Foo']);
        });
    }
}
