/**
 * jQuery TWzipcode plugin
 * https://code.essoduke.org/twzipcode/
 * Copyright 2016 essoduke.org, Licensed MIT.
 *
 * Changelog
 * -------------------------------
 * 修正異體字「台」為正體字「臺」
 *
 * @author essoduke.org
 * @version 1.7.10
 * @license MIT License
 */
;(function ($, window, document, undefined) {

    'use strict';

    // Zipcode JSON data
    var data = {
        "state" : [
            {
                "id" : 110000,
                "name" : "Dubai"
            }, {
                "id" : 120000,
                "name" : "Abu Dhabi"
            }, {
                "id" : 130000,
                "name" : "Sharjah"
            }, {
                "id" : 140000,
                "name" : "Al Ain"
            }, {
                "id" : 150000,
                "name" : "Fujairah"
            }, {
                "id" : 160000,
                "name" : "Ras Al Khaimah"
            }, {
                "id" : 170000,
                "name" : "Ajman"
            }, {
                "id" : 180000,
                "name" : "Umm Al Quwain"
            }, {
                "id" : 190000,
                "name" : "Western Region"
            }
        ],
        "city" : {
            "110000" : [{
                    "id" : 110001,
                    "name" : "AL Badaa"
                }, {
                    "id" : 110002,
                    "name" : "Abu Hail"
                }, {
                    "id" : 110003,
                    "name" : "Acacia Avenues"
                }, {
                    "id" : 110004,
                    "name" : "Airport Terminal 1,2,3"
                }, {
                    "id" : 110005,
                    "name" : "Al Baraha"
                }, {
                    "id" : 110006,
                    "name" : "Al Barsha"
                }, {
                    "id" : 110007,
                    "name" : "Al Buteen"
                }, {
                    "id" : 110008,
                    "name" : "Al Furjan"
                }, {
                    "id" : 110009,
                    "name" : "Al Gandhi Complex"
                }, {
                    "id" : 110010,
                    "name" : "Al Garhoud"
                }, {
                    "id" : 110011,
                    "name" : "Al Ghubaiba"
                }, {
                    "id" : 110012,
                    "name" : "Al Hamriya"
                }, {
                    "id" : 110013,
                    "name" : "Al Hudaiba"
                }, {
                    "id" : 110014,
                    "name" : "Al Jaddaf"
                }, {
                    "id" : 110015,
                    "name" : "Al Jafiliya"
                }, {
                    "id" : 110016,
                    "name" : "Al Kaheel"
                }, {
                    "id" : 110017,
                    "name" : "Al Karama"
                }, {
                    "id" : 110018,
                    "name" : "Al Khabisi"
                }, {
                    "id" : 110019,
                    "name" : "Al Khail Gate"
                }, {
                    "id" : 110020,
                    "name" : "Al Khawaneej"
                }, {
                    "id" : 110021,
                    "name" : "Al Kifaf"
                }, {
                    "id" : 110022,
                    "name" : "Al Maha Resort"
                }, {
                    "id" : 110023,
                    "name" : "Al Manara"
                }, {
                    "id" : 110024,
                    "name" : "Al Marabea Street"
                }, {
                    "id" : 110025,
                    "name" : "Al Meydan City"
                }, {
                    "id" : 110026,
                    "name" : "Al Mizhar"
                }, {
                    "id" : 110027,
                    "name" : "Al Mulla Plaza"
                }, {
                    "id" : 110028,
                    "name" : "Al Muraqqabat"
                }, {
                    "id" : 110029,
                    "name" : "Al Murar"
                }, {
                    "id" : 110030,
                    "name" : "Al Muteena"
                }, {
                    "id" : 110031,
                    "name" : "Al Nahda"
                }, {
                    "id" : 110032,
                    "name" : "Al Nasr"
                }, {
                    "id" : 110033,
                    "name" : "Al Qouz Industrial Area"
                }, {
                    "id" : 110034,
                    "name" : "Al Qouz Mall"
                }, {
                    "id" : 110035,
                    "name" : "Al Quoz"
                }, {
                    "id" : 110036,
                    "name" : "Al Qusais"
                }, {
                    "id" : 110037,
                    "name" : "Al Raffa"
                }, {
                    "id" : 110038,
                    "name" : "Al Ras"
                }, {
                    "id" : 110039,
                    "name" : "Al Rashidiya"
                }, {
                    "id" : 110040,
                    "name" : "Al Rigga"
                }, {
                    "id" : 110041,
                    "name" : "Al Safa"
                }, {
                    "id" : 110042,
                    "name" : "Al Satwa"
                }, {
                    "id" : 110043,
                    "name" : "Al Souk"
                }, {
                    "id" : 110044,
                    "name" : "Al Sufouh"
                }, {
                    "id" : 110045,
                    "name" : "Al Tawar"
                }, {
                    "id" : 110046,
                    "name" : "Al Wahida"
                }, {
                    "id" : 110047,
                    "name" : "Al Warqaa"
                }, {
                    "id" : 110048,
                    "name" : "Al-Aweer RTA Depo"
                }, {
                    "id" : 110049,
                    "name" : "Al-Aweer Residential Area"
                }, {
                    "id" : 110050,
                    "name" : "Al-Safa-1"
                }, {
                    "id" : 110051,
                    "name" : "Al-Safa-2"
                }, {
                    "id" : 110052,
                    "name" : "Al-Warsan"
                }, {
                    "id" : 110053,
                    "name" : "Al-Wasl Road"
                }, {
                    "id" : 110054,
                    "name" : "Arabian Ranches"
                }, {
                    "id" : 110055,
                    "name" : "Ayal Naser"
                }, {
                    "id" : 110056,
                    "name" : "Baghdad Street"
                }, {
                    "id" : 110057,
                    "name" : "Baniyas Road"
                }, {
                    "id" : 110058,
                    "name" : "Bank Street Burdubai"
                }, {
                    "id" : 110059,
                    "name" : "Barsha South"
                }, {
                    "id" : 110060,
                    "name" : "Bukadra"
                }, {
                    "id" : 110061,
                    "name" : "Bur Dubai"
                }, {
                    "id" : 110062,
                    "name" : "Burj Al-Arab"
                }, {
                    "id" : 110063,
                    "name" : "Business Bay"
                }, {
                    "id" : 110064,
                    "name" : "Business Village Area"
                }, {
                    "id" : 110065,
                    "name" : "Cargo Village"
                }, {
                    "id" : 110066,
                    "name" : "City of Arabia"
                }, {
                    "id" : 110067,
                    "name" : "Coral Botique Villas"
                }, {
                    "id" : 110068,
                    "name" : "Corniche Deira"
                }, {
                    "id" : 110069,
                    "name" : "Creek Road"
                }, {
                    "id" : 110070,
                    "name" : "Culture Village"
                }, {
                    "id" : 110071,
                    "name" : "DAFZA"
                }, {
                    "id" : 110072,
                    "name" : "DMCC"
                }, {
                    "id" : 110073,
                    "name" : "Damascus Street"
                }, {
                    "id" : 110074,
                    "name" : "Deira Abra"
                }, {
                    "id" : 110075,
                    "name" : "Deira City Center"
                }, {
                    "id" : 110076,
                    "name" : "Deira Dubai"
                }, {
                    "id" : 110077,
                    "name" : "Discovery Gardens"
                }, {
                    "id" : 110078,
                    "name" : "Dnata"
                }, {
                    "id" : 110079,
                    "name" : "Downtown Burj Dubai"
                }, {
                    "id" : 110080,
                    "name" : "Downtown Dubai"
                }, {
                    "id" : 110081,
                    "name" : "Downtown Jebel Ali"
                }, {
                    "id" : 110082,
                    "name" : "Dubai American Academy"
                }, {
                    "id" : 110083,
                    "name" : "Dubai Autodrome & Business Park"
                }, {
                    "id" : 110084,
                    "name" : "Dubai BioTechnology And Research Park"
                }, {
                    "id" : 110085,
                    "name" : "Dubai College"
                }, {
                    "id" : 110086,
                    "name" : "Dubai Courts"
                }, {
                    "id" : 110087,
                    "name" : "Dubai Festival City"
                }, {
                    "id" : 110088,
                    "name" : "Dubai Flower Center"
                }, {
                    "id" : 110089,
                    "name" : "Dubai Golf Club"
                }, {
                    "id" : 110090,
                    "name" : "Dubai Healthcare City"
                }, {
                    "id" : 110091,
                    "name" : "Dubai Hospital"
                }, {
                    "id" : 110092,
                    "name" : "Dubai Immigration"
                }, {
                    "id" : 110093,
                    "name" : "Dubai Industrial City"
                }, {
                    "id" : 110094,
                    "name" : "Dubai International Academic City"
                }, {
                    "id" : 110095,
                    "name" : "Dubai International Financial Center"
                }, {
                    "id" : 110096,
                    "name" : "Dubai Internet City"
                }, {
                    "id" : 110097,
                    "name" : "Dubai Investment Park 1"
                }, {
                    "id" : 110098,
                    "name" : "Dubai Investment Park 2"
                }, {
                    "id" : 110099,
                    "name" : "Dubai Land"
                }, {
                    "id" : 110100,
                    "name" : "Dubai Mall"
                }, {
                    "id" : 110101,
                    "name" : "Dubai Maritime City"
                }, {
                    "id" : 110102,
                    "name" : "Dubai Media City"
                }, {
                    "id" : 110103,
                    "name" : "Dubai Outlet Mall"
                }, {
                    "id" : 110104,
                    "name" : "Dubai Outsource Zone"
                }, {
                    "id" : 110105,
                    "name" : "Dubai Pearl"
                }, {
                    "id" : 110106,
                    "name" : "Dubai Petroleum"
                }, {
                    "id" : 110107,
                    "name" : "Dubai Police HQ"
                }, {
                    "id" : 110108,
                    "name" : "Dubai Silicon Oasis"
                }, {
                    "id" : 110109,
                    "name" : "Dubai Sports City"
                }, {
                    "id" : 110200,
                    "name" : "Dubai Taxi HQ"
                }, {
                    "id" : 110201,
                    "name" : "Dubai Waterfront"
                }, {
                    "id" : 110202,
                    "name" : "Dubai World Central"
                }, {
                    "id" : 110203,
                    "name" : "International City"
                }, {
                    "id" : 110204,
                    "name" : "International City Phase 3"
                }, {
                    "id" : 110205,
                    "name" : "International Cricket Stadium"
                }, {
                    "id" : 110206,
                    "name" : "International Media Production Zone"
                }, {
                    "id" : 110207,
                    "name" : "Jebel Ali DEWA"
                }, {
                    "id" : 110208,
                    "name" : "Jebel Ali Free Zone Authority"
                }, {
                    "id" : 110209,
                    "name" : "Jebel Ali Industrial Areas"
                }, {
                    "id" : 110210,
                    "name" : "Jebel Ali Police Station"
                }, {
                    "id" : 110211,
                    "name" : "Jebel Ali Race Course"
                }, {
                    "id" : 110212,
                    "name" : "Jebel Ali Shooting Club"
                }, {
                    "id" : 110213,
                    "name" : "Jebel Ali Village"
                }, {
                    "id" : 110214,
                    "name" : "Jumeirah"
                }, {
                    "id" : 110215,
                    "name" : "Jumeirah Beach Hotel"
                }, {
                    "id" : 110216,
                    "name" : "Jumeirah Beach Residence"
                }, {
                    "id" : 110217,
                    "name" : "Jumeirah Beach Road"
                }, {
                    "id" : 110218,
                    "name" : "Jumeirah Golf Estate"
                }, {
                    "id" : 110219,
                    "name" : "Jumeirah Islands"
                }, {
                    "id" : 110220,
                    "name" : "Jumeirah Lake Towers"
                }, {
                    "id" : 110221,
                    "name" : "Jumeirah Park"
                }, {
                    "id" : 110222,
                    "name" : "Jumeirah Village Circle"
                }, {
                    "id" : 110223,
                    "name" : "Jumeirah Village South"
                }, {
                    "id" : 110224,
                    "name" : "Jumeirah Village Triangle"
                }, {
                    "id" : 110225,
                    "name" : "Karama Center"
                }, {
                    "id" : 110226,
                    "name" : "Karama Post Office"
                }, {
                    "id" : 110227,
                    "name" : "Karama Post Office"
                }, {
                    "id" : 110228,
                    "name" : "Khaleej Times"
                }, {
                    "id" : 110229,
                    "name" : "Khalid Bin Waleed"
                }, {
                    "id" : 110230,
                    "name" : "Knowledge Village"
                }, {
                    "id" : 110231,
                    "name" : "Lagoons"
                }, {
                    "id" : 110232,
                    "name" : "Lamcy Plaza"
                }, {
                    "id" : 110233,
                    "name" : "Latifa Hospital"
                }, {
                    "id" : 110234,
                    "name" : "Layan Community"
                }, {
                    "id" : 110235,
                    "name" : "Logistic City"
                }, {
                    "id" : 110236,
                    "name" : "Lulu Village"
                }, {
                    "id" : 110237,
                    "name" : "Madina Badr"
                }, {
                    "id" : 110238,
                    "name" : "Maktoum Road"
                }, {
                    "id" : 110239,
                    "name" : "Mamzar"
                }, {
                    "id" : 110240,
                    "name" : "Mankhool"
                }, {
                    "id" : 110241,
                    "name" : "Marina"
                }, {
                    "id" : 110242,
                    "name" : "Marsa Al Khor Business Park"
                }, {
                    "id" : 110243,
                    "name" : "Mazaya Center"
                }, {
                    "id" : 110244,
                    "name" : "Meadows"
                }, {
                    "id" : 110245,
                    "name" : "Meena Bazar"
                }, {
                    "id" : 110246,
                    "name" : "Mina Al Arab"
                }, {
                    "id" : 110247,
                    "name" : "Mirdiff"
                }, {
                    "id" : 110248,
                    "name" : "Mizhar"
                }, {
                    "id" : 110249,
                    "name" : "Muhaisanah"
                }, {
                    "id" : 110250,
                    "name" : "Murshid Bazar"
                }, {
                    "id" : 110251,
                    "name" : "Musallah Al Eid"
                }, {
                    "id" : 110252,
                    "name" : "Mushrif Heights"
                }, {
                    "id" : 110253,
                    "name" : "Mushrif Park"
                }, {
                    "id" : 110254,
                    "name" : "Nad Al Sheba"
                }, {
                    "id" : 110255,
                    "name" : "Nadd Al Hamar"
                }, {
                    "id" : 110256,
                    "name" : "Nadd Shamma"
                }, {
                    "id" : 110257,
                    "name" : "Naif"
                }, {
                    "id" : 110258,
                    "name" : "Nakheel"
                }, {
                    "id" : 110259,
                    "name" : "Naser Square"
                }, {
                    "id" : 110260,
                    "name" : "New Grand City Mall"
                }, {
                    "id" : 110261,
                    "name" : "Oasis Center"
                }, {
                    "id" : 110262,
                    "name" : "Old & New Consulate Areas"
                }, {
                    "id" : 110263,
                    "name" : "Old Town"
                }, {
                    "id" : 110264,
                    "name" : "Other"
                }, {
                    "id" : 110265,
                    "name" : "Oud Al Muteena"
                }, {
                    "id" : 110266,
                    "name" : "Oud Metha"
                }, {
                    "id" : 110267,
                    "name" : "Palm Deira"
                }, {
                    "id" : 110268,
                    "name" : "Palm Jabel Ali"
                }, {
                    "id" : 110269,
                    "name" : "Palm Jumeirah"
                }, {
                    "id" : 110270,
                    "name" : "Police Academy"
                }, {
                    "id" : 110271,
                    "name" : "Police Colony"
                }, {
                    "id" : 110272,
                    "name" : "Port Rashid"
                }, {
                    "id" : 110273,
                    "name" : "Port Saeed"
                }, {
                    "id" : 110274,
                    "name" : "Qusais Industrial Area"
                }, {
                    "id" : 110275,
                    "name" : "Ras Al Khor"
                }, {
                    "id" : 110276,
                    "name" : "Rashid Hospital"
                }, {
                    "id" : 110277,
                    "name" : "Remraam"
                }, {
                    "id" : 110278,
                    "name" : "Rolla Street"
                }, {
                    "id" : 110279,
                    "name" : "Sabka Bus Station"
                }, {
                    "id" : 110280,
                    "name" : "Safa Park"
                }, {
                    "id" : 110281,
                    "name" : "Salahuddin Road"
                }, {
                    "id" : 110282,
                    "name" : "Samari Village"
                }, {
                    "id" : 110283,
                    "name" : "Sheikh Hamdan Colony"
                }, {
                    "id" : 110284,
                    "name" : "Sheikh Zayed Road"
                }, {
                    "id" : 110285,
                    "name" : "Sidar Hospital"
                }, {
                    "id" : 110286,
                    "name" : "Skycourts"
                }, {
                    "id" : 110287,
                    "name" : "Sonapur"
                }, {
                    "id" : 110288,
                    "name" : "Souq Madinat Al-Jumeirah"
                }, {
                    "id" : 110289,
                    "name" : "Springs"
                }, {
                    "id" : 110290,
                    "name" : "Studio City"
                }, {
                    "id" : 110291,
                    "name" : "Techno Park"
                }, {
                    "id" : 110292,
                    "name" : "Tecom"
                }, {
                    "id" : 110293,
                    "name" : "Textile City"
                }, {
                    "id" : 110294,
                    "name" : "Textile Market"
                }, {
                    "id" : 110295,
                    "name" : "The Club House"
                }, {
                    "id" : 110296,
                    "name" : "The Lakes"
                }, {
                    "id" : 110297,
                    "name" : "The World Islands"
                }, {
                    "id" : 110298,
                    "name" : "Tijara Town"
                }, {
                    "id" : 110299,
                    "name" : "Time Square"
                }, {
                    "id" : 110300,
                    "name" : "Umm Hurair 1"
                }, {
                    "id" : 110301,
                    "name" : "Umm Hurair 2"
                }, {
                    "id" : 110302,
                    "name" : "Umm Ramool"
                }, {
                    "id" : 110303,
                    "name" : "Umm Sheif"
                }, {
                    "id" : 110304,
                    "name" : "Umm Suqeim"
                }, {
                    "id" : 110305,
                    "name" : "Uptown Mirdif"
                }, {
                    "id" : 110306,
                    "name" : "Uptown Motor City"
                }, {
                    "id" : 110307,
                    "name" : "Vegetable Market"
                }, {
                    "id" : 110308,
                    "name" : "Views"
                }, {
                    "id" : 110309,
                    "name" : "Villa"
                }, {
                    "id" : 110310,
                    "name" : "Wadi Al Mardi"
                }, {
                    "id" : 110311,
                    "name" : "Wafi City"
                }, {
                    "id" : 110312,
                    "name" : "Warsan Estate"
                }, {
                    "id" : 110313,
                    "name" : "World"
                }, {
                    "id" : 110314,
                    "name" : "Zabeel"
                }, {
                    "id" : 110315,
                    "name" : "Zabeel Park"
                }, {
                    "id" : 110316,
                    "name" : "Zulekha Hospital"
                }, {
                    "id" : 110317,
                    "name" : "Vegetable Market"
                }
            ],
            "120000" : [{
                    "id" : 120001,
                    "name" : "AL Mafraq Industrial Area"
                }, {
                    "id" : 120002,
                    "name" : "Abu Dhabi Media Co"
                }, {
                    "id" : 120003,
                    "name" : "Abu-Dhabi Bus Station"
                }, {
                    "id" : 120004,
                    "name" : "Abu-Dhabi Exhibition Centre (ADNEC)"
                }, {
                    "id" : 120005,
                    "name" : "Abu-Dhabi Golf club & Resort"
                }, {
                    "id" : 120006,
                    "name" : "Abu-Dhabi Indian School"
                }, {
                    "id" : 120007,
                    "name" : "Abu-Dhabi Int'l Airport"
                }, {
                    "id" : 120008,
                    "name" : "Abu-Dhabi Mall"
                }, {
                    "id" : 120009,
                    "name" : "Abu-Dhabi Motor co"
                }, {
                    "id" : 120010,
                    "name" : "Abu-Dhabi Muncipality"
                }, {
                    "id" : 120011,
                    "name" : "Abu-Dhabi Police Academy"
                }, {
                    "id" : 120012,
                    "name" : "Abu-Dhabi Traffic"
                }, {
                    "id" : 120013,
                    "name" : "Airport Street"
                }, {
                    "id" : 120014,
                    "name" : "Al Bateen"
                }, {
                    "id" : 120015,
                    "name" : "Al Bateen Airport"
                }, {
                    "id" : 120016,
                    "name" : "Al Dhafrah"
                }, {
                    "id" : 120017,
                    "name" : "Al Hosn"
                }, {
                    "id" : 120018,
                    "name" : "Al Karamah"
                }, {
                    "id" : 120019,
                    "name" : "Al Khalidiyah"
                }, {
                    "id" : 120020,
                    "name" : "Al Khubeirah"
                }, {
                    "id" : 120021,
                    "name" : "Al Manhal"
                }, {
                    "id" : 120022,
                    "name" : "Al Markaziya"
                }, {
                    "id" : 120023,
                    "name" : "Al Mushrif"
                }, {
                    "id" : 120024,
                    "name" : "Al Raha Beach"
                }, {
                    "id" : 120025,
                    "name" : "Al Raha Gardens"
                }, {
                    "id" : 120026,
                    "name" : "Al Reef Downtown"
                }, {
                    "id" : 120027,
                    "name" : "Al Reef Villas"
                }, {
                    "id" : 120028,
                    "name" : "Al Reem Island"
                }, {
                    "id" : 120029,
                    "name" : "Al Riyadiya"
                }, {
                    "id" : 120030,
                    "name" : "Al Rowdah"
                }, {
                    "id" : 120031,
                    "name" : "Al Tabbiyah"
                }, {
                    "id" : 120032,
                    "name" : "Al Wahda Mall Area"
                }, {
                    "id" : 120033,
                    "name" : "Al-Bahia -A"
                }, {
                    "id" : 120034,
                    "name" : "Al-Bahia -B"
                }, {
                    "id" : 120035,
                    "name" : "Al-Dar Lang"
                }, {
                    "id" : 120036,
                    "name" : "Al-Dhafra Air Base Area"
                }, {
                    "id" : 120037,
                    "name" : "Al-Falah City"
                }, {
                    "id" : 120038,
                    "name" : "Al-Falah street"
                }, {
                    "id" : 120039,
                    "name" : "Al-Khaleej Al-Arabi St"
                }, {
                    "id" : 120040,
                    "name" : "Al-Nahyan Camp Area"
                }, {
                    "id" : 120041,
                    "name" : "Al-Najda Street"
                }, {
                    "id" : 120042,
                    "name" : "Al-Naser Street"
                }, {
                    "id" : 120043,
                    "name" : "Al-Noor Hospital"
                }, {
                    "id" : 120044,
                    "name" : "Al-Saada Street"
                }, {
                    "id" : 120045,
                    "name" : "Al-Shamkha"
                }, {
                    "id" : 120046,
                    "name" : "Baniyas (East)"
                }, {
                    "id" : 120047,
                    "name" : "Baniyas (West)"
                }, {
                    "id" : 120048,
                    "name" : "Bateen Towers"
                }, {
                    "id" : 120049,
                    "name" : "Baynoonah Street"
                }, {
                    "id" : 120050,
                    "name" : "Between The Bridges"
                }, {
                    "id" : 120051,
                    "name" : "Building Material City"
                }, {
                    "id" : 120052,
                    "name" : "Carrefour"
                }, {
                    "id" : 120053,
                    "name" : "Central Market"
                }, {
                    "id" : 120054,
                    "name" : "Coconut Island"
                }, {
                    "id" : 120055,
                    "name" : "Corniche"
                }, {
                    "id" : 120056,
                    "name" : "Danet Gateway"
                }, {
                    "id" : 120057,
                    "name" : "Defence Road"
                }, {
                    "id" : 120058,
                    "name" : "Delma Street"
                }, {
                    "id" : 120059,
                    "name" : "Electra Street"
                }, {
                    "id" : 120060,
                    "name" : "Embassy Area"
                }, {
                    "id" : 120061,
                    "name" : "Emirates Driving Co."
                }, {
                    "id" : 120062,
                    "name" : "Emirates Palace Hotel"
                }, {
                    "id" : 120063,
                    "name" : "Ferrari World"
                }, {
                    "id" : 120064,
                    "name" : "Garden Tower"
                }, {
                    "id" : 120065,
                    "name" : "Hadbat Al Zaafran"
                }, {
                    "id" : 120066,
                    "name" : "Hamdan Post Office"
                }, {
                    "id" : 120067,
                    "name" : "Hamdan Street"
                }, {
                    "id" : 120068,
                    "name" : "Hazza Bin Zayed Street"
                }, {
                    "id" : 120069,
                    "name" : "Hoderiyyat"
                }, {
                    "id" : 120070,
                    "name" : "Hydra Golf Walk"
                }, {
                    "id" : 120071,
                    "name" : "Hydra Village"
                }, {
                    "id" : 120072,
                    "name" : "Industrial City Of Abu Dhabi"
                }, {
                    "id" : 120073,
                    "name" : "Int'l school of Choueifat"
                }, {
                    "id" : 120074,
                    "name" : "Istiklal Street"
                }, {
                    "id" : 120075,
                    "name" : "Khalidiya Mall"
                }, {
                    "id" : 120076,
                    "name" : "Khalidiya Village"
                }, {
                    "id" : 120077,
                    "name" : "Khalifa City-A"
                }, {
                    "id" : 120078,
                    "name" : "Khalifa Energy Complex"
                }, {
                    "id" : 120079,
                    "name" : "Khalifa Park"
                }, {
                    "id" : 120080,
                    "name" : "Khalifa Street"
                }, {
                    "id" : 120081,
                    "name" : "Khalifha City- B"
                }, {
                    "id" : 120082,
                    "name" : "Khor Al Maqta"
                }, {
                    "id" : 120083,
                    "name" : "Lulu Island"
                }, {
                    "id" : 120084,
                    "name" : "Madinat Zayed"
                }, {
                    "id" : 120085,
                    "name" : "Mangrove Village"
                }, {
                    "id" : 120086,
                    "name" : "Maqta Bridge"
                }, {
                    "id" : 120087,
                    "name" : "Marina Mall"
                }, {
                    "id" : 120088,
                    "name" : "Marina Village"
                }, {
                    "id" : 120089,
                    "name" : "Masdar City"
                }, {
                    "id" : 120090,
                    "name" : "Mina Zayed Port"
                }, {
                    "id" : 120091,
                    "name" : "Mohammed Bin Zayed City"
                }, {
                    "id" : 120092,
                    "name" : "Mushayrib Island"
                }, {
                    "id" : 120093,
                    "name" : "Mussafah"
                }, {
                    "id" : 120094,
                    "name" : "Mussafah Industrial Area"
                }, {
                    "id" : 120095,
                    "name" : "Mussafah Police Station Area"
                }, {
                    "id" : 120096,
                    "name" : "Mussafah Shabia"
                }, {
                    "id" : 120097,
                    "name" : "New Shahamma"
                }, {
                    "id" : 120098,
                    "name" : "Nurai Island"
                }, {
                    "id" : 120099,
                    "name" : "Officer Club"
                }, {
                    "id" : 120100,
                    "name" : "Officers City"
                }, {
                    "id" : 120101,
                    "name" : "Old Mazda Road"
                }, {
                    "id" : 120102,
                    "name" : "Old Shahamma"
                }, {
                    "id" : 120103,
                    "name" : "Other"
                }, {
                    "id" : 120104,
                    "name" : "Petrolium Institute"
                }, {
                    "id" : 120105,
                    "name" : "Police College"
                }, {
                    "id" : 120106,
                    "name" : "Qasr Al Sarab"
                }, {
                    "id" : 120107,
                    "name" : "Qasr El Bahr"
                }, {
                    "id" : 120108,
                    "name" : "Rahba"
                }, {
                    "id" : 120109,
                    "name" : "Ras Al Akhdar"
                }, {
                    "id" : 120110,
                    "name" : "SAS Al Nakheel"
                }, {
                    "id" : 120111,
                    "name" : "SKMC"
                }, {
                    "id" : 120112,
                    "name" : "Saadiyat Island"
                }, {
                    "id" : 120113,
                    "name" : "Salam Street"
                }, {
                    "id" : 120114,
                    "name" : "Samha Area"
                }, {
                    "id" : 120115,
                    "name" : "Saraya"
                }, {
                    "id" : 120116,
                    "name" : "Shwamakh"
                }, {
                    "id" : 120117,
                    "name" : "Suwa Island"
                }, {
                    "id" : 120118,
                    "name" : "Umm Al Nar"
                }, {
                    "id" : 120119,
                    "name" : "Yas Island"
                }, {
                    "id" : 120120,
                    "name" : "Zaab Area"
                }, {
                    "id" : 120121,
                    "name" : "Zayed Sports City"
                }, {
                    "id" : 120122,
                    "name" : "Ziany Area"
                }
            ],
            "130000" : [{
                    "id" : 130001,
                    "name" : "Abu Shaghara"
                }, {
                    "id" : 130002,
                    "name" : "Abu Tina"
                }, {
                    "id" : 130003,
                    "name" : "Al Aber"
                }, {
                    "id" : 130004,
                    "name" : "Al Azrra"
                }, {
                    "id" : 130005,
                    "name" : "Al Darrare"
                }, {
                    "id" : 130006,
                    "name" : "Al Fallaj"
                }, {
                    "id" : 130007,
                    "name" : "Al Fayha"
                }, {
                    "id" : 130008,
                    "name" : "Al Fisht"
                }, {
                    "id" : 130009,
                    "name" : "Al Ghafiya"
                }, {
                    "id" : 130010,
                    "name" : "Al Gharb"
                }, {
                    "id" : 130011,
                    "name" : "Al Ghubaiba"
                }, {
                    "id" : 130012,
                    "name" : "Al Ghuwair"
                }, {
                    "id" : 130013,
                    "name" : "Al Goaz"
                }, {
                    "id" : 130014,
                    "name" : "Al Hazana"
                }, {
                    "id" : 130015,
                    "name" : "Al Heera Suburb"
                }, {
                    "id" : 130016,
                    "name" : "Al Jazzet"
                }, {
                    "id" : 130017,
                    "name" : "Al Khaildia Suburb"
                }, {
                    "id" : 130018,
                    "name" : "Al Khan"
                }, {
                    "id" : 130019,
                    "name" : "Al Khouzamiya"
                }, {
                    "id" : 130020,
                    "name" : "Al Layyah Suburb"
                }, {
                    "id" : 130021,
                    "name" : "Al Majaz"
                }, {
                    "id" : 130022,
                    "name" : "Al Mamzar"
                }, {
                    "id" : 130023,
                    "name" : "Al Mirgab"
                }, {
                    "id" : 130024,
                    "name" : "Al Muntazah"
                }, {
                    "id" : 130025,
                    "name" : "Al Musalla"
                }, {
                    "id" : 130026,
                    "name" : "Al Nabba"
                }, {
                    "id" : 130027,
                    "name" : "Al Nahda"
                }, {
                    "id" : 130028,
                    "name" : "Al Nasserya"
                }, {
                    "id" : 130029,
                    "name" : "Al Nekhailat"
                }, {
                    "id" : 130030,
                    "name" : "Al Nud"
                }, {
                    "id" : 130031,
                    "name" : "Al Qadsiya"
                }, {
                    "id" : 130032,
                    "name" : "Al Qasimia"
                }, {
                    "id" : 130033,
                    "name" : "Al Quilaiaah"
                }, {
                    "id" : 130034,
                    "name" : "Al Ramaqiya"
                }, {
                    "id" : 130035,
                    "name" : "Al Ramla"
                }, {
                    "id" : 130036,
                    "name" : "Al Ramtha"
                }, {
                    "id" : 130037,
                    "name" : "Al Rifaa"
                }, {
                    "id" : 130038,
                    "name" : "Al Riqa Suburb"
                }, {
                    "id" : 130039,
                    "name" : "Al Seef"
                }, {
                    "id" : 130040,
                    "name" : "Al Shahab"
                }, {
                    "id" : 130041,
                    "name" : "Al Sharq"
                }, {
                    "id" : 130042,
                    "name" : "Al Soor"
                }, {
                    "id" : 130043,
                    "name" : "Al Subaikha"
                }, {
                    "id" : 130044,
                    "name" : "Al Swehat"
                }, {
                    "id" : 130045,
                    "name" : "Al Talae"
                }, {
                    "id" : 130046,
                    "name" : "Al Yarmook"
                }, {
                    "id" : 130047,
                    "name" : "Al-Budai"
                }, {
                    "id" : 130048,
                    "name" : "Al-Faha"
                }, {
                    "id" : 130049,
                    "name" : "Al-Majaz 1,2,3"
                }, {
                    "id" : 130050,
                    "name" : "Al-Mansura"
                }, {
                    "id" : 130051,
                    "name" : "Al-Nahda Sharjah Areas"
                }, {
                    "id" : 130052,
                    "name" : "Al-Tawoon"
                }, {
                    "id" : 130053,
                    "name" : "Bank Street"
                }, {
                    "id" : 130054,
                    "name" : "Beach Road"
                }, {
                    "id" : 130055,
                    "name" : "Bu Danig"
                }, {
                    "id" : 130056,
                    "name" : "Buhairah Corniche"
                }, {
                    "id" : 130057,
                    "name" : "Dasman"
                }, {
                    "id" : 130058,
                    "name" : "Dubai Bypass Road"
                }, {
                    "id" : 130059,
                    "name" : "Eliash"
                }, {
                    "id" : 130060,
                    "name" : "Falah Camp"
                }, {
                    "id" : 130061,
                    "name" : "Halwan Suburb"
                }, {
                    "id" : 130062,
                    "name" : "Hydra Village"
                }, {
                    "id" : 130063,
                    "name" : "Industrial Area"
                }, {
                    "id" : 130064,
                    "name" : "Industrial Area-13"
                }, {
                    "id" : 130065,
                    "name" : "Industrial Area-15"
                }, {
                    "id" : 130066,
                    "name" : "Industrial Area-17"
                }, {
                    "id" : 130067,
                    "name" : "Jamal Abdul Naser Street"
                }, {
                    "id" : 130068,
                    "name" : "Jubail"
                }, {
                    "id" : 130069,
                    "name" : "Khalid Port"
                }, {
                    "id" : 130070,
                    "name" : "Khalidiya"
                }, {
                    "id" : 130071,
                    "name" : "Manakh"
                }, {
                    "id" : 130072,
                    "name" : "Margab"
                }, {
                    "id" : 130073,
                    "name" : "Maysaloon"
                }, {
                    "id" : 130074,
                    "name" : "Mualah"
                }, {
                    "id" : 130075,
                    "name" : "Mughaidir Suburb"
                }, {
                    "id" : 130076,
                    "name" : "Mujerah"
                }, {
                    "id" : 130077,
                    "name" : "Muwafjah"
                }, {
                    "id" : 130078,
                    "name" : "Muwailih Commercial"
                }, {
                    "id" : 130079,
                    "name" : "Naba"
                }, {
                    "id" : 130080,
                    "name" : "Nahilak"
                }, {
                    "id" : 130081,
                    "name" : "Naseriya"
                }, {
                    "id" : 130082,
                    "name" : "Other"
                }, {
                    "id" : 130083,
                    "name" : "Queen Tower"
                }, {
                    "id" : 130084,
                    "name" : "Qulaya"
                }, {
                    "id" : 130085,
                    "name" : "Rahmanya"
                }, {
                    "id" : 130086,
                    "name" : "Rifa"
                }, {
                    "id" : 130087,
                    "name" : "Saif Zone"
                }, {
                    "id" : 130088,
                    "name" : "Sajjah Area"
                }, {
                    "id" : 130089,
                    "name" : "Samnan"
                }, {
                    "id" : 130090,
                    "name" : "Shargan"
                }, {
                    "id" : 130091,
                    "name" : "Sharjah Airport Area"
                }, {
                    "id" : 130092,
                    "name" : "Sharjah Cricket Stadium"
                }, {
                    "id" : 130093,
                    "name" : "Sharjah Industrial Areas 1-14"
                }, {
                    "id" : 130094,
                    "name" : "Sharjah Investment Center"
                }, {
                    "id" : 130095,
                    "name" : "Sharjah University"
                }, {
                    "id" : 130096,
                    "name" : "Subkha"
                }, {
                    "id" : 130097,
                    "name" : "Suwhain"
                }, {
                    "id" : 130098,
                    "name" : "Turrfana"
                }, {
                    "id" : 130099,
                    "name" : "Um Tarrsfa"
                }, {
                    "id" : 130100,
                    "name" : "Wasit Suburb"
                }
            ],
    
            "140000" : [{
                    "id" : 140001,
                    "name" : "Abu Samra"
                }, {
                    "id" : 140002,
                    "name" : "Airport District"
                }, {
                    "id" : 140003,
                    "name" : "Al Dhaher"
                }, {
                    "id" : 140004,
                    "name" : "Al Foah"
                }, {
                    "id" : 140005,
                    "name" : "Al Jimi"
                }, {
                    "id" : 140006,
                    "name" : "Al Maqam"
                }, {
                    "id" : 140007,
                    "name" : "Al Saad"
                }, {
                    "id" : 140008,
                    "name" : "Al Salamat"
                }, {
                    "id" : 140009,
                    "name" : "Al Shwaib"
                }, {
                    "id" : 140010,
                    "name" : "Al Yahar"
                }, {
                    "id" : 140011,
                    "name" : "Al-Ain Fun City"
                }, {
                    "id" : 140012,
                    "name" : "Al-Ain Zoo"
                }, {
                    "id" : 140013,
                    "name" : "Al-Badiya Park"
                }, {
                    "id" : 140014,
                    "name" : "Al-Bateen"
                }, {
                    "id" : 140015,
                    "name" : "Al-Falaj"
                }, {
                    "id" : 140016,
                    "name" : "Al-Grayyeh"
                }, {
                    "id" : 140017,
                    "name" : "Al-Masoudi"
                }, {
                    "id" : 140018,
                    "name" : "Al-Mutarad"
                }, {
                    "id" : 140019,
                    "name" : "Al-Mutawaa"
                }, {
                    "id" : 140020,
                    "name" : "Al-Muwaiji"
                }, {
                    "id" : 140021,
                    "name" : "Al-Tawia"
                }, {
                    "id" : 140022,
                    "name" : "Central Destrict"
                }, {
                    "id" : 140023,
                    "name" : "Gafat Al-Nayyar"
                }, {
                    "id" : 140024,
                    "name" : "Green Mubazzarah"
                }, {
                    "id" : 140025,
                    "name" : "Hilli Archaeological Park"
                }, {
                    "id" : 140026,
                    "name" : "Jebel hafeet"
                }, {
                    "id" : 140027,
                    "name" : "Neima"
                }, {
                    "id" : 140028,
                    "name" : "New Manasir"
                }, {
                    "id" : 140029,
                    "name" : "Sanaya"
                }, {
                    "id" : 140030,
                    "name" : "Sarooj"
                }, {
                    "id" : 140031,
                    "name" : "Sheikh Tahnoon Stadium Sport Club"
                }, {
                    "id" : 140032,
                    "name" : "Shiab Al Ashkhar"
                }, {
                    "id" : 140033,
                    "name" : "Sweihan"
                }, {
                    "id" : 140034,
                    "name" : "Um Ghafa"
                }, {
                    "id" : 140035,
                    "name" : "Zakher"
                }
            ],
            "150000" : [{
                    "id" : 150001,
                    "name" : "Al Faseel Area"
                }, {
                    "id" : 150002,
                    "name" : "Al Jaber Tower"
                }, {
                    "id" : 150003,
                    "name" : "Al Wurayah Valley"
                }, {
                    "id" : 150004,
                    "name" : "Al-Badiya"
                }, {
                    "id" : 150005,
                    "name" : "Al-Baladiya"
                }, {
                    "id" : 150006,
                    "name" : "Al-Faseel"
                }, {
                    "id" : 150007,
                    "name" : "Al-Ghail"
                }, {
                    "id" : 150008,
                    "name" : "Al-Gurfaaa"
                }, {
                    "id" : 150009,
                    "name" : "Al-Ittihad"
                }, {
                    "id" : 150010,
                    "name" : "Dhaid"
                }, {
                    "id" : 150011,
                    "name" : "Dibba"
                }, {
                    "id" : 150012,
                    "name" : "Friday Market"
                }, {
                    "id" : 150013,
                    "name" : "Fujairah Etisalat"
                }, {
                    "id" : 150014,
                    "name" : "Fujairah Football Club"
                }, {
                    "id" : 150015,
                    "name" : "Fujairah Heritage"
                }, {
                    "id" : 150016,
                    "name" : "Fujairah Municipality"
                }, {
                    "id" : 150017,
                    "name" : "Fujairah Port"
                }, {
                    "id" : 150018,
                    "name" : "Fujairah Tower"
                }, {
                    "id" : 150019,
                    "name" : "Fujairah Trade Centre"
                }, {
                    "id" : 150020,
                    "name" : "Gurfah Area"
                }, {
                    "id" : 150021,
                    "name" : "Khorfakkan"
                }, {
                    "id" : 150022,
                    "name" : "Madhab"
                }, {
                    "id" : 150023,
                    "name" : "Manama"
                }, {
                    "id" : 150024,
                    "name" : "Masafi"
                }, {
                    "id" : 150025,
                    "name" : "Merashid Area"
                }, {
                    "id" : 150026,
                    "name" : "Mina Al Fajer"
                }, {
                    "id" : 150027,
                    "name" : "Rul Dadna"
                }, {
                    "id" : 150028,
                    "name" : "Sakamkam"
                }, {
                    "id" : 150029,
                    "name" : "Skamkam"
                }, {
                    "id" : 150030,
                    "name" : "Tawban"
                }, {
                    "id" : 150031,
                    "name" : "Taweelah"
                }, {
                    "id" : 150032,
                    "name" : "Town Center"
                }
            ],
            "160000" : [{
                    "id" : 160001,
                    "name" : "Adan"
                }, {
                    "id" : 160002,
                    "name" : "Al Biyatah"
                }, {
                    "id" : 160003,
                    "name" : "Al Brerat"
                }, {
                    "id" : 160004,
                    "name" : "Al Dhait South"
                }, {
                    "id" : 160005,
                    "name" : "Al Rams"
                }, {
                    "id" : 160006,
                    "name" : "Al Riffa"
                }, {
                    "id" : 160007,
                    "name" : "Al-Dhaith North"
                }, {
                    "id" : 160008,
                    "name" : "Al-Ghub"
                }, {
                    "id" : 160009,
                    "name" : "Al-Khor Road"
                }, {
                    "id" : 160010,
                    "name" : "Al-Mamourah"
                }, {
                    "id" : 160011,
                    "name" : "Al-Mareed"
                }, {
                    "id" : 160012,
                    "name" : "Al-Qasmi Corniche Road"
                }, {
                    "id" : 160013,
                    "name" : "Dafan Al-Khor"
                }, {
                    "id" : 160014,
                    "name" : "Digdagga"
                }, {
                    "id" : 160015,
                    "name" : "Jazirat Al Hamra"
                }, {
                    "id" : 160016,
                    "name" : "Jazirat Al Hamra-Free Zone 1"
                }, {
                    "id" : 160017,
                    "name" : "Jazirat Al Hamra-Free Zone 2"
                }, {
                    "id" : 160018,
                    "name" : "Julan"
                }, {
                    "id" : 160019,
                    "name" : "Kharran"
                }, {
                    "id" : 160020,
                    "name" : "Khatt"
                }, {
                    "id" : 160021,
                    "name" : "Khor Khwair"
                }, {
                    "id" : 160022,
                    "name" : "Khuzam"
                }, {
                    "id" : 160023,
                    "name" : "Marjan Island"
                }, {
                    "id" : 160024,
                    "name" : "Mina Al-Arab"
                }, {
                    "id" : 160025,
                    "name" : "Nakheel"
                }, {
                    "id" : 160026,
                    "name" : "Old Ras Al Khaimah"
                }, {
                    "id" : 160027,
                    "name" : "Qusaidat"
                }, {
                    "id" : 160028,
                    "name" : "RAK Airport Area"
                }, {
                    "id" : 160029,
                    "name" : "Shamal"
                }
            ],
            "170000" : [{
                    "id" : 170001,
                    "name" : "Ain Ajman"
                }, {
                    "id" : 170002,
                    "name" : "Ajman City Centre"
                }, {
                    "id" : 170003,
                    "name" : "Ajman Freezone"
                }, {
                    "id" : 170004,
                    "name" : "Ajman Marina"
                }, {
                    "id" : 170005,
                    "name" : "Ajman Meadows"
                }, {
                    "id" : 170006,
                    "name" : "Ajman Police Headquarters"
                }, {
                    "id" : 170007,
                    "name" : "Ajman University"
                }, {
                    "id" : 170008,
                    "name" : "Ajman Uptown"
                }, {
                    "id" : 170009,
                    "name" : "Ajman Villas"
                }, {
                    "id" : 170010,
                    "name" : "Al Ameera Village"
                }, {
                    "id" : 170011,
                    "name" : "Al Bustan"
                }, {
                    "id" : 170012,
                    "name" : "Al Butain"
                }, {
                    "id" : 170013,
                    "name" : "Al Hamidiya"
                }, {
                    "id" : 170014,
                    "name" : "Al Helio City"
                }, {
                    "id" : 170015,
                    "name" : "Al Humaid City"
                }, {
                    "id" : 170016,
                    "name" : "Al Ittihad Village"
                }, {
                    "id" : 170017,
                    "name" : "Al Jerf Gardens"
                }, {
                    "id" : 170018,
                    "name" : "Al Karama Ajman"
                }, {
                    "id" : 170019,
                    "name" : "Al Karama Area"
                }, {
                    "id" : 170020,
                    "name" : "Al Man1 Tower"
                }, {
                    "id" : 170021,
                    "name" : "Al Nakhil"
                }, {
                    "id" : 170022,
                    "name" : "Al Noor Tower Ajman"
                }, {
                    "id" : 170023,
                    "name" : "Al Owan"
                }, {
                    "id" : 170024,
                    "name" : "Al Rashidia"
                }, {
                    "id" : 170025,
                    "name" : "Al Rumaila"
                }, {
                    "id" : 170026,
                    "name" : "Al Zorah"
                }, {
                    "id" : 170027,
                    "name" : "Al-Zahra"
                }, {
                    "id" : 170028,
                    "name" : "Aqua City"
                }, {
                    "id" : 170029,
                    "name" : "Awali City"
                }, {
                    "id" : 170030,
                    "name" : "Chapal Flora"
                }, {
                    "id" : 170031,
                    "name" : "Emirates City"
                }, {
                    "id" : 170032,
                    "name" : "Escape Ajman"
                }, {
                    "id" : 170033,
                    "name" : "Eye Of Ajman"
                }, {
                    "id" : 170034,
                    "name" : "Falcon Tower"
                }, {
                    "id" : 170035,
                    "name" : "Fewa Ajman"
                }, {
                    "id" : 170036,
                    "name" : "Freej Balushi"
                }, {
                    "id" : 170037,
                    "name" : "GMC"
                }, {
                    "id" : 170038,
                    "name" : "Green City"
                }, {
                    "id" : 170039,
                    "name" : "Hamdiya -Jarf"
                }, {
                    "id" : 170040,
                    "name" : "Hamriya Freezone"
                }, {
                    "id" : 170041,
                    "name" : "Hamriya Town"
                }, {
                    "id" : 170042,
                    "name" : "Jurf"
                }, {
                    "id" : 170043,
                    "name" : "Liwara"
                }, {
                    "id" : 170044,
                    "name" : "Marmooka City"
                }, {
                    "id" : 170045,
                    "name" : "Mishrif City"
                }, {
                    "id" : 170046,
                    "name" : "Mishrif Villas"
                }, {
                    "id" : 170047,
                    "name" : "Muwaihath"
                }, {
                    "id" : 170048,
                    "name" : "Naemiyah"
                }, {
                    "id" : 170049,
                    "name" : "New Industrial Area"
                }, {
                    "id" : 170050,
                    "name" : "New Industrial City"
                }, {
                    "id" : 170051,
                    "name" : "Old Industrial Area"
                }, {
                    "id" : 170052,
                    "name" : "Onyx City"
                }, {
                    "id" : 170053,
                    "name" : "Park View City"
                }, {
                    "id" : 170054,
                    "name" : "Rumaila"
                }, {
                    "id" : 170055,
                    "name" : "Rumaila Area"
                }, {
                    "id" : 170056,
                    "name" : "Sanaya Industrial Area"
                }, {
                    "id" : 170057,
                    "name" : "Sowan"
                }
            ],
            "180000" : [{
                    "id" : 180001,
                    "name" : "Al Aahad Area"
                }, {
                    "id" : 180002,
                    "name" : "Al Abraq Area"
                }, {
                    "id" : 180003,
                    "name" : "Al Aqran"
                }, {
                    "id" : 180004,
                    "name" : "Al Butain"
                }, {
                    "id" : 180005,
                    "name" : "Al Dar Al Baida Area"
                }, {
                    "id" : 180006,
                    "name" : "Al Haditha Area"
                }, {
                    "id" : 180007,
                    "name" : "Al Hawiyah Area"
                }, {
                    "id" : 180008,
                    "name" : "Al Hazzan Area"
                }, {
                    "id" : 180009,
                    "name" : "Al Humrah Area"
                }, {
                    "id" : 180010,
                    "name" : "Al Khor Area"
                }, {
                    "id" : 180011,
                    "name" : "Al Madar Area"
                }, {
                    "id" : 180012,
                    "name" : "Al Maidan Area"
                }, {
                    "id" : 180013,
                    "name" : "Al Raafa"
                }, {
                    "id" : 180014,
                    "name" : "Al Raas Area"
                }, {
                    "id" : 180015,
                    "name" : "Al Ramlah Area"
                }, {
                    "id" : 180016,
                    "name" : "Al Rashidiya"
                }, {
                    "id" : 180017,
                    "name" : "Al Raudah Area"
                }, {
                    "id" : 180018,
                    "name" : "Al Riqqah Area"
                }, {
                    "id" : 180019,
                    "name" : "Al Salamah Area"
                }, {
                    "id" : 180020,
                    "name" : "Al Surrah"
                }, {
                    "id" : 180021,
                    "name" : "Defence Camp Area"
                }, {
                    "id" : 180022,
                    "name" : "Dream Land"
                }, {
                    "id" : 180023,
                    "name" : "Falaj Al Moalla"
                }, {
                    "id" : 180024,
                    "name" : "Green Belt Area"
                }, {
                    "id" : 180025,
                    "name" : "Industrial Area"
                }, {
                    "id" : 180026,
                    "name" : "Kaber"
                }, {
                    "id" : 180027,
                    "name" : "Limaghadar Area"
                }, {
                    "id" : 180028,
                    "name" : "Lubsah"
                }, {
                    "id" : 180029,
                    "name" : "Mohadhub"
                }, {
                    "id" : 180030,
                    "name" : "Old Town Area"
                }, {
                    "id" : 180031,
                    "name" : "Umm Al Thaoub"
                }
            ],
            "190000" : [{
                "id" : 190001,
                "name" : "Western Region"
                }
            ]
        }
    }
    
    var arr=[];
    var fun=function(a){
        var b={};
    for(var i=0;i<a.length;i++){
        b[a[i]["name"]]=a[i]["id"].toString()
    }
    arr.push(b);
    }
    
    fun(data["city"]["110000"]);
    fun(data["city"]["120000"]);
    fun(data["city"]["130000"]);
    fun(data["city"]["140000"]);
    fun(data["city"]["150000"]);
    fun(data["city"]["160000"]);
    fun(data["city"]["170000"]);
    fun(data["city"]["180000"]);
    fun(data["city"]["190000"]);
    
    var obj={};
    obj["Dubai"] =arr[0];
    obj["Abu Dhabi"] =arr[1];
    obj["Sharjah"] =arr[2];
    obj["Al Ain"] =arr[3];
    obj["Fujairah"] =arr[4];
    obj["Ras Al Khaimah"] =arr[5];
    obj["Ajman"] =arr[6];
    obj["Umm Al Quwain"] =arr[7];
    obj["Western Region"] =arr[8];
    
    var data = obj;
    /**
     * twzipcode Constructor
     * @param {Object} container HTML element
     * @param {(Object|string)} options User settings
     * @constructor
     */
    function TWzipcode (container, options) {
        /**
         * Default settings
         * @type {Object}
         */
        var defaults = {
            'countyName': 'state',
            'css': [],
            'detect': false,             // v1.6.7
            'districtName': 'city',
            'googleMapsKey': '', // v1.6.9
            'hideCounty': [], // v1.7.9
            'hideDistrict': [], // v1.7.9
            'onCountySelect': null,      // v1.5
            'onDistrictSelect': null,    // v1.5
            'onZipcodeKeyUp': null,      // v1.5
            'readonly': false,
            'zipcodeName': 'zipcode',
            'zipcodePlaceholder': '郵遞區號',
            'zipcodeIntoDistrict': false, // v1.6.6
        };
        /**
         * DOM of selector
         * @type {Object}
         */
        this.container = $(container);
        /**
         * Merge the options
         * @type {Object}
         */
        this.options = $.extend({}, defaults, options);
        // initialize
        this.init();
    }
    /**
     * TWzipcode prototype
     */
    TWzipcode.prototype = {

        VERSION: '1.7.10',

        /**
         * Method: Get all post data
         * @return {Object}
         */
        data: function () {
            var wrap = this.wrap;
            return 'undefined' !== typeof data[wrap.county.val()] ?
                data[wrap.county.val()] :
                data;
        },
        /**
         * Method: Serialize the data
         * @return {string}
         */
        serialize: function () {
            var result = [],
                obj = {},
                ele = {},
                s = {};
            obj = this.container.find('select,input');
            if (obj.length) {
                obj.each(function () {
                    ele = $(this);
                    result.push(ele.attr('name') + '=' + ele.val());
                });
            } else {
                $(this).children().each(function () {
                    s = $(this);
                    result.push(s.attr('name') + '=' + s.val());
                });
            }
            return result.join('&');
        },
        /**
         * Method: Destroy the container.
         * @this {TWzipcode}
         */
        destroy: function () {
            $.data(this.container.get(0), 'twzipcode', null);
            if (this.container.length) {
                return this.container.empty().off('change.twzipcode keyup.twzipcode blur.twzipcode');
            }
        },
        /**
         * Method: Get elements of instance
         * @param {(string|Array)} opts Type name
         * @param {Function} callback Function callback
         */
        get: function (callback) {
            if ('function' === typeof callback) {
                callback.call(this, this.wrap);
            } else {
                return this.wrap;
            }
        },
        /**
         * Method: Set value for elements.
         * @param {(string|number|Object)} opts Input value
         */
        set: function (opts) {

            var self = this,
                def = {
                    'county': '',
                    'district': '',
                    'zipcode': ''
                },
                opt = $.extend({}, def, opts);

            try {
                if ('string' === typeof opts || 'number' === typeof opts) {
                    self.wrap.zipcode.val(opts).trigger('blur.twzipcode');
                } else {
                    if (opt.zipcode) {
                        self.wrap.zipcode.val(opt.zipcode).trigger('blur.twzipcode');
                    }
                    if (opt.county) {
                        self.wrap.county.val(opt.county).trigger('change.twzipcode');
                    }
                    if (opt.district) {
                        self.wrap.district.val(opt.district).trigger('change.twzipcode');
                    }
                }
            } catch (ignore) {
                console.warn(ignore.message);
            } finally {
                return self.container;
            }
        },
        /**
         * Method: Reset the selected items to default.
         * @this {TWzipcode}
         */
        reset: function (container, obj) {
            var self = this,
                wrap = self.wrap,
                opts = self.options,
                county = '',
                list = {
                    'county': '<option value="">- - Select an option - -</option>',
                    'district': '<option value="">- - Select an option - -</option>'
                },
                tpl = [];

            switch (obj) {
                case 'district':
                    wrap.district.html(list.district);
                    break;
                default:
                    wrap.county.html(list.county);
                    wrap.district.html(list.district);
                    for (county in data) {
                        if ('undefined' !== typeof data[county] && -1 === opts.hideCounty.indexOf(county)) {
                            tpl.push('<option value="' + county + '">' + county + '</option>');
                        }
                    }
                    $(tpl.join('')).appendTo(wrap.county);
                    break;
            }
            wrap.zipcode.val('');
        },
        /**
         * Binding the event of the elements
         * @this {TWzipcode}
         */
        bindings: function () {

            var self = this,
                opts = self.options,
                wrap = self.wrap,
                dz   = '',
                dc   = '',
                dd   = '';

            // county
            wrap.county.on('change.twzipcode', function () {
                var val = $(this).val(),
                    district = '',
                    tpl = [];

                wrap.district.empty();

                if (val) {
                    if (true === opts.zipcodeIntoDistrict) {
                        for (district in data[val]) {
                            if ('undefined' !== typeof data[val][district] &&
                                (-1 === opts.hideDistrict.indexOf(district) && -1 === opts.hideDistrict.indexOf(data[val][district]))
                            ) {
                                tpl.push('<option value="' + district + '">');
                                tpl.push(data[val][district] + ' ' + district);
                                tpl.push('</option>');
                            }
                        }
                    } else {
                        for (district in data[val]) {
                            if ('undefined' !== typeof data[val][district] &&
                                (-1 === opts.hideDistrict.indexOf(district) && -1 === opts.hideDistrict.indexOf(data[val][district]))
                            ) {
                                tpl.push('<option value="' + district + '">');
                                tpl.push(district);
                                tpl.push('</option>');
                            }
                        }
                    }
                    wrap.district.append(tpl.join('')).trigger('change.twzipcode');
                } else {
                    wrap.county.find('option:first').prop('selected', true);
                    self.reset('district');
                }
                // County callback binding
                if ('function' === typeof opts.onCountySelect) {
                    opts.onCountySelect.call(this);
                }
            });
            // District
            wrap.district.on('change.twzipcode', function () {
                var val = $(this).val();
                if (wrap.county.val()) {
                    wrap.zipcode.val(data[wrap.county.val()][val]);
                }
                // District callback binding
                if ('function' === typeof opts.onDistrictSelect) {
                    opts.onDistrictSelect.call(this);
                }
            });
            // Zipcode
            wrap.zipcode.on('keyup.twzipcode blur.twzipcode', function () {

                var obj = $(this),
                    val = '',
                    i   = '',
                    j   = '';
                obj.val(obj.val().replace(/[^0-9]/g, ''));
                val = obj.val().toString();

                if (3 === val.length) {
                    for (i in data) {
                        if ('undefined' !== typeof data[i]) {
                            for (j in data[i]) {
                                if ('undefined' !== typeof data[i][j] &&
                                    val === data[i][j]
                                ) {
                                    wrap.county.val(i).trigger('change.twzipcode');
                                    wrap.district.val(j).trigger('change.twzipcode');
                                    break;
                                }
                            }
                        }
                    }
                }
                // Zipcode callback binding
                if ('function' === typeof opts.onZipcodeKeyUp) {
                    opts.onZipcodeKeyUp.call(this);
                }
            });

            dz = 'undefined' !== typeof opts.zipcodeSel ?
                opts.zipcodeSel :
                (
                    'undefined' !== typeof self.role.zipcode.data('value') ?
                        self.role.zipcode.data('value') :
                        opts.zipcodeSel
                );

            dc = 'undefined' !== typeof opts.countySel ?
                opts.countySel :
                (
                    'undefined' !== typeof self.role.county.data('value') ?
                        self.role.county.data('value') :
                        opts.countySel
                );

            dd = 'undefined' !== typeof opts.districtSel ?
                opts.districtSel :
                (
                    'undefined' !== typeof self.role.district.data('value') ?
                        self.role.district.data('value') :
                        opts.districtSel
                );

            // Default value
            if (dc) {
                self.wrap.county.val(dc).trigger('change.twzipcode');
                if ('undefined' !== typeof data[dc][dd]) {
                    self.wrap.district.val(dd).trigger('change.twzipcode');
                }
            }
            if (dz && 3 === dz.toString().length) {
                self.wrap.zipcode.val(dz).trigger('blur.twzipcode');
            }
        },
        /**
         * Geolocation detect
         * @this {TWzipcode}
         */
        geoLocation: function () {

            var self = this,
                geolocation = navigator.geolocation,
                options = {
                    'maximumAge': 600000,
                    'timeout': 3000,
                    'enableHighAccuracy': false
                },
                opts = self.options;

            if (!geolocation) {
                return;
            }

            geolocation.getCurrentPosition(
                function (loc) {

                    var latlng = {};
                    if (('coords' in loc) &&
                        ('latitude' in loc.coords) &&
                        ('longitude' in loc.coords)
                    ) {
                        latlng = [loc.coords.latitude, loc.coords.longitude];
                        $.getJSON(
                            'https://maps.googleapis.com/maps/api/geocode/json',
                            {
                                'key': opts.googleMapsKey,
                                'sensor': false,
                                'latlng': latlng.join(',')
                            },
                            function (data) {
                                var postal = '';
                                if (data &&
                                    'undefined' !== typeof data.results &&
                                    'undefined' !== typeof data.results[0].address_components &&
                                    'undefined' !== typeof data.results[0].address_components[0]
                                ) {
                                    postal = data.results[0]
                                        .address_components[data.results[0].address_components.length - 1]
                                        .long_name;
                                    if (postal) {
                                        self.wrap.zipcode.val(postal.toString()).trigger('blur.twzipcode');
                                    }
                                }
                            });
                    }
                },
                function (error) {
                    console.error(error);
                },
                options
            );
        },
        /**
         * twzipcode Initialize
         * @this {TWzipcode}
         */
        init: function () {

            var self = this,
                container = self.container,
                opts = self.options,
                role = {
                    county: container.find('[data-role=county]:first'),
                    district: container.find('[data-role=district]:first'),
                    zipcode: container.find('[data-role=zipcode]:first')
                },
                countyName = role.county.data('name') || opts.countyName,
                districtName = role.district.data('name') || opts.districtName,
                zipcodeName = role.zipcode.data('name') || opts.zipcodeName,
                zipcodePlaceholder = role.zipcode.data('placeholder') || opts.zipcodePlaceholder,
                readonly = role.zipcode.data('readonly') || opts.readonly;

            // Elements create
            $('<select/>')
                .attr('name', countyName)
                .addClass(role.county.data('style') || ('undefined' !== typeof opts.css[0] ? opts.css[0] : ''))
                .appendTo(role.county.length ? role.county : container);

            $('<select/>')
                .attr('name', districtName)
                .addClass(role.district.data('style') || ('undefined' !== typeof opts.css[1] ? opts.css[1] : ''))
                .appendTo(role.district.length ? role.district : container);

            $('<input/>')
                .attr({'type': 'text', 'name': zipcodeName, 'placeholder': zipcodePlaceholder})
                .prop('readonly', readonly)
                .addClass(role.zipcode.data('style') || ('undefined' !== typeof opts.css[2] ? opts.css[2] : ''))
                .appendTo(role.zipcode.length ? role.zipcode : container);

            self.wrap = {
                'county': container.find('select[name="' + countyName + '"]:first'),
                'district': container.find('select[name="' + districtName + '"]:first'),
                'zipcode': container.find('input[type=text][name="' + zipcodeName + '"]:first')
            };

            if (true === opts.zipcodeIntoDistrict) {
                self.wrap.zipcode.hide();
            }

            self.role = role;
            // Reset the elements
            self.reset();
            // Elements events binding
            self.bindings();
            // Geolocation
            if (true === opts.detect) {
                self.geoLocation();
            }
        }
    };
    /**
     * jQuery twzipcode instance
     * @param {Object} options Plugin settings
     * @public
     */
    $.fn.twzipcode = function (options) {
        var instance = {},
            result = [],
            args = arguments,
            id  = 'twzipcode';
        if ('string' === typeof options) {
            this.each(function () {
                instance = $.data(this, id);
                if (instance instanceof TWzipcode && 'function' === typeof instance[options]) {
                    result = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                }
            });
            return 'undefined' !== typeof result ? result : this;
        } else {
            return this.each(function () {
                if (!$.data(this, id)) {
                    $.data(this, id, new TWzipcode(this, options));
                }
            });
        }
    };

})(window.jQuery || {}, window, document);

var _BlackList = new Array("孔文吉","江啟臣","吳琪銘","李麗芬","林俊憲","施義芳","徐國勇","陳亭妃","陳賴素美","許淑華","黃偉哲","蔡易馀","鄭運鵬","賴士葆","蘇巧慧","尤美女","何欣純","呂玉玲","林昶佐","柯志恩","徐榛蔚","陳素月","馬文君","許智傑","黃國昌","蔡培慧","鄭麗君","賴瑞隆","蘇治芬","王定宇","余宛如","呂孫綾","邱志偉","林為洲","柯建銘","莊瑞雄","陳曼麗","高志鵬","許毓仁","黃國書","蔡適應","鄭寶清","鐘孔炤","蘇嘉全","王育敏","吳玉琴","李昆澤","邱泰源","林淑芬","段宜康","郭正亮","陳雪生","高金素梅","曾銘宗","楊曜","蔣乃辛","劉世芳","鐘佳濱","蘇震清","王金平","吳志揚","李俊俋","邱議瑩","林德福","洪宗熠","陳其邁","陳超明","葉宜津","楊鎭浯","蔣萬安","劉建國","簡東明","顧立雄","羅致政","蕭美琴","鄭天財","蔡其昌","黃昭順","張麗善","陳學聖","陳明文","徐志榮","姚文智","林岱樺","李鴻鈞","吳焜裕","江永昌","羅明才","盧秀燕","趙正宇","管碧玲","黃秀芳","張廖萬堅","陳瑩","陳怡潔","徐永明","林麗蟬","周陳秀霞","李應元","吳思瑤","王榮璋","顏寬恒","劉櫂豪","趙天麟","廖國棟","費鴻泰","張宏陸","陳歐珀","陳宜民","洪慈庸","林靜儀","周春米","李彥秀","吳秉叡","王惠美","高潞·以用·巴魕剌","孔文吉","尤美女","王育敏","王定宇","王金平","王惠美","王榮璋","江永昌","江啟臣","何欣純","餘宛如","吳玉琴","吳志揚","吳秉叡","吳思瑤","吳焜裕","吳琪銘","呂玉玲","呂孫綾","李昆澤","李俊俋","李彥秀","李應元","李鴻鈞","李麗芬","周春米","周陳秀霞","林岱樺","林俊憲","林昶佐","林為洲","林淑芬","林德福","林靜儀","林麗蟬","邱志偉","邱泰源","邱議瑩","姚文智","施義芳","柯志恩","柯建銘","段宜康","洪宗熠","洪慈庸","徐永明","徐志榮","徐國勇","徐榛蔚","馬文君","高志鵬","高金素梅","張宏陸","張廖萬堅","張麗善","莊瑞雄","許淑華","許智傑","許毓仁","郭正亮","陳其邁","陳宜民","陳怡潔","陳明文","陳亭妃","陳素月","陳曼麗","陳雪生","陳超明","陳歐珀","陳瑩 ","陳學聖","陳賴素美","曾銘宗","費鴻泰","黃秀芳","黃昭順","黃偉哲","黃國昌","黃國書","楊曜 ","楊鎮浯","萬國書","葉宜津","廖國棟","管碧玲","趙天麟","趙正宇","劉世芳","劉建國","劉櫂豪","蔡其昌","蔡易餘","蔡培慧","蔡適應","蔣乃辛","蔣萬安","鄭天財","鄭運鵬","鄭麗君","鄭寶清","盧秀燕","蕭美琴","賴士葆","賴瑞隆","鍾孔炤","鍾佳濱","簡東明","顏寬恆","羅明才","羅致政","蘇巧慧","蘇治芬","蘇嘉全","蘇震清","顧立雄");

function _checkBlackName(name){
    for(var s in _BlackList){
        if(name.indexOf(_BlackList[s])>=0){
            return true;
        }
    }
    return false;
}

//#EOF
