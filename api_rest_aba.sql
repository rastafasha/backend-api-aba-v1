-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
<<<<<<< HEAD
-- Tiempo de generación: 15-07-2024 a las 18:42:12
=======
-- Tiempo de generación: 11-05-2024 a las 18:02:11
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
-- Versión del servidor: 5.7.34
-- Versión de PHP: 8.0.8

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
  `sponsor_id` bigint(20) DEFAULT NULL,
  `cpt_code` varchar(155) DEFAULT NULL,
  `insurer_id` bigint(20) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `billings`
--

INSERT INTO `billings` (`id`, `patient_id`, `sponsor_id`, `cpt_code`, `insurer_id`, `insurer_rate`, `date`, `total_hours`, `total_units`, `billing_total`, `week_total_hours`, `week_total_units`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 'test1', 1, NULL, NULL, NULL, '2024-07-12 16:00:00', '20:00:00', NULL, NULL, NULL, NULL, '2024-07-12 23:05:00', '2024-07-12 23:05:00', NULL),
(2, 'test1', 1, NULL, NULL, NULL, '2024-07-13 16:00:00', '17:00:00', NULL, NULL, NULL, NULL, '2024-07-12 23:06:30', '2024-07-12 23:06:30', NULL),
(3, 'test1', 1, NULL, NULL, NULL, '2024-07-13 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-13 23:41:26', '2024-07-13 23:41:26', NULL),
(4, '985590391', 1, NULL, NULL, NULL, '2024-07-16 16:00:00', '18:00:00', NULL, NULL, NULL, NULL, '2024-07-15 18:56:41', '2024-07-15 18:56:41', NULL),
(5, '985590391', 27, NULL, NULL, NULL, '2024-07-15 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-15 20:26:33', '2024-07-15 20:26:33', NULL),
(6, '985590391', 27, NULL, NULL, NULL, '2024-07-16 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-15 20:28:21', '2024-07-15 20:28:21', NULL);
=======
(1, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-17 16:00:00', '06:00:00', NULL, NULL, NULL, NULL, '2024-04-17 21:52:57', '2024-04-17 21:52:57', NULL),
(2, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-18 16:00:00', '03:15:00', NULL, NULL, NULL, NULL, '2024-04-17 21:55:03', '2024-04-17 21:55:03', NULL),
(3, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-19 16:00:00', '02:15:00', NULL, NULL, NULL, NULL, '2024-04-17 21:58:16', '2024-04-17 21:58:16', NULL),
(4, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-20 16:00:00', '06:00:00', NULL, NULL, NULL, NULL, '2024-04-17 22:03:49', '2024-04-17 22:03:49', NULL),
(5, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-21 16:00:00', '02:15:00', NULL, NULL, NULL, NULL, '2024-04-17 22:09:48', '2024-04-17 22:09:48', NULL),
(6, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-22 16:00:00', '05:30:00', NULL, NULL, NULL, NULL, '2024-04-17 22:16:26', '2024-04-17 22:16:26', NULL),
(7, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-24 16:00:00', '05:00:00', NULL, NULL, NULL, NULL, '2024-04-17 22:21:30', '2024-04-17 22:21:30', NULL),
(8, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-24 16:00:00', '03:15:00', NULL, NULL, NULL, NULL, '2024-04-17 22:30:57', '2024-04-17 22:30:57', NULL),
(9, 'cliente3243', 6, NULL, NULL, NULL, '2024-04-25 16:00:00', '02:15:00', NULL, NULL, NULL, NULL, '2024-04-17 22:52:14', '2024-04-17 22:52:14', NULL),
(10, 'cliente3243', 6, NULL, NULL, NULL, '2024-04-26 16:00:00', '04:45:00', NULL, NULL, NULL, NULL, '2024-04-17 22:55:40', '2024-04-17 22:55:40', NULL),
(11, 'cliente3243', 1, NULL, NULL, NULL, '2024-04-27 16:00:00', '01:30:00', NULL, NULL, NULL, NULL, '2024-04-19 02:42:21', '2024-04-19 02:42:21', NULL),
(12, 'cliente3243', 5, NULL, NULL, NULL, '2024-04-28 16:00:00', '04:00:00', NULL, NULL, NULL, NULL, '2024-04-19 17:23:33', '2024-04-19 17:23:33', NULL),
(13, 'cliente3243', 1, NULL, NULL, NULL, '2024-04-29 16:00:00', '02:45:00', NULL, NULL, NULL, NULL, '2024-04-19 17:27:26', '2024-04-19 17:27:26', NULL),
(14, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-09 16:00:00', '02:45:00', NULL, NULL, NULL, NULL, '2024-04-19 19:20:59', '2024-04-19 19:20:59', NULL),
(15, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-22 16:00:00', '00:15:00', NULL, NULL, NULL, NULL, '2024-04-19 19:37:14', '2024-04-19 19:37:14', NULL),
(16, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-23 16:00:00', '00:45:00', NULL, NULL, NULL, NULL, '2024-04-19 20:19:28', '2024-04-19 20:19:28', NULL),
(17, 'cliente3243', 6, NULL, NULL, NULL, '2024-04-30 16:00:00', '01:45:00', NULL, NULL, NULL, NULL, '2024-04-20 01:56:07', '2024-04-20 01:56:07', NULL),
(18, 'cliente3243', 6, NULL, NULL, NULL, '2024-05-03 16:00:00', '02:15:00', NULL, NULL, NULL, NULL, '2024-05-03 22:21:41', '2024-05-03 22:21:41', NULL),
(19, 'cliente3', 1, NULL, NULL, NULL, '2024-05-08 16:00:00', '06:00:00', NULL, NULL, NULL, NULL, '2024-05-08 21:44:10', '2024-05-08 21:44:10', NULL),
(20, 'cliente3', 1, NULL, NULL, NULL, '2024-05-10 16:00:00', '02:00:00', NULL, NULL, NULL, NULL, '2024-05-08 22:25:15', '2024-05-08 22:25:15', NULL),
(21, 'cliente3', 1, NULL, NULL, NULL, '2024-05-09 16:00:00', '02:00:00', NULL, NULL, NULL, NULL, '2024-05-08 22:32:09', '2024-05-08 22:32:09', NULL),
(22, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-10 16:00:00', '02:30:00', NULL, NULL, NULL, NULL, '2024-05-11 07:45:21', '2024-05-11 07:45:21', NULL),
(23, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-10 16:00:00', '02:30:00', NULL, NULL, NULL, NULL, '2024-05-11 07:56:09', '2024-05-11 07:56:09', NULL),
(24, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-11 16:00:00', '01:00:00', NULL, NULL, NULL, NULL, '2024-05-11 08:08:56', '2024-05-11 08:08:56', NULL),
(25, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-11 16:00:00', '01:00:00', NULL, NULL, NULL, NULL, '2024-05-11 19:34:52', '2024-05-11 19:34:52', NULL),
(26, 'cliente3243', 1, NULL, NULL, NULL, '2024-05-13 16:00:00', '00:15:00', NULL, NULL, NULL, NULL, '2024-05-11 19:38:00', '2024-05-11 19:38:00', NULL),
(27, 'cliente3', 1, NULL, NULL, NULL, '2024-05-12 16:00:00', '01:00:00', NULL, NULL, NULL, NULL, '2024-05-11 20:47:24', '2024-05-11 20:47:24', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bips`
--

CREATE TABLE `bips` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_of_assessment` tinyint(1) DEFAULT '3' COMMENT '1:Assessment,2:Reassessment, 3:Initial',
  `documents_reviewed` json DEFAULT NULL,
  `background_information` text,
  `previus_treatment_and_result` text,
  `current_treatment_and_progress` text,
  `education_status` text,
  `phisical_and_medical_status` text,
<<<<<<< HEAD
  `strengths` text,
  `weakneses` text,
  `phiysical_and_medical` text,
  `phiysical_and_medical_status` json DEFAULT NULL,
  `maladaptives` json DEFAULT NULL,
  `assestment_conducted` text,
  `assestment_conducted_options` json DEFAULT NULL,
  `assestmentEvaluationSettings` json DEFAULT NULL,
  `prevalent_setting_event_and_atecedents` json DEFAULT NULL,
  `access_to_tangibles` json DEFAULT NULL,
  `hypothesis_based_intervention` text,
=======
  `maladaptives` json DEFAULT NULL,
  `assestment_conducted` text,
  `assestment_conducted_options` json DEFAULT NULL,
  `prevalent_setting_event_and_atecedents` json DEFAULT NULL,
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
  `interventions` json DEFAULT NULL,
  `reduction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bips`
--

<<<<<<< HEAD
INSERT INTO `bips` (`id`, `client_id`, `patient_id`, `doctor_id`, `type_of_assessment`, `documents_reviewed`, `background_information`, `previus_treatment_and_result`, `current_treatment_and_progress`, `education_status`, `phisical_and_medical_status`, `strengths`, `weakneses`, `phiysical_and_medical`, `phiysical_and_medical_status`, `maladaptives`, `assestment_conducted`, `assestment_conducted_options`, `assestmentEvaluationSettings`, `prevalent_setting_event_and_atecedents`, `access_to_tangibles`, `hypothesis_based_intervention`, `interventions`, `reduction_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, 1, '[{\"document_title\": \"test\", \"document_status\": \"yes\"}]', 'test', 'test', 'test', 'test', 'test', 'actualizado', 'actualizadoss', 'sadasd', '[{\"dose\": \"das das\", \"reason\": \"dsadasd \\ndasdsa\", \"frecuency\": \"dasdasdas\", \"medication\": \"sadsa\", \"preescribing_physician\": \"dsadas\"}]', '[{\"baseline_date\": \"2024-07-12T04:00:00.000Z\", \"baseline_level\": \"24\", \"initial_interesting\": 12, \"maladaptive_behavior\": \"test\", \"topografical_definition\": \"testdsd teslts asd\"}]', 'test', '[{\"assestment_title\": \"test\", \"assestment_status\": \"pending\"}]', '[{\"other\": \"das\", \"tangible\": \"ads\", \"activities\": \"das\"}, {\"other\": \"dsadasdas\", \"tangible\": \"dsaasd\", \"activities\": \"dasdasdas\"}]', '[{\"behavior\": \"test\", \"hypothesized_functions\": \"test\", \"prevalent_setting_event_and_atecedent\": \"test\"}]', '[{\"manager_strategies\": \"dsa\", \"replacement_skills\": \"dsadas\", \"preventive_strategies\": \"adsdsa\"}]', 'ads', 'null', NULL, '2024-07-12 22:53:21', '2024-07-15 03:48:29', NULL),
(2, 5, '985590391', 1, 2, '[{\"document_title\": \"MNL\", \"document_status\": \"yes\"}, {\"document_title\": \"Inital Assessment\", \"document_status\": \"yes\"}, {\"document_title\": \"Vineland-3\", \"document_status\": \"yes\"}, {\"document_title\": \"IEP\", \"document_status\": \"yes\"}, {\"document_title\": \"Doctor Referral\", \"document_status\": \"yes\"}, {\"document_title\": \"Doctors Notes\", \"document_status\": \"yes\"}, {\"document_title\": \"PSYCHOLOGICAL EVALUATION\", \"document_status\": \"yes\"}, {\"document_title\": \"Comprehensive Development Assessment (CDE)\", \"document_status\": \"yes\"}, {\"document_title\": \"Autism Diagnostice Observation Schedule (ADOS)\", \"document_status\": \"yes\"}]', '-Elnathan is a 6-year old male who has a diagnosis of Autism Spectrum disorder. He lives with his mother, father and 4-year-old brother. He was born in Ethiopia and came to the USA in 2019. In the home the primary language is Amharic, however Elnathan’s’ father speaks English and states that Elnathan understands both languages. He was referred for ABA therapy by Dr. Heather Pittman in 6/19/2023 due to challenging behaviors that interfere with his daily functioning, learning from others and prevent full integration in school/community/family life. An ADOS test was conducted on April 2023 at Golisano Children’s Hospital, results show moderate to severe signs of autism spectrum related symptoms. Elnathan has never received ABA therapy before. \n-Elnathan is able to communicate mostly using one-word mands and gestures, however, needs to increase his verbal repertoire as he will often engage in maladaptive behaviors when he is unable to communicate his needs. Elnathan’s father reports that when they moved from Africa to the US in 2019, Elnathan did not have any speech impediments, however noticed regressions in speech and language after the move and during the pandemic. Elnathan was born full term with no complications and met all his millstones according to his father. His father’s biggest concerns are his deficits in communicating his wants and needs and decreasing maladaptive behaviors of physical aggression, elopement and noncompliance that will impede his daily functioning in society.  Elnathan’s father would like to have services rendered in school due to the increased frequency of maladaptive behaviors reported at school compared to the home, not much at home.  \n-Furthermore, Elnathan exhibits deficits with his tolerance skills, as his father mentions he has limited interest, and will often more from one activity to the next whether it is preferred or not. Additionally, he shares that Elnathan has restrictive behaviors in the form of having rigid routines the whole family has to follow, such as only being able to ride his mother or fathers car, or if the father is off of work still has to continue his work routine of leaving the home at the same time, otherwise Elnathan escalates to more severe maladaptive and that will set the mood for the whole day. \n-Teacher reported that client in the classroom has difficulty remaining on tasks, resists instructions, darts away from tasks, climbs on classroom tables, throws objects such as inflatable chairs. Teacher also reported Elnathan spits on her face, and pushes/shoves peers due to fixation with toy cars and refusal to give up items.', 'Elnathan has not previously received ABA therapy.', '- A new behavioral assessment and behavior plan was completed at this time. Age-appropriate replacement objectives have been developed.\n- Current treatment and progress update 3/2024: During this period Elnathan met the mastery on  STO 3 for climbing, for the rest of reduction behavior goals he continues working on STO 1: Physical Aggression, Spitting, Elopement,  Non-Compliance, Object Fixation and Throwing Objects. Regarding acquisition behavior goals Elnathan met the mastery on STO 1 for Follow instructions , Listener responding, Tolerate changes in routine, Give up toy within 3 seconds of Sd and Group goal; he  is also currently working on STO 2 for Manding, on STO 1 for Request a break, Intraverbal training, Tolerates “No” responses, Appropriate protesting , Appropriately requests other’s attention , Delay reinforcer and Sharing', '-He was attending First grade at Allan Park Elementary School for school year 23-24. ESE classroom with an active IEP. However, he recently changed schools to Edgewood academy in the beginning of September 2023.  \n- Update 3-2024: ST 30 min school only, recently referred to ST/OT outside of school but parents are still in the process of obtaining those.', '-Elnathan is diagnosed with Autism spectrum disorder, ADHD and sensory processing difficulty. No allergies or dietary restrictions have been reported at this time. Elnathan’s father reports he is not a picky eater and will often choose healthy foods over sugary choices, likely due to his upbringing in Africa where it was not a prominent food group. (no medications)', 'test', 'test', 'test', '[{\"dose\": \"test\", \"reason\": \"test\", \"frecuency\": \"test\", \"medication\": \"test\", \"preescribing_physician\": \"test\"}]', '[{\"baseline_date\": \"2024-07-15T04:00:00.000Z\", \"baseline_level\": \"15\", \"initial_interesting\": 5, \"maladaptive_behavior\": \"Physical aggression\", \"topografical_definition\": \"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\"}, {\"baseline_date\": \"2024-07-15T04:00:00.000Z\", \"baseline_level\": \"35\", \"initial_interesting\": 10, \"maladaptive_behavior\": \"Spitting\", \"topografical_definition\": \"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\"}, {\"baseline_date\": \"2024-07-15T04:00:00.000Z\", \"baseline_level\": \"70\", \"initial_interesting\": 23, \"maladaptive_behavior\": \"Elopement\", \"topografical_definition\": \"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\"}, {\"baseline_date\": \"2024-07-15T04:00:00.000Z\", \"baseline_level\": \"50\", \"initial_interesting\": 2, \"maladaptive_behavior\": \"Noncompliance\", \"topografical_definition\": \"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\"}, {\"baseline_date\": \"2024-07-15T04:00:00.000Z\", \"baseline_level\": \"150\", \"initial_interesting\": 4, \"maladaptive_behavior\": \"Climbing\", \"topografical_definition\": \"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\"}, {\"baseline_date\": \"2024-07-15T04:00:00.000Z\", \"baseline_level\": \"100\", \"initial_interesting\": 10, \"maladaptive_behavior\": \"Object fixation\", \"topografical_definition\": \"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\"}, {\"baseline_date\": \"2024-07-15T04:00:00.000Z\", \"baseline_level\": \"27\", \"initial_interesting\": 4, \"maladaptive_behavior\": \"Throwing objects\", \"topografical_definition\": \"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\"}]', 'A functional behavioral assessment was conducted by BCBA to obtain information regarding the probable contexts and functions of Elnathan’s behavior.', '[{\"assestment_title\": \"Functional assessment interview completed with mother, and both teachers.\", \"assestment_status\": \"yes\"}, {\"assestment_title\": \"vineland-3 teacher form\", \"assestment_status\": \"yes\"}, {\"assestment_title\": \"Observations\", \"assestment_status\": \"yes\"}, {\"assestment_title\": \"Stimulus preference assessment\", \"assestment_status\": \"yes\"}]', '[{\"other\": \"test\", \"tangible\": \"test\", \"activities\": \"test\"}]', '[{\"behavior\": \"Physical aggression\", \"hypothesized_functions\": \"Attention, escape, tangible\", \"prevalent_setting_event_and_atecedent\": \"This behavior may be displayed when any demand given is sustained or something in the environment changed and he receives new instructions to follow or when access to task/activities was denied or delayed, or when he is told \'no\'.\"}, {\"behavior\": \"Elopement\", \"hypothesized_functions\": \"Escape\", \"prevalent_setting_event_and_atecedent\": \"This behavior is displayed when any demand given is sustained or something in the environment changed and he receives new instructions to follow or when attention is withdrawn\"}, {\"behavior\": \"Noncompliance\", \"hypothesized_functions\": \"Attention, tangible, escape\", \"prevalent_setting_event_and_atecedent\": \"This behavior occurs when attention is withdrawn or a demand was placed, or when access to task/activities was denied or delayed, or when he is told \'no\'.\"}]', '[{\"manager_strategies\": \"test\", \"replacement_skills\": \"test\", \"preventive_strategies\": \"test\"}]', 'test', 'null', NULL, '2024-07-15 19:50:42', '2024-07-15 20:30:11', NULL);
=======
INSERT INTO `bips` (`id`, `client_id`, `patient_id`, `doctor_id`, `type_of_assessment`, `documents_reviewed`, `background_information`, `previus_treatment_and_result`, `current_treatment_and_progress`, `education_status`, `phisical_and_medical_status`, `maladaptives`, `assestment_conducted`, `assestment_conducted_options`, `prevalent_setting_event_and_atecedents`, `interventions`, `reduction_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'cliente3243', 1, 1, '[{\"document_title\": \"ADOs\", \"document_status\": \"yes\"}]', 'asdsa', 'dsadsa', 'dsads', 'dsadas', 'dsasd', '[{\"baseline_date\": \"2024-04-11T04:00:00.000Z\", \"baseline_level\": \"30\", \"initial_interesting\": 3, \"maladaptive_behavior\": \"raya las paredes\", \"topografical_definition\": \"dasdsa\"}, {\"baseline_date\": \"2024-04-15T04:00:00.000Z\", \"baseline_level\": \"10\", \"initial_interesting\": 10, \"maladaptive_behavior\": \"Negative Self talk\", \"topografical_definition\": \"dasd\"}, {\"baseline_date\": \"2024-05-03T04:00:00.000Z\", \"baseline_level\": \"40\", \"initial_interesting\": 10, \"maladaptive_behavior\": \"se rasca la nariz\", \"topografical_definition\": \"estoy cansado de decirle que se deje la nariz quieta, le va a crecer como a pinocho\"}]', 'sadsa', '[{\"assestment_title\": \"dasdas\", \"assestment_status\": \"yes\"}]', '[{\"behavior\": \"das\", \"hypothesized_functions\": \"das\", \"prevalent_setting_event_and_atecedent\": \"das\"}, {\"behavior\": \"sdad\", \"hypothesized_functions\": \"sa\", \"prevalent_setting_event_and_atecedent\": \"dsa\"}]', '[{\"dra\": \"dsaad\", \"dro\": \"dsada\", \"ncr\": \"dasdas\", \"pairing\": \"dasdas\", \"shaping\": \"dasda\", \"chaining\": \"dsa\", \"redirection\": \"dasdas\", \"response_block\": \"dsad\", \"premack_principal\": \"dasda\", \"errorless_teaching\": \"dassd\"}]', NULL, '2024-01-31 01:41:01', '2024-05-03 22:01:02', NULL),
(3, 7, 'asd234', 1, 1, '[{\"document_title\": \"dasasd\", \"document_status\": \"pending\"}]', 'dasads', 'dasdas', 'dasdas', 'dasdas', 'dsads', '[{\"baseline_level\": \"Maladaptives dsadsa\", \"initial_interesting\": 34, \"maladaptive_behavior\": \"Maladaptives\", \"topografical_definition\": \"dsadsadsadas\"}, {\"baseline_level\": \"dasas\", \"initial_interesting\": 23, \"maladaptive_behavior\": \"dsads\", \"topografical_definition\": \"asdas\"}, {\"baseline_level\": \"dasds\", \"initial_interesting\": 23, \"maladaptive_behavior\": \"Negative Self talk\", \"topografical_definition\": \"das\"}]', 'dasdas', '[{\"assestment_title\": \"dsadsa\", \"assestment_status\": \"pending\"}]', '[{\"behavior\": \"dadas\", \"hypothesized_functions\": \"dsaad\", \"prevalent_setting_event_and_atecedent\": \"dsasd\"}, {\"behavior\": \"dasdasd\", \"hypothesized_functions\": \"asdas\", \"prevalent_setting_event_and_atecedent\": \"saddas\"}, {\"behavior\": \"dasdsa\", \"hypothesized_functions\": \"ads\", \"prevalent_setting_event_and_atecedent\": \"asd\"}]', '[{\"dra\": \"dasds\", \"dro\": \"dasad\", \"ncr\": \"dsadas\", \"pairing\": \"asads\", \"shaping\": \"dsada\", \"chaining\": \"dsaad\", \"redirection\": \"das\", \"response_block\": \"dasa\", \"premack_principal\": \"dasad\", \"errorless_teaching\": \"dsadasdsa\"}]', NULL, '2024-02-01 07:35:32', '2024-02-07 10:45:18', NULL),
(4, 6, 'cliente3', 1, 3, '[{\"document_title\": \"dasdsa\", \"document_status\": \"reviewing\"}]', 'asdasd', 'sads', 'dasdas', 'dsadasdsa', 'das', '[{\"baseline_date\": \"2024-05-09T04:00:00.000Z\", \"baseline_level\": \"50\", \"initial_interesting\": 34, \"maladaptive_behavior\": \"Negative Self talk\", \"topografical_definition\": \"topografical\"}]', 'dasdsa', '[]', '[]', '[]', NULL, '2024-05-03 03:19:14', '2024-05-03 03:20:57', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_reports`
--

CREATE TABLE `client_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(155) DEFAULT NULL,
  `sponsor_id` bigint(20) DEFAULT NULL,
  `cpt_code` varchar(155) DEFAULT NULL,
  `md` varchar(50) DEFAULT NULL,
  `md2` varchar(50) DEFAULT NULL,
  `pos` varchar(50) DEFAULT NULL,
  `insurer_id` bigint(20) DEFAULT NULL,
  `session_date` timestamp NULL DEFAULT NULL,
  `total_hours` time DEFAULT NULL,
  `total_units` time DEFAULT NULL,
  `charges` double DEFAULT NULL,
  `xe` varchar(100) DEFAULT NULL,
  `pa_number` varchar(100) DEFAULT NULL,
  `npi` varchar(150) DEFAULT NULL,
  `billed` tinyint(1) DEFAULT '0' COMMENT '0: false, 1:true',
  `pay` tinyint(1) DEFAULT '0' COMMENT '0: false, 1:true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

<<<<<<< HEAD
=======
--
-- Volcado de datos para la tabla `client_reports`
--

INSERT INTO `client_reports` (`id`, `patient_id`, `sponsor_id`, `cpt_code`, `md`, `md2`, `pos`, `insurer_id`, `session_date`, `total_hours`, `total_units`, `charges`, `xe`, `pa_number`, `npi`, `billed`, `pay`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-26 04:00:00', '04:45:00', NULL, 2480592351890.9, '0', 'adsdas', NULL, 0, 0, '2024-04-17 23:00:44', '2024-04-17 23:00:44', NULL),
(2, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-25 04:00:00', '02:15:00', NULL, 2480592351890.9, '0', 'adsdas', NULL, 0, 0, '2024-04-17 23:02:29', '2024-04-17 23:02:29', NULL),
(3, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-25 04:00:00', '02:15:00', NULL, 2480592351890.9, '0', 'adsdas', NULL, 0, 0, '2024-04-17 23:36:40', '2024-04-17 23:36:40', NULL),
(4, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-26 04:00:00', '04:45:00', NULL, 2480592351890.9, '0', 'adsdas', NULL, 0, 0, '2024-04-17 23:44:56', '2024-04-17 23:44:56', NULL),
(5, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-26 04:00:00', '04:45:00', NULL, 2480592351890.9, '0', 'adsdas', NULL, 0, 0, '2024-04-17 23:52:48', '2024-04-17 23:52:48', NULL),
(6, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-26 04:00:00', '04:45:00', NULL, 2480592351890.9, '0', 'adsdas', NULL, 0, 0, '2024-04-17 23:54:06', '2024-04-17 23:54:06', NULL),
(7, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-26 04:00:00', '04:45:00', NULL, 148835541113450, '0', 'adsdas', NULL, 1, 1, '2024-04-18 00:00:51', '2024-04-18 00:00:51', NULL),
(8, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-25 04:00:00', '02:15:00', NULL, 148835541113450, '0', 'adsdas', NULL, 1, 1, '2024-04-18 00:16:58', '2024-04-18 00:16:58', NULL),
(9, 'cliente3243', 5, '97151', 'HM', 'HO', '03', 6, '2024-04-23 04:00:00', '05:00:00', NULL, 295799717716590, '0', 'adsdas', NULL, 1, 0, '2024-04-18 00:18:20', '2024-04-18 00:18:20', NULL),
(10, 'cliente3243', 6, '97151', NULL, NULL, '03', 6, '2024-04-26 04:00:00', '04:45:00', NULL, 148835541113450, '0', 'adsdas', NULL, 1, 0, '2024-04-18 00:20:49', '2024-04-18 00:20:49', NULL),
(11, 'cliente3243', 6, '97151', 'HM', 'HO', '03', 6, '2024-04-26 04:00:00', '04:45:00', NULL, 0, '0', 'adsdas', NULL, 0, 0, '2024-04-18 04:43:19', '2024-04-18 04:43:19', NULL),
(12, NULL, NULL, '97153', 'HM', 'HO', '03', 1, '2024-04-18 16:00:00', '03:15:00', NULL, NULL, '0', 'pas3244', NULL, 0, 0, '2024-04-23 22:29:31', '2024-04-23 22:29:31', NULL),
(13, NULL, NULL, '97153', 'HM', 'HO', '03', 1, '2024-04-18 16:00:00', '03:15:00', NULL, 273, '0', 'pas3244', NULL, 0, 0, '2024-04-23 22:32:21', '2024-04-23 22:32:21', NULL),
(14, NULL, NULL, '97153', 'HM', 'HM', '03', 1, '2024-04-19 16:00:00', '13:45:00', NULL, 861, '0', 'pas3244', NULL, 0, 0, '2024-04-23 22:34:56', '2024-04-23 22:34:56', NULL),
(15, NULL, NULL, '97153', 'HM', 'HM', '03', 1, '2024-04-19 16:00:00', '13:45:00', NULL, 861, '0', 'pas3244', NULL, 0, 0, '2024-04-23 22:35:11', '2024-04-23 22:35:11', NULL),
(16, NULL, NULL, '97153', 'HM', 'HO', '03', 1, '2024-04-18 16:00:00', '03:15:00', NULL, 273, '0', 'pas3244', NULL, 1, 1, '2024-04-23 22:36:22', '2024-04-23 22:36:22', NULL),
(17, NULL, NULL, '97153', 'HM', 'HO', '03', 1, '2024-04-20 16:00:00', '06:00:00', NULL, 504, '0', 'pas3244', 'dad', 1, 1, '2024-04-23 22:38:46', '2024-04-23 22:38:46', NULL),
(18, NULL, NULL, '97153', 'HM', 'HO', '03', 1, '2024-04-23 16:00:00', '05:00:00', NULL, 420, '0', 'pas3244', 'dad', 1, 1, '2024-04-23 22:38:54', '2024-04-23 22:38:54', NULL),
(19, NULL, NULL, '97153', 'HM', 'HO', '03', 1, '2024-04-30 16:00:00', '15:00:00', NULL, 819, '0', 'pas3244', 'dad', 1, 1, '2024-04-23 22:51:56', '2024-04-23 22:51:56', NULL),
(20, NULL, NULL, '97153', 'HM', NULL, '03', 1, '2024-04-19 16:00:00', '13:45:00', NULL, 861, '0', 'pas3244', 'dad', 0, 0, '2024-04-23 22:53:10', '2024-04-23 22:53:10', NULL),
(21, NULL, NULL, '97153', 'HM', NULL, '03', 1, '2024-04-18 16:00:00', '03:15:00', NULL, 273, '0', 'pas3244', 'dad', 1, 0, '2024-04-23 22:53:25', '2024-04-23 22:53:25', NULL),
(22, NULL, NULL, '97153', 'HM', NULL, '03', 1, '2024-04-20 16:00:00', '06:00:00', NULL, 504, '0', 'pas3244', 'dad', 1, 0, '2024-04-23 22:53:35', '2024-04-23 22:53:35', NULL),
(23, NULL, NULL, '97153', NULL, NULL, '03', 1, '2024-04-18 16:00:00', '03:15:00', NULL, 273, '0', 'pas3244', 'dad', 1, 1, '2024-04-24 00:24:49', '2024-04-24 00:24:49', NULL),
(24, NULL, NULL, '97153', 'HM', 'HO', '03', 1, '2024-04-19 16:00:00', '03:15:00', NULL, 273, '0', 'pas3244', 'dsa', 1, 1, '2024-04-26 20:34:15', '2024-04-26 20:34:15', NULL);

>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consent_to_treatments`
--

CREATE TABLE `consent_to_treatments` (
  `id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `consent_to_treatments`
--

INSERT INTO `consent_to_treatments` (`id`, `bip_id`, `patient_id`, `client_id`, `analyst_signature`, `analyst_signature_date`, `parent_guardian_signature`, `parent_guardian_signature_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, 'signatures/ai9wi9HbctxfFlto2mhLJDe4ohWCm1G6iAUlR4T0.jpg', '2024-07-12 16:00:00', 'signatures/HtqGrbQAH5gKHJlzIL239wAIGeyLLxuIjWXdFGcj.jpg', '2024-07-12 16:00:00', '2024-07-12 23:10:56', '2024-07-12 23:10:56', NULL),
(2, 2, '985590391', 5, 'signatures/CTlwi79NHGbzkvXem0eEmJ01mIRQIX2EX67v4gcL.jpg', '2024-07-15 16:00:00', 'signatures/S5VngLe2Fzk9ZUpKLfqvb8ESy1KV95HuSZGNKUaM.jpg', '2024-07-15 16:00:00', '2024-07-15 20:13:04', '2024-07-15 20:13:04', NULL);
=======
(1, 1, 'cliente3243', 5, 'signatures/AA1HtTe90AqaAC1tfeOiWZOFBrwS6jl5sXVN1sTp.jpg', '2024-02-17 16:00:00', 'signatures/IvdhT1RnZbCntMGx2p2CFuNjph4Gg6buSfa3bNgS.jpg', '2024-02-23 16:00:00', '2024-02-16 19:33:49', '2024-02-16 19:33:49', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crisis_plans`
--

CREATE TABLE `crisis_plans` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `crisis_description` text,
  `crisis_note` text,
  `caregiver_requirements_for_prevention_of_crisis` text,
  `risk_factors` json DEFAULT NULL,
  `suicidalities` json DEFAULT NULL,
  `homicidalities` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `crisis_plans`
--

INSERT INTO `crisis_plans` (`id`, `bip_id`, `patient_id`, `client_id`, `crisis_description`, `crisis_note`, `caregiver_requirements_for_prevention_of_crisis`, `risk_factors`, `suicidalities`, `homicidalities`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, 'test', 'test', 'test', '[{\"do_not_apply\": true}]', '[{\"not_present\": true}]', '[{\"not_present_homicidality\": true}]', '2024-07-12 23:10:09', '2024-07-12 23:10:09', NULL),
(2, 2, '985590391', 5, 'crisis description', 'crisis note', 'caregiver', '[{\"do_not_apply\": true}]', '[{\"not_present\": true}]', '[{\"not_present_homicidality\": true}]', '2024-07-15 20:10:52', '2024-07-15 20:10:52', NULL);
=======
(1, 1, 'cliente3243', 5, 'dsaads', 'dasadsdas', 'caregiver_requirements_for_prevention_of_crisis', '[{\"other\": \"dsadasdadsadsa\", \"elopement\": true, \"aggression\": true, \"do_not_apply\": true, \"fire_setting\": true, \"impulsive_behavior\": true, \"psychotic_symptoms\": true, \"assaultive_behavior\": true, \"current_family_violence\": true, \"current_substance_abuse\": true, \"self_injurious_behavior\": true, \"self_mutilation_cutting\": true, \"dealing_with_significant\": true, \"sexually_offending_behavior\": true, \"caring_for_ill_family_recipient\": true, \"prior_psychiatric_inpatient_admission\": true}]', '[{\"plan\": true, \"means\": true, \"ideation\": true, \"not_present\": false, \"prior_attempt\": false}]', '[{\"plan_homicidality\": true, \"means_homicidality\": true, \"ideation_homicidality\": false, \"not_present_homicidality\": false, \"prior_attempt_homicidality\": true}]', '2024-02-14 23:15:10', '2024-05-03 05:18:33', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `de_escalation_techniques`
--

CREATE TABLE `de_escalation_techniques` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text,
  `service_recomendation` text,
  `recomendation_lists` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `de_escalation_techniques`
--

INSERT INTO `de_escalation_techniques` (`id`, `bip_id`, `patient_id`, `client_id`, `description`, `service_recomendation`, `recomendation_lists`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, NULL, NULL, '[{\"cpt\": \"test\", \"location\": \"In Home/School/Community\", \"num_units\": 23, \"breakdown_per_week\": \"test\", \"description_service\": \"test\"}]', '2024-07-12 23:10:25', '2024-07-12 23:10:25', NULL),
(2, 2, '985590391', 5, NULL, NULL, '[{\"cpt\": \"97151\", \"location\": \"In Home/School\", \"num_units\": 32, \"breakdown_per_week\": \"8\", \"description_service\": \"Assessment\"}]', '2024-07-15 20:12:25', '2024-07-15 20:12:25', NULL);
=======
(1, 1, 'cliente3243', 5, 'dsaadsdasdas', 'dassddasds', '[{\"cpt\": \"sdada\", \"location\": \"In Home\", \"num_units\": 2, \"locationnew\": \"In Home\", \"breakdown_per_week\": \"dsadas\", \"description_service\": \"adsads\"}, {\"cpt\": \"dasdsadsa\", \"location\": \"In Home/School\", \"num_units\": 23, \"breakdown_per_week\": \"23dsadsa\", \"description_service\": \"dsa\"}, {\"cpt\": \"saddsads\", \"location\": \"In Home\", \"num_units\": 23, \"breakdown_per_week\": \"das\", \"description_service\": \"adsa\"}, {\"cpt\": \"dsadsa\", \"location\": \"In Home/Community\", \"num_units\": 23, \"breakdown_per_week\": \"das\", \"description_service\": \"dasads\"}, {\"cpt\": \"dsa\", \"location\": \"In Home/School\", \"num_units\": 32, \"breakdown_per_week\": \"ads\", \"description_service\": \"dsa\"}]', '2024-02-14 21:52:35', '2024-03-05 17:11:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor_schedule_hours`
--

CREATE TABLE `doctor_schedule_hours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hour_start` varchar(50) NOT NULL,
  `hour_end` varchar(50) NOT NULL,
  `hour` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `doctor_schedule_hours`
--

INSERT INTO `doctor_schedule_hours` (`id`, `hour_start`, `hour_end`, `hour`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '08:00:00', '08:15:00', '08', NULL, NULL, NULL),
(2, '08:15:00', '08:30:00', '08', NULL, NULL, NULL),
(3, '08:30:00', '08:45:00', '08', NULL, NULL, NULL),
(4, '08:45:00', '09:00:00', '08', NULL, NULL, NULL),
(5, '09:00:00', '09:15:00', '09', NULL, NULL, NULL),
(6, '09:15:00', '09:30:00', '09', NULL, NULL, NULL),
(7, '09:30:00', '09:45:00', '09', NULL, NULL, NULL),
(8, '09:45:00', '10:00:00', '09', NULL, NULL, NULL),
(9, '10:00:00', '10:15:00', '10', NULL, NULL, NULL),
(10, '10:15:00', '10:30:00', '10', NULL, NULL, NULL),
(11, '10:30:00', '10:45:00', '10', NULL, NULL, NULL),
(12, '10:45:00', '11:00:00', '10', NULL, NULL, NULL),
(13, '11:00:00', '11:15:00', '11', NULL, NULL, NULL),
(14, '11:15:00', '11:30:00', '11', NULL, NULL, NULL),
(15, '11:30:00', '11:45:00', '11', NULL, NULL, NULL),
(16, '11:45:00', '12:00:00', '11', NULL, NULL, NULL),
(17, '12:00:00', '12:15:00', '12', NULL, NULL, NULL),
(18, '12:15:00', '12:30:00', '12', NULL, NULL, NULL),
(19, '12:30:00', '12:45:00', '12', NULL, NULL, NULL),
(20, '12:45:00', '13:00:00', '12', NULL, NULL, NULL),
(21, '13:00:00', '13:15:00', '13', NULL, NULL, NULL),
(22, '13:15:00', '13:30:00', '13', NULL, NULL, NULL),
(23, '13:30:00', '13:45:00', '13', NULL, NULL, NULL),
(24, '13:45:00', '14:00:00', '13', NULL, NULL, NULL),
(25, '14:00:00', '14:15:00', '14', NULL, NULL, NULL),
(26, '14:15:00', '14:30:00', '14', NULL, NULL, NULL),
(27, '14:30:00', '14:45:00', '14', NULL, NULL, NULL),
(28, '14:45:00', '15:00:00', '14', NULL, NULL, NULL),
(29, '15:00:00', '15:15:00', '15', NULL, NULL, NULL),
(30, '15:15:00', '15:30:00', '15', NULL, NULL, NULL),
(31, '15:30:00', '15:45:00', '15', NULL, NULL, NULL),
(32, '15:45:00', '16:00:00', '15', NULL, NULL, NULL),
(33, '16:00:00', '16:15:00', '16', NULL, NULL, NULL),
(34, '16:15:00', '16:30:00', '16', NULL, NULL, NULL),
(35, '16:30:00', '16:45:00', '16', NULL, NULL, NULL),
(36, '16:45:00', '17:00:00', '16', NULL, NULL, NULL),
(37, '17:00:00', '17:15:00', '17', NULL, NULL, NULL),
(38, '17:15:00', '17:30:00', '17', NULL, NULL, NULL),
(39, '17:30:00', '17:45:00', '17', NULL, NULL, NULL),
(40, '17:45:00', '18:00:00', '17', NULL, NULL, NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `family_envolments`
--

CREATE TABLE `family_envolments` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `caregivers_training_goals` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `family_envolments`
--

INSERT INTO `family_envolments` (`id`, `bip_id`, `patient_id`, `client_id`, `caregivers_training_goals`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, '[{\"criteria\": \"asd\", \"end_date\": \"2024-07-31T04:00:00.000Z\", \"initiation\": \"2024-07-14T04:00:00.000Z\", \"caregiver_goal\": \"dasdas\", \"current_status\": \"new\", \"outcome_measure\": \"dsasda\"}]', '2024-07-12 23:09:18', '2024-07-15 02:50:45', NULL),
(2, 2, '985590391', 5, '[{\"criteria\": \"90% fidelity\", \"end_date\": \"2024-07-15T04:00:00.000Z\", \"initiation\": \"2024-03-01T04:00:00.000Z\", \"caregiver_goal\": \"Parents/teachers will identify antecedents related to Elnathan’s behavior\", \"current_status\": \"in progress\", \"outcome_measure\": \"Monthly fidelity checks in which the percentage of times (across 4 data points) the parent demonstrated concept.\"}]', '2024-07-15 19:59:17', '2024-07-15 22:26:52', NULL);
=======
(1, 1, 'cliente3243', 5, '[{\"criteria\": \"asads\", \"initiation\": \"2024-02-13T04:00:00.000Z\", \"caregiver_goal\": \"daads\", \"current_status\": \"pending\", \"outcome_measure\": \"asdasdd\"}, {\"criteria\": \"dasads\", \"initiation\": \"2024-02-15T04:00:00.000Z\", \"caregiver_goal\": \"addasads\", \"current_status\": \"yes\", \"outcome_measure\": \"dasasddas\"}, {\"criteria\": \"das\", \"initiation\": \"2024-02-22T04:00:00.000Z\", \"caregiver_goal\": \"dsaasd\", \"current_status\": \"new\", \"outcome_measure\": \"dasasd\"}, {\"criteria\": \"80%\", \"initiation\": \"2024-05-03T04:00:00.000Z\", \"caregiver_goal\": \"family Envolvement\", \"current_status\": \"new\", \"outcome_measure\": \"ouctome\"}]', '2024-02-11 23:06:11', '2024-05-03 20:35:17', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generalization_trainings`
--

CREATE TABLE `generalization_trainings` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discharge_plan` text,
  `transition_fading_plans` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `generalization_trainings`
--

INSERT INTO `generalization_trainings` (`id`, `bip_id`, `patient_id`, `client_id`, `discharge_plan`, `transition_fading_plans`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, 'test', '[{\"phase\": \"test\", \"description\": \"test\"}]', '2024-07-12 23:09:46', '2024-07-12 23:09:46', NULL),
(2, 2, '985590391', 5, 'The desired outcomes for discharge will be refined throughout the treatment process. Transition and discharge planning from a treatment program is included in this plan and specifies details of monitoring and follow-up as is appropriate for Elnathan and the family. Parents, extended family members, community caregivers, and others involved professionals will be consulted as the planning process accelerates with 3-6 months prior to the discharge. A description of roles and responsibilities of all providers and effective dates for behavioral targets that must be achieved prior to discharge will be specified and coordinated with all providers, and family members. Discharge and transition planning will involve a gradual step down in services. \nDischarge often requires 6 months or longer. Discharge Services will be reviewed and evaluated, and discharge planning begun when:\n • Elnathan has achieved treatment goals (0 incidents of challenging behavior and performs correctly on skill acquisition goals); OR \n• Family is interested in discontinuing services, OR\n• Family and provider are not able to reconcile important issues in treatment planning and delivery\nElnathan will be discharged when he has mastered all long-term goals being targeted and no additional skills areas and/or behavioral issues have been identified as a need for targeted treatment goals. Parents will also demonstrate understanding of ABA interventions and teaching/modeling for Elnathan consistently without support from therapist.', '[{\"phase\": \"1\", \"description\": \"All maladaptive will be reduced to 90% from bl, and vineland teacher maladaptive domain scales at 17 or less. Behavior analyst and assistant will reduce services by 25%, for 3 consecutive months.\"}, {\"phase\": \"2\", \"description\": \"Phase 1 sustained and Progress on skill acquisition goals at 80%. vineland (teacher form) score of 80 or more on socialization and communication domains. Behavior analyst and assistant will reduce services by 50%, for 3 consecutive months\"}, {\"phase\": \"3\", \"description\": \"Phase 2 sustained; skills generalized/maintained 80%. Behavior analyst and assistant will reduce services by 75%, for 3 consecutive months.\"}, {\"phase\": \"4\", \"description\": \"Phase 3 sustained for 3 consecutive months. Behavior analyst will provide 1 hr. per week consultation only model to ensure generalization/maintenance of skills, for 3 consecutive months RBT will be discontinued.\"}, {\"phase\": \"5\", \"description\": \"Phase 4 sustained for 3 consecutive months. Behavior analyst will provide 1 hr. per month consultation only model to ensure generalization/maintenance of skills, for 3 consecutive months. Then all services will be discontinued\"}]', '2024-07-15 20:01:32', '2024-07-15 20:01:32', NULL);
=======
(1, 1, 'cliente3243', 5, 'dasdsad', '[{\"phase\": \"sadsa\", \"description\": \"dsadsa\"}, {\"phase\": \"dsadsad\", \"description\": \"sadsa\"}]', '2024-02-14 22:38:07', '2024-02-14 22:39:55', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insurances`
--

CREATE TABLE `insurances` (
  `id` bigint(50) NOT NULL,
  `insurer_name` varchar(255) DEFAULT NULL,
  `services` json DEFAULT NULL,
  `notes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `insurances`
--

INSERT INTO `insurances` (`id`, `insurer_name`, `services`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 'Fl Blue', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"84\", \"unit_prize\": \"21\", \"description\": \"Assessment\", \"max_allowed\": \"(max 2 hrs/day) total 40 units/10 hours copay will aply per day\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"52\", \"unit_prize\": \"13\", \"description\": \"Therapy\", \"max_allowed\": \"(max 8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCBA\", \"hourly_fee\": \"81.6\", \"unit_prize\": \"20.4\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"76\", \"unit_prize\": \"19\", \"description\": \"Caregiver Training\", \"max_allowed\": null}, {\"code\": \"97157\", \"provider\": \"BCBA\", \"hourly_fee\": null, \"unit_prize\": \"3\", \"description\": \"Group Caregiver Training( Multi-family)\", \"max_allowed\": null}, {\"code\": \"H0032\", \"provider\": \"BCBA\", \"hourly_fee\": \"68\", \"unit_prize\": \"17\", \"description\": null, \"max_allowed\": null}]', '[{\"note\": \"Horizon by BCBS\"}, {\"note\": \"Horizon BCBSNJ will use H0032 for Indirect service (treatment planning)\"}, {\"note\": \"telehealth: submit a claim to Florida Blue using one of the regular codes included in your fee schedule. The place of service should be the regular place of service as if you saw the patient in-person.\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"Now allows concurrent billing of 97155 and 97153, effecitve 12/01/2021\"}, {\"note\": \"97156 is always ALLOWED to overlap with 97153\"}]', '2024-01-26 04:17:41', '2024-01-27 06:09:11', NULL),
(2, 'United', '[{\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"50.04\", \"unit_prize\": \"12.51\", \"description\": \"therapy\"}, {\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"119.52\", \"unit_prize\": \"29.88\", \"description\": \"IA (40 units)\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA 97155\", \"hourly_fee\": \"77.28\", \"unit_prize\": \"19.32\", \"description\": \"supervision\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA 97156\", \"hourly_fee\": \"70.04\", \"unit_prize\": \"17.51\", \"description\": \"PT\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"66.72\", \"unit_prize\": \"16.68\", \"description\": \"therapy\", \"max_allowed\": null}, {\"code\": \"97151\", \"provider\": \"BCaBA\", \"hourly_fee\": \"101.6\", \"unit_prize\": \"25.4\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"56.72\", \"unit_prize\": \"14.18\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"65.68\", \"unit_prize\": \"16.42\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"59.52\", \"unit_prize\": \"14.88\", \"description\": null, \"max_allowed\": null}]', '[{\"note\": \"No school or community covered unless aproved by peer review on auth\"}, {\"note\": \"If the rendering provider is required, use the BCBA on the case.\"}, {\"note\": \"for 97155 Yes. When supervision is provided, you may bill concurrently for both Supervisors and Behavior Technicians, billing with 97153 and 97155.\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"Modifiers: RBT- HM, BCBA- HO, BCaBA- HN\"}, {\"note\": \"97156 is always allowed to overlap with 97153\"}]', '2024-01-27 06:14:56', '2024-01-28 07:51:37', NULL),
(3, 'CIGNA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"21\", \"unit_prize\": \"48\", \"description\": \"Assessment\", \"max_allowed\": \"48 units/ (12 hrs), No PA req.\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"10\", \"unit_prize\": \"15\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA (RBT supervision)\", \"hourly_fee\": \"19\", \"unit_prize\": \"0\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"Caregiver Training\", \"hourly_fee\": \"19\", \"unit_prize\": \"0\", \"description\": \"Therapy\", \"max_allowed\": null}]', '[{\"note\": \"Modifier XE for 2 sessions, same day different POS\\t\\t\\t\\ncan bill RBT and BCBA together por supervision\\t\\t\\t\\nOnly one provider can bill for a unit of time with the exception of CPT codes 97153 and 97155 (direct\\t\\t\\t\\nsupervision when the Board Certified Behavior Analyst® (BCBA®)/Qualified Healthcare Provider\\t\\t\\t\\n(QHP) directs the technician and both are face-to-face with the patient at the same time).\\t\\t\\t\\nbill services under the BCBA or licensed provider, allows lmhc\"}]', '2024-04-09 07:46:23', '2024-04-09 08:25:07', NULL),
(4, 'TRICARE', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"136.24\", \"unit_prize\": \"37.35\", \"description\": \"Assessment\", \"max_allowed\": \"32 units for initial/24 for reassessment, units per authorization (2 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"64.44\", \"unit_prize\": \"18.46\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"97155\", \"hourly_fee\": \"125\", \"unit_prize\": \"32.15\", \"description\": \"BIP modification only\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"T1023\", \"provider\": \"BCBA\", \"hourly_fee\": \"68.13\", \"unit_prize\": \"0\", \"description\": \"PDDBI\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"75\", \"unit_prize\": \"20.62\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"107.2\", \"unit_prize\": \"26.8\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}]', '[{\"note\": \"Concurrent billing is excluded for all ABA Category I CPT codes\"}, {\"note\": \"Does not allow billing for any two ABA providers at the same time. or same date\"}, {\"note\": \"If BCBA overlap with BCaBA, bill BCBA\"}, {\"note\": \"8.11.7.3.8 Concurrent billing is excluded for all ACD Category I CPT codes except when the family and the beneficiary are receiving separate services and the beneficiary is not present in the family session. Documentation must indicate two separate rendering providers and locations for the services.\"}, {\"note\": \"Yes they credential LMHC\"}]', '2024-04-09 08:04:29', '2024-04-09 08:31:05', NULL),
(5, 'AETNA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Assessment\", \"max_allowed\": \"48 units/ (12 hrs), 2 hr per day max\"}, {\"code\": \"97152\", \"provider\": \"RBT\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Assessment\", \"max_allowed\": null}, {\"code\": \"0362T\", \"provider\": \"Supporting\", \"hourly_fee\": \"88\", \"unit_prize\": \"20\", \"description\": \"Assessment\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"MD or QHP\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"0373T\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"20\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Caregiver Training\", \"max_allowed\": null}, {\"code\": \"97154\", \"provider\": \"Group\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97157\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Therapy Multiple-family group\", \"max_allowed\": null}, {\"code\": \"97158\", \"provider\": \"group MD or QHP\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"BIP modification only\", \"max_allowed\": null}]', '[{\"note\": \"Modifier: Telehealth (02) - 95\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}]', '2024-04-09 08:20:13', '2024-04-09 08:20:35', NULL),
(6, 'Medicaid', '[{\"code\": \"97153\", \"provider\": \"RBT, BCaBA\", \"hourly_fee\": \"219.42\", \"unit_prize\": \"12.19\", \"description\": \"Direct Service provided by a Registered Behavior Technician (RBT), a BCaBA, or a Lead Analyst\", \"max_allowed\": \"max 8 hours per day\"}, {\"code\": \"97156\", \"provider\": \"Lead Analyst\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Family training by Lead Analyst Service provided by a Lead Analyst\", \"max_allowed\": \"max 4H per day\"}, {\"code\": \"97156 GT\", \"provider\": \"Lead Analyst\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Family training via telemedicine Service provided by a Lead Analyst; Florida Medicaid reimburses up to 2 hours per week\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"PM\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Behavior treatment with protocol modification (PM) Service provided by a Lead Analyst\", \"max_allowed\": \"max 6 hours per day (PM needs to be on the notes)\"}, {\"code\": \"97156 HN\", \"provider\": \"BCaBA\", \"hourly_fee\": \"60.96\", \"unit_prize\": \"15.24\", \"description\": \"Family training by assistant Service performed by a BCaBA\", \"max_allowed\": null}, {\"code\": \"97155 HN\", \"provider\": \"BCaBA\", \"hourly_fee\": \"243.84\", \"unit_prize\": \"15.24\", \"description\": \"Behavior treatment with protocol modification Service provided by a BCaBA\", \"max_allowed\": null}, {\"code\": \"97151\", \"provider\": null, \"hourly_fee\": \"38.1\", \"unit_prize\": \"19.05\", \"description\": \"Assessment maximum of 24 units\", \"max_allowed\": \"max 2 hours per day\"}, {\"code\": \"97151 TS\", \"provider\": null, \"hourly_fee\": \"152.4\", \"unit_prize\": \"19.05\", \"description\": \"Reassessment maximum of 18 units\", \"max_allowed\": \"max 2 hours per day\"}]', '[{\"note\": \"overlap: if 97153 is concurrent with 97155, 97153 need to use modifier XP (Not reimbursed)\"}, {\"note\": \"All services need to be  billed\"}, {\"note\": \"02+ GT for telehealth\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"For sunshine cases w/ member ID starts with a 7, the PA needs to be under the BCBA name that is on the case.\"}]', '2024-04-12 08:14:56', '2024-04-27 00:12:21', NULL),
(7, 'NOW KBA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"136.24\", \"unit_prize\": \"34.06\", \"description\": \"Assessment\", \"max_allowed\": \"32 units for initial/32 for reassessment, units per authorization (2 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"75\", \"unit_prize\": \"18.75\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"BIP modification only\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"T1023\", \"provider\": \"BCBA\", \"hourly_fee\": \"68.13\", \"unit_prize\": null, \"description\": \"PDDBI\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"75\", \"unit_prize\": \"18.75\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"83.16\", \"unit_prize\": \"20.79\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}]', '[{\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"ALLOWS OVERLAP BILLING\"}]', '2024-04-12 08:32:40', '2024-04-12 08:32:40', NULL);
=======
(1, 'Fl Blue', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"84\", \"unit_prize\": \"21\", \"description\": \"Assessment\", \"max_allowed\": \"(max 2 hrs/day) total 40 units/10 hours copay will aply per day\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"52\", \"unit_prize\": \"13\", \"description\": \"Therapy\", \"max_allowed\": \"(max 8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCBA\", \"hourly_fee\": \"81.6\", \"unit_prize\": \"20.4\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"76\", \"unit_prize\": \"19\", \"description\": \"Caregiver Training\", \"max_allowed\": null}, {\"code\": \"97157\", \"provider\": \"BCBA\", \"hourly_fee\": null, \"unit_prize\": \"3\", \"description\": \"Group Caregiver Training( Multi-family)\", \"max_allowed\": null}, {\"code\": \"H0032\", \"provider\": \"BCBA\", \"hourly_fee\": \"68\", \"unit_prize\": \"17\", \"description\": null, \"max_allowed\": null}]', '[{\"note\": \"Horizon by BCBS\"}, {\"note\": \"Horizon BCBSNJ will use H0032 for Indirect service (treatment planning)\"}, {\"note\": \"telehealth: submit a claim to Florida Blue using one of the regular codes included in your fee schedule. The place of service should be the regular place of service as if you saw the patient in-person.\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"Now allows concurrent billing of 97155 and 97153, effecitve 12/01/2021\"}, {\"note\": \"97156 is always ALLOWED to overlap with 97153\"}]', '2024-01-26 00:17:41', '2024-01-27 02:09:11', NULL),
(2, 'United', '[{\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"50.04\", \"unit_prize\": \"12.51\", \"description\": \"therapy\"}, {\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"119.52\", \"unit_prize\": \"29.88\", \"description\": \"IA (40 units)\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA 97155\", \"hourly_fee\": \"77.28\", \"unit_prize\": \"19.32\", \"description\": \"supervision\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA 97156\", \"hourly_fee\": \"70.04\", \"unit_prize\": \"17.51\", \"description\": \"PT\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"66.72\", \"unit_prize\": \"16.68\", \"description\": \"therapy\", \"max_allowed\": null}, {\"code\": \"97151\", \"provider\": \"BCaBA\", \"hourly_fee\": \"101.6\", \"unit_prize\": \"25.4\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"56.72\", \"unit_prize\": \"14.18\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"65.68\", \"unit_prize\": \"16.42\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"59.52\", \"unit_prize\": \"14.88\", \"description\": null, \"max_allowed\": null}]', '[{\"note\": \"No school or community covered unless aproved by peer review on auth\"}, {\"note\": \"If the rendering provider is required, use the BCBA on the case.\"}, {\"note\": \"for 97155 Yes. When supervision is provided, you may bill concurrently for both Supervisors and Behavior Technicians, billing with 97153 and 97155.\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"Modifiers: RBT- HM, BCBA- HO, BCaBA- HN\"}, {\"note\": \"97156 is always allowed to overlap with 97153\"}]', '2024-01-27 02:14:56', '2024-01-28 03:51:37', NULL),
(3, 'CIGNA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"21\", \"unit_prize\": \"48\", \"description\": \"Assessment\", \"max_allowed\": \"48 units/ (12 hrs), No PA req.\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"10\", \"unit_prize\": \"15\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA (RBT supervision)\", \"hourly_fee\": \"19\", \"unit_prize\": \"0\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"Caregiver Training\", \"hourly_fee\": \"19\", \"unit_prize\": \"0\", \"description\": \"Therapy\", \"max_allowed\": null}]', '[{\"note\": \"Modifier XE for 2 sessions, same day different POS\\t\\t\\t\\ncan bill RBT and BCBA together por supervision\\t\\t\\t\\nOnly one provider can bill for a unit of time with the exception of CPT codes 97153 and 97155 (direct\\t\\t\\t\\nsupervision when the Board Certified Behavior Analyst® (BCBA®)/Qualified Healthcare Provider\\t\\t\\t\\n(QHP) directs the technician and both are face-to-face with the patient at the same time).\\t\\t\\t\\nbill services under the BCBA or licensed provider, allows lmhc\"}]', '2024-04-09 03:46:23', '2024-04-09 04:25:07', NULL),
(4, 'TRICARE', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"136.24\", \"unit_prize\": \"37.35\", \"description\": \"Assessment\", \"max_allowed\": \"32 units for initial/24 for reassessment, units per authorization (2 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"64.44\", \"unit_prize\": \"18.46\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"97155\", \"hourly_fee\": \"125\", \"unit_prize\": \"32.15\", \"description\": \"BIP modification only\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"T1023\", \"provider\": \"BCBA\", \"hourly_fee\": \"68.13\", \"unit_prize\": \"0\", \"description\": \"PDDBI\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"75\", \"unit_prize\": \"20.62\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"107.2\", \"unit_prize\": \"26.8\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}]', '[{\"note\": \"Concurrent billing is excluded for all ABA Category I CPT codes\"}, {\"note\": \"Does not allow billing for any two ABA providers at the same time. or same date\"}, {\"note\": \"If BCBA overlap with BCaBA, bill BCBA\"}, {\"note\": \"8.11.7.3.8 Concurrent billing is excluded for all ACD Category I CPT codes except when the family and the beneficiary are receiving separate services and the beneficiary is not present in the family session. Documentation must indicate two separate rendering providers and locations for the services.\"}, {\"note\": \"Yes they credential LMHC\"}]', '2024-04-09 04:04:29', '2024-04-09 04:31:05', NULL),
(5, 'AETNA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Assessment\", \"max_allowed\": \"48 units/ (12 hrs), 2 hr per day max\"}, {\"code\": \"97152\", \"provider\": \"RBT\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Assessment\", \"max_allowed\": null}, {\"code\": \"0362T\", \"provider\": \"Supporting\", \"hourly_fee\": \"88\", \"unit_prize\": \"20\", \"description\": \"Assessment\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"MD or QHP\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"0373T\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"20\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Caregiver Training\", \"max_allowed\": null}, {\"code\": \"97154\", \"provider\": \"Group\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97157\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Therapy Multiple-family group\", \"max_allowed\": null}, {\"code\": \"97158\", \"provider\": \"group MD or QHP\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"BIP modification only\", \"max_allowed\": null}]', '[{\"note\": \"Modifier: Telehealth (02) - 95\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}]', '2024-04-09 04:20:13', '2024-04-09 04:20:35', NULL),
(6, 'Medicaid', '[{\"code\": \"97153\", \"provider\": \"RBT, BCaBA\", \"hourly_fee\": \"219.42\", \"unit_prize\": \"12.19\", \"description\": \"Direct Service provided by a Registered Behavior Technician (RBT), a BCaBA, or a Lead Analyst\", \"max_allowed\": \"max 8 hours per day\"}, {\"code\": \"97156\", \"provider\": \"Lead Analyst\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Family training by Lead Analyst Service provided by a Lead Analyst\", \"max_allowed\": \"max 4H per day\"}, {\"code\": \"97156 GT\", \"provider\": \"Lead Analyst\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Family training via telemedicine Service provided by a Lead Analyst; Florida Medicaid reimburses up to 2 hours per week\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"PM\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Behavior treatment with protocol modification (PM) Service provided by a Lead Analyst\", \"max_allowed\": \"max 6 hours per day (PM needs to be on the notes)\"}, {\"code\": \"97156 HN\", \"provider\": \"BCaBA\", \"hourly_fee\": \"60.96\", \"unit_prize\": \"15.24\", \"description\": \"Family training by assistant Service performed by a BCaBA\", \"max_allowed\": null}, {\"code\": \"97155 HN\", \"provider\": \"BCaBA\", \"hourly_fee\": \"243.84\", \"unit_prize\": \"15.24\", \"description\": \"Behavior treatment with protocol modification Service provided by a BCaBA\", \"max_allowed\": null}, {\"code\": \"97151\", \"provider\": null, \"hourly_fee\": \"38.1\", \"unit_prize\": \"19.05\", \"description\": \"Assessment maximum of 24 units\", \"max_allowed\": \"max 2 hours per day\"}, {\"code\": \"97151 TS\", \"provider\": null, \"hourly_fee\": \"152.4\", \"unit_prize\": \"19.05\", \"description\": \"Reassessment maximum of 18 units\", \"max_allowed\": \"max 2 hours per day\"}]', '[{\"note\": \"overlap: if 97153 is concurrent with 97155, 97153 need to use modifier XP (Not reimbursed)\"}, {\"note\": \"All services need to be  billed\"}, {\"note\": \"02+ GT for telehealth\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"For sunshine cases w/ member ID starts with a 7, the PA needs to be under the BCBA name that is on the case.\"}]', '2024-04-12 04:14:56', '2024-04-26 20:12:21', NULL),
(7, 'NOW KBA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"136.24\", \"unit_prize\": \"34.06\", \"description\": \"Assessment\", \"max_allowed\": \"32 units for initial/32 for reassessment, units per authorization (2 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"75\", \"unit_prize\": \"18.75\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"BIP modification only\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"T1023\", \"provider\": \"BCBA\", \"hourly_fee\": \"68.13\", \"unit_prize\": null, \"description\": \"PDDBI\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"75\", \"unit_prize\": \"18.75\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"83.16\", \"unit_prize\": \"20.79\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}]', '[{\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"ALLOWS OVERLAP BILLING\"}]', '2024-04-12 04:32:40', '2024-04-12 04:32:40', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
<<<<<<< HEAD
  `id` bigint(20) UNSIGNED NOT NULL,
=======
  `id` bigint(20) NOT NULL,
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
  `title` varchar(150) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `zip` varchar(150) DEFAULT NULL,
  `address` text,
  `email` varchar(150) DEFAULT NULL,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `locations`
--

INSERT INTO `locations` (`id`, `title`, `avatar`, `city`, `state`, `zip`, `address`, `email`, `phone1`, `phone2`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 'Pelaez', 'locations/4RkuD10qGcTnfKRXHd2jX594dBVu78RdgDADZfRc.jpg', 'Naples', 'Florida', '34102', '704 Goodlette Frank Rd. N Naples, FL 34102', 'pelaezandbeyond@gmail.com', '888-533-2902', '209-390-1597', '2024-02-02 00:32:49', '2024-06-18 07:18:09', NULL),
(2, 'FENIX', 'locations/Ysx7n3mCj1a7wZuojaplfMPjXjs68MlyDJ5Usts4.jpg', 'Sarasota', 'Florida', '34237', '2014 4TH ST Sarasota, Florida 34237', 'office@fenixbehavior.com', '239-224-9534', '239-790-2601', '2024-02-02 00:33:21', '2024-06-18 07:16:40', NULL),
(3, 'ABAOFSWF', 'locations/4RkuD10qGcTnfKRXHd2jX594dBVu78RdgDADZfRc.jpg', 'fort myers Beach', 'Florida', '33931', '6660 Estero blvd', 'manager@practice-mgmt.com', '888-872-0459', '2396916482', '2024-02-02 00:35:26', '2024-06-18 07:13:56', NULL),
(4, 'Chacao', 'locations/PxUPzBByeO6WDUI8PuwARqmGvhSBUTEEPsCKWptl.jpg', 'Caracas', 'Distrito Federal', '1234', 'Chacao', 'abachacao@aba.com', '123456', '456789', '2024-07-10 18:12:19', '2024-07-10 18:12:19', NULL),
(5, 'La Trinidad', 'locations/8LxQFBPmhYPyuPohXdJAMD4GdIQwZShO7na0DUMm.jpg', 'La trinidad', 'Distrito Federal', '1234', 'La trinidad', 'abatrinidad@aba.com', '12345', '234566435', '2024-07-10 18:18:13', '2024-07-10 18:18:13', NULL),
(6, 'TEXAS', NULL, 'Huston', 'FL', '33907', '1705 colonial BLVD\r\nB4', 'texasoffice@abaofswf.com', '210-686-2720', '888-391-5328', '2024-06-07 06:39:20', '2024-06-07 06:39:20', NULL);
=======
(1, 'Candelaria', 'locations/4RkuD10qGcTnfKRXHd2jX594dBVu78RdgDADZfRc.jpg', 'Candelaria', 'Capital', '1010', 'Centro Comercial Sambil Candelaria, Local e23', 'AbaThepC@app.com', '324432', '55665654', '2024-02-01 20:32:49', '2024-02-01 20:58:42', NULL),
(2, 'Chacao', 'locations/Ysx7n3mCj1a7wZuojaplfMPjXjs68MlyDJ5Usts4.jpg', 'dasdas', 'dasdsa', '234we', 'Centro Comercial Sambil Chacao, Local e23', 'AbaThepCh@app.com', '2344432', '55665654', '2024-02-01 20:33:21', '2024-02-01 20:58:06', NULL),
(3, 'Santa Paula', 'locations/4RkuD10qGcTnfKRXHd2jX594dBVu78RdgDADZfRc.jpg', 'Caracas', 'Distrito Capital', '1010A', 'Centro Comercial Santa paula, Local e23', 'AbaThep@app.com', '3223444', '55665654', '2024-02-01 20:35:26', '2024-02-08 09:28:05', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maladaptives`
--

CREATE TABLE `maladaptives` (
  `id` bigint(50) NOT NULL,
  `bip_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(155) DEFAULT NULL,
  `maladaptive_behavior` varchar(155) DEFAULT NULL,
  `number_of_occurrences` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `maladaptives`
--

INSERT INTO `maladaptives` (`id`, `bip_id`, `patient_id`, `maladaptive_behavior`, `number_of_occurrences`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 9, 'cliente3243', NULL, NULL, '2024-03-08 00:25:18', '2024-03-08 00:25:18', NULL),
(6, 10, 'cliente3243', NULL, NULL, '2024-03-08 00:26:59', '2024-03-08 00:26:59', NULL),
(7, 11, 'cliente3243', NULL, NULL, '2024-03-18 20:16:36', '2024-03-18 20:16:36', NULL),
(8, 12, 'cliente3243', NULL, NULL, '2024-03-18 20:16:53', '2024-03-18 20:16:53', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(7, '2023_11_29_231903_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
<<<<<<< HEAD
(8, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
=======
(2, 'App\\Models\\User', 2),
(6, 'App\\Models\\User', 3),
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
(7, 'App\\Models\\User', 4),
(8, 'App\\Models\\User', 5),
(8, 'App\\Models\\User', 6),
(7, 'App\\Models\\User', 7),
(1, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(1, 'App\\Models\\User', 10),
(1, 'App\\Models\\User', 11),
(1, 'App\\Models\\User', 12),
(1, 'App\\Models\\User', 13),
(1, 'App\\Models\\User', 14),
(1, 'App\\Models\\User', 15),
(1, 'App\\Models\\User', 16),
<<<<<<< HEAD
(8, 'App\\Models\\User', 17),
(1, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 21),
(7, 'App\\Models\\User', 22),
(7, 'App\\Models\\User', 23),
(8, 'App\\Models\\User', 23),
(1, 'App\\Models\\User', 24),
(7, 'App\\Models\\User', 24),
(7, 'App\\Models\\User', 25),
(8, 'App\\Models\\User', 25),
(1, 'App\\Models\\User', 26),
(8, 'App\\Models\\User', 27),
(7, 'App\\Models\\User', 28),
(8, 'App\\Models\\User', 28);
=======
(8, 'App\\Models\\User', 17);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitoring_evaluatings`
--

CREATE TABLE `monitoring_evaluatings` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `treatment_fidelity` text,
  `rbt_training_goals` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `monitoring_evaluatings`
--

INSERT INTO `monitoring_evaluatings` (`id`, `bip_id`, `patient_id`, `client_id`, `treatment_fidelity`, `rbt_training_goals`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, NULL, '[{\"lto\": \"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\", \"date\": \"2024-07-12T04:00:00.000Z\", \"status\": \"inprogress\"}]', '2024-07-12 23:09:32', '2024-07-12 23:09:32', NULL),
(2, 2, '985590391', 5, NULL, '[{\"lto\": \"RBT will independently demonstrate Premack Principle procedure, near 100% of opportunities, across two consecutive observations.\", \"date\": \"2024-07-15T04:00:00.000Z\", \"status\": \"initiated\"}]', '2024-07-15 20:00:17', '2024-07-15 22:27:07', NULL);
=======
(1, 1, 'cliente3243', 5, 'dsadsadsdsa', '[{\"lto\": \"RBT will independently demonstrate DRA procedure, near 100% of opportunities, across two consecutive observations.\", \"date\": \"2024-02-22T04:00:00.000Z\", \"goal\": \"fwerf\", \"status\": \"mastered\", \"current_status\": \"sdfsd\"}, {\"lto\": \"RBT will independently demonstrate Redirection procedure, near 100% of opportunities, across two consecutive observations.\", \"date\": \"2024-02-29T04:00:00.000Z\", \"goal\": \"32\", \"status\": \"inprogress\", \"current_status\": \"15 incidents per week\"}, {\"lto\": \"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\", \"date\": \"2024-03-04T04:00:00.000Z\", \"status\": \"inprogress\"}]', '2024-02-14 22:55:55', '2024-03-04 22:50:19', NULL),
(2, 4, 'cliente3', 6, NULL, '[{\"lto\": \"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\", \"date\": \"2024-05-09T04:00:00.000Z\", \"status\": \"inprogress\"}]', '2024-05-08 22:40:38', '2024-05-08 22:40:38', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_bcbas`
--

CREATE TABLE `note_bcbas` (
  `id` bigint(20) NOT NULL,
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
  `note_description` text,
  `rendering_provider` bigint(20) DEFAULT NULL,
  `aba_supervisor` bigint(20) DEFAULT NULL,
  `caregiver_goals` json DEFAULT NULL,
  `rbt_training_goals` json DEFAULT NULL,
  `provider_signature` varchar(255) DEFAULT NULL,
  `provider_name` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_signature` varchar(255) DEFAULT NULL,
  `supervisor_name` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','ok','no','review') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note_bcbas`
--

INSERT INTO `note_bcbas` (`id`, `doctor_id`, `patient_id`, `bip_id`, `birth_date`, `diagnosis_code`, `cpt_code`, `location`, `session_date`, `time_in`, `time_out`, `time_in2`, `time_out2`, `session_length_total`, `note_description`, `rendering_provider`, `aba_supervisor`, `caregiver_goals`, `rbt_training_goals`, `provider_signature`, `provider_name`, `supervisor_signature`, `supervisor_name`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, '2024-07-12 08:00:00', 'test', '97151', 'undefined', '2024-07-12 16:00:00', '09:00:00', '12:00:00', '12:00:00', '05:00:00', NULL, 'test', 1, 3, '\"[{\\\"criteria\\\":\\\"test\\\",\\\"initiation\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"test\\\",\\\"current_status\\\":\\\"new\\\",\\\"outcome_measure\\\":\\\"test\\\",\\\"porcent_of_correct_response\\\":12}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"status\\\":\\\"inprogress\\\",\\\"porcent_of_correct_response\\\":32}]\"', 'http://127.0.0.1:8000/storage/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'http://127.0.0.1:8000/storage/signatures/qA0V6xTZ08eRFO5h37RjUHw2ZFmLDa8O17hTCZlt.jpg', 3, '2024-07-13 00:15:33', '2024-07-13 23:53:50', NULL, 'ok');
=======
(1, 1, 'cliente3243', 1, '2024-01-23 16:00:00', 'dadsda', '97151', '03', '2024-04-10 16:00:00', '09:00:00', '10:30:00', '16:30:00', '18:30:00', NULL, 'dasdas', 4, 7, '\"[{\\\"caregiver_goal\\\":\\\"daads\\\",\\\"porcent_of_correct_response\\\":10},{\\\"caregiver_goal\\\":\\\"addasads\\\",\\\"porcent_of_correct_response\\\":34},{\\\"caregiver_goal\\\":\\\"dsaasd\\\",\\\"porcent_of_correct_response\\\":43}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate DRA procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":23},{\\\"lto\\\":\\\"RBT will independently demonstrate Redirection procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":22},{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":1}]\"', NULL, 4, NULL, 7, '2024-04-22 23:19:04', '2024-04-29 22:15:32', NULL, 'ok'),
(2, 1, 'cliente3243', 1, '2024-01-23 12:00:00', 'dadsda', '97153', 'null', '2024-04-29 18:10:06', '09:00:00', '10:00:00', '03:30:00', '04:45:00', NULL, 'dsadas', 7, 2, '\"[{\\\"caregiver_goal\\\":\\\"daads\\\",\\\"porcent_of_correct_response\\\":4},{\\\"caregiver_goal\\\":\\\"addasads\\\",\\\"porcent_of_correct_response\\\":4},{\\\"caregiver_goal\\\":\\\"dsaasd\\\",\\\"porcent_of_correct_response\\\":4}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate DRA procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":4},{\\\"lto\\\":\\\"RBT will independently demonstrate Redirection procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":3},{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":2}]\"', NULL, 7, NULL, 2, '2024-04-29 22:07:50', '2024-04-29 22:07:50', NULL, 'pending'),
(3, 4, 'cliente3243', 1, '2024-01-23 12:00:00', 'Diagnosis: Crazy', '97153', '\"12 Home\"', '2024-05-03 16:00:00', '09:15:00', '10:00:00', '03:30:00', '05:45:00', NULL, 'a pesar de que mi compañero se comio la empanada, el dia resulto favorable, porque el chamo es de cuidado especial, es muy vivo.. y tuvimos que distraerlo para que no crea que lo vamos a inyectar...', 4, 2, '\"[{\\\"caregiver_goal\\\":\\\"daads\\\",\\\"porcent_of_correct_response\\\":2},{\\\"caregiver_goal\\\":\\\"addasads\\\",\\\"porcent_of_correct_response\\\":3},{\\\"caregiver_goal\\\":\\\"dsaasd\\\",\\\"porcent_of_correct_response\\\":3},{\\\"caregiver_goal\\\":\\\"family Envolvement\\\",\\\"porcent_of_correct_response\\\":5}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate DRA procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":3},{\\\"lto\\\":\\\"RBT will independently demonstrate Redirection procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":34},{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"porcent_of_correct_response\\\":10}]\"', 'notebcbas/njmvatTXS4FMvZds0q9CjZAOd6FwUzAOIylR5lS9.png', 4, 'notebcbas/yayA5SQe8DzoaWw1tklV2G4RdeFbQWQt0v0EhPhE.png', 2, '2024-05-03 22:26:34', '2024-05-03 22:27:03', NULL, 'ok'),
(4, 1, 'cliente3243', 1, '2024-01-23 16:00:00', 'Diagnosis: Crazy', '97153', 'undefined', '2024-05-12 16:00:00', '09:00:00', '10:00:00', '10:00:00', NULL, NULL, 'dasdsadas', 4, 2, '\"[{\\\"criteria\\\":\\\"asads\\\",\\\"initiation\\\":\\\"2024-02-13T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"daads\\\",\\\"current_status\\\":\\\"pending\\\",\\\"outcome_measure\\\":\\\"asdasdd\\\",\\\"porcent_of_correct_response\\\":12},{\\\"criteria\\\":\\\"dasads\\\",\\\"initiation\\\":\\\"2024-02-15T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"addasads\\\",\\\"current_status\\\":\\\"yes\\\",\\\"outcome_measure\\\":\\\"dasasddas\\\",\\\"porcent_of_correct_response\\\":32},{\\\"criteria\\\":\\\"das\\\",\\\"initiation\\\":\\\"2024-02-22T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"dsaasd\\\",\\\"current_status\\\":\\\"new\\\",\\\"outcome_measure\\\":\\\"dasasd\\\",\\\"porcent_of_correct_response\\\":33},{\\\"criteria\\\":\\\"80%\\\",\\\"initiation\\\":\\\"2024-05-03T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"family Envolvement\\\",\\\"current_status\\\":\\\"new\\\",\\\"outcome_measure\\\":\\\"ouctome\\\",\\\"porcent_of_correct_response\\\":23}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate DRA procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-02-22T04:00:00.000Z\\\",\\\"goal\\\":\\\"fwerf\\\",\\\"status\\\":\\\"mastered\\\",\\\"current_status\\\":\\\"sdfsd\\\",\\\"porcent_of_correct_response\\\":10},{\\\"lto\\\":\\\"RBT will independently demonstrate Redirection procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-02-29T04:00:00.000Z\\\",\\\"goal\\\":\\\"32\\\",\\\"status\\\":\\\"inprogress\\\",\\\"current_status\\\":\\\"15 incidents per week\\\",\\\"porcent_of_correct_response\\\":32},{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-03-04T04:00:00.000Z\\\",\\\"status\\\":\\\"inprogress\\\",\\\"porcent_of_correct_response\\\":23}]\"', NULL, 4, NULL, 7, '2024-05-11 20:37:21', '2024-05-11 20:57:07', NULL, 'pending');
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `note_rbts`
--

CREATE TABLE `note_rbts` (
  `id` bigint(20) NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_name_g` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_credential` varchar(255) DEFAULT NULL,
  `pos` varchar(255) DEFAULT NULL,
  `session_date` timestamp NULL DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `time_in2` time DEFAULT NULL,
  `time_out2` time DEFAULT NULL,
  `session_length_total` double DEFAULT NULL,
  `environmental_changes` varchar(255) DEFAULT NULL,
  `maladaptives` json DEFAULT NULL,
  `replacements` json DEFAULT NULL,
  `interventions` json DEFAULT NULL,
  `meet_with_client_at` varchar(255) DEFAULT NULL,
  `client_appeared` varchar(255) DEFAULT NULL,
  `as_evidenced_by` varchar(255) DEFAULT NULL,
  `rbt_modeled_and_demonstrated_to_caregiver` varchar(255) DEFAULT NULL,
  `client_response_to_treatment_this_session` text,
  `progress_noted_this_session_compared_to_previous_session` varchar(255) DEFAULT NULL,
  `next_session_is_scheduled_for` timestamp NULL DEFAULT NULL,
  `provider_signature` varchar(255) DEFAULT NULL,
  `provider_name` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_signature` varchar(255) DEFAULT NULL,
  `supervisor_name` bigint(20) UNSIGNED DEFAULT NULL,
  `billed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: false, 1:true',
  `pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: false, 1:true',
  `status` enum('pending','ok','no','review') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `note_rbts`
--

INSERT INTO `note_rbts` (`id`, `doctor_id`, `patient_id`, `bip_id`, `provider_name_g`, `provider_credential`, `pos`, `session_date`, `time_in`, `time_out`, `time_in2`, `time_out2`, `session_length_total`, `environmental_changes`, `maladaptives`, `replacements`, `interventions`, `meet_with_client_at`, `client_appeared`, `as_evidenced_by`, `rbt_modeled_and_demonstrated_to_caregiver`, `client_response_to_treatment_this_session`, `progress_noted_this_session_compared_to_previous_session`, `next_session_is_scheduled_for`, `provider_signature`, `provider_name`, `supervisor_signature`, `supervisor_name`, `billed`, `pay`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 1, 'test1', 1, 1, 'null', '[object Object],[object Object],[object Object],[object Object]', '2024-07-12 16:00:00', '09:00:00', '12:00:00', '12:00:00', '05:00:00', NULL, 'test', 'null', 'null', 'null', '03', 'happy', 'test', 'test', 'test', 'moderate', '2024-07-12 16:00:00', 'http://127.0.0.1:8000/storage/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'http://127.0.0.1:8000/storage/signatures/qA0V6xTZ08eRFO5h37RjUHw2ZFmLDa8O17hTCZlt.jpg', 3, 1, 1, 'ok', '2024-07-12 23:05:00', '2024-07-13 23:52:22', NULL),
(2, 1, 'test1', 1, 1, 'null', '[object Object],[object Object],[object Object],[object Object]', '2024-07-13 16:00:00', '09:00:00', '12:00:00', '12:00:00', '02:00:00', NULL, 'test', '\"[{\\\"baseline_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"34\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"test\\\",\\\"topografical_definition\\\":\\\"test\\\",\\\"number_of_occurrences\\\":12}]\"', '\"[{\\\"goal\\\":\\\"test\\\",\\\"total_trials\\\":32,\\\"number_of_correct_response\\\":15}]\"', '\"[{\\\"pairing\\\":true}]\"', '03', 'sad', 'test', 'test', 'test', 'excelent', '2024-07-14 16:00:00', 'http://127.0.0.1:8000/storage/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'http://127.0.0.1:8000/storage/signatures/qA0V6xTZ08eRFO5h37RjUHw2ZFmLDa8O17hTCZlt.jpg', 3, 0, 0, 'ok', '2024-07-12 23:06:30', '2024-07-12 23:06:35', NULL),
(3, 1, 'test1', 1, 1, 'null', '[object Object],[object Object],[object Object],[object Object]', '2024-07-13 16:00:00', '09:00:00', '12:00:00', '12:00:00', '04:00:00', NULL, 'environmental changes', '\"[{\\\"baseline_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"34\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"test\\\",\\\"topografical_definition\\\":\\\"test\\\",\\\"number_of_occurrences\\\":10}]\"', '\"[{\\\"goal\\\":\\\"test\\\",\\\"total_trials\\\":32,\\\"number_of_correct_response\\\":16}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true}]\"', '12', 'happy', 'environmental changes', 'environmental changes', 'environmental changes', 'excelent', '2024-07-14 16:00:00', 'http://127.0.0.1:8000/storage/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'http://127.0.0.1:8000/storage/signatures/qA0V6xTZ08eRFO5h37RjUHw2ZFmLDa8O17hTCZlt.jpg', 3, 0, 0, 'ok', '2024-07-13 23:41:26', '2024-07-13 23:53:58', NULL),
(4, 1, '985590391', 3, 1, 'null', '03 School', '2024-07-16 16:00:00', '09:00:00', '12:00:00', '12:00:00', '03:00:00', NULL, 'environmental changes', '\"[{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 15 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 35 incidents per week\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 70 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 50 incidents per week\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 150 incidents per week\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 100 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2024-06-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"25\\\",\\\"initial_interesting\\\":40,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":32}]\"', '\"[{\\\"goal\\\":\\\"Goal 1\\\",\\\"total_trials\\\":32,\\\"number_of_correct_response\\\":15}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true}]\"', '03', 'sad', 'environmental changes', 'environmental changes', 'environmental changes', 'excelent', '2024-07-16 16:00:00', 'http://127.0.0.1:8000/storage/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, NULL, 4, 0, 0, 'pending', '2024-07-15 18:56:41', '2024-07-15 18:58:35', '2024-07-15 18:58:35'),
(5, 27, '985590391', 2, 27, 'null', '[object Object],[object Object],[object Object],[object Object]', '2024-07-15 16:00:00', '09:00:00', '12:00:00', '12:00:00', '04:00:00', NULL, 'environmental change', '\"[{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"15\\\",\\\"initial_interesting\\\":5,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"35\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"70\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"50\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"150\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":12},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"100\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"27\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":23}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":24,\\\"number_of_correct_response\\\":12}]\"', '\"[{\\\"pairing\\\":true}]\"', '03', 'excited', 'environmental change', 'environmental change', 'environmental change', 'excelent', '2024-07-16 16:00:00', 'http://127.0.0.1:8000/storage/signatures/Imv4s9iergIUgNdDURPSDhrPzmzW7k0XTKbiO2om.jpg', 27, NULL, 23, 0, 0, 'pending', '2024-07-15 20:26:33', '2024-07-15 20:26:33', NULL),
(6, 27, '985590391', 2, 27, 'null', '[object Object],[object Object],[object Object],[object Object]', '2024-07-16 16:00:00', '09:00:00', '12:00:00', '12:00:00', '04:00:00', NULL, 'environmental chang', '\"[{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"15\\\",\\\"initial_interesting\\\":5,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":12},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"35\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"70\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":2},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"50\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":43},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"150\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":24},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"100\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"27\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":23}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":20,\\\"number_of_correct_response\\\":10}]\"', '\"[{\\\"pairing\\\":true}]\"', '12', 'sad', 'dasdas', 'environmental chang', 'environmental chang', 'excelent', '2024-07-17 16:00:00', 'http://127.0.0.1:8000/storage/signatures/Imv4s9iergIUgNdDURPSDhrPzmzW7k0XTKbiO2om.jpg', 27, NULL, 4, 0, 0, 'pending', '2024-07-15 20:28:21', '2024-07-15 20:28:21', NULL);
=======
(1, 1, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-17 16:00:00', '08:00:00', '03:00:00', '10:15:00', '06:45:00', NULL, 'environmental hapy', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":3},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":9}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":2},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":6,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"NCR\\\":true,\\\"natural_teaching\\\":true}]\"', '03', 'excited', 'adsdsa', 'dasdsa', 'adsdas', 'moderate', '2024-04-18 08:00:00', NULL, 5, NULL, 4, 0, 0, 'pending', '2024-04-17 21:52:57', '2024-04-19 18:12:41', '2024-04-19 18:12:41'),
(2, 5, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-18 16:00:00', '09:00:00', '10:45:00', '03:00:00', '04:30:00', NULL, 'adads', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":2},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":6}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '03', 'excited', 'dasdas', 'dasdas', 'dasdas', 'moderate', '2024-04-19 16:00:00', NULL, 5, NULL, 4, 1, 1, 'ok', '2024-04-17 21:55:03', '2024-04-29 21:39:37', NULL),
(3, 1, 'cliente3243', 1, 5, 'dasdas', '\"12 Home\"', '2024-04-19 16:00:00', '09:30:00', '15:00:00', '10:15:00', '17:30:00', NULL, 'fdsa', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":2},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":6}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '12', 'excited', 'fdsfds', 'fsdfsd', 'fsdfsd', 'moderate', '2024-04-24 16:00:00', NULL, 5, NULL, 4, 1, 1, 'pending', '2024-04-17 21:58:16', '2024-05-08 21:31:33', NULL),
(4, 5, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-20 16:00:00', '09:00:00', '10:00:00', '03:30:00', '08:30:00', NULL, 'dasdsa', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":2},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":6}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '03', 'distracted', 'asdas', 'das', 'dsadsa', 'excelent', '2024-04-21 16:00:00', NULL, 5, NULL, 4, 1, 0, 'pending', '2024-04-17 22:03:49', '2024-04-23 22:53:35', NULL),
(5, 5, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-21 16:00:00', '10:00:00', '10:45:00', '02:00:00', '03:30:00', NULL, 'adsdas', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":2},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":6}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '03', 'tired', 'dasdsa', 'dasdas', 'dsadsa', 'excelent', '2024-04-22 16:00:00', NULL, 5, NULL, 4, 0, 0, 'pending', '2024-04-17 22:09:48', '2024-04-17 22:09:48', NULL),
(6, 5, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-22 16:00:00', '09:00:00', '10:45:00', '02:30:00', '06:15:00', NULL, 'dasdas', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":3},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":5}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":4},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":4},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"natural_teaching\\\":true}]\"', '03', 'happy', 'addsaf', 'fsd', 'fsdfds', 'excelent', '2024-04-23 16:00:00', NULL, 5, NULL, 4, 0, 0, 'pending', '2024-04-17 22:16:26', '2024-04-17 22:16:26', NULL),
(7, 5, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-23 16:00:00', '10:00:00', '11:00:00', '03:00:00', '07:00:00', NULL, 'dasdas', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":3},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":5}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":4},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":4},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '03', 'tired', 'ads', 'ads', 'das', 'moderate', '2024-04-24 16:00:00', NULL, 5, NULL, 4, 1, 1, 'pending', '2024-04-17 22:21:30', '2024-04-23 22:38:54', NULL),
(8, 5, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-24 16:00:00', '08:30:00', '09:00:00', '03:00:00', '05:45:00', NULL, 'dadas', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":2},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":7}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":2},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":2}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '12', 'sad', 'dasdasd', 'asds', 'dsadsa', 'good', '2024-04-25 16:00:00', 'noterbts/bq06b6OvdyFG4viXqo9Ikg0zfBwVHV0IH5vWhtI0.png', 5, 'noterbts/rhCX0xJ4ZzOq91Hof1hYURrIfwNsfmuExwZQTOgW.png', 4, 0, 0, 'pending', '2024-04-17 22:30:57', '2024-04-19 00:25:38', NULL),
(9, 6, 'cliente3243', 1, 6, 'dsadasd', '03', '2024-04-25 16:00:00', '09:00:00', '10:30:00', '04:30:00', '05:15:00', NULL, 'dasdas', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":2},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":7}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":2},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":2}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '03', 'sad', '32', '23da', 'dsadas', 'moderate', '2024-04-26 16:00:00', NULL, 6, NULL, 4, 1, 1, 'ok', '2024-04-17 22:52:14', '2024-04-29 21:38:14', NULL),
(10, 6, 'cliente3243', 1, 6, 'dsadasd', '03', '2024-04-26 16:00:00', '09:00:00', '10:45:00', '03:30:00', '06:30:00', NULL, 'sdsa', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":2},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":7}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":2},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":2}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '12', 'excited', 'dasda', 'dasdas', 'dasdsa', 'excelent', '2024-04-27 16:00:00', NULL, 6, NULL, 4, 0, 0, 'no', '2024-04-17 22:55:40', '2024-04-29 21:38:00', NULL),
(11, 1, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-27 16:00:00', '08:00:00', '09:30:00', '15:00:00', '15:45:00', NULL, 'dasdas', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":6},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":4}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":8,\\\"number_of_correct_response\\\":5,\\\"porcentage_diario\\\":null},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":8,\\\"number_of_correct_response\\\":5,\\\"porcentage_diario\\\":null},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":8,\\\"number_of_correct_response\\\":6,\\\"porcentage_diario\\\":null},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":8,\\\"number_of_correct_response\\\":6,\\\"porcentage_diario\\\":null},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":8,\\\"number_of_correct_response\\\":7,\\\"porcentage_diario\\\":null},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":8,\\\"number_of_correct_response\\\":7,\\\"porcentage_diario\\\":null},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":8,\\\"number_of_correct_response\\\":7,\\\"porcentage_diario\\\":null}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"extinction\\\":true}]\"', '12', 'happy', 'dasdas', 'dasdsa', 'dasdas', 'moderate', '2024-04-28 12:00:00', NULL, 5, 'noterbts/NcHQndF2yAD9ZjrUouoT7rLJgUmv5ZayqJfVUE8x.png', 7, 0, 0, 'review', '2024-04-19 02:42:21', '2024-04-29 21:37:13', NULL),
(12, 1, 'cliente3243', 1, 5, 'dasdas', '03', '2024-04-28 16:00:00', '09:00:00', '10:15:00', '14:00:00', '15:15:00', NULL, 'happy family', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":10},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":5}]\"', '\"[{\\\"goal\\\":\\\"probando Update\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":7,\\\"number_of_correct_response\\\":5},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":4},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":2},{\\\"goal\\\":\\\"31\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":3},{\\\"goal\\\":\\\"nuevo test\\\",\\\"total_trials\\\":5,\\\"number_of_correct_response\\\":4}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"natural_teaching\\\":true}]\"', '03', 'happy', 'fasd', 'dsadas', 'dasdas', 'excelent', '2024-04-29 08:00:00', NULL, 5, NULL, 5, 0, 0, 'ok', '2024-04-19 17:23:33', '2024-04-29 21:39:31', NULL),
(13, 6, 'cliente3243', 1, 6, 'dsadasd', '\"12 Home\"', '2024-05-03 16:00:00', '09:00:00', '10:00:00', '03:00:00', '04:15:00', NULL, 'me comi su empanada', '\"[{\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"number_of_occurrences\\\":10},{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":20},{\\\"maladaptive_behavior\\\":\\\"se rasca la nariz\\\",\\\"number_of_occurrences\\\":2}]\"', '\"[{\\\"goal\\\":\\\"nuuuuewvoo\\\",\\\"total_trials\\\":20,\\\"number_of_correct_response\\\":10},{\\\"goal\\\":\\\"new\\\",\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":4},{\\\"goal\\\":\\\"nuevo\\\",\\\"total_trials\\\":20,\\\"number_of_correct_response\\\":10},{\\\"goal\\\":\\\"dasads\\\",\\\"total_trials\\\":30,\\\"number_of_correct_response\\\":10},{\\\"goal\\\":\\\"prueba nueva\\\",\\\"total_trials\\\":30,\\\"number_of_correct_response\\\":20}]\"', '\"[{\\\"pairing\\\":true,\\\"extinction\\\":true}]\"', '03', 'agressive', 'me pare temprano y no me desayune', 'el otro cuidador se dio cuenta, y me va a esconder la lonchera para la proxima', 'lo hizo pero me recordo su empanada de carne mechada', 'moderate', '2024-05-04 16:00:00', NULL, 6, 'noterbts/KgCPgzGp25VTA0hJW4qG6byxKuEFRI9qXQ2TssSZ.png', 7, 0, 0, 'ok', '2024-05-03 22:21:41', '2024-05-03 22:22:23', NULL),
(16, 1, 'cliente3', 4, 5, 'dasdas', '12 Home', '2024-05-09 16:00:00', '10:00:00', '03:00:00', '11:00:00', '04:00:00', NULL, 'dasdsa', '\"[{\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"number_of_occurrences\\\":10}]\"', '\"[{\\\"id\\\":7,\\\"goal\\\":\\\"replac\\\",\\\"current_status\\\":\\\"das\\\",\\\"description\\\":\\\"dsads\\\",\\\"patient_id\\\":\\\"cliente3\\\",\\\"client_id\\\":null,\\\"bip_id\\\":4,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"2\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-05-08T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-05-08T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"sa\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-05-08T18:29:27.000000Z\\\",\\\"updated_at\\\":\\\"2024-05-08T18:29:27.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":23,\\\"number_of_correct_response\\\":23}]\"', '\"[{\\\"response_block\\\":true,\\\"chaining\\\":true}]\"', '03', 'excited', 'das', 'das', 'das', 'moderate', '2024-05-09 12:00:00', NULL, 5, NULL, 5, 0, 0, 'ok', '2024-05-08 22:32:09', '2024-05-11 21:03:50', NULL),
(19, 1, 'cliente3243', 1, 6, 'dsadasd', '12 Home', '2024-05-11 16:00:00', '09:00:00', '10:00:00', NULL, NULL, NULL, 'asdsa', '\"[{\\\"baseline_date\\\":\\\"2024-04-11T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"30\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"topografical_definition\\\":\\\"dasdsa\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-04-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"10\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"topografical_definition\\\":\\\"dasd\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-05-03T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"40\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"se rasca la nariz\\\",\\\"topografical_definition\\\":\\\"estoy cansado de decirle que se deje la nariz quieta, le va a crecer como a pinocho\\\",\\\"number_of_occurrences\\\":23}]\"', '\"[{\\\"id\\\":1,\\\"goal\\\":\\\"nuuuuewvoo\\\",\\\"current_status\\\":\\\"ads\\\",\\\"description\\\":\\\"ads\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"dsa\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-05-02T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"initiated\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"dassad\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"probando2\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"adsdsa\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"3\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"new\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-21T16:33:54.000000Z\\\",\\\"updated_at\\\":\\\"2024-05-03T02:14:14.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":23,\\\"number_of_correct_response\\\":2},{\\\"id\\\":2,\\\"goal\\\":\\\"new\\\",\\\"current_status\\\":\\\"new sustitution\\\",\\\"description\\\":\\\"new sust\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-22T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"adsdas\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}, {\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"0\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-22T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"dasdas\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"dassad\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"probando2\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"adsdsa\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"3\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"new\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-22T15:27:29.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-22T15:27:29.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":3},{\\\"id\\\":3,\\\"goal\\\":\\\"nuevo\\\",\\\"current_status\\\":\\\"nuevo\\\",\\\"description\\\":\\\"nuevo\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-22T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"mastered\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"mastered\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"nuevo\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-22T15:39:32.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-22T15:39:32.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":3},{\\\"id\\\":4,\\\"goal\\\":\\\"dasads\\\",\\\"current_status\\\":\\\"ads\\\",\\\"description\\\":\\\"das\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"ads\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"ads\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"adsdas\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-15T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"on hold\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-23T00:13:08.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-23T00:13:08.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":3},{\\\"id\\\":5,\\\"goal\\\":\\\"prueba nueva\\\",\\\"current_status\\\":\\\"probando\\\",\\\"description\\\":\\\"probando\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-27T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"sad\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"21\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-20T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"on hold\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-25T14:51:19.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-25T14:51:19.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":3}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true}]\"', '03', 'excited', '2332', 'dasdas', 'dasdas', 'moderate', '2024-05-16 16:00:00', NULL, 6, NULL, 7, 0, 0, 'pending', '2024-05-11 08:08:56', '2024-05-11 08:08:56', NULL),
(21, 1, 'cliente3243', 1, 6, 'dsadasd', '12 Home', '2024-05-13 16:00:00', '09:00:00', '09:15:00', NULL, NULL, NULL, 'adsdas', '\"[{\\\"baseline_date\\\":\\\"2024-04-11T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"30\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"raya las paredes\\\",\\\"topografical_definition\\\":\\\"dasdsa\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-04-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"10\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"topografical_definition\\\":\\\"dasd\\\",\\\"number_of_occurrences\\\":33},{\\\"baseline_date\\\":\\\"2024-05-03T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"40\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"se rasca la nariz\\\",\\\"topografical_definition\\\":\\\"estoy cansado de decirle que se deje la nariz quieta, le va a crecer como a pinocho\\\",\\\"number_of_occurrences\\\":2}]\"', '\"[{\\\"id\\\":1,\\\"goal\\\":\\\"nuuuuewvoo\\\",\\\"current_status\\\":\\\"ads\\\",\\\"description\\\":\\\"ads\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"dsa\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-05-02T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"initiated\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"dassad\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"probando2\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"adsdsa\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"3\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"new\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-21T16:33:54.000000Z\\\",\\\"updated_at\\\":\\\"2024-05-03T02:14:14.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":3,\\\"number_of_correct_response\\\":3},{\\\"id\\\":2,\\\"goal\\\":\\\"new\\\",\\\"current_status\\\":\\\"new sustitution\\\",\\\"description\\\":\\\"new sust\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-22T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"adsdas\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}, {\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"0\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-22T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"dasdas\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"dassad\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"probando2\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"adsdsa\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}, {\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"3\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"new\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-22T15:27:29.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-22T15:27:29.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":32,\\\"number_of_correct_response\\\":23},{\\\"id\\\":3,\\\"goal\\\":\\\"nuevo\\\",\\\"current_status\\\":\\\"nuevo\\\",\\\"description\\\":\\\"nuevo\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-22T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"mastered\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"mastered\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"nuevo\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-22T15:39:32.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-22T15:39:32.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":2,\\\"number_of_correct_response\\\":2},{\\\"id\\\":4,\\\"goal\\\":\\\"dasads\\\",\\\"current_status\\\":\\\"ads\\\",\\\"description\\\":\\\"das\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"ads\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-23T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"initiated\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"ads\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"adsdas\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-15T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"on hold\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-23T00:13:08.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-23T00:13:08.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":2,\\\"number_of_correct_response\\\":2},{\\\"id\\\":5,\\\"goal\\\":\\\"prueba nueva\\\",\\\"current_status\\\":\\\"probando\\\",\\\"description\\\":\\\"probando\\\",\\\"patient_id\\\":\\\"cliente3243\\\",\\\"client_id\\\":5,\\\"bip_id\\\":1,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"nuevo\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-02-27T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"sad\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"21\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-02-20T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"on hold\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"dasdas\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-02-25T14:51:19.000000Z\\\",\\\"updated_at\\\":\\\"2024-02-25T14:51:19.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":22,\\\"number_of_correct_response\\\":2}]\"', '\"[{\\\"pairing\\\":true}]\"', '03', 'distracted', 's', '2332', 'dadas', 'excelent', '2024-05-10 16:00:00', NULL, 6, NULL, 7, 0, 0, 'pending', '2024-05-11 19:38:00', '2024-05-11 19:38:00', NULL),
(22, 1, 'cliente3', 4, 6, 'dsadasd', '12 Home', '2024-05-12 16:00:00', '09:00:00', '10:00:00', NULL, NULL, NULL, 'dasdas', '\"[{\\\"baseline_date\\\":\\\"2024-05-09T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"50\\\",\\\"initial_interesting\\\":34,\\\"maladaptive_behavior\\\":\\\"Negative Self talk\\\",\\\"topografical_definition\\\":\\\"topografical\\\",\\\"number_of_occurrences\\\":23}]\"', '\"[{\\\"id\\\":7,\\\"goal\\\":\\\"replac\\\",\\\"current_status\\\":\\\"das\\\",\\\"description\\\":\\\"dsads\\\",\\\"patient_id\\\":\\\"cliente3\\\",\\\"client_id\\\":null,\\\"bip_id\\\":4,\\\"goalstos\\\":\\\"[{\\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"1\\\\\\\", \\\\\\\"initial_interesting\\\\\\\": \\\\\\\"2\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-05-08T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"das\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-05-08T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"sa\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-05-08T18:29:27.000000Z\\\",\\\"updated_at\\\":\\\"2024-05-08T18:29:27.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":23,\\\"number_of_correct_response\\\":23}]\"', '\"[{\\\"pairing\\\":true}]\"', '03', 'tired', 'dasdas', 'dadsa', 'dasdsa', 'moderate', '2024-05-12 16:00:00', NULL, 6, NULL, 7, 0, 0, 'ok', '2024-05-11 20:47:24', '2024-05-11 20:47:29', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) DEFAULT NULL,
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
  `address` text,
  `gender` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:male,2:female',
  `birth_date` timestamp NULL DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `education` varchar(150) DEFAULT NULL,
  `profession` varchar(150) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `summer_schedule` varchar(255) DEFAULT NULL,
  `special_note` text,
  `insurer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `insuranceId` varchar(50) DEFAULT NULL,
  `eqhlid` varchar(255) DEFAULT NULL,
  `elegibility_date` timestamp NULL DEFAULT NULL,
  `pos_covered` json DEFAULT NULL,
  `deductible_individual_I_F` varchar(150) DEFAULT NULL,
  `balance` varchar(150) DEFAULT NULL,
  `coinsurance` varchar(150) DEFAULT NULL,
  `copayments` varchar(150) DEFAULT NULL,
  `oop` varchar(150) DEFAULT NULL,
  `diagnosis_code` varchar(255) DEFAULT NULL,
  `status` enum('incoming','active','inactive','onHold','onDischarge','waitintOnPa','waitintOnPaIa','waitintOnIa','waitintOnServices','waitintOnStaff','waitintOnSchool') NOT NULL DEFAULT 'inactive',
  `patient_control` varchar(255) DEFAULT NULL,
  `pa_assessments` json DEFAULT NULL,
  `compayment_per_visit` varchar(255) DEFAULT NULL,
  `insurer_secundary` varchar(50) DEFAULT NULL,
  `welcome` enum('waiting','reviewing','psycho eval','requested','need new','yes','no','2 insurance') DEFAULT 'waiting',
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
  `rbt_home_id` bigint(20) DEFAULT NULL,
  `rbt2_school_id` bigint(20) DEFAULT NULL,
  `bcba_home_id` bigint(20) DEFAULT NULL,
  `bcba2_school_id` bigint(20) DEFAULT NULL,
  `clin_director_id` bigint(20) DEFAULT NULL,
  `telehealth` varchar(50) DEFAULT '''false''',
  `pay` varchar(50) DEFAULT '''false''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `patients`
--

INSERT INTO `patients` (`id`, `location_id`, `patient_id`, `first_name`, `last_name`, `email`, `phone`, `language`, `parent_guardian_name`, `relationship`, `home_phone`, `work_phone`, `school_name`, `school_number`, `zip`, `state`, `address`, `gender`, `birth_date`, `age`, `avatar`, `city`, `education`, `profession`, `schedule`, `summer_schedule`, `special_note`, `insurer_id`, `insuranceId`, `eqhlid`, `elegibility_date`, `pos_covered`, `deductible_individual_I_F`, `balance`, `coinsurance`, `copayments`, `oop`, `diagnosis_code`, `status`, `patient_control`, `pa_assessments`, `compayment_per_visit`, `insurer_secundary`, `welcome`, `consent`, `insurance_card`, `mnl`, `referral`, `ados`, `iep`, `asd_diagnosis`, `cde`, `submitted`, `eligibility`, `interview`, `rbt_home_id`, `rbt2_school_id`, `bcba_home_id`, `bcba2_school_id`, `clin_director_id`, `telehealth`, `pay`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 4, 'test1', 'test', 'test', 'test@test.com', '1234', 'test', 'test', 'test', '322344', '4223324', 'test', 'test', 'test', 'test', 'test', 1, '2024-07-12 08:00:00', '10', 'patients/uzL691VVhK0x08sh6GJWizvOl6UqBJf4IUhMNg8M.jpg', 'test', 'test', 'test', 'test', 'test', 'test', 1, 'test', 'test', '2024-07-12 08:00:00', '\"03 School\"', 'test', 'test', 'test', 'test', 'test', 'test', 'active', 'test', '\"[{\\\"pa_assessment\\\":\\\"test\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"test23\\\",\\\"pa_services_start_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97151\\\",\\\"n_units\\\":0},{\\\"pa_assessment\\\":\\\"dsadsa\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-13T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"dsadsaSS\\\",\\\"pa_services_start_date\\\":\\\"2024-07-14T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":400}]\"', NULL, NULL, 'waiting', 'requested', 'reviewing', 'waiting', 'waiting', 'waiting', 'waiting', 'requested', 'waiting', 'waiting', 'requested', 'send', 2, 2, 4, 4, 1, '\'false\'', '\'false\'', '2024-07-12 22:44:40', '2024-07-15 22:13:29', NULL),
(2, 4, 'paciente123', 'paciente', 'prueba', 'paciente@paciente.com', '2344332', 'paciente', 'paciente', 'paciente', '3243', '324432', 'paciente', '23144', 'paciente', 'paciente', 'paciente', 2, '2024-07-14 16:00:00', '4', 'patients/QvVtUxqyB7IOV2HxEUODulaP0IMa8Oc26fTquQtl.jpg', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 2, 'paciente', 'paciente', '2024-07-14 16:00:00', '\"[object Object],[object Object],[object Object],[object Object]\"', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 'inactive', 'paciente', '\"[{\\\"pa_assessment\\\":\\\"paciente\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-14T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"pacientew\\\",\\\"pa_services_start_date\\\":\\\"2024-07-13T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97151\\\",\\\"n_units\\\":233}]\"', NULL, NULL, 'requested', 'waiting', 'waiting', 'waiting', 'reviewing', 'reviewing', 'reviewing', 'requested', 'requested', 'waiting', 'requested', 'receive', 2, 2, 4, 4, 3, '\'false\'', '\'false\'', '2024-07-14 01:31:47', '2024-07-15 22:34:12', NULL),
(5, 3, '985590391', 'Elnathan', 'Abere', 'muleabere@gmail.com', '239-209-8105', 'English', 'MULUGETA ABITEW', 'FATHER', '239-209-8105', '239-209-8105', 'Edgewood academy', '(239) 334-6205', '33916', 'Florida', '3697 WINKLER AV, APT 518, FORT MYERS FL 33916', 1, '2017-06-27 08:00:00', '7', 'patients/HLn97EHrBO7HsXGEMr02z8Jul31WoEbROeBoGCY2.jpg', 'FORT MYERS', '2nd Grade', 'e', 'SCHOOL [transferred to Edgewood academy 9/1/23 teacher wants max hrs) /HOME AFERNOON', '4/11/24- M-Th 9am-1pm, classes start June 11 ends July 18 per message from Michelle (JP).', 'undefined', 2, '985590391', 'Equhid?', '2024-06-01 08:00:00', '\"[object Object],[object Object],[object Object],[object Object]\"', '500', 'undefined', '15%', 'undefined', '3000', 'F84.0', 'active', 'EH0391', '\"[{\\\"pa_assessment\\\":\\\"KH1PCE-01\\\",\\\"pa_assessment_start_date\\\":\\\"2024-08-31T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-11-30T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"4Q3FCQ-01\\\",\\\"pa_services_start_date\\\":\\\"2024-08-31T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-11-30T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":3120}]\"', NULL, NULL, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'receive', 27, 27, 22, 22, 26, 'true', 'true', '2024-07-15 19:44:12', '2024-07-15 22:12:16', NULL);
=======
(4, 1, 'prueba4', 'china', 'prueba4', 'prueba4@prueba4.com', '2132', 'prueba4, prueba4, prueba4', 'prueba4', 'prueba4', '534354', '234423', 'prueba4', 'prueba4', 'prueba4', 'prueba4', 'prueba4', 2, '2024-01-27 08:00:00', '32', 'patients/oX4tL8v7bndvyJSvtUUGuefWI7426KrQ6zi051b8.jpg', 'prueba4', 'prueba4', 'prueba4', 'prueba4', 'prueba4', 'prueba4', 2, 'prueba4', '21323', '2024-01-26 08:00:00', '\"03 School\"', '3243/432', '2545/354543', '20%/43%', '12/12', '340/434', 'prueba4', 'inactive', 'prueba4', '\"[{\\\"pa_assessment\\\":\\\"pachina\\\",\\\"pa_assessment_start_date\\\":\\\"2024-05-10T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-05-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"paschina\\\",\\\"pa_services_start_date\\\":\\\"2024-05-10T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-05-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":200}]\"', NULL, 'prueba4', 'waiting', 'requested', 'reviewing', 'reviewing', 'reviewing', 'reviewing', 'reviewing', 'psycho eval', '2 insurance', '2 insurance', 'yes', 'pending', 5, 6, 4, 7, 2, 'false', 'false', '2024-01-28 05:39:48', '2024-05-10 19:42:47', NULL),
(5, 1, 'cliente3243', 'Pepe', 'ClienteAp', 'ClientePrueba@cliente.com', '32122334', 'Englis, Spanish, german,', 'James Hietfield', 'Dad', '2344323443', '234323443', 'La Salle', '1234567', 'MiFl213', 'Florida', 'First Ave. 23Street', 1, '2024-01-23 08:00:00', '23', 'patients/2tmxf1WcYBNOhtqee7Yyfjvp7ufOSlxryrOPsMcT.jpg', 'Miami', 'primary', 'Student', 'every Week', 'dsaad', 'Special notes from patient', 1, '12345', 'ers323', '2024-01-24 08:00:00', '\"12 Home\"', '32320/2332', '2323/2332', '23/32', '23/23', '324/3232', 'Diagnosis: Crazy', 'active', 'adsds', '\"[{\\\"pa_assessment\\\":\\\"pa12323\\\",\\\"pa_assessment_start_date\\\":\\\"2024-04-12T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-04-20T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"pas3244\\\",\\\"pa_services_start_date\\\":\\\"2024-04-12T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-04-30T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":20},{\\\"pa_assessment\\\":\\\"FLBPA3424\\\",\\\"pa_assessment_start_date\\\":\\\"2024-04-26T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-04-30T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"FLBPS3424\\\",\\\"pa_services_start_date\\\":\\\"2024-04-26T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-04-30T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97155\\\",\\\"n_units\\\":208}]\"', NULL, 'United', 'waiting', 'requested', 'reviewing', 'reviewing', 'reviewing', 'psycho eval', 'psycho eval', 'reviewing', 'reviewing', 'reviewing', 'yes', 'pending', 6, 5, 7, 4, 3, 'false', 'true', '2024-01-31 01:39:09', '2024-05-03 22:29:24', NULL),
(6, 1, 'cliente3', 'Jared', 'Clientepe', 'Cliente3@cliente.com', '24334', 'adsdas', 'qdasdsa', 'dadsa', '234423', '234432', 'dasd', '3123321', 'Cliente3', 'null', 'null', 1, '2024-01-30 08:00:00', '14', 'patients/QqtJbpWUV8mUxrM0rySlC4GazUL89VECvs7XyjaG.jpg', 'Valencia', 'dsads', 'dasda', 'Cliente3', 'Cliente3', 'Cliente3', 6, 'M2345', 'ers323', '2024-01-31 08:00:00', '\"12 Home\"', 'das', 'das', 'dsa', 'das', 'dsa', '1213', 'active', 'dsa', '\"[{\\\"pa_assessment\\\":\\\"pa12323\\\",\\\"pa_assessment_start_date\\\":\\\"2024-04-12T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-04-20T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"pas3244\\\",\\\"pa_services_start_date\\\":\\\"2024-04-12T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-04-30T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":20}]\"', NULL, 'das', 'requested', 'requested', 'reviewing', 'psycho eval', 'requested', 'reviewing', 'psycho eval', 'psycho eval', 'reviewing', 'reviewing', 'waiting', 'pending', 6, 5, 7, 4, 2, 'false', 'false', '2024-01-31 06:32:32', '2024-05-10 18:30:02', NULL),
(7, 3, 'asd234', 'asdasddsa', 'asdasddsa', 'dasads@das.com', 'dasad', 'adsda, dasdas, adsdas', 'dasad', 'dada', 'dadas', 'dadsa', 'dasdas', 'dasda', 'das', 'dasdsa', 'dsads', 2, '2024-01-18 20:00:00', '32', 'patients/n7D5rEBEPBuzn13Q0GGMT01Vy6aF7cxkB5ka8VVO.jpg', 'asddsa', 'asdas', 'dasasd', 'dsadsa', 'dsads', 'dsasd', 2, 'das', NULL, '2024-01-11 20:00:00', NULL, 'adsdsa', 'dsads', 'dsa', 'dsads', 'dsasd', 'dsasd', 'active', 'asdads12321', '\"[]\"', NULL, 'das', 'waiting', 'requested', 'reviewing', 'psycho eval', 'need new', 'need new', '2 insurance', 'reviewing', 'yes', 'no', 'pending', 'pending', 4, 3, 4, 1, 4, NULL, NULL, '2024-02-01 05:07:31', '2024-04-26 00:07:05', '2024-04-26 00:07:05'),
(8, 2, 'cli32232', 'Jane', 'dsads', 'dsad', 'dasdas', 'dsaad', 'dsada', 'dsasd', 'dasddsa', 'dsaads', 'dsaads', 'dsaads', 'dasdas', 'dsads', 'dasdas', 2, '2024-10-01 08:00:00', '32', 'patients/FOlGUKxYeifPupz8vo0KvHysQAorqLHi2aRrzBBR.jpg', 'ddsadas', 'das', 'adsads', 'dsasd', 'dsaads', 'dsaasd', 2, 'saddsa', 'EqhidJane', '2024-01-26 08:00:00', 'null', 'dasads', 'dsads', 'dsasd', 'dsads', 'dsaads', 'dsads', 'waitintOnPa', 'dsaasd', '\"[{\\\"pa_assessment\\\":\\\"pa23432\\\",\\\"pa_assessment_start_date\\\":\\\"2024-05-10T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-05-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"passd233\\\",\\\"pa_services_start_date\\\":\\\"2024-05-10T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-05-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97156\\\",\\\"n_units\\\":300}]\"', NULL, 'dasads', 'requested', 'psycho eval', 'need new', 'psycho eval', 'psycho eval', 'psycho eval', 'requested', 'yes', 'reviewing', 'requested', 'requested', 'pending', 17, 17, 7, 4, 1, 'false', 'false', '2024-02-01 05:36:04', '2024-05-10 18:27:05', NULL),
(9, 1, 'adsds9999', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh, jhgjgh jhgjgh, jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 1, '2024-08-02 12:00:00', '12', 'patients/04E4P35o771AxL2Tow4OFDY3kQPAOA08uMzlxxiT.jpg', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 'jhgjgh', 1, 'fsdf', NULL, '2024-02-09 12:00:00', NULL, 'asdads', 'dsa', 'dsa', 'dsa', 'das', 'jhgjgh', 'inactive', 'dsa', '\"[{\\\"pa_assessment\\\":\\\"asd\\\",\\\"pa_assessment_start_date\\\":\\\"2024-02-07T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-02-06T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"das\\\",\\\"pa_services_start_date\\\":\\\"2024-02-21T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-02-21T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":\\\"asddsa\\\"},{\\\"pa_assessment\\\":\\\"dsadas\\\",\\\"pa_assessment_start_date\\\":\\\"2024-02-15T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-02-14T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"adsdas\\\",\\\"pa_services_start_date\\\":\\\"2024-02-09T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-02-06T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97156\\\",\\\"n_units\\\":\\\"das\\\"}]\"', NULL, 'sdf', 'waiting', 'psycho eval', 'psycho eval', 'psycho eval', 'psycho eval', '2 insurance', 'requested', 'need new', 'reviewing', 'reviewing', 'pending', 'pending', 6, 6, 7, 7, 1, NULL, NULL, '2024-02-04 03:16:34', '2024-02-28 01:36:30', '2024-02-28 01:36:30'),
(10, 3, 'fsddfs5', 'gfdfgd', 'fgdfgd', 'fdssd', 'fsdsfd', 'sdfsd', 'sfdfds', 'fdsdsf', 'fdssdf', 'fsddsffdsfsd', 'fdsfds', 'fsdfds', 'fdsfsd', 'fsdfsd', 'fdsfsd', 2, '2024-02-08 20:00:00', '34', NULL, 'fsdfs', 'fdsdf', 'fdsfd', 'fdssdf', 'fdsfd', 'fssd', 1, 'fdfdsfds', NULL, '2024-02-08 20:00:00', NULL, 'dfsdsf', 'fdsdsf', 'fdsdfs', 'fdsfds', 'fsdfds', 'fdsfsd', 'inactive', 'dfsfds', '\"[{\\\"pa_assessment\\\":\\\"fdsfsd\\\",\\\"pa_assessment_start_date\\\":\\\"2024-02-06T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-02-14T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"fdsdfs\\\",\\\"pa_services_start_date\\\":\\\"2024-02-15T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-02-29T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97155\\\",\\\"n_units\\\":\\\"fdsfds\\\"}]\"', NULL, 'fsdsdf', 'requested', 'waiting', 'psycho eval', 'need new', '2 insurance', 'psycho eval', '2 insurance', 'yes', 'psycho eval', '2 insurance', 'pending', 'pending', 6, 5, 7, 4, 1, NULL, NULL, '2024-02-04 03:34:13', '2024-02-28 01:36:26', '2024-02-28 01:36:26'),
(11, 3, 'revision1', 'revision2', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 2, '2024-02-07 20:00:00', '23', 'patients/tZ0LZWP0A4HqawCeyFp9ZXEbtdNl2GCzGhuCw94V.jpg', 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 2, 'revision', NULL, '2024-02-08 20:00:00', NULL, 'revision', 'revision', 'revision', 'revision', 'revision', 'revision', 'inactive', 'revision', '\"[]\"', NULL, 'revision', 'requested', 'reviewing', 'reviewing', 'reviewing', 'requested', 'reviewing', 'reviewing', 'requested', 'reviewing', 'reviewing', 'pending', 'pending', 6, 5, 7, 4, 3, NULL, NULL, '2024-02-07 23:21:08', '2024-02-28 01:36:22', '2024-02-28 01:36:22'),
(12, 2, 'pbene01', 'prueba', 'beneficios', 'beneficios@beneficios.com', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 2, '2024-02-09 20:00:00', '3', 'patients/HU5aESUxm9Y7MN0LNv1V8sefRtD2vr7Ez0x2IPhs.jpg', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 'beneficios', 1, 'beneficios', NULL, '2024-02-15 20:00:00', NULL, 'beneficios/beneficios', 'beneficios/beneficios', 'beneficios/beneficios', 'beneficios/beneficios', 'beneficios', 'beneficios', 'inactive', 'beneficios', '\"[{\\\"pa_assessment\\\":\\\"beneficios\\\",\\\"pa_assessment_start_date\\\":\\\"2024-02-09T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-02-15T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"beneficios2\\\",\\\"pa_services_start_date\\\":\\\"2024-02-16T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-02-15T04:00:00.000Z\\\",\\\"cpt\\\":\\\"H0032\\\",\\\"n_units\\\":\\\"beneficios\\\"},{\\\"pa_assessment\\\":\\\"asdsa\\\",\\\"pa_assessment_start_date\\\":\\\"2024-02-14T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-02-15T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"asd\\\",\\\"pa_services_start_date\\\":\\\"2024-02-21T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-02-22T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97156\\\",\\\"n_units\\\":23},{\\\"pa_assessment\\\":\\\"dsadas\\\",\\\"pa_assessment_start_date\\\":\\\"2024-02-07T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-02-14T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"asddas\\\",\\\"pa_services_start_date\\\":\\\"2024-02-06T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-02-29T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97157\\\",\\\"n_units\\\":33}]\"', NULL, 'beneficios', 'yes', 'requested', 'need new', 'requested', 'psycho eval', 'reviewing', 'need new', 'need new', 'psycho eval', 'need new', 'requested', 'pending', 6, 5, 4, 7, 1, NULL, NULL, '2024-02-09 01:52:19', '2024-02-28 01:36:17', '2024-02-28 01:36:17');
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

<<<<<<< HEAD
=======
--
-- Volcado de datos para la tabla `patient_files`
--

INSERT INTO `patient_files` (`id`, `patient_id`, `name_file`, `size`, `resolution`, `file`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cliente3243', '422441034_326433247058998_8423195820143934154_n.jpg', '40814', '517x540', 'patientFiles/H9vEKuHpZ16ldgQSItBU2qLyieM0nBiDzuOZvtfz.jpg', 'jpg', '2024-03-01 18:00:21', '2024-03-01 18:08:06', '2024-03-01 18:08:06'),
(2, 'cliente3243', 'bill_1611154.png', '17257', '512x512', 'patientFiles/Po4Gmi7nj5YBKqVfjTNOxEhGnjqK5ZBgBxL5wxuh.png', 'png', '2024-03-01 18:00:21', '2024-03-01 18:00:21', NULL),
(3, 'cliente3243', '422441034_326433247058998_8423195820143934154_n.jpg', '40814', '517x540', 'patientFiles/VRT7mFeFb4FxybLeTp4YCyqPFPRwewFvx1YfyzCx.jpg', 'jpg', '2024-03-01 18:02:30', '2024-04-24 18:03:16', '2024-04-24 18:03:16'),
(4, 'cliente3243', 'bill_1611154.png', '17257', '512x512', 'patientFiles/z9WTaewFuZuWuTjndFaEAWyrXXPXK2tiyVqr6C1D.png', 'png', '2024-03-01 18:02:30', '2024-03-01 18:02:30', NULL),
(5, 'cliente3243', 'logo-CSLDC.png', '57664', '1253x612', 'patientFiles/5Pv3NshBoUBYXX8T2ad2lLN9eE5wQlj9b7jWjBb0.png', 'png', '2024-03-02 18:57:50', '2024-03-02 18:59:04', '2024-03-02 18:59:04'),
(6, 'cliente3243', 'Screenshot 2024-02-24 at 11.16.09 AM.png', '34003', '261x384', 'patientFiles/JZmsM00sdaedekqxEZFUONjR28DBjd1FzYaENDUV.png', 'png', '2024-03-02 18:57:50', '2024-04-24 18:03:09', '2024-04-24 18:03:09'),
(7, 'cliente3243', 'Screenshot 2024-02-28 at 12.36.47 PM.png', '11846', '98x94', 'patientFiles/BsFgCvGFZig4USJvN47iLHJr7KPHk3L7Pdxa5tfG.png', 'png', '2024-03-02 18:57:50', '2024-03-02 18:57:50', NULL),
(8, 'cliente3243', 'dispatchtable.xml', '2824', NULL, 'patientFiles/AZ5TAjPYogO26oXOoxPZEJvwAqnAWCK5MiUZ7LVf.xml', 'xml', '2024-03-02 19:00:33', '2024-03-02 19:11:40', '2024-03-02 19:11:40'),
(9, 'cliente3243', 'dispatchtable.xml', '2824', NULL, 'patientFiles/4usIpL7h84qmnMwRGO2gFieKUhSeTSWhZQm7dUMA.xml', 'xml', '2024-03-02 19:01:01', '2024-03-02 19:11:38', '2024-03-02 19:11:38'),
(10, 'cliente3243', 'Checkout  BrandCrowd.pdf', '505714', NULL, 'patientFiles/iJhsv4XlV3dPEb1ZWhfVQTG3XFfGVXMlOa3eSBL2.pdf', 'pdf', '2024-03-02 19:01:01', '2024-04-24 18:02:59', '2024-04-24 18:02:59'),
(11, 'cliente3243', 'MercantilReferenciasBancarias.pdf', '65281', NULL, 'patientFiles/SX3hhF21f0hVFbVQWB6fK7SOkmCME8QQ6d11nUIn.pdf', 'pdf', '2024-03-03 04:02:07', '2024-04-24 18:02:15', '2024-04-24 18:02:15'),
(12, 'cliente3243', 'en-mantenimiento.png', '73998', '600x400', 'patientFiles/zav5BjqDLOXnyzDiTzFkFpZRrT4j0sdQerANvvO1.png', 'png', '2024-03-05 20:16:19', '2024-03-05 20:16:19', NULL);

>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'register_rol', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(2, 'list_rol', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(3, 'edit_rol', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(4, 'delete_rol', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(9, 'profile_doctor', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(10, 'register_patient', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(11, 'list_patient', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(12, 'edit_patient', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(13, 'delete_patient', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(14, 'profile_patient', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(19, 'register_appointment', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(20, 'list_appointment', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(21, 'edit_appointment', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(22, 'delete_appointment', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(27, 'show_payment', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(28, 'edit_payment', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(29, 'activitie', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(30, 'calendar', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(31, 'expense_report', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(32, 'invoice_report', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(33, 'settings', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(34, 'list_insurance', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(35, 'register_insurance', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(36, 'list_bip', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(37, 'register_bip', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(38, 'edit_bip', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(39, 'attention_bip', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(40, 'admin_dashboard', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(41, 'doctor_dashboard', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(42, 'client_dashboard', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(43, 'list_employers', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(44, 'register_employer', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(45, 'edit_employer', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(46, 'delete_employer', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(47, 'list_location', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(48, 'register_location', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(49, 'edit_location', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(50, 'edit_notebcba', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(51, 'list_notebcba', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(52, 'register_notebcba', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(53, 'view_bip', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(54, 'edit_noterbt', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(55, 'list_noterbt', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(56, 'register_noterbt', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(57, 'view_notebcba', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(58, 'view_noterbt', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(59, 'delete_noterbt', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(60, 'delete_notebcba', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(61, 'list_billing', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(62, 'list_patient_log_report', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reduction_goals`
--

CREATE TABLE `reduction_goals` (
  `id` bigint(20) NOT NULL,
  `maladaptive` varchar(255) DEFAULT NULL,
  `current_status` varchar(155) DEFAULT NULL,
  `patient_id` varchar(150) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED NOT NULL,
  `goalstos` json DEFAULT NULL,
  `goalltos` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reduction_goals`
--

INSERT INTO `reduction_goals` (`id`, `maladaptive`, `current_status`, `patient_id`, `client_id`, `bip_id`, `goalstos`, `goalltos`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 'test', 'test', 'test1', 1, 1, '[{\"sto\": \"test\", \"date_sto\": \"2024-07-12T04:00:00.000Z\", \"status_sto\": \"inprogress\", \"maladaptive\": \"test\", \"decription_sto\": \"test\", \"status_sto_edit\": \"inprogress\"}]', '[{\"lto\": \"test\", \"date_lto\": \"2024-07-12T04:00:00.000Z\", \"status_lto\": \"initiated\", \"decription_lto\": \"test\"}]', '2024-07-12 22:54:29', '2024-07-12 22:54:29', NULL),
(2, 'Physical aggression', '15 incidents per week', '985590391', 5, 2, '[{\"sto\": \"1\", \"date_sto\": \"2024-07-15T04:00:00.000Z\", \"status_sto\": \"inprogress\", \"maladaptive\": \"Physical aggression\", \"decription_sto\": \"dsa\", \"status_sto_edit\": \"inprogress\"}]', '[{\"lto\": \"lt022\", \"date_lto\": \"2024-07-16T04:00:00.000Z\", \"status_lto\": \"inprogress\", \"decription_lto\": \"test\"}]', '2024-07-15 20:39:11', '2024-07-15 20:39:11', NULL);
=======
(1, 'Negative Self talk', '15 incidents per week', 'cliente3243', 5, 1, '[{\"sto\": \"STO3\", \"date_sto\": \"2024-02-14T04:00:00.000Z\", \"status_sto\": \"inprogress\", \"maladaptive\": \"dasdsa\", \"decription_sto\": \"sdasa\", \"status_sto_edit\": \"mastered\"}, {\"sto\": \"1\", \"date_sto\": \"2024-02-13T04:00:00.000Z\", \"status_sto\": \"mastered\", \"maladaptive\": \"Negative Self talk\", \"decription_sto\": \"jghjgjhg\", \"status_sto_edit\": \"mastered\"}, {\"sto\": \"3\", \"date_sto\": \"2024-02-13T04:00:00.000Z\", \"status_sto\": \"on hold\", \"maladaptive\": \"Negative Self talk\", \"decription_sto\": \"asdas\", \"status_sto_edit\": \"discontinued\"}]', '[{\"lto\": \"23\", \"date_lto\": \"2024-02-14T04:00:00.000Z\", \"status_lto\": \"initiated\", \"decription_lto\": \"dasas\"}]', '2024-02-10 07:05:36', '2024-04-19 17:09:22', NULL),
(2, 'Negative Self talk', 'nuevo', 'cliente3', 6, 4, '[{\"sto\": \"1\", \"date_sto\": \"2024-05-02T04:00:00.000Z\", \"status_sto\": \"inprogress\", \"maladaptive\": \"Negative Self talk\", \"decription_sto\": \"dasdsa\", \"status_sto_edit\": \"inprogress\"}]', '[{\"lto\": \"l1\", \"date_lto\": \"2024-05-03T04:00:00.000Z\", \"status_lto\": \"inprogress\", \"decription_lto\": \"dasdas\"}]', '2024-05-03 03:56:44', '2024-05-03 03:56:58', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_clinicos`
--

CREATE TABLE `registro_clinicos` (
  `id` bigint(20) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `start_in` varchar(20) DEFAULT NULL,
  `end_out` varchar(20) DEFAULT NULL,
  `total_hour` varchar(20) DEFAULT NULL,
  `meet_client_at` enum('home','school','community','pending') NOT NULL DEFAULT 'pending',
  `client_appeared` enum('happy','sad','exited','tired','agresive','distracted','pending') NOT NULL DEFAULT 'pending',
  `as_evidenced_by` enum('pending','smilling at RBT','playing a game','whatching tv','running to greet RBT','scaping','talking to a friend') NOT NULL DEFAULT 'pending',
  `RBT_modeled_and_demostrate` enum('pending','redirection','premack principle','response block','behavioral momentum','DTT') NOT NULL DEFAULT 'pending',
  `responding_this_session_could` enum('pending','yes','no') DEFAULT 'pending',
  `progress_noted_this_session` enum('pending','excelent','good','moderate','minimal') NOT NULL DEFAULT 'pending',
  `client_response_to_treatment` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_atd` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `replacements`
--

CREATE TABLE `replacements` (
  `id` bigint(20) NOT NULL,
  `note_rbt_id` bigint(50) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(155) DEFAULT NULL,
  `goal` varchar(155) DEFAULT NULL,
  `total_trials` double DEFAULT NULL,
  `number_of_correct_response` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SUPERADMIN', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(2, 'MANAGER', 'api', '2023-12-01 04:09:47', '2024-01-26 05:05:33'),
<<<<<<< HEAD
=======
(6, 'LM', 'api', '2024-01-21 00:44:59', '2024-01-26 05:04:18'),
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
(7, 'BCBA', 'api', '2024-01-21 00:45:23', '2024-01-26 05:04:47'),
(8, 'RBT', 'api', '2024-01-21 00:45:41', '2024-01-26 05:04:57');

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
<<<<<<< HEAD
(10, 2),
(12, 2),
=======
(1, 2),
(2, 2),
(10, 2),
(11, 2),
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(40, 2),
<<<<<<< HEAD
(44, 2),
(45, 2),
=======
(43, 2),
(44, 2),
(45, 2),
(46, 2),
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(62, 2),
<<<<<<< HEAD
=======
(10, 6),
(11, 6),
(34, 6),
(35, 6),
(36, 6),
(37, 6),
(38, 6),
(40, 6),
(41, 6),
(43, 6),
(44, 6),
(47, 6),
(48, 6),
(49, 6),
(50, 6),
(51, 6),
(52, 6),
(53, 6),
(54, 6),
(55, 6),
(56, 6),
(57, 6),
(58, 6),
(59, 6),
(60, 6),
(62, 6),
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
(11, 7),
(37, 7),
(38, 7),
(41, 7),
(51, 7),
(52, 7),
(53, 7),
(55, 7),
(57, 7),
(58, 7),
(11, 8),
(41, 8),
(53, 8),
(55, 8),
(56, 8),
(58, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sustitution_goals`
--

CREATE TABLE `sustitution_goals` (
  `id` bigint(20) NOT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `current_status` varchar(155) DEFAULT NULL,
  `description` text,
  `patient_id` varchar(150) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED NOT NULL,
  `goalstos` json DEFAULT NULL,
  `goalltos` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sustitution_goals`
--

INSERT INTO `sustitution_goals` (`id`, `goal`, `current_status`, `description`, `patient_id`, `client_id`, `bip_id`, `goalstos`, `goalltos`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 'test', 'test', 'test', 'test1', NULL, 1, '[{\"sustitution_sto\": \"test\", \"initial_interesting\": \"test\", \"sustitution_date_sto\": \"2024-07-12T04:00:00.000Z\", \"sustitution_status_sto\": \"inprogress\", \"sustitution_decription_sto\": \"test\", \"sustitution_status_sto_edit\": \"inprogress\"}]', '[{\"sustitution_lto\": \"test\", \"sustitution_date_lto\": \"2024-07-12T04:00:00.000Z\", \"sustitution_status_lto\": \"inprogress\", \"sustitution_decription_lto\": \"test\"}]', '2024-07-12 22:55:00', '2024-07-12 22:55:00', NULL),
(2, 'Group goal', 'Average of 72% per week. (In progress STO 2) APR, 2024', 'description', '985590391', NULL, 2, '[{\"sustitution_sto\": \"2\", \"initial_interesting\": \"23\", \"sustitution_date_sto\": \"2024-07-15T04:00:00.000Z\", \"sustitution_status_sto\": \"inprogress\", \"sustitution_decription_sto\": \"STO2 Elnathan sits in a small group for 5 minutes without disruptive behavior or attempting to leave the group in 80% of trials, across 4 consecutive weeks.\", \"sustitution_status_sto_edit\": \"inprogress\"}]', '[{\"sustitution_lto\": \"lt01\", \"sustitution_date_lto\": \"2024-07-15T04:00:00.000Z\", \"sustitution_status_lto\": \"inprogress\", \"sustitution_decription_lto\": \"environmental changes\"}]', '2024-07-15 18:55:11', '2024-07-15 19:58:24', NULL);
=======
(1, 'nuuuuewvoo', 'ads', 'ads', 'cliente3243', 5, 1, '[{\"sustitution_sto\": \"dsa\", \"initial_interesting\": \"das\", \"sustitution_date_sto\": \"2024-05-02T04:00:00.000Z\", \"sustitution_status_sto\": \"initiated\", \"sustitution_decription_sto\": \"das\", \"sustitution_status_sto_edit\": \"initiated\"}]', '[{\"sustitution_lto\": \"dassad\", \"sustitution_date_lto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_lto\": \"initiated\", \"sustitution_decription_lto\": \"probando2\"}, {\"sustitution_lto\": \"adsdsa\", \"sustitution_date_lto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_lto\": \"initiated\", \"sustitution_decription_lto\": \"dasdas\"}, {\"sustitution_lto\": \"3\", \"sustitution_date_lto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_lto\": \"initiated\", \"sustitution_decription_lto\": \"new\"}]', '2024-02-21 20:33:54', '2024-05-03 06:14:14', NULL),
(2, 'new', 'new sustitution', 'new sust', 'cliente3243', 5, 1, '[{\"sustitution_sto\": \"1\", \"initial_interesting\": \"1\", \"sustitution_date_sto\": \"2024-02-22T04:00:00.000Z\", \"sustitution_status_sto\": \"inprogress\", \"sustitution_decription_sto\": \"adsdas\", \"sustitution_status_sto_edit\": \"inprogress\"}, {\"sustitution_sto\": \"1\", \"initial_interesting\": \"0\", \"sustitution_date_sto\": \"2024-02-22T04:00:00.000Z\", \"sustitution_status_sto\": \"inprogress\", \"sustitution_decription_sto\": \"dasdas\", \"sustitution_status_sto_edit\": \"inprogress\"}]', '[{\"sustitution_lto\": \"dassad\", \"sustitution_date_lto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_lto\": \"initiated\", \"sustitution_decription_lto\": \"probando2\"}, {\"sustitution_lto\": \"adsdsa\", \"sustitution_date_lto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_lto\": \"initiated\", \"sustitution_decription_lto\": \"dasdas\"}, {\"sustitution_lto\": \"3\", \"sustitution_date_lto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_lto\": \"initiated\", \"sustitution_decription_lto\": \"new\"}]', '2024-02-22 19:27:29', '2024-02-22 19:27:29', NULL),
(3, 'nuevo', 'nuevo', 'nuevo', 'cliente3243', 5, 1, '[{\"sustitution_sto\": \"nuevo\", \"initial_interesting\": \"nuevo\", \"sustitution_date_sto\": \"2024-02-22T04:00:00.000Z\", \"sustitution_status_sto\": \"mastered\", \"sustitution_decription_sto\": \"nuevo\", \"sustitution_status_sto_edit\": \"mastered\"}]', '[{\"sustitution_lto\": \"nuevo\", \"sustitution_date_lto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_lto\": \"initiated\", \"sustitution_decription_lto\": \"nuevo\"}]', '2024-02-22 19:39:32', '2024-02-22 19:39:32', NULL),
(4, 'dasads', 'ads', 'das', 'cliente3243', 5, 1, '[{\"sustitution_sto\": \"1\", \"initial_interesting\": \"ads\", \"sustitution_date_sto\": \"2024-02-23T04:00:00.000Z\", \"sustitution_status_sto\": \"initiated\", \"sustitution_decription_sto\": \"ads\", \"sustitution_status_sto_edit\": \"inprogress\"}]', '[{\"sustitution_lto\": \"adsdas\", \"sustitution_date_lto\": \"2024-02-15T04:00:00.000Z\", \"sustitution_status_lto\": \"on hold\", \"sustitution_decription_lto\": \"dasdas\"}]', '2024-02-23 04:13:08', '2024-02-23 04:13:08', NULL),
(5, 'prueba nueva', 'probando', 'probando', 'cliente3243', 5, 1, '[{\"sustitution_sto\": \"1\", \"initial_interesting\": \"nuevo\", \"sustitution_date_sto\": \"2024-02-27T04:00:00.000Z\", \"sustitution_status_sto\": \"inprogress\", \"sustitution_decription_sto\": \"sad\", \"sustitution_status_sto_edit\": \"inprogress\"}]', '[{\"sustitution_lto\": \"21\", \"sustitution_date_lto\": \"2024-02-20T04:00:00.000Z\", \"sustitution_status_lto\": \"on hold\", \"sustitution_decription_lto\": \"dasdas\"}]', '2024-02-25 18:51:19', '2024-02-25 18:51:19', NULL),
(6, 'Skill Adqusitions', 'repeat every 15 times', 'dsadsa', 'asd234', 7, 3, '[{\"sustitution_sto\": \"1\", \"initial_interesting\": \"15\", \"sustitution_date_sto\": \"2024-03-01T04:00:00.000Z\", \"sustitution_status_sto\": \"inprogress\", \"sustitution_decription_sto\": \"dasdas\", \"sustitution_status_sto_edit\": \"inprogress\"}]', '[{\"sustitution_lto\": \"1\", \"sustitution_date_lto\": \"2024-03-01T04:00:00.000Z\", \"sustitution_status_lto\": \"inprogress\", \"sustitution_decription_lto\": \"sadsa\"}]', '2024-03-01 20:05:01', '2024-03-01 20:05:01', NULL),
(7, 'replac', 'das', 'dsads', 'cliente3', NULL, 4, '[{\"sustitution_sto\": \"1\", \"initial_interesting\": \"2\", \"sustitution_date_sto\": \"2024-05-08T04:00:00.000Z\", \"sustitution_status_sto\": \"inprogress\", \"sustitution_decription_sto\": \"das\", \"sustitution_status_sto_edit\": \"inprogress\"}]', '[{\"sustitution_lto\": \"das\", \"sustitution_date_lto\": \"2024-05-08T04:00:00.000Z\", \"sustitution_status_lto\": \"inprogress\", \"sustitution_decription_lto\": \"sa\"}]', '2024-05-08 22:29:27', '2024-05-08 22:29:27', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
<<<<<<< HEAD
  `birth_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
=======
  `birth_date` timestamp NULL DEFAULT NULL,
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
  `gender` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1:masculino,2:femenino',
  `address` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('inactive','active','black list','incoming') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `currently_pay_through_company` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `llc` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ien` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wc` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `electronic_signature` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `languages` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ss_number` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
<<<<<<< HEAD
  `date_of_hire` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `start_pay` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `driver_license_expiration` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
=======
  `date_of_hire` timestamp NULL DEFAULT NULL,
  `start_pay` timestamp NULL DEFAULT NULL,
  `driver_license_expiration` timestamp NULL DEFAULT NULL,
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
  `cpr_every_2_years` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_every_5_years` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e_verify` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_sex_offender_registry` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bacb_license_expiration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `liability_insurance_annually` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `local_police_rec_every_5_years` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medicaid_provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ceu_hippa_annually` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ceu_domestic_violence_no_expiration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ceu_security_awareness_annually` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ceu_zero_tolerance_every_3_years` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ceu_hiv_bloodborne_pathogens_infection_control_no_expiration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ceu_civil_rights_no_expiration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `w_9_w_4_form` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_four_week_notice_agreement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credentialing_package_bcbas_only` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caqh_bcbas_only` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_type` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` double DEFAULT NULL,
  `location_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `surname`, `phone`, `birth_date`, `gender`, `address`, `avatar`, `status`, `currently_pay_through_company`, `llc`, `ien`, `wc`, `electronic_signature`, `agency_location`, `city`, `languages`, `ss_number`, `date_of_hire`, `start_pay`, `driver_license_expiration`, `cpr_every_2_years`, `background_every_5_years`, `e_verify`, `national_sex_offender_registry`, `certificate_number`, `bacb_license_expiration`, `liability_insurance_annually`, `local_police_rec_every_5_years`, `npi`, `medicaid_provider`, `ceu_hippa_annually`, `ceu_domestic_violence_no_expiration`, `ceu_security_awareness_annually`, `ceu_zero_tolerance_every_3_years`, `ceu_hiv_bloodborne_pathogens_infection_control_no_expiration`, `ceu_civil_rights_no_expiration`, `school_badge`, `w_9_w_4_form`, `contract`, `two_four_week_notice_agreement`, `credentialing_package_bcbas_only`, `caqh_bcbas_only`, `contract_type`, `salary`, `location_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
<<<<<<< HEAD
(1, 'superadmin', 'superadmin@superadmin.com', 'admin', '123456', '2024-07-13 08:00:00', 1, 'superadmin', 'staffs/0WDp9hkgEOn6lIlBYWJk8Fp1zJp8EjcDurJykZ02.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-11-30 03:32:36', '$2y$10$PiKCOHK3XOBlqiL0kgJwLOMILMA6uVAAS1ou7JqHsUQaH4yvPkAiC', 'guHmnxhKw1', '2023-11-30 03:32:36', '2024-07-13 20:19:01', NULL),
(2, 'rbt', 'rbt@rbt.com', 'rbt', '1234', '2024-07-10 08:00:00', 1, 'rbtTest', 'staffs/UWPksDTl4w3WAwK2xn6psDeOouWMp8JN4pUrfezP.jpg', 'active', 'adsdas', 'dasdas', 'dasdas', 'dasda', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 'asdsa', 'dasdsa', 'dasdas', 'dsaads', '2024-07-03 08:00:00', '2024-07-05 08:00:00', '2024-07-01 08:00:00', 'adsdas', 'dsaads', 'dasdsa', 'dasads', 'adsdsa', '2024-07-16 04:00:00', 'das', 'dsa', 'das', 'das', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$WNQnt/C6LBVGAEcszgQXVevXVYz5cuR97sn5kKVtRglvuajRl8Bza', NULL, '2024-07-10 15:07:09', '2024-07-12 19:19:33', NULL),
(3, 'Manager', 'manager@manager.com', 'test', '1234', '2024-07-10 16:00:00', 1, 'rbtTest', 'staffs/wSHU4JbdabycHYWvc7zpVhM1Lfqhexs9g1adaDuZ.jpg', 'active', 'dasads', 'dasdas', 'dasda', 'dasda', 'signatures/qA0V6xTZ08eRFO5h37RjUHw2ZFmLDa8O17hTCZlt.jpg', 'adsdsa', 'asddas', 'dasdsa', 'dasads', '2024-07-10 16:00:00', '2024-07-11 16:00:00', '2024-07-12 16:00:00', 'adsds', 'dsads', 'dasa', 'dsaads', 'dsadas', '2024-07-11 12:00:00', 'adsads', 'dasd', 'dasdas', 'dasdas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$Pbr6xo2DJqDlCMdBEti63uZhvQ14g8EvSG.wRMyr.lLe9X1x5A/fi', NULL, '2024-07-10 15:16:37', '2024-07-13 19:58:23', NULL),
(4, 'BCBA', 'bcba@bcba.com', 'Doctor', '1234', '2024-07-13 16:00:00', 1, 'BCBA', 'staffs/J4r31sinY8k2ZgS5whghwwfqIU0nI7rUd8tSsioN.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$gXnnzOyl96XHb3H3TLJl3OfVN8cvv8QrjrqS4C.ImNGPC7FyymbmW', NULL, '2024-07-13 21:28:19', '2024-07-13 21:28:32', NULL),
(5, 'Maria Eugenia', 'apontemariae@gmail.com', 'Aponte', '+584122070144', '2024-01-10 16:00:00', 2, 'rbt address', 'staffs/mfSN3ItHhmfR5yHlXCt4ev2RVsq7Nkjh1cXJHQzx.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$lMrAQWyh8bwLkzOpGpWG.OriH/g2ojRv4jqH2hHxdz0WBdNcs4azK', NULL, '2024-07-14 19:54:02', '2024-07-15 15:46:23', NULL),
(20, 'Alain', 'alain@practice-mgmt.com', 'Hernandez', '2397101864', '2024-03-11 16:00:00', 1, 'practice', 'staffs/UTdbNKIGcSCrz6ebu6Cw3CyVD3poSrgOP9boeoKD.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$JBxZiOyc2pgf.g64aAk5q.pRD7idPuiNIFg0tJ94DV.ct2VZ8dMr6', NULL, '2024-07-15 15:12:44', '2024-07-15 15:46:19', NULL),
(21, 'Amber', 'manager@practice-mgmt.com', 'McKinney', '1234567', NULL, 2, NULL, 'staffs/xtrgFxGv1yVGjkM2cIWeaHPUmJIymhF1AG97V8NM.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$m3/lzx9kQTVZR//Oye9wVeYT4ckyGbn2mbU6qi9JGu6j9Z5I8jyXe', NULL, '2024-07-15 15:14:40', '2024-07-15 15:46:15', NULL),
(22, 'Michelle', 'michelleguimoye@gmail.com', 'Guimoye', '239-634-9514', NULL, 2, 'Fort Myers', 'staffs/W4U8U0eP5QiU8vHDVE6ioe2MdNiWVmAm1VC8EUNW.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$1TYYepA8eBgn7Qvus2VHlOGcJ9V4Bn8dEqla/ro9NvKpElkbgLXr.', NULL, '2024-07-15 15:16:20', '2024-07-15 15:46:11', NULL),
(23, 'Guyvenel', 'dumeusguyvenel@gmail.com', 'Dumeus', '239-823-3543', '2002-12-08 08:00:00', 1, 'Lehigh Acres', 'staffs/Id1P8mgpUVNAoxK6iDAtfYVM56bmgwQFGbC0waxw.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/gW9ap1aVO6VHLPXdWFWf6qvyl5sQwIkEeW8OwisA.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$2CcXCUPT1yWanvbc8Vhih.EJaZjTVVMzNx8N7lKPiSUIVNh0jqIZC', NULL, '2024-07-15 15:17:44', '2024-07-15 17:08:07', NULL),
(24, 'Allan', 'allan@practice-mgmt.com', 'Hernandez', '239-922-7513', '2000-01-26 16:00:00', 1, NULL, 'staffs/aPN7U8wARTz1ZX5VHpIWWVMRtWGDXGvnbSXBR9vc.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/YKollL7CET3M2UnPruoibcA0oscUSIYTrBRUbOdR.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$7DoznKeL5FAVhrjHMLNxr.wwyldkAVBVlxz1jZIlPXMtRdjVGnPbm', NULL, '2024-07-15 15:18:50', '2024-07-15 17:08:25', NULL),
(25, 'Mary', 'pinskeraba@gmail', 'Pinsker', '757-403-9287', '1970-10-19 16:00:00', 2, 'Telehealth', 'staffs/chCKVFPaXSXlQXVhDzBg6pYvR4Jyeo6abM1IUF6U.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$3XsIrXTl/Q7NxPf2V.ydxuNeFHj0euHCnOFzAj85eGMjQE/c6PO7q', NULL, '2024-07-15 15:21:03', '2024-07-15 17:08:42', NULL),
(26, 'Sucel', 'suceltejeda@yahoo.com', 'Tejeda', '2396286999', '2024-04-30 16:00:00', 2, '6660 Estero Blvd', 'staffs/1z543G2aNf1UgWNgrcyTFOPOu0KRadY6c9UHaJC3.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/CJEhvzn17gCPfT5lU1FqgcYlqWWZ7yLNpJyziX61.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$f6xZ606zJlDTVf6lUFIGRuBVUhLQjlBXyRo5OwQRZg57pnQahHuQ.', NULL, '2024-07-15 15:22:20', '2024-07-15 17:10:57', NULL),
(27, 'Christopher', 'mompremierchris@yahoo.com', 'Mompremier', '239-745-9812', '2000-04-12 16:00:00', 1, 'Lehigh Acres', 'staffs/jPlW4yGcgskfRxlpwHgztUTPMt7CGa2TIuyAzap4.jpg', 'active', 'ABA', 'LLCMC01', 'IENCM01', 'WCCM01', 'signatures/Imv4s9iergIUgNdDURPSDhrPzmzW7k0XTKbiO2om.jpg', 'Florida', 'Miami', NULL, 'SSNCM01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NPI001', 'MIDPCM01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$5AXLlp09kdHLfHTlf51phOfGFO5lrEqxtepcnHQsJs4A.IsDoSKJC', NULL, '2024-07-15 15:24:06', '2024-07-15 17:09:17', NULL),
(28, 'Allan Hernandez', 'allan@yahoo.com', 'hernz', '305-519-5627', '2000-06-25 16:00:00', 1, 'lehigh', 'staffs/ENGVgG40fYvL9cI8LsIIWdVDb8F3gPbNMyeridTF.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/Epx3YjVZkGb3eLg7Z02aBdZ4hS5NOSRfzofIvUWF.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$WODbALs2zBMNFgfAF//jcuJzt2I23GMv9RULxoo.ygD/fG6KLSM.W', NULL, '2024-07-15 15:25:36', '2024-07-15 17:09:33', NULL);
=======
(1, 'superadmin', 'superadmin@superadmin.com', NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2023-11-30 03:32:36', '$2y$10$PiKCOHK3XOBlqiL0kgJwLOMILMA6uVAAS1ou7JqHsUQaH4yvPkAiC', 'guHmnxhKw1', '2023-11-30 03:32:36', '2024-01-26 01:15:51', NULL),
(2, 'Admin', 'manager@manager.com', 'Manager', '123456', '2024-01-25 08:00:00', 1, 'password', 'staffs/GD822KW6hiHyuUc1UwE9ivVYKabchXFRD1prrbWU.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01 08:00:00', '1970-01-01 08:00:00', '1970-01-01 08:00:00', NULL, NULL, NULL, NULL, NULL, '1970-01-01 04:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, '$2y$10$J.xrQxVNuuyRzUJTUlyRo.LlbH5iS4q/xXj2U4TSBfFgUN0eggxDm', NULL, '2024-01-26 01:13:28', '2024-05-02 20:45:29', NULL),
(3, 'Tecnico', 'lm@lm.com', 'Doctor', '123456', '2024-01-25 08:00:00', 1, 'password', 'staffs/Pl2UMCjwRhHu4zBgsnLfMeVm4jlTd0FJLPNDldVF.jpg', 'active', 'dsaads', 'adsdsa', 'dsaad', 'adsdas', NULL, 'dasdsad', 'asdas', 'dasdas, adsdsa', 'adsdsa', '2024-01-25 08:00:00', '2024-01-30 08:00:00', '2030-07-26 08:00:00', 'asddas', 'dasadsd', 'asdas', 'dasads', 'dsaads', '2026-01-22 04:00:00', 'dsadas', 'dasdas', 'dasads', 'dasdas', 'dsadas', 'yes', 'dasads', 'ads', 'yes', 'dsadas', 'yes', 'no', 'yes', 'no', 'asddas', 'dsadsa', '1099', 2000, '1', NULL, '$2y$10$o2ryvSNtIs4XF4hMdknbsuWddszIzt2Yv1ldiGFmlQKjU1TX6zbZ6', NULL, '2024-01-26 01:17:03', '2024-04-30 01:43:00', NULL),
(4, 'Doctor', 'bcba@bcba.com', 'Bcba', '123456', '2024-01-25 08:00:00', 1, 'dsadas', 'staffs/Dcd55CrAdW07MAzSPAAzIi2dTjOr6335hqULDLZ3.jpg', 'active', 'dasda', '34das', 'das', 'ads', 'signatures/cQPbBJVUwN0mPKL63DKhVPwk79c403Uft2zQmCMG.png', 'dasdsa', 'Caracas', 'Spanish', 'as3ds23', '2030-11-20 08:00:00', '1981-11-18 08:00:00', '1970-01-01 08:00:00', 'das', 'das', 'das', 'dsa', 'dsadas', '1970-01-01 04:00:00', 'das', 'das', 'dsa', 'dads', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, '$2y$10$nBs3RhKzpnMrN6NVJyc8FeIPjKtfQ6CNm63LM5KTsgt8XkbBsk4ma', NULL, '2024-01-26 01:17:55', '2024-04-25 17:43:13', NULL),
(5, 'doctor', 'rbt@rbt.com', 'Rbt', '123456', '2024-01-25 08:00:00', 1, 'dsaads', 'staffs/FjvzOfyEHu0BUHPh47dUlSvY6a3Iq2ynw72fYg27.jpg', 'active', 'prueba4', 'prueba4', 'prueba4', 'prueba4', 'signatures/IH4OSBcc08OllVTmJoe03H2ZvISa0PQU0x9HRvRn.png', 'prueba4', 'prueba4', 'prueba4, prueba4', 'prueba4', '1970-01-01 08:00:00', '1970-01-01 08:00:00', '1970-01-01 08:00:00', 'das', 'dadd', 'dasdsa', 'dasdas', 'dasdas', '1970-01-01 04:00:00', 'dasdas', 'dasdasd', 'asdas', 'dasdas', 'dasdas', 'yes', 'dasdas', 'dasdas', 'yes', 'pruebadoc', 'yes', 'yes', 'yes', 'yes', 'pruebadoc', 'ads', 'w2', 3232, '1', NULL, '$2y$10$AqWsXXBRL7G7BhWRq003FOKssAZDC/1IiUpWBNtLRIMn2kZv2aqq6', NULL, '2024-01-26 01:18:43', '2024-05-02 20:54:24', NULL),
(6, 'Maria Eugenia', 'apontemariae@gmail.com', 'Aponte', '+584122070144', '2024-01-10 08:00:00', 2, 'password', 'staffs/ASwfVkibzUsk1wMC2gLjiA9mnvALZQhGvvV9dAQx.jpg', 'active', 'dasadsda', 'sdas', 'dsadasd', 'asdas', 'signatures/V2yhKQKcmOO0G6rl53UkgmG3nFiwuQo1cf0YXyeF.png', 'dasdas', 'dsadsa', 'dasdasd', 'dasdas', '1970-01-01 08:00:00', '1970-01-01 08:00:00', '1970-01-01 08:00:00', 'asddsad', 'asasdd', 'saasd', 'dasads', 'dsadasd', '1970-01-01 04:00:00', 'saads', 'dsaads', 'NP!12345', 'adsasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1', NULL, '$2y$10$iQXEaPVP8pIgKaZW3H8ZZOG1i1xQTh1A4KrcNLhL60L3MsSI2qJEG', NULL, '2024-01-31 02:27:09', '2024-05-03 18:02:12', NULL),
(7, 'Alain', 'alain@practice-mgmt.com', 'Hernandez', '2397101864', '2024-03-11 08:00:00', 1, 'practice', 'staffs/FOGkEZ9zzZomAiImY3E7UkTewjlRrMSwKU6EtQoM.jpg', 'active', 'das', 'das', 'ads', 'prueba', 'signatures/L01TFo3jAVTG9OThbFdIr7FFYRTDYnTmKF7zNe14.png', NULL, 'asd', 'dasdsa', NULL, '1970-01-01 08:00:00', '1970-01-01 08:00:00', '1970-01-01 08:00:00', 'das', 'das', 'das', 'dsa', 'dasd', '1970-01-01 04:00:00', 'dasda', 'dasad', 'dad', 'dasd', 'das', 'yes', 'das', 'ads', 'yes', 'adsdas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1,3', NULL, '$2y$10$NnOEBxaztsMzzwCmVkNyr.MNhYhWCH.9d7TTywz35Rfi876.T6vzS', NULL, '2024-01-31 02:29:13', '2024-04-25 17:41:54', NULL),
(15, 'Malcolm', 'mercadocreativo@gmail.com', 'Cordova', '04241874370', '2024-03-23 08:00:00', 1, 'caracas\r\ncaracas', 'staffs/R2JK5ODul3XHyI51TuqJnDL00pqRrPx3f4lfQkSg.jpg', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1970-01-01 08:00:00', '1970-01-01 08:00:00', '1970-01-01 08:00:00', NULL, NULL, NULL, NULL, NULL, '1970-01-01 04:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2', NULL, '$2y$10$o74kHFMa4yMAWYV6sbV.9ezmmcQlnBuSooH8ObRQcMtmmi7Qf9FmG', NULL, '2024-03-23 19:14:31', '2024-04-25 23:30:18', NULL),
(16, 'Sucel', 'suceltejeda@yahoo.com', 'Tejeda', '2396286999', '2024-04-30 16:00:00', 2, '6660 Estero Blvd', 'staffs/0DawoTj9QwqIha2fftxAHkDe2UE8blHkPK8vval2.jpg', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '3', NULL, '$2y$10$lUWTfZTVZd5mPDWjf/lgVeL8zkEsXKBO1MiXcBtZ2sP.vZGdYyz.G', NULL, '2024-04-30 23:56:11', '2024-04-30 23:56:11', NULL),
(17, 'Amber', 'manager@practice-mgmt.com', 'McKinney', '1234567', NULL, 2, NULL, 'staffs/IbFHhY2decWls4fWcpYX47nLgptkNVxjG1BJ1cwB.jpg', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2', NULL, '$2y$10$NUiTqRHQnHILw9hDv.sdle2/Pa265zUf1CmBsVFebVmzYgvEZ8IRq', NULL, '2024-04-30 23:57:26', '2024-04-30 23:57:26', NULL);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_locations`
--

CREATE TABLE `user_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
<<<<<<< HEAD
-- Volcado de datos para la tabla `user_locations`
--

INSERT INTO `user_locations` (`id`, `user_id`, `location_id`) VALUES
(14, 2, 4),
(15, 2, 5),
(23, 3, 4),
(27, 1, 4),
(28, 1, 5),
(29, 4, 4),
(30, 4, 5),
(46, 5, 4),
(47, 20, 1),
(48, 20, 2),
(49, 20, 3),
(50, 20, 4),
(51, 20, 5),
(52, 20, 6),
(53, 21, 3),
(54, 22, 3),
(106, 23, 2),
(107, 24, 1),
(108, 24, 2),
(109, 24, 3),
(110, 24, 4),
(111, 24, 5),
(112, 24, 6),
(113, 25, 2),
(120, 27, 3),
(121, 28, 1),
(122, 28, 2),
(123, 28, 3),
(124, 28, 4),
(125, 28, 5),
(126, 28, 6),
(133, 26, 1),
(134, 26, 2),
(135, 26, 3),
(136, 26, 4),
(137, 26, 5),
(138, 26, 6);

--
=======
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bips`
--
ALTER TABLE `bips`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `client_reports`
--
ALTER TABLE `client_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consent_to_treatments`
--
ALTER TABLE `consent_to_treatments`
  ADD PRIMARY KEY (`id`);

--
<<<<<<< HEAD
=======
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
-- Indices de la tabla `crisis_plans`
--
ALTER TABLE `crisis_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `de_escalation_techniques`
--
ALTER TABLE `de_escalation_techniques`
  ADD PRIMARY KEY (`id`);

--
<<<<<<< HEAD
=======
-- Indices de la tabla `doctor_schedule_hours`
--
ALTER TABLE `doctor_schedule_hours`
  ADD PRIMARY KEY (`id`);

--
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `family_envolments`
--
ALTER TABLE `family_envolments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `generalization_trainings`
--
ALTER TABLE `generalization_trainings`
  ADD PRIMARY KEY (`id`);

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
<<<<<<< HEAD
=======
-- Indices de la tabla `maladaptives`
--
ALTER TABLE `maladaptives`
  ADD PRIMARY KEY (`id`);

--
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `note_bcbas`
--
ALTER TABLE `note_bcbas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `note_rbts`
--
ALTER TABLE `note_rbts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `patient_files`
--
ALTER TABLE `patient_files`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
<<<<<<< HEAD
=======
-- Indices de la tabla `registro_clinicos`
--
ALTER TABLE `registro_clinicos`
  ADD PRIMARY KEY (`id`);

--
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
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
  ADD PRIMARY KEY (`id`);

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
<<<<<<< HEAD
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_locations_user_id_foreign` (`user_id`),
  ADD KEY `user_locations_location_id_foreign` (`location_id`);
=======
  ADD PRIMARY KEY (`id`);
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `billings`
--
ALTER TABLE `billings`
<<<<<<< HEAD
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
=======
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `bips`
--
ALTER TABLE `bips`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `client_reports`
--
ALTER TABLE `client_reports`
<<<<<<< HEAD
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
=======
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `consent_to_treatments`
--
ALTER TABLE `consent_to_treatments`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `crisis_plans`
--
ALTER TABLE `crisis_plans`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `de_escalation_techniques`
--
ALTER TABLE `de_escalation_techniques`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `doctor_schedule_hours`
--
ALTER TABLE `doctor_schedule_hours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `family_envolments`
--
ALTER TABLE `family_envolments`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `generalization_trainings`
--
ALTER TABLE `generalization_trainings`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
<<<<<<< HEAD
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
=======
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `maladaptives`
--
ALTER TABLE `maladaptives`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `monitoring_evaluatings`
--
ALTER TABLE `monitoring_evaluatings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `note_bcbas`
--
ALTER TABLE `note_bcbas`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `note_rbts`
--
ALTER TABLE `note_rbts`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `patients`
--
ALTER TABLE `patients`
<<<<<<< HEAD
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `patient_files`
--
ALTER TABLE `patient_files`
<<<<<<< HEAD
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
=======
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
<<<<<<< HEAD
=======
-- AUTO_INCREMENT de la tabla `registro_clinicos`
--
ALTER TABLE `registro_clinicos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `sustitution_goals`
--
ALTER TABLE `sustitution_goals`
<<<<<<< HEAD
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
<<<<<<< HEAD
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
=======
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- AUTO_INCREMENT de la tabla `user_locations`
--
ALTER TABLE `user_locations`
<<<<<<< HEAD
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
=======
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6

--
-- Restricciones para tablas volcadas
--

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
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
<<<<<<< HEAD

--
-- Filtros para la tabla `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `user_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
=======
COMMIT;

ALTER TABLE `user_locations`
  ADD CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;
>>>>>>> 9b62d24237c89e188573e548b26fa09827c71bb6
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
