<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Processus;

class ProcessusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pilotage des orientations stratégiques (POS) (PS)
        // Qualité (QLT) (QT)
        // Veille et SIN (SIN) (SI)
        // Accompagnement des parcours (ACP) (AP)
        // Recherche innovation conception (RIC) (RI)
        // Activités pédagogiques HR (APH) (PH)
        // Activités pédagogiques Industrie (API) (PI)
        // Activités pédagogiques Vente/Commerce (APV) (PV)
        // Accompagnement éducatif (ACE) (AE)
        // Administration générale (ADM) (AG)
        // Relation entreprise commercialisation (REC) (RE)
        // Communication événements (COM) (CO)
        // Ressources humaines (RHU) (RH)
        // Ressources financières (RFI) (RF)
        // Ressources matérielles et logistique (RML) (RM)

        $enregs = [
            [
                'name' => "PS",
                'label' => "Pilotage des orientations stratégiques",
            ],
            [
                'name' => "QT",
                'label' => "Qualité",
            ],
            [
                'name' => "SI",
                'label' => "Veille et SIN",
            ],

            [
                'name' => "AP",
                'label' => "Accompagnement des parcours",
            ],

            [
                'name' => "RI",
                'label' => "Recherche innovation conception",
            ],

            [
                'name' => "PH",
                'label' => "Activités pédagogiques HR",
            ],

            [
                'name' => "PI",
                'label' => "Activités pédagogiques Industrie",
            ],

            [
                'name' => "PV",
                'label' => "Activités pédagogiques Vente/Commerce",
            ],

            [
                'name' => "AE",
                'label' => "Accompagnement éducatif",
            ],
            [
                'name' => "AG",
                'label' => "Administration générale",
            ],
            [
                'name' => "RE",
                'label' => "Relation entreprise commercialisation",
            ],
            [
                'name' => "CO",
                'label' => "Communication événements",
            ],
            [
                'name' => "RH",
                'label' => "Ressources humaines",
            ],
            [
                'name' => "RF",
                'label' => "Ressources financières",
            ],
            [
                'name' => "RM",
                'label' => "Ressources matérielles et logistique",
            ]
        ];

        foreach ($enregs as $proc) {
            $processus = new Processus();
            $processus->fill([
                'name' => $proc['name'],
                'label' => $proc['label']
            ])->save();
        }
    }
}
