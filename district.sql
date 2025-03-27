USE gadget_gears
GO

/****** Object:  Table [dbo].[District]    Script Date: 21/03/2025 12:15:17 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE District (
    DID int  NULL,
    DesID int  NULL,
    DistserialNo int DEFAULT 0,
    DesName varchar(255),
    District varchar(255),
    UserName varchar(50),
    EntDate datetime,
    EntYear int,
    PRIMARY KEY (DesID)
);
GO

INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 1, 260, N'†bvqvLvjx', N'নোয়াখালী', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 2, 10, N'XvKv (gnvbMi)', N'ঢাকা (মহানগর)', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 3, 270, N'†dbx', N'ফেনী', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (5, 4, 340, N'†fvjv', N'ভোলা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 5, 480, N'†g‡nicyi', N'মেহেরপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (6, 6, 200, N'†gŠjex evRvi', N'মৌলবী বাজার', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (8, 7, 120, N'gqgbwmsn', N'ময়মনসিংহ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (8, 8, 150, N'†kicyi', N'শেরপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 9, 540, N'bIMuv', N'নওগাঁ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 10, 40, N'biwms`x', N'নরসিংদী', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 11, 430, N'bovBj', N'নড়াইল', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 12, 510, N'bv‡Uvi', N'নাটোর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 13, 50, N'bvivqYMÄ', N'নারায়ণগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 14, 500, N'cvebv', N'পাবনা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 15, 80, N'dwi`cyi', N'ফরিদপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 16, 560, N'e¸ov', N'বগুড়া', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 17, 400, N'ev‡MinvU', N'বাগেরহাট', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (5, 18, 330, N'ewikvj', N'বরিশাল', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 19, 440, N'gv¸iv', N'মাগুরা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 20, 70, N'gvwbKMÄ', N'মানিকগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 21, 60, N'gywÝMÄ', N'মুন্সিগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 22, 420, N'h‡kvi', N'যশোর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 23, 600, N'iscyi', N'রংপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 24, 520, N'ivRkvnx', N'রাজশাহী', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 25, 250, N'j²xcyi', N'লক্ষ্মীপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 26, 90, N'kixqZcyi', N'শরীয়তপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 27, 230, N'Kzwgjøv', N'কুমিল্লা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 28, 580, N'KzwoMÖvg', N'কুড়িগ্রাম', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 29, 460, N'Kzwóqv', N'কুষ্টিয়া', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 30, 390, N'Lyjbv', N'খুলনা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 31, 30, N'MvRxcyi', N'গাজীপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 32, 410, N'mvZÿxiv', N'সাতক্ষীরা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (6, 33, 190, N'mybvgMÄ', N'সুনামগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (6, 34, 210, N'nweMÄ', N'হবিগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (6, 34, 210, N'nweMÄ', N'হবিগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 35, 280, N'PÆMÖvg', N'চট্টগ্রাম', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 36, 240, N'Puv`cyi', N'চাঁদপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 37, 530, N'PvcvBbeveMÄ', N'চাপাইনবাবগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 38, 470, N'PzqvWv½v', N'চুয়াডাঙ্গা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (8, 39, 160, N'Rvgvjcyi', N'জামালপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (5, 40, 370, N'SvjKvwV', N'ঝালকাঠি', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 41, 170, N'Uv½vBj', N'টাঙ্গাইল', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 42, 630, N'VvKziMuvI', N'ঠাকুরগাঁও', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 43, 620, N'w`bvRcyi', N'দিনাজপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (5, 44, 380, N'wc‡ivRcyi', N'পিরোজপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 45, 220, N'eªv‏þYevoxqv', N'ব্রাহ্মণবাড়ীয়া', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 46, 130, N'wK‡kviMÄ', N'কিশোরগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (6, 47, 180, N'wm‡jU', N'সিলেট', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 48, 490, N'wmivRMÄ', N'সিরাজগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (4, 49, 450, N'wSbvB`n', N'ঝিনাইদহ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 50, 20, N'XvKv', N'ঢাকা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 51, 570, N'MvBevÜv', N'গাইবান্ধা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (5, 52, 350, N'cUzqvLvjx', N'পটুয়াখালী', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 53, 110, N'†MvcvjMÄ', N'গোপালগঞ্জ', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 54, 100, N'gv`vixcyi', N'মাদারীপুর', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 55, 320, N'K·evRvi', N'কক্সবাজার', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (5, 56, 360, N'ei¸bv', N'বরগুনা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 57, 610, N'bxjdvgvix', N'নীলফামারী', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 58, 310, N'ev›`ievb', N'বান্দরবন', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (1, 59, 85, N'ivRevox', N'রাজবাড়ী', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 60, 590, N'jvjgwbi nvU', N'লালমনির হাট', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 61, 290, N'LvMovQwo', N'খাগড়াছড়ি', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (2, 62, 300, N'iv½vgvwU', N'রাঙ্গামাটি', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (7, 63, 640, N'cÂMo', N'পঞ্চগড়', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (3, 64, 550, N'RqcyinvU', N'জয়পুরহাট', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
INSERT [dbo].[District] ([DID], [DesID], [DistserialNo], [DesName], [District], [UserName], [EntDate], [EntYear]) VALUES (8, 65, 140, N'†bÎ‡Kvbv', N'নেত্রকোনা', N'dinv`', CAST(N'2016-07-26T00:00:00.000' AS DateTime), 2016)
GO

ALTER TABLE [dbo].[District] ADD CONSTRAINT [DF_District_DistserialNo] DEFAULT ((0)) FOR [DistserialNo]
GO

