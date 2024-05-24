-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24 مايو 2024 الساعة 07:24
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_textbooks_sharing`
--

-- --------------------------------------------------------

--
-- بنية الجدول `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userName` varchar(40) NOT NULL,
  `phoneNumber` varchar(9) DEFAULT NULL,
  `emailVerified` tinyint(1) NOT NULL DEFAULT 0,
  `phoneVerified` tinyint(1) NOT NULL DEFAULT 0,
  `fcm_token` varchar(255) DEFAULT NULL,
  `exist` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','point','admin') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `accounts`
--

INSERT INTO `accounts` (`id`, `userName`, `phoneNumber`, `emailVerified`, `phoneVerified`, `fcm_token`, `exist`, `password`, `email`, `role`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Micah@', '711763790', 0, 0, NULL, 0, '$2y$12$/LiEHAi2QxmCWUkKpjqC8unf5wBmKWT6lxWIXLVnJAC5mhqMnf.sa', 'oral.beatty@ruecker.biz', 'user', 'tjU7a0smoC', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(2, 'Emelia@', '704035437', 0, 0, NULL, 0, '$2y$12$uBV57hFzWF44J74xKLZJQOg0MjpOY2/GIfZeRx9bIR.5xNoIu.nky', 'homenick.braulio@hoppe.com', 'user', 'WNquaLdiuw', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(3, 'Ladarius@', '785275227', 0, 0, NULL, 0, '$2y$12$qbDTsYiGunSvkNI68E/L6.rSD6NaFM0IV8zwkp9v27uQW6rk4hl7S', 'pkunze@senger.biz', 'user', '9Sgy2ePlx1', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(4, 'Mireya@', '789118316', 0, 0, NULL, 0, '$2y$12$p9PYpTkafjdbZlVIQMUciOTbqAnT71boL6s9LqTGsM6Q9z3LL7U1G', 'oconner.nathan@yahoo.com', 'user', 'WwfTFcVrsD', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(5, 'Efrain@', '703565120', 0, 0, NULL, 0, '$2y$12$whq04iSLJc5Al5sFr/6o7upB3p6//Y1JeqDY2Yr.XWNP4JytivXey', 'tianna54@rice.com', 'user', 'b8CC8GY6Hd', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(6, 'Carlo@', '775019340', 0, 0, NULL, 0, '$2y$12$C5kF66T2kxeQPgmAY0aqeOfo.R6X1U0UPpqkqsj7aoFeddQssOD92', 'acollier@daugherty.org', 'user', 'oS5qYmxSAK', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(7, 'Rahul@', '716937189', 0, 0, NULL, 0, '$2y$12$IbwkCJtwn88FjaVwWWh/nON.IMjnB8oonoNCD53ya8cfeTgWnOOGW', 'halvorson.frederique@hotmail.com', 'user', 'p9IzydTYVV', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(8, 'Cooper@', '735742125', 0, 0, NULL, 0, '$2y$12$Y1bjh.LaQ.D228k4TAMReOcZwfQKA5FX5LZfCsmAvqe4.tquw/ucq', 'mhilpert@hotmail.com', 'user', 'ATeVf0mru6', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(9, 'Abbey@', '701936455', 0, 0, NULL, 0, '$2y$12$2zoTbVqaBXj8gGtgPa.qd.e8fGacDDbSP4OVQlh7A/kNczsv.saLq', 'lucile.quitzon@fadel.net', 'user', 'fAmP84C8NL', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(10, 'Filomena', '783964127', 0, 0, NULL, 0, '$2y$12$Z87CpqhLYLshRXv2XPelreLCJFv8rHpJmKMZecJvWUB6mlFs7GHkW', 'pfahey@stanton.info', 'user', 'sukN7xtLgk', NULL, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(11, 'Werner@', '772567603', 0, 0, NULL, 0, '$2y$12$mnqbwHbInpXYOt2nb/E2MehDzzTs8ityMb.y51loqX2tjxuLQ9dkq', 'uweber@morissette.biz', 'point', 'CFvN054Vmx', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(12, 'Bethany', '774154770', 0, 0, NULL, 0, '$2y$12$1mcN7Ck29vCldjbMi163suKtPfKa3Gjs9Z/eCsdJjgY2C1Sjo5iMS', 'madelyn.halvorson@hotmail.com', 'point', 'Hz7p24IIGV', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(13, 'Sandra', '774629733', 0, 0, NULL, 0, '$2y$12$VACxDd4XOc2jB1aIV6UgBeKkxrw1XMEeNq.kYlX1Dz09aIw7BWWjS', 'jamey07@yahoo.com', 'point', 'DdtXGnEjnr', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(14, 'Lyla', '713256477', 0, 0, NULL, 0, '$2y$12$tu5yVTHV3d7bZTX6x1PApeZ1OZ0.aK2c.NygjRgpWsCXP9U1LG7mO', 'lbogan@hotmail.com', 'point', '84RWN2u99x', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(15, 'Roslyn', '778448320', 0, 0, NULL, 0, '$2y$12$6s65MzwnPMOHmFOxV3gmcecVwwh60upmUXpocB.bZs73NYtfRT6D2', 'jwest@yahoo.com', 'point', 'dmOQ36cA9D', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(16, 'Ola', '788306624', 0, 0, NULL, 0, '$2y$12$WBGCbxp5mJ4poZTyOzyCVOLdBr4bEevI2gZLIzWU.RJIhVnWzUgdq', 'murazik.ron@yahoo.com', 'point', 'cSeF24lx4g', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(17, 'Kaci', '788114087', 0, 0, NULL, 0, '$2y$12$5uDQzogyyYVY.rfH6RiRF.qtm5flgFgTqBeNKSGoH3mFYeHBm8QLS', 'bconroy@kuvalis.com', 'point', 'YT1P3r0NpO', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(18, 'Marcelino', '717670418', 0, 0, NULL, 0, '$2y$12$AduNZcjaak0dcoBJoJTEcejuC8WJ728BTW6n4gejHk2Nfk3o73EtW', 'xkunze@padberg.com', 'point', '90FnRFd58U', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(19, 'Magdalen', '711190945', 0, 0, NULL, 0, '$2y$12$jIJffiYz2/pNDvfeu8aD2OCyx03Xq3elC7VOG6XYtC4S.u87AjhYi', 'phoppe@halvorson.com', 'point', 'IwlYh2aS2u', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(20, 'Jennifer', '703695065', 0, 0, NULL, 0, '$2y$12$YTtx7FvTC3MkIe7uIzNRwuDRBi4XH4CNHx8KY7RJE4umt5/jkd/Ja', 'acassin@gmail.com', 'point', '2i8IN2cdnt', NULL, '2024-05-23 10:40:14', '2024-05-23 10:40:14');

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `admin_city`
--

CREATE TABLE `admin_city` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `book_donations`
--

CREATE TABLE `book_donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `donor_id` bigint(20) UNSIGNED NOT NULL,
  `exchangePoint_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level` enum('أولى إعدادي','ثاني إعدادي','ثالث إعدادي','رابع إعدادي','خامس إعدادي','سادس إعدادي','سابع إعدادي','ثامن إعدادي','تاسع إعدادي','أولى ثانوي','ثاني ثانوي','ثالث ثانوي') NOT NULL,
  `semester` enum('الفصل الأول','الفصل الثاني','كلا الفصلين') NOT NULL,
  `status` enum('غير محجوز وليس في النقطة','محجوز في انتظار الاستلام','غير محجوز في النقطة','محجوز في انتظار التسليم','تم التسليم','تم الحذف من النقطة',' تم الحذف من المدير','تم رفض التبرع') NOT NULL DEFAULT 'غير محجوز وليس في النقطة',
  `canAcceptEvenItIsNotWaited` tinyint(1) NOT NULL DEFAULT 0,
  `donorName` varchar(255) DEFAULT NULL,
  `isHided` tinyint(1) NOT NULL DEFAULT 0,
  `description` varchar(1000) DEFAULT NULL,
  `receiptDate` datetime DEFAULT NULL,
  `startLeadTimeDateForDonor` datetime DEFAULT NULL,
  `isRemovable` tinyint(1) NOT NULL DEFAULT 0,
  `no_rejecting` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `book_donations`
--

INSERT INTO `book_donations` (`id`, `donor_id`, `exchangePoint_id`, `level`, `semester`, `status`, `canAcceptEvenItIsNotWaited`, `donorName`, `isHided`, `description`, `receiptDate`, `startLeadTimeDateForDonor`, `isRemovable`, `no_rejecting`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'أولى إعدادي', 'الفصل الأول', 'غير محجوز وليس في النقطة', 0, 'سالم بن حيدر', 0, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(2, 1, 1, 'ثالث ثانوي', 'كلا الفصلين', 'غير محجوز وليس في النقطة', 0, 'أحمد صالح الجنيدي', 0, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(3, 1, 1, 'سادس إعدادي', 'كلا الفصلين', 'غير محجوز وليس في النقطة', 0, 'ياسمين صبري باعطية', 0, 'الكتب بحالة مقبولة، بعض التمزقات الصغيرة في الصفحات الأخيرة، ولكن النصوص والصور لا تزال واضحة. هناك بعض الشروحات بخط اليد على الهوامش التي قد تكون مفيدة للطلاب في فهم المحتوى بشكل أفضل. الغلاف يظهر علامات الاستعمال ولكنه لا يزال بحالة جيدة. مناسبة للاستخدام اليومي دون عوائق كبيرة.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(4, 1, 1, 'سابع إعدادي', 'كلا الفصلين', 'غير محجوز وليس في النقطة', 0, 'سنان حسن باجابر', 0, 'الكتب بحالة جيدة، مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش التي لا تؤثر على القراءة. الغلاف بحالة جيدة والصفحات سليمة وواضحة. الكتب تعتبر إضافة قيمة لمكتبة أي طالب يسعى للتفوق الدراسي. ستفيد هذه الكتب الطلاب بشكل كبير في تحصيلهم العلمي.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(5, 1, 1, 'رابع إعدادي', 'الفصل الثاني', 'محجوز في انتظار الاستلام', 0, 'عثمان أرطغرل باقلاقل', 1, 'الكتب بحالة جيدة جدًا، الغلاف نظيف وأنيق مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش. جميع الصفحات سليمة وواضحة، ولا توجد أي تمزقات أو صفحات مفقودة. يمكن للطلاب الاستفادة من هذه الكتب دون أي مشاكل في القراءة أو الفهم. تعتبر هذه الكتب إضافة ممتازة لأي مكتبة مدرسية.', NULL, '2024-05-23 20:21:29', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:21:29'),
(6, 1, 1, 'سادس إعدادي', 'الفصل الأول', 'محجوز في انتظار الاستلام', 0, 'فحرية علي بن محفوظ', 1, 'الكتب بحالة مقبولة، بعض التمزقات الصغيرة في الصفحات الأخيرة، ولكن النصوص والصور لا تزال واضحة. هناك بعض الشروحات بخط اليد على الهوامش التي قد تكون مفيدة للطلاب في فهم المحتوى بشكل أفضل. الغلاف يظهر علامات الاستعمال ولكنه لا يزال بحالة جيدة. مناسبة للاستخدام اليومي دون عوائق كبيرة.', NULL, '2024-05-23 20:21:37', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:21:37'),
(7, 1, 1, 'أولى إعدادي', 'الفصل الأول', 'محجوز في انتظار الاستلام', 0, 'فوزية حسن بن جوبح', 1, 'الكتب بحالة جيدة، مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش التي لا تؤثر على القراءة. الغلاف بحالة جيدة والصفحات سليمة وواضحة. الكتب تعتبر إضافة قيمة لمكتبة أي طالب يسعى للتفوق الدراسي. ستفيد هذه الكتب الطلاب بشكل كبير في تحصيلهم العلمي.', NULL, '2024-05-23 20:21:43', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:21:43'),
(8, 1, 1, 'أولى إعدادي', 'الفصل الثاني', 'محجوز في انتظار الاستلام', 0, 'منير محمد سالمين جمل الليل', 1, 'الكتب بحالة جيدة جدًا، الغلاف نظيف وأنيق مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش. جميع الصفحات سليمة وواضحة، ولا توجد أي تمزقات أو صفحات مفقودة. يمكن للطلاب الاستفادة من هذه الكتب دون أي مشاكل في القراءة أو الفهم. تعتبر هذه الكتب إضافة ممتازة لأي مكتبة مدرسية.', NULL, '2024-05-23 20:21:52', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:21:52'),
(9, 1, 1, 'أولى ثانوي', 'الفصل الأول', 'محجوز في انتظار التسليم', 0, 'رشا هادي النهدي', 1, 'الكتب بحالة جيدة جدًا، الغلاف نظيف وبعض الرسومات البيانية ملونة بالقلم مما يسهل الفهم. الصفحات سليمة وواضحة، ولا توجد أي علامات استعمال بارزة. الكتب جاهزة للاستخدام وتوفر تجربة دراسة مريحة وفعالة. مناسبة لأي طالب يحتاج إلى موارد دراسية جيدة.', '2024-05-23 20:28:30', '2024-05-23 20:23:00', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:28:30'),
(10, 1, 1, 'ثاني ثانوي', 'الفصل الأول', 'محجوز في انتظار التسليم', 0, 'منيرة علي العمودي', 1, 'الكتب بحالة جيدة، مع بعض الحواف المهترئة قليلاً ولكنها لا تؤثر على المحتوى الداخلي. النصوص والصور بحالة ممتازة، ولا توجد أي تمزقات أو صفحات مفقودة. يمكن للطلاب الاعتماد على هذه الكتب للدراسة والمراجعة بارتياح. تعد هذه الكتب خياراً رائعاً للطلاب الذين يحتاجون إلى موارد دراسية موثوقة.', '2024-05-23 20:28:36', '2024-05-23 20:23:42', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:28:36'),
(11, 1, 1, 'أولى إعدادي', 'الفصل الأول', 'محجوز في انتظار التسليم', 0, 'محمد سالم بازنيور', 1, 'الكتب بحالة جيدة جدًا، الغلاف نظيف وبعض العلامات بالقلم الرصاص. جميع الصفحات سليمة ولا توجد أي تمزقات.', '2024-05-23 20:28:42', '2024-05-23 20:23:48', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:28:42'),
(12, 1, 1, 'خامس إعدادي', 'كلا الفصلين', 'محجوز في انتظار التسليم', 0, 'أحمد سالم بازنبور', 1, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.\nالعلوم: الكتاب بحالة جيدة، الغلاف يظهر عليه بعض علامات الاستعمال. هناك بعض الشروحات بخط اليد على الهوامش التي قد تكون مفيدة للطلاب.\n\nالتربية الإسلامية: الكتاب بحالة ممتازة، نظيف وجميع الصفحات سليمة. لا توجد أي كتابات داخل الكتاب.\n\nالجغرافيا: الكتاب بحالة جيدة، الغلاف مشوه قليلًا عند الحواف. يوجد بعض العلامات البسيطة في الداخل ولكن النصوص والصور واضحة وسهلة القراءة.\n\nالتاريخ: الكتاب بحالة جيدة، الغلاف الأمامي والخلفي سليمان. يوجد بعض البقع الخفيفة على الصفحات الأولى ولكن لا تؤثر على القراءة.', '2024-05-23 20:28:48', '2024-05-23 20:23:54', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:28:48'),
(13, 1, 1, 'تاسع إعدادي', 'الفصل الثاني', 'تم رفض التبرع', 0, 'فايزة سالم بازنبور', 1, 'الكتب بحالة ممتازة، لا توجد علامات استعمال واضحة. الصفحات نظيفة وواضحة، والغلاف بحالة جيدة جداً. الكتب تبدو وكأنها جديدة مما يجعلها خيارًا رائعًا للطلاب الذين يحتاجون إلى مواد دراسية موثوقة. تعتبر هذه الكتب استثماراً جيداً في التعليم.', '2024-05-23 20:29:08', '2024-05-23 20:24:00', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:29:08'),
(14, 1, 1, 'ثالث ثانوي', 'الفصل الثاني', 'تم رفض التبرع', 0, 'مروة سالم بازنبور', 1, 'الكتب بحالة مقبولة، مع بعض البقع الخفيفة على الصفحات الأولى التي لا تؤثر على القراءة. الشروحات بخط اليد على الهوامش مفيدة للطلاب لفهم النقاط الصعبة. الغلاف يظهر بعض علامات الاستعمال ولكنه لا يزال في حالة جيدة. هذه الكتب مفيدة جداً للفهم العميق للمحتوى الدراسي', '2024-05-23 20:29:14', '2024-05-23 20:24:06', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:29:14'),
(15, 1, 1, 'ثالث ثانوي', 'الفصل الثاني', 'تم رفض التبرع', 0, 'مروة سالم بازنبور', 1, 'الكتب بحالة مقبولة، مع بعض البقع الخفيفة على الصفحات الأولى التي لا تؤثر على القراءة. الشروحات بخط اليد على الهوامش مفيدة للطلاب لفهم النقاط الصعبة. الغلاف يظهر بعض علامات الاستعمال ولكنه لا يزال في حالة جيدة. هذه الكتب مفيدة جداً للفهم العميق للمحتوى الدراسي', '2024-05-23 20:30:38', '2024-05-23 20:25:10', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:30:38'),
(16, 1, 1, 'رابع إعدادي', 'الفصل الثاني', 'تم رفض التبرع', 0, 'عثمان أرطغرل باقلاقل', 1, 'الكتب بحالة جيدة جدًا، الغلاف نظيف وأنيق مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش. جميع الصفحات سليمة وواضحة، ولا توجد أي تمزقات أو صفحات مفقودة. يمكن للطلاب الاستفادة من هذه الكتب دون أي مشاكل في القراءة أو الفهم. تعتبر هذه الكتب إضافة ممتازة لأي مكتبة مدرسية.', '2024-05-23 20:30:45', '2024-05-23 20:26:12', 0, 0, '2024-05-23 10:40:14', '2024-05-23 17:30:45'),
(17, 2, 1, 'سادس إعدادي', 'الفصل الأول', 'غير محجوز وليس في النقطة', 0, 'فحرية علي بن محفوظ', 0, 'الكتب بحالة مقبولة، بعض التمزقات الصغيرة في الصفحات الأخيرة، ولكن النصوص والصور لا تزال واضحة. هناك بعض الشروحات بخط اليد على الهوامش التي قد تكون مفيدة للطلاب في فهم المحتوى بشكل أفضل. الغلاف يظهر علامات الاستعمال ولكنه لا يزال بحالة جيدة. مناسبة للاستخدام اليومي دون عوائق كبيرة.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(18, 2, 1, 'أولى إعدادي', 'الفصل الأول', 'غير محجوز وليس في النقطة', 0, 'فوزية حسن بن جوبح', 0, 'الكتب بحالة جيدة، مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش التي لا تؤثر على القراءة. الغلاف بحالة جيدة والصفحات سليمة وواضحة. الكتب تعتبر إضافة قيمة لمكتبة أي طالب يسعى للتفوق الدراسي. ستفيد هذه الكتب الطلاب بشكل كبير في تحصيلهم العلمي.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(19, 2, 1, 'أولى إعدادي', 'الفصل الثاني', 'غير محجوز وليس في النقطة', 0, 'منير محمد سالمين جمل الليل', 0, 'الكتب بحالة جيدة جدًا، الغلاف نظيف وأنيق مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش. جميع الصفحات سليمة وواضحة، ولا توجد أي تمزقات أو صفحات مفقودة. يمكن للطلاب الاستفادة من هذه الكتب دون أي مشاكل في القراءة أو الفهم. تعتبر هذه الكتب إضافة ممتازة لأي مكتبة مدرسية.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(20, 2, 1, 'أولى إعدادي', 'الفصل الأول', 'غير محجوز وليس في النقطة', 0, 'إسماعيل إسحاق باوزير', 0, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(21, 2, 1, 'ثالث ثانوي', 'كلا الفصلين', 'غير محجوز وليس في النقطة', 0, 'أحمد صالح الجنيدي', 0, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(22, 2, 1, 'سابع إعدادي', 'كلا الفصلين', 'غير محجوز وليس في النقطة', 0, 'سنان حسن باجابر', 0, 'الكتب بحالة جيدة، مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش التي لا تؤثر على القراءة. الغلاف بحالة جيدة والصفحات سليمة وواضحة. الكتب تعتبر إضافة قيمة لمكتبة أي طالب يسعى للتفوق الدراسي. ستفيد هذه الكتب الطلاب بشكل كبير في تحصيلهم العلمي.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(23, 2, 1, 'ثاني ثانوي', 'الفصل الأول', 'غير محجوز وليس في النقطة', 0, 'منيرة علي العمودي', 0, 'الكتب بحالة جيدة، مع بعض الحواف المهترئة قليلاً ولكنها لا تؤثر على المحتوى الداخلي. النصوص والصور بحالة ممتازة، ولا توجد أي تمزقات أو صفحات مفقودة. يمكن للطلاب الاعتماد على هذه الكتب للدراسة والمراجعة بارتياح. تعد هذه الكتب خياراً رائعاً للطلاب الذين يحتاجون إلى موارد دراسية موثوقة.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(24, 2, 1, 'خامس إعدادي', 'كلا الفصلين', 'غير محجوز وليس في النقطة', 0, 'أحمد سالم بازنبور', 0, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.\r\nالعلوم: الكتاب بحالة جيدة، الغلاف يظهر عليه بعض علامات الاستعمال. هناك بعض الشروحات بخط اليد على الهوامش التي قد تكون مفيدة للطلاب.\r\n\r\nالتربية الإسلامية: الكتاب بحالة ممتازة، نظيف وجميع الصفحات سليمة. لا توجد أي كتابات داخل الكتاب.\r\n\r\nالجغرافيا: الكتاب بحالة جيدة، الغلاف مشوه قليلًا عند الحواف. يوجد بعض العلامات البسيطة في الداخل ولكن النصوص والصور واضحة وسهلة القراءة.\r\n\r\nالتاريخ: الكتاب بحالة جيدة، الغلاف الأمامي والخلفي سليمان. يوجد بعض البقع الخفيفة على الصفحات الأولى ولكن لا تؤثر على القراءة.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(25, 2, 1, 'أولى إعدادي', 'الفصل الثاني', 'غير محجوز وليس في النقطة', 0, 'منير محمد سالمين جمل الليل', 0, 'الكتب بحالة جيدة جدًا، الغلاف نظيف وأنيق مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش. جميع الصفحات سليمة وواضحة، ولا توجد أي تمزقات أو صفحات مفقودة. يمكن للطلاب الاستفادة من هذه الكتب دون أي مشاكل في القراءة أو الفهم. تعتبر هذه الكتب إضافة ممتازة لأي مكتبة مدرسية.', NULL, NULL, 0, 0, '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(26, 1, 1, 'أولى ثانوي', 'الفصل الأول', 'تم التسليم', 0, 'سالم بن حيدر', 1, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.', '2024-05-24 03:56:29', '2024-05-24 03:54:56', 0, 0, '2024-05-23 10:40:14', '2024-05-24 00:58:30'),
(27, 1, 1, 'تاسع إعدادي', 'الفصل الأول', 'تم التسليم', 0, 'أحمد صالح الجنيدي', 1, 'الكتب بحالة ممتازة، نظيفة وخالية من أي علامات استعمال. جميع الصفحات واضحة والغلاف بحالة جيدة جدًا. الكتب تبدو وكأنها جديدة، مما يجعلها مثالية للاستخدام من قبل الطلاب الذين يبحثون عن موارد دراسية عالية الجودة. هذه الكتب ستساعد بشكل كبير في التحضير للامتحانات والدروس.', '2024-05-24 03:56:34', '2024-05-24 03:55:02', 0, 0, '2024-05-23 10:40:14', '2024-05-24 00:59:22'),
(28, 1, 1, 'سادس إعدادي', 'الفصل الأول', 'تم التسليم', 0, 'ياسمين صبري باعطية', 1, 'الكتب بحالة مقبولة، بعض التمزقات الصغيرة في الصفحات الأخيرة، ولكن النصوص والصور لا تزال واضحة. هناك بعض الشروحات بخط اليد على الهوامش التي قد تكون مفيدة للطلاب في فهم المحتوى بشكل أفضل. الغلاف يظهر علامات الاستعمال ولكنه لا يزال بحالة جيدة. مناسبة للاستخدام اليومي دون عوائق كبيرة.', '2024-05-24 03:56:39', '2024-05-24 03:55:08', 0, 0, '2024-05-23 10:40:14', '2024-05-24 01:00:03'),
(29, 1, 1, 'سابع إعدادي', 'كلا الفصلين', 'تم التسليم', 0, 'سنان حسن باجابر', 1, 'الكتب بحالة جيدة، مع بعض العلامات الخفيفة بالقلم الرصاص على الهوامش التي لا تؤثر على القراءة. الغلاف بحالة جيدة والصفحات سليمة وواضحة. الكتب تعتبر إضافة قيمة لمكتبة أي طالب يسعى للتفوق الدراسي. ستفيد هذه الكتب الطلاب بشكل كبير في تحصيلهم العلمي.', '2024-05-24 03:56:42', '2024-05-24 03:55:37', 0, 0, '2024-05-23 10:40:14', '2024-05-24 01:00:20');

-- --------------------------------------------------------

--
-- بنية الجدول `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(15) NOT NULL,
  `district` enum('أبين','عدن','البيضاء','الحديدة','الجوف','المهرة','المحويت','صنعاء','عمران','ذمار','حضرموت','حجة','إب','لحج','مأرب','ريمة','صعدة','شبوة','أرخبيل سقطرى','تعز') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `cities`
--

INSERT INTO `cities` (`id`, `name`, `district`, `created_at`, `updated_at`) VALUES
(1, 'المكلا', 'حضرموت', '2024-05-23 10:40:09', '2024-05-23 10:40:09'),
(2, 'العين', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(3, 'العين', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(4, 'حريضة', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(5, 'العين', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(6, 'تريم', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(7, 'سيئون', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(8, 'تريم', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(9, 'القطن', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(10, 'دوعن', 'حضرموت', '2024-05-23 10:40:10', '2024-05-23 10:40:10');

-- --------------------------------------------------------

--
-- بنية الجدول `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `device` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `email_verification_tokens`
--

CREATE TABLE `email_verification_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `exchange_points`
--

CREATE TABLE `exchange_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `residentialQuarter_id` bigint(20) UNSIGNED NOT NULL,
  `maxPackages` tinyint(3) UNSIGNED NOT NULL,
  `no_packages` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `locationDescription` varchar(100) DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `exchange_points`
--

INSERT INTO `exchange_points` (`id`, `account_id`, `residentialQuarter_id`, `maxPackages`, `no_packages`, `locationDescription`, `location`, `created_at`, `updated_at`) VALUES
(1, 11, 8, 30, 8, 'Eveniet nulla sequi reprehenderit officiis.', 'https://maps.app.goo.gl/ifWmzHfvSQvzkMyu5', '2024-05-23 10:40:14', '2024-05-24 01:00:20'),
(2, 12, 6, 18, 0, 'Quis natus sint dolor quibusdam incidunt.', 'https://maps.app.goo.gl/GdtGVs9vjt9yMxsH8', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(3, 13, 6, 30, 0, 'Voluptatum enim doloribus iusto est nulla.', 'https://maps.app.goo.gl/ayuuKA7F2rcBo95Y9', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(4, 14, 5, 13, 0, 'Officia veritatis adipisci aut voluptatem quos.', 'https://maps.app.goo.gl/ayuuKA7F2rcBo95Y9', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(5, 15, 7, 24, 0, 'In consectetur molestiae eaque.', 'https://maps.app.goo.gl/GdtGVs9vjt9yMxsH8', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(6, 16, 2, 20, 0, 'Expedita aut numquam aut error.', 'https://maps.app.goo.gl/ifWmzHfvSQvzkMyu5', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(7, 17, 8, 26, 0, 'Dolor qui tempore voluptas excepturi.', 'https://maps.app.goo.gl/GdtGVs9vjt9yMxsH8', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(8, 18, 1, 26, 0, 'Vitae consequatur illo vel quia fuga.', 'https://maps.app.goo.gl/ifWmzHfvSQvzkMyu5', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(9, 19, 8, 28, 0, 'Tempore est nihil magni quod.', 'https://maps.app.goo.gl/GdtGVs9vjt9yMxsH8', '2024-05-23 10:40:14', '2024-05-23 10:40:14'),
(10, 20, 9, 50, 0, 'In optio hic et voluptatem et est possimus.', 'https://maps.app.goo.gl/ifWmzHfvSQvzkMyu5', '2024-05-23 10:40:14', '2024-05-23 10:40:14');

-- --------------------------------------------------------

--
-- بنية الجدول `failed_jobs`
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
-- بنية الجدول `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bookDonation_id` bigint(20) UNSIGNED NOT NULL,
  `source` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `jobs`
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

--
-- إرجاع أو استيراد بيانات الجدول `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"0f28f1a8-1d9d-4a19-8130-ad61359b88e0\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"command\":\"O:36:\\\"App\\\\Jobs\\\\CancelReservationInPointJob\\\":3:{s:53:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000bookDonation_id\\\";i:5;s:45:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:00:47.288340\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716494447, 1716494389),
(2, 'default', '{\"uuid\":\"689f45b9-444f-4cf9-82e4-ee8c72036fc2\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:5;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 19:59:49.350729\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748030389, 1716494389),
(3, 'default', '{\"uuid\":\"3540f4db-171e-4a93-b35c-453d61ffab1f\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"command\":\"O:36:\\\"App\\\\Jobs\\\\CancelReservationInPointJob\\\":3:{s:53:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000bookDonation_id\\\";i:6;s:45:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:00:56.611026\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716494456, 1716494396),
(4, 'default', '{\"uuid\":\"05d83bb1-7f6b-4ac6-a0e9-33a058e6e3cb\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:6;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 19:59:56.661451\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748030396, 1716494396),
(5, 'default', '{\"uuid\":\"f1d78b5e-6e22-45ec-8f38-3e31771d0a5c\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"command\":\"O:36:\\\"App\\\\Jobs\\\\CancelReservationInPointJob\\\":3:{s:53:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000bookDonation_id\\\";i:7;s:45:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:01:05.777649\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716494465, 1716494405),
(6, 'default', '{\"uuid\":\"d91a2491-186e-43ab-a637-c3c39a0a2d6e\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:7;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:00:05.824664\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748030405, 1716494405),
(7, 'default', '{\"uuid\":\"d64e0923-0716-439d-9405-c5cc8e56cadc\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationInPointJob\",\"command\":\"O:36:\\\"App\\\\Jobs\\\\CancelReservationInPointJob\\\":3:{s:53:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000bookDonation_id\\\";i:8;s:45:\\\"\\u0000App\\\\Jobs\\\\CancelReservationInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:01:11.454910\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716494471, 1716494411),
(8, 'default', '{\"uuid\":\"41e56764-1a73-4626-810d-311a7128ef7c\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:8;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:00:11.481202\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748030411, 1716494411),
(9, 'default', '{\"uuid\":\"499aa3f4-b9a8-439a-a7bc-e4998daa3dd8\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:5;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:22:29.788611\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495749, 1716495689),
(10, 'default', '{\"uuid\":\"db391a27-be63-4e6d-a62c-0f415cbb0c2d\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:9;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:21:29.894417\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031689, 1716495689),
(11, 'default', '{\"uuid\":\"7429ceac-3a4a-411c-b6e6-38455395f76f\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:6;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:22:37.294413\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495757, 1716495697),
(12, 'default', '{\"uuid\":\"8126ff85-15be-4a37-ae6b-06e312df394c\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:10;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:21:37.321790\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031697, 1716495697),
(13, 'default', '{\"uuid\":\"61ce900f-39f5-444b-9141-e0742779cd06\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:7;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:22:43.623307\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495763, 1716495703),
(14, 'default', '{\"uuid\":\"946fb7e6-5ca4-4ca3-99d6-fc029f1fef12\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:11;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:21:43.649587\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031703, 1716495703),
(15, 'default', '{\"uuid\":\"a0fd91f7-0422-44ba-aa4a-776559a0b1af\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:8;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:22:52.416499\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495772, 1716495712),
(16, 'default', '{\"uuid\":\"12d58a6a-c83b-41a8-b7dc-937fa39d45aa\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:12;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:21:52.442923\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031712, 1716495712),
(17, 'default', '{\"uuid\":\"7c3a136f-815b-4c05-81fa-1915a1462a1c\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:9;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:24:00.775370\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495840, 1716495780),
(18, 'default', '{\"uuid\":\"0f6db942-f567-429e-b24c-bef807b469c1\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:13;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:23:00.809433\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031780, 1716495780),
(19, 'default', '{\"uuid\":\"29bba6ba-81f8-4532-b734-08fcd3dfc099\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:10;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:24:42.683904\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495882, 1716495822),
(20, 'default', '{\"uuid\":\"a683917d-8656-497b-84b2-47bb15344338\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:14;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:23:42.731123\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031822, 1716495822),
(21, 'default', '{\"uuid\":\"6e064129-2e5f-4802-943d-3ecf20997e88\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:11;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:24:48.609839\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495888, 1716495828),
(22, 'default', '{\"uuid\":\"fd105f1a-aded-435f-9218-65d386dcd77a\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:15;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:23:48.635151\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031828, 1716495828),
(23, 'default', '{\"uuid\":\"384b09c8-a615-4905-a6e1-1a82e6e6978c\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:12;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:24:54.512939\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495894, 1716495834),
(24, 'default', '{\"uuid\":\"ddc340f6-432b-42f3-87be-d6c347780b5e\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:16;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:23:54.538614\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031834, 1716495834),
(25, 'default', '{\"uuid\":\"0d1da1c6-3081-4239-a526-aa4810e3bbe9\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:13;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:25:00.135343\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495900, 1716495840),
(26, 'default', '{\"uuid\":\"0baa909d-d545-48b6-b87c-bd2c01caf3a9\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:17;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:24:00.169939\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031840, 1716495840),
(27, 'default', '{\"uuid\":\"f81c4ef7-d005-4b2e-8871-f046767a6542\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:14;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:25:06.999533\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495906, 1716495847),
(28, 'default', '{\"uuid\":\"cc63ff42-2780-4a19-a1f0-1b7effd194b3\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:18;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:24:07.047258\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031847, 1716495847),
(29, 'default', '{\"uuid\":\"8009a908-44bd-4650-a4f5-80afea926a16\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:15;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:26:10.269810\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716495970, 1716495910),
(30, 'default', '{\"uuid\":\"07a2c1bc-93e2-4d01-aaf1-baccf09d3e2f\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:19;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:25:10.332763\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031910, 1716495910),
(31, 'default', '{\"uuid\":\"4d5e7389-8221-4f2e-a088-45afd7e66984\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:16;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-23 20:27:12.189450\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716496032, 1716495972),
(32, 'default', '{\"uuid\":\"cdc09984-4dbe-4544-a8a6-53bd06d9a855\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:20;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-23 20:26:12.227038\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748031972, 1716495972),
(33, 'default', '{\"uuid\":\"6ee52e80-d604-4db0-b7c5-8747917feefc\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:1;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:28:30.211171\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272110, 1716496110),
(34, 'default', '{\"uuid\":\"2bbccec5-3fec-4c88-afe2-619aa90818f7\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:28:36.613759\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272116, 1716496116),
(35, 'default', '{\"uuid\":\"a1048d5f-4ce1-4f34-8fb1-9d24f68bbe11\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:3;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:28:42.589890\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272122, 1716496122),
(36, 'default', '{\"uuid\":\"4f4e2aed-dbba-4100-a51a-fd647beb2809\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:4;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:28:48.925344\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272128, 1716496128),
(37, 'default', '{\"uuid\":\"4bc0840e-ab71-4959-b1c2-a9790c464ccb\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:5;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:29:08.821491\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272148, 1716496148),
(38, 'default', '{\"uuid\":\"d47cf47e-0bb4-414e-bd14-fb8563eb10f0\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:6;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:29:14.903106\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272154, 1716496154),
(39, 'default', '{\"uuid\":\"2301537d-c3a4-434b-8ea5-d92fff36f644\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:7;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:30:38.214792\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272238, 1716496238),
(40, 'default', '{\"uuid\":\"89b65ff6-a369-49cc-b8f3-dfda7d6ed073\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:8;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-21 20:30:45.560014\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724272245, 1716496245),
(41, 'default', '{\"uuid\":\"a4320361-a9d2-4291-bcd7-08a905df4611\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:26;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-24 03:55:56.287881\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716522956, 1716522897),
(42, 'default', '{\"uuid\":\"541917fb-4860-404e-b8ab-03b45363305d\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:21;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 03:54:57.187689\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748058897, 1716522897),
(43, 'default', '{\"uuid\":\"4fde2ef9-f7d7-403a-814b-cb967e6c7e06\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:27;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-24 03:56:03.011981\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716522963, 1716522903),
(44, 'default', '{\"uuid\":\"b0350f1e-cb94-4803-871e-006288c48cd7\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:22;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 03:55:03.028435\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748058903, 1716522903),
(45, 'default', '{\"uuid\":\"f368e550-1e52-428e-91dd-d0bdd405f692\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:28;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-24 03:56:08.223403\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716522968, 1716522908),
(46, 'default', '{\"uuid\":\"21260f4a-488b-4eb5-9adb-d67a5b73a0f3\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:23;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 03:55:08.238444\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748058908, 1716522908),
(47, 'default', '{\"uuid\":\"984d8c71-44b7-4b91-b7c6-e9c71d6a1fd9\",\"displayName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CancelReservationNotInPointJob\",\"command\":\"O:39:\\\"App\\\\Jobs\\\\CancelReservationNotInPointJob\\\":3:{s:56:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000bookDonation_id\\\";i:29;s:48:\\\"\\u0000App\\\\Jobs\\\\CancelReservationNotInPointJob\\u0000user_id\\\";i:2;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-05-24 03:56:37.105462\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1716522997, 1716522937),
(48, 'default', '{\"uuid\":\"506776b9-7560-428d-bbdc-f270bba1e0eb\",\"displayName\":\"App\\\\Jobs\\\\RemoveReservation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveReservation\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveReservation\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveReservation\\u0000reservation_id\\\";i:24;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 03:55:37.117707\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748058937, 1716522937),
(49, 'default', '{\"uuid\":\"4b5b43c1-96ac-42a7-8d0c-d1bb87b37b77\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:9;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 03:56:29.347991\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724298989, 1716522989),
(50, 'default', '{\"uuid\":\"6e3a5791-3783-49ad-9f38-97e150646145\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:10;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 03:56:34.837241\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724298994, 1716522994),
(51, 'default', '{\"uuid\":\"334a332c-9b02-4dca-bc83-c38da0ad8472\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:11;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 03:56:39.243635\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724298999, 1716522999),
(52, 'default', '{\"uuid\":\"df440bce-f599-4e97-a692-e39666eed9f5\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:12;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 03:56:42.969640\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724299002, 1716523002),
(53, 'default', '{\"uuid\":\"ca21f2b8-1a74-46c9-b4d4-4c3c429fa206\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:13;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 03:58:30.172997\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724299110, 1716523110),
(54, 'default', '{\"uuid\":\"a8227d4e-817c-4bbd-842a-9f158ab9b1e0\",\"displayName\":\"App\\\\Jobs\\\\RemoveDonation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveDonation\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\RemoveDonation\\\":2:{s:40:\\\"\\u0000App\\\\Jobs\\\\RemoveDonation\\u0000bookDonation_id\\\";i:26;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 03:58:30.202109\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748059110, 1716523110),
(55, 'default', '{\"uuid\":\"797ae8d1-b3bf-47cb-a462-a12622d18c00\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:14;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 03:59:22.807512\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724299162, 1716523162),
(56, 'default', '{\"uuid\":\"591dcab5-74d4-48c2-8bc5-e1278559fa13\",\"displayName\":\"App\\\\Jobs\\\\RemoveDonation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveDonation\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\RemoveDonation\\\":2:{s:40:\\\"\\u0000App\\\\Jobs\\\\RemoveDonation\\u0000bookDonation_id\\\";i:27;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 03:59:22.820345\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748059162, 1716523162),
(57, 'default', '{\"uuid\":\"a5ab03e0-6779-4387-b637-bb14771244f6\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:15;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 04:00:03.116915\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724299203, 1716523203),
(58, 'default', '{\"uuid\":\"fb331ea7-24b4-4404-aac9-0bec6c261263\",\"displayName\":\"App\\\\Jobs\\\\RemoveDonation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveDonation\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\RemoveDonation\\\":2:{s:40:\\\"\\u0000App\\\\Jobs\\\\RemoveDonation\\u0000bookDonation_id\\\";i:28;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 04:00:03.132406\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748059203, 1716523203),
(59, 'default', '{\"uuid\":\"d138a28e-3d58-458c-8d78-5c8c67cfa4dc\",\"displayName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveTransaction\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\RemoveTransaction\\\":2:{s:42:\\\"\\u0000App\\\\Jobs\\\\RemoveTransaction\\u0000transaction_id\\\";i:16;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2024-08-22 04:00:20.217324\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1724299220, 1716523220),
(60, 'default', '{\"uuid\":\"a3999dc4-dd9f-4801-8f77-a3e96da7fa01\",\"displayName\":\"App\\\\Jobs\\\\RemoveDonation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RemoveDonation\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\RemoveDonation\\\":2:{s:40:\\\"\\u0000App\\\\Jobs\\\\RemoveDonation\\u0000bookDonation_id\\\";i:29;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-05-24 04:00:20.227798\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:3:\\\"UTC\\\";}}\"}}', 0, NULL, 1748059220, 1716523220);

-- --------------------------------------------------------

--
-- بنية الجدول `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_accounts_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2024_02_15_175758_create_users_table', 1),
(11, '2024_02_16_105051_create_cities_table', 1),
(12, '2024_02_21_075500_create_residential_quarters_table', 1),
(13, '2024_02_21_213728_create_exchange_points_table', 1),
(14, '2024_02_22_107608_create_book_donations_table', 1),
(15, '2024_02_22_235523_create_images_table', 1),
(16, '2024_03_07_110307_create_reservations_table', 1),
(17, '2024_03_28_211252_create_device_tokens_table', 1),
(18, '2024_03_30_001823_create_admins_table', 1),
(19, '2024_03_30_203021_admin_city', 1),
(20, '2024_04_09_002907_performances', 1),
(21, '2024_04_12_142533_create_jobs_table', 1),
(22, '2024_04_21_062031_create_transactions_table', 1),
(23, '2024_04_26_143913_create_email_verification_tokens_table', 1),
(24, '2024_04_26_143923_create_phone_verification_tokens_table', 1),
(25, '2024_04_28_094542_create_update_email_tokens_table', 1),
(26, '2024_05_21_045229_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `performances`
--

CREATE TABLE `performances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exchangePoint_id` bigint(20) UNSIGNED NOT NULL,
  `month` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `year` smallint(6) NOT NULL,
  `no_addedDonation` int(11) NOT NULL DEFAULT 0,
  `no_bookedDonation` int(11) NOT NULL DEFAULT 0,
  `no_canceledDonationFromDonor` int(11) NOT NULL DEFAULT 0,
  `no_canceledDonationFromBeneficiary` int(11) NOT NULL DEFAULT 0,
  `no_receivedDonation` int(11) NOT NULL DEFAULT 0,
  `no_removedDonationByAdmin` int(11) NOT NULL DEFAULT 0,
  `no_removedDonation` int(11) NOT NULL DEFAULT 0,
  `no_rejectedDonation` int(11) NOT NULL DEFAULT 0,
  `no_deliveredDonation` int(11) NOT NULL DEFAULT 0,
  `no_rejectedDonationFromBeneficiary` int(11) NOT NULL DEFAULT 0,
  `no_reachingMaxPackages` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `performances`
--

INSERT INTO `performances` (`id`, `exchangePoint_id`, `month`, `year`, `no_addedDonation`, `no_bookedDonation`, `no_canceledDonationFromDonor`, `no_canceledDonationFromBeneficiary`, `no_receivedDonation`, `no_removedDonationByAdmin`, `no_removedDonation`, `no_rejectedDonation`, `no_deliveredDonation`, `no_rejectedDonationFromBeneficiary`, `no_reachingMaxPackages`, `created_at`, `updated_at`) VALUES
(3, 1, '5', 2024, 20, 16, 0, 0, 8, 0, 0, 4, 4, 0, 0, '2024-05-23 16:59:46', '2024-05-24 01:00:20');

-- --------------------------------------------------------

--
-- بنية الجدول `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Account', 1, 'HP', 'f38be2006372fd0c2e3ccd119016837576185d0b63428dceda8df2727a3b8ad3', '[\"*\"]', '2024-05-24 01:54:53', NULL, '2024-05-23 16:53:07', '2024-05-24 01:54:53'),
(2, 'App\\Models\\Account', 2, 'HP', 'fd086522148afbfd7d7de8c677d989f9657e3a3c4194d765517e9c30e59f6bdb', '[\"*\"]', '2024-05-24 01:07:54', NULL, '2024-05-23 16:56:54', '2024-05-24 01:07:54'),
(3, 'App\\Models\\Account', 11, 'HP', '7ed400e297cbe8da8142e3697749ec718f29c1b8cc0097c9117ff640253f1b87', '[\"*\"]', '2024-05-24 01:00:20', NULL, '2024-05-23 17:02:10', '2024-05-24 01:00:20');

-- --------------------------------------------------------

--
-- بنية الجدول `phone_verification_tokens`
--

CREATE TABLE `phone_verification_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bookDonation_id` bigint(20) UNSIGNED NOT NULL,
  `activeOrSuccess` tinyint(1) NOT NULL DEFAULT 0,
  `deliveryDate` datetime DEFAULT NULL,
  `code` smallint(5) UNSIGNED DEFAULT NULL,
  `startLeadTimeDateForBeneficiary` datetime DEFAULT NULL,
  `status` enum('تم التسليم','بانتظار استلامها من المتبرع','بانتظار مجيئك واستلامها','تم إلغاء الحجز من المتبرع','المتبرع لم يسلم حزمة الكتب','المستفيد لم يستلم حزمة الكتب','تم إلغاء الحجز من البرنامج','تم إلغاء الحجز من المستفيد','المستفيد لم يقبل حزمة الكتب') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `bookDonation_id`, `activeOrSuccess`, `deliveryDate`, `code`, `startLeadTimeDateForBeneficiary`, `status`, `created_at`, `updated_at`) VALUES
(9, 2, 5, 1, NULL, NULL, NULL, 'بانتظار استلامها من المتبرع', '2024-05-23 17:21:29', '2024-05-23 17:21:29'),
(10, 2, 6, 1, NULL, NULL, NULL, 'بانتظار استلامها من المتبرع', '2024-05-23 17:21:37', '2024-05-23 17:21:37'),
(11, 2, 7, 1, NULL, NULL, NULL, 'بانتظار استلامها من المتبرع', '2024-05-23 17:21:43', '2024-05-23 17:21:43'),
(12, 2, 8, 1, NULL, NULL, NULL, 'بانتظار استلامها من المتبرع', '2024-05-23 17:21:52', '2024-05-23 17:21:52'),
(13, 2, 9, 1, NULL, 61346, '2024-05-23 20:28:30', 'بانتظار مجيئك واستلامها', '2024-05-23 17:23:00', '2024-05-23 17:23:00'),
(14, 2, 10, 1, NULL, 64691, '2024-05-23 20:28:36', 'بانتظار مجيئك واستلامها', '2024-05-23 17:23:42', '2024-05-23 17:23:42'),
(15, 2, 11, 1, NULL, 17787, '2024-05-23 20:28:42', 'بانتظار مجيئك واستلامها', '2024-05-23 17:23:48', '2024-05-23 17:23:48'),
(16, 2, 12, 1, NULL, 39755, '2024-05-23 20:28:48', 'بانتظار مجيئك واستلامها', '2024-05-23 17:23:54', '2024-05-23 17:23:54'),
(17, 2, 13, 0, NULL, NULL, NULL, 'المستفيد لم يقبل حزمة الكتب', '2024-05-23 17:24:00', '2024-05-23 17:24:00'),
(18, 2, 14, 0, NULL, NULL, NULL, 'تم إلغاء الحجز من البرنامج', '2024-05-23 17:24:06', '2024-05-23 17:24:06'),
(19, 2, 15, 0, NULL, NULL, NULL, 'المتبرع لم يسلم حزمة الكتب', '2024-05-23 17:25:10', '2024-05-23 17:25:10'),
(20, 2, 16, 0, NULL, NULL, NULL, 'تم إلغاء الحجز من البرنامج', '2024-05-23 17:26:12', '2024-05-23 17:26:12'),
(21, 2, 26, 1, '2024-05-24 03:58:30', NULL, '2024-05-24 03:56:29', 'تم التسليم', '2024-05-24 00:54:56', '2024-05-24 00:54:56'),
(22, 2, 27, 1, '2024-05-24 03:59:22', NULL, '2024-05-24 03:56:34', 'تم التسليم', '2024-05-24 00:55:03', '2024-05-24 00:55:03'),
(23, 2, 28, 1, '2024-05-24 04:00:03', NULL, '2024-05-24 03:56:39', 'تم التسليم', '2024-05-24 00:55:08', '2024-05-24 00:55:08'),
(24, 2, 29, 1, '2024-05-24 04:00:20', NULL, '2024-05-24 03:56:42', 'تم التسليم', '2024-05-24 00:55:37', '2024-05-24 00:55:37');

-- --------------------------------------------------------

--
-- بنية الجدول `residential_quarters`
--

CREATE TABLE `residential_quarters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `residential_quarters`
--

INSERT INTO `residential_quarters` (`id`, `city_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'المتضررين', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(2, 1, 'روكب', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(3, 1, 'الضيافة', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(4, 1, 'امبيخه', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(5, 1, 'الديس', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(6, 1, 'المطابع', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(7, 1, 'الشافعي', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(8, 1, 'الريان', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(9, 1, 'خمر', '2024-05-23 10:40:10', '2024-05-23 10:40:10'),
(10, 1, 'المتبويش', '2024-05-23 10:40:10', '2024-05-23 10:40:10');

-- --------------------------------------------------------

--
-- بنية الجدول `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bookDonation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('تم التسليم','تم رفض التبرع','تم استلام التبرع','تم رفض الاستلام') NOT NULL,
  `canCancel` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `transactions`
--

INSERT INTO `transactions` (`id`, `bookDonation_id`, `user_id`, `status`, `canCancel`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 'تم استلام التبرع', 1, '2024-05-23 17:28:30', '2024-05-23 17:28:30'),
(2, 10, 1, 'تم استلام التبرع', 1, '2024-05-23 17:28:36', '2024-05-23 17:28:36'),
(3, 11, 1, 'تم استلام التبرع', 1, '2024-05-23 17:28:42', '2024-05-23 17:28:42'),
(4, 12, 1, 'تم استلام التبرع', 1, '2024-05-23 17:28:48', '2024-05-23 17:28:48'),
(5, 13, 1, 'تم رفض التبرع', 1, '2024-05-23 17:29:08', '2024-05-23 17:29:08'),
(6, 14, 1, 'تم رفض التبرع', 1, '2024-05-23 17:29:14', '2024-05-23 17:29:14'),
(7, 15, 1, 'تم رفض التبرع', 1, '2024-05-23 17:30:38', '2024-05-23 17:30:38'),
(8, 16, 1, 'تم رفض التبرع', 1, '2024-05-23 17:30:45', '2024-05-23 17:30:45'),
(9, 26, 1, 'تم استلام التبرع', 1, '2024-05-24 00:56:29', '2024-05-24 00:56:29'),
(10, 27, 1, 'تم استلام التبرع', 1, '2024-05-24 00:56:34', '2024-05-24 00:56:34'),
(11, 28, 1, 'تم استلام التبرع', 1, '2024-05-24 00:56:39', '2024-05-24 00:56:39'),
(12, 29, 1, 'تم استلام التبرع', 1, '2024-05-24 00:56:42', '2024-05-24 00:56:42'),
(13, 26, 2, 'تم التسليم', 1, '2024-05-24 00:58:30', '2024-05-24 00:58:30'),
(14, 27, 2, 'تم التسليم', 1, '2024-05-24 00:59:22', '2024-05-24 00:59:22'),
(15, 28, 2, 'تم التسليم', 1, '2024-05-24 01:00:03', '2024-05-24 01:00:03'),
(16, 29, 2, 'تم التسليم', 1, '2024-05-24 01:00:20', '2024-05-24 01:00:20');

-- --------------------------------------------------------

--
-- بنية الجدول `update_email_tokens`
--

CREATE TABLE `update_email_tokens` (
  `account_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `no_donations` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `no_benefits` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `no_bookingOfFirstSemester` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `no_bookingOfSecondSemester` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `no_non_adherence_donor` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `no_non_adherence_beneficiary` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `account_id`, `no_donations`, `no_benefits`, `no_bookingOfFirstSemester`, `no_bookingOfSecondSemester`, `no_non_adherence_donor`, `no_non_adherence_beneficiary`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-24 00:56:42'),
(2, 2, 0, 4, 2, 2, 0, 0, '2024-05-23 10:40:12', '2024-05-24 01:00:20'),
(3, 3, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(4, 4, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(5, 5, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(6, 6, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(7, 7, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(8, 8, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(9, 9, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12'),
(10, 10, 0, 0, 0, 0, 0, 0, '2024-05-23 10:40:12', '2024-05-23 10:40:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_username_unique` (`userName`),
  ADD KEY `accounts_phonenumber_index` (`phoneNumber`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_account_id_foreign` (`account_id`);

--
-- Indexes for table `admin_city`
--
ALTER TABLE `admin_city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_city_admin_id_foreign` (`admin_id`),
  ADD KEY `admin_city_city_id_foreign` (`city_id`);

--
-- Indexes for table `book_donations`
--
ALTER TABLE `book_donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_donations_donor_id_foreign` (`donor_id`),
  ADD KEY `book_donations_exchangepoint_id_foreign` (`exchangePoint_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_tokens_account_id_foreign` (`account_id`);

--
-- Indexes for table `email_verification_tokens`
--
ALTER TABLE `email_verification_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_verification_tokens_email_index` (`email`);

--
-- Indexes for table `exchange_points`
--
ALTER TABLE `exchange_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exchange_points_account_id_foreign` (`account_id`),
  ADD KEY `exchange_points_residentialquarter_id_foreign` (`residentialQuarter_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_bookdonation_id_foreign` (`bookDonation_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_account_id_foreign` (`account_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_reset_tokens_email_index` (`email`);

--
-- Indexes for table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performances_exchangepoint_id_foreign` (`exchangePoint_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `phone_verification_tokens`
--
ALTER TABLE `phone_verification_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_verification_tokens_phonenumber_index` (`phoneNumber`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_bookdonation_id_foreign` (`bookDonation_id`);

--
-- Indexes for table `residential_quarters`
--
ALTER TABLE `residential_quarters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residential_quarters_city_id_foreign` (`city_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_bookdonation_id_foreign` (`bookDonation_id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `update_email_tokens`
--
ALTER TABLE `update_email_tokens`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_account_id_foreign` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_city`
--
ALTER TABLE `admin_city`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_donations`
--
ALTER TABLE `book_donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_verification_tokens`
--
ALTER TABLE `email_verification_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exchange_points`
--
ALTER TABLE `exchange_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phone_verification_tokens`
--
ALTER TABLE `phone_verification_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `residential_quarters`
--
ALTER TABLE `residential_quarters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `admin_city`
--
ALTER TABLE `admin_city`
  ADD CONSTRAINT `admin_city_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_city_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `book_donations`
--
ALTER TABLE `book_donations`
  ADD CONSTRAINT `book_donations_donor_id_foreign` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `book_donations_exchangepoint_id_foreign` FOREIGN KEY (`exchangePoint_id`) REFERENCES `exchange_points` (`id`);

--
-- قيود الجداول `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD CONSTRAINT `device_tokens_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `exchange_points`
--
ALTER TABLE `exchange_points`
  ADD CONSTRAINT `exchange_points_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `exchange_points_residentialquarter_id_foreign` FOREIGN KEY (`residentialQuarter_id`) REFERENCES `residential_quarters` (`id`);

--
-- قيود الجداول `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_bookdonation_id_foreign` FOREIGN KEY (`bookDonation_id`) REFERENCES `book_donations` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `performances`
--
ALTER TABLE `performances`
  ADD CONSTRAINT `performances_exchangepoint_id_foreign` FOREIGN KEY (`exchangePoint_id`) REFERENCES `exchange_points` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_bookdonation_id_foreign` FOREIGN KEY (`bookDonation_id`) REFERENCES `book_donations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `residential_quarters`
--
ALTER TABLE `residential_quarters`
  ADD CONSTRAINT `residential_quarters_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON UPDATE CASCADE;

--
-- قيود الجداول `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_bookdonation_id_foreign` FOREIGN KEY (`bookDonation_id`) REFERENCES `book_donations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
