<?php

namespace App\Orchid\Screens\Wealth;

use App\Models\Wealth;
use App\Models\WealthType;
use App\Models\Indicator;
use App\Models\Career;
use App\Models\Action;
use App\Models\File as FileModel;
use App\Http\Traits\FileManagement;

use App\Orchid\Layouts\Wealth\EditLayout;
use App\Orchid\Layouts\Wealth\AttachmentListener;
use App\Orchid\Layouts\Wealth\DetailsLayout;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;


class WealthEditScreen extends Screen
{
    use FileManagement;

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
            'attachment_visibity' => 'public'
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
        return $this->wealth->exists ? __('wealth_edit :label', ['label' => $this->wealth->label]) : __('wealth_create');
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

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove', [
                    'wealth' => $this->wealth,
                ])
                ->canSee($this->wealth->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $canSee = false;

        $tabs = [
            __('wealth') => EditLayout::class,
            __('details') => DetailsLayout::class,
            __('Visualisation') => AttachmentListener::class,
        ];

        $layout = [
            Layout::tabs($tabs)->activeTab(__('wealth')),
        ];

        return $layout;
    }

    /**
     *
     * @return string[]
     */
    public function asyncCanSee($payload)
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
        $request->validate([
            // 'wealth.email' => [
            //     'required',
            //     Rule::unique(Wealth::class, 'email')->ignore($wealth),
            // ],
        ]);

        $wealthData = $request->all('wealth')['wealth'];

        $wealth
            ->fill($wealthData)
            ->wealthType()->associate($wealthData['wealth_type'])
            ->processus()->associate($wealthData['processus'])
            ->save();

        //si l'indicateur exist et 
        if (isset($wealthData['indicators'])) {
            $indicators = Indicator::find($wealthData['indicators']);
            $wealth->indicators()->sync($indicators);
        }
        if (isset($wealthData['actions'])) {
            $actions = Action::find($wealthData['actions']);
            $wealth->actions()->sync($actions);
        }

        if (isset($wealthData['careers'])) {
            $careers = Career::find($wealthData['careers']);
            $wealth->careers()->sync($careers);
        }

        //upload data and save in bdd
        if (isset($wealthData['file'])) {
            $fileId = $this->saveFile($wealthData['file'], $wealth);
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
        //gérer les relations
        $wealth->actions()->detach();
        $wealth->careers()->detach();
        $wealth->indicators()->detach();

        //supprimer les fichiers oui ou non ?

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
        // récuperer le processus pour le copier au bon endroit
        $processus = $wealth->processus->name;
        $processusDirectoryId = $this->getDirectoryId($this->formatUrlPart($processus));

        // sur le drive
        try {
            $res = $file->storeAs($processusDirectoryId, $file->getClientOriginalName());
        } catch (\Throwable $th) {
            Toast::error(__('File_not_uploaded'));
            return false;
        }

        //gdrive meta datas
        $info = $this->getMetaData($res);
        $sharedLink = "https://drive.google.com/file/d/"
            . explode('/', $info['path'])[1] .
            "/view?usp=sharing";

        // save in db 
        $fileToStore = new FileModel();
        $fileToStore->fill([
            'original_name' => $info['name'],
            'gdrive_shared_link' => $sharedLink,
            'gdrive_path_id' => $info['path'],
            'mime_type' => $info['mimetype'],
            'size' => $info['size'],
            'user_id' => Auth::id(),
        ]);

        // enregistrement en bdd
        $fileToStore->save();

        // faire le lien avec la ressource
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
    public function removeFile(Wealth $wealth, $action)
    {
        foreach ($wealth->files as $file) {
            switch ($action) {
                case 'archive':
                    $archId = $this->getDirectoryId('archive');
                    Storage::cloud()->move($file->gdrive_path_id, $archId . "/" . $file->gdrive_path_id);

                    $wealth->files()->detach($file->id);

                    $file->archived_at = now();
                    $file->save();

                    Toast::success(__('file_archive'));
                    break;

                case 'logic':
                    Storage::cloud()->delete($file->gdrive_path_id);

                    $wealth->files()->detach($file->id);

                    $file->deleted_at = now();
                    $file->save();
                    Toast::success(__('file_deleted_logic'));
                    break;

                case 'eradicate':
                    Storage::cloud()->delete($file->gdrive_path_id);

                    $wealth->files()->detach($file->id);

                    $file->delete();

                    Toast::success(__('file_deleted_permanently'));
                    break;

                default:
                    Toast::warning('File not deleted there are no actions', __('file_deleted_permanently'));
                    break;
            }
        }
    }
}
