-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-09-2024 a las 22:08:31
-- Versión del servidor: 10.6.18-MariaDB-cll-lve
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `billings`
--

INSERT INTO `billings` (`id`, `patient_id`, `sponsor_id`, `cpt_code`, `insurer_id`, `insurer_rate`, `date`, `total_hours`, `total_units`, `billing_total`, `week_total_hours`, `week_total_units`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test1', 1, NULL, NULL, NULL, '2024-07-12 16:00:00', '20:00:00', NULL, NULL, NULL, NULL, '2024-07-12 23:05:00', '2024-07-12 23:05:00', NULL),
(2, 'test1', 1, NULL, NULL, NULL, '2024-07-13 16:00:00', '17:00:00', NULL, NULL, NULL, NULL, '2024-07-12 23:06:30', '2024-07-12 23:06:30', NULL),
(3, 'test1', 1, NULL, NULL, NULL, '2024-07-13 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-13 23:41:26', '2024-07-13 23:41:26', NULL),
(4, '985590391', 1, NULL, NULL, NULL, '2024-07-16 16:00:00', '18:00:00', NULL, NULL, NULL, NULL, '2024-07-15 18:56:41', '2024-07-15 18:56:41', NULL),
(5, '985590391', 27, NULL, NULL, NULL, '2024-07-15 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-15 20:26:33', '2024-07-15 20:26:33', NULL),
(6, '985590391', 27, NULL, NULL, NULL, '2024-07-16 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-15 20:28:21', '2024-07-15 20:28:21', NULL),
(7, '985590391', 1, NULL, NULL, NULL, NULL, '00:00:00', NULL, NULL, NULL, NULL, '2024-07-20 20:19:31', '2024-07-20 20:19:31', NULL),
(8, 'test1', 1, NULL, NULL, NULL, '2024-07-20 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-20 22:40:01', '2024-07-20 22:40:01', NULL),
(9, 'test1', 1, NULL, NULL, NULL, '2024-07-21 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-20 22:49:51', '2024-07-20 22:49:51', NULL),
(10, 'test1', 1, NULL, NULL, NULL, '2024-07-23 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-21 00:13:19', '2024-07-21 00:13:19', NULL),
(11, '985590391', 1, NULL, NULL, NULL, '2024-07-24 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-24 18:06:16', '2024-07-24 18:06:16', NULL),
(12, 'test1', 1, NULL, NULL, NULL, '2024-07-24 16:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-07-24 18:47:04', '2024-07-24 18:47:04', NULL),
(13, '985590391', 1, NULL, NULL, NULL, '2024-08-16 19:00:00', '19:00:00', NULL, NULL, NULL, NULL, '2024-08-17 00:39:37', '2024-08-17 00:39:37', NULL),
(14, '985590391', 12, NULL, NULL, NULL, '2024-08-12 19:00:00', '15:00:00', NULL, NULL, NULL, NULL, '2024-08-17 04:27:47', '2024-08-17 04:27:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bips`
--

CREATE TABLE `bips` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_of_assessment` tinyint(1) DEFAULT 3 COMMENT '1:Assessment,2:Reassessment, 3:Initial',
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
  `tangibles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tangibles`)),
  `sensory` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`sensory`)),
  `escape` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`escape`)),
  `attention` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`attention`)),
  `hypothesis_based_intervention` text DEFAULT NULL,
  `interventions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`interventions`)),
  `reduction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `bips`
--

INSERT INTO `bips` (`id`, `client_id`, `patient_id`, `doctor_id`, `type_of_assessment`, `documents_reviewed`, `background_information`, `previus_treatment_and_result`, `current_treatment_and_progress`, `education_status`, `phisical_and_medical_status`, `strengths`, `weakneses`, `phiysical_and_medical`, `phiysical_and_medical_status`, `maladaptives`, `assestment_conducted`, `assestment_conducted_options`, `assestmentEvaluationSettings`, `prevalent_setting_event_and_atecedents`, `tangibles`, `sensory`, `escape`, `attention`, `hypothesis_based_intervention`, `interventions`, `reduction_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, 1, '[{\"document_title\":\"test\",\"document_status\":\"yes\"}]', 'test', 'test', 'test', 'test', 'test', 'actualizado', 'actualizadoss', 'sadasd', '[{\"dose\":\"das das\",\"reason\":\"dsadasd \\ndasdsa\",\"frecuency\":\"dasdasdas\",\"medication\":\"sadsa\",\"preescribing_physician\":\"dsadas\"}]', '[{\"baseline_date\":\"2024-07-12T04:00:00.000Z\",\"baseline_level\":\"24\",\"initial_interesting\":12,\"maladaptive_behavior\":\"test\",\"topografical_definition\":\"testdsd teslts asd\"}]', 'test', '[{\"assestment_title\":\"test\",\"assestment_status\":\"pending\"}]', '[{\"other\":\"das\",\"tangible\":\"ads\",\"activities\":\"das\"},{\"other\":\"dsadasdas\",\"tangible\":\"dsaasd\",\"activities\":\"dasdasdas\"}]', '[{\"behavior\":\"test\",\"hypothesized_functions\":\"test\",\"prevalent_setting_event_and_atecedent\":\"test\"}]', '[{\"manager_strategies\":\"dsa\",\"replacement_skills\":\"dsadas\",\"preventive_strategies\":\"adsdsa\"}]', '[{\"preventive_strategies_s\":\"Access to Sensory Activities\",\"replacement_skills_s\":\"Access to Sensory Activities\",\"manager_strategies_s\":\"Access to Sensory Activities\"}]', '[{\"preventive_strategies_e\":\"Access to Escape Activities\",\"replacement_skills_e\":\"Access to Escape Activities\",\"manager_strategies_e\":\"Access to Escape Activities\"}]', '[{\"preventive_strategies_a\":\"Access to Attention Activities\",\"replacement_skills_a\":\"Access to Attention Activities\",\"manager_strategies_a\":\"Access to Attention Activities\"}]', 'ads', '[{\"index\":1,\"titleIntervention\":\"Escape Extin\",\"descriptionIntervention\":\"ysical guidance (gently placing hand on her back and or hand over hand) will be used so that Client will not be able to escape from the demand or task. Regardless of how long Client engages in these behaviors caregivers will continue to\",\"nombre\":\"Nuevo nombre\"}]', NULL, '2024-07-13 05:53:21', '2024-09-03 02:44:02', NULL),
(2, 5, '985590391', 13, 2, '[{\"document_title\":\"MNL\",\"document_status\":\"yes\"},{\"document_title\":\"Inital Assessment\",\"document_status\":\"yes\"},{\"document_title\":\"Vineland-3\",\"document_status\":\"yes\"},{\"document_title\":\"IEP\",\"document_status\":\"yes\"},{\"document_title\":\"Doctor Referral\",\"document_status\":\"yes\"},{\"document_title\":\"Doctors Notes\",\"document_status\":\"yes\"},{\"document_title\":\"PSYCHOLOGICAL EVALUATION\",\"document_status\":\"yes\"},{\"document_title\":\"Comprehensive Development Assessment (CDE)\",\"document_status\":\"yes\"},{\"document_title\":\"Autism Diagnostice Observation Schedule (ADOS)\",\"document_status\":\"yes\"}]', '-Elnathan is a 6-year old male who has a diagnosis of Autism Spectrum disorder. He lives with his mother, father and 4-year-old brother. He was born in Ethiopia and came to the USA in 2019. In the home the primary language is Amharic, however Elnathan’s’ father speaks English and states that Elnathan understands both languages. He was referred for ABA therapy by Dr. Heather Pittman in 6/19/2023 due to challenging behaviors that interfere with his daily functioning, learning from others and prevent full integration in school/community/family life. An ADOS test was conducted on April 2023 at Golisano Children’s Hospital, results show moderate to severe signs of autism spectrum related symptoms. Elnathan has never received ABA therapy before. \n-Elnathan is able to communicate mostly using one-word mands and gestures, however, needs to increase his verbal repertoire as he will often engage in maladaptive behaviors when he is unable to communicate his needs. Elnathan’s father reports that when they moved from Africa to the US in 2019, Elnathan did not have any speech impediments, however noticed regressions in speech and language after the move and during the pandemic. Elnathan was born full term with no complications and met all his millstones according to his father. His father’s biggest concerns are his deficits in communicating his wants and needs and decreasing maladaptive behaviors of physical aggression, elopement and noncompliance that will impede his daily functioning in society.  Elnathan’s father would like to have services rendered in school due to the increased frequency of maladaptive behaviors reported at school compared to the home, not much at home.  \n-Furthermore, Elnathan exhibits deficits with his tolerance skills, as his father mentions he has limited interest, and will often more from one activity to the next whether it is preferred or not. Additionally, he shares that Elnathan has restrictive behaviors in the form of having rigid routines the whole family has to follow, such as only being able to ride his mother or fathers car, or if the father is off of work still has to continue his work routine of leaving the home at the same time, otherwise Elnathan escalates to more severe maladaptive and that will set the mood for the whole day. \n-Teacher reported that client in the classroom has difficulty remaining on tasks, resists instructions, darts away from tasks, climbs on classroom tables, throws objects such as inflatable chairs. Teacher also reported Elnathan spits on her face, and pushes/shoves peers due to fixation with toy cars and refusal to give up items.', 'Elnathan has not previously received ABA therapy.', '- A new behavioral assessment and behavior plan was completed at this time. Age-appropriate replacement objectives have been developed.\n- Current treatment and progress update 3/2024: During this period Elnathan met the mastery on  STO 3 for climbing, for the rest of reduction behavior goals he continues working on STO 1: Physical Aggression, Spitting, Elopement,  Non-Compliance, Object Fixation and Throwing Objects. Regarding acquisition behavior goals Elnathan met the mastery on STO 1 for Follow instructions , Listener responding, Tolerate changes in routine, Give up toy within 3 seconds of Sd and Group goal; he  is also currently working on STO 2 for Manding, on STO 1 for Request a break, Intraverbal training, Tolerates “No” responses, Appropriate protesting , Appropriately requests other’s attention , Delay reinforcer and Sharing', '-He was attending First grade at Allan Park Elementary School for school year 23-24. ESE classroom with an active IEP. However, he recently changed schools to Edgewood academy in the beginning of September 2023.  \n- Update 3-2024: ST 30 min school only, recently referred to ST/OT outside of school but parents are still in the process of obtaining those.', '-Elnathan is diagnosed with Autism spectrum disorder, ADHD and sensory processing difficulty. No allergies or dietary restrictions have been reported at this time. Elnathan’s father reports he is not a picky eater and will often choose healthy foods over sugary choices, likely due to his upbringing in Africa where it was not a prominent food group. (no medications)', 'Elnathan has ability to communicate verbally using one-word mands, and gestures when is unable to communicate.', 'Elnathan lacks appropriate communication and social skills, he resorts to engaging in challenging behaviors to make needs known.', 'Elnathan is diagnosed with Autism spectrum disorder, ADHD and sensory processing difficulty. No allergies or dietary restrictions have been reported at this time. Elnathan’s father reports he is not a picky eater and will often choose healthy foods over sugary choices, likely due to his upbringing in Africa where it was not a prominent food group. no medications', '[]', '[{\"baseline_date\":\"2023-09-27T05:00:00.000Z\",\"baseline_level\":\"15\",\"initial_interesting\":3,\"maladaptive_behavior\":\"Physical aggression\",\"topografical_definition\":\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit\\/push (making forceful physical contact) with another person (hitting\\/pushing\\/shoving) or scratching using nails against another person\\u2019s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\"},{\"baseline_date\":\"2023-09-27T05:00:00.000Z\",\"baseline_level\":\"35\",\"initial_interesting\":3,\"maladaptive_behavior\":\"Spitting\",\"topografical_definition\":\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person\\u2019s shirt up and spitting on their person. Typically towards the teacher.\"},{\"baseline_date\":\"2023-09-27T05:00:00.000Z\",\"baseline_level\":\"70\",\"initial_interesting\":3,\"maladaptive_behavior\":\"Elopement\",\"topografical_definition\":\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\"},{\"baseline_date\":\"2023-09-27T05:00:00.000Z\",\"baseline_level\":\"50\",\"initial_interesting\":3,\"maladaptive_behavior\":\"Noncompliance\",\"topografical_definition\":\"Defined as any instance of task avoidance such as Elnathan stating \\u201cno\\u201d when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\"},{\"baseline_date\":\"2023-09-27T05:00:00.000Z\",\"baseline_level\":\"150\",\"initial_interesting\":3,\"maladaptive_behavior\":\"Climbing\",\"topografical_definition\":\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\"},{\"baseline_date\":\"2023-09-27T05:00:00.000Z\",\"baseline_level\":\"100\",\"initial_interesting\":3,\"maladaptive_behavior\":\"Object fixation\",\"topografical_definition\":\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers\\/adults.\"},{\"baseline_date\":\"2023-09-27T05:00:00.000Z\",\"baseline_level\":\"25\",\"initial_interesting\":3,\"maladaptive_behavior\":\"Throwing objects\",\"topografical_definition\":\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\"}]', 'A functional behavioral assessment was conducted by BCBA to obtain information regarding the probable contexts and functions of Elnathan’s behavior.', '[{\"assestment_title\":\"Functional assessment interview completed with mother, and both teachers.\",\"assestment_status\":\"yes\"},{\"assestment_title\":\"vineland-3 teacher form\",\"assestment_status\":\"yes\"},{\"assestment_title\":\"Observations\",\"assestment_status\":\"yes\"},{\"assestment_title\":\"Stimulus preference assessment\",\"assestment_status\":\"yes\"}]', '[{\"tangible\":\"Bubbles\",\"activities\":\"Watching TV, tablet games, running around\",\"other\":\"Going to the park \\nSocial attention\"}]', '[{\"behavior\":\"Physical aggression\",\"hypothesized_functions\":\"Attention, escape, tangible\",\"prevalent_setting_event_and_atecedent\":\"This behavior may be displayed when any demand given is sustained or something in the environment changed and he receives new instructions to follow or when access to task\\/activities was denied or delayed, or when he is told \'no\'.\"},{\"behavior\":\"Elopement\",\"hypothesized_functions\":\"Escape\",\"prevalent_setting_event_and_atecedent\":\"This behavior is displayed when any demand given is sustained or something in the environment changed and he receives new instructions to follow or when attention is withdrawn\"},{\"behavior\":\"Noncompliance\",\"hypothesized_functions\":\"Attention, tangible, escape\",\"prevalent_setting_event_and_atecedent\":\"This behavior occurs when attention is withdrawn or a demand was placed, or when access to task\\/activities was denied or delayed, or when he is told \'no\'.\"}]', '[{\"preventive_strategies\":\"Anticipate transitions and tell Elnathan what it is going to happen next, giving him time to reorganize himself. \\n\\nUse a timer to indicate the end of an activity and the beginning of the new task. \\n\\nWhen possible, only start activities when there is time to complete them\\nLet Elnathan know when the activities will be available again (e.g., on a picture schedule)\\nEncourage Elnathan to engage in another activity while waiting\\nRemind Elnathan of positive upcoming activities, using \\u201cif-then\\u201d statements\\n\\nRemove highly preferred items that Elnathan cannot have from sight or reach\\u2013 or keep them out of the house altogether\",\"replacement_skills\":\"Delay of Reinforcement (wait for tangibles) \\n\\nAccepting \\\"no\\\"\",\"manager_strategies\":\"Positive Behaviors: \\nIf Elnathan waits for desired items\\/activities: Praise him and give the access to the tangible once the designed time has passed. \\nIf Elnathan Requests tangibles appropriately, using his words, instead of problem behaviors then praise him and honor his request giving him the desired item\\/activity, if available.  \\n\\nMaladaptive behaviors:\\nIf Elnathan engages in problem behavior to have access to tangibles, do not allow him to access the item, once he is calm for three seconds; redirect him to use the appropriate request for tangible. \\n\\nIf Elnathan engages in problem behaviors block the behavior (less than 15 sec), do not allow him to access the item, once he is calm for three seconds; redirect him to use the appropriate request for tangible.\"}]', 'null', '[{\"preventive_strategies_e\":\"Simplify, shorten, or clarify tasks, activities, or demands.\\n\\nEmbed preferred items or activities such as toys or edibles in unpleasant or difficult tasks\\n\\nRemind Elnathan of more enjoyable activities that will occur following completion of the task\\/demand using \\u201cif-then\\u201d statements\\n\\nBegin demands with tasks that are relatively easy to complete to create behavioral momentum\\n\\nClearly differentiate choices from directives. \\n\\nAvoid presenting demands in the presence of a noisy environment\\n\\nRemind Elnathan when he is allowed to say no and to request breaks or assistance\\n\\nElnathan\\u2019s working materials and environment should periodically change to avoid escape based behaviors by satiation. \\n\\nTeach Elnathan to develop a plan for completing activities, allowing brief breaks and ordering tasks to make them more manageable\",\"replacement_skills_e\":\"Teach Elnathan to say no to a task (e.g., shaking head, \\u201clater, please\\u201d, \\u201cnot now\\u201d, \\u201cNo, thanks\\u201d)\\n\\nTeach Elnathan to request a break by using words\\n\\nTolerate non-preferred tasks\\n\\nTeach Elnathan to increase time on tasks\",\"manager_strategies_e\":\"Positive Behaviors: \\nIf Elnathan says no and the task, activity, or demand is not required (e.g., playing a game), respect his decision\\nIf Elnathan asks for a break, allow him to exit the activity for (5) minutes while resting in the sofa (not very reinforcing activity)\\nIf Elnathan asks for assistance, provide appropriate help\\nIf Elnathan follows instructions praise him immediately and allow him to take a break, if needed. \\n If Elnathan remains on task, praise him and remind him that he will be able to take a break after a certain period of time (FI) according to the objective he is working at the moment. \\n\\nMaladaptive behaviors: \\nIf Elnathan engages in problem behaviors do not allow him to leave the demand until he completes at least part of the task.\\nWithhold access to enjoyable activities until the task, activity, or demand has been completed.\\n\\nIf Elnathan engages problem behaviors, block the behavior (less than 15 sec), and redirect him to complete at least part of the activity or to request a break.\"}]', '[{\"preventive_strategies_a\":\"Provide attention to Elnathan every 10 minutes \\n\\nAt the end of each 10-minute interval, caregiver should approach him and provide attention by engaging in a short conversation with him\\n\\nLet Elnathan know when attention will be available and unavailable by for example, explaining to him when you are going to be in a phone call and how attention will be available immediately after that. \\n\\nProvide alternative activities or toys, tablet and cards when attention will be withdrawn \\n\\nRemind Elnathan to request attention with appropriate behavior\",\"replacement_skills_a\":\"Teach Elnathan to gain other\\u2019s attention appropriately\\n\\nTeach him to wait for attention\",\"manager_strategies_a\":\"Positive Behaviors: \\nProvide immediate attention if possible when Elnathan requests attention appropriately using his words.\\n\\nIf unable to provide attention, let Elnathan know when you will be available\\nReward lengthy periods of independent activity with special, attention-rich activities such as playing a game together. \\n\\nMaladaptive behaviors: \\nWithhold or minimize attention for, problem behaviors by minimizing conversation and looking away or blocking any possible harmful behavior.\\n\\nIf necessary, remove yourself or Elnathan to another room to prevent interaction and escalation.\\n\\nIf Elnathan engages in problem behaviors block the behavior (less than 15 sec), and redirect him to ask for attention appropriately.\"}]', 'The following hypothesis-based interventions and instructional practices will be initiated to address the different patterns of behavior/response classes.  These strategies have been selected because they are directly linked to the functions of Elnathan’s behavior and they are the least intrusive and most effective options available that will work within the environments in which he participates.', '[]', NULL, '2024-07-16 02:50:42', '2024-09-05 05:25:32', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_reports`
--

CREATE TABLE `client_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(155) DEFAULT NULL,
  `sponsor_id` bigint(20) DEFAULT NULL,
  `insurer_id` bigint(20) DEFAULT NULL,
  `cpt_code` varchar(155) DEFAULT NULL,
  `note_rbt_id` bigint(20) DEFAULT NULL,
  `note_bcba_id` bigint(20) DEFAULT NULL,
  `pa_number` varchar(100) DEFAULT NULL,
  `md` varchar(50) DEFAULT NULL,
  `md2` varchar(50) DEFAULT NULL,
  `mdbcba` varchar(20) DEFAULT NULL,
  `md2bcba` varchar(20) DEFAULT NULL,
  `pos` varchar(50) DEFAULT NULL,
  `session_date` timestamp NULL DEFAULT NULL,
  `total_hours` time DEFAULT NULL,
  `total_units` time DEFAULT NULL,
  `chargesrbt` double DEFAULT NULL,
  `chargesbcba` double DEFAULT NULL,
  `xe` varchar(100) DEFAULT NULL,
  `npi` varchar(150) DEFAULT NULL,
  `billed` tinyint(1) DEFAULT 0 COMMENT '0: false, 1:true',
  `pay` tinyint(1) DEFAULT 0 COMMENT '0: false, 1:true',
  `billedbcba` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: false, 1:true	',
  `paybcba` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: false, 1:true	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `client_reports`
--

INSERT INTO `client_reports` (`id`, `patient_id`, `sponsor_id`, `insurer_id`, `cpt_code`, `note_rbt_id`, `note_bcba_id`, `pa_number`, `md`, `md2`, `mdbcba`, `md2bcba`, `pos`, `session_date`, `total_hours`, `total_units`, `chargesrbt`, `chargesbcba`, `xe`, `npi`, `billed`, `pay`, `billedbcba`, `paybcba`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21, NULL, NULL, 1, '97153', 7, 2, NULL, NULL, NULL, 'HM', 'HM', NULL, '2024-07-22 16:00:00', NULL, NULL, 0, 0, '0', NULL, 1, 0, 0, 0, '2024-08-01 05:41:21', '2024-08-01 05:41:21', NULL),
(22, NULL, NULL, 1, '97153', 7, 2, NULL, NULL, NULL, 'HM', 'HM', NULL, '2024-07-22 16:00:00', NULL, NULL, 0, 0, '0', NULL, 1, 0, 0, 0, '2024-08-01 05:41:41', '2024-08-01 05:41:41', NULL),
(23, NULL, NULL, 1, '97153', 7, 2, NULL, NULL, NULL, 'HM', 'HM', NULL, '2024-07-22 16:00:00', NULL, NULL, 0, 0, '0', NULL, 1, 0, 0, 0, '2024-08-01 05:42:43', '2024-08-01 05:42:43', NULL),
(24, NULL, NULL, 1, '97153', 7, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-22 16:00:00', NULL, NULL, 0, 0, '0', NULL, 1, 1, 1, 1, '2024-08-01 05:46:49', '2024-08-01 05:46:49', NULL),
(25, NULL, NULL, 6, '97153', 8, 5, NULL, NULL, NULL, 'HM', 'HO', NULL, '2024-07-24 16:00:00', NULL, NULL, 0, 0, '0', NULL, 1, 1, 1, 1, '2024-08-01 05:56:24', '2024-08-01 05:56:24', NULL),
(26, NULL, NULL, 6, '97153', 8, 5, NULL, 'XE', NULL, NULL, NULL, NULL, '2024-07-24 16:00:00', NULL, NULL, 0, 0, '0', NULL, 1, 1, 1, 1, '2024-08-01 05:58:04', '2024-08-01 05:58:04', NULL),
(27, NULL, NULL, 1, '97151', 9, 4, NULL, 'HM', 'HM', NULL, NULL, NULL, '2024-07-24 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 1, 1, '2024-08-01 08:09:05', '2024-08-01 08:09:05', NULL),
(28, NULL, NULL, 1, '97151', 9, 4, NULL, NULL, NULL, 'HO', 'HO', NULL, '2024-07-24 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 1, 1, '2024-08-01 08:21:49', '2024-08-01 08:21:49', NULL),
(29, NULL, NULL, 1, '97151', 9, 4, NULL, 'HM', 'HM', NULL, NULL, NULL, '2024-07-24 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 1, 1, '2024-08-01 08:25:04', '2024-08-01 08:25:04', NULL),
(30, NULL, NULL, 1, '97153', 7, 2, NULL, 'HM', 'HO', NULL, NULL, NULL, '2024-07-22 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 1, 1, '2024-08-01 08:25:31', '2024-08-01 08:25:31', NULL),
(31, NULL, NULL, 1, '97153', 7, 2, NULL, NULL, NULL, 'HM', 'HM', NULL, '2024-07-22 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 1, 1, '2024-08-01 08:26:30', '2024-08-01 08:26:30', NULL),
(32, NULL, NULL, 6, '97153', 8, 5, NULL, NULL, NULL, 'XE', NULL, NULL, '2024-07-24 16:00:00', NULL, NULL, 536.36, 292.56, '0', NULL, 1, 1, 1, 1, '2024-08-01 08:27:58', '2024-08-01 08:27:58', NULL),
(33, NULL, NULL, 6, '97153', 4, 3, NULL, NULL, NULL, 'HM', 'XE', NULL, '2024-07-20 16:00:00', NULL, NULL, 341.32, 341.32, '0', NULL, 1, 0, 1, 0, '2024-08-01 08:28:30', '2024-08-01 08:28:30', NULL),
(34, NULL, NULL, 1, '97151', 9, 6, NULL, NULL, NULL, 'HM', '-- Select --', NULL, '2024-07-24 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 1, 1, '2024-08-17 00:28:26', '2024-08-17 00:28:26', NULL),
(35, NULL, NULL, 1, '97151', 9, 6, NULL, NULL, NULL, 'HM', NULL, NULL, '2024-07-24 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 1, 1, '2024-08-17 00:28:50', '2024-08-17 00:28:50', NULL),
(36, NULL, NULL, 6, '97153', 10, 5, NULL, 'HM', 'XE', NULL, NULL, NULL, '2024-08-16 19:00:00', NULL, NULL, 536.36, 292.56, '0', NULL, 1, 0, 1, 1, '2024-08-17 00:41:00', '2024-08-17 00:41:00', NULL),
(37, NULL, NULL, 1, '97151', 9, 6, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-24 16:00:00', NULL, NULL, 588, 588, '0', NULL, 1, 1, 0, 0, '2024-08-22 23:00:08', '2024-08-22 23:00:08', NULL),
(38, NULL, NULL, 1, '97151', 6, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-21 16:00:00', NULL, NULL, 588, 588, '0', NULL, 0, 0, 1, 1, '2024-08-23 07:12:27', '2024-08-23 07:12:27', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `consent_to_treatments`
--

INSERT INTO `consent_to_treatments` (`id`, `bip_id`, `patient_id`, `client_id`, `analyst_signature`, `analyst_signature_date`, `parent_guardian_signature`, `parent_guardian_signature_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, 'signatures/ai9wi9HbctxfFlto2mhLJDe4ohWCm1G6iAUlR4T0.jpg', '2024-07-12 16:00:00', 'signatures/HtqGrbQAH5gKHJlzIL239wAIGeyLLxuIjWXdFGcj.jpg', '2024-07-12 16:00:00', '2024-07-12 23:10:56', '2024-07-12 23:10:56', NULL),
(2, 2, '985590391', 5, 'signatures/CTlwi79NHGbzkvXem0eEmJ01mIRQIX2EX67v4gcL.jpg', '2024-07-15 16:00:00', 'signatures/S5VngLe2Fzk9ZUpKLfqvb8ESy1KV95HuSZGNKUaM.jpg', '2024-07-15 16:00:00', '2024-07-15 20:13:04', '2024-07-15 20:13:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crisis_plans`
--

CREATE TABLE `crisis_plans` (
  `id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `crisis_plans`
--

INSERT INTO `crisis_plans` (`id`, `bip_id`, `patient_id`, `client_id`, `crisis_description`, `crisis_note`, `caregiver_requirements_for_prevention_of_crisis`, `risk_factors`, `suicidalities`, `homicidalities`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, 'test', 'test', 'test', '[{\"do_not_apply\": true}]', '[{\"not_present\": true}]', '[{\"not_present_homicidality\": true}]', '2024-07-12 23:10:09', '2024-07-12 23:10:09', NULL),
(2, 2, '985590391', 5, 'crisis description', 'crisis note', 'caregiver', '[{\"do_not_apply\": true}]', '[{\"not_present\": true}]', '[{\"not_present_homicidality\": true}]', '2024-07-15 20:10:52', '2024-07-15 20:10:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `de_escalation_techniques`
--

CREATE TABLE `de_escalation_techniques` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `service_recomendation` text DEFAULT NULL,
  `recomendation_lists` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`recomendation_lists`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `de_escalation_techniques`
--

INSERT INTO `de_escalation_techniques` (`id`, `bip_id`, `patient_id`, `client_id`, `description`, `service_recomendation`, `recomendation_lists`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, NULL, NULL, '[{\"cpt\": \"test\", \"location\": \"In Home/School/Community\", \"num_units\": 23, \"breakdown_per_week\": \"test\", \"description_service\": \"test\"}]', '2024-07-12 23:10:25', '2024-07-12 23:10:25', NULL),
(2, 2, '985590391', 5, NULL, NULL, '[{\"index\":2,\"cpt\":\"97151\",\"description_service\":\"Assessment\",\"num_units\":32,\"breakdown_per_week\":\"8\",\"location\":\"In Home\\/School\"}]', '2024-07-15 20:12:25', '2024-09-03 03:59:20', NULL);

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
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `caregivers_training_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`caregivers_training_goals`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `family_envolments`
--

INSERT INTO `family_envolments` (`id`, `bip_id`, `patient_id`, `client_id`, `caregivers_training_goals`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, '[{\"criteria\": \"asd\", \"end_date\": \"2024-07-31T04:00:00.000Z\", \"initiation\": \"2024-07-14T04:00:00.000Z\", \"caregiver_goal\": \"dasdas\", \"current_status\": \"new\", \"outcome_measure\": \"dsasda\"}]', '2024-07-12 23:09:18', '2024-07-15 02:50:45', NULL),
(2, 2, '985590391', 5, '[{\"index\":2,\"caregiver_goal\":\"Parents\\/teachers will identify antecedents related to Elnathan\\u2019s behavior\",\"outcome_measure\":\"Monthly fidelity checks in which the percentage of times (across 4 data points) the parent demonstrated concept.\",\"criteria\":\"90% fidelity\",\"initiation\":\"2024-09-01T04:00:00.000Z\",\"end_date\":\"2024-09-30T04:00:00.000Z\",\"current_status\":\"in progress\"}]', '2024-07-15 19:59:17', '2024-09-03 03:58:25', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generalization_trainings`
--

CREATE TABLE `generalization_trainings` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discharge_plan` text DEFAULT NULL,
  `transition_fading_plans` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`transition_fading_plans`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `generalization_trainings`
--

INSERT INTO `generalization_trainings` (`id`, `bip_id`, `patient_id`, `client_id`, `discharge_plan`, `transition_fading_plans`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, 'test', '[{\"phase\": \"test\", \"description\": \"test\"}]', '2024-07-12 23:09:46', '2024-07-12 23:09:46', NULL),
(2, 2, '985590391', 5, 'The desired outcomes for discharge will be refined throughout the treatment process. Transition and discharge planning from a treatment program is included in this plan and specifies details of monitoring and follow-up as is appropriate for Elnathan and the family. Parents, extended family members, community caregivers, and others involved professionals will be consulted as the planning process accelerates with 3-6 months prior to the discharge. A description of roles and responsibilities of all providers and effective dates for behavioral targets that must be achieved prior to discharge will be specified and coordinated with all providers, and family members. Discharge and transition planning will involve a gradual step down in services. \nDischarge often requires 6 months or longer. Discharge Services will be reviewed and evaluated, and discharge planning begun when:\n • Elnathan has achieved treatment goals (0 incidents of challenging behavior and performs correctly on skill acquisition goals); OR \n• Family is interested in discontinuing services, OR\n• Family and provider are not able to reconcile important issues in treatment planning and delivery\nElnathan will be discharged when he has mastered all long-term goals being targeted and no additional skills areas and/or behavioral issues have been identified as a need for targeted treatment goals. Parents will also demonstrate understanding of ABA interventions and teaching/modeling for Elnathan consistently without support from therapist.', '[{\"phase\": \"1\", \"description\": \"All maladaptive will be reduced to 90% from bl, and vineland teacher maladaptive domain scales at 17 or less. Behavior analyst and assistant will reduce services by 25%, for 3 consecutive months.\"}, {\"phase\": \"2\", \"description\": \"Phase 1 sustained and Progress on skill acquisition goals at 80%. vineland (teacher form) score of 80 or more on socialization and communication domains. Behavior analyst and assistant will reduce services by 50%, for 3 consecutive months\"}, {\"phase\": \"3\", \"description\": \"Phase 2 sustained; skills generalized/maintained 80%. Behavior analyst and assistant will reduce services by 75%, for 3 consecutive months.\"}, {\"phase\": \"4\", \"description\": \"Phase 3 sustained for 3 consecutive months. Behavior analyst will provide 1 hr. per week consultation only model to ensure generalization/maintenance of skills, for 3 consecutive months RBT will be discontinued.\"}, {\"phase\": \"5\", \"description\": \"Phase 4 sustained for 3 consecutive months. Behavior analyst will provide 1 hr. per month consultation only model to ensure generalization/maintenance of skills, for 3 consecutive months. Then all services will be discontinued\"}]', '2024-07-15 20:01:32', '2024-07-15 20:01:32', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insurances`
--

CREATE TABLE `insurances` (
  `id` bigint(50) NOT NULL,
  `insurer_name` varchar(255) DEFAULT NULL,
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`services`)),
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`notes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `insurances`
--

INSERT INTO `insurances` (`id`, `insurer_name`, `services`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fl Blue', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"84\", \"unit_prize\": \"21\", \"description\": \"Assessment\", \"max_allowed\": \"(max 2 hrs/day) total 40 units/10 hours copay will aply per day\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"52\", \"unit_prize\": \"13\", \"description\": \"Therapy\", \"max_allowed\": \"(max 8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCBA\", \"hourly_fee\": \"81.6\", \"unit_prize\": \"20.4\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"76\", \"unit_prize\": \"19\", \"description\": \"Caregiver Training\", \"max_allowed\": null}, {\"code\": \"97157\", \"provider\": \"BCBA\", \"hourly_fee\": null, \"unit_prize\": \"3\", \"description\": \"Group Caregiver Training( Multi-family)\", \"max_allowed\": null}, {\"code\": \"H0032\", \"provider\": \"BCBA\", \"hourly_fee\": \"68\", \"unit_prize\": \"17\", \"description\": null, \"max_allowed\": null}]', '[{\"note\": \"Horizon by BCBS\"}, {\"note\": \"Horizon BCBSNJ will use H0032 for Indirect service (treatment planning)\"}, {\"note\": \"telehealth: submit a claim to Florida Blue using one of the regular codes included in your fee schedule. The place of service should be the regular place of service as if you saw the patient in-person.\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"Now allows concurrent billing of 97155 and 97153, effecitve 12/01/2021\"}, {\"note\": \"97156 is always ALLOWED to overlap with 97153\"}]', '2024-01-26 04:17:41', '2024-01-27 06:09:11', NULL),
(2, 'United', '[{\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"50.04\", \"unit_prize\": \"12.51\", \"description\": \"therapy\"}, {\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"119.52\", \"unit_prize\": \"29.88\", \"description\": \"IA (40 units)\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA 97155\", \"hourly_fee\": \"77.28\", \"unit_prize\": \"19.32\", \"description\": \"supervision\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA 97156\", \"hourly_fee\": \"70.04\", \"unit_prize\": \"17.51\", \"description\": \"PT\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"66.72\", \"unit_prize\": \"16.68\", \"description\": \"therapy\", \"max_allowed\": null}, {\"code\": \"97151\", \"provider\": \"BCaBA\", \"hourly_fee\": \"101.6\", \"unit_prize\": \"25.4\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"56.72\", \"unit_prize\": \"14.18\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"65.68\", \"unit_prize\": \"16.42\", \"description\": null, \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"59.52\", \"unit_prize\": \"14.88\", \"description\": null, \"max_allowed\": null}]', '[{\"note\": \"No school or community covered unless aproved by peer review on auth\"}, {\"note\": \"If the rendering provider is required, use the BCBA on the case.\"}, {\"note\": \"for 97155 Yes. When supervision is provided, you may bill concurrently for both Supervisors and Behavior Technicians, billing with 97153 and 97155.\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"Modifiers: RBT- HM, BCBA- HO, BCaBA- HN\"}, {\"note\": \"97156 is always allowed to overlap with 97153\"}]', '2024-01-27 06:14:56', '2024-01-28 07:51:37', NULL),
(3, 'CIGNA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"21\", \"unit_prize\": \"48\", \"description\": \"Assessment\", \"max_allowed\": \"48 units/ (12 hrs), No PA req.\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"10\", \"unit_prize\": \"15\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA (RBT supervision)\", \"hourly_fee\": \"19\", \"unit_prize\": \"0\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"Caregiver Training\", \"hourly_fee\": \"19\", \"unit_prize\": \"0\", \"description\": \"Therapy\", \"max_allowed\": null}]', '[{\"note\": \"Modifier XE for 2 sessions, same day different POS\\t\\t\\t\\ncan bill RBT and BCBA together por supervision\\t\\t\\t\\nOnly one provider can bill for a unit of time with the exception of CPT codes 97153 and 97155 (direct\\t\\t\\t\\nsupervision when the Board Certified Behavior Analyst® (BCBA®)/Qualified Healthcare Provider\\t\\t\\t\\n(QHP) directs the technician and both are face-to-face with the patient at the same time).\\t\\t\\t\\nbill services under the BCBA or licensed provider, allows lmhc\"}]', '2024-04-09 07:46:23', '2024-04-09 08:25:07', NULL),
(4, 'TRICARE', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"136.24\", \"unit_prize\": \"37.35\", \"description\": \"Assessment\", \"max_allowed\": \"32 units for initial/24 for reassessment, units per authorization (2 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"64.44\", \"unit_prize\": \"18.46\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"97155\", \"hourly_fee\": \"125\", \"unit_prize\": \"32.15\", \"description\": \"BIP modification only\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"T1023\", \"provider\": \"BCBA\", \"hourly_fee\": \"68.13\", \"unit_prize\": \"0\", \"description\": \"PDDBI\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"75\", \"unit_prize\": \"20.62\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"107.2\", \"unit_prize\": \"26.8\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}]', '[{\"note\": \"Concurrent billing is excluded for all ABA Category I CPT codes\"}, {\"note\": \"Does not allow billing for any two ABA providers at the same time. or same date\"}, {\"note\": \"If BCBA overlap with BCaBA, bill BCBA\"}, {\"note\": \"8.11.7.3.8 Concurrent billing is excluded for all ACD Category I CPT codes except when the family and the beneficiary are receiving separate services and the beneficiary is not present in the family session. Documentation must indicate two separate rendering providers and locations for the services.\"}, {\"note\": \"Yes they credential LMHC\"}]', '2024-04-09 08:04:29', '2024-04-09 08:31:05', NULL),
(5, 'AETNA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Assessment\", \"max_allowed\": \"48 units/ (12 hrs), 2 hr per day max\"}, {\"code\": \"97152\", \"provider\": \"RBT\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Assessment\", \"max_allowed\": null}, {\"code\": \"0362T\", \"provider\": \"Supporting\", \"hourly_fee\": \"88\", \"unit_prize\": \"20\", \"description\": \"Assessment\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"MD or QHP\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"0373T\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"20\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Caregiver Training\", \"max_allowed\": null}, {\"code\": \"97154\", \"provider\": \"Group\", \"hourly_fee\": \"64\", \"unit_prize\": \"16\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97157\", \"provider\": \"BCBA\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"Therapy Multiple-family group\", \"max_allowed\": null}, {\"code\": \"97158\", \"provider\": \"group MD or QHP\", \"hourly_fee\": \"88\", \"unit_prize\": \"22\", \"description\": \"BIP modification only\", \"max_allowed\": null}]', '[{\"note\": \"Modifier: Telehealth (02) - 95\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}]', '2024-04-09 08:20:13', '2024-04-09 08:20:35', NULL),
(6, 'Medicaid', '[{\"code\": \"97153\", \"provider\": \"RBT, BCaBA\", \"hourly_fee\": \"219.42\", \"unit_prize\": \"12.19\", \"description\": \"Direct Service provided by a Registered Behavior Technician (RBT), a BCaBA, or a Lead Analyst\", \"max_allowed\": \"max 8 hours per day\"}, {\"code\": \"97156\", \"provider\": \"Lead Analyst\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Family training by Lead Analyst Service provided by a Lead Analyst\", \"max_allowed\": \"max 4H per day\"}, {\"code\": \"97156 GT\", \"provider\": \"Lead Analyst\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Family training via telemedicine Service provided by a Lead Analyst; Florida Medicaid reimburses up to 2 hours per week\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"PM\", \"hourly_fee\": \"76.2\", \"unit_prize\": \"19.05\", \"description\": \"Behavior treatment with protocol modification (PM) Service provided by a Lead Analyst\", \"max_allowed\": \"max 6 hours per day (PM needs to be on the notes)\"}, {\"code\": \"97156 HN\", \"provider\": \"BCaBA\", \"hourly_fee\": \"60.96\", \"unit_prize\": \"15.24\", \"description\": \"Family training by assistant Service performed by a BCaBA\", \"max_allowed\": null}, {\"code\": \"97155 HN\", \"provider\": \"BCaBA\", \"hourly_fee\": \"243.84\", \"unit_prize\": \"15.24\", \"description\": \"Behavior treatment with protocol modification Service provided by a BCaBA\", \"max_allowed\": null}, {\"code\": \"97151\", \"provider\": null, \"hourly_fee\": \"38.1\", \"unit_prize\": \"19.05\", \"description\": \"Assessment maximum of 24 units\", \"max_allowed\": \"max 2 hours per day\"}, {\"code\": \"97151 TS\", \"provider\": null, \"hourly_fee\": \"152.4\", \"unit_prize\": \"19.05\", \"description\": \"Reassessment maximum of 18 units\", \"max_allowed\": \"max 2 hours per day\"}]', '[{\"note\": \"overlap: if 97153 is concurrent with 97155, 97153 need to use modifier XP (Not reimbursed)\"}, {\"note\": \"All services need to be  billed\"}, {\"note\": \"02+ GT for telehealth\"}, {\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"For sunshine cases w/ member ID starts with a 7, the PA needs to be under the BCBA name that is on the case.\"}]', '2024-04-12 08:14:56', '2024-04-27 00:12:21', NULL),
(7, 'NOW KBA', '[{\"code\": \"97151\", \"provider\": \"BCBA\", \"hourly_fee\": \"136.24\", \"unit_prize\": \"34.06\", \"description\": \"Assessment\", \"max_allowed\": \"32 units for initial/32 for reassessment, units per authorization (2 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"RBT\", \"hourly_fee\": \"75\", \"unit_prize\": \"18.75\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97153\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Therapy\", \"max_allowed\": null}, {\"code\": \"97155\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"BIP modification only\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"97156\", \"provider\": \"BCBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}, {\"code\": \"T1023\", \"provider\": \"BCBA\", \"hourly_fee\": \"68.13\", \"unit_prize\": null, \"description\": \"PDDBI\", \"max_allowed\": null}, {\"code\": \"97153\", \"provider\": \"BCaBA\", \"hourly_fee\": \"75\", \"unit_prize\": \"18.75\", \"description\": \"Therapy\", \"max_allowed\": \"32 units per day/ (8 hrs/day)\"}, {\"code\": \"97155\", \"provider\": \"BCaBA\", \"hourly_fee\": \"83.16\", \"unit_prize\": \"20.79\", \"description\": \"BIP modification only\", \"max_allowed\": null}, {\"code\": \"97156\", \"provider\": \"BCaBA\", \"hourly_fee\": \"125\", \"unit_prize\": \"31.25\", \"description\": \"Caregiver Training\", \"max_allowed\": \"8 units per day/ (2 hr/day)\"}]', '[{\"note\": \"Modifier XE for 2 sessions, same day different POS\"}, {\"note\": \"ALLOWS OVERLAP BILLING\"}]', '2024-04-12 08:32:40', '2024-04-12 08:32:40', NULL);

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
  `telfax` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `locations`
--

INSERT INTO `locations` (`id`, `title`, `avatar`, `city`, `state`, `zip`, `address`, `email`, `phone1`, `phone2`, `telfax`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pelaez', NULL, 'Naples', 'Florida', '34102', '704 Goodlette Frank Rd. N Naples, FL 34102', 'pelaezandbeyond@gmail.com', '888-533-2902', '209-390-1597', NULL, '2024-02-02 00:32:49', '2024-06-18 07:18:09', NULL),
(2, 'FENIX', NULL, 'Sarasota', 'Florida', '34237', '2014 4TH ST Sarasota, Florida 34237', 'office@fenixbehavior.com', '239-224-9534', '239-790-2601', NULL, '2024-02-02 00:33:21', '2024-06-18 07:16:40', NULL),
(3, 'ABAOFSWF', NULL, 'fort myers Beach', 'Florida', '33931', '6660 Estero blvd', 'manager@practice-mgmt.com', '888-872-0459', '2396916482', NULL, '2024-02-02 00:35:26', '2024-06-18 07:13:56', NULL),
(4, 'Chacao', 'locations/PxUPzBByeO6WDUI8PuwARqmGvhSBUTEEPsCKWptl.jpg', 'Caracas', 'Distrito Federal', '1234', 'Chacao', 'abachacao@aba.com', '123456', '456789', NULL, '2024-07-10 18:12:19', '2024-07-10 18:12:19', NULL),
(5, 'La Trinidad', 'locations/8LxQFBPmhYPyuPohXdJAMD4GdIQwZShO7na0DUMm.jpg', 'La trinidad', 'Distrito Federal', '1234', 'La trinidad', 'abatrinidad@aba.com', '12345', '234566435', NULL, '2024-07-10 18:18:13', '2024-07-10 18:18:13', NULL),
(6, 'TEXAS', NULL, 'Huston', 'FL', '33907', '1705 colonial BLVD\r\nB4', 'texasoffice@abaofswf.com', '210-686-2720', '888-391-5328', '888-391-5328', '2024-06-07 06:39:20', '2024-07-16 03:31:41', NULL);

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
(7, '2023_11_29_231903_create_permission_tables', 1);

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
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 11),
(1, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 4),
(7, 'App\\Models\\User', 8),
(7, 'App\\Models\\User', 10),
(8, 'App\\Models\\User', 2),
(8, 'App\\Models\\User', 9),
(8, 'App\\Models\\User', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitoring_evaluatings`
--

CREATE TABLE `monitoring_evaluatings` (
  `id` bigint(20) NOT NULL,
  `bip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `treatment_fidelity` text DEFAULT NULL,
  `rbt_training_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rbt_training_goals`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `monitoring_evaluatings`
--

INSERT INTO `monitoring_evaluatings` (`id`, `bip_id`, `patient_id`, `client_id`, `treatment_fidelity`, `rbt_training_goals`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'test1', 1, NULL, '[{\"lto\": \"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\", \"date\": \"2024-07-12T04:00:00.000Z\", \"status\": \"inprogress\"}]', '2024-07-12 23:09:32', '2024-07-12 23:09:32', NULL),
(2, 2, '985590391', 5, NULL, '[{\"index\":2,\"lto\":\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\",\"status\":\"initiated\",\"date\":\"2024-09-02T04:00:00.000Z\",\"end_date\":\"2024-09-25T04:00:00.000Z\"}]', '2024-07-15 20:00:17', '2024-09-03 03:58:51', NULL);

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
  `note_description` text DEFAULT NULL,
  `rendering_provider` bigint(20) DEFAULT NULL,
  `aba_supervisor` bigint(20) DEFAULT NULL,
  `caregiver_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`caregiver_goals`)),
  `rbt_training_goals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rbt_training_goals`)),
  `provider_signature` varchar(255) DEFAULT NULL,
  `provider_name` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_signature` varchar(255) DEFAULT NULL,
  `supervisor_name` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','ok','no','review') NOT NULL DEFAULT 'pending',
  `billedbcba` tinyint(1) NOT NULL DEFAULT 0,
  `paybcba` tinyint(1) NOT NULL DEFAULT 0,
  `mdbcba` varchar(10) DEFAULT NULL,
  `md2bcba` varchar(10) DEFAULT NULL,
  `meet_with_client_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `note_bcbas`
--

INSERT INTO `note_bcbas` (`id`, `doctor_id`, `patient_id`, `bip_id`, `birth_date`, `diagnosis_code`, `cpt_code`, `location`, `session_date`, `time_in`, `time_out`, `time_in2`, `time_out2`, `session_length_total`, `note_description`, `rendering_provider`, `aba_supervisor`, `caregiver_goals`, `rbt_training_goals`, `provider_signature`, `provider_name`, `supervisor_signature`, `supervisor_name`, `created_at`, `updated_at`, `deleted_at`, `status`, `billedbcba`, `paybcba`, `mdbcba`, `md2bcba`, `meet_with_client_at`) VALUES
(1, 4, 'test1', 1, '2024-07-12 16:00:00', 'test', '97151', 'undefined', '2024-07-12 16:00:00', '09:00:00', '12:00:00', '12:00:00', '17:00:00', NULL, 'test', 4, 3, '\"[{\\\"criteria\\\":\\\"test\\\",\\\"initiation\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"test\\\",\\\"current_status\\\":\\\"new\\\",\\\"outcome_measure\\\":\\\"test\\\",\\\"porcent_of_correct_response\\\":12}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"status\\\":\\\"inprogress\\\",\\\"porcent_of_correct_response\\\":32}]\"', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 4, 'signatures/qA0V6xTZ08eRFO5h37RjUHw2ZFmLDa8O17hTCZlt.jpg', 3, '2024-07-13 00:15:33', '2024-07-31 23:17:34', NULL, 'ok', 0, 0, NULL, NULL, '02'),
(2, 4, 'test1', 1, '2024-07-12 16:00:00', 'test', '97153', 'undefined', '2024-07-20 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'description', 4, 13, '\"[{\\\"criteria\\\":\\\"asd\\\",\\\"end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"initiation\\\":\\\"2024-07-14T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"dasdas\\\",\\\"current_status\\\":\\\"new\\\",\\\"outcome_measure\\\":\\\"dsasda\\\",\\\"porcent_of_correct_response\\\":23}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"status\\\":\\\"inprogress\\\",\\\"porcent_of_correct_response\\\":12}]\"', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 4, 'storage/signatures/CJEhvzn17gCPfT5lU1FqgcYlqWWZ7yLNpJyziX61.jpg', 12, '2024-07-21 00:22:16', '2024-08-01 08:26:30', NULL, 'ok', 1, 1, 'HM', 'HM', '02'),
(3, 10, '985590391', 2, '2017-06-27 16:00:00', 'F84.0', '97153', 'undefined', '2024-07-20 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'number_of_correct_response', 10, 11, '\"[{\\\"criteria\\\":\\\"90% fidelity\\\",\\\"end_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"initiation\\\":\\\"2024-03-01T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"Parents/teachers will identify antecedents related to Elnathan’s behavior\\\",\\\"current_status\\\":\\\"in progress\\\",\\\"outcome_measure\\\":\\\"Monthly fidelity checks in which the percentage of times (across 4 data points) the parent demonstrated concept.\\\",\\\"porcent_of_correct_response\\\":15}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate Premack Principle procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"status\\\":\\\"initiated\\\",\\\"porcent_of_correct_response\\\":13}]\"', 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 10, 'signatures/CJEhvzn17gCPfT5lU1FqgcYlqWWZ7yLNpJyziX61.jpg', 11, '2024-07-21 00:23:24', '2024-08-06 22:41:31', NULL, 'ok', 1, 0, 'HM', 'XE', '03'),
(4, 4, 'test1', 1, '2024-07-12 16:00:00', 'test', '97151', 'undefined', '2024-07-22 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'fdsfds', 4, 10, '\"[{\\\"criteria\\\":\\\"asd\\\",\\\"end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"initiation\\\":\\\"2024-07-14T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"dasdas\\\",\\\"current_status\\\":\\\"new\\\",\\\"outcome_measure\\\":\\\"dsasda\\\",\\\"porcent_of_correct_response\\\":23}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"status\\\":\\\"inprogress\\\",\\\"porcent_of_correct_response\\\":3}]\"', 'storage/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 4, 'signatures/CJEhvzn17gCPfT5lU1FqgcYlqWWZ7yLNpJyziX61.jpg', 12, '2024-07-22 22:10:20', '2024-08-02 19:44:46', NULL, 'ok', 1, 1, 'HO', 'HO', '02'),
(5, 10, '985590391', 2, '2017-06-27 16:00:00', 'F84.0', '97153', 'undefined', '2024-07-22 16:00:00', '09:00:00', '12:00:00', '12:00:00', '15:00:00', NULL, 'nota', 10, 11, '\"[{\\\"criteria\\\":\\\"90% fidelity\\\",\\\"end_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"initiation\\\":\\\"2024-03-01T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"Parents/teachers will identify antecedents related to Elnathan’s behavior\\\",\\\"current_status\\\":\\\"in progress\\\",\\\"outcome_measure\\\":\\\"Monthly fidelity checks in which the percentage of times (across 4 data points) the parent demonstrated concept.\\\",\\\"porcent_of_correct_response\\\":23}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate Premack Principle procedure, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"status\\\":\\\"initiated\\\",\\\"porcent_of_correct_response\\\":2}]\"', 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 10, 'signatures/CJEhvzn17gCPfT5lU1FqgcYlqWWZ7yLNpJyziX61.jpg', 11, '2024-07-23 04:59:38', '2024-08-06 22:41:52', NULL, 'ok', 1, 1, 'XE', NULL, '12'),
(6, 4, 'test1', 1, '2024-07-12 19:00:00', 'test', '97151', 'undefined', '2024-08-17 19:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'dasdasads', 4, 5, '\"[{\\\"criteria\\\":\\\"asd\\\",\\\"end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"initiation\\\":\\\"2024-07-14T04:00:00.000Z\\\",\\\"caregiver_goal\\\":\\\"dasdas\\\",\\\"current_status\\\":\\\"new\\\",\\\"outcome_measure\\\":\\\"dsasda\\\",\\\"porcent_of_correct_response\\\":23}]\"', '\"[{\\\"lto\\\":\\\"RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.\\\",\\\"date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"status\\\":\\\"inprogress\\\",\\\"porcent_of_correct_response\\\":23}]\"', 'https://abatherapy.malcolmcordova.com/backend-api-aba/storage/app/public/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, NULL, 6, '2024-08-17 00:25:47', '2024-08-22 23:08:54', NULL, 'ok', 0, 0, 'HM', NULL, '02');

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
  `provider_signature` varchar(255) DEFAULT NULL,
  `provider_name` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_signature` varchar(255) DEFAULT NULL,
  `supervisor_name` bigint(20) UNSIGNED DEFAULT NULL,
  `md` varchar(20) DEFAULT NULL,
  `md2` varchar(20) DEFAULT NULL,
  `billed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: false, 1:true',
  `pay` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: false, 1:true',
  `cpt_code` varchar(200) DEFAULT NULL,
  `status` enum('pending','ok','no','review') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `note_rbts`
--

INSERT INTO `note_rbts` (`id`, `doctor_id`, `patient_id`, `bip_id`, `provider_name_g`, `provider_credential`, `pos`, `session_date`, `time_in`, `time_out`, `time_in2`, `time_out2`, `session_length_total`, `environmental_changes`, `maladaptives`, `replacements`, `interventions`, `meet_with_client_at`, `client_appeared`, `as_evidenced_by`, `rbt_modeled_and_demonstrated_to_caregiver`, `client_response_to_treatment_this_session`, `progress_noted_this_session_compared_to_previous_session`, `next_session_is_scheduled_for`, `provider_signature`, `provider_name`, `supervisor_signature`, `supervisor_name`, `md`, `md2`, `billed`, `pay`, `cpt_code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '985590391', 2, 2, 'adsdsa', '03 School', '2024-07-16 16:00:00', '09:00:00', '12:00:00', '12:00:00', '03:00:00', NULL, 'environmental changes', '\"[{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 15 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 35 incidents per week\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 70 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 50 incidents per week\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 150 incidents per week\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 100 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2024-06-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"25\\\",\\\"initial_interesting\\\":40,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":32}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":32,\\\"number_of_correct_response\\\":15}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true}]\"', '03', 'sad', 'environmental changes', 'environmental changes', 'environmental changes', 'excelent', '2024-07-16 16:00:00', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 4, NULL, NULL, 0, 0, NULL, 'pending', '2024-07-15 18:56:41', '2024-07-15 18:58:35', '2024-07-15 18:58:35'),
(2, 2, '985590391', 2, 2, 'adsdsa', '03 School,12 Home,02 Telehealth', '2024-07-15 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'environmental change', '\"[{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 15 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 35 incidents per week\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 70 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 50 incidents per week\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 150 incidents per week\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 100 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2024-06-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"25\\\",\\\"initial_interesting\\\":40,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":32}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":30,\\\"number_of_correct_response\\\":15}]\"', '\"[{\\\"pairing\\\":true}]\"', '03', 'excited', 'environmental change', 'environmental change', 'environmental change', 'excelent', '2024-07-16 16:00:00', 'signatures/Imv4s9iergIUgNdDURPSDhrPzmzW7k0XTKbiO2om.jpg', 3, 'signatures/gW9ap1aVO6VHLPXdWFWf6qvyl5sQwIkEeW8OwisA.jpg', 3, 'HM', 'HM', 1, 1, '97153', 'ok', '2024-07-15 20:26:33', '2024-08-06 21:28:30', NULL),
(3, 2, '985590391', 2, 2, 'adsdsa', '03 School,12 Home', '2024-07-16 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'environmental chang', '\"[{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 15 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 35 incidents per week\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 70 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 50 incidents per week\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 150 incidents per week\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 100 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2024-06-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"25\\\",\\\"initial_interesting\\\":40,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":32}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":30,\\\"number_of_correct_response\\\":15}]\"', '\"[{\\\"pairing\\\":true}]\"', '12', 'sad', 'dasdas', 'environmental chang', 'environmental chang', 'excelent', '2024-07-17 12:00:00', 'storage/signatures/Imv4s9iergIUgNdDURPSDhrPzmzW7k0XTKbiO2om.jpg', 3, 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 4, 'HM', 'HM', 1, 1, '97153', 'ok', '2024-07-15 20:28:21', '2024-07-23 20:42:55', NULL),
(4, 2, '985590391', 2, 2, 'cris', '03 School,12 Home', '2024-07-20 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'environmental chang', '\"[{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 15 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 35 incidents per week\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 70 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 50 incidents per week\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 150 incidents per week\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2023-09-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"Average of 100 incidents per week\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":32},{\\\"baseline_date\\\":\\\"2024-06-27T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"25\\\",\\\"initial_interesting\\\":40,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":32}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":30,\\\"number_of_correct_response\\\":15}]\"', '\"[{\\\"pairing\\\":true}]\"', '03', 'happy', '32', '32', '32', 'excelent', '2024-07-22 08:00:00', 'storage/signatures/Imv4s9iergIUgNdDURPSDhrPzmzW7k0XTKbiO2om.jpg', 3, 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 4, 'HM', 'HM', 1, 0, '97153', 'review', '2024-07-20 20:19:31', '2024-07-23 20:43:26', NULL),
(5, 2, 'test1', 1, 2, 'adsdsa', '02 Telehealth', '2024-07-20 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'environmental changes', '\"[{\\\"baseline_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"24\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"test\\\",\\\"topografical_definition\\\":\\\"testdsd teslts asd\\\",\\\"number_of_occurrences\\\":20}]\"', '\"[{\\\"goal\\\":\\\"test\\\",\\\"total_trials\\\":10,\\\"number_of_correct_response\\\":5}]\"', '\"[{\\\"pairing\\\":true,\\\"response_block\\\":true,\\\"shaping\\\":true}]\"', '02', 'sad', 'dasenvironmental changes', 'environmental changes', 'environmental changes', 'excelent', '2024-07-21 08:00:00', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 2, 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 10, 'HM', 'HM', 1, 0, '97151', 'ok', '2024-07-20 22:40:01', '2024-08-06 22:39:40', NULL),
(6, 2, 'test1', 1, 2, 'adsdsa', '02 Telehealth', '2024-07-21 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, '32', '\"[{\\\"baseline_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"24\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"test\\\",\\\"topografical_definition\\\":\\\"testdsd teslts asd\\\",\\\"number_of_occurrences\\\":12}]\"', '\"[{\\\"goal\\\":\\\"test\\\",\\\"total_trials\\\":20,\\\"number_of_correct_response\\\":10}]\"', '\"[{\\\"pairing\\\":true,\\\"response_block\\\":true,\\\"NCR\\\":true}]\"', '02', 'happy', '323wqasd', 'adsads', 'dasads', 'excelent', '2024-07-22 08:00:00', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 2, 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 3, 'HM', 'HO', 0, 0, '97151', 'ok', '2024-07-20 22:49:51', '2024-08-23 07:12:27', NULL),
(7, 2, 'test1', 1, 2, 'adsdsa', '02 Telehealth', '2024-07-22 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'asddas', '\"[{\\\"baseline_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"24\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"test\\\",\\\"topografical_definition\\\":\\\"testdsd teslts asd\\\",\\\"number_of_occurrences\\\":12}]\"', '\"[{\\\"goal\\\":\\\"test\\\",\\\"total_trials\\\":12,\\\"number_of_correct_response\\\":6}]\"', '\"[{\\\"pairing\\\":true}]\"', '02', 'sad', 'number_of_correct_response', 'number_of_correct_response', 'number_of_correct_response', 'excelent', '2024-07-23 16:00:00', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 2, 'signatures/Epx3YjVZkGb3eLg7Z02aBdZ4hS5NOSRfzofIvUWF.jpg', 3, 'HM', 'HO', 1, 1, '97153', 'ok', '2024-07-21 00:13:19', '2024-08-17 00:21:25', NULL),
(8, 2, '985590391', 2, 2, 'null', NULL, '2024-07-24 16:00:00', '09:00:00', '12:00:00', '12:00:00', '04:00:00', NULL, 'cambios en el ambiente', '\"[{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"15\\\",\\\"initial_interesting\\\":5,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit/push (making forceful physical contact) with another person (hitting/pushing/shoving) or scratching using nails against another person’s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"35\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person’s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":43},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"70\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":12},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"50\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating “no” when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":12},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"150\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":0},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"100\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers/adults.\\\",\\\"number_of_occurrences\\\":12},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"27\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":0}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":24,\\\"number_of_correct_response\\\":12}]\"', '\"[{\\\"pairing\\\":true,\\\"response_block\\\":true,\\\"NCR\\\":true}]\"', '02', 'happy', 'as evidenced by', 'RBT modeled and demonstrated to caregiver', 'RBT modeled and demonstrated to caregiver', 'excelent', '2024-07-25 16:00:00', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'signatures/Epx3YjVZkGb3eLg7Z02aBdZ4hS5NOSRfzofIvUWF.jpg', 3, 'XE', NULL, 1, 1, '97153', 'ok', '2024-07-24 18:06:16', '2024-08-01 05:58:04', NULL),
(9, 2, 'test1', 1, 2, 'adsdsa', '02 Telehealth', '2024-07-24 16:00:00', '09:00:00', '12:00:00', '12:00:00', '16:00:00', NULL, 'cambios del ambiente', '\"[{\\\"baseline_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"24\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"test\\\",\\\"topografical_definition\\\":\\\"testdsd teslts asd\\\",\\\"number_of_occurrences\\\":23}]\"', '\"[{\\\"goal\\\":\\\"test\\\",\\\"total_trials\\\":20,\\\"number_of_correct_response\\\":10}]\"', '\"[{\\\"pairing\\\":true,\\\"response_block\\\":true,\\\"DRA\\\":true}]\"', '02', 'happy', 'as evidenced by', 'as evidenced by', 'as evidenced by', 'moderate', '2024-07-25 16:00:00', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 2, 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 10, 'HM', 'HM', 1, 1, '97151', 'ok', '2024-07-24 18:47:04', '2024-08-06 22:38:34', NULL),
(10, 1, '985590391', 2, 1, 'null', NULL, '2024-08-16 19:00:00', '09:00:00', '12:00:00', '12:00:00', '04:00:00', NULL, 'adsdas', '\"[{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"15\\\",\\\"initial_interesting\\\":5,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit\\/push (making forceful physical contact) with another person (hitting\\/pushing\\/shoving) or scratching using nails against another person\\u2019s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":23},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"35\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person\\u2019s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":2},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"70\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":3},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"50\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating \\u201cno\\u201d when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":3},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"150\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":0},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"100\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers\\/adults.\\\",\\\"number_of_occurrences\\\":1},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"27\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":3}]\"', '\"[{\\\"goal\\\":\\\"Group goal\\\",\\\"total_trials\\\":20,\\\"number_of_correct_response\\\":13}]\"', '\"[{\\\"pairing\\\":true,\\\"errorless_teaching\\\":true,\\\"NCR\\\":true}]\"', '02', 'happy', 'dasdas', 'adsdsaads', 'adsdas', 'moderate', '2024-08-18 19:00:00', 'https://abatherapy.malcolmcordova.com/backend-api-aba/storage/app/public/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'https://abatherapy.malcolmcordova.com/backend-api-aba/storage/app/public/signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 10, 'HM', 'XE', 1, 0, '97153', 'pending', '2024-08-17 00:39:37', '2024-08-17 00:41:00', NULL),
(11, 12, '985590391', 2, 12, 'RBT-23-277795', NULL, '2024-08-12 19:00:00', '10:00:00', NULL, NULL, '01:00:00', NULL, 'NONE', '\"[{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"15\\\",\\\"initial_interesting\\\":5,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit\\/push (making forceful physical contact) with another person (hitting\\/pushing\\/shoving) or scratching using nails against another person\\u2019s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":4},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"35\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person\\u2019s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":4},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"70\\\",\\\"initial_interesting\\\":23,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":4},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"50\\\",\\\"initial_interesting\\\":2,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating \\u201cno\\u201d when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":4},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"150\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":4},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"100\\\",\\\"initial_interesting\\\":10,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers\\/adults.\\\",\\\"number_of_occurrences\\\":4},{\\\"baseline_date\\\":\\\"2024-07-15T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"27\\\",\\\"initial_interesting\\\":4,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":4}]\"', '\"[{\\\"id\\\":2,\\\"goal\\\":\\\"Group goal\\\",\\\"current_status\\\":\\\"Average of 72% per week. (In progress STO 2) APR, 2024\\\",\\\"description\\\":\\\"description\\\",\\\"patient_id\\\":\\\"985590391\\\",\\\"client_id\\\":null,\\\"bip_id\\\":2,\\\"goalstos\\\":\\\"[{\\\\\\\"target\\\\\\\": \\\\\\\"50-75\\\\\\\", \\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"3\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-07-24T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"STO3 Elnathan sits in a small group for 5 minutes without disruptive behavior or attempting to leave the group in 75% of trials, across 4 consecutive weeks.\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"inprogress\\\\\\\"}, {\\\\\\\"target\\\\\\\": \\\\\\\"100\\\\\\\", \\\\\\\"sustitution_sto\\\\\\\": \\\\\\\"4\\\\\\\", \\\\\\\"sustitution_date_sto\\\\\\\": \\\\\\\"2024-07-25T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_sto\\\\\\\": \\\\\\\"on hold\\\\\\\", \\\\\\\"sustitution_decription_sto\\\\\\\": \\\\\\\"target\\\\\\\", \\\\\\\"sustitution_status_sto_edit\\\\\\\": \\\\\\\"on hold\\\\\\\"}]\\\",\\\"goalltos\\\":\\\"[{\\\\\\\"sustitution_lto\\\\\\\": \\\\\\\"lt01\\\\\\\", \\\\\\\"sustitution_date_lto\\\\\\\": \\\\\\\"2024-07-15T04:00:00.000Z\\\\\\\", \\\\\\\"sustitution_status_lto\\\\\\\": \\\\\\\"inprogress\\\\\\\", \\\\\\\"sustitution_decription_lto\\\\\\\": \\\\\\\"environmental changes\\\\\\\"}]\\\",\\\"created_at\\\":\\\"2024-07-15T11:55:11.000000Z\\\",\\\"updated_at\\\":\\\"2024-07-24T22:01:07.000000Z\\\",\\\"deleted_at\\\":null,\\\"total_trials\\\":4,\\\"number_of_correct_response\\\":4}]\"', '\"[{\\\"response_block\\\":true,\\\"errorless_teaching\\\":true,\\\"token_economy\\\":true}]\"', '03', 'tired', 'Smiling at RBT', '4', '4', 'excelent', '2024-08-14 19:00:00', 'https://abatherapy.malcolmcordova.com/backend-api-aba/storage/app/public/signatures/xM3ratFhvTNtjb3pkbUjSycpy2lnfXH7JBtM9Q8Q.jpg', 12, NULL, 8, NULL, NULL, 0, 0, '97153', 'pending', '2024-08-17 04:27:47', '2024-08-17 04:27:47', NULL),
(12, 1, '985590391', 2, 1, 'null', NULL, '2024-09-04 19:00:00', '09:00:00', '12:00:00', '01:00:00', '04:00:00', NULL, 'asdasdsdsa', '\"[{\\\"baseline_date\\\":\\\"2023-09-27T05:00:00.000Z\\\",\\\"baseline_level\\\":\\\"15\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"Physical aggression\\\",\\\"topografical_definition\\\":\\\"Defined as any occurrence of using a hand or arm with a closed or open fist to hit\\/push (making forceful physical contact) with another person (hitting\\/pushing\\/shoving) or scratching using nails against another person\\u2019s body. (Non-Examples: Giving a high five, Hugging, Common social physical interactions)\\\",\\\"number_of_occurrences\\\":10},{\\\"baseline_date\\\":\\\"2023-09-27T05:00:00.000Z\\\",\\\"baseline_level\\\":\\\"35\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"Spitting\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of forcibly expelling saliva or other fluids from the mouth, through the lips, resulting in visible droplets or a stream of fluid exiting the mouth. Including pulling a person\\u2019s shirt up and spitting on their person. Typically towards the teacher.\\\",\\\"number_of_occurrences\\\":4},{\\\"baseline_date\\\":\\\"2023-09-27T05:00:00.000Z\\\",\\\"baseline_level\\\":\\\"70\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"Elopement\\\",\\\"topografical_definition\\\":\\\"Defined as leaving designated area to be further than 2 feet from the designated area or more than an arm\'s reach from the adult when in public places. May try to open the door of the classroom. Scored as a frequency if child turns and attempts to run away, getting at least 1 foot out of designated area, even if the behavior is blocked for safety purposes prior to teaching unsafe distances.\\\",\\\"number_of_occurrences\\\":6},{\\\"baseline_date\\\":\\\"2023-09-27T05:00:00.000Z\\\",\\\"baseline_level\\\":\\\"50\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"Noncompliance\\\",\\\"topografical_definition\\\":\\\"Defined as any instance of task avoidance such as Elnathan stating \\u201cno\\u201d when presented with a task demand or instruction, ignoring an instruction for 15 consecutive seconds or longer, and or starting but not completing given task.\\\",\\\"number_of_occurrences\\\":0},{\\\"baseline_date\\\":\\\"2023-09-27T05:00:00.000Z\\\",\\\"baseline_level\\\":\\\"150\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"Climbing\\\",\\\"topografical_definition\\\":\\\"Defined as each instance of climbing tables within the classroom that is not part of the assigned activity.\\\",\\\"number_of_occurrences\\\":0},{\\\"baseline_date\\\":\\\"2023-09-27T05:00:00.000Z\\\",\\\"baseline_level\\\":\\\"100\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"Object fixation\\\",\\\"topografical_definition\\\":\\\"Defined as persistent and intense visual concentration on a single physical object (typically a toy car), characterized by prolonged and unbroken eye contact with the object for a duration exceeding three minutes, and refusing to give it up to peers\\/adults.\\\",\\\"number_of_occurrences\\\":3},{\\\"baseline_date\\\":\\\"2023-09-27T05:00:00.000Z\\\",\\\"baseline_level\\\":\\\"25\\\",\\\"initial_interesting\\\":3,\\\"maladaptive_behavior\\\":\\\"Throwing objects\\\",\\\"topografical_definition\\\":\\\"Defined as propelling objects at least one foot from their original location by movement of hand or by kicking it (typically includes throwing donut inflatable chairs and other furniture in the classroom)\\\",\\\"number_of_occurrences\\\":3}]\"', '\"[{\\\"goal\\\":\\\"Request a break from non-preferred activity\\\",\\\"total_trials\\\":30,\\\"number_of_correct_response\\\":15}]\"', '\"[{\\\"pairing\\\":true,\\\"response_block\\\":true,\\\"DRA\\\":true}]\"', '12', 'happy', 'adsdas', 'dsadsa', 'dasdsa', 'excelent', '2024-09-06 19:00:00', 'https://abatherapy.malcolmcordova.com/backend-api-aba/storage/app/public/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, NULL, 4, NULL, NULL, 0, 0, '97153', 'ok', '2024-09-05 01:55:47', '2024-09-05 01:56:18', NULL),
(13, 1, 'test1', 1, 1, 'null', NULL, '2024-09-04 19:00:00', '09:00:00', '12:00:00', '12:00:00', '04:00:00', NULL, 'cambios en el ambiente', '\"[{\\\"baseline_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"baseline_level\\\":\\\"24\\\",\\\"initial_interesting\\\":12,\\\"maladaptive_behavior\\\":\\\"test\\\",\\\"topografical_definition\\\":\\\"testdsd teslts asd\\\",\\\"number_of_occurrences\\\":20}]\"', '\"[{\\\"goal\\\":\\\"testing on line\\\",\\\"total_trials\\\":10,\\\"number_of_correct_response\\\":5}]\"', '\"[{\\\"pairing\\\":true,\\\"response_block\\\":true,\\\"DRA\\\":true}]\"', '02', 'happy', 'adsdas', 'dasadsdas', NULL, 'excelent', '2024-09-06 19:00:00', 'https://abatherapy.malcolmcordova.com/backend-api-aba/storage/app/public/signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 1, 'https://abatherapy.malcolmcordova.com/backend-api-aba/storage/app/public/storage/signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', 10, NULL, NULL, 0, 0, '97153', 'pending', '2024-09-05 02:03:18', '2024-09-05 02:03:18', NULL);

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
  `address` text DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:male,2:female',
  `birth_date` timestamp NULL DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `patients`
--

INSERT INTO `patients` (`id`, `location_id`, `patient_id`, `first_name`, `last_name`, `email`, `phone`, `language`, `parent_guardian_name`, `relationship`, `home_phone`, `work_phone`, `school_name`, `school_number`, `zip`, `state`, `address`, `gender`, `birth_date`, `age`, `avatar`, `city`, `education`, `profession`, `schedule`, `summer_schedule`, `special_note`, `insurer_id`, `insuranceId`, `eqhlid`, `elegibility_date`, `pos_covered`, `deductible_individual_I_F`, `balance`, `coinsurance`, `copayments`, `oop`, `diagnosis_code`, `status`, `patient_control`, `pa_assessments`, `compayment_per_visit`, `insurer_secundary`, `welcome`, `consent`, `insurance_card`, `mnl`, `referral`, `ados`, `iep`, `asd_diagnosis`, `cde`, `submitted`, `eligibility`, `interview`, `rbt_home_id`, `rbt2_school_id`, `bcba_home_id`, `bcba2_school_id`, `clin_director_id`, `telehealth`, `pay`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'test1', 'test', 'test', 'test@test.com', '1234', 'test', 'test', 'test', '322344', '4223324', 'test', 'test', 'test', 'test', 'test', 1, '2024-07-12 11:00:00', '10', 'patients/uzL691VVhK0x08sh6GJWizvOl6UqBJf4IUhMNg8M.jpg', 'test', 'test', 'test', 'test', 'test', 'test', 1, 'test', 'test', '2024-07-12 11:00:00', '\"02 Telehealth\"', 'test', 'test', 'test', 'test', 'test', 'test', 'active', 'test', '\"[{\\\"pa_assessment\\\":\\\"dsadsa\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-13T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"dsadsaSS\\\",\\\"pa_services_start_date\\\":\\\"2024-07-14T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":400},{\\\"pa_assessment\\\":\\\"test\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"testServ\\\",\\\"pa_services_start_date\\\":\\\"2024-07-12T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97151\\\",\\\"n_units\\\":200},{\\\"pa_assessment\\\":\\\"paProver\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-25T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"paProverServ\\\",\\\"pa_services_start_date\\\":\\\"2024-07-25T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97151\\\",\\\"n_units\\\":23,\\\"provider\\\":\\\"BCBA\\\"},{\\\"pa_assessment\\\":\\\"dasdas\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-26T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"dasadsadsa\\\",\\\"pa_services_start_date\\\":\\\"2024-07-25T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":32},{\\\"pa_assessment\\\":\\\"Test\\\",\\\"pa_assessment_start_date\\\":\\\"2024-08-14T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-08-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"TestServicio\\\",\\\"pa_services_start_date\\\":\\\"2024-08-14T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-08-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97151\\\",\\\"n_units\\\":3000}]\"', NULL, NULL, 'waiting', 'requested', 'reviewing', 'waiting', 'waiting', 'waiting', 'waiting', 'requested', 'waiting', 'waiting', 'requested', 'send', 9, 9, 4, 4, 11, '\'false\'', '\'false\'', '2024-07-12 22:44:40', '2024-08-15 05:05:03', NULL),
(2, 4, 'paciente123', 'paciente', 'prueba', 'paciente@paciente.com', '2344332', 'paciente', 'paciente', 'paciente', '3243', '324432', 'paciente', '23144', 'paciente', 'paciente', 'paciente', 2, '2024-07-14 08:00:00', '4', 'patients/uzL691VVhK0x08sh6GJWizvOl6UqBJf4IUhMNg8M.jpg', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 2, 'paciente', 'paciente', '2024-07-14 08:00:00', '\"03 School,12 Home,02 Telehealth,99 Other\"', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 'paciente', 'inactive', 'paciente', '\"[{\\\"pa_assessment\\\":\\\"paciente\\\",\\\"pa_assessment_start_date\\\":\\\"2024-07-14T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"pacientew\\\",\\\"pa_services_start_date\\\":\\\"2024-07-13T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-07-31T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97151\\\",\\\"n_units\\\":233}]\"', NULL, NULL, 'requested', 'waiting', 'waiting', 'waiting', 'reviewing', 'reviewing', 'reviewing', 'requested', 'requested', 'waiting', 'requested', 'receive', 2, 2, 4, 4, 3, '\'false\'', '\'false\'', '2024-07-14 01:31:47', '2024-07-28 00:51:15', NULL),
(5, 3, '985590391', 'Elnathan', 'Abere', 'muleabere@gmail.com', '239-209-8105', 'English', 'MULUGETA ABITEW', 'FATHER', '239-209-8105', '239-209-8105', 'Edgewood academy', '(239) 334-6205', '33916', 'Florida', '3697 WINKLER AV, APT 518, FORT MYERS FL 33916', 1, '2017-06-27 11:00:00', '7', 'patients/PxQKS7VDy3vmzDXeDZqZScr7y3v7fr7sJu5wjeH0.jpg', 'FORT MYERS', '2nd Grade', 'e', 'SCHOOL [transferred to Edgewood academy 9/1/23 teacher wants max hrs) /HOME AFERNOON', '4/11/24- M-Th 9am-1pm, classes start June 11 ends July 18 per message from Michelle (JP).', 'undefined', 6, '985590391', 'Equhid?', '2024-06-01 11:00:00', '\"03 School,12 Home,02 Telehealth\"', '500', 'undefined', '15%', 'undefined', '3000', 'F84.0', 'active', 'EH0391', '\"[{\\\"pa_assessment\\\":\\\"KH1PCE-01\\\",\\\"pa_assessment_start_date\\\":\\\"2024-08-31T04:00:00.000Z\\\",\\\"pa_assessment_end_date\\\":\\\"2024-11-30T04:00:00.000Z\\\",\\\"pa_services\\\":\\\"4Q3FCQ-01\\\",\\\"pa_services_start_date\\\":\\\"2024-08-31T04:00:00.000Z\\\",\\\"pa_services_end_date\\\":\\\"2024-11-30T04:00:00.000Z\\\",\\\"cpt\\\":\\\"97153\\\",\\\"n_units\\\":3120}]\"', NULL, NULL, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'receive', 9, 12, 8, 8, 6, 'true', 'true', '2024-07-15 19:44:12', '2024-08-16 22:00:35', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` bigint(20) NOT NULL,
  `maladaptive` varchar(255) DEFAULT NULL,
  `current_status` varchar(155) DEFAULT NULL,
  `patient_id` varchar(150) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED NOT NULL,
  `goalstos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`goalstos`)),
  `goalltos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`goalltos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `reduction_goals`
--

INSERT INTO `reduction_goals` (`id`, `maladaptive`, `current_status`, `patient_id`, `client_id`, `bip_id`, `goalstos`, `goalltos`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', 'test', 'test1', 1, 1, '[{\"sto\":\"test\",\"date_sto\":\"2024-07-12T04:00:00.000Z\",\"status_sto\":\"inprogress\",\"maladaptive\":\"test\",\"decription_sto\":\"test\",\"status_sto_edit\":\"inprogress\",\"nombre\":\"Nuevo nombre\",\"end_date_sto\":\"2024-09-03T04:00:00.000Z\"}]', '[{\"lto\":\"test\",\"date_lto\":\"2024-07-12T04:00:00.000Z\",\"status_lto\":\"initiated\",\"decription_lto\":\"test\",\"nombre\":\"Nuevo nombre\",\"initial_date_lto\":\"2024-09-03T04:00:00.000Z\",\"end_date_lto\":\"2024-09-17T04:00:00.000Z\"}]', '2024-07-12 22:54:29', '2024-09-03 02:46:04', NULL),
(2, 'Physical aggression', 'Average of 11 incidents per week APR, 2024', '985590391', 5, 2, '[{\"index\":1,\"maladaptive\":\"Physical aggression\",\"sto\":\"STO #1\",\"status_sto\":\"mastered\",\"status_sto_edit\":\"mastered\",\"end_date_sto\":\"2024-03-16T04:00:00.000Z\",\"decription_sto\":\"client will reduce aggression from 15 to 10 incidents per week for four consecutive weeks.\",\"nombre\":\"Nuevo nombre\",\"date_sto\":\"2023-11-01T04:00:00.000Z\"},{\"index\":2,\"maladaptive\":\"Physical aggression\",\"sto\":\"STO #2\",\"status_sto\":\"inprogress\",\"status_sto_edit\":\"inprogress\",\"initial_date_sto\":null,\"end_date_sto\":null,\"decription_sto\":\"client will reduce aggression from 10 to 5 incidents per week for four consecutive weeks.\",\"nombre\":\"Nuevo nombre\",\"date_sto\":\"2024-03-17T04:00:00.000Z\"},{\"index\":3,\"maladaptive\":\"Physical aggression\",\"sto\":\"STO #3\",\"status_sto\":null,\"status_sto_edit\":null,\"initial_date_sto\":null,\"end_date_sto\":null,\"decription_sto\":\"client will reduce aggression from 5 to 0 incidents per week for four consecutive weeks.\"}]', '[{\"index\":1,\"lto\":\"LTO\",\"decription_lto\":\"client will maintain aggression near 0 incidents per week for 3 consecutive months.\"}]', '2024-07-15 20:39:11', '2024-09-05 06:45:09', NULL),
(3, 'Spitting', '35 incidents per week', '985590391', 5, 2, '[{\"index\":1,\"maladaptive\":\"Spitting\",\"sto\":\"STO #1\",\"status_sto\":\"mastered\",\"status_sto_edit\":\"mastered\",\"initial_date_sto\":null,\"end_date_sto\":\"2024-01-27T05:00:00.000Z\",\"decription_sto\":\"client will reduce spitting from 35 to 25 incidents per week for four consecutive weeks.\",\"nombre\":\"Nuevo nombre\",\"date_sto\":\"2023-11-01T04:00:00.000Z\"},{\"index\":2,\"maladaptive\":\"Spitting\",\"sto\":\"STO #2\",\"status_sto\":\"inprogress\",\"status_sto_edit\":\"inprogress\",\"initial_date_sto\":null,\"end_date_sto\":null,\"decription_sto\":\"client will reduce  spitting from 25 to 15 incidents per week for four consecutive weeks.\",\"nombre\":\"Nuevo nombre\",\"date_sto\":\"2024-01-28T05:00:00.000Z\"},{\"index\":3,\"maladaptive\":\"Spitting\",\"sto\":\"STO #3\",\"status_sto\":null,\"status_sto_edit\":null,\"initial_date_sto\":null,\"end_date_sto\":null,\"decription_sto\":\"client will reduce  spitting from 15 to 10 incidents per week for four consecutive weeks.\"},{\"index\":4,\"maladaptive\":\"Spitting\",\"sto\":\"STO #4\",\"status_sto\":null,\"status_sto_edit\":null,\"initial_date_sto\":null,\"end_date_sto\":null,\"decription_sto\":\"client will reduce  spitting from 10 to 5 incidents per week for four consecutive weeks.\"}]', '[{\"index\":1,\"lto\":\"LTO\",\"status_lto\":null,\"initial_date_lto\":null,\"end_date_lto\":null,\"decription_lto\":\"client will maintain  spitting near 0  incidents per week for 3 consecutive months.\"}]', '2024-07-23 05:01:25', '2024-09-05 06:30:27', NULL);

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
(1, 'SUPERADMIN', 'api', '2023-11-30 03:32:36', '2023-11-30 03:32:36'),
(2, 'MANAGER', 'api', '2023-12-01 04:09:47', '2024-01-26 05:05:33'),
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
(10, 2),
(11, 7),
(11, 8),
(12, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(37, 7),
(38, 2),
(38, 7),
(40, 2),
(41, 7),
(41, 8),
(44, 2),
(45, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(51, 7),
(52, 2),
(52, 7),
(53, 2),
(53, 7),
(53, 8),
(54, 2),
(55, 2),
(55, 7),
(55, 8),
(56, 2),
(56, 8),
(57, 2),
(57, 7),
(58, 2),
(58, 7),
(58, 8),
(59, 2),
(60, 2),
(62, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sustitution_goals`
--

CREATE TABLE `sustitution_goals` (
  `id` bigint(20) NOT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `current_status` varchar(155) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `patient_id` varchar(150) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bip_id` bigint(20) UNSIGNED NOT NULL,
  `goalstos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`goalstos`)),
  `goalltos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`goalltos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `sustitution_goals`
--

INSERT INTO `sustitution_goals` (`id`, `goal`, `current_status`, `description`, `patient_id`, `client_id`, `bip_id`, `goalstos`, `goalltos`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'testing on line', 'probando', 'testing', 'test1', NULL, 1, '[{\"index\":1,\"sustitution_sto\":\"1\",\"target\":\"30-45\",\"sustitution_status_sto\":\"inprogress\",\"sustitution_status_sto_edit\":\"inprogress\",\"sustitution_date_sto\":\"2024-09-02T04:00:00.000Z\",\"end_sustitution_date_sto\":\"2024-09-24T04:00:00.000Z\",\"sustitution_decription_sto\":\"dsdas\"},{\"index\":2,\"sustitution_sto\":\"2\",\"target\":\"30\",\"sustitution_status_sto\":\"on hold\",\"sustitution_status_sto_edit\":\"on hold\",\"sustitution_date_sto\":\"2024-09-12T04:00:00.000Z\",\"end_sustitution_date_sto\":\"2024-09-20T04:00:00.000Z\",\"sustitution_decription_sto\":\"asdas\",\"nombre\":\"Nuevo nombre\"}]', '[{\"index\":1,\"sustitution_lto\":\"32\",\"sustitution_status_lto\":\"inprogress\",\"sustitution_date_lto\":\"2024-09-02T04:00:00.000Z\",\"end_sustitution_date_lto\":\"2024-09-11T04:00:00.000Z\",\"sustitution_decription_lto\":\"das\"}]', '2024-07-12 22:55:00', '2024-09-03 03:54:28', NULL),
(2, 'Request a break from non-preferred activity', 'Baseline: 0% of opportunities, Baseline date: 9/7/23', NULL, '985590391', NULL, 2, '[{\"index\":2,\"sustitution_sto\":\"1\",\"target\":\"30-45\",\"sustitution_status_sto\":\"initiated\",\"sustitution_status_sto_edit\":\"initiated\",\"sustitution_date_sto\":\"2024-09-02T04:00:00.000Z\",\"end_sustitution_date_sto\":\"2024-09-18T04:00:00.000Z\",\"sustitution_decription_sto\":\"Elnathan will request a break from non-preferred activity, independently, in 50% of trials, across 4 consecutive weeks.\"},{\"index\":3,\"sustitution_sto\":\"2\",\"target\":\"30\",\"sustitution_status_sto\":\"on hold\",\"sustitution_status_sto_edit\":\"on hold\",\"sustitution_date_sto\":\"2024-09-02T04:00:00.000Z\",\"end_sustitution_date_sto\":null,\"sustitution_decription_sto\":\"Elnathan will request a break from non-preferred activity in 80% of trials, across 4 consecutive weeks.\"}]', '[{\"index\":1,\"sustitution_lto\":\"LTO\",\"sustitution_status_lto\":\"initiated\",\"sustitution_date_lto\":\"2024-09-01T04:00:00.000Z\",\"end_sustitution_date_lto\":\"2024-09-30T04:00:00.000Z\",\"sustitution_decription_lto\":\"Elnathan will maintain requesting a break from non-preferred activity, independently (no prompts), in 90% of trials, 3 consecutive months\"}]', '2024-07-15 18:55:11', '2024-09-05 04:51:40', '2024-09-05 04:51:40'),
(3, NULL, NULL, NULL, '985590391', NULL, 2, '[{\"sustitution_sto\":\"1\",\"target\":null,\"sustitution_status_sto\":\"inprogress\",\"sustitution_status_sto_edit\":\"inprogress\",\"sustitution_date_sto\":\"2023-12-23T06:00:00.000Z\",\"sustitution_decription_sto\":\"adsflasdjf;laksdjf;laksdf\"},{\"sustitution_sto\":\"2\",\"target\":null,\"sustitution_status_sto\":null,\"sustitution_status_sto_edit\":null,\"sustitution_date_sto\":null,\"sustitution_decription_sto\":\"fdsafsd;fjasd;lfkja;sdlkfja;sldkfa\"}]', '[]', '2024-08-28 01:14:05', '2024-09-03 02:50:03', '2024-09-03 02:50:03'),
(4, NULL, NULL, NULL, '985590391', NULL, 2, '[{\"sustitution_sto\":\"1\",\"target\":null,\"sustitution_status_sto\":\"inprogress\",\"sustitution_status_sto_edit\":\"inprogress\",\"sustitution_date_sto\":\"2023-12-23T06:00:00.000Z\",\"sustitution_decription_sto\":\"adsflasdjf;laksdjf;laksdf\"},{\"sustitution_sto\":\"2\",\"target\":null,\"sustitution_status_sto\":null,\"sustitution_status_sto_edit\":null,\"sustitution_date_sto\":null,\"sustitution_decription_sto\":\"fdsafsd;fjasd;lfkja;sdlkfja;sldkfa\"}]', '[]', '2024-08-28 01:14:05', '2024-09-03 02:49:30', '2024-09-03 02:49:30'),
(5, 'Group goal', 'Baseline: 0% of opportunities, Baseline date: 9/7/23', NULL, '985590391', NULL, 2, '[{\"index\":1,\"sustitution_sto\":\"1\",\"target\":\"30\",\"sustitution_status_sto\":\"inprogress\",\"sustitution_status_sto_edit\":\"inprogress\",\"sustitution_date_sto\":\"2024-03-12T04:00:00.000Z\",\"sustitution_decription_sto\":\"Will do what i say no matter what in the abcess of maladaptive behaviors.\"}]', '[{\"index\":1,\"sustitution_lto\":\"1\",\"sustitution_status_lto\":null,\"sustitution_date_lto\":null,\"end_sustitution_date_lto\":null,\"sustitution_decription_lto\":\"Will maintain\"}]', '2024-09-05 04:49:44', '2024-09-05 04:52:50', '2024-09-05 04:52:50'),
(6, 'Manding', '2', NULL, '985590391', NULL, 2, '[{\"index\":2,\"sustitution_sto\":\"2\",\"target\":\"40\",\"sustitution_status_sto\":null,\"sustitution_status_sto_edit\":null,\"sustitution_date_sto\":null,\"end_sustitution_date_sto\":null,\"sustitution_decription_sto\":\"Will do what i say no matter what in the abcess of maladaptive behaviors. (2)\"}]', '[{\"index\":1,\"sustitution_lto\":\"2\",\"sustitution_status_lto\":null,\"sustitution_date_lto\":null,\"end_sustitution_date_lto\":null,\"sustitution_decription_lto\":\"Will maintain doing what i say no matter what in the abcess of maladaptive behaviors. (2)\"}]', '2024-09-05 04:51:28', '2024-09-05 04:52:51', '2024-09-05 04:52:51'),
(7, '1', '1', 'description number 1', '985590391', NULL, 2, '[{\"index\":1,\"sustitution_sto\":\"1\",\"target\":\"100\",\"sustitution_status_sto\":\"initiated\",\"sustitution_status_sto_edit\":\"inprogress\",\"sustitution_date_sto\":\"2024-06-24T04:00:00.000Z\",\"end_sustitution_date_sto\":\"2024-09-25T04:00:00.000Z\",\"sustitution_decription_sto\":\"description number STO1\",\"nombre\":\"Nuevo nombre\"},{\"index\":2,\"sustitution_sto\":\"2\",\"target\":\"2\",\"sustitution_status_sto\":\"on hold\",\"sustitution_status_sto_edit\":null,\"sustitution_date_sto\":\"2024-09-09T04:00:00.000Z\",\"end_sustitution_date_sto\":\"2024-09-30T04:00:00.000Z\",\"sustitution_decription_sto\":\"description number STO2\",\"nombre\":\"Nuevo nombre\"}]', '[{\"index\":1,\"sustitution_lto\":\"1 (a)\",\"sustitution_status_lto\":\"on hold\",\"sustitution_date_lto\":\"2024-09-09T04:00:00.000Z\",\"end_sustitution_date_lto\":\"2024-09-17T04:00:00.000Z\",\"sustitution_decription_lto\":\"description number LTO1 (A)\",\"nombre\":\"Nuevo nombre\"}]', '2024-09-05 04:54:54', '2024-09-10 08:47:51', NULL),
(8, '2', '2', 'description number 2', '985590391', NULL, 2, '[{\"index\":1,\"sustitution_sto\":\"1 b\",\"target\":\"1b\",\"sustitution_status_sto\":\"inprogress\",\"sustitution_status_sto_edit\":\"inprogress\",\"sustitution_date_sto\":\"2024-06-24T04:00:00.000Z\",\"end_sustitution_date_sto\":null,\"sustitution_decription_sto\":\"description number STO1b\"},{\"index\":2,\"sustitution_sto\":\"2b\",\"target\":\"2b\",\"sustitution_status_sto\":null,\"sustitution_status_sto_edit\":null,\"sustitution_date_sto\":null,\"end_sustitution_date_sto\":null,\"sustitution_decription_sto\":\"description number STO2b\"}]', '[{\"index\":1,\"sustitution_lto\":\"1b\",\"sustitution_status_lto\":null,\"sustitution_date_lto\":null,\"end_sustitution_date_lto\":null,\"sustitution_decription_lto\":\"description number LTO1b\"}]', '2024-09-05 04:57:55', '2024-09-05 04:57:55', NULL);

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
  `gender` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1:masculino,2:femenino',
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
  `start_pay` varchar(20) DEFAULT NULL,
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
(1, 'superadmin', 'superadmin@superadmin.com', 'admin', '123456', '2024-07-13 11:00:00', 1, 'superadmin', 'staffs/wSxe6p5abooypssUKjD2qohIdo6dUTUKr4b7R5X3.webp', 'active', NULL, NULL, NULL, NULL, 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-11-30 03:32:36', '$2y$10$PiKCOHK3XOBlqiL0kgJwLOMILMA6uVAAS1ou7JqHsUQaH4yvPkAiC', 'guHmnxhKw1', '2023-11-30 03:32:36', '2024-08-06 22:20:52', NULL),
(2, 'rbt', 'rbt@rbt.com', 'rbt', '1234', '2024-07-10 15:00:00', 1, 'rbtTest', 'staffs/UWPksDTl4w3WAwK2xn6psDeOouWMp8JN4pUrfezP.jpg', 'incoming', 'adsdas', 'dasdas', 'dasdas', 'dasda', 'signatures/hgd4hos7DMVU8sVNeCvsOVbXnwkryeOezoI8hhNS.jpg', 'asdsa', 'dasdsa', 'dasdas', 'dsaads', '2024-07-03 23:00:00', '2024-07-05 19:00:00', '2024-07-01 23:00:00', 'adsdas', 'dsaads', 'dasdsa', 'dasads', 'adsdsa', '2024-07-16 12:00:00', 'das', 'dsa', 'das', 'das', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$xlMmmw9A39iN8OBQR8Tqg.ECe5RUOzgI7Zr3A1/ijTKLOZkiYrQwG', NULL, '2024-07-10 19:07:09', '2024-08-22 02:59:17', NULL),
(3, 'Manager', 'manager@manager.com', 'test', '1234', '2024-07-10 15:00:00', 1, 'rbtTest', 'staffs/wSHU4JbdabycHYWvc7zpVhM1Lfqhexs9g1adaDuZ.jpg', 'active', 'dasads', 'dasdas', 'dasda', 'dasda', 'signatures/qA0V6xTZ08eRFO5h37RjUHw2ZFmLDa8O17hTCZlt.jpg', 'adsdsa', 'asddas', 'dasdsa', 'dasads', '2024-07-10 23:00:00', '2024-07-11 19:00:00', '2024-07-12 23:00:00', 'adsds', 'dsads', 'dasa', 'dsaads', 'dsadas', '2024-07-11 12:00:00', 'adsads', 'dasd', 'dasdas', 'dasdas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$vkhiGJEBjSLgj5.qEIflsO6F4/DKgq8X3umL7qfZ4vcdlDS0eKHHS', NULL, '2024-07-10 19:16:37', '2024-07-17 00:08:25', NULL),
(4, 'BCBA', 'bcba@bcba.com', 'Doctor', '1234', '2024-07-13 15:00:00', 1, 'BCBA', 'staffs/J4r31sinY8k2ZgS5whghwwfqIU0nI7rUd8tSsioN.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$yWq7q.kOVs3GzUZt8V3X5umDu4Dyvu7EnbGbCNN2nGV/f5T4c0OY6', NULL, '2024-07-14 01:28:19', '2024-08-06 18:18:27', NULL),
(5, 'Maria Eugenia', 'apontemariae@gmail.com', 'Aponte', '+584122070144', '2024-01-10 15:00:00', 2, 'rbt address', 'staffs/mfSN3ItHhmfR5yHlXCt4ev2RVsq7Nkjh1cXJHQzx.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$lncqhyTE4SIRBjMhRvh88.qReitT3T4jQS8C9KGdz74umYY1QohNy', NULL, '2024-07-14 23:54:02', '2024-07-17 00:07:43', NULL),
(6, 'Alain', 'alain@practice-mgmt.com', 'Hernandez', '2397101864', '2024-03-11 11:00:00', 1, 'practice', 'staffs/phfsftyDEGE3UGXNk6JHWoeTOYLuSNLYIHjvFCd8.png', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$FOGpvXr5rr3yeH/LgFnWDugJ3/5QtATaXnP27Le1cZ3S.e.qy064W', NULL, '2024-07-15 19:12:44', '2024-08-18 19:35:04', NULL),
(7, 'Amber', 'manager@practice-mgmt.com', 'McKinney', '1234567', '2024-07-15 08:00:00', 2, NULL, 'staffs/TA5dFrrEJdsFkG5m4e4v5I0cdO2KiKk1VrXozLzi.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/ZtgOSP3pUdWOjkvpDU69RP0pazdLmneI1NgGa0ra.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$aw.DFJtlh85Emy5LP0yIwuMmkYFeu9V70BN2E3Adc33Q8Cv.f1pnK', NULL, '2024-07-15 19:14:40', '2024-08-06 18:17:47', NULL),
(8, 'Michelle', 'michelleguimoye@gmail.com', 'Guimoye', '239-634-9514', '1970-01-01 08:00:00', 2, 'Fort Myers', 'staffs/RQNkg0k73hswagNlsYh0mYVS4hUJT8VUUY5CeN7a.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$IClgEjs0svQgRMIm9/IBauBemi81gQ0liufj/It.u2JkVbiKsJBUC', NULL, '2024-07-15 19:16:20', '2024-08-06 18:16:16', NULL),
(9, 'Guyvenel', 'dumeusguyvenel@gmail.com', 'Dumeus', '239-823-3543', '2002-12-08 08:00:00', 1, 'Lehigh Acres', 'staffs/oGKYwkj34Yf9tBE6yR9dlzRxjRdDNQhh3cXE812O.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/gW9ap1aVO6VHLPXdWFWf6qvyl5sQwIkEeW8OwisA.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$W812AhxTBc.ILPUgoU1./OC5nCQjPE36EYl7KrBhH.uxmmNREwD5y', NULL, '2024-07-15 19:17:44', '2024-08-06 18:13:11', NULL),
(10, 'Mary', 'pinskeraba@gmail', 'Pinsker', '757-403-9287', '1970-10-19 11:00:00', 2, 'Telehealth', 'staffs/knrWsl0u3FK0fG92WkWA9nRY2ZQYtWOYvtzcw1pU.jpg', 'active', NULL, NULL, NULL, NULL, 'signatures/Bo2iRD8mPmhaNfMnOwBjkeT5qeZLGtb6NVFSJqYZ.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NPMaryPinker', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$OahddVzU4O4B.AE4FVWrqOP6zh5VFf8DWaEHLBR9JVlJUVNpt/qjK', NULL, '2024-07-15 19:21:03', '2024-08-06 22:55:16', NULL),
(11, 'Sucel', 'suceltejeda@yahoo.com', 'Tejeda', '2396286999', '2024-04-30 11:00:00', 2, '6660 Estero Blvd', 'staffs/1z543G2aNf1UgWNgrcyTFOPOu0KRadY6c9UHaJC3.jpg', 'active', 'CPtC', NULL, NULL, NULL, 'signatures/CJEhvzn17gCPfT5lU1FqgcYlqWWZ7yLNpJyziX61.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dasdas', 'NpiSucelPrueba', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$h27cdyHoTSk3Low7nJyckuJ0frh2lVmOM1IJN02XTy1r3DDr1R352', NULL, '2024-07-15 19:22:20', '2024-08-16 20:56:25', NULL),
(12, 'Christopher', 'mompremierchris@yahoo.com', 'Mompremier', '239-745-9812', '2024-07-15 12:00:00', 2, 'Lehigh Acres', 'staffs/x0XIzbrFevFkpFaK3zVLfkWwsLhjj7H4c3sy9KgC.jpg', 'active', 'ABA', 'ABA By Mompremier LLC', '99-1777439', '03/27/2026', 'signatures/xM3ratFhvTNtjb3pkbUjSycpy2lnfXH7JBtM9Q8Q.jpg', 'Florida', 'Lehigh Acres', 'English / Creole', '589-93-2052', '2023-08-13 12:00:00', '30', '2032-04-12 12:00:00', '06/23/2026', '03/21/2028', 'On file', 'Clear', 'RBT-23-277795', '2025-06-07 05:00:00', '08/03/2024', '02/02/2025', '1295419125', '119799000', '07/08/2025', 'yes', '06/29/2024', '07/09/2026', 'yes', '07/02/2099', 'yes', 'yes', 'yes', 'yes', NULL, NULL, '1099', 30, NULL, NULL, '$2y$10$LwcfUzfrQPvDuSkG41FWc.V8tr6Yy5M.OKCYCFiE3V4Lg3Rt19TDi', NULL, '2024-07-15 19:24:06', '2024-08-27 16:43:07', NULL),
(13, 'Allan', 'allan@practice-mgmt.com', 'Hernandez', '239-922-7513', '2000-01-26 15:00:00', 1, NULL, 'staffs/Z9q1QrzmRhucca0mvYXneay9mqA5WmHWb82QZfAT.jpg', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '$2y$10$noh7Ic/UPnxOzBRGLJ0LyuRCxMrGBzjjmd78eu9mk97jFsUjXwbbe', NULL, '2024-07-17 03:30:21', '2024-07-27 05:11:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_locations`
--

CREATE TABLE `user_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `user_locations`
--

INSERT INTO `user_locations` (`id`, `user_id`, `location_id`) VALUES
(28, 2, 5),
(170, 3, 1),
(171, 4, 2),
(172, 5, 3),
(178, 13, 6),
(179, 9, 2),
(180, 9, 3),
(181, 8, 3),
(182, 7, 4),
(183, 1, 4),
(185, 10, 1),
(192, 11, 2),
(193, 6, 3),
(197, 12, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `billings`
--
ALTER TABLE `billings`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_locations_user_id_foreign` (`user_id`),
  ADD KEY `user_locations_location_id_foreign` (`location_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `billings`
--
ALTER TABLE `billings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `client_reports`
--
ALTER TABLE `client_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `consent_to_treatments`
--
ALTER TABLE `consent_to_treatments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `crisis_plans`
--
ALTER TABLE `crisis_plans`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `de_escalation_techniques`
--
ALTER TABLE `de_escalation_techniques`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `family_envolments`
--
ALTER TABLE `family_envolments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `generalization_trainings`
--
ALTER TABLE `generalization_trainings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `note_rbts`
--
ALTER TABLE `note_rbts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `patient_files`
--
ALTER TABLE `patient_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `sustitution_goals`
--
ALTER TABLE `sustitution_goals`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

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
