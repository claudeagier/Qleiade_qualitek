<?php

namespace App\Orchid\Screens\Wealth;

use App\Models\Wealth;
use App\Models\Indicator;
use App\Models\WealthType;
use App\Models\Processus;
use App\Models\Career;
use App\Models\Action;
use App\Models\Formation;
use App\Orchid\Layouts\Wealth\WealthEditLayout;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Relation;

class WealthEditScreen extends Screen
{

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
        $datas = ['wealth'=>$wealth];

        if($wealth->exists){
            $formations =$this->formatEntityListToIdsArray($wealth->formations);
            $indicators =$this->formatEntityListToIdsArray($wealth->indicators);
            $actions =$this->formatEntityListToIdsArray($wealth->actions);
            $careers =$this->formatEntityListToIdsArray($wealth->careers);
            
            $datas= [
                'wealth' => $wealth,
                'name' => $wealth->name,
                'validity_date' => $wealth->validity_date,
                'conformity_level' => $wealth->conformity_level,
                'description' => $wealth->description,
                'wealth_type' =>$wealth->wealthType->id,
                'processus' => $wealth->processus->id,
                'formations' => $formations,
                'indicators' => $indicators,
                'actions' => $actions,
                'careers' => $careers,
            ];
        }

        // var_dump($wealth->wealthType->id);
        // die;
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
        $wealthLayout = new WealthEditLayout();

        $layout = [
            Layout::columns([
                $wealthLayout->title(__('wealth')),
                Layout::rows([
                    Relation::make('indicators')
                        ->fromModel(Indicator::class, 'name')
                        ->multiple()
                        ->required()
                        ->title(__('indicator_select_title')),

                    Relation::make('processus')
                        ->fromModel(Processus::class, 'name')
                        ->required()
                        ->title(__('processus_select_title')),

                    Relation::make('actions')
                        ->fromModel(Action::class, 'name')
                        ->multiple()
                        ->required()

                        ->title(__('action_select_title')),

                    Relation::make('careers')
                        ->fromModel(Career::class, 'name')
                        ->multiple()
                        ->required()
                        ->popover("Ex.: cap 3 ans")
                        ->title(__('career_select_title')),
                    Relation::make('formations')
                        ->fromModel(Formation::class, 'name')
                        ->multiple()
                        ->title(__('formation_select_title')),
                ])->title(__('details'))
            ]),
        ];
        return $layout;
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
        
        $wealthData = $request->all();

        $wealth
            ->fill($wealthData)
            ->wealthType()->associate($wealthData['wealth_type'])
            ->processus()->associate($wealthData['processus'])
            ->save();

        //si l'indicateur exist et 
        $indicators= Indicator::find($wealthData['indicators']);
        $wealth->indicators()->sync($indicators);

        $actions= Action::find($wealthData['actions']);
        $wealth->actions()->sync($actions);

        $careers= Career::find($wealthData['careers']);
        $wealth->careers()->sync($careers);

        $formations= Formation::find($wealthData['formations']);
        $wealth->formations()->sync($formations);

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
        $wealth->formations()->detach();
        $wealth->actions()->detach();
        $wealth->careers()->detach();
        $wealth->indicators()->detach();

        $wealth->delete();
        $wealth->delete();

        Toast::success(__('Wealth_was_removed'));

        return redirect()->route('platform.quality.wealths');
    }

    protected function formatEntityListToIdsArray($myArray){
        $ids = [];
        foreach ($myArray as $item){
            if ($item->id) {
                array_push($ids, $item->id);
            }
        }
        return $ids;
    }
}
