<?php

namespace Database\Seeders;

use App\Models\Bip\Bip;
use Illuminate\Database\Seeder;

class BipSeeder extends Seeder
{
    const BASE_BACKGROUND = "Client is a 4 year old female, who lives with her mother, and father in Fort myers, Fl. Client is diagnosed with ASD, language delay. She is exposed to English and two Indian languages in the home.
Client was referred for ABA therapy due to maladaptive behaviors that interfere with daily functioning and limit her ability to integrate and learn form others in her environment.
Client is non-vocal. She exhibits limited to no functional communication. She communicates by pulling other’s hand or pointing. At times she may echo single words or parts of a word. " .
        "She does not answer questions and has difficulty understanding directives.
Client sometimes gives a blank stare when given a direction. She is unable to follow multistep instructions of more than 2 steps. Client needs assistance with all ADLs.
She is not toilet trained. She uses underwear during daytime and pull up at bedtime. She is prompt dependent to use the restroom for voiding, she will hold it until instructed to go potty. For bowel movements (BM) she refuses to use the toilet, she uses a pull up for BMs.
Client engages in tantrums daily, crying or screaming. She frequently exhibits physical aggression towards parents, pinching/ scratching or hitting/lunging at their arms or face when told no or denied access to preffered tangible.
During observations she lunged suddenly at dad’s face, he had to block her to prevent scratching. Client was constantly moving away from instructional area, and did not follow most instructions given.
She was able to recognize/point to some pictures shown, but required repeated prompting, and she would move the BCBA’s hand away frequently. Family main goals include: decreasing maladaptives such as tantrums and aggression, Increase appropriate communication skills. Increase independence with Toileting needs.
";

    public function run()
    {
        $bips = [
            [
                'client_id' => 1, // Make sure this user exists
                'patient_identifier' => 'PAT001',
                'doctor_id' => 3, // BCBA1
                'type_of_assessment' => 1,
                'documents_reviewed' => [
                    [
                        'index' => 1,
                        'title' => 'School Records',
                        'status' => 'yes'
                    ],
                    [
                        'index' => 2,
                        'title' => 'Behavioral Assessment',
                        'status' => 'yes'
                    ]
                ],
                'background_information' => self::BASE_BACKGROUND,
                'previous_treatment_and_result' => 'Previous ABA therapy with positive outcomes',
                'current_treatment_and_progress' => 'Currently receiving regular ABA therapy',
                'education_status' => 'Attending special education program',
                'physical_and_medical_status' => 'Generally healthy, no major concerns',
                'strengths' => 'Good motor skills, responsive to reinforcement',
                'weaknesses' => 'Communication difficulties, attention challenges'
            ],
            [
                'client_id' => 2, // Make sure this user exists
                'patient_identifier' => 'PAT002',
                'doctor_id' => 4, // BCBA2
                'type_of_assessment' => 1,
                'documents_reviewed' => [
                    [
                        'index' => 1,
                        'title' => 'School Records',
                        'status' => 'yes'
                    ],
                    [
                        'index' => 2,
                        'title' => 'Behavioral Assessment',
                        'status' => 'yes'
                    ]
                ],
                'background_information' => 'Patient background information for PAT002',
                'previous_treatment_and_result' => 'First time in ABA therapy',
                'current_treatment_and_progress' => 'New to ABA treatment program',
                'education_status' => 'Mainstream education with support',
                'physical_and_medical_status' => 'No significant health concerns',
                'strengths' => 'Strong visual learning skills',
                'weaknesses' => 'Social interaction challenges'
            ]
        ];

        foreach ($bips as $bipData) {
            Bip::create($bipData);
        }
    }
}
