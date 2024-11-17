<?php

namespace Database\Seeders;

use App\Models\Insurance\Insurance;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    public function run()
    {
        $insurances = [
            [
                'name' => 'Fl Blue',
                'services' => [
                    [
                        'code' => '97151',
                        'provider' => 'BCBA',
                        'description' => 'Assessment',
                        'unit_prize' => '21',
                        'hourly_fee' => '84',
                        'max_allowed' => '(max 2 hrs/day) total 40 units/10 hours copay will aply per day'
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'RBT',
                        'description' => 'Therapy',
                        'unit_prize' => '13',
                        'hourly_fee' => '52',
                        'max_allowed' => '(max 8 hrs/day)'
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'BCBA',
                        'description' => 'BIP modification only',
                        'unit_prize' => '20.4',
                        'hourly_fee' => '81.6',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCBA',
                        'description' => 'Caregiver Training',
                        'unit_prize' => '19',
                        'hourly_fee' => '76',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97157',
                        'provider' => 'BCBA',
                        'description' => 'Group Caregiver Training( Multi-family)',
                        'unit_prize' => '3',
                        'hourly_fee' => null,
                        'max_allowed' => null
                    ],
                    [
                        'code' => 'H0032',
                        'provider' => 'BCBA',
                        'description' => null,
                        'unit_prize' => '17',
                        'hourly_fee' => '68',
                        'max_allowed' => null
                    ]
                ],
                'notes' => [
                    ['note' => 'Horizon by BCBS'],
                    ['note' => 'Horizon BCBSNJ will use H0032 for Indirect service (treatment planning)'],
                    ['note' => 'telehealth: submit a claim to Florida Blue using one of the regular codes included in your fee schedule. The place of service should be the regular place of service as if you saw the patient in-person.'],
                    ['note' => 'Modifier XE for 2 sessions, same day different POS'],
                    ['note' => 'Now allows concurrent billing of 97155 and 97153, effecitve 12/01/2021'],
                    ['note' => '97156 is always ALLOWED to overlap with 97153']
                ]
            ],
            [
                'name' => 'United',
                'services' => [
                    [
                        'code' => '97153',
                        'provider' => 'RBT',
                        'description' => 'therapy',
                        'unit_prize' => '12.51',
                        'hourly_fee' => '50.04',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97151',
                        'provider' => 'BCBA',
                        'description' => 'IA (40 units)',
                        'unit_prize' => '29.88',
                        'hourly_fee' => '119.52',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'BCBA 97155',
                        'description' => 'supervision',
                        'unit_prize' => '19.32',
                        'hourly_fee' => '77.28',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCBA 97156',
                        'description' => 'PT',
                        'unit_prize' => '17.51',
                        'hourly_fee' => '70.04',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'BCBA',
                        'description' => 'therapy',
                        'unit_prize' => '16.68',
                        'hourly_fee' => '66.72',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97151',
                        'provider' => 'BCaBA',
                        'description' => null,
                        'unit_prize' => '25.4',
                        'hourly_fee' => '101.6',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'BCaBA',
                        'description' => null,
                        'unit_prize' => '14.18',
                        'hourly_fee' => '56.72',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'BCaBA',
                        'description' => null,
                        'unit_prize' => '16.42',
                        'hourly_fee' => '65.68',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCaBA',
                        'description' => null,
                        'unit_prize' => '14.88',
                        'hourly_fee' => '59.52',
                        'max_allowed' => null
                    ]
                ],
                'notes' => [
                    ['note' => 'No school or community covered unless aproved by peer review on auth'],
                    ['note' => 'If the rendering provider is required, use the BCBA on the case.'],
                    ['note' => 'for 97155 Yes. When supervision is provided, you may bill concurrently for both Supervisors and Behavior Technicians, billing with 97153 and 97155.'],
                    ['note' => 'Modifier XE for 2 sessions, same day different POS'],
                    ['note' => 'Modifiers: RBT- HM, BCBA- HO, BCaBA- HN'],
                    ['note' => '97156 is always allowed to overlap with 97153']
                ]
            ],
            [
                'name' => 'CIGNA',
                'services' => [
                    [
                        'code' => '97151',
                        'provider' => 'BCBA',
                        'description' => 'Assessment',
                        'unit_prize' => '48',
                        'hourly_fee' => '21',
                        'max_allowed' => '48 units/ (12 hrs), No PA req.'
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'RBT',
                        'description' => 'Therapy',
                        'unit_prize' => '15',
                        'hourly_fee' => '10',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'BCBA (RBT supervision)',
                        'description' => 'Therapy',
                        'unit_prize' => '0',
                        'hourly_fee' => '19',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'Caregiver Training',
                        'description' => 'Therapy',
                        'unit_prize' => '0',
                        'hourly_fee' => '19',
                        'max_allowed' => null
                    ]
                ],
                'notes' => [
                    ['note' => 'Modifier XE for 2 sessions, same day different POS\t\t\t\ncan bill RBT and BCBA together por supervision\t\t\t\nOnly one provider can bill for a unit of time with the exception of CPT codes 97153 and 97155 (direct\t\t\t\nsupervision when the Board Certified Behavior Analyst® (BCBA®)/Qualified Healthcare Provider\t\t\t\n(QHP) directs the technician and both are face-to-face with the patient at the same time).\t\t\t\nbill services under the BCBA or licensed provider, allows lmhc']
                ]
            ],
            [
                'name' => 'TRICARE',
                'services' => [
                    [
                        'code' => '97151',
                        'provider' => 'BCBA',
                        'description' => 'Assessment',
                        'unit_prize' => '37.35',
                        'hourly_fee' => '136.24',
                        'max_allowed' => '32 units for initial/24 for reassessment, units per authorization (2 hrs/day)'
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'RBT',
                        'description' => 'Therapy',
                        'unit_prize' => '18.46',
                        'hourly_fee' => '64.44',
                        'max_allowed' => '32 units per day/ (8 hrs/day)'
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'BCBA',
                        'description' => 'Therapy',
                        'unit_prize' => '31.25',
                        'hourly_fee' => '125',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155',
                        'provider' => '97155',
                        'description' => 'BIP modification only',
                        'unit_prize' => '32.15',
                        'hourly_fee' => '125',
                        'max_allowed' => '8 units per day/ (2 hr/day)'
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCBA',
                        'description' => 'Caregiver Training',
                        'unit_prize' => '31.25',
                        'hourly_fee' => '125',
                        'max_allowed' => '8 units per day/ (2 hr/day)'
                    ],
                    [
                        'code' => 'T1023',
                        'provider' => 'BCBA',
                        'description' => 'PDDBI',
                        'unit_prize' => '0',
                        'hourly_fee' => '68.13',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'BCaBA',
                        'description' => 'Therapy',
                        'unit_prize' => '20.62',
                        'hourly_fee' => '75',
                        'max_allowed' => '32 units per day/ (8 hrs/day)'
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'BCaBA',
                        'description' => 'BIP modification only',
                        'unit_prize' => '26.8',
                        'hourly_fee' => '107.2',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCaBA',
                        'description' => 'Caregiver Training',
                        'unit_prize' => '31.25',
                        'hourly_fee' => '125',
                        'max_allowed' => '8 units per day/ (2 hr/day)'
                    ]
                ],
                'notes' => [
                    ['note' => 'Concurrent billing is excluded for all ABA Category I CPT codes'],
                    ['note' => 'Does not allow billing for any two ABA providers at the same time. or same date'],
                    ['note' => 'If BCBA overlap with BCaBA, bill BCBA'],
                    ['note' => '8.11.7.3.8 Concurrent billing is excluded for all ACD Category I CPT codes except when the family and the beneficiary are receiving separate services and the beneficiary is not present in the family session. Documentation must indicate two separate rendering providers and locations for the services.'],
                    ['note' => 'Yes they credential LMHC']
                ]
            ],
            [
                'name' => 'AETNA',
                'services' => [
                    [
                        'code' => '97151',
                        'provider' => 'BCBA',
                        'description' => 'Assessment',
                        'unit_prize' => '22',
                        'hourly_fee' => '88',
                        'max_allowed' => '48 units/ (12 hrs), 2 hr per day max'
                    ],
                    [
                        'code' => '97152',
                        'provider' => 'RBT',
                        'description' => 'Assessment',
                        'unit_prize' => '16',
                        'hourly_fee' => '64',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '0362T',
                        'provider' => 'Supporting',
                        'description' => 'Assessment',
                        'unit_prize' => '20',
                        'hourly_fee' => '88',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'MD or QHP',
                        'description' => 'BIP modification only',
                        'unit_prize' => '22',
                        'hourly_fee' => '88',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '0373T',
                        'provider' => 'BCBA',
                        'description' => 'BIP modification only',
                        'unit_prize' => '20',
                        'hourly_fee' => '88',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'RBT',
                        'description' => 'Therapy',
                        'unit_prize' => '16',
                        'hourly_fee' => '64',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCBA',
                        'description' => 'Caregiver Training',
                        'unit_prize' => '22',
                        'hourly_fee' => '88',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97154',
                        'provider' => 'Group',
                        'description' => 'Therapy',
                        'unit_prize' => '16',
                        'hourly_fee' => '64',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97157',
                        'provider' => 'BCBA',
                        'description' => 'Therapy Multiple-family group',
                        'unit_prize' => '22',
                        'hourly_fee' => '88',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97158',
                        'provider' => 'group MD or QHP',
                        'description' => 'BIP modification only',
                        'unit_prize' => '22',
                        'hourly_fee' => '88',
                        'max_allowed' => null
                    ]
                ],
                'notes' => [
                    ['note' => 'Modifier: Telehealth (02) - 95'],
                    ['note' => 'Modifier XE for 2 sessions, same day different POS']
                ]
            ],
            [
                'name' => 'Medicaid',
                'services' => [
                    [
                        'code' => '97153',
                        'provider' => 'RBT, BCaBA',
                        'description' => 'Direct Service provided by a Registered Behavior Technician (RBT), a BCaBA, or a Lead Analyst',
                        'unit_prize' => '12.19',
                        'hourly_fee' => '219.42',
                        'max_allowed' => 'max 8 hours per day'
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'Lead Analyst',
                        'description' => 'Family training by Lead Analyst Service provided by a Lead Analyst',
                        'unit_prize' => '19.05',
                        'hourly_fee' => '76.2',
                        'max_allowed' => 'max 4H per day'
                    ],
                    [
                        'code' => '97156 GT',
                        'provider' => 'Lead Analyst',
                        'description' => 'Family training via telemedicine Service provided by a Lead Analyst; Florida Medicaid reimburses up to 2 hours per week',
                        'unit_prize' => '19.05',
                        'hourly_fee' => '76.2',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'PM',
                        'description' => 'Behavior treatment with protocol modification (PM) Service provided by a Lead Analyst',
                        'unit_prize' => '19.05',
                        'hourly_fee' => '76.2',
                        'max_allowed' => 'max 6 hours per day (PM needs to be on the notes)'
                    ],
                    [
                        'code' => '97156 HN',
                        'provider' => 'BCaBA',
                        'description' => 'Family training by assistant Service performed by a BCaBA',
                        'unit_prize' => '15.24',
                        'hourly_fee' => '60.96',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155 HN',
                        'provider' => 'BCaBA',
                        'description' => 'Behavior treatment with protocol modification Service provided by a BCaBA',
                        'unit_prize' => '15.24',
                        'hourly_fee' => '243.84',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97151',
                        'provider' => null,
                        'description' => 'Assessment maximum of 24 units',
                        'unit_prize' => '19.05',
                        'hourly_fee' => '38.1',
                        'max_allowed' => 'max 2 hours per day'
                    ],
                    [
                        'code' => '97151 TS',
                        'provider' => null,
                        'description' => 'Reassessment maximum of 18 units',
                        'unit_prize' => '19.05',
                        'hourly_fee' => '152.4',
                        'max_allowed' => 'max 2 hours per day'
                    ]
                ],
                'notes' => [
                    ['note' => 'overlap: if 97153 is concurrent with 97155, 97153 need to use modifier XP (Not reimbursed)'],
                    ['note' => 'All services need to be  billed'],
                    ['note' => '02+ GT for telehealth'],
                    ['note' => 'Modifier XE for 2 sessions, same day different POS'],
                    ['note' => 'For sunshine cases w/ member ID starts with a 7, the PA needs to be under the BCBA name that is on the case.']
                ]
            ],
            [
                'name' => 'NOW KBA',
                'services' => [
                    [
                        'code' => '97151',
                        'provider' => 'BCBA',
                        'description' => 'Assessment',
                        'unit_prize' => '34.06',
                        'hourly_fee' => '136.24',
                        'max_allowed' => '32 units for initial/32 for reassessment, units per authorization (2 hrs/day)'
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'RBT',
                        'description' => 'Therapy',
                        'unit_prize' => '18.75',
                        'hourly_fee' => '75',
                        'max_allowed' => '32 units per day/ (8 hrs/day)'
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'BCBA',
                        'description' => 'Therapy',
                        'unit_prize' => '31.25',
                        'hourly_fee' => '125',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'BCBA',
                        'description' => 'BIP modification only',
                        'unit_prize' => '31.25',
                        'hourly_fee' => '125',
                        'max_allowed' => '8 units per day/ (2 hr/day)'
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCBA',
                        'description' => 'Caregiver Training',
                        'unit_prize' => '31.25',
                        'hourly_fee' => '125',
                        'max_allowed' => '8 units per day/ (2 hr/day)'
                    ],
                    [
                        'code' => 'T1023',
                        'provider' => 'BCBA',
                        'description' => 'PDDBI',
                        'unit_prize' => null,
                        'hourly_fee' => '68.13',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97153',
                        'provider' => 'BCaBA',
                        'description' => 'Therapy',
                        'unit_prize' => '18.75',
                        'hourly_fee' => '75',
                        'max_allowed' => '32 units per day/ (8 hrs/day)'
                    ],
                    [
                        'code' => '97155',
                        'provider' => 'BCaBA',
                        'description' => 'BIP modification only',
                        'unit_prize' => '20.79',
                        'hourly_fee' => '83.16',
                        'max_allowed' => null
                    ],
                    [
                        'code' => '97156',
                        'provider' => 'BCaBA',
                        'description' => 'Caregiver Training',
                        'unit_prize' => '31.25',
                        'hourly_fee' => '125',
                        'max_allowed' => '8 units per day/ (2 hr/day)'
                    ]
                ],
                'notes' => [
                    ['note' => 'Modifier XE for 2 sessions, same day different POS'],
                    ['note' => 'ALLOWS OVERLAP BILLING']
                ]
            ]
        ];

        foreach ($insurances as $insurance) {
            Insurance::create($insurance);
        }
    }
}