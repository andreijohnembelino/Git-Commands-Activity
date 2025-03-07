-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 06:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lgu_health`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time DEFAULT NULL,
  `status` enum('Scheduled','Completed','Cancelled','Pending') DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `client_id`, `patient_name`, `doctor_id`, `appointment_date`, `appointment_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(7, NULL, NULL, 'dsadsa', 2, '2025-02-13', '08:00:00', 'Completed', 'awsdasdasdas', '2025-02-09 09:44:32', '2025-02-16 11:54:28'),
(13, NULL, NULL, 'kargo', 2, '2025-02-09', '17:46:00', 'Completed', 'dsadsa', '2025-02-09 09:47:01', '2025-02-16 11:54:34'),
(14, NULL, NULL, 'vfey', 2, '2025-02-09', '17:49:00', 'Completed', 'dasdsad', '2025-02-09 09:49:37', '2025-02-16 11:57:52'),
(15, NULL, NULL, 'marvin', 2, '2025-02-18', NULL, 'Completed', 'checkup', '2025-02-11 05:15:21', '2025-02-16 12:00:25'),
(16, NULL, NULL, 'mero', 2, '2025-02-13', '09:00:00', 'Completed', 'dasdsa', '2025-02-11 05:19:22', '2025-02-16 12:07:06'),
(17, NULL, 2, 'babaye', 2, '2025-02-13', '11:00:00', 'Completed', 'pacheck up', '2025-02-15 15:05:48', '2025-02-16 12:07:09'),
(18, NULL, 2, 'mero', 3, '2025-02-13', '14:00:00', 'Completed', 'dasdasdasd', '2025-02-16 12:19:02', '2025-02-16 12:19:16'),
(19, NULL, 2, 'tanginamo', 3, '2025-02-17', '10:00:00', 'Completed', 'tanginamo', '2025-02-16 12:23:23', '2025-02-16 12:23:50'),
(20, NULL, 2, 'kupal', 3, '2025-02-16', '15:00:00', 'Completed', 'fsddf', '2025-02-16 13:06:16', '2025-02-16 14:43:31'),
(21, NULL, 2, 'wtf', 3, '2025-02-19', '08:00:00', 'Completed', 'fasdfasd', '2025-02-16 14:53:12', '2025-02-16 14:55:26'),
(22, NULL, 2, 'sadasd', 3, '2025-02-12', '09:00:00', 'Completed', 'dasd', '2025-02-16 14:59:49', '2025-02-16 15:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `billing_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `billing_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Refunded') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `patient_id`, `full_name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, NULL, 'niel', 'niel123@gmail.com', '$2y$10$PUZAbajp7pxExlZuCDNRAOFC31WiLJcI1ilOa51S45WdFa4hXdXR2', NULL, '2025-02-08 10:10:32', '2025-02-08 10:10:32'),
(2, NULL, 'andrie paloma', 'paloma@gmail.com', '$2y$10$fOd6kFEbDOFWkhkp3mn7VOupGhuNgZMtX5oQ.jjudZVZHqYVWdd.u', 'Client', '2025-02-14 07:22:02', '2025-02-14 07:22:02'),
(3, NULL, 'edgeniel A. buhian', 'edgeniel16@gmail.com', '$2y$10$1KJzfxIxfpfUwtRVKktijelDoZodM8/jn8ZG3TKGLPayUt/UPYPZy', 'Client', '2025-02-16 13:39:53', '2025-02-16 13:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_assignments`
--

CREATE TABLE `doctor_assignments` (
  `assignment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` enum('Medicine','Supply','Equipment') DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item_name`, `category`, `quantity`, `unit_price`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 'Food pack', 'Supply', 35, 399.00, '2025-01-30 05:30:19', '2025-02-04 01:52:03', NULL, 1),
(3, 'Biogesic', 'Medicine', 100, 12.50, '2025-01-30 05:39:39', '2025-02-04 01:54:03', NULL, 1),
(4, 'Nubulizer', 'Equipment', 20, 1500.00, '2025-01-30 06:33:08', '2025-01-30 06:33:08', 2, NULL),
(5, 'battery', 'Equipment', 10, 10.00, '2025-02-02 05:33:13', '2025-02-02 12:17:34', 1, 1),
(6, 'can', 'Supply', 45, 10.00, '2025-02-02 13:54:37', '2025-02-04 01:49:37', 1, 1),
(7, 'filler', 'Supply', 14, 7.00, '2025-02-16 14:13:29', '2025-02-16 15:14:05', 3, 3),
(8, 'key board', 'Equipment', 25, 12.00, '2025-02-17 05:46:30', '2025-02-17 05:46:30', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `message`, `created_at`) VALUES
(1, 'New user registered: Full Name - edgeniel A. buhian, Email - edgeniel16@gmail.com, Role - Client', '2025-02-16 13:39:53'),
(2, 'New patient registered: Name - edgeniel A. buhian, DOB - 2025-02-06, Gender - Male, Contact - 09152130678, Address - k1 brgy pansol Q.C', '2025-02-16 13:51:50'),
(3, 'New patient registered: Name - edgeniel A. buhian, DOB - 2025-01-31, Gender - Male, Contact - 09152130678, Address - k1 brgy pansol Q.C', '2025-02-16 13:55:13'),
(4, 'New patient registered: Name - edgeniel A. buhian, DOB - 2025-02-06, Gender - Male, Contact - 09152130678, Address - k1 brgy pansol Q.C', '2025-02-16 13:57:22'),
(5, 'User with ID 3 added new inventory item: filler, Category: supply, Quantity: 12, Unit Price: 12', '2025-02-16 07:13:29'),
(6, 'Appointment ID 20 marked as completed by Doctor ID undefined at 2025-02-16T14:43:31.208Z', '2025-02-16 07:43:31'),
(7, 'Appointment ID 21 marked as completed by Doctor ID undefined at 2025-02-16T14:55:26.116Z', '2025-02-16 07:55:26'),
(8, 'Appointment ID 22 marked as completed by User ID 3 at 2025-02-16T15:02:06.435Z', '2025-02-16 08:02:06'),
(9, 'Inventory Item ID 7 updated by User ID 3 at 2025-02-16 16:14:05', '2025-02-16 08:14:05'),
(10, 'User with ID 6 added new inventory item: key board, Category: equipment, Quantity: 25, Unit Price: 12', '2025-02-16 22:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `client_id` int(15) DEFAULT NULL,
  `patient_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `selected_symptoms` varchar(255) DEFAULT NULL,
  `detailed_explanation` text DEFAULT NULL,
  `sickness_description` text DEFAULT NULL,
  `registration_type` enum('staff','self-registered') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admission_type` enum('staff','self-registered') DEFAULT 'staff',
  `patient_status` enum('active','discharged') DEFAULT 'active',
  `doctor_id` int(11) DEFAULT NULL,
  `published_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `client_id`, `patient_name`, `date_of_birth`, `age`, `gender`, `contact_number`, `address`, `medical_history`, `allergies`, `selected_symptoms`, `detailed_explanation`, `sickness_description`, `registration_type`, `created_at`, `updated_at`, `admission_type`, `patient_status`, `doctor_id`, `published_by`) VALUES
(2, NULL, 'test', '2025-01-01', 0, 'Female', '09152130678', 'k1 brgy pansol Q.C', 'mental', 'nuts', 'headache, musclePain', '9 years old with mild headache and severe muscle pain', 'Strain/Overexertion:**  Intense physical activity can cause significant muscle pain. Over-the-counter pain relief:**  For the headache and muscle pain, age-appropriate doses of acetaminophen (Tylenol) or ibuprofen (Advil, Motrin) can be given, following the instructions on the packaging carefully. **Always check with a doctor or pharmacist before giving any medication to a child.**', 'staff', '2025-01-25 08:45:08', '2025-02-07 11:14:24', 'staff', 'active', NULL, 1),
(3, NULL, 'edgeniel A. buhian', '2025-01-25', 0, 'Male', '09152130678', 'k1 brgy pansol Q.C', 'puyat', 'coding', 'fatigue, weakness, musclePain', '10 years old boy with weakness , fatigue, and mild muscle pain', '0', 'staff', '2025-01-25 08:53:50', '2025-02-06 09:24:45', 'staff', 'active', NULL, 1),
(4, NULL, 'margo', '2025-01-01', 0, 'Female', '09846387631', 'nova bayan', 'diabeties', 'shrimp', NULL, NULL, NULL, 'staff', '2025-01-26 05:47:51', '2025-01-26 05:47:51', 'staff', 'active', NULL, NULL),
(5, NULL, 'arthur morgan', '2025-01-01', 0, 'Male', '09163857438', 'black water', 'tuberculosis', 'sneeze', NULL, NULL, NULL, 'staff', '2025-01-26 06:05:44', '2025-01-26 06:05:44', 'staff', 'active', NULL, NULL),
(6, NULL, 'edgeniel A. buhian', '2023-03-28', 0, 'Male', '0915213123', 'k1 brgy pansol Q.C', 'dsfdsf', 'fdsf', NULL, NULL, NULL, 'staff', '2025-01-28 05:32:26', '2025-01-28 05:32:26', 'staff', 'active', NULL, NULL),
(7, NULL, 'art javar gwapo', '2018-02-28', 0, 'Female', '09152130567', 'k1 brgy pansol Q.C', 'puyat', 'codings', NULL, NULL, NULL, 'staff', '2025-01-28 05:34:23', '2025-01-28 05:34:23', 'staff', 'active', NULL, NULL),
(8, NULL, 'andrie embilino', '2014-02-28', 0, 'Male', '09152130561', 'k1 brgy pansol Q.C', 'dsfadsf', 'asdfdas', NULL, NULL, NULL, 'staff', '2025-01-28 05:41:03', '2025-01-28 05:41:03', 'staff', 'active', NULL, NULL),
(9, NULL, 'abdul wahid', '2011-02-28', 13, 'Male', '09152134678', 'k1 brgy pansol Q.C', 'dasdasd', 'asdasd', NULL, NULL, NULL, 'staff', '2025-01-28 05:55:10', '2025-01-28 05:55:10', 'staff', 'active', NULL, NULL),
(10, NULL, 'arthur morgan', '2015-02-28', 9, 'Male', '09232134578', 'Sandigan quezon city', 'Illnesses: Past illnesses, childhood illnesses, and current infections\nMedications: Medications taken, allergies, and any adverse reactions\nSurgeries: Major surgeries or operations\nImmunizations: Immunizations received\nPhysical exams: Results of physical exams and tests\nHealth habits: Diet, exercise, sleep, and personal habits\nFamily history: Family history of illnesses, such as cancer, diabetes, and heart disease\nChronic health conditions: Chronic health conditions, such as high blood pressure', 'shrimps and nuts', NULL, NULL, NULL, 'staff', '2025-01-28 07:27:06', '2025-01-28 07:27:06', 'staff', 'active', NULL, NULL),
(11, NULL, 'sophie arnold', '1988-02-04', 37, 'Female', '09152130345', 'k1 brgy pansol pasig', 'chest pain', 'nuts', 'soreThroat, runnyNose, sneezing', 'mild sore throat and minor runny nose with combination of sneezing and chills', 'Common Cold take rest and sleep peacefuly', 'staff', '2025-02-04 05:11:44', '2025-02-06 12:22:32', 'staff', 'active', NULL, 1),
(17, 2, 'andrie paloma', '2012-02-14', 13, 'Male', '0915213123', 'Nova bayan quezon city', 'di ko alam', 'bawal sa seafoods', 'fever, rash, itching', '13 year old male with allergies on seafoods with those following symptoms', '**1. Likely Diagnoses:**\\n\\nGiven the patient\\\'s history of seafood allergy and presentation of fever, rash (morbilliform, urticarial, or possibly other allergic reactions), and pruritus (itching), the following diagnoses should be considered in order of likelihood:\\n\\n\\n1. **Acute Urticaria:**  A type I hypersensitivity reaction characterized by wheals and flares.  The fever suggests a more systemic reaction.\\n\\n**Serum Sickness-like Reaction:**  A delayed-type hypersensitivity reaction to seafood proteins, potentially mimicking serum sickness with fever, rash, and arthralgia (though not explicitly mentioned).\\n3. **Infectious Exacerbation:** A superimposed viral or bacterial infection could exacerbate the allergic response, contributing to the fever.  Further investigation may be necessary to rule out this possibility.\\n4. **Anaphylaxis (less likely but needs to be excluded):** Though the symptoms aren\\\'t classically severe for anaphylaxis,  the presence of fever and systemic symptoms warrants careful consideration and exclusion.  A detailed history regarding respiratory compromise or hypotension is crucial.\\n\\n\\n**2. Recommendations:**\\n\\n1. **Assess for anaphylaxis:**  Immediately assess vital signs (blood pressure, heart rate, respiratory rate, oxygen saturation) to rule out anaphylaxis.  If any signs of respiratory distress or hypotension are present, initiate appropriate emergency management (e.g., epinephrine administration, airway management).\\n\\n2. **Complete Allergic Workup:**  Assess the specific seafood implicated. If there are multiple possible exposures, it is crucial to identify the responsible allergen. Skin prick testing or serum-specific IgE testing should be considered for precise identification of the causative allergen.  Consider cross-reactivity testing given the potential for multiple allergens in seafood.\\n\\n3. **Supportive Care:**  Administer antipyretics (e.g., acetaminophen or ibuprofen) for fever management.  For pruritus, consider oral antihistamines (e.g., cetirizine, fexofenadine) or topical corticosteroids (hydrocortisone cream) if the rash is localized.   Cool compresses may also help.\\n\\n4. **Antihistamine Management:**  Initiate high-dose oral antihistamines (e.g., diphenhydramine or hydroxyzine) to manage the acute allergic reaction.  Consider the addition of a corticosteroid (e.g., prednisone) if symptoms are severe or unresponsive to antihistamines.  Adjust dosage based on the patient’s clinical response.\\n\\n5. **Infectious Workup:**  If clinical suspicion for a co-existing infection persists (e.g., elevated white blood cell count), obtain relevant laboratory investigations (complete blood count with differential, blood cultures if indicated).\\n\\n6. **Close Monitoring:**  The patient requires close observation for at least 24 hours to assess for any deterioration in clinical status.  Advise the family about potential worsening symptoms and the importance of prompt return if they occur.\\n\\n7. **Patient/Family Education:**  Provide detailed education on the avoidance of the identified allergen(s) and the importance of carrying an epinephrine auto-injector (if appropriate based on the allergic reaction).\\n\\n8. **Referral:**  Consider referral to an allergist/immunologist for long-term management and allergy desensitization if necessary.', 'staff', '2025-02-14 11:46:40', '2025-02-14 11:49:11', 'self-registered', 'active', NULL, 3),
(20, NULL, 'edgeniel A. buhian', '2025-01-29', 0, 'Male', '09152130678', 'k1 brgy pansol Q.C', 'asdas', 'sdasd', NULL, NULL, NULL, 'staff', '2025-02-16 13:49:46', '2025-02-16 13:49:46', 'staff', 'active', NULL, NULL),
(24, NULL, 'edgeniel A. buhian', '2025-02-06', 0, 'Male', '09152130678', 'k1 brgy pansol Q.C', 'asdas', 'asdas', NULL, NULL, NULL, 'staff', '2025-02-16 13:57:21', '2025-02-16 13:57:21', 'staff', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Doctor','Nurse','Receptionist') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$tqIBdQ9mdRYG/9EJQOIOwe9ngIvkESx.fSY8sTKybjrGbmHvDAVlW', 'Admin', '2025-01-25 06:48:01', '2025-02-12 12:18:02'),
(2, 'Art javar', 'art@gmail.com', '$2y$10$FfLiMmPM7YBsFmYcvSwcherc3XDpEx2UMHoyGvpWpZo.uNIPKHAZC', 'Doctor', '2025-01-26 11:55:37', '2025-02-11 12:26:00'),
(3, 'Abdul Wahid', 'abdul@gmail.com', '$2y$10$CuZd0JNFFafa/yaivuNQ5uUU4rdXuY61aIhxbFewoF2RNquLL31BW', 'Doctor', '2025-02-11 07:05:25', '2025-02-11 07:05:25'),
(6, 'Andrie Embilino', 'andrie@gmail.com', '$2y$10$1mLM.GY5FzT3elMjwToFXuB/3aJAnGtoaFLK9F12IXNJYNwvO3CQW', 'Nurse', '2025-02-16 12:35:15', '2025-02-16 12:35:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`billing_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `doctor_assignments`
--
ALTER TABLE `doctor_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `fk_patients_users` (`doctor_id`),
  ADD KEY `published_by` (`published_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor_assignments`
--
ALTER TABLE `doctor_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`),
  ADD CONSTRAINT `billing_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `doctor_assignments`
--
ALTER TABLE `doctor_assignments`
  ADD CONSTRAINT `doctor_assignments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `doctor_assignments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_patients_users` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`published_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
