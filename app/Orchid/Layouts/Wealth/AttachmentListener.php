<?php

namespace App\Orchid\Layouts\Wealth;

use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use App\Orchid\Layouts\Wealth\UploadCustomLayout;

class AttachmentListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['wealth.wealth_type', 'wealth.id'];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncCansee';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        $uploadFile = new UploadCustomLayout();
        return [
            // Layout::rows([
            //     Upload::make('wealth.attachment')
            //     ->title(__('Upload file'))
            //     ->maxFiles(1)
            //     ->storage('public')
            //     ->formaction('wealth/attachment/create')
            //     ->formmethod('post')
                
            //     ])->canSee($this->query['whoShouldSee'] === 'file')
            $uploadFile->canSee($this->query['whoShouldSee'] === 'file'),
        ];
    }
}
