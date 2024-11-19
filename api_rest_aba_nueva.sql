-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-11-2024 a las 11:51:46
-- Versión del servidor: 10.6.19-MariaDB-cll-lve
-- Versión de PHP: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_rest_aba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `billings`
--

CREATE TABLE `billings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(155) DEFAULT NULL,
  `sponsor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cpt_code` varchar(155) DEFAULT NULL,
  `insurer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `insurer_rate` double DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `total_hours` time DEFAULT NULL,
  `total_units` time DEFAULT NULL,
  `billing_total` double DEFAULT NULL,
  `week_total_hours` time DEFAULT NULL,
  `week_total_units` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bips`
--

CREATE TABLE `bips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_of_assessment` tinyint(4) NOT NULL DEFAULT 3,
  `documents_reviewed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents_reviewed`)),
  `background_information` text DEFAULT NULL,
  `previus_treatment_and_result` text DEFAULT NULL,
  `current_treatment_and_progress` text DEFAULT NULL,
  `education_status` text DEFAULT NULL,
  `phisical_and_medical_status` text DEFAULT NULL,
  `strengths` text DEFAULT NULL,
  `weakneses` text DEFAULT NULL,
  `phiysical_and_medical` text DEFAULT NULL,
  `phiysical_and_medical_status` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`phiysical_and_medical_status`)),
  `maladaptives` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`maladaptives`)),
  `assestment_conducted` text DEFAULT NULL,
  `assestment_conducted_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assestment_conducted_options`)),
  `assestmentEvaluationSettings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`assestmentEvaluationSettings`)),
  `prevalent_setting_event_and_atecedents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`prevalent_setting_event_and_atecedents`)),
  `hypothesis_based_intervention` text DEFAULT NULL,
  `interventions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`interventions`)),
  `tangibles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tangibles`)),
  `attention` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attention`)),
  `escape` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`escape`)),
  `sensory` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sensory`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bips`
--

INSERT INTO `bips` (`id`, `client_id`, `patient_id`, `doctor_id`, `type_of_assessment`, `documents_reviewed`, `background_information`, `previus_treatment_and_result`, `current_treatment_and_progress`, `education_status`, `phisical_and_medical_status`, `strengths`, `weakneses`, `phiysical_and_medical`, `phiysical_and_medical_status`, `maladaptives`, `assestment_conducted`, `assestment_conducted_options`, `assestmentEvaluationSettings`, `prevalent_setting_event_and_atecedents`, `hypothesis_based_intervention`, `interventions`, `tangibles`, `attention`, `escape`, `sensory`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'PAT001', 3, 3, '[\"Initial Assessment\",\"Medical Records\"]', 'Patient background information for PAT001', 'Previous ABA therapy with positive outcomes', 'Currently receiving regular ABA therapy', 'Attending special education program', 'Generally healthy, no major concerns', 'Good motor skills, responsive to reinforcement', 'Communication difficulties, attention challenges', NULL, NULL, '{\"tantrums\":true,\"aggression\":true}', NULL, NULL, NULL, NULL, NULL, '{\"positive_reinforcement\":true,\"token_economy\":true}', NULL, NULL, NULL, NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(2, 2, 'PAT002', 4, 3, '[\"Behavioral Assessment\",\"School Records\"]', 'Patient background information for PAT002', 'First time in ABA therapy', 'New to ABA treatment program', 'Mainstream education with support', 'No significant health concerns', 'Strong visual learning skills', 'Social interaction challenges', NULL, NULL, '{\"self_stimming\":true,\"avoidance\":true}', NULL, NULL, NULL, NULL, NULL, '{\"positive_reinforcement\":true,\"visual_schedules\":true}', NULL, NULL, NULL, NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `claims`
--

CREATE TABLE `claims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rbt_notes_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rbt_notes_ids`)),
  `bcba_notes_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bcba_notes_ids`)),
  `filename` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_reports`
--

CREATE TABLE `client_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(155) DEFAULT NULL,
  `sponsor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note_rbt_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note_bcba_id` bigint(20) UNSIGNED DEFAULT NULL,
  `insurer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cpt_code` varchar(155) DEFAULT NULL,
  `npi` varchar(150) DEFAULT NULL,
  `pa_number` varchar(100) DEFAULT NULL,
  `xe` varchar(100) DEFAULT NULL,
  `pos` varchar(50) DEFAULT NULL,
  `md` varchar(50) DEFAULT NULL,
  `md2` varchar(50) DEFAULT NULL,
  `mdbcba` varchar(50) DEFAULT NULL,
  `md2bcba` varchar(50) DEFAULT NULL,
  `session_date` timestamp NULL DEFAULT NULL,
  `total_hours` time DEFAULT NULL,
  `n_units` int(11) DEFAULT NULL,
  `chargesrbt` double DEFAULT NULL,
  `chargesbcba` double DEFAULT NULL,
  `billed` tinyint(1) NOT NULL DEFAULT 0,
  `billedbcba` tinyint(1) NOT NULL DEFAULT 0,
  `pay` tinyint(1) NOT NULL DEFAULT 0,
  `paybcba` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consent_to_treatments`
--

CREATE TABLE `consent_to_treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `analyst_signature` varchar(255) DEFAULT NULL,
  `analyst_signature_date` timestamp NULL DEFAULT NULL,
  `parent_guardian_signature` varchar(255) DEFAULT NULL,
  `parent_guardian_signature_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crisis_plans`
--

CREATE TABLE `crisis_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `crisis_description` text DEFAULT NULL,
  `crisis_note` text DEFAULT NULL,
  `caregiver_requirements_for_prevention_of_crisis` text DEFAULT NULL,
  `risk_factors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`risk_factors`)),
  `suicidalities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`suicidalities`)),
  `homicidalities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`homicidalities`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `de_escalation_techniques`
--

CREATE TABLE `de_escalation_techniques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `service_recomendation` text DEFAULT NULL,
  `recomendation_lists` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`recomendation_lists`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `family_envolments`
--

CREATE TABLE `family_envolments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `caregivers_training_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`caregivers_training_goals`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generalization_trainings`
--

CREATE TABLE `generalization_trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discharge_plan` text DEFAULT NULL,
  `transition_fading_plans` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`transition_fading_plans`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insurances`
--

CREATE TABLE `insurances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `insurer_name` varchar(255) DEFAULT NULL,
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Codes, provider, description, unit prize, Hourly Fee, max_allowed' CHECK (json_valid(`services`)),
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'description' CHECK (json_valid(`notes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `payer_id` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `street2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `insurances`
--

INSERT INTO `insurances` (`id`, `insurer_name`, `services`, `notes`, `created_at`, `updated_at`, `deleted_at`, `payer_id`, `street`, `street2`, `city`, `state`, `zip`) VALUES
(1, 'Fl Blue', '[{\"code\":\"97151\",\"provider\":\"BCBA\",\"description\":\"Assessment\",\"unit_prize\":\"21\",\"hourly_fee\":\"84\",\"max_allowed\":\"(max 2 hrs\\/day) total 40 units\\/10 hours copay will aply per day\"},{\"code\":\"97153\",\"provider\":\"RBT\",\"description\":\"Therapy\",\"unit_prize\":\"13\",\"hourly_fee\":\"52\",\"max_allowed\":\"(max 8 hrs\\/day)\"},{\"code\":\"97155\",\"provider\":\"BCBA\",\"description\":\"BIP modification only\",\"unit_prize\":\"20.4\",\"hourly_fee\":\"81.6\",\"max_allowed\":null},{\"code\":\"97156\",\"provider\":\"BCBA\",\"description\":\"Caregiver Training\",\"unit_prize\":\"19\",\"hourly_fee\":\"76\",\"max_allowed\":null},{\"code\":\"97157\",\"provider\":\"BCBA\",\"description\":\"Group Caregiver Training( Multi-family)\",\"unit_prize\":\"3\",\"hourly_fee\":null,\"max_allowed\":null},{\"code\":\"H0032\",\"provider\":\"BCBA\",\"description\":null,\"unit_prize\":\"17\",\"hourly_fee\":\"68\",\"max_allowed\":null}]', '[{\"note\":\"Horizon by BCBS\"},{\"note\":\"Horizon BCBSNJ will use H0032 for Indirect service (treatment planning)\"},{\"note\":\"telehealth: submit a claim to Florida Blue using one of the regular codes included in your fee schedule. The place of service should be the regular place of service as if you saw the patient in-person.\"},{\"note\":\"Modifier XE for 2 sessions, same day different POS\"},{\"note\":\"Now allows concurrent billing of 97155 and 97153, effecitve 12\\/01\\/2021\"},{\"note\":\"97156 is always ALLOWED to overlap with 97153\"}]', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'United', '[{\"code\":\"97153\",\"provider\":\"RBT\",\"description\":\"therapy\",\"unit_prize\":\"12.51\",\"hourly_fee\":\"50.04\",\"max_allowed\":null},{\"code\":\"97151\",\"provider\":\"BCBA\",\"description\":\"IA (40 units)\",\"unit_prize\":\"29.88\",\"hourly_fee\":\"119.52\",\"max_allowed\":null},{\"code\":\"97155\",\"provider\":\"BCBA 97155\",\"description\":\"supervision\",\"unit_prize\":\"19.32\",\"hourly_fee\":\"77.28\",\"max_allowed\":null},{\"code\":\"97156\",\"provider\":\"BCBA 97156\",\"description\":\"PT\",\"unit_prize\":\"17.51\",\"hourly_fee\":\"70.04\",\"max_allowed\":null},{\"code\":\"97153\",\"provider\":\"BCBA\",\"description\":\"therapy\",\"unit_prize\":\"16.68\",\"hourly_fee\":\"66.72\",\"max_allowed\":null},{\"code\":\"97151\",\"provider\":\"BCaBA\",\"description\":null,\"unit_prize\":\"25.4\",\"hourly_fee\":\"101.6\",\"max_allowed\":null},{\"code\":\"97153\",\"provider\":\"BCaBA\",\"description\":null,\"unit_prize\":\"14.18\",\"hourly_fee\":\"56.72\",\"max_allowed\":null},{\"code\":\"97155\",\"provider\":\"BCaBA\",\"description\":null,\"unit_prize\":\"16.42\",\"hourly_fee\":\"65.68\",\"max_allowed\":null},{\"code\":\"97156\",\"provider\":\"BCaBA\",\"description\":null,\"unit_prize\":\"14.88\",\"hourly_fee\":\"59.52\",\"max_allowed\":null}]', '[{\"note\":\"No school or community covered unless aproved by peer review on auth\"},{\"note\":\"If the rendering provider is required, use the BCBA on the case.\"},{\"note\":\"for 97155 Yes. When supervision is provided, you may bill concurrently for both Supervisors and Behavior Technicians, billing with 97153 and 97155.\"},{\"note\":\"Modifier XE for 2 sessions, same day different POS\"},{\"note\":\"Modifiers: RBT- HM, BCBA- HO, BCaBA- HN\"},{\"note\":\"97156 is always allowed to overlap with 97153\"}]', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'CIGNA', '[{\"code\":\"97151\",\"provider\":\"BCBA\",\"description\":\"Assessment\",\"unit_prize\":\"48\",\"hourly_fee\":\"21\",\"max_allowed\":\"48 units\\/ (12 hrs), No PA req.\"},{\"code\":\"97153\",\"provider\":\"RBT\",\"description\":\"Therapy\",\"unit_prize\":\"15\",\"hourly_fee\":\"10\",\"max_allowed\":null},{\"code\":\"97155\",\"provider\":\"BCBA (RBT supervision)\",\"description\":\"Therapy\",\"unit_prize\":\"0\",\"hourly_fee\":\"19\",\"max_allowed\":null},{\"code\":\"97156\",\"provider\":\"Caregiver Training\",\"description\":\"Therapy\",\"unit_prize\":\"0\",\"hourly_fee\":\"19\",\"max_allowed\":null}]', '[{\"note\":\"Modifier XE for 2 sessions, same day different POS\\\\t\\\\t\\\\t\\\\ncan bill RBT and BCBA together por supervision\\\\t\\\\t\\\\t\\\\nOnly one provider can bill for a unit of time with the exception of CPT codes 97153 and 97155 (direct\\\\t\\\\t\\\\t\\\\nsupervision when the Board Certified Behavior Analyst\\u00ae (BCBA\\u00ae)\\/Qualified Healthcare Provider\\\\t\\\\t\\\\t\\\\n(QHP) directs the technician and both are face-to-face with the patient at the same time).\\\\t\\\\t\\\\t\\\\nbill services under the BCBA or licensed provider, allows lmhc\"}]', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'TRICARE', '[{\"code\":\"97151\",\"provider\":\"BCBA\",\"description\":\"Assessment\",\"unit_prize\":\"37.35\",\"hourly_fee\":\"136.24\",\"max_allowed\":\"32 units for initial\\/24 for reassessment, units per authorization (2 hrs\\/day)\"},{\"code\":\"97153\",\"provider\":\"RBT\",\"description\":\"Therapy\",\"unit_prize\":\"18.46\",\"hourly_fee\":\"64.44\",\"max_allowed\":\"32 units per day\\/ (8 hrs\\/day)\"},{\"code\":\"97153\",\"provider\":\"BCBA\",\"description\":\"Therapy\",\"unit_prize\":\"31.25\",\"hourly_fee\":\"125\",\"max_allowed\":null},{\"code\":\"97155\",\"provider\":\"97155\",\"description\":\"BIP modification only\",\"unit_prize\":\"32.15\",\"hourly_fee\":\"125\",\"max_allowed\":\"8 units per day\\/ (2 hr\\/day)\"},{\"code\":\"97156\",\"provider\":\"BCBA\",\"description\":\"Caregiver Training\",\"unit_prize\":\"31.25\",\"hourly_fee\":\"125\",\"max_allowed\":\"8 units per day\\/ (2 hr\\/day)\"},{\"code\":\"T1023\",\"provider\":\"BCBA\",\"description\":\"PDDBI\",\"unit_prize\":\"0\",\"hourly_fee\":\"68.13\",\"max_allowed\":null},{\"code\":\"97153\",\"provider\":\"BCaBA\",\"description\":\"Therapy\",\"unit_prize\":\"20.62\",\"hourly_fee\":\"75\",\"max_allowed\":\"32 units per day\\/ (8 hrs\\/day)\"},{\"code\":\"97155\",\"provider\":\"BCaBA\",\"description\":\"BIP modification only\",\"unit_prize\":\"26.8\",\"hourly_fee\":\"107.2\",\"max_allowed\":null},{\"code\":\"97156\",\"provider\":\"BCaBA\",\"description\":\"Caregiver Training\",\"unit_prize\":\"31.25\",\"hourly_fee\":\"125\",\"max_allowed\":\"8 units per day\\/ (2 hr\\/day)\"}]', '[{\"note\":\"Concurrent billing is excluded for all ABA Category I CPT codes\"},{\"note\":\"Does not allow billing for any two ABA providers at the same time. or same date\"},{\"note\":\"If BCBA overlap with BCaBA, bill BCBA\"},{\"note\":\"8.11.7.3.8 Concurrent billing is excluded for all ACD Category I CPT codes except when the family and the beneficiary are receiving separate services and the beneficiary is not present in the family session. Documentation must indicate two separate rendering providers and locations for the services.\"},{\"note\":\"Yes they credential LMHC\"}]', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'AETNA', '[{\"code\":\"97151\",\"provider\":\"BCBA\",\"description\":\"Assessment\",\"unit_prize\":\"22\",\"hourly_fee\":\"88\",\"max_allowed\":\"48 units\\/ (12 hrs), 2 hr per day max\"},{\"code\":\"97152\",\"provider\":\"RBT\",\"description\":\"Assessment\",\"unit_prize\":\"16\",\"hourly_fee\":\"64\",\"max_allowed\":null},{\"code\":\"0362T\",\"provider\":\"Supporting\",\"description\":\"Assessment\",\"unit_prize\":\"20\",\"hourly_fee\":\"88\",\"max_allowed\":null},{\"code\":\"97155\",\"provider\":\"MD or QHP\",\"description\":\"BIP modification only\",\"unit_prize\":\"22\",\"hourly_fee\":\"88\",\"max_allowed\":null},{\"code\":\"0373T\",\"provider\":\"BCBA\",\"description\":\"BIP modification only\",\"unit_prize\":\"20\",\"hourly_fee\":\"88\",\"max_allowed\":null},{\"code\":\"97153\",\"provider\":\"RBT\",\"description\":\"Therapy\",\"unit_prize\":\"16\",\"hourly_fee\":\"64\",\"max_allowed\":null},{\"code\":\"97156\",\"provider\":\"BCBA\",\"description\":\"Caregiver Training\",\"unit_prize\":\"22\",\"hourly_fee\":\"88\",\"max_allowed\":null},{\"code\":\"97154\",\"provider\":\"Group\",\"description\":\"Therapy\",\"unit_prize\":\"16\",\"hourly_fee\":\"64\",\"max_allowed\":null},{\"code\":\"97157\",\"provider\":\"BCBA\",\"description\":\"Therapy Multiple-family group\",\"unit_prize\":\"22\",\"hourly_fee\":\"88\",\"max_allowed\":null},{\"code\":\"97158\",\"provider\":\"group MD or QHP\",\"description\":\"BIP modification only\",\"unit_prize\":\"22\",\"hourly_fee\":\"88\",\"max_allowed\":null}]', '[{\"note\":\"Modifier: Telehealth (02) - 95\"},{\"note\":\"Modifier XE for 2 sessions, same day different POS\"}]', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Medicaid', '[{\"code\":\"97153\",\"provider\":\"RBT, BCaBA\",\"description\":\"Direct Service provided by a Registered Behavior Technician (RBT), a BCaBA, or a Lead Analyst\",\"unit_prize\":\"12.19\",\"hourly_fee\":\"219.42\",\"max_allowed\":\"max 8 hours per day\"},{\"code\":\"97156\",\"provider\":\"Lead Analyst\",\"description\":\"Family training by Lead Analyst Service provided by a Lead Analyst\",\"unit_prize\":\"19.05\",\"hourly_fee\":\"76.2\",\"max_allowed\":\"max 4H per day\"},{\"code\":\"97156 GT\",\"provider\":\"Lead Analyst\",\"description\":\"Family training via telemedicine Service provided by a Lead Analyst; Florida Medicaid reimburses up to 2 hours per week\",\"unit_prize\":\"19.05\",\"hourly_fee\":\"76.2\",\"max_allowed\":null},{\"code\":\"97155\",\"provider\":\"PM\",\"description\":\"Behavior treatment with protocol modification (PM) Service provided by a Lead Analyst\",\"unit_prize\":\"19.05\",\"hourly_fee\":\"76.2\",\"max_allowed\":\"max 6 hours per day (PM needs to be on the notes)\"},{\"code\":\"97156 HN\",\"provider\":\"BCaBA\",\"description\":\"Family training by assistant Service performed by a BCaBA\",\"unit_prize\":\"15.24\",\"hourly_fee\":\"60.96\",\"max_allowed\":null},{\"code\":\"97155 HN\",\"provider\":\"BCaBA\",\"description\":\"Behavior treatment with protocol modification Service provided by a BCaBA\",\"unit_prize\":\"15.24\",\"hourly_fee\":\"243.84\",\"max_allowed\":null},{\"code\":\"97151\",\"provider\":null,\"description\":\"Assessment maximum of 24 units\",\"unit_prize\":\"19.05\",\"hourly_fee\":\"38.1\",\"max_allowed\":\"max 2 hours per day\"},{\"code\":\"97151 TS\",\"provider\":null,\"description\":\"Reassessment maximum of 18 units\",\"unit_prize\":\"19.05\",\"hourly_fee\":\"152.4\",\"max_allowed\":\"max 2 hours per day\"}]', '[{\"note\":\"overlap: if 97153 is concurrent with 97155, 97153 need to use modifier XP (Not reimbursed)\"},{\"note\":\"All services need to be  billed\"},{\"note\":\"02+ GT for telehealth\"},{\"note\":\"Modifier XE for 2 sessions, same day different POS\"},{\"note\":\"For sunshine cases w\\/ member ID starts with a 7, the PA needs to be under the BCBA name that is on the case.\"}]', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'NOW KBA', '[{\"code\":\"97151\",\"provider\":\"BCBA\",\"description\":\"Assessment\",\"unit_prize\":\"34.06\",\"hourly_fee\":\"136.24\",\"max_allowed\":\"32 units for initial\\/32 for reassessment, units per authorization (2 hrs\\/day)\"},{\"code\":\"97153\",\"provider\":\"RBT\",\"description\":\"Therapy\",\"unit_prize\":\"18.75\",\"hourly_fee\":\"75\",\"max_allowed\":\"32 units per day\\/ (8 hrs\\/day)\"},{\"code\":\"97153\",\"provider\":\"BCBA\",\"description\":\"Therapy\",\"unit_prize\":\"31.25\",\"hourly_fee\":\"125\",\"max_allowed\":null},{\"code\":\"97155\",\"provider\":\"BCBA\",\"description\":\"BIP modification only\",\"unit_prize\":\"31.25\",\"hourly_fee\":\"125\",\"max_allowed\":\"8 units per day\\/ (2 hr\\/day)\"},{\"code\":\"97156\",\"provider\":\"BCBA\",\"description\":\"Caregiver Training\",\"unit_prize\":\"31.25\",\"hourly_fee\":\"125\",\"max_allowed\":\"8 units per day\\/ (2 hr\\/day)\"},{\"code\":\"T1023\",\"provider\":\"BCBA\",\"description\":\"PDDBI\",\"unit_prize\":null,\"hourly_fee\":\"68.13\",\"max_allowed\":null},{\"code\":\"97153\",\"provider\":\"BCaBA\",\"description\":\"Therapy\",\"unit_prize\":\"18.75\",\"hourly_fee\":\"75\",\"max_allowed\":\"32 units per day\\/ (8 hrs\\/day)\"},{\"code\":\"97155\",\"provider\":\"BCaBA\",\"description\":\"BIP modification only\",\"unit_prize\":\"20.79\",\"hourly_fee\":\"83.16\",\"max_allowed\":null},{\"code\":\"97156\",\"provider\":\"BCaBA\",\"description\":\"Caregiver Training\",\"unit_prize\":\"31.25\",\"hourly_fee\":\"125\",\"max_allowed\":\"8 units per day\\/ (2 hr\\/day)\"}]', '[{\"note\":\"Modifier XE for 2 sessions, same day different POS\"},{\"note\":\"ALLOWS OVERLAP BILLING\"}]', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `zip` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `telfax` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `locations`
--

INSERT INTO `locations` (`id`, `title`, `avatar`, `city`, `state`, `zip`, `address`, `email`, `phone1`, `phone2`, `telfax`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Main Office', NULL, 'Miami', 'FL', '33101', '123 Main St', 'main@example.com', '305-555-0123', '305-555-0124', '305-555-0125', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL),
(2, 'Branch Office', NULL, 'Orlando', 'FL', '32801', '456 Branch Ave', 'orlando@example.com', '407-555-0123', '407-555-0124', '407-555-0125', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL),
(3, 'South Miami Center', NULL, 'Miami', 'FL', '33143', '789 Treatment Blvd', 'south@example.com', '305-555-0126', '305-555-0127', '305-555-0128', '2024-11-16 11:15:52', '2024-11-16 11:15:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_11_30_175428_create_jobs_table', 1),
(6, '2022_12_18_035041_create_contacts_table', 1),
(7, '2023_11_29_231903_create_permission_tables', 1),
(8, '2024_01_01_000001_create_locations_table', 1),
(9, '2024_01_01_000002_create_insurances_table', 1),
(10, '2024_01_01_000004_create_patients_table', 1),
(11, '2024_01_01_000008_create_pa_services_table', 1),
(12, '2024_01_01_000010_create_bips_table', 1),
(13, '2024_01_01_000012_create_reduction_goals_table', 1),
(14, '2024_01_01_000016_create_note_rbts_table', 1),
(15, '2024_01_01_000018_create_note_bcbas_table', 1),
(16, '2024_01_01_000022_create_patient_files_table', 1),
(17, '2024_01_01_000024_create_billings_table', 1),
(18, '2024_01_01_000028_create_client_reports_table', 1),
(19, '2024_01_01_000032_create_consent_to_treatments_table', 1),
(20, '2024_01_01_000036_create_sustitution_goals_table', 1),
(21, '2024_01_01_000040_create_generalization_trainings_table', 1),
(22, '2024_01_01_000044_create_crisis_plans_table', 1),
(23, '2024_01_01_000048_create_de_escalation_techniques_table', 1),
(24, '2024_01_01_000050_create_family_envolments_table', 1),
(25, '2024_11_01_182441_add_payer_id_to_insurances_table', 1),
(26, '2024_11_03_205233_add_address_fields_to_insurances_table', 1),
(27, '2024_11_07_225859_create_claims_table', 1),
(28, '2024_11_15_000020_create_monitoring_evaluatings_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(7, 'App\\Models\\User', 3),
(7, 'App\\Models\\User', 4),
(8, 'App\\Models\\User', 5),
(8, 'App\\Models\\User', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitoring_evaluatings`
--

CREATE TABLE `monitoring_evaluatings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `treatment_fidelity` text DEFAULT NULL,
  `rbt_training_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rbt_training_goals`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_bcbas`
--

CREATE TABLE `note_bcbas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `birth_date` timestamp NULL DEFAULT NULL,
  `diagnosis_code` varchar(50) DEFAULT NULL,
  `cpt_code` varchar(255) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `session_date` timestamp NULL DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `time_in2` time DEFAULT NULL,
  `time_out2` time DEFAULT NULL,
  `session_length_total` double DEFAULT NULL,
  `note_description` text DEFAULT NULL,
  `rendering_provider` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `caregiver_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`caregiver_goals`)),
  `rbt_training_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rbt_training_goals`)),
  `provider_signature` varchar(255) DEFAULT NULL,
  `provider_name` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_signature` varchar(255) DEFAULT NULL,
  `supervisor_name` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','ok','no','review') NOT NULL DEFAULT 'pending',
  `summary_note` text DEFAULT NULL,
  `billedbcba` tinyint(1) NOT NULL DEFAULT 0,
  `paybcba` tinyint(1) NOT NULL DEFAULT 0,
  `mdbcba` varchar(20) DEFAULT NULL,
  `md2bcba` varchar(20) DEFAULT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `pa_service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_rbts`
--

CREATE TABLE `note_rbts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pos` varchar(255) DEFAULT NULL,
  `session_date` timestamp NULL DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `time_in2` time DEFAULT NULL,
  `time_out2` time DEFAULT NULL,
  `session_length_total` double DEFAULT NULL,
  `environmental_changes` varchar(255) DEFAULT NULL,
  `maladaptives` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`maladaptives`)),
  `replacements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`replacements`)),
  `interventions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`interventions`)),
  `meet_with_client_at` varchar(255) DEFAULT NULL,
  `client_appeared` varchar(255) DEFAULT NULL,
  `as_evidenced_by` varchar(255) DEFAULT NULL,
  `rbt_modeled_and_demonstrated_to_caregiver` varchar(255) DEFAULT NULL,
  `client_response_to_treatment_this_session` text DEFAULT NULL,
  `progress_noted_this_session_compared_to_previous_session` varchar(255) DEFAULT NULL,
  `next_session_is_scheduled_for` timestamp NULL DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_signature` varchar(255) DEFAULT NULL,
  `provider_credential` varchar(255) DEFAULT NULL,
  `supervisor_signature` varchar(255) DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_name` bigint(20) UNSIGNED DEFAULT NULL,
  `billed` tinyint(1) NOT NULL DEFAULT 0,
  `pay` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','ok','no','review') NOT NULL DEFAULT 'pending',
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `cpt_code` text DEFAULT NULL,
  `pa_service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `note_rbts`
--

INSERT INTO `note_rbts` (`id`, `doctor_id`, `patient_id`, `bip_id`, `pos`, `session_date`, `time_in`, `time_out`, `time_in2`, `time_out2`, `session_length_total`, `environmental_changes`, `maladaptives`, `replacements`, `interventions`, `meet_with_client_at`, `client_appeared`, `as_evidenced_by`, `rbt_modeled_and_demonstrated_to_caregiver`, `client_response_to_treatment_this_session`, `progress_noted_this_session_compared_to_previous_session`, `next_session_is_scheduled_for`, `provider_id`, `provider_signature`, `provider_credential`, `supervisor_signature`, `supervisor_id`, `supervisor_name`, `billed`, `pay`, `status`, `location_id`, `cpt_code`, `pa_service_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'PAT001', 1, '12', '2024-11-11 07:15:52', '09:00:00', '11:00:00', NULL, NULL, 2, 'None noted', '{\"tantrums\":3,\"aggression\":1}', '{\"verbal_requests\":5,\"waiting_quietly\":4}', '{\"positive_reinforcement\":true,\"prompting\":true,\"redirection\":true}', 'Home', 'Alert and engaged', 'Active participation in activities', 'Positive reinforcement techniques', 'Client showed good progress with verbal requests', 'Improvement in communication skills', '2024-11-18 07:15:52', 5, 'Alice RBT', 'RBT', 'Sarah BCBA', 3, 3, 0, 0, 'ok', 1, '97153', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(2, 3, 'PAT001', 1, '12', '2024-11-13 07:15:52', '14:00:00', '16:00:00', NULL, NULL, 2, 'Minimal distractions', '{\"tantrums\":2,\"aggression\":0}', '{\"verbal_requests\":6,\"waiting_quietly\":5}', '{\"positive_reinforcement\":true,\"prompting\":true,\"modeling\":true}', 'Home', 'Calm and cooperative', 'Following instructions consistently', 'Behavior management strategies', 'Decreased maladaptive behaviors', 'Continuing improvement in behavior control', '2024-11-20 07:15:52', 5, 'Alice RBT', 'RBT', 'Sarah BCBA', 3, 3, 0, 0, 'ok', 1, '97153', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(3, 4, 'PAT002', 2, '12', '2024-11-12 07:15:52', '10:00:00', '12:00:00', NULL, NULL, 2, 'Structured environment', '{\"self_stimming\":4,\"avoidance\":2}', '{\"task_completion\":5,\"social_interaction\":3}', '{\"positive_reinforcement\":true,\"token_economy\":true,\"visual_schedules\":true}', 'Home', 'Energetic but focused', 'Completed multiple learning activities', 'Token economy system', 'Responded well to token system', 'Improved task completion', '2024-11-19 07:15:52', 6, 'Bob RBT', 'RBT', 'Mike BCBA', 4, 4, 0, 0, 'ok', 2, '97153', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(4, 4, 'PAT002', 2, '12', '2024-11-14 07:15:52', '13:00:00', '15:00:00', NULL, NULL, 2, 'Quiet study area', '{\"self_stimming\":3,\"avoidance\":1}', '{\"task_completion\":6,\"social_interaction\":4}', '{\"positive_reinforcement\":true,\"token_economy\":true,\"social_stories\":true}', 'Home', 'Well-regulated', 'Maintained attention throughout session', 'Social story implementation', 'Good engagement with social stories', 'Increased social interaction', '2024-11-21 07:15:52', 6, 'Bob RBT', 'RBT', 'Mike BCBA', 4, 4, 0, 0, 'ok', 2, '97153', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `language` varchar(150) DEFAULT NULL,
  `parent_guardian_name` varchar(150) DEFAULT NULL,
  `relationship` varchar(150) DEFAULT NULL,
  `home_phone` varchar(150) DEFAULT NULL,
  `work_phone` varchar(150) DEFAULT NULL,
  `school_name` varchar(150) DEFAULT NULL,
  `school_number` varchar(150) DEFAULT NULL,
  `zip` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT 1,
  `birth_date` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `education` varchar(150) DEFAULT NULL,
  `profession` varchar(150) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `summer_schedule` varchar(255) DEFAULT NULL,
  `special_note` text DEFAULT NULL,
  `insurer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `insuranceId` varchar(50) DEFAULT NULL,
  `eqhlid` varchar(255) DEFAULT NULL,
  `elegibility_date` timestamp NULL DEFAULT NULL,
  `pos_covered` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pos_covered`)),
  `deductible_individual_I_F` varchar(150) DEFAULT NULL,
  `balance` varchar(150) DEFAULT NULL,
  `coinsurance` varchar(150) DEFAULT NULL,
  `copayments` varchar(150) DEFAULT NULL,
  `oop` varchar(150) DEFAULT NULL,
  `diagnosis_code` varchar(255) DEFAULT NULL,
  `status` enum('incoming','active','inactive','onHold','onDischarge','waitintOnPa','waitintOnPaIa','waitintOnIa','waitintOnServices','waitintOnStaff','waitintOnSchool') NOT NULL DEFAULT 'inactive',
  `patient_control` varchar(255) DEFAULT NULL,
  `pa_assessments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pa_assessments`)),
  `compayment_per_visit` varchar(255) DEFAULT NULL,
  `insurer_secundary` varchar(50) DEFAULT NULL,
  `welcome` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `consent` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `insurance_card` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `mnl` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `referral` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `ados` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `iep` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `asd_diagnosis` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `cde` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `submitted` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'waiting',
  `eligibility` enum('pending','waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') NOT NULL DEFAULT 'pending',
  `interview` enum('pending','send','receive','no apply') NOT NULL DEFAULT 'pending',
  `rbt_home_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rbt2_school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bcba_home_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bcba2_school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `clin_director_id` bigint(20) UNSIGNED DEFAULT NULL,
  `telehealth` varchar(50) NOT NULL DEFAULT 'false',
  `pay` varchar(50) NOT NULL DEFAULT 'false',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patients`
--

INSERT INTO `patients` (`id`, `location_id`, `patient_id`, `first_name`, `last_name`, `email`, `phone`, `language`, `parent_guardian_name`, `relationship`, `home_phone`, `work_phone`, `school_name`, `school_number`, `zip`, `state`, `address`, `gender`, `birth_date`, `avatar`, `city`, `education`, `profession`, `schedule`, `summer_schedule`, `special_note`, `insurer_id`, `insuranceId`, `eqhlid`, `elegibility_date`, `pos_covered`, `deductible_individual_I_F`, `balance`, `coinsurance`, `copayments`, `oop`, `diagnosis_code`, `status`, `patient_control`, `pa_assessments`, `compayment_per_visit`, `insurer_secundary`, `welcome`, `consent`, `insurance_card`, `mnl`, `referral`, `ados`, `iep`, `asd_diagnosis`, `cde`, `submitted`, `eligibility`, `interview`, `rbt_home_id`, `rbt2_school_id`, `bcba_home_id`, `bcba2_school_id`, `clin_director_id`, `telehealth`, `pay`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'PAT001', 'John', 'Doe', 'john@example.com', '123-555-0123', 'English', 'Jane Doe', 'Mother', NULL, NULL, NULL, NULL, '33101', 'FL', '789 Patient St', 1, '2015-01-01 07:00:00', NULL, 'Miami', '2nd Grade', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '[\"03\",\"12\"]', NULL, NULL, NULL, NULL, NULL, 'F84.0', 'active', NULL, NULL, NULL, NULL, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'receive', 5, NULL, 3, NULL, NULL, 'false', 'false', '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(2, 2, 'PAT002', 'Jane', 'Smith', 'jane@example.com', '123-555-0124', 'Spanish', 'John Smith', 'Father', NULL, NULL, NULL, NULL, '32801', 'FL', '987 Patient Ave', 2, '2016-02-02 07:00:00', NULL, 'Orlando', '3rd Grade', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, '\"[\\\"03\\\", \\\"12\\\"]\"', NULL, NULL, NULL, NULL, NULL, 'F84.0', 'active', NULL, NULL, NULL, NULL, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'pending', 6, NULL, 4, NULL, NULL, 'false', 'false', '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patient_files`
--

CREATE TABLE `patient_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `name_file` varchar(250) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `resolution` varchar(20) DEFAULT NULL,
  `file` varchar(250) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pa_services`
--

CREATE TABLE `pa_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `pa_services` varchar(255) NOT NULL,
  `cpt` varchar(255) NOT NULL,
  `n_units` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pa_services`
--

INSERT INTO `pa_services` (`id`, `patient_id`, `pa_services`, `cpt`, `n_units`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'service 1', '97151', 1, '2024-01-01', '2024-01-01', '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(2, 2, 'service 2', '97153', 1, '2024-01-01', '2024-01-01', '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'register_rol', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(2, 'list_rol', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(3, 'edit_rol', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(4, 'delete_rol', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(9, 'profile_doctor', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(10, 'register_patient', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(11, 'list_patient', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(12, 'edit_patient', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(13, 'delete_patient', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(14, 'profile_patient', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(19, 'register_appointment', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(20, 'list_appointment', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(21, 'edit_appointment', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(22, 'delete_appointment', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(27, 'show_payment', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(28, 'edit_payment', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(29, 'activitie', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(30, 'calendar', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(31, 'expense_report', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(32, 'invoice_report', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(33, 'settings', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(34, 'list_insurance', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(35, 'register_insurance', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(36, 'list_bip', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(37, 'register_bip', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(38, 'edit_bip', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(39, 'attention_bip', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(40, 'admin_dashboard', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(41, 'doctor_dashboard', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(42, 'client_dashboard', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(43, 'list_employers', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(44, 'register_employer', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(45, 'edit_employer', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(46, 'delete_employer', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(47, 'list_location', 'api', '2024-11-16 11:15:51', '2024-11-16 11:15:51'),
(48, 'register_location', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(49, 'edit_location', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(50, 'edit_notebcba', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(51, 'list_notebcba', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(52, 'register_notebcba', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(53, 'view_bip', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(54, 'edit_noterbt', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(55, 'list_noterbt', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(56, 'register_noterbt', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(57, 'view_notebcba', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(58, 'view_noterbt', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(59, 'delete_noterbt', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(60, 'delete_notebcba', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(61, 'list_billing', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(62, 'list_patient_log_report', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reduction_goals`
--

CREATE TABLE `reduction_goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bip_id` bigint(20) UNSIGNED NOT NULL,
  `maladaptive` varchar(255) DEFAULT NULL,
  `current_status` varchar(155) DEFAULT NULL,
  `patient_id` varchar(150) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `goalstos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`goalstos`)),
  `goalltos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`goalltos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SUPERADMIN', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(2, 'MANAGER', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(7, 'BCBA', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52'),
(8, 'RBT', 'api', '2024-11-16 11:15:52', '2024-11-16 11:15:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sustitution_goals`
--

CREATE TABLE `sustitution_goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `current_status` varchar(155) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `patient_id` varchar(150) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED NOT NULL,
  `goalstos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'JSON array of STO goals' CHECK (json_valid(`goalstos`)),
  `goalltos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'JSON array of LTO goals' CHECK (json_valid(`goalltos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `surname` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `birth_date` timestamp NULL DEFAULT current_timestamp(),
  `gender` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('inactive','active','black list','incoming') NOT NULL DEFAULT 'inactive',
  `currently_pay_through_company` varchar(150) DEFAULT NULL,
  `llc` varchar(150) DEFAULT NULL,
  `ien` varchar(150) DEFAULT NULL,
  `wc` varchar(150) DEFAULT NULL,
  `electronic_signature` varchar(150) DEFAULT NULL,
  `agency_location` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `languages` varchar(50) DEFAULT NULL,
  `ss_number` varchar(150) DEFAULT NULL,
  `date_of_hire` timestamp NULL DEFAULT current_timestamp(),
  `start_pay` timestamp NULL DEFAULT current_timestamp(),
  `driver_license_expiration` timestamp NULL DEFAULT current_timestamp(),
  `cpr_every_2_years` varchar(255) DEFAULT NULL,
  `background_every_5_years` varchar(255) DEFAULT NULL,
  `e_verify` varchar(255) DEFAULT NULL,
  `national_sex_offender_registry` varchar(255) DEFAULT NULL,
  `certificate_number` varchar(255) DEFAULT NULL,
  `bacb_license_expiration` varchar(255) DEFAULT NULL,
  `liability_insurance_annually` varchar(255) DEFAULT NULL,
  `local_police_rec_every_5_years` varchar(255) DEFAULT NULL,
  `npi` varchar(255) DEFAULT NULL,
  `medicaid_provider` varchar(255) DEFAULT NULL,
  `ceu_hippa_annually` varchar(255) DEFAULT NULL,
  `ceu_domestic_violence_no_expiration` varchar(255) DEFAULT NULL,
  `ceu_security_awareness_annually` varchar(255) DEFAULT NULL,
  `ceu_zero_tolerance_every_3_years` varchar(255) DEFAULT NULL,
  `ceu_hiv_bloodborne_pathogens_infection_control_no_expiration` varchar(255) DEFAULT NULL,
  `ceu_civil_rights_no_expiration` varchar(255) DEFAULT NULL,
  `school_badge` varchar(255) DEFAULT NULL,
  `w_9_w_4_form` varchar(255) DEFAULT NULL,
  `contract` varchar(255) DEFAULT NULL,
  `two_four_week_notice_agreement` varchar(255) DEFAULT NULL,
  `credentialing_package_bcbas_only` varchar(255) DEFAULT NULL,
  `caqh_bcbas_only` varchar(255) DEFAULT NULL,
  `contract_type` varchar(155) DEFAULT NULL,
  `salary` double DEFAULT NULL,
  `location_id` varchar(50) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `surname`, `phone`, `birth_date`, `gender`, `address`, `avatar`, `status`, `currently_pay_through_company`, `llc`, `ien`, `wc`, `electronic_signature`, `agency_location`, `city`, `languages`, `ss_number`, `date_of_hire`, `start_pay`, `driver_license_expiration`, `cpr_every_2_years`, `background_every_5_years`, `e_verify`, `national_sex_offender_registry`, `certificate_number`, `bacb_license_expiration`, `liability_insurance_annually`, `local_police_rec_every_5_years`, `npi`, `medicaid_provider`, `ceu_hippa_annually`, `ceu_domestic_violence_no_expiration`, `ceu_security_awareness_annually`, `ceu_zero_tolerance_every_3_years`, `ceu_hiv_bloodborne_pathogens_infection_control_no_expiration`, `ceu_civil_rights_no_expiration`, `school_badge`, `w_9_w_4_form`, `contract`, `two_four_week_notice_agreement`, `credentialing_package_bcbas_only`, `caqh_bcbas_only`, `contract_type`, `salary`, `location_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'superadmin@example.com', NULL, NULL, '2024-11-16 04:15:52', 1, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-16 04:15:52', '2024-11-16 04:15:52', '2024-11-16 04:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-16 11:15:52', '$2y$10$vyzOJbk7VGtEl00Kt27GEOVIkLAWMSQd/hLtLS77JT/ISzw3cWfES', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(2, 'John Manager', 'manager@example.com', 'Doe', NULL, '2024-11-16 04:15:52', 1, NULL, NULL, 'active', NULL, NULL, NULL, NULL, 'signatures/example.png', NULL, NULL, NULL, NULL, '2024-11-16 04:15:52', '2024-11-16 04:15:52', '2024-11-16 04:15:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-16 07:15:52', '$2y$10$DO35DAkjCaCCFRIae.d2lObvd6C89DeYkjyECtMBOWYreZn0k3/L2', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(3, 'Sarah BCBA', 'bcba1@example.com', 'Howard', '1234567890', '2024-11-16 04:15:52', 2, NULL, NULL, 'active', NULL, NULL, NULL, NULL, 'signatures/example.png', NULL, NULL, NULL, NULL, '2024-11-16 04:15:52', '2024-11-16 04:15:52', '2024-11-16 04:15:52', NULL, NULL, NULL, NULL, 'BCBA12345', NULL, NULL, NULL, '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$xb3Z0btrRxXKKmJgIvD8pOMjkT6H2hFJNkemivOLA8WQeG5fWLbam', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(4, 'Mike BCBA', 'bcba2@example.com', 'Smith', '1234567891', '2024-11-16 04:15:52', 1, NULL, NULL, 'active', NULL, NULL, NULL, NULL, 'signatures/example.png', NULL, NULL, NULL, NULL, '2024-11-16 04:15:52', '2024-11-16 04:15:52', '2024-11-16 04:15:52', NULL, NULL, NULL, NULL, 'BCBA12346', NULL, NULL, NULL, '1234567891', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$.MLQ3WfCnLPGC3ahINlBWuBx1V7sXR6HoCvH305qMOXVDBUyE5Sr.', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(5, 'Alice RBT', 'rbt1@example.com', 'Brown', '1234567892', '2024-11-16 04:15:52', 2, NULL, NULL, 'active', NULL, NULL, NULL, NULL, 'signatures/example.png', NULL, NULL, NULL, NULL, '2024-11-16 04:15:52', '2024-11-16 04:15:52', '2024-11-16 04:15:52', NULL, NULL, NULL, NULL, 'RBT12345', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$fb1rZIIHeMELJgfO4y1PWOmqeZNEl1NO5JkI.lOe1NQfdiUeqM3FS', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL),
(6, 'Bob RBT', 'rbt2@example.com', 'Johnson', '1234567893', '2024-11-16 04:15:52', 1, NULL, NULL, 'active', NULL, NULL, NULL, NULL, 'signatures/example.png', NULL, NULL, NULL, NULL, '2024-11-16 04:15:52', '2024-11-16 04:15:52', '2024-11-16 04:15:52', NULL, NULL, NULL, NULL, 'RBT12346', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$bLaYQaZx3qAP46IJQcd5s.XuyMQBxavBJ.CxbiWizWs6lL0GsO4NS', NULL, '2024-11-16 07:15:52', '2024-11-16 07:15:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_locations`
--

CREATE TABLE `user_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_locations`
--

INSERT INTO `user_locations` (`id`, `user_id`, `location_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 6, 1, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billings_sponsor_id_foreign` (`sponsor_id`),
  ADD KEY `billings_insurer_id_foreign` (`insurer_id`);

--
-- Indices de la tabla `bips`
--
ALTER TABLE `bips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bips_client_id_foreign` (`client_id`),
  ADD KEY `bips_doctor_id_foreign` (`doctor_id`);

--
-- Indices de la tabla `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `client_reports`
--
ALTER TABLE `client_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_reports_note_rbt_id_foreign` (`note_rbt_id`),
  ADD KEY `client_reports_note_bcba_id_foreign` (`note_bcba_id`),
  ADD KEY `client_reports_sponsor_id_foreign` (`sponsor_id`),
  ADD KEY `client_reports_insurer_id_foreign` (`insurer_id`);

--
-- Indices de la tabla `consent_to_treatments`
--
ALTER TABLE `consent_to_treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consent_to_treatments_bip_id_foreign` (`bip_id`),
  ADD KEY `consent_to_treatments_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `crisis_plans`
--
ALTER TABLE `crisis_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crisis_plans_bip_id_foreign` (`bip_id`),
  ADD KEY `crisis_plans_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `de_escalation_techniques`
--
ALTER TABLE `de_escalation_techniques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `de_escalation_techniques_bip_id_foreign` (`bip_id`),
  ADD KEY `de_escalation_techniques_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `family_envolments`
--
ALTER TABLE `family_envolments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `family_envolments_bip_id_foreign` (`bip_id`),
  ADD KEY `family_envolments_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `generalization_trainings`
--
ALTER TABLE `generalization_trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generalization_trainings_bip_id_foreign` (`bip_id`),
  ADD KEY `generalization_trainings_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `monitoring_evaluatings`
--
ALTER TABLE `monitoring_evaluatings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monitoring_evaluatings_bip_id_foreign` (`bip_id`),
  ADD KEY `monitoring_evaluatings_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `note_bcbas`
--
ALTER TABLE `note_bcbas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note_bcbas_doctor_id_foreign` (`doctor_id`),
  ADD KEY `note_bcbas_bip_id_foreign` (`bip_id`),
  ADD KEY `note_bcbas_provider_name_foreign` (`provider_name`),
  ADD KEY `note_bcbas_supervisor_name_foreign` (`supervisor_name`),
  ADD KEY `note_bcbas_pa_service_id_foreign` (`pa_service_id`),
  ADD KEY `note_bcbas_rendering_provider_foreign` (`rendering_provider`),
  ADD KEY `note_bcbas_supervisor_id_foreign` (`supervisor_id`);

--
-- Indices de la tabla `note_rbts`
--
ALTER TABLE `note_rbts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note_rbts_doctor_id_foreign` (`doctor_id`),
  ADD KEY `note_rbts_bip_id_foreign` (`bip_id`),
  ADD KEY `note_rbts_provider_id_foreign` (`provider_id`),
  ADD KEY `note_rbts_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `note_rbts_supervisor_name_foreign` (`supervisor_name`),
  ADD KEY `note_rbts_pa_service_id_foreign` (`pa_service_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_insurer_id_foreign` (`insurer_id`),
  ADD KEY `patients_rbt_home_id_foreign` (`rbt_home_id`),
  ADD KEY `patients_rbt2_school_id_foreign` (`rbt2_school_id`),
  ADD KEY `patients_bcba_home_id_foreign` (`bcba_home_id`),
  ADD KEY `patients_bcba2_school_id_foreign` (`bcba2_school_id`),
  ADD KEY `patients_clin_director_id_foreign` (`clin_director_id`),
  ADD KEY `patients_location_id_foreign` (`location_id`);

--
-- Indices de la tabla `patient_files`
--
ALTER TABLE `patient_files`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pa_services`
--
ALTER TABLE `pa_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pa_services_patient_id_foreign` (`patient_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `reduction_goals`
--
ALTER TABLE `reduction_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reduction_goals_bip_id_foreign` (`bip_id`),
  ADD KEY `reduction_goals_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sustitution_goals`
--
ALTER TABLE `sustitution_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sustitution_goals_client_id_foreign` (`client_id`),
  ADD KEY `sustitution_goals_bip_id_foreign` (`bip_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_locations_user_id_location_id_unique` (`user_id`,`location_id`),
  ADD KEY `user_locations_location_id_foreign` (`location_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `billings`
--
ALTER TABLE `billings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bips`
--
ALTER TABLE `bips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `claims`
--
ALTER TABLE `claims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `client_reports`
--
ALTER TABLE `client_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consent_to_treatments`
--
ALTER TABLE `consent_to_treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `crisis_plans`
--
ALTER TABLE `crisis_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `de_escalation_techniques`
--
ALTER TABLE `de_escalation_techniques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `family_envolments`
--
ALTER TABLE `family_envolments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `generalization_trainings`
--
ALTER TABLE `generalization_trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `monitoring_evaluatings`
--
ALTER TABLE `monitoring_evaluatings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `note_bcbas`
--
ALTER TABLE `note_bcbas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `note_rbts`
--
ALTER TABLE `note_rbts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `patient_files`
--
ALTER TABLE `patient_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pa_services`
--
ALTER TABLE `pa_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reduction_goals`
--
ALTER TABLE `reduction_goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `sustitution_goals`
--
ALTER TABLE `sustitution_goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `billings`
--
ALTER TABLE `billings`
  ADD CONSTRAINT `billings_insurer_id_foreign` FOREIGN KEY (`insurer_id`) REFERENCES `insurances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `billings_sponsor_id_foreign` FOREIGN KEY (`sponsor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `bips`
--
ALTER TABLE `bips`
  ADD CONSTRAINT `bips_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bips_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `client_reports`
--
ALTER TABLE `client_reports`
  ADD CONSTRAINT `client_reports_insurer_id_foreign` FOREIGN KEY (`insurer_id`) REFERENCES `insurances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `client_reports_note_bcba_id_foreign` FOREIGN KEY (`note_bcba_id`) REFERENCES `note_bcbas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `client_reports_note_rbt_id_foreign` FOREIGN KEY (`note_rbt_id`) REFERENCES `note_rbts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `client_reports_sponsor_id_foreign` FOREIGN KEY (`sponsor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `consent_to_treatments`
--
ALTER TABLE `consent_to_treatments`
  ADD CONSTRAINT `consent_to_treatments_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `consent_to_treatments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `crisis_plans`
--
ALTER TABLE `crisis_plans`
  ADD CONSTRAINT `crisis_plans_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `crisis_plans_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `de_escalation_techniques`
--
ALTER TABLE `de_escalation_techniques`
  ADD CONSTRAINT `de_escalation_techniques_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `de_escalation_techniques_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `family_envolments`
--
ALTER TABLE `family_envolments`
  ADD CONSTRAINT `family_envolments_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `family_envolments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `generalization_trainings`
--
ALTER TABLE `generalization_trainings`
  ADD CONSTRAINT `generalization_trainings_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `generalization_trainings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `monitoring_evaluatings`
--
ALTER TABLE `monitoring_evaluatings`
  ADD CONSTRAINT `monitoring_evaluatings_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `monitoring_evaluatings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `note_bcbas`
--
ALTER TABLE `note_bcbas`
  ADD CONSTRAINT `note_bcbas_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_bcbas_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_bcbas_pa_service_id_foreign` FOREIGN KEY (`pa_service_id`) REFERENCES `pa_services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_bcbas_provider_name_foreign` FOREIGN KEY (`provider_name`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_bcbas_rendering_provider_foreign` FOREIGN KEY (`rendering_provider`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_bcbas_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_bcbas_supervisor_name_foreign` FOREIGN KEY (`supervisor_name`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `note_rbts`
--
ALTER TABLE `note_rbts`
  ADD CONSTRAINT `note_rbts_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_rbts_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_rbts_pa_service_id_foreign` FOREIGN KEY (`pa_service_id`) REFERENCES `pa_services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_rbts_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_rbts_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `note_rbts_supervisor_name_foreign` FOREIGN KEY (`supervisor_name`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_bcba2_school_id_foreign` FOREIGN KEY (`bcba2_school_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patients_bcba_home_id_foreign` FOREIGN KEY (`bcba_home_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patients_clin_director_id_foreign` FOREIGN KEY (`clin_director_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patients_insurer_id_foreign` FOREIGN KEY (`insurer_id`) REFERENCES `insurances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patients_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patients_rbt2_school_id_foreign` FOREIGN KEY (`rbt2_school_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patients_rbt_home_id_foreign` FOREIGN KEY (`rbt_home_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `pa_services`
--
ALTER TABLE `pa_services`
  ADD CONSTRAINT `pa_services_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reduction_goals`
--
ALTER TABLE `reduction_goals`
  ADD CONSTRAINT `reduction_goals_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reduction_goals_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sustitution_goals`
--
ALTER TABLE `sustitution_goals`
  ADD CONSTRAINT `sustitution_goals_bip_id_foreign` FOREIGN KEY (`bip_id`) REFERENCES `bips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sustitution_goals_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `user_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
