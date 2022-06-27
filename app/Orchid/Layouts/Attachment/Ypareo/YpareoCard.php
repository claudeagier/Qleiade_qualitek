<?php

namespace App\Orchid\Layouts\Attachment\Ypareo;

use Orchid\Screen\Sight;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Legend;

class YpareoCard extends Legend
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    //     /**
    //  * Data source.
    //  *
    //  * The name of the key to fetch it from the query.
    //  * The results of which will be elements of the table.
    //  *
    //  * @var string
    //  */
    // protected $target = 'attachment';

    protected function columns(): array
    {
        return  [
            Sight::make(__('actions'))->render(function () {
                return Group::make(
                    [
                        Button::make(__('Remove'))
                            ->icon('database')
                            ->confirm(__('confirm_archive_file'))
                            ->method('removeAttachment', [
                                'wealth' =>  $this->query['wealth'],
                            ]),
                    ]
                );
            }),
            Sight::make('attachment.ypareo.type', __('attachment_ypareo_type')),
            Sight::make('attachment.ypareo.process', __('attachment_ypareo_url')),
            Sight::make('attachment.ypareo.created_at', __('created_at')),
        ];
    }
}
