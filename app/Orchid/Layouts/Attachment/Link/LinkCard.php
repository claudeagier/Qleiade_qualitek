<?php

namespace App\Orchid\Layouts\Attachment\Link;

use Orchid\Screen\Sight;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Legend;

class LinkCard extends Legend
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    protected function columns(): array
    {
        return  [
            Sight::make(__('actions'))->render(function () {
                return Group::make(
                    [
                        Button::make(__('Remove'))
                            ->icon('database')
                            ->confirm(__('confirm_delete_attachment'))
                            ->method('removeAttachment', [
                                'wealth' =>  $this->query['wealth']
                            ])->right(),
                    ]
                );
            }),
            Sight::make('attachment.link.type', __('link_type')),
            Sight::make('attachment.link.url', __('link_url'))
            ->render(function () {
                $link = $this->query['attachment']['link']['url'];
                return Link::make($link)
                ->href($link);
            })
        ];
    }
}
