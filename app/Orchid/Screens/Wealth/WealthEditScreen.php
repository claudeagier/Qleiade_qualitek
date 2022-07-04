<?php

namespace App\Orchid\Screens\Wealth;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Tag;
use App\Models\Action;
use App\Models\Wealth;
use App\Models\Indicator;
use App\Models\WealthType;
use App\Models\File as FileModel;
use App\Http\Traits\DriveManagement;
use App\Orchid\Layouts\Wealth\EditLayout;
use App\Orchid\Layouts\Wealth\DetailsLayout;
use App\Orchid\Layouts\Wealth\AttachmentListener;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;

class WealthEditScreen extends Screen
{
    use DriveManagement;

    /**
     * @var Wealth
     */
    public $wealth;

    /**
     * Query data.
     *
     * @param Wealth
     * @return array
     */
    public function query(Wealth $wealth): iterable
    {
        $datas = [
            'wealth' => $wealth,
            'whoshouldSee' => ""
        ];

        if ($wealth->exists) {
            $wealth->wealth_type = $wealth->wealthType->id;
            if (count($wealth->files) >= 1) {
                $wealth->file = $wealth->files[0];
            }

            $datas = [
                'wealth' => $wealth,
                'whoShouldSee' => $wealth->wealthType->name,
            ];

            //add attachment if exists in db
            if (!is_null($wealth->attachment)) {
                $attachmentArray = json_decode($wealth->attachment, true);
                $datas['attachment'] = $attachmentArray;
            }
        }

        return $datas;
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->wealth->exists ? __('wealth_edit :name', ['name' => $this->wealth->name]) : __('wealth_create');
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return __('wealth_description');
    }

    //DOC: orchid add permission to a screen
    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.quality.wealths.edit',
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Cancel'))
                ->icon('action-undo')
                ->route('platform.quality.wealths'),

            Button::make('Save', __('Save'))
                ->icon('check')
                ->confirm(__('wealth_save_confirmation'))
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('wealth_remove_confirmation'))
                ->method('remove', [
                    'wealth' => $this->wealth,
                ])
                ->canSee($this->wealth->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs(
                [
                    __('wealth') => EditLayout::class,
                    __('details') => DetailsLayout::class,
                    __('Visualisation') => AttachmentListener::class,
                ]
            )->activeTab(__('wealth'))
        ];
    }

    /**
     *
     * @return string[]
     */
    public function asyncAttachmentData($payload)
    {
        //get wealthTypeName according to id
        $type = WealthType::find($payload['wealth_type']);

        if ($payload['id'] != "") {
            $wealth = Wealth::find($payload['id']);
        } else {
            $wealth = new Wealth();
        }

        return [
            'wealth' => $wealth,
            'whoShouldSee' => $type->name,
        ];
    }

    /**
     * @param Wealth    $wealth
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Wealth $wealth, Request $request)
    {
        //TODO : ajouter un controle de date pour la date de validité
        //TODO : ajouter un controle sur l'unicité du nom ?
        $request->validate([
            'wealth.conformity_level' => [
                'numeric',
                'min:0',
                'max:100'
            ],
            "wealth.processus" =>"required"
        ]);

        //Datas from request
        $wealthData = $request->all('wealth')['wealth'];

        //Attachments
        $fileToUpload = null;
        if ($request->has('attachment')) {
            //data's attachment
            $attachments = $request->all('attachment')['attachment'];
            $dataAttachment = new Collection($attachments);
            if (isset($attachments['file'])) {
                $dataAttachment['file'] = ["type" => 'drive'];
                $fileToUpload = $attachments['file'];
            } else {
                if (count($wealth->files) > 0) {
                    Toast::info('le fichier lié à cette preuve a été supprimé');
                }
            }
            $wealth->attachment = $dataAttachment->toJson();
        }

        //Create Wealth model
        $wealth
            ->fill($wealthData);
        //with Wealth type
        if (isset($wealthData['wealth_type'])) {
            $wealth
                ->wealthType()->associate($wealthData['wealth_type']);
        }
        //with processus
        if (isset($wealthData['processus'])) {
            $wealth
                ->processus()->associate($wealthData['processus']);
        }
        $wealth->save();

        //DOC: update accross relationships
        if (isset($wealthData['indicators'])) {
            $indicators = Indicator::find($wealthData['indicators']);
            $wealth->indicators()->sync($indicators);
        }

        //Actions
        if (isset($wealthData['actions'])) {
            $actions = Action::find($wealthData['actions']);
            $wealth->actions()->sync($actions);
        }

        //Tags
        if (isset($wealthData['tags'])) {
            $tags = Tag::find($wealthData['tags']);
            $wealth->tags()->sync($tags);
        }

        //upload file and save in db
        if (isset($fileToUpload)) {
            $fileId = $this->saveFile($fileToUpload, $wealth);
            if ($fileId) {
                $wealth->files()->sync($fileId);
            } else {
                Toast::error(__('File_not_uploaded'));
            }
        }

        Toast::success(__('Wealth_was_saved'));

        return redirect()->route('platform.quality.wealths');
    }

    /**
     * @param Wealth $wealth
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function remove(Wealth $wealth)
    {
        //DOC: Delete and relationships
        $wealth->actions()->detach();
        $wealth->tags()->detach();
        $wealth->indicators()->detach();

        $wealth->delete();
        $wealth->delete();

        Toast::success(__('Wealth_was_removed'));

        return redirect()->route('platform.quality.wealths');
    }

    /**
     * @param UploadedFile $file
     *
     * @throws \Exception
     *
     * @return String
     *
     */
    public function saveFile(UploadedFile $file, Wealth $wealth)
    {
        //DOC: Store file on google drive

        // get processus
        $processus = $wealth->processus->label;
        $processusDirectoryId = $this->getDirectoryId($this->formatUrlPart($processus));

        //try to stor
        try {
            $res = $file->storeAs($processusDirectoryId, $file->getClientOriginalName());
        } catch (\Throwable $th) {
            Toast::error(__('File_not_uploaded'));
            return false;
        }

        //gdrive meta datas
        $info = $this->getMetaData($res);
        $sharedLink = $this->formatSharedLink($info['path']);

        // save in db
        $fileToStore = new FileModel();
        $fileToStore->fill([
            'original_name' => $info['name'],
            'gdrive_shared_link' => $sharedLink,
            'gdrive_path_id' => $info['path'],
            'mime_type' => $info['mimetype'],
            'size' => $info['size'],
            'user_id' => Auth::id(),
        ])->save();

        Toast::success(__('file_is_added'));

        return $fileToStore->id;
    }

    /**
     * @param Wealth $wealth
     *
     * @throws \Exception
     *
     *
     */
    public function removeFile(Wealth $wealth, Request $request)
    {
        // DOC: Remove Files
        $action = $request->query("action");
        foreach ($wealth->files as $file) {
            switch ($action) {
                
                //Archiving
                case 'archive':
                    //move file in archive directory in Qleiade
                    $archId = $this->getDirectoryId('archive');
                    $archDirId = $this->getDirectoryId($this->formatUrlPart($wealth->processus->label), $archId);
                    $newFilePath = $archDirId . "/" . $file->original_name;
                    Storage::cloud()->move($file->gdrive_path_id, $newFilePath);

                    //update wealth
                    $wealth->files()->detach($file->id);
                    $wealth->attachment = null;
                    $wealth->save();

                    //update file model
                    $file->archived_at = now();
                    $file->gdrive_shared_link = null;
                    $file->gdrive_path_id = $newFilePath;
                    $file->save();

                    Toast::success(__('file_archived'));
                    break;

                // Archiving with delete file on drive
                case 'logical':
                    //delete file in gDrive
                    Storage::cloud()->delete($file->gdrive_path_id);

                    //update wealth
                    $wealth->files()->detach($file->id);
                    $wealth->attachment = null;
                    $wealth->save();

                    //soft delete (complet deleted_at columns)
                    $file->delete();

                    Toast::success(__('file_deleted_logic'));
                    break;

                //Eradicate file
                case 'eradicate':
                    //delete file definitly in g drive
                    Storage::cloud()->delete($file->gdrive_path_id);

                    //update wealth
                    $wealth->files()->detach($file->id);
                    $wealth->attachment = null;
                    $wealth->save();

                    //delet file definitly in
                    $file->forceDelete();

                    Toast::success(__('file_deleted_permanently'));
                    break;

                default:
                    Toast::warning('File not deleted there are no actions', __('file_not_deleted'));
                    break;
            }
        }
    }

    public function removeAttachment(Wealth $wealth)
    {
        //DOC: Remove Attachment
        $wealth->attachment = null;
        $wealth->save();
    }
}
