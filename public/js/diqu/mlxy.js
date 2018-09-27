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
    var a= [
        {
        id: "R80017344",
        name: "Kuala Lumpur",
        nameLocal: "",
        parentId: "R2939672",
        displayName: "Kuala Lumpur"
        },
        {
        id: "R80017345",
        name: "Setapak",
        nameLocal: "",
        parentId: "R2939672",
        displayName: "Setapak"
        }
        ];
    
    var b =  [
        {
        id: "R80199583",
        name: "Ayer Baloi",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Ayer Baloi"
        },
        {
        id: "R80199552",
        name: "Ayer Hitam",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Ayer Hitam"
        },
        {
        id: "R80199558",
        name: "Ayer Tawar 2",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Ayer Tawar 2"
        },
        {
        id: "R80199565",
        name: "Bandar Penawar",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Bandar Penawar"
        },
        {
        id: "R80199554",
        name: "Bandar Tenggara",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Bandar Tenggara"
        },
        {
        id: "R80199534",
        name: "Batu Anam",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Batu Anam"
        },
        {
        id: "R80199547",
        name: "Batu Pahat",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Batu Pahat"
        },
        {
        id: "R80199549",
        name: "Bekok",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Bekok"
        },
        {
        id: "R80199571",
        name: "Benut",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Benut"
        },
        {
        id: "R80199545",
        name: "Bukit Gambir",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Bukit Gambir"
        },
        {
        id: "R80199561",
        name: "Bukit Pasir",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Bukit Pasir"
        },
        {
        id: "R80199553",
        name: "Chaah",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Chaah"
        },
        {
        id: "R80199535",
        name: "Endau",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Endau"
        },
        {
        id: "R80199562",
        name: "Gelang Patah",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Gelang Patah"
        },
        {
        id: "R80199584",
        name: "Gerisek",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Gerisek"
        },
        {
        id: "R80199542",
        name: "Gugusan Taib Andak",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Gugusan Taib Andak"
        },
        {
        id: "R80199577",
        name: "Jementah",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Jementah"
        },
        {
        id: "R80199532",
        name: "Johor Bahru",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Johor Bahru"
        },
        {
        id: "R80199566",
        name: "Kahang",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Kahang"
        },
        {
        id: "R80199543",
        name: "Kluang",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Kluang"
        },
        {
        id: "R80199575",
        name: "Kota Tinggi",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Kota Tinggi"
        },
        {
        id: "R80199537",
        name: "Kukup",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Kukup"
        },
        {
        id: "R80199563",
        name: "Kulai",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Kulai"
        },
        {
        id: "R80199573",
        name: "Labis",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Labis"
        },
        {
        id: "R80199564",
        name: "Layang-Layang",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Layang-Layang"
        },
        {
        id: "R80199559",
        name: "Masai",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Masai"
        },
        {
        id: "R80199557",
        name: "Mersing",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Mersing"
        },
        {
        id: "R80199567",
        name: "Muar",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Muar"
        },
        {
        id: "R80199544",
        name: "Nusajaya",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Nusajaya"
        },
        {
        id: "R80199578",
        name: "Pagoh",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Pagoh"
        },
        {
        id: "R80199550",
        name: "Paloh",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Paloh"
        },
        {
        id: "R80199539",
        name: "Panchor",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Panchor"
        },
        {
        id: "R80199579",
        name: "Parit Jawa",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Parit Jawa"
        },
        {
        id: "R80199568",
        name: "Parit Raja",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Parit Raja"
        },
        {
        id: "R80199551",
        name: "Parit Sulong",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Parit Sulong"
        },
        {
        id: "R80199569",
        name: "Pasir Gudang",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Pasir Gudang"
        },
        {
        id: "R80199533",
        name: "Pekan Nenas",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Pekan Nenas"
        },
        {
        id: "R80199580",
        name: "Pengerang",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Pengerang"
        },
        {
        id: "R80199570",
        name: "Pontian",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Pontian"
        },
        {
        id: "R80199572",
        name: "Rengam",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Rengam"
        },
        {
        id: "R80199581",
        name: "Rengit",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Rengit"
        },
        {
        id: "R80199560",
        name: "Segamat",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Segamat"
        },
        {
        id: "R80199538",
        name: "Semerah",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Semerah"
        },
        {
        id: "R80199540",
        name: "Senai",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Senai"
        },
        {
        id: "R80199576",
        name: "Senggarang",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Senggarang"
        },
        {
        id: "R80199582",
        name: "Seri Gading",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Seri Gading"
        },
        {
        id: "R80199546",
        name: "Seri Medan",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Seri Medan"
        },
        {
        id: "R80199556",
        name: "Simpang Rengam",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Simpang Rengam"
        },
        {
        id: "R80199536",
        name: "Sungai Mati",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Sungai Mati"
        },
        {
        id: "R80199585",
        name: "Tangkak",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Tangkak"
        },
        {
        id: "R80199555",
        name: "Tioman",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Tioman"
        },
        {
        id: "R80199574",
        name: "Ulu Choh",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Ulu Choh"
        },
        {
        id: "R80199541",
        name: "Ulu Tiram",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Ulu Tiram"
        },
        {
        id: "R80199548",
        name: "Yong Peng",
        nameLocal: "",
        parentId: "R2939653",
        displayName: "Yong Peng"
        }
        ];
        var s=[
            {
            id: "R80017422",
            name: "Alor Setar",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Alor Setar"
            },
            {
            id: "R80017440",
            name: "Ayer Hitam",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Ayer Hitam"
            },
            {
            id: "R6166148",
            name: "Baling",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Baling"
            },
            {
            id: "R6166149",
            name: "Bandar Baharu",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Bandar Baharu"
            },
            {
            id: "R80017441",
            name: "Bandar Bahru",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Bandar Bahru"
            },
            {
            id: "R80017427",
            name: "Bedong",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Bedong"
            },
            {
            id: "R80017417",
            name: "Bukit Kayu Hitam",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Bukit Kayu Hitam"
            },
            {
            id: "R80017442",
            name: "Changloon",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Changloon"
            },
            {
            id: "R80017428",
            name: "Gurun",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Gurun"
            },
            {
            id: "R80017429",
            name: "Jeniang",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Jeniang"
            },
            {
            id: "R80017430",
            name: "Jitra",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Jitra"
            },
            {
            id: "R80017437",
            name: "Karangan",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Karangan"
            },
            {
            id: "R80017419",
            name: "Kepala Batas",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kepala Batas"
            },
            {
            id: "R80017438",
            name: "Kodiang",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kodiang"
            },
            {
            id: "R80017434",
            name: "Kota Kuala Muda",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kota Kuala Muda"
            },
            {
            id: "R80017418",
            name: "Kota Sarang Semut",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kota Sarang Semut"
            },
            {
            id: "R80017431",
            name: "Kuala Kedah",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kuala Kedah"
            },
            {
            id: "R80017420",
            name: "Kuala Ketil",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kuala Ketil"
            },
            {
            id: "R80017435",
            name: "Kuala Nerang",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kuala Nerang"
            },
            {
            id: "R80017444",
            name: "Kuala Pegang",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kuala Pegang"
            },
            {
            id: "R6166150",
            name: "Kulim",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kulim"
            },
            {
            id: "R80017421",
            name: "Kupang",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Kupang"
            },
            {
            id: "R80017432",
            name: "Langgar",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Langgar"
            },
            {
            id: "R4763405",
            name: "Langkawi",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Langkawi"
            },
            {
            id: "R80017436",
            name: "Lunas",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Lunas"
            },
            {
            id: "R80017443",
            name: "Merbok",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Merbok"
            },
            {
            id: "R80017423",
            name: "Padang Serai",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Padang Serai"
            },
            {
            id: "R80017424",
            name: "Pendang",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Pendang"
            },
            {
            id: "R80017433",
            name: "Pokok Sena",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Pokok Sena"
            },
            {
            id: "R80017439",
            name: "Serdang",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Serdang"
            },
            {
            id: "R6166151",
            name: "Sik",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Sik"
            },
            {
            id: "R80017425",
            name: "Simpang Empat",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Simpang Empat"
            },
            {
            id: "R80017426",
            name: "Sungai Petani",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Sungai Petani"
            },
            {
            id: "R5331713",
            name: "Yan",
            nameLocal: "",
            parentId: "R4444908",
            displayName: "Yan"
            }
            ];
        var c=[
            {
            id: "R80017447",
            name: "Ayer Lanas",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Ayer Lanas"
            },
            {
            id: "R4443634",
            name: "Bachok",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Bachok"
            },
            {
            id: "R80017452",
            name: "Cherang Ruku",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Cherang Ruku"
            },
            {
            id: "R80017453",
            name: "Dabong",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Dabong"
            },
            {
            id: "R4443635",
            name: "Gua Musang",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Gua Musang"
            },
            {
            id: "R4443636",
            name: "Jeli",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Jeli"
            },
            {
            id: "R80017457",
            name: "Kem Desa Pahlawan",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Kem Desa Pahlawan"
            },
            {
            id: "R80017458",
            name: "Ketereh",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Ketereh"
            },
            {
            id: "R6311590",
            name: "Kota Bharu",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Kota Bharu"
            },
            {
            id: "R80017459",
            name: "Kuala Balah",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Kuala Balah"
            },
            {
            id: "R4443637",
            name: "Kuala Krai",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Kuala Krai"
            },
            {
            id: "R4443638",
            name: "Machang",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Machang"
            },
            {
            id: "R80017454",
            name: "Melor",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Melor"
            },
            {
            id: "R80017446",
            name: "Pasir Mas",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Pasir Mas"
            },
            {
            id: "R4443639",
            name: "Pasir Puteh",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Pasir Puteh"
            },
            {
            id: "R80017448",
            name: "Pulai Chondong",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Pulai Chondong"
            },
            {
            id: "R80017449",
            name: "Rantau Panjang",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Rantau Panjang"
            },
            {
            id: "R80017455",
            name: "Selising",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Selising"
            },
            {
            id: "R80017450",
            name: "Tanah Merah",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Tanah Merah"
            },
            {
            id: "R80017451",
            name: "Temangan",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Temangan"
            },
            {
            id: "R80017445",
            name: "Tumpat",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Tumpat"
            },
            {
            id: "R80017456",
            name: "Wakaf Bharu",
            nameLocal: "",
            parentId: "R4443571",
            displayName: "Wakaf Bharu"
            }
            ];
        var d=[
            {
            id: "R4463193",
            name: "Alor Gajah",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Alor Gajah"
            },
            {
            id: "R80017196",
            name: "Asahan",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Asahan"
            },
            {
            id: "R80017188",
            name: "Ayer Keroh",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Ayer Keroh"
            },
            {
            id: "R80017189",
            name: "Bemban",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Bemban"
            },
            {
            id: "R80017197",
            name: "Durian Tunggal",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Durian Tunggal"
            },
            {
            id: "R4463195",
            name: "Jasin",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Jasin"
            },
            {
            id: "R80017192",
            name: "Kem Trendak",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Kem Trendak"
            },
            {
            id: "R80017193",
            name: "Kuala Sungai Baru",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Kuala Sungai Baru"
            },
            {
            id: "R80017194",
            name: "Lubok China",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Lubok China"
            },
            {
            id: "R80017190",
            name: "Masjid Tanah",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Masjid Tanah"
            },
            {
            id: "R80017198",
            name: "Melaka",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Melaka"
            },
            {
            id: "R80017199",
            name: "Merlimau",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Merlimau"
            },
            {
            id: "R80017191",
            name: "Selandar",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Selandar"
            },
            {
            id: "R80017201",
            name: "Sungai Rambai",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Sungai Rambai"
            },
            {
            id: "R80017200",
            name: "Sungai Udang",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Sungai Udang"
            },
            {
            id: "R80017195",
            name: "Tanjong Kling",
            nameLocal: "",
            parentId: "R2939673",
            displayName: "Tanjong Kling"
            }
            ];
        var e=[
            {
            id: "R80017480",
            name: "Bahau",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Bahau"
            },
            {
            id: "R80017474",
            name: "Bandar Baru Enstek",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Bandar Baru Enstek"
            },
            {
            id: "R80017466",
            name: "Bandar Baru Serting",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Bandar Baru Serting"
            },
            {
            id: "R80017467",
            name: "Bandar Seri Jempol",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Bandar Seri Jempol"
            },
            {
            id: "R80017475",
            name: "Batu Kikir",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Batu Kikir"
            },
            {
            id: "R80017485",
            name: "Gemas",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Gemas"
            },
            {
            id: "R80017481",
            name: "Gemencheh",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Gemencheh"
            },
            {
            id: "R80017482",
            name: "Johol",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Johol"
            },
            {
            id: "R80017483",
            name: "Kota",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Kota"
            },
            {
            id: "R80017468",
            name: "Kuala Klawang",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Kuala Klawang"
            },
            {
            id: "R80017460",
            name: "Kuala Pilah",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Kuala Pilah"
            },
            {
            id: "R80017469",
            name: "Labu",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Labu"
            },
            {
            id: "R80017470",
            name: "Linggi",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Linggi"
            },
            {
            id: "R80017461",
            name: "Mantin",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Mantin"
            },
            {
            id: "R80017471",
            name: "Nilai",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Nilai"
            },
            {
            id: "R80017462",
            name: "Port Dickson",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Port Dickson"
            },
            {
            id: "R80017476",
            name: "Pusat Bandar Palong",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Pusat Bandar Palong"
            },
            {
            id: "R80017463",
            name: "Rantau",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Rantau"
            },
            {
            id: "R80017477",
            name: "Rembau",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Rembau"
            },
            {
            id: "R80017464",
            name: "Rompin",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Rompin"
            },
            {
            id: "R80017472",
            name: "Seremban",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Seremban"
            },
            {
            id: "R80017465",
            name: "Simpang Durian",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Simpang Durian"
            },
            {
            id: "R80017478",
            name: "Simpang Pertang",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Simpang Pertang"
            },
            {
            id: "R80017473",
            name: "Si Rusa",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Si Rusa"
            },
            {
            id: "R80017484",
            name: "Tampin",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Tampin"
            },
            {
            id: "R80017479",
            name: "Tanjong Ipoh",
            nameLocal: "",
            parentId: "R2939674",
            displayName: "Tanjong Ipoh"
            }
            ];
        var f=[
            {
            id: "R80017237",
            name: "Balok",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Balok"
            },
            {
            id: "R80017216",
            name: "Bandar Pusat Jengka",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Bandar Pusat Jengka"
            },
            {
            id: "R80017224",
            name: "Bandar Tun Abdul Razak",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Bandar Tun Abdul Razak"
            },
            {
            id: "R80017217",
            name: "Benta",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Benta"
            },
            {
            id: "R80017203",
            name: "Bentong",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Bentong"
            },
            {
            id: "R80017204",
            name: "Brinchang",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Brinchang"
            },
            {
            id: "R80017212",
            name: "Bukit Fraser",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Bukit Fraser"
            },
            {
            id: "R80017213",
            name: "Bukit Goh",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Bukit Goh"
            },
            {
            id: "R80017218",
            name: "Chenor",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Chenor"
            },
            {
            id: "R80017205",
            name: "Chini",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Chini"
            },
            {
            id: "R80017232",
            name: "Damak",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Damak"
            },
            {
            id: "R80017233",
            name: "Dong",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Dong"
            },
            {
            id: "R80017238",
            name: "Gambang",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Gambang"
            },
            {
            id: "R80017215",
            name: "Genting Highlands",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Genting Highlands"
            },
            {
            id: "R80017225",
            name: "Jaya Gading",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Jaya Gading"
            },
            {
            id: "R80017207",
            name: "Jerantut",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Jerantut"
            },
            {
            id: "R80017226",
            name: "Karak",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Karak"
            },
            {
            id: "R80017234",
            name: "Kemayan",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Kemayan"
            },
            {
            id: "R80017227",
            name: "Kuala Krau",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Kuala Krau"
            },
            {
            id: "R80017219",
            name: "Kuala Lipis",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Kuala Lipis"
            },
            {
            id: "R80017214",
            name: "Kuala Rompin",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Kuala Rompin"
            },
            {
            id: "R80017220",
            name: "Kuantan",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Kuantan"
            },
            {
            id: "R80017221",
            name: "Lanchang",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Lanchang"
            },
            {
            id: "R80017210",
            name: "Lurah Bilut",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Lurah Bilut"
            },
            {
            id: "R80017228",
            name: "Maran",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Maran"
            },
            {
            id: "R80017208",
            name: "Mentakab",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Mentakab"
            },
            {
            id: "R80017229",
            name: "Muadzam Shah",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Muadzam Shah"
            },
            {
            id: "R80017222",
            name: "Padang Tengku",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Padang Tengku"
            },
            {
            id: "R80017239",
            name: "Pekan",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Pekan"
            },
            {
            id: "R80017235",
            name: "Raub",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Raub"
            },
            {
            id: "R80017230",
            name: "Ringlet",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Ringlet"
            },
            {
            id: "R80017209",
            name: "Sega",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Sega"
            },
            {
            id: "R80017223",
            name: "Sungai Koyan",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Sungai Koyan"
            },
            {
            id: "R80017236",
            name: "Sungai Lembing",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Sungai Lembing"
            },
            {
            id: "R80017206",
            name: "Sungai Ruan",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Sungai Ruan"
            },
            {
            id: "R80017202",
            name: "Tanah Rata",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Tanah Rata"
            },
            {
            id: "R80017231",
            name: "Temerloh",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Temerloh"
            },
            {
            id: "R80017211",
            name: "Triang",
            nameLocal: "",
            parentId: "R4444595",
            displayName: "Triang"
            }
            ];
        var g=[
            {
            id: "R80017398",
            name: "Ayer Itam",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Ayer Itam"
            },
            {
            id: "R80017415",
            name: "Balik Pulau",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Balik Pulau"
            },
            {
            id: "R80017416",
            name: "Batu Ferringhi",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Batu Ferringhi"
            },
            {
            id: "R80017402",
            name: "Batu Maung",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Batu Maung"
            },
            {
            id: "R80017410",
            name: "Bayan Lepas",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Bayan Lepas"
            },
            {
            id: "R80017411",
            name: "Bukit Mertajam",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Bukit Mertajam"
            },
            {
            id: "R80017412",
            name: "Butterworth",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Butterworth"
            },
            {
            id: "R80017408",
            name: "Gelugor",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Gelugor"
            },
            {
            id: "R80017413",
            name: "Jelutong",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Jelutong"
            },
            {
            id: "R80017400",
            name: "Kepala Batas",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Kepala Batas"
            },
            {
            id: "R80017399",
            name: "Kubang Semang",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Kubang Semang"
            },
            {
            id: "R80017395",
            name: "Nibong Tebal",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Nibong Tebal"
            },
            {
            id: "R80017396",
            name: "Penaga",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Penaga"
            },
            {
            id: "R80017409",
            name: "Penang Hill",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Penang Hill"
            },
            {
            id: "R80017397",
            name: "Perai",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Perai"
            },
            {
            id: "R80017403",
            name: "Permatang Pauh",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Permatang Pauh"
            },
            {
            id: "R80017401",
            name: "Pulau Pinang",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Pulau Pinang"
            },
            {
            id: "R80017404",
            name: "Simpang Ampat",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Simpang Ampat"
            },
            {
            id: "R80017405",
            name: "Sungai Jawi",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Sungai Jawi"
            },
            {
            id: "R80017406",
            name: "Tanjong Bungah",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Tanjong Bungah"
            },
            {
            id: "R80017407",
            name: "Tasek Gelugor",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Tasek Gelugor"
            },
            {
            id: "R80017414",
            name: "Usm Pulau Pinang",
            nameLocal: "",
            parentId: "R4445131",
            displayName: "Usm Pulau Pinang"
            }
            ];
        var h=[
            {
            id: "R80017276",
            name: "Ayer Tawar",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Ayer Tawar"
            },
            {
            id: "R80017299",
            name: "Bagan Datoh",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Bagan Datoh"
            },
            {
            id: "R80017265",
            name: "Bagan Serai",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Bagan Serai"
            },
            {
            id: "R80017291",
            name: "Bandar Seri Iskandar",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Bandar Seri Iskandar"
            },
            {
            id: "R80017256",
            name: "Batu Gajah",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Batu Gajah"
            },
            {
            id: "R80017266",
            name: "Batu Kurau",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Batu Kurau"
            },
            {
            id: "R80017253",
            name: "Behrang Stesen",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Behrang Stesen"
            },
            {
            id: "R80017284",
            name: "Bidor",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Bidor"
            },
            {
            id: "R80017277",
            name: "Bota",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Bota"
            },
            {
            id: "R80017294",
            name: "Bruas",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Bruas"
            },
            {
            id: "R80017278",
            name: "Changkat Jering",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Changkat Jering"
            },
            {
            id: "R80017308",
            name: "Changkat Keruing",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Changkat Keruing"
            },
            {
            id: "R80017309",
            name: "Chemor",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Chemor"
            },
            {
            id: "R80017285",
            name: "Chenderiang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Chenderiang"
            },
            {
            id: "R80017254",
            name: "Chenderong Balai",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Chenderong Balai"
            },
            {
            id: "R80017243",
            name: "Chikus",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Chikus"
            },
            {
            id: "R80017255",
            name: "Enggor",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Enggor"
            },
            {
            id: "R80017240",
            name: "Gerik",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Gerik"
            },
            {
            id: "R80017310",
            name: "Gopeng",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Gopeng"
            },
            {
            id: "R80017248",
            name: "Hutan Melintang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Hutan Melintang"
            },
            {
            id: "R80017249",
            name: "Intan",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Intan"
            },
            {
            id: "R80017295",
            name: "Ipoh",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Ipoh"
            },
            {
            id: "R80017267",
            name: "Jeram",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Jeram"
            },
            {
            id: "R80017251",
            name: "Kampar",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Kampar"
            },
            {
            id: "R80017250",
            name: "Kampung Gajah",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Kampung Gajah"
            },
            {
            id: "R80017301",
            name: "Kampung Kepayang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Kampung Kepayang"
            },
            {
            id: "R80017286",
            name: "Kamunting",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Kamunting"
            },
            {
            id: "R80017241",
            name: "Kuala Kangsar",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Kuala Kangsar"
            },
            {
            id: "R80017245",
            name: "Kuala Kurau",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Kuala Kurau"
            },
            {
            id: "R80017288",
            name: "Kuala Sepetang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Kuala Sepetang"
            },
            {
            id: "R80017297",
            name: "Lambor Kanan",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Lambor Kanan"
            },
            {
            id: "R80017257",
            name: "Langkap",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Langkap"
            },
            {
            id: "R80017271",
            name: "Lenggong",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Lenggong"
            },
            {
            id: "R80017289",
            name: "Lumut",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Lumut"
            },
            {
            id: "R80017260",
            name: "Malim Nawar",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Malim Nawar"
            },
            {
            id: "R80017246",
            name: "Mambang Di Awan",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Mambang Di Awan"
            },
            {
            id: "R80017261",
            name: "Manong",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Manong"
            },
            {
            id: "R80017244",
            name: "Matang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Matang"
            },
            {
            id: "R80017298",
            name: "Padang Rengas",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Padang Rengas"
            },
            {
            id: "R80017303",
            name: "Pangkor",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Pangkor"
            },
            {
            id: "R80017304",
            name: "Pantai Remis",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Pantai Remis"
            },
            {
            id: "R80017242",
            name: "Parit",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Parit"
            },
            {
            id: "R80017262",
            name: "Parit Buntar",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Parit Buntar"
            },
            {
            id: "R80017263",
            name: "Pengkalan Hulu",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Pengkalan Hulu"
            },
            {
            id: "R80017290",
            name: "Pusing",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Pusing"
            },
            {
            id: "R80017296",
            name: "Rantau Panjang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Rantau Panjang"
            },
            {
            id: "R80017264",
            name: "Sauk",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Sauk"
            },
            {
            id: "R80017305",
            name: "Selama",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Selama"
            },
            {
            id: "R80017272",
            name: "Selekoh",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Selekoh"
            },
            {
            id: "R80017292",
            name: "Seri Manjong",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Seri Manjong"
            },
            {
            id: "R80017247",
            name: "Simpang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Simpang"
            },
            {
            id: "R80017258",
            name: "Simpang Ampat Semanggol",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Simpang Ampat Semanggol"
            },
            {
            id: "R80017268",
            name: "Sitiawan",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Sitiawan"
            },
            {
            id: "R80017269",
            name: "Slim River",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Slim River"
            },
            {
            id: "R80017287",
            name: "Sungai Siput",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Sungai Siput"
            },
            {
            id: "R80017306",
            name: "Sungai Sumun",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Sungai Sumun"
            },
            {
            id: "R80017273",
            name: "Sungkai",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Sungkai"
            },
            {
            id: "R80017270",
            name: "Taiping",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Taiping"
            },
            {
            id: "R80017281",
            name: "Tanjong Malim",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tanjong Malim"
            },
            {
            id: "R80017252",
            name: "Tanjong Piandang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tanjong Piandang"
            },
            {
            id: "R80017274",
            name: "Tanjong Rambutan",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tanjong Rambutan"
            },
            {
            id: "R80017307",
            name: "Tanjong Tualang",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tanjong Tualang"
            },
            {
            id: "R80017282",
            name: "Tapah",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tapah"
            },
            {
            id: "R80017259",
            name: "Tapah Road",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tapah Road"
            },
            {
            id: "R80017311",
            name: "Teluk Intan",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Teluk Intan"
            },
            {
            id: "R80017275",
            name: "Temoh",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Temoh"
            },
            {
            id: "R80017279",
            name: "Tldm Lumut",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tldm Lumut"
            },
            {
            id: "R80017302",
            name: "Trolak",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Trolak"
            },
            {
            id: "R80017283",
            name: "Trong",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Trong"
            },
            {
            id: "R80017300",
            name: "Tronoh",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Tronoh"
            },
            {
            id: "R80017293",
            name: "Ulu Bernam",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Ulu Bernam"
            },
            {
            id: "R80017280",
            name: "Ulu Kinta",
            nameLocal: "",
            parentId: "R4445076",
            displayName: "Ulu Kinta"
            }
            ];
        var i=[
            {
            id: "R80017186",
            name: "Arau",
            nameLocal: "",
            parentId: "R4444918",
            displayName: "Arau"
            },
            {
            id: "R80017187",
            name: "Kaki Bukit",
            nameLocal: "",
            parentId: "R4444918",
            displayName: "Kaki Bukit"
            },
            {
            id: "R80017182",
            name: "Kangar",
            nameLocal: "",
            parentId: "R4444918",
            displayName: "Kangar"
            },
            {
            id: "R80017183",
            name: "Kuala Perlis",
            nameLocal: "",
            parentId: "R4444918",
            displayName: "Kuala Perlis"
            },
            {
            id: "R80017184",
            name: "Padang Besar",
            nameLocal: "",
            parentId: "R4444918",
            displayName: "Padang Besar"
            },
            {
            id: "R80017185",
            name: "Simpang Ampat",
            nameLocal: "",
            parentId: "R4444918",
            displayName: "Simpang Ampat"
            }
            ];
        var j=[
            {
            id: "R80017312",
            name: "Beaufort",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Beaufort"
            },
            {
            id: "R80017313",
            name: "Beluran",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Beluran"
            },
            {
            id: "R80017321",
            name: "Beverly",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Beverly"
            },
            {
            id: "R80017322",
            name: "Bongawan",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Bongawan"
            },
            {
            id: "R80017337",
            name: "Inanam",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Inanam"
            },
            {
            id: "R80017318",
            name: "Keningau",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Keningau"
            },
            {
            id: "R80017332",
            name: "Kota Belud",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Kota Belud"
            },
            {
            id: "R80017333",
            name: "Kota Kinabalu",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Kota Kinabalu"
            },
            {
            id: "R80017319",
            name: "Kota Kinabatangan",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Kota Kinabatangan"
            },
            {
            id: "R80017334",
            name: "Kota Marudu",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Kota Marudu"
            },
            {
            id: "R80017325",
            name: "Kuala Penyu",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Kuala Penyu"
            },
            {
            id: "R80017323",
            name: "Kudat",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Kudat"
            },
            {
            id: "R80017335",
            name: "Kunak",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Kunak"
            },
            {
            id: "R80017336",
            name: "Lahad Datu",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Lahad Datu"
            },
            {
            id: "R80017314",
            name: "Likas",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Likas"
            },
            {
            id: "R80017326",
            name: "Membakut",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Membakut"
            },
            {
            id: "R80017320",
            name: "Menumbok",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Menumbok"
            },
            {
            id: "R80017341",
            name: "Nabawan",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Nabawan"
            },
            {
            id: "R80017330",
            name: "Pamol",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Pamol"
            },
            {
            id: "R80017338",
            name: "Papar",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Papar"
            },
            {
            id: "R80017342",
            name: "Penampang",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Penampang"
            },
            {
            id: "R80017315",
            name: "Putatan",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Putatan"
            },
            {
            id: "R80017327",
            name: "Ranau",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Ranau"
            },
            {
            id: "R80017316",
            name: "Sandakan",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Sandakan"
            },
            {
            id: "R80017324",
            name: "Semporna",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Semporna"
            },
            {
            id: "R80017339",
            name: "Sipitang",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Sipitang"
            },
            {
            id: "R80017340",
            name: "Tambunan",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Tambunan"
            },
            {
            id: "R80017317",
            name: "Tamparuli",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Tamparuli"
            },
            {
            id: "R80017328",
            name: "Tanjung Aru",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Tanjung Aru"
            },
            {
            id: "R80017329",
            name: "Tawau",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Tawau"
            },
            {
            id: "R80017331",
            name: "Tenom",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Tenom"
            },
            {
            id: "R80017343",
            name: "Tuaran",
            nameLocal: "",
            parentId: "R3879783",
            displayName: "Tuaran"
            }
            ];
        var k=[
            {
            id: "R80017372",
            name: "Asajaya",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Asajaya"
            },
            {
            id: "R80017373",
            name: "Balingian",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Balingian"
            },
            {
            id: "R80017374",
            name: "Baram",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Baram"
            },
            {
            id: "R80017380",
            name: "Bau",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Bau"
            },
            {
            id: "R80017368",
            name: "Bekenu",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Bekenu"
            },
            {
            id: "R80017353",
            name: "Belaga",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Belaga"
            },
            {
            id: "R80017347",
            name: "Belawai",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Belawai"
            },
            {
            id: "R80017362",
            name: "Betong",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Betong"
            },
            {
            id: "R80017381",
            name: "Bintangor",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Bintangor"
            },
            {
            id: "R80017388",
            name: "Bintulu",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Bintulu"
            },
            {
            id: "R80017382",
            name: "Dalat",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Dalat"
            },
            {
            id: "R80017354",
            name: "Daro",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Daro"
            },
            {
            id: "R80017389",
            name: "Debak",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Debak"
            },
            {
            id: "R80017363",
            name: "Engkilili",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Engkilili"
            },
            {
            id: "R80017369",
            name: "Julau",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Julau"
            },
            {
            id: "R80017390",
            name: "Kabong",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Kabong"
            },
            {
            id: "R80017348",
            name: "Kanowit",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Kanowit"
            },
            {
            id: "R80017383",
            name: "Kapit",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Kapit"
            },
            {
            id: "R80017375",
            name: "Kota Samarahan",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Kota Samarahan"
            },
            {
            id: "R80017384",
            name: "Kuching",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Kuching"
            },
            {
            id: "R80017385",
            name: "Lawas",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Lawas"
            },
            {
            id: "R80017370",
            name: "Limbang",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Limbang"
            },
            {
            id: "R80017355",
            name: "Lingga",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Lingga"
            },
            {
            id: "R80017350",
            name: "Long Lama",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Long Lama"
            },
            {
            id: "R80017376",
            name: "Lubok Antu",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Lubok Antu"
            },
            {
            id: "R80017371",
            name: "Lundu",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Lundu"
            },
            {
            id: "R80017364",
            name: "Lutong",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Lutong"
            },
            {
            id: "R80017356",
            name: "Matu",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Matu"
            },
            {
            id: "R80017351",
            name: "Miri",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Miri"
            },
            {
            id: "R80017386",
            name: "Mukah",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Mukah"
            },
            {
            id: "R80017349",
            name: "Nanga Medamit",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Nanga Medamit"
            },
            {
            id: "R80017377",
            name: "Niah",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Niah"
            },
            {
            id: "R80017387",
            name: "Pusa",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Pusa"
            },
            {
            id: "R80017391",
            name: "Roban",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Roban"
            },
            {
            id: "R80017365",
            name: "Saratok",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Saratok"
            },
            {
            id: "R80017378",
            name: "Sarikei",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Sarikei"
            },
            {
            id: "R80017359",
            name: "Sebauh",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Sebauh"
            },
            {
            id: "R80017357",
            name: "Sebuyau",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Sebuyau"
            },
            {
            id: "R80017358",
            name: "Serian",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Serian"
            },
            {
            id: "R80017366",
            name: "Sibu",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Sibu"
            },
            {
            id: "R80017360",
            name: "Siburan",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Siburan"
            },
            {
            id: "R80017346",
            name: "Simunjan",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Simunjan"
            },
            {
            id: "R80017392",
            name: "Song",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Song"
            },
            {
            id: "R80017352",
            name: "Spaoh",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Spaoh"
            },
            {
            id: "R80017367",
            name: "Sri Aman",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Sri Aman"
            },
            {
            id: "R80017361",
            name: "Sundar",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Sundar"
            },
            {
            id: "R80017379",
            name: "Tatau",
            nameLocal: "",
            parentId: "R3879784",
            displayName: "Tatau"
            }
            ];
        var l=[
            {
            id: "R80017520",
            name: "Ampang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Ampang"
            },
            {
            id: "R80017521",
            name: "Bandar Baru Bangi",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Bandar Baru Bangi"
            },
            {
            id: "R80017526",
            name: "Bandar Puncak Alam",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Bandar Puncak Alam"
            },
            {
            id: "R80017522",
            name: "Bangi",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Bangi"
            },
            {
            id: "R80017523",
            name: "Banting",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Banting"
            },
            {
            id: "R80017505",
            name: "Batang Berjuntai",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Batang Berjuntai"
            },
            {
            id: "R80017493",
            name: "Batang Kali",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Batang Kali"
            },
            {
            id: "R80017506",
            name: "Batu Caves",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Batu Caves"
            },
            {
            id: "R80017527",
            name: "Beranang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Beranang"
            },
            {
            id: "R80017497",
            name: "Bukit Rotan",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Bukit Rotan"
            },
            {
            id: "R80017507",
            name: "Cheras",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Cheras"
            },
            {
            id: "R80017528",
            name: "Cyberjaya",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Cyberjaya"
            },
            {
            id: "R80017494",
            name: "Dengkil",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Dengkil"
            },
            {
            id: "R80017508",
            name: "Hulu Langat",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Hulu Langat"
            },
            {
            id: "R80017498",
            name: "Jenjarom",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Jenjarom"
            },
            {
            id: "R80017530",
            name: "Jeram",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Jeram"
            },
            {
            id: "R80017495",
            name: "Kajang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Kajang"
            },
            {
            id: "R80017499",
            name: "Kapar",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Kapar"
            },
            {
            id: "R80017517",
            name: "Kerling",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Kerling"
            },
            {
            id: "R80017518",
            name: "Klang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Klang"
            },
            {
            id: "R80017489",
            name: "Klia",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Klia"
            },
            {
            id: "R80017529",
            name: "Kuala Kubu Baru",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Kuala Kubu Baru"
            },
            {
            id: "R80017490",
            name: "Kuala Selangor",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Kuala Selangor"
            },
            {
            id: "R80017513",
            name: "Pelabuhan Klang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Pelabuhan Klang"
            },
            {
            id: "R80017531",
            name: "Petaling Jaya",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Petaling Jaya"
            },
            {
            id: "R80017491",
            name: "Puchong",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Puchong"
            },
            {
            id: "R80017514",
            name: "Pulau Carey",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Pulau Carey"
            },
            {
            id: "R80017501",
            name: "Pulau Indah",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Pulau Indah"
            },
            {
            id: "R80017502",
            name: "Pulau Ketam",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Pulau Ketam"
            },
            {
            id: "R80017515",
            name: "Rasa",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Rasa"
            },
            {
            id: "R80017516",
            name: "Rawang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Rawang"
            },
            {
            id: "R80017532",
            name: "Sabak Bernam",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Sabak Bernam"
            },
            {
            id: "R80017503",
            name: "Sekinchan",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Sekinchan"
            },
            {
            id: "R80017524",
            name: "Semenyih",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Semenyih"
            },
            {
            id: "R80017492",
            name: "Sepang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Sepang"
            },
            {
            id: "R80017486",
            name: "Serdang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Serdang"
            },
            {
            id: "R80017500",
            name: "Serendah",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Serendah"
            },
            {
            id: "R80017511",
            name: "Seri Kembangan",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Seri Kembangan"
            },
            {
            id: "R80017519",
            name: "Shah Alam",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Shah Alam"
            },
            {
            id: "R80017504",
            name: "Subang Airport",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Subang Airport"
            },
            {
            id: "R80017496",
            name: "Subang Jaya",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Subang Jaya"
            },
            {
            id: "R80017509",
            name: "Sungai Ayer Tawar",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Sungai Ayer Tawar"
            },
            {
            id: "R80017533",
            name: "Sungai Besar",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Sungai Besar"
            },
            {
            id: "R80017487",
            name: "Sungai Buloh",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Sungai Buloh"
            },
            {
            id: "R80017512",
            name: "Sungai Pelek",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Sungai Pelek"
            },
            {
            id: "R80017488",
            name: "Tanjong Karang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Tanjong Karang"
            },
            {
            id: "R80017525",
            name: "Tanjong Sepat",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Tanjong Sepat"
            },
            {
            id: "R80017510",
            name: "Telok Panglima Garang",
            nameLocal: "",
            parentId: "R2932285",
            displayName: "Telok Panglima Garang"
            }
            ];
        var m=[
            {
            id: "R80017534",
            name: "Ajil",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Ajil"
            },
            {
            id: "R80017541",
            name: "Al Muktatfi Billah Shah",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Al Muktatfi Billah Shah"
            },
            {
            id: "R80017546",
            name: "Ayer Puteh",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Ayer Puteh"
            },
            {
            id: "R80017542",
            name: "Bukit Besi",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Bukit Besi"
            },
            {
            id: "R80017547",
            name: "Bukit Payong",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Bukit Payong"
            },
            {
            id: "R80017535",
            name: "Ceneh",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Ceneh"
            },
            {
            id: "R80017552",
            name: "Chalok",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Chalok"
            },
            {
            id: "R80017536",
            name: "Cukai",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Cukai"
            },
            {
            id: "R80017553",
            name: "Dungun",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Dungun"
            },
            {
            id: "R80017548",
            name: "Jerteh",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Jerteh"
            },
            {
            id: "R80017549",
            name: "Kampung Raja",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Kampung Raja"
            },
            {
            id: "R80017554",
            name: "Kemasek",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Kemasek"
            },
            {
            id: "R80017537",
            name: "Kerteh",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Kerteh"
            },
            {
            id: "R80017538",
            name: "Ketengah Jaya",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Ketengah Jaya"
            },
            {
            id: "R80017543",
            name: "Kijal",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Kijal"
            },
            {
            id: "R80017539",
            name: "Kuala Berang",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Kuala Berang"
            },
            {
            id: "R80017540",
            name: "Kuala Besut",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Kuala Besut"
            },
            {
            id: "R80017544",
            name: "Kuala Terengganu",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Kuala Terengganu"
            },
            {
            id: "R80017545",
            name: "Marang",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Marang"
            },
            {
            id: "R80017550",
            name: "Paka",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Paka"
            },
            {
            id: "R80017555",
            name: "Permaisuri",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Permaisuri"
            },
            {
            id: "R80017551",
            name: "Sungai Tong",
            nameLocal: "",
            parentId: "R4444411",
            displayName: "Sungai Tong"
            }
            ];
        var n=[
            {
            id: "R80017393",
            name: "Labuan",
            nameLocal: "",
            parentId: "R4521286",
            displayName: "Labuan"
            }
            ];
        var o=[
            {
            id: "R80017394",
            name: "Putrajaya",
            nameLocal: "",
            parentId: "R4443881",
            displayName: "Putrajaya"
            }
            ];
        var fun=function(a){
            var b={};
        for(var i=0;i<a.length;i++){
            b[a[i]["name"]]=a[i]["id"].toString()
        }
        return b;
        }
        var obj={};
            obj["Wp Kuala Lumpur"]=fun(a);
            obj["Johor"]=fun(b);
            obj["Kedah"]=fun(s);
            obj["Kelantan"]=fun(c);
            obj["Melaka"]=fun(d);
            obj["Negeri Sembilan"]=fun(e);
            obj["Pahang"]=fun(f);
            obj["Penang"]=fun(g);
            obj["Perak"]=fun(h);
            obj["Perlis"]=fun(i);
            obj["Sabah"]=fun(j);
            obj["Sarawak"]=fun(k);
            obj["Selangor"]=fun(l);
            obj["Terengganu"]=fun(m);
            obj["Wp Labuan"]=fun(n);
            obj["Wp Putrajaya"]=fun(o);
    
    
    
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
