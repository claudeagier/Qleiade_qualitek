<?php

namespace App\Orchid\Screens\PArtials;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class GenericScreen extends Screen
{
    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('GitHub')
            ->href('https://github.com/orchidsoftware/platform')
            ->icon('social-github'),];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [];
    }
}
