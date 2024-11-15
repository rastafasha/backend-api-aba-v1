<?php

namespace App\Services;

require __DIR__ . '/../Utils/edi837p.php';

class EdiX12837Service
{
    private $segTer;
    private $eleDataSep;
    private $compEleSep;

    public function __construct($segTer = "~", $eleDataSep = "*", $compEleSep = ":")
    {
        $this->segTer = $segTer;
        $this->eleDataSep = $eleDataSep;
        $this->compEleSep = $compEleSep;
    }

    public function test($res): string
    {
        $content = create_x12_837_file($res, $this->segTer, $this->eleDataSep, $this->compEleSep);
        return $content;
    }

    public function generate($res)
    {
        $file_data = "";
        $loopcounter = 0;

        foreach ($res as $row) {
            // ISA - Interchange Control Header
            $file_data .= $this->createISA($row) . PHP_EOL;

            // GS - Functional Group Header
            $file_data .= $this->createGS($row) . PHP_EOL;

            // ST - Transaction Set Header
            $file_data .= $this->createST($row) . PHP_EOL;
            ++$loopcounter;

            // BHT - Beginning of Hierarchical Transaction
            $file_data .= $this->createBHT($row) . PHP_EOL;
            ++$loopcounter;

            // Submitter Information - 1000A
            $file_data .= $this->createNM1($row, 'SUBMITTER') . PHP_EOL;
            ++$loopcounter;
            if (!empty($row['submitter_telephone'])) {
                $file_data .= $this->createPER($row, 'TE') . PHP_EOL;
                ++$loopcounter;
            }
            if (!empty($row['submitter_email'])) {
                $file_data .= $this->createPER($row, 'EM') . PHP_EOL;
                ++$loopcounter;
            }

            // Receiver Information - 1000B
            $file_data .= $this->createNM1($row, 'RC') . PHP_EOL;
            ++$loopcounter;

            // Billing Provider Hierarchical Level - 2000A
            $file_data .= $this->createHL($row, 1) . PHP_EOL;
            ++$loopcounter;

            // Billing Provider Specialty Information
            $file_data .= $this->createPRV($row) . PHP_EOL;
            ++$loopcounter;

            // Billing Provider Name - 2010AA
            $file_data .= $this->createNM1($row, 'BP') . PHP_EOL;
            ++$loopcounter;
            $file_data .= $this->createN3($row, 'BP') . PHP_EOL;
            ++$loopcounter;
            $file_data .= $this->createN4($row, 'BP') . PHP_EOL;
            ++$loopcounter;

            // Billing Provider Tax ID
            if (!empty($row['billing_provider_federal_taxid'])) {
                $file_data .= $this->createREF($row, 'EI') . PHP_EOL;
                ++$loopcounter;
            }

            // Subscriber Hierarchical Level - 2000B
            $file_data .= $this->createHL($row, 2) . PHP_EOL;
            ++$loopcounter;

            // Subscriber Information
            $file_data .= $this->createSBR($row, 'PR') . PHP_EOL;
            ++$loopcounter;
            $file_data .= $this->createNM1($row, 'IL') . PHP_EOL;
            ++$loopcounter;
            $file_data .= $this->createN3($row, 'SB') . PHP_EOL;
            ++$loopcounter;
            $file_data .= $this->createN4($row, 'SB') . PHP_EOL;
            ++$loopcounter;
            $file_data .= $this->createDMG($row) . PHP_EOL;
            ++$loopcounter;

            // Payer Name - 2010BB
            $file_data .= $this->createNM1($row, 'PR') . PHP_EOL;
            ++$loopcounter;

            // Claim Information - 2300
            $file_data .= $this->createCLM($row) . PHP_EOL;
            ++$loopcounter;

            // Prior Authorization
            if (!empty($row['prior_auth_code'])) {
                $file_data .= $this->createREF($row, 'G1') . PHP_EOL;
                ++$loopcounter;
            }

            // Diagnosis Codes
            $file_data .= $this->createHI($row, 1) . PHP_EOL;
            ++$loopcounter;

            // Referring Provider
            if (!empty($row['ref_physician_npi'])) {
                $file_data .= $this->createNM1($row, 'DN') . PHP_EOL;
                ++$loopcounter;
            }

            // Rendering Provider
            if (!empty($row['rendering_provider_npi'])) {
                $file_data .= $this->createNM1($row, 82) . PHP_EOL;
                ++$loopcounter;
                $file_data .= $this->createPRV($row) . PHP_EOL;
                ++$loopcounter;
            }

            // Service Lines - 2400
            if (sizeof($row['procedure_codes'])) {
                $loopindex = 1;
                foreach ($row['procedure_codes'] as $proc_items) {
                    $file_data .= $this->createLX($row, $loopindex) . PHP_EOL;
                    ++$loopcounter;
                    $file_data .= $this->createSV1($row, $proc_items) . PHP_EOL;
                    ++$loopcounter;
                    $file_data .= $this->createDTP($row, 472, '', '', $proc_items['dos']) . PHP_EOL;
                    ++$loopcounter;

                    // Add Line Item Control Number if needed
                    if (!empty($proc_items['line_item_control_number'])) {
                        $file_data .= $this->createREF($row, '6R') . PHP_EOL;
                        ++$loopcounter;
                    }

                    $loopindex++;
                }
            }

            // Transaction Set Trailer
            ++$loopcounter;
            $file_data .= $this->createSE($row, $loopcounter) . PHP_EOL;

            // Functional Group Trailer
            $file_data .= $this->createGE($row) . PHP_EOL;

            // Interchange Control Trailer
            $file_data .= $this->createIEA($row) . PHP_EOL;
        }

        return $file_data;
    }

    private function createISA($row)
    {
        $ISA = array();
        $ISA[0] = "ISA";
        $ISA[1] = "00";
        $ISA[2] = str_pad("", 10, " ");
        $ISA[3] = "00";
        $ISA[4] = str_pad("", 10, " ");
        $ISA[5] = "ZZ";                // Change from "30" to "ZZ"
        $ISA[6] = str_pad($row['x12_sender_id'], 15, " ");
        $ISA[7] = "ZZ";                // Change from "30" to "ZZ"
        $ISA[8] = str_pad($row['x12_reciever_id'], 15, " ");
        $ISA[9] = str_pad(date('ymd'), 6, " ");
        $ISA[10] = str_pad(date('Hi'), 4, " ");
        $ISA[11] = str_pad("^", 1, " ");
        $ISA[12] = str_pad(substr($row['x12_version'], 0, 5), 5, " ");
        $ISA[13] = str_pad("000000001", 9, " ");
        $ISA[14] = str_pad("1", 1, " ");
        $ISA[15] = str_pad("P", 1, " ");

        $ISA['Created'] = implode('*', $ISA);
        $ISA['Created'] = $ISA['Created'] . "*";
        $ISA['Created'] = $ISA ['Created'] . $this->compEleSep . $this->segTer;

        return trim($ISA['Created']);
    }

    private function createGS($row)
    {
        $GS = array();
        $GS[0] = "GS";
        $GS[1] = "HC";
        $GS[2] = $row['x12_sender_id'];
        $GS[3] = $row['x12_reciever_id'];
        $GS[4] = date('Ymd');
        $GS[5] = date('His');
        $GS[6] = str_pad($row['group_number'], 9, "0", STR_PAD_LEFT);
        $GS[7] = "X";
        $GS[8] = $row['x12_version'];

        $GS['Created'] = implode('*', $GS);
        $GS['Created'] = $GS['Created'] . $this->segTer;

        return trim($GS['Created']);
    }

    private function createGE($row)
    {
        $GE = array();
        $GE[0] = "GE";
        $GE[1] = "1";
        $GE[2] = str_pad($row['group_number'], 9, "0", STR_PAD_LEFT);

        $GE['Created'] = implode('*', $GE);
        $GE['Created'] = $GE['Created'] . $this->segTer;

        return trim($GE['Created']);
    }

    private function createIEA($row)
    {
        $IEA = array();
        $IEA[0] = "IEA";
        $IEA[1] = "1";
        $IEA[2] = "000000001";

        $IEA['Created'] = implode('*', $IEA);
        $IEA['Created'] = $IEA['Created'] . $this->segTer;

        return trim($IEA['Created']);
    }

    private function createST($row)
    {
        $ST = array();
        $ST[0] = "ST";
        $ST[1] = "837";
        $ST[2] = str_pad($row['batch_number'], 9, "0", STR_PAD_LEFT);
        $ST[3] = $row['x12_version'];

        $ST['Created'] = implode('*', $ST);
        $ST['Created'] = $ST['Created'] . $this->segTer;

        return trim($ST['Created']);
    }

    private function createBHT($row)
    {
        $BHT = array();
        $BHT[0] = "BHT";
        $BHT[1] = "0019";
        $BHT[2] = "00";
        $BHT[3] = str_pad($row['transcode'], 11, "0", STR_PAD_LEFT);
        $BHT[4] = str_pad(date('Ymd'), 8, " ");
        $BHT[5] = str_pad(date('Hi'), 4, " ");
        $BHT[6] = "CH";

        $BHT['Created'] = implode('*', $BHT);
        $BHT['Created'] = $BHT['Created'] . $this->segTer;

        return trim($BHT['Created']);
    }

    private function createNM1($row, $nm1Cast)
    {
        $NM1 = array();
        $NM1[0] = "NM1";

        if ($nm1Cast == 'RC') {
            $NM1[1] = "40";
            $NM1[2] = "2";
            $NM1[3] = $row["payer_name"];
            $NM1[4] = "";
            $NM1[5] = "";
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "46";
            $NM1[9] = $row["payer_code"];
        } elseif ($nm1Cast == '87') {
            $NM1[1] = "87";
            $NM1[2] = "2";
            $NM1[3] = $row['billing_provider_lastname'];
            $NM1[4] = "";
            $NM1[5] = "";
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "XX";
            $NM1[9] = $row['billing_provider_npi'];
        } elseif ($nm1Cast == 'BP') {
            $NM1[1] = "85";
            $NM1[2] = "2";
            $NM1[3] = $row['billing_provider_lastname'];
            $NM1[4] = "";
            $NM1[5] = "";
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "XX";
            $NM1[9] = $row['billing_provider_npi'];
        } elseif ($nm1Cast == 'SUBMITTER') {
            $NM1[1] = "41";
            $NM1[2] = "2";
            $NM1[3] = $row['submitter_org_name'];
            $NM1[4] = "";
            $NM1[5] = "";
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "46";
            $NM1[9] = $row['submitter_tax_id'];
        } elseif ($nm1Cast == 'SB') {
            $NM1[1] = "41";
            $NM1[2] = "1";
            $NM1[3] = $row['subscriber_lname'];
            $NM1[4] = $row['subscriber_fname'];
            $NM1[5] = $row['subscriber_mname'];
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "46";
            $NM1[9] = $row['subscriber_policy_number'];
        } elseif ($nm1Cast == 'IL') {
            $NM1[1] = "IL";
            $NM1[2] = "1";
            $NM1[3] = $row['subscriber_lname'];
            $NM1[4] = $row['subscriber_fname'];
            $NM1[5] = $row['subscriber_mname'];
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "MI";
            $NM1[9] = $row['subscriber_policy_number'];
        } elseif ($nm1Cast == 'DN') {
            $NM1[1] = "DN";
            $NM1[2] = "1";
            $NM1[3] = $row['ref_physician_lname'];
            $NM1[4] = $row['ref_physician_fname'];
            $NM1[5] = $row['ref_physician_mname'];
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "XX";
            $NM1[9] = $row['ref_physician_npi'];
        } elseif ($nm1Cast == 82) {
            $NM1[1] = "82";
            $NM1[2] = "1";
            $NM1[3] = $row['rendering_provider_lname'];
            $NM1[4] = $row['rendering_provider_fname'];
            $NM1[5] = $row['rendering_provider_mname'];
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "XX";
            $NM1[9] = $row['rendering_provider_npi'];
        } elseif ($nm1Cast == 77) {
            $NM1[1] = "82";
            $NM1[2] = "2";
            $NM1[3] = $row["facility_name"];
            $NM1[4] = "";
            $NM1[5] = "";
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "XX";
            $NM1[9] = $row['facility_npi'];
        } elseif ($nm1Cast == 'PR') {
            $NM1[1] = "PR";
            $NM1[2] = "2";
            $NM1[3] = $row["payer_name"];
            $NM1[4] = "";
            $NM1[5] = "";
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "PI";
            $NM1[9] = $row["payer_code"];
        } elseif ($nm1Cast == 'PR2') {
            $NM1[1] = "PR";
            $NM1[2] = "2";
            $NM1[3] = $row["secondary_payer_name"];
            $NM1[4] = "";
            $NM1[5] = "";
            $NM1[6] = "";
            $NM1[7] = "";
            $NM1[8] = "PI";
            $NM1[9] = $row["secondary_payer_code"];
        }

        $NM1['Created'] = implode('*', $NM1);
        $NM1['Created'] = $NM1['Created'] . $this->segTer;

        return trim($NM1['Created']);
    }

    private function createPER($row, $type)
    {
        $PER = array();
        $PER[0] = "PER";
        $PER[1] = "IC";
        $PER[2] = "";

        if ($type == 'TE') {
            $PER[3] = "TE";
            $PER[4] = $row['submitter_telephone'];
        }
        if ($type == 'EM') {
            $PER[3] = "EM";
            $PER[4] = $row['submitter_email'];
        }

        $PER['Created'] = implode('*', $PER);
        $PER['Created'] = $PER['Created'] . $this->segTer;

        return trim($PER['Created']);
    }

    private function createHL($row, $nHlCounter)
    {
        $HL = array();
        $HL[0] = "HL";

        if ($nHlCounter == 1) {
            $HL[1] = "1";
            $HL[2] = "";
            $HL[3] = "20";
            $HL[4] = "1";
        } elseif ($nHlCounter == 2) {
            $HL[1] = "2";
            $HL[2] = "1";
            $HL[3] = "22";
            $HL[4] = "0";
        }

        $HL['Created'] = implode('*', $HL);
        $HL['Created'] = $HL['Created'] . $this->segTer;

        return trim($HL['Created']);
    }

    private function createPRV($row)
    {
        $PRV = array();
        $PRV[0] = "PRV";
        $PRV[1] = "BI";
        $PRV[2] = "PXC";
        $PRV[3] = $row['biller_tax_code'];

        $PRV['Created'] = implode('*', $PRV);
        $PRV['Created'] = $PRV['Created'] . $this->segTer;

        return trim($PRV['Created']);
    }

    private function createN3($row, $ref)
    {
        $N3 = array();
        $N3[0] = "N3";

        if ($ref == 'SB') {
            $N3[1] = $row['subscriber_address'];
            $N3[2] = $row['subscriber_address2'];
        } elseif ($ref == 'BP') {
            $N3[1] = $row['billing_provider_street'];
            $N3[2] = $row['billing_provider_street2'];
        } elseif ($ref == 'PR') {
            $N3[1] = $row['payer_street'];
            $N3[2] = $row['payer_street2'];
        } elseif ($ref == 'PR2') {
            $N3[1] = $row['secondary_payer_street'];
            $N3[2] = $row['secondary_payer_street2'];
        } elseif ($ref == 'FA') {
            $N3[1] = $row['facility_address'];
            $N3[2] = "";
        }

        $N3['Created'] = implode('*', $N3);
        $N3['Created'] = $N3['Created'] . $this->segTer;

        return trim($N3['Created']);
    }

    private function createN4($row, $ref)
    {
        $N4 = array();
        $N4[0] = "N4";

        if ($ref == 'SB') {
            $N4[1] = $row['subscriber_city'];
            $N4[2] = $row['subscriber_state'];
            $N4[3] = $row['subscriber_zip'];
        } elseif ($ref == 'BP') {
            $N4[1] = $row['billing_provider_city'];
            $N4[2] = $row['billing_provider_state'];
            $N4[3] = $row['billing_provider_zip'];
        } elseif ($ref == 'PR') {
            $N4[1] = $row['payer_city'];
            $N4[2] = $row['payer_state'];
            $N4[3] = $row['payer_zip'];
        } elseif ($ref == 'PR2') {
            $N4[1] = $row['secondary_payer_city'];
            $N4[2] = $row['secondary_payer_state'];
            $N4[3] = $row['secondary_payer_zip'];
        } elseif ($ref == 'FA') {
            $N4[1] = $row['facility_city'];
            $N4[2] = $row['facility_state'];
            $N4[3] = $row['facility_zip'];
        }

        $N4['Created'] = implode('*', $N4);
        $N4['Created'] = $N4['Created'] . $this->segTer;

        return trim($N4['Created']);
    }

    private function createREF($row, $ref)
    {
        $REF = array();
        $REF[0] = "REF";

        if ($ref == 'SY') {
            $REF[1] = $ref;
            $REF[2] = $row['billing_provider_pin'];
        }
        if ($ref == 'EI') {
            $REF[1] = $ref;
            $REF[2] = $row['billing_provider_federal_taxid'];
        }
        if ($ref == 'G1') {
            $REF[1] = $ref;
            $REF[2] = $row['prior_auth_code'];
        }
        if ($ref == 'F8') {
            $REF[1] = $ref;
            $REF[2] = $row['original_claim_number'];
        }
        if ($ref == 'X4') {
            $REF[1] = $ref;
            $REF[2] = $row['original_claim_number'];
        }
        if ($ref == 'EA') {
            $REF[1] = $ref;
            $REF[2] = $row['patient_mrn'];
        }
        if ($ref == '9F') {
            $REF[1] = $ref;
            $REF[2] = $row['referral_number'];
        }

        $REF['Created'] = implode('*', $REF);
        $REF['Created'] = $REF['Created'] . $this->segTer;

        return trim($REF['Created']);
    }

    private function createSBR($row, $ref)
    {
        $SBR = array();
        $SBR[0] = "SBR";

        if ($ref == 'OT') {
            $SBR[1] = "S";
        } elseif ($ref == 'PR') {
            $SBR[1] = "P";
        }

        $SBR[2] = $this->translateRelationship($row['subscriber_relationship']);

        if ($ref == 'OT') {
            $SBR[3] = "";
            $SBR[4] = $row['subscriber_secondary_payer_name'];
            $SBR[5] = $row['subscriber_secondary_insurance_type'];
            $SBR[6] = "";
            $SBR[7] = "";
            $SBR[8] = "";
            $SBR[9] = "MB";
        } else {
            $SBR[3] = "";
            $SBR[4] = "";
            $SBR[5] = "";
            $SBR[6] = "";
            $SBR[7] = "";
            $SBR[8] = "";
            $SBR[9] = "HM";
        }

        $SBR['Created'] = implode('*', $SBR);
        $SBR['Created'] = $SBR['Created'] . $this->segTer;

        return trim($SBR['Created']);
    }

    private function createDMG($row)
    {
        $DMG = array();
        $DMG[0] = "DMG";
        $DMG[1] = "D8";
        $DMG[2] = $row['subscriber_dob'];
        $DMG[3] = $row['subscriber_gender'];

        $DMG['Created'] = implode('*', $DMG);
        $DMG['Created'] = $DMG['Created'] . $this->segTer;

        return trim($DMG['Created']);
    }

    private function createCLM($row)
    {
        $CLM = array();
        $CLM[0] = "CLM";
        $CLM[1] = $row['patient_id'];
        $CLM[2] = $row['total_amount'];
        $CLM[3] = "";
        $CLM[4] = "";
        $CLM[5] = "11:" . "B" . ":" . $row['claim_type'];
        $CLM[6] = "Y";
        $CLM[7] = "A";
        $CLM[8] = "Y";
        $CLM[9] = "Y";
        $CLM[10] = "P";

        $CLM['Created'] = implode('*', $CLM);
        $CLM['Created'] = $CLM['Created'] . $this->segTer;

        return trim($CLM['Created']);
    }

    private function createDTP($row, $ref, $segTer = '', $compEleSep = '', $dos = '')
    {
        $DTP = array();
        $DTP[0] = "DTP";
        $DTP[1] = $ref;
        $DTP[2] = "D8";

        if ($ref == '431') {
            $DTP[3] = $row['patient_encounter_date'];
        }
        if ($ref == '472') {
            $DTP[3] = $dos;
        }
        if ($ref == '454') {
            $DTP[3] = $row['patient_first_encounter_date'];
        }
        if ($ref == '304') {
            $DTP[3] = $row['patient_last_visit_date'];
        }
        if ($ref == '435') {
            $DTP[3] = $row['patient_admission_date'];
        }
        if ($ref == '096') {
            $DTP[3] = $row['patient_discharge_date'];
        }

        $DTP['Created'] = implode('*', $DTP);
        $DTP['Created'] = $DTP['Created'] . $this->segTer;

        return trim($DTP['Created']);
    }

    private function createAMT($row)
    {
        $AMT = array();
        $AMT[0] = "AMT";
        $AMT[1] = "F5";
        $AMT[2] = $row['patient_paid_amt'];

        $AMT['Created'] = implode('*', $AMT);
        $AMT['Created'] = $AMT['Created'] . $this->segTer;

        return trim($AMT['Created']);
    }

    private function createNTE($row)
    {
        $NTE = array();
        $NTE[0] = "NTE";
        $NTE[1] = "ADD";
        $NTE[2] = $row['claim_notes'];

        $NTE['Created'] = implode('*', $NTE);
        $NTE['Created'] = $NTE['Created'] . $this->segTer;

        return trim($NTE['Created']);
    }

    private function createHI($row, $primary)
    {
        $HI = array();
        $HI[0] = "HI";

        if ($primary == 1) {
            $icd_type = ($row['primary_problem_type_code'] == "ICD9") ? "BK" : "ABK";
            $HI[1] = $icd_type . ":" . $row['primary_problem_code'];
        } else {
            $loopvar = 1; //Max loop 12
            if (sizeof($row['other_diag_list'])) {
                foreach ($row['other_diag_list'] as $items) {
                    $icd_type = ($items['icd_type'] == "ICD9") ? "BF" : "ABF";
                    $HI[$loopvar] = $icd_type . ":" . $items['icd_codes'];
                    $loopvar++;
                }
            }
        }

        $HI['Created'] = implode('*', $HI);
        $HI['Created'] = $HI['Created'] . $this->segTer;

        return trim($HI['Created']);
    }

    private function createLX($row, $loopcount)
    {
        $LX = array();
        $LX[0] = "LX";
        $LX[1] = $loopcount;

        $LX['Created'] = implode('*', $LX);
        $LX['Created'] = $LX['Created'] . $this->segTer;

        return trim($LX['Created']);
    }

    private function createSV1($row, $items)
    {
        $SV1 = array();
        $SV1[0] = "SV1";
        $SV1[1] = "HC:" . $items['cpt_codes'];
        $SV1[2] = $items['cpt_charge'];
        $SV1[3] = "UN";
        $SV1[4] = $items['quantity'];
        $SV1[5] = $items['facility_code'];
        $SV1[6] = "";
        $SV1[7] = $items['code_pointer'];

        $SV1['Created'] = implode('*', $SV1);
        $SV1['Created'] = $SV1['Created'] . $this->segTer;

        return trim($SV1['Created']);
    }

    private function createSE($row, $segmentcount)
    {
        $SE = array();
        $SE[0] = "SE";
        $SE[1] = $segmentcount;
        $SE[2] = str_pad($row['batch_number'], 9, "0", STR_PAD_LEFT);

        $SE['Created'] = implode('*', $SE);
        $SE['Created'] = $SE['Created'] . $this->segTer;

        return trim($SE['Created']);
    }

    private function translateRelationship($relationship)
    {
        switch ($relationship) {
            case "spouse":
                return "01";
            case "child":
                return "19";
            case "self":
                return "18";
            default:
                return "G8";
        }
    }
}
