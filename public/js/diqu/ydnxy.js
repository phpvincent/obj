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
    var sheng=[{"id":"R6362934","name":"DKI\u0020Jakarta","nameLocal":"","parentId":"R304751","displayName":"DKI\u0020Jakarta"},{"id":"R1615621","name":"Bali","nameLocal":"","parentId":"R304751","displayName":"Bali"},{"id":"R3797243","name":"Bangka\u0020Belitung","nameLocal":"","parentId":"R304751","displayName":"Bangka\u0020Belitung"},{"id":"R2388356","name":"Banten","nameLocal":"","parentId":"R304751","displayName":"Banten"},{"id":"R2390837","name":"Bengkulu","nameLocal":"","parentId":"R304751","displayName":"Bengkulu"},{"id":"R5616105","name":"Di\u0020Yogyakarta","nameLocal":"","parentId":"R304751","displayName":"Di\u0020Yogyakarta"},{"id":"R2388665","name":"Gorontalo","nameLocal":"","parentId":"R304751","displayName":"Gorontalo"},{"id":"R2390838","name":"Jambi","nameLocal":"","parentId":"R304751","displayName":"Jambi"},{"id":"R2388361","name":"Jawa\u0020Barat","nameLocal":"","parentId":"R304751","displayName":"Jawa\u0020Barat"},{"id":"R2388357","name":"Jawa\u0020Tengah","nameLocal":"","parentId":"R304751","displayName":"Jawa\u0020Tengah"},{"id":"R3438227","name":"Jawa\u0020Timur","nameLocal":"","parentId":"R304751","displayName":"Jawa\u0020Timur"},{"id":"R2388616","name":"Kalimantan\u0020Barat","nameLocal":"","parentId":"R304751","displayName":"Kalimantan\u0020Barat"},{"id":"R2388615","name":"Kalimantan\u0020Selatan","nameLocal":"","parentId":"R304751","displayName":"Kalimantan\u0020Selatan"},{"id":"R2388613","name":"Kalimantan\u0020Tengah","nameLocal":"","parentId":"R304751","displayName":"Kalimantan\u0020Tengah"},{"id":"R5449459","name":"Kalimantan\u0020Timur","nameLocal":"","parentId":"R304751","displayName":"Kalimantan\u0020Timur"},{"id":"R5449460","name":"Kalimantan\u0020Utara","nameLocal":"","parentId":"R304751","displayName":"Kalimantan\u0020Utara"},{"id":"R3797244","name":"Kepulauan\u0020Riau","nameLocal":"","parentId":"R304751","displayName":"Kepulauan\u0020Riau"},{"id":"R2390839","name":"Lampung","nameLocal":"","parentId":"R304751","displayName":"Lampung"},{"id":"R2396795","name":"Maluku","nameLocal":"","parentId":"R304751","displayName":"Maluku"},{"id":"R2396796","name":"Maluku\u0020Utara","nameLocal":"","parentId":"R304751","displayName":"Maluku\u0020Utara"},{"id":"R2390836","name":"Nanggroe\u0020Aceh\u0020Darussalam\u0020\u0028Nad\u0029","nameLocal":"","parentId":"R304751","displayName":"Nanggroe\u0020Aceh\u0020Darussalam\u0020\u0028Nad\u0029"},{"id":"R1615622","name":"Nusa\u0020Tenggara\u0020Barat\u0020\u0028Ntb\u0029","nameLocal":"","parentId":"R304751","displayName":"Nusa\u0020Tenggara\u0020Barat\u0020\u0028Ntb\u0029"},{"id":"R2396778","name":"Nusa\u0020Tenggara\u0020Timur\u0020\u0028Ntt\u0029","nameLocal":"","parentId":"R304751","displayName":"Nusa\u0020Tenggara\u0020Timur\u0020\u0028Ntt\u0029"},{"id":"R4521144","name":"Papua","nameLocal":"","parentId":"R304751","displayName":"Papua"},{"id":"R4521145","name":"Papua\u0020Barat","nameLocal":"","parentId":"R304751","displayName":"Papua\u0020Barat"},{"id":"R2390840","name":"Riau","nameLocal":"","parentId":"R304751","displayName":"Riau"},{"id":"R2388669","name":"Sulawesi\u0020Barat","nameLocal":"","parentId":"R304751","displayName":"Sulawesi\u0020Barat"},{"id":"R2388667","name":"Sulawesi\u0020Selatan","nameLocal":"","parentId":"R304751","displayName":"Sulawesi\u0020Selatan"},{"id":"R2388664","name":"Sulawesi\u0020Tengah","nameLocal":"","parentId":"R304751","displayName":"Sulawesi\u0020Tengah"},{"id":"R2388668","name":"Sulawesi\u0020Tenggara","nameLocal":"","parentId":"R304751","displayName":"Sulawesi\u0020Tenggara"},{"id":"R2388666","name":"Sulawesi\u0020Utara","nameLocal":"","parentId":"R304751","displayName":"Sulawesi\u0020Utara"},{"id":"R2390841","name":"Sumatera\u0020Barat","nameLocal":"","parentId":"R304751","displayName":"Sumatera\u0020Barat"},{"id":"R2390842","name":"Sumatera\u0020Selatan","nameLocal":"","parentId":"R304751","displayName":"Sumatera\u0020Selatan"},{"id":"R2390843","name":"Sumatera\u0020Utara","nameLocal":"","parentId":"R304751","displayName":"Sumatera\u0020Utara"}]
        var shi =[
            {a:[{"id":"R5802442","name":"Kab\u002E\u0020Kepulauan\u0020Seribu","nameLocal":"","parentId":"R6362934","displayName":"Kab\u002E\u0020Kepulauan\u0020Seribu"},{"id":"R7626001","name":"Kota\u0020Jakarta\u0020Barat","nameLocal":"","parentId":"R6362934","displayName":"Kota\u0020Jakarta\u0020Barat"},{"id":"R7625977","name":"Kota\u0020Jakarta\u0020Pusat","nameLocal":"","parentId":"R6362934","displayName":"Kota\u0020Jakarta\u0020Pusat"},{"id":"R5802438","name":"Kota\u0020Jakarta\u0020Selatan","nameLocal":"","parentId":"R6362934","displayName":"Kota\u0020Jakarta\u0020Selatan"},{"id":"R5802441","name":"Kota\u0020Jakarta\u0020Timur","nameLocal":"","parentId":"R6362934","displayName":"Kota\u0020Jakarta\u0020Timur"},{"id":"R7626002","name":"Kota\u0020Jakarta\u0020Utara","nameLocal":"","parentId":"R6362934","displayName":"Kota\u0020Jakarta\u0020Utara"}]},
            {a:[{"id":"R7760984","name":"Kab\u002E\u0020Badung","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Badung"},{"id":"R80010523","name":"Kab\u002E\u0020Bangli","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Bangli"},{"id":"R80010528","name":"Kab\u002E\u0020Buleleng","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Buleleng"},{"id":"R80010527","name":"Kab\u002E\u0020Gianyar","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Gianyar"},{"id":"R80010526","name":"Kab\u002E\u0020Jembrana","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Jembrana"},{"id":"R80010522","name":"Kab\u002E\u0020Karangasem","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Karangasem"},{"id":"R80010525","name":"Kab\u002E\u0020Klungkung","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Klungkung"},{"id":"R80010524","name":"Kab\u002E\u0020Tabanan","nameLocal":"","parentId":"R1615621","displayName":"Kab\u002E\u0020Tabanan"},{"id":"R5563171","name":"Kota\u0020Denpasar","nameLocal":"","parentId":"R1615621","displayName":"Kota\u0020Denpasar"}]},
            {a:[{"id":"R7314113","name":"Kab\u002E\u0020Bangka","nameLocal":"","parentId":"R3797243","displayName":"Kab\u002E\u0020Bangka"},{"id":"R80010453","name":"Kab\u002E\u0020Bangka\u0020Barat","nameLocal":"","parentId":"R3797243","displayName":"Kab\u002E\u0020Bangka\u0020Barat"},{"id":"R80010452","name":"Kab\u002E\u0020Bangka\u0020Selatan","nameLocal":"","parentId":"R3797243","displayName":"Kab\u002E\u0020Bangka\u0020Selatan"},{"id":"R80010451","name":"Kab\u002E\u0020Bangka\u0020Tengah","nameLocal":"","parentId":"R3797243","displayName":"Kab\u002E\u0020Bangka\u0020Tengah"},{"id":"R7219502","name":"Kab\u002E\u0020Belitung","nameLocal":"","parentId":"R3797243","displayName":"Kab\u002E\u0020Belitung"},{"id":"R80010450","name":"Kab\u002E\u0020Belitung\u0020Timur","nameLocal":"","parentId":"R3797243","displayName":"Kab\u002E\u0020Belitung\u0020Timur"},{"id":"R80010449","name":"Kota\u0020Pangkal\u0020Pinang","nameLocal":"","parentId":"R3797243","displayName":"Kota\u0020Pangkal\u0020Pinang"}]},
            {a:[{"id":"R7641586","name":"Kab\u002E\u0020Lebak","nameLocal":"","parentId":"R2388356","displayName":"Kab\u002E\u0020Lebak"},{"id":"R7641585","name":"Kab\u002E\u0020Pandeglang","nameLocal":"","parentId":"R2388356","displayName":"Kab\u002E\u0020Pandeglang"},{"id":"R7641587","name":"Kab\u002E\u0020Serang","nameLocal":"","parentId":"R2388356","displayName":"Kab\u002E\u0020Serang"},{"id":"R7641583","name":"Kab\u002E\u0020Tangerang","nameLocal":"","parentId":"R2388356","displayName":"Kab\u002E\u0020Tangerang"},{"id":"R7641589","name":"Kota\u0020Cilegon","nameLocal":"","parentId":"R2388356","displayName":"Kota\u0020Cilegon"},{"id":"R7641588","name":"Kota\u0020Serang","nameLocal":"","parentId":"R2388356","displayName":"Kota\u0020Serang"},{"id":"R80199891","name":"Kota\u0020Tangerang","nameLocal":"","parentId":"R2388356","displayName":"Kota\u0020Tangerang"},{"id":"R7641582","name":"Kota\u0020Tangerang\u0020Selatan","nameLocal":"","parentId":"R2388356","displayName":"Kota\u0020Tangerang\u0020Selatan"}]},
            {a:[{"id":"R80010343","name":"Kab\u002E\u0020Bengkulu\u0020Selatan","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Bengkulu\u0020Selatan"},{"id":"R80010342","name":"Kab\u002E\u0020Bengkulu\u0020Tengah","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Bengkulu\u0020Tengah"},{"id":"R80010348","name":"Kab\u002E\u0020Bengkulu\u0020Utara","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Bengkulu\u0020Utara"},{"id":"R80010341","name":"Kab\u002E\u0020Kaur","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Kaur"},{"id":"R80010347","name":"Kab\u002E\u0020Kepahiang","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Kepahiang"},{"id":"R80010346","name":"Kab\u002E\u0020Lebong","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Lebong"},{"id":"R80010350","name":"Kab\u002E\u0020Muko\u0020Muko","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Muko\u0020Muko"},{"id":"R80010345","name":"Kab\u002E\u0020Rejang\u0020Lebong","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Rejang\u0020Lebong"},{"id":"R80010349","name":"Kab\u002E\u0020Seluma","nameLocal":"","parentId":"R2390837","displayName":"Kab\u002E\u0020Seluma"},{"id":"R80010344","name":"Kota\u0020Bengkulu","nameLocal":"","parentId":"R2390837","displayName":"Kota\u0020Bengkulu"}]},
            {a:[{"id":"R5615253","name":"Kab\u002E\u0020Bantul","nameLocal":"","parentId":"R5616105","displayName":"Kab\u002E\u0020Bantul"},{"id":"R80010365","name":"Kab\u002E\u0020Gunung\u0020Kidul","nameLocal":"","parentId":"R5616105","displayName":"Kab\u002E\u0020Gunung\u0020Kidul"},{"id":"R5615252","name":"Kab\u002E\u0020Kulon\u0020Progo","nameLocal":"","parentId":"R5616105","displayName":"Kab\u002E\u0020Kulon\u0020Progo"},{"id":"R5615254","name":"Kab\u002E\u0020Sleman","nameLocal":"","parentId":"R5616105","displayName":"Kab\u002E\u0020Sleman"},{"id":"R5615250","name":"Kota\u0020Yogyakarta","nameLocal":"","parentId":"R5616105","displayName":"Kota\u0020Yogyakarta"}]},
            {a:[{"id":"R80199814","name":"Kab\u002E\u0020Boalemo","nameLocal":"","parentId":"R2388665","displayName":"Kab\u002E\u0020Boalemo"},{"id":"R80199813","name":"Kab\u002E\u0020Bone\u0020Bolango","nameLocal":"","parentId":"R2388665","displayName":"Kab\u002E\u0020Bone\u0020Bolango"},{"id":"R80199812","name":"Kab\u002E\u0020Gorontalo","nameLocal":"","parentId":"R2388665","displayName":"Kab\u002E\u0020Gorontalo"},{"id":"R80199811","name":"Kab\u002E\u0020Gorontalo\u0020Utara","nameLocal":"","parentId":"R2388665","displayName":"Kab\u002E\u0020Gorontalo\u0020Utara"},{"id":"R80199810","name":"Kab\u002E\u0020Pohuwato","nameLocal":"","parentId":"R2388665","displayName":"Kab\u002E\u0020Pohuwato"},{"id":"R80199815","name":"Kota\u0020Gorontalo","nameLocal":"","parentId":"R2388665","displayName":"Kota\u0020Gorontalo"}]},
            {a:[{"id":"R80010503","name":"Kab\u002E\u0020Batang\u0020Hari","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Batang\u0020Hari"},{"id":"R80010507","name":"Kab\u002E\u0020Bungo","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Bungo"},{"id":"R80010502","name":"Kab\u002E\u0020Kerinci","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Kerinci"},{"id":"R80010501","name":"Kab\u002E\u0020Merangin","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Merangin"},{"id":"R80010506","name":"Kab\u002E\u0020Muaro\u0020Jambi","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Muaro\u0020Jambi"},{"id":"R80010500","name":"Kab\u002E\u0020Sarolangun","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Sarolangun"},{"id":"R80010505","name":"Kab\u002E\u0020Tanjung\u0020Jabung\u0020Barat","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Tanjung\u0020Jabung\u0020Barat"},{"id":"R80010504","name":"Kab\u002E\u0020Tanjung\u0020Jabung\u0020Timur","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Tanjung\u0020Jabung\u0020Timur"},{"id":"R80010499","name":"Kab\u002E\u0020Tebo","nameLocal":"","parentId":"R2390838","displayName":"Kab\u002E\u0020Tebo"},{"id":"R80010498","name":"Kota\u0020Jambi","nameLocal":"","parentId":"R2390838","displayName":"Kota\u0020Jambi"},{"id":"R80010497","name":"Kota\u0020Sungaipenuh","nameLocal":"","parentId":"R2390838","displayName":"Kota\u0020Sungaipenuh"}]},
            {a:[{"id":"R80010414","name":"Kab\u002E\u0020Bandung","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Bandung"},{"id":"R80010431","name":"Kab\u002E\u0020Bandung\u0020Barat","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Bandung\u0020Barat"},{"id":"R80010424","name":"Kab\u002E\u0020Bekasi","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Bekasi"},{"id":"R80010413","name":"Kab\u002E\u0020Bogor","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Bogor"},{"id":"R80010430","name":"Kab\u002E\u0020Ciamis","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Ciamis"},{"id":"R80010429","name":"Kab\u002E\u0020Cianjur","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Cianjur"},{"id":"R80010423","name":"Kab\u002E\u0020Cirebon","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Cirebon"},{"id":"R80010422","name":"Kab\u002E\u0020Garut","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Garut"},{"id":"R80010412","name":"Kab\u002E\u0020Indramayu","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Indramayu"},{"id":"R80010411","name":"Kab\u002E\u0020Karawang","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Karawang"},{"id":"R80010417","name":"Kab\u002E\u0020Kuningan","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Kuningan"},{"id":"R80010428","name":"Kab\u002E\u0020Majalengka","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Majalengka"},{"id":"R80010421","name":"Kab\u002E\u0020Purwakarta","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Purwakarta"},{"id":"R80010410","name":"Kab\u002E\u0020Subang","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Subang"},{"id":"R80010409","name":"Kab\u002E\u0020Sukabumi","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Sukabumi"},{"id":"R80010420","name":"Kab\u002E\u0020Sumedang","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Sumedang"},{"id":"R80010416","name":"Kab\u002E\u0020Tasikmalaya","nameLocal":"","parentId":"R2388361","displayName":"Kab\u002E\u0020Tasikmalaya"},{"id":"R80010415","name":"Kota\u0020Bandung","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Bandung"},{"id":"R80010419","name":"Kota\u0020Banjar","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Banjar"},{"id":"R80010427","name":"Kota\u0020Bekasi","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Bekasi"},{"id":"R80010426","name":"Kota\u0020Bogor","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Bogor"},{"id":"R80010425","name":"Kota\u0020Cimahi","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Cimahi"},{"id":"R80010418","name":"Kota\u0020Cirebon","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Cirebon"},{"id":"R80010434","name":"Kota\u0020Depok","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Depok"},{"id":"R80010433","name":"Kota\u0020Sukabumi","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Sukabumi"},{"id":"R80010432","name":"Kota\u0020Tasikmalaya","nameLocal":"","parentId":"R2388361","displayName":"Kota\u0020Tasikmalaya"}]},
            {a:[{"id":"R80010384","name":"Kab\u002E\u0020Banjarnegara","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Banjarnegara"},{"id":"R80010389","name":"Kab\u002E\u0020Banyumas","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Banyumas"},{"id":"R80010397","name":"Kab\u002E\u0020Batang","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Batang"},{"id":"R80010393","name":"Kab\u002E\u0020Blora","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Blora"},{"id":"R80010396","name":"Kab\u002E\u0020Boyolali","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Boyolali"},{"id":"R80010406","name":"Kab\u002E\u0020Brebes","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Brebes"},{"id":"R80010400","name":"Kab\u002E\u0020Cilacap","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Cilacap"},{"id":"R80010379","name":"Kab\u002E\u0020Demak","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Demak"},{"id":"R80010405","name":"Kab\u002E\u0020Grobogan","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Grobogan"},{"id":"R80010399","name":"Kab\u002E\u0020Jepara","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Jepara"},{"id":"R80010376","name":"Kab\u002E\u0020Karanganyar","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Karanganyar"},{"id":"R80010375","name":"Kab\u002E\u0020Kebumen","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Kebumen"},{"id":"R80010408","name":"Kab\u002E\u0020Kendal","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Kendal"},{"id":"R80010383","name":"Kab\u002E\u0020Klaten","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Klaten"},{"id":"R80010395","name":"Kab\u002E\u0020Kudus","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Kudus"},{"id":"R80010398","name":"Kab\u002E\u0020Magelang","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Magelang"},{"id":"R80010404","name":"Kab\u002E\u0020Pati","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Pati"},{"id":"R80010374","name":"Kab\u002E\u0020Pekalongan","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Pekalongan"},{"id":"R80010388","name":"Kab\u002E\u0020Pemalang","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Pemalang"},{"id":"R80010382","name":"Kab\u002E\u0020Purbalingga","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Purbalingga"},{"id":"R80010392","name":"Kab\u002E\u0020Purworejo","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Purworejo"},{"id":"R80010381","name":"Kab\u002E\u0020Rembang","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Rembang"},{"id":"R80010387","name":"Kab\u002E\u0020Semarang","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Semarang"},{"id":"R80010386","name":"Kab\u002E\u0020Sragen","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Sragen"},{"id":"R80010407","name":"Kab\u002E\u0020Sukoharjo","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Sukoharjo"},{"id":"R80010403","name":"Kab\u002E\u0020Tegal","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Tegal"},{"id":"R80010378","name":"Kab\u002E\u0020Temanggung","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Temanggung"},{"id":"R80010377","name":"Kab\u002E\u0020Wonogiri","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Wonogiri"},{"id":"R80010391","name":"Kab\u002E\u0020Wonosobo","nameLocal":"","parentId":"R2388357","displayName":"Kab\u002E\u0020Wonosobo"},{"id":"R80010394","name":"Kota\u0020Magelang","nameLocal":"","parentId":"R2388357","displayName":"Kota\u0020Magelang"},{"id":"R80010402","name":"Kota\u0020Pekalongan","nameLocal":"","parentId":"R2388357","displayName":"Kota\u0020Pekalongan"},{"id":"R80010401","name":"Kota\u0020Salatiga","nameLocal":"","parentId":"R2388357","displayName":"Kota\u0020Salatiga"},{"id":"R80010385","name":"Kota\u0020Semarang","nameLocal":"","parentId":"R2388357","displayName":"Kota\u0020Semarang"},{"id":"R80010380","name":"Kota\u0020Surakarta\u0020\u0028Solo\u0029","nameLocal":"","parentId":"R2388357","displayName":"Kota\u0020Surakarta\u0020\u0028Solo\u0029"},{"id":"R80010390","name":"Kota\u0020Tegal","nameLocal":"","parentId":"R2388357","displayName":"Kota\u0020Tegal"}]},
            {a:[{"id":"R80010294","name":"Kab\u002E\u0020Bangkalan","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Bangkalan"},{"id":"R80010299","name":"Kab\u002E\u0020Banyuwangi","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Banyuwangi"},{"id":"R80010323","name":"Kab\u002E\u0020Blitar","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Blitar"},{"id":"R80010316","name":"Kab\u002E\u0020Bojonegoro","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Bojonegoro"},{"id":"R80010308","name":"Kab\u002E\u0020Bondowoso","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Bondowoso"},{"id":"R80010298","name":"Kab\u002E\u0020Gresik","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Gresik"},{"id":"R80010327","name":"Kab\u002E\u0020Jember","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Jember"},{"id":"R3535957","name":"Kab\u002E\u0020Jombang","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Jombang"},{"id":"R80010311","name":"Kab\u002E\u0020Kediri","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Kediri"},{"id":"R80010326","name":"Kab\u002E\u0020Lamongan","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Lamongan"},{"id":"R80010315","name":"Kab\u002E\u0020Lumajang","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Lumajang"},{"id":"R80010314","name":"Kab\u002E\u0020Madiun","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Madiun"},{"id":"R80010310","name":"Kab\u002E\u0020Magetan","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Magetan"},{"id":"R80010307","name":"Kab\u002E\u0020Malang","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Malang"},{"id":"R3458228","name":"Kab\u002E\u0020Mojokerto","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Mojokerto"},{"id":"R80010306","name":"Kab\u002E\u0020Nganjuk","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Nganjuk"},{"id":"R80010325","name":"Kab\u002E\u0020Ngawi","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Ngawi"},{"id":"R80010305","name":"Kab\u002E\u0020Pacitan","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Pacitan"},{"id":"R80010304","name":"Kab\u002E\u0020Pamekasan","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Pamekasan"},{"id":"R80010319","name":"Kab\u002E\u0020Pasuruan","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Pasuruan"},{"id":"R80010297","name":"Kab\u002E\u0020Ponorogo","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Ponorogo"},{"id":"R80010324","name":"Kab\u002E\u0020Probolinggo","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Probolinggo"},{"id":"R80010322","name":"Kab\u002E\u0020Sampang","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Sampang"},{"id":"R80010303","name":"Kab\u002E\u0020Sidoarjo","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Sidoarjo"},{"id":"R80010296","name":"Kab\u002E\u0020Situbondo","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Situbondo"},{"id":"R80010295","name":"Kab\u002E\u0020Sumenep","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Sumenep"},{"id":"R80010309","name":"Kab\u002E\u0020Trenggalek","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Trenggalek"},{"id":"R80010321","name":"Kab\u002E\u0020Tuban","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Tuban"},{"id":"R80010302","name":"Kab\u002E\u0020Tulungagung","nameLocal":"","parentId":"R3438227","displayName":"Kab\u002E\u0020Tulungagung"},{"id":"R80010313","name":"Kota\u0020Batu","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Batu"},{"id":"R80010301","name":"Kota\u0020Blitar","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Blitar"},{"id":"R80010318","name":"Kota\u0020Kediri","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Kediri"},{"id":"R80010317","name":"Kota\u0020Madiun","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Madiun"},{"id":"R80010300","name":"Kota\u0020Malang","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Malang"},{"id":"R3444546","name":"Kota\u0020Mojokerto","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Mojokerto"},{"id":"R80010320","name":"Kota\u0020Pasuruan","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Pasuruan"},{"id":"R80010328","name":"Kota\u0020Probolinggo","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Probolinggo"},{"id":"R80010312","name":"Kota\u0020Surabaya","nameLocal":"","parentId":"R3438227","displayName":"Kota\u0020Surabaya"}]},
            {a:[{"id":"R80010438","name":"Kab\u002E\u0020Bengkayang","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Bengkayang"},{"id":"R80010436","name":"Kab\u002E\u0020Kapuas\u0020Hulu","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Kapuas\u0020Hulu"},{"id":"R80010445","name":"Kab\u002E\u0020Kayong\u0020Utara","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Kayong\u0020Utara"},{"id":"R80010444","name":"Kab\u002E\u0020Ketapang","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Ketapang"},{"id":"R80010443","name":"Kab\u002E\u0020Kubu\u0020Raya","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Kubu\u0020Raya"},{"id":"R80010448","name":"Kab\u002E\u0020Landak","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Landak"},{"id":"R80010442","name":"Kab\u002E\u0020Melawi","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Melawi"},{"id":"R80010441","name":"Kab\u002E\u0020Pontianak","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Pontianak"},{"id":"R80010447","name":"Kab\u002E\u0020Sambas","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Sambas"},{"id":"R80010440","name":"Kab\u002E\u0020Sanggau","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Sanggau"},{"id":"R80010446","name":"Kab\u002E\u0020Sekadau","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Sekadau"},{"id":"R80010435","name":"Kab\u002E\u0020Sintang","nameLocal":"","parentId":"R2388616","displayName":"Kab\u002E\u0020Sintang"},{"id":"R80010439","name":"Kota\u0020Pontianak","nameLocal":"","parentId":"R2388616","displayName":"Kota\u0020Pontianak"},{"id":"R80010437","name":"Kota\u0020Singkawang","nameLocal":"","parentId":"R2388616","displayName":"Kota\u0020Singkawang"}]},
            {a:[{"id":"R80010488","name":"Kab\u002E\u0020Balangan","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Balangan"},{"id":"R80010485","name":"Kab\u002E\u0020Banjar","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Banjar"},{"id":"R80010484","name":"Kab\u002E\u0020Barito\u0020Kuala","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Barito\u0020Kuala"},{"id":"R80010495","name":"Kab\u002E\u0020Hulu\u0020Sungai\u0020Selatan","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Hulu\u0020Sungai\u0020Selatan"},{"id":"R80010494","name":"Kab\u002E\u0020Hulu\u0020Sungai\u0020Tengah","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Hulu\u0020Sungai\u0020Tengah"},{"id":"R80010493","name":"Kab\u002E\u0020Hulu\u0020Sungai\u0020Utara","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Hulu\u0020Sungai\u0020Utara"},{"id":"R80010496","name":"Kab\u002E\u0020Kotabaru","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Kotabaru"},{"id":"R80010492","name":"Kab\u002E\u0020Tabalong","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Tabalong"},{"id":"R80010491","name":"Kab\u002E\u0020Tanah\u0020Bumbu","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Tanah\u0020Bumbu"},{"id":"R80010490","name":"Kab\u002E\u0020Tanah\u0020Laut","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Tanah\u0020Laut"},{"id":"R80010489","name":"Kab\u002E\u0020Tapin","nameLocal":"","parentId":"R2388615","displayName":"Kab\u002E\u0020Tapin"},{"id":"R80010487","name":"Kota\u0020Banjarbaru","nameLocal":"","parentId":"R2388615","displayName":"Kota\u0020Banjarbaru"},{"id":"R80010486","name":"Kota\u0020Banjarmasin","nameLocal":"","parentId":"R2388615","displayName":"Kota\u0020Banjarmasin"}]},
            {a:[{"id":"R80010520","name":"Kab\u002E\u0020Barito\u0020Selatan","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Barito\u0020Selatan"},{"id":"R80010519","name":"Kab\u002E\u0020Barito\u0020Timur","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Barito\u0020Timur"},{"id":"R80010518","name":"Kab\u002E\u0020Barito\u0020Utara","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Barito\u0020Utara"},{"id":"R80010517","name":"Kab\u002E\u0020Gunung\u0020Mas","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Gunung\u0020Mas"},{"id":"R80010516","name":"Kab\u002E\u0020Kapuas","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Kapuas"},{"id":"R80010512","name":"Kab\u002E\u0020Katingan","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Katingan"},{"id":"R80010508","name":"Kab\u002E\u0020Kotawaringin\u0020Barat","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Kotawaringin\u0020Barat"},{"id":"R80010514","name":"Kab\u002E\u0020Kotawaringin\u0020Timur","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Kotawaringin\u0020Timur"},{"id":"R80010515","name":"Kab\u002E\u0020Lamandau","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Lamandau"},{"id":"R80010511","name":"Kab\u002E\u0020Murung\u0020Raya","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Murung\u0020Raya"},{"id":"R80010510","name":"Kab\u002E\u0020Pulang\u0020Pisau","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Pulang\u0020Pisau"},{"id":"R80010513","name":"Kab\u002E\u0020Seruyan","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Seruyan"},{"id":"R80010521","name":"Kab\u002E\u0020Sukamara","nameLocal":"","parentId":"R2388613","displayName":"Kab\u002E\u0020Sukamara"},{"id":"R80010509","name":"Kota\u0020Palangka\u0020Raya","nameLocal":"","parentId":"R2388613","displayName":"Kota\u0020Palangka\u0020Raya"}]},
            {a:[{"id":"R80010202","name":"Kab\u002E\u0020Berau","nameLocal":"","parentId":"R5449459","displayName":"Kab\u002E\u0020Berau"},{"id":"R80010196","name":"Kab\u002E\u0020Kutai\u0020Barat","nameLocal":"","parentId":"R5449459","displayName":"Kab\u002E\u0020Kutai\u0020Barat"},{"id":"R80010195","name":"Kab\u002E\u0020Kutai\u0020Kartanegara","nameLocal":"","parentId":"R5449459","displayName":"Kab\u002E\u0020Kutai\u0020Kartanegara"},{"id":"R80010194","name":"Kab\u002E\u0020Kutai\u0020Timur","nameLocal":"","parentId":"R5449459","displayName":"Kab\u002E\u0020Kutai\u0020Timur"},{"id":"R80010201","name":"Kab\u002E\u0020Paser","nameLocal":"","parentId":"R5449459","displayName":"Kab\u002E\u0020Paser"},{"id":"R80010200","name":"Kab\u002E\u0020Penajam\u0020Paser\u0020Utara","nameLocal":"","parentId":"R5449459","displayName":"Kab\u002E\u0020Penajam\u0020Paser\u0020Utara"},{"id":"R80010199","name":"Kota\u0020Balikpapan","nameLocal":"","parentId":"R5449459","displayName":"Kota\u0020Balikpapan"},{"id":"R80010198","name":"Kota\u0020Bontang","nameLocal":"","parentId":"R5449459","displayName":"Kota\u0020Bontang"},{"id":"R80010197","name":"Kota\u0020Samarinda","nameLocal":"","parentId":"R5449459","displayName":"Kota\u0020Samarinda"}]},
            {a:[{"id":"R80010293","name":"Kab\u002E\u0020Bulungan\u0020\u0028Bulongan\u0029","nameLocal":"","parentId":"R5449460","displayName":"Kab\u002E\u0020Bulungan\u0020\u0028Bulongan\u0029"},{"id":"R80010292","name":"Kab\u002E\u0020Malinau","nameLocal":"","parentId":"R5449460","displayName":"Kab\u002E\u0020Malinau"},{"id":"R80010291","name":"Kab\u002E\u0020Nunukan","nameLocal":"","parentId":"R5449460","displayName":"Kab\u002E\u0020Nunukan"},{"id":"R80010290","name":"Kab\u002E\u0020Tana\u0020Tidung","nameLocal":"","parentId":"R5449460","displayName":"Kab\u002E\u0020Tana\u0020Tidung"},{"id":"R2680548","name":"Kota\u0020Tarakan","nameLocal":"","parentId":"R5449460","displayName":"Kota\u0020Tarakan"}]},
            {a:[{"id":"R80010459","name":"Kab\u002E\u0020Bintan","nameLocal":"","parentId":"R3797244","displayName":"Kab\u002E\u0020Bintan"},{"id":"R80010458","name":"Kab\u002E\u0020Karimun","nameLocal":"","parentId":"R3797244","displayName":"Kab\u002E\u0020Karimun"},{"id":"R80010457","name":"Kab\u002E\u0020Kepulauan\u0020Anambas","nameLocal":"","parentId":"R3797244","displayName":"Kab\u002E\u0020Kepulauan\u0020Anambas"},{"id":"R80010456","name":"Kab\u002E\u0020Lingga","nameLocal":"","parentId":"R3797244","displayName":"Kab\u002E\u0020Lingga"},{"id":"R80010455","name":"Kab\u002E\u0020Natuna","nameLocal":"","parentId":"R3797244","displayName":"Kab\u002E\u0020Natuna"},{"id":"R80010454","name":"Kota\u0020Batam","nameLocal":"","parentId":"R3797244","displayName":"Kota\u0020Batam"},{"id":"R80010460","name":"Kota\u0020Tanjung\u0020Pinang","nameLocal":"","parentId":"R3797244","displayName":"Kota\u0020Tanjung\u0020Pinang"}]},
            {a:[{"id":"R80010361","name":"Kab\u002E\u0020Lampung\u0020Barat","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Lampung\u0020Barat"},{"id":"R80010360","name":"Kab\u002E\u0020Lampung\u0020Selatan","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Lampung\u0020Selatan"},{"id":"R80010359","name":"Kab\u002E\u0020Lampung\u0020Tengah","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Lampung\u0020Tengah"},{"id":"R80010352","name":"Kab\u002E\u0020Lampung\u0020Timur","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Lampung\u0020Timur"},{"id":"R80010351","name":"Kab\u002E\u0020Lampung\u0020Utara","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Lampung\u0020Utara"},{"id":"R80010364","name":"Kab\u002E\u0020Mesuji","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Mesuji"},{"id":"R80010358","name":"Kab\u002E\u0020Pesawaran","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Pesawaran"},{"id":"R80010357","name":"Kab\u002E\u0020Pringsewu","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Pringsewu"},{"id":"R80010363","name":"Kab\u002E\u0020Tanggamus","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Tanggamus"},{"id":"R80010356","name":"Kab\u002E\u0020Tulang\u0020Bawang","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Tulang\u0020Bawang"},{"id":"R80010362","name":"Kab\u002E\u0020Tulang\u0020Bawang\u0020Barat","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Tulang\u0020Bawang\u0020Barat"},{"id":"R80010355","name":"Kab\u002E\u0020Way\u0020Kanan","nameLocal":"","parentId":"R2390839","displayName":"Kab\u002E\u0020Way\u0020Kanan"},{"id":"R80010354","name":"Kota\u0020Bandar\u0020Lampung","nameLocal":"","parentId":"R2390839","displayName":"Kota\u0020Bandar\u0020Lampung"},{"id":"R80010353","name":"Kota\u0020Metro","nameLocal":"","parentId":"R2390839","displayName":"Kota\u0020Metro"}]},
            {a:[{"id":"R80010204","name":"Kab\u002E\u0020Buru","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Buru"},{"id":"R80010207","name":"Kab\u002E\u0020Buru\u0020Selatan","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Buru\u0020Selatan"},{"id":"R80010203","name":"Kab\u002E\u0020Kepulauan\u0020Aru","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Kepulauan\u0020Aru"},{"id":"R80010213","name":"Kab\u002E\u0020Maluku\u0020Barat\u0020Daya","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Maluku\u0020Barat\u0020Daya"},{"id":"R80010212","name":"Kab\u002E\u0020Maluku\u0020Tengah","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Maluku\u0020Tengah"},{"id":"R80010211","name":"Kab\u002E\u0020Maluku\u0020Tenggara","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Maluku\u0020Tenggara"},{"id":"R80010210","name":"Kab\u002E\u0020Maluku\u0020Tenggara\u0020Barat","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Maluku\u0020Tenggara\u0020Barat"},{"id":"R80010209","name":"Kab\u002E\u0020Seram\u0020Bagian\u0020Barat","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Seram\u0020Bagian\u0020Barat"},{"id":"R80010208","name":"Kab\u002E\u0020Seram\u0020Bagian\u0020Timur","nameLocal":"","parentId":"R2396795","displayName":"Kab\u002E\u0020Seram\u0020Bagian\u0020Timur"},{"id":"R80010206","name":"Kota\u0020Ambon","nameLocal":"","parentId":"R2396795","displayName":"Kota\u0020Ambon"},{"id":"R80010205","name":"Kota\u0020Tual","nameLocal":"","parentId":"R2396795","displayName":"Kota\u0020Tual"}]},
            {a:[{"id":"R80010372","name":"Kab\u002E\u0020Halmahera\u0020Barat","nameLocal":"","parentId":"R2396796","displayName":"Kab\u002E\u0020Halmahera\u0020Barat"},{"id":"R80010371","name":"Kab\u002E\u0020Halmahera\u0020Selatan","nameLocal":"","parentId":"R2396796","displayName":"Kab\u002E\u0020Halmahera\u0020Selatan"},{"id":"R80010367","name":"Kab\u002E\u0020Halmahera\u0020Tengah","nameLocal":"","parentId":"R2396796","displayName":"Kab\u002E\u0020Halmahera\u0020Tengah"},{"id":"R80010370","name":"Kab\u002E\u0020Halmahera\u0020Timur","nameLocal":"","parentId":"R2396796","displayName":"Kab\u002E\u0020Halmahera\u0020Timur"},{"id":"R80010366","name":"Kab\u002E\u0020Halmahera\u0020Utara","nameLocal":"","parentId":"R2396796","displayName":"Kab\u002E\u0020Halmahera\u0020Utara"},{"id":"R4286275","name":"Kab\u002E\u0020Kepulauan\u0020Sula","nameLocal":"","parentId":"R2396796","displayName":"Kab\u002E\u0020Kepulauan\u0020Sula"},{"id":"R80010369","name":"Kab\u002E\u0020Pulau\u0020Morotai","nameLocal":"","parentId":"R2396796","displayName":"Kab\u002E\u0020Pulau\u0020Morotai"},{"id":"R80010368","name":"Kota\u0020Ternate","nameLocal":"","parentId":"R2396796","displayName":"Kota\u0020Ternate"},{"id":"R80010373","name":"Kota\u0020Tidore\u0020Kepulauan","nameLocal":"","parentId":"R2396796","displayName":"Kota\u0020Tidore\u0020Kepulauan"}]},
            {a:[{"id":"R80010151","name":"Kab\u002E\u0020Aceh\u0020Barat","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Barat"},{"id":"R80010156","name":"Kab\u002E\u0020Aceh\u0020Barat\u0020Daya","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Barat\u0020Daya"},{"id":"R80010155","name":"Kab\u002E\u0020Aceh\u0020Besar","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Besar"},{"id":"R80010147","name":"Kab\u002E\u0020Aceh\u0020Jaya","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Jaya"},{"id":"R80010154","name":"Kab\u002E\u0020Aceh\u0020Selatan","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Selatan"},{"id":"R80010153","name":"Kab\u002E\u0020Aceh\u0020Singkil","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Singkil"},{"id":"R80010146","name":"Kab\u002E\u0020Aceh\u0020Tamiang","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Tamiang"},{"id":"R80010150","name":"Kab\u002E\u0020Aceh\u0020Tengah","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Tengah"},{"id":"R80010145","name":"Kab\u002E\u0020Aceh\u0020Tenggara","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Tenggara"},{"id":"R80010144","name":"Kab\u002E\u0020Aceh\u0020Timur","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Timur"},{"id":"R4559902","name":"Kab\u002E\u0020Aceh\u0020Utara","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Aceh\u0020Utara"},{"id":"R80010149","name":"Kab\u002E\u0020Bener\u0020Meriah","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Bener\u0020Meriah"},{"id":"R5474497","name":"Kab\u002E\u0020Bireuen","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Bireuen"},{"id":"R80010143","name":"Kab\u002E\u0020Gayo\u0020Lues","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Gayo\u0020Lues"},{"id":"R80010142","name":"Kab\u002E\u0020Nagan\u0020Raya","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Nagan\u0020Raya"},{"id":"R80010148","name":"Kab\u002E\u0020Pidie","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Pidie"},{"id":"R80010139","name":"Kab\u002E\u0020Pidie\u0020Jaya","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Pidie\u0020Jaya"},{"id":"R80010138","name":"Kab\u002E\u0020Simeulue","nameLocal":"","parentId":"R2390836","displayName":"Kab\u002E\u0020Simeulue"},{"id":"R5978331","name":"Kota\u0020Banda\u0020Aceh","nameLocal":"","parentId":"R2390836","displayName":"Kota\u0020Banda\u0020Aceh"},{"id":"R80010152","name":"Kota\u0020Langsa","nameLocal":"","parentId":"R2390836","displayName":"Kota\u0020Langsa"},{"id":"R4126220","name":"Kota\u0020Lhokseumawe","nameLocal":"","parentId":"R2390836","displayName":"Kota\u0020Lhokseumawe"},{"id":"R80010141","name":"Kota\u0020Sabang","nameLocal":"","parentId":"R2390836","displayName":"Kota\u0020Sabang"},{"id":"R80010140","name":"Kota\u0020Subulussalam","nameLocal":"","parentId":"R2390836","displayName":"Kota\u0020Subulussalam"}]},
            {a:[{"id":"R80010282","name":"Kab\u002E\u0020Bima","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Bima"},{"id":"R80010281","name":"Kab\u002E\u0020Dompu","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Dompu"},{"id":"R80010286","name":"Kab\u002E\u0020Lombok\u0020Barat","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Lombok\u0020Barat"},{"id":"R80010289","name":"Kab\u002E\u0020Lombok\u0020Tengah","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Lombok\u0020Tengah"},{"id":"R80010285","name":"Kab\u002E\u0020Lombok\u0020Timur","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Lombok\u0020Timur"},{"id":"R80010284","name":"Kab\u002E\u0020Lombok\u0020Utara","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Lombok\u0020Utara"},{"id":"R7219492","name":"Kab\u002E\u0020Sumbawa","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Sumbawa"},{"id":"R80010288","name":"Kab\u002E\u0020Sumbawa\u0020Barat","nameLocal":"","parentId":"R1615622","displayName":"Kab\u002E\u0020Sumbawa\u0020Barat"},{"id":"R80010283","name":"Kota\u0020Bima","nameLocal":"","parentId":"R1615622","displayName":"Kota\u0020Bima"},{"id":"R80010287","name":"Kota\u0020Mataram","nameLocal":"","parentId":"R1615622","displayName":"Kota\u0020Mataram"}]},
            {a:[{"id":"R5138903","name":"Kab\u002E\u0020Alor","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Alor"},{"id":"R80010238","name":"Kab\u002E\u0020Belu","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Belu"},{"id":"R80010231","name":"Kab\u002E\u0020Ende","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Ende"},{"id":"R80010223","name":"Kab\u002E\u0020Flores\u0020Timur","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Flores\u0020Timur"},{"id":"R80010226","name":"Kab\u002E\u0020Kupang","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Kupang"},{"id":"R80010222","name":"Kab\u002E\u0020Lembata","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Lembata"},{"id":"R80010221","name":"Kab\u002E\u0020Manggarai","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Manggarai"},{"id":"R80010225","name":"Kab\u002E\u0020Manggarai\u0020Barat","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Manggarai\u0020Barat"},{"id":"R80010228","name":"Kab\u002E\u0020Manggarai\u0020Timur","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Manggarai\u0020Timur"},{"id":"R80010230","name":"Kab\u002E\u0020Nagekeo","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Nagekeo"},{"id":"R80010237","name":"Kab\u002E\u0020Ngada","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Ngada"},{"id":"R80010227","name":"Kab\u002E\u0020Rote\u0020Ndao","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Rote\u0020Ndao"},{"id":"R80010224","name":"Kab\u002E\u0020Sabu\u0020Raijua","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Sabu\u0020Raijua"},{"id":"R80010236","name":"Kab\u002E\u0020Sikka","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Sikka"},{"id":"R80010235","name":"Kab\u002E\u0020Sumba\u0020Barat","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Sumba\u0020Barat"},{"id":"R80010220","name":"Kab\u002E\u0020Sumba\u0020Barat\u0020Daya","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Sumba\u0020Barat\u0020Daya"},{"id":"R80010234","name":"Kab\u002E\u0020Sumba\u0020Tengah","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Sumba\u0020Tengah"},{"id":"R80010233","name":"Kab\u002E\u0020Sumba\u0020Timur","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Sumba\u0020Timur"},{"id":"R80010219","name":"Kab\u002E\u0020Timor\u0020Tengah\u0020Selatan","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Timor\u0020Tengah\u0020Selatan"},{"id":"R80010232","name":"Kab\u002E\u0020Timor\u0020Tengah\u0020Utara","nameLocal":"","parentId":"R2396778","displayName":"Kab\u002E\u0020Timor\u0020Tengah\u0020Utara"},{"id":"R80010229","name":"Kota\u0020Kupang","nameLocal":"","parentId":"R2396778","displayName":"Kota\u0020Kupang"}]},
            {a:[{"id":"R7754473","name":"Kab\u002E\u0020Asmat","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Asmat"},{"id":"R7754459","name":"Kab\u002E\u0020Biak\u0020Numfor","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Biak\u0020Numfor"},{"id":"R7754474","name":"Kab\u002E\u0020Boven\u0020Digoel","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Boven\u0020Digoel"},{"id":"R7754462","name":"Kab\u002E\u0020Deiyai\u0020\u0028Deliyai\u0029","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Deiyai\u0020\u0028Deliyai\u0029"},{"id":"R7754463","name":"Kab\u002E\u0020Dogiyai","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Dogiyai"},{"id":"R7754465","name":"Kab\u002E\u0020Intan\u0020Jaya","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Intan\u0020Jaya"},{"id":"R7754451","name":"Kab\u002E\u0020Jayapura","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Jayapura"},{"id":"R7754470","name":"Kab\u002E\u0020Jayawijaya","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Jayawijaya"},{"id":"R7754450","name":"Kab\u002E\u0020Keerom","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Keerom"},{"id":"R7754458","name":"Kab\u002E\u0020Kepulauan\u0020Yapen\u0020\u0028Yapen\u0020Waropen\u0029","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Kepulauan\u0020Yapen\u0020\u0028Yapen\u0020Waropen\u0029"},{"id":"R7754469","name":"Kab\u002E\u0020Lanny\u0020Jaya","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Lanny\u0020Jaya"},{"id":"R7754447","name":"Kab\u002E\u0020Mamberamo\u0020Raya","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Mamberamo\u0020Raya"},{"id":"R7754456","name":"Kab\u002E\u0020Mamberamo\u0020Tengah","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Mamberamo\u0020Tengah"},{"id":"R7754472","name":"Kab\u002E\u0020Mappi","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Mappi"},{"id":"R7754475","name":"Kab\u002E\u0020Merauke","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Merauke"},{"id":"R7754461","name":"Kab\u002E\u0020Mimika","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Mimika"},{"id":"R7754457","name":"Kab\u002E\u0020Nabire","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Nabire"},{"id":"R7754471","name":"Kab\u002E\u0020Nduga","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Nduga"},{"id":"R7754464","name":"Kab\u002E\u0020Paniai","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Paniai"},{"id":"R7754452","name":"Kab\u002E\u0020Pegunungan\u0020Bintang","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Pegunungan\u0020Bintang"},{"id":"R7754466","name":"Kab\u002E\u0020Puncak","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Puncak"},{"id":"R7754468","name":"Kab\u002E\u0020Puncak\u0020Jaya","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Puncak\u0020Jaya"},{"id":"R7754453","name":"Kab\u002E\u0020Sarmi","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Sarmi"},{"id":"R7754460","name":"Kab\u002E\u0020Supiori","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Supiori"},{"id":"R7754467","name":"Kab\u002E\u0020Tolikara","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Tolikara"},{"id":"R7754448","name":"Kab\u002E\u0020Waropen","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Waropen"},{"id":"R7754454","name":"Kab\u002E\u0020Yahukimo","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Yahukimo"},{"id":"R7754455","name":"Kab\u002E\u0020Yalimo","nameLocal":"","parentId":"R4521144","displayName":"Kab\u002E\u0020Yalimo"},{"id":"R80199885","name":"Kota\u0020Jayapura","nameLocal":"","parentId":"R4521144","displayName":"Kota\u0020Jayapura"}]},
            {a:[{"id":"R80010121","name":"Kab\u002E\u0020Fakfak","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Fakfak"},{"id":"R80010120","name":"Kab\u002E\u0020Kaimana","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Kaimana"},{"id":"R80010114","name":"Kab\u002E\u0020Manokwari","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Manokwari"},{"id":"R80010113","name":"Kab\u002E\u0020Maybrat","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Maybrat"},{"id":"R80010119","name":"Kab\u002E\u0020Raja\u0020Ampat","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Raja\u0020Ampat"},{"id":"R80010118","name":"Kab\u002E\u0020Sorong","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Sorong"},{"id":"R80010112","name":"Kab\u002E\u0020Sorong\u0020Selatan","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Sorong\u0020Selatan"},{"id":"R80010116","name":"Kab\u002E\u0020Tambrauw","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Tambrauw"},{"id":"R80010117","name":"Kab\u002E\u0020Teluk\u0020Bintuni","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Teluk\u0020Bintuni"},{"id":"R80010122","name":"Kab\u002E\u0020Teluk\u0020Wondama","nameLocal":"","parentId":"R4521145","displayName":"Kab\u002E\u0020Teluk\u0020Wondama"},{"id":"R80010115","name":"Kota\u0020Sorong","nameLocal":"","parentId":"R4521145","displayName":"Kota\u0020Sorong"}]},
            {a:[{"id":"R80010161","name":"Kab\u002E\u0020Bengkalis","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Bengkalis"},{"id":"R80010167","name":"Kab\u002E\u0020Indragiri\u0020Hilir","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Indragiri\u0020Hilir"},{"id":"R80010160","name":"Kab\u002E\u0020Indragiri\u0020Hulu","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Indragiri\u0020Hulu"},{"id":"R80010166","name":"Kab\u002E\u0020Kampar","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Kampar"},{"id":"R80010159","name":"Kab\u002E\u0020Kepulauan\u0020Meranti","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Kepulauan\u0020Meranti"},{"id":"R80010165","name":"Kab\u002E\u0020Kuantan\u0020Singingi","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Kuantan\u0020Singingi"},{"id":"R80010162","name":"Kab\u002E\u0020Meranti","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Meranti"},{"id":"R80010158","name":"Kab\u002E\u0020Pelalawan","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Pelalawan"},{"id":"R80010164","name":"Kab\u002E\u0020Rokan\u0020Hilir","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Rokan\u0020Hilir"},{"id":"R80010157","name":"Kab\u002E\u0020Rokan\u0020Hulu","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Rokan\u0020Hulu"},{"id":"R80010163","name":"Kab\u002E\u0020Siak","nameLocal":"","parentId":"R2390840","displayName":"Kab\u002E\u0020Siak"},{"id":"R80010169","name":"Kota\u0020Dumai","nameLocal":"","parentId":"R2390840","displayName":"Kota\u0020Dumai"},{"id":"R80010168","name":"Kota\u0020Pekanbaru","nameLocal":"","parentId":"R2390840","displayName":"Kota\u0020Pekanbaru"}]},
            {a:[{"id":"R80010218","name":"Kab\u002E\u0020Majene","nameLocal":"","parentId":"R2388669","displayName":"Kab\u002E\u0020Majene"},{"id":"R80010217","name":"Kab\u002E\u0020Mamasa","nameLocal":"","parentId":"R2388669","displayName":"Kab\u002E\u0020Mamasa"},{"id":"R80010216","name":"Kab\u002E\u0020Mamuju","nameLocal":"","parentId":"R2388669","displayName":"Kab\u002E\u0020Mamuju"},{"id":"R80010215","name":"Kab\u002E\u0020Mamuju\u0020Utara","nameLocal":"","parentId":"R2388669","displayName":"Kab\u002E\u0020Mamuju\u0020Utara"},{"id":"R80010214","name":"Kab\u002E\u0020Polewali\u0020Mandar","nameLocal":"","parentId":"R2388669","displayName":"Kab\u002E\u0020Polewali\u0020Mandar"}]},
            {a:[{"id":"R80010478","name":"Kab\u002E\u0020Bantaeng","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Bantaeng"},{"id":"R80010482","name":"Kab\u002E\u0020Barru","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Barru"},{"id":"R80010468","name":"Kab\u002E\u0020Bone","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Bone"},{"id":"R80010477","name":"Kab\u002E\u0020Bulukumba","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Bulukumba"},{"id":"R80010463","name":"Kab\u002E\u0020Enrekang","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Enrekang"},{"id":"R80010462","name":"Kab\u002E\u0020Gowa","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Gowa"},{"id":"R80010476","name":"Kab\u002E\u0020Jeneponto","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Jeneponto"},{"id":"R80010481","name":"Kab\u002E\u0020Luwu","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Luwu"},{"id":"R80010461","name":"Kab\u002E\u0020Luwu\u0020Timur","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Luwu\u0020Timur"},{"id":"R80010467","name":"Kab\u002E\u0020Luwu\u0020Utara","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Luwu\u0020Utara"},{"id":"R80010475","name":"Kab\u002E\u0020Maros","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Maros"},{"id":"R80010474","name":"Kab\u002E\u0020Pangkajene\u0020Kepulauan","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Pangkajene\u0020Kepulauan"},{"id":"R80010473","name":"Kab\u002E\u0020Pinrang","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Pinrang"},{"id":"R5130963","name":"Kab\u002E\u0020Selayar\u0020\u0028Kepulauan\u0020Selayar\u0029","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Selayar\u0020\u0028Kepulauan\u0020Selayar\u0029"},{"id":"R80010472","name":"Kab\u002E\u0020Sidenreng\u0020Rappang\u002Frapang","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Sidenreng\u0020Rappang\u002Frapang"},{"id":"R80010466","name":"Kab\u002E\u0020Sinjai","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Sinjai"},{"id":"R80010483","name":"Kab\u002E\u0020Soppeng","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Soppeng"},{"id":"R80010479","name":"Kab\u002E\u0020Takalar","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Takalar"},{"id":"R80010465","name":"Kab\u002E\u0020Tana\u0020Toraja","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Tana\u0020Toraja"},{"id":"R80010464","name":"Kab\u002E\u0020Toraja\u0020Utara","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Toraja\u0020Utara"},{"id":"R80010471","name":"Kab\u002E\u0020Wajo","nameLocal":"","parentId":"R2388667","displayName":"Kab\u002E\u0020Wajo"},{"id":"R80010470","name":"Kota\u0020Makassar","nameLocal":"","parentId":"R2388667","displayName":"Kota\u0020Makassar"},{"id":"R80010480","name":"Kota\u0020Palopo","nameLocal":"","parentId":"R2388667","displayName":"Kota\u0020Palopo"},{"id":"R80010469","name":"Kota\u0020Parepare","nameLocal":"","parentId":"R2388667","displayName":"Kota\u0020Parepare"}]},
            {a:[{"id":"R4269707","name":"Kab\u002E\u0020Banggai","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Banggai"},{"id":"R4269807","name":"Kab\u002E\u0020Banggai\u0020Kepulauan","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Banggai\u0020Kepulauan"},{"id":"R4273893","name":"Kab\u002E\u0020Buol","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Buol"},{"id":"R80010193","name":"Kab\u002E\u0020Donggala","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Donggala"},{"id":"R80010192","name":"Kab\u002E\u0020Morowali","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Morowali"},{"id":"R80010190","name":"Kab\u002E\u0020Parigi\u0020Moutong","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Parigi\u0020Moutong"},{"id":"R80010189","name":"Kab\u002E\u0020Poso","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Poso"},{"id":"R80010188","name":"Kab\u002E\u0020Sigi","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Sigi"},{"id":"R80010191","name":"Kab\u002E\u0020Tojo\u0020Una\u002DUna","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Tojo\u0020Una\u002DUna"},{"id":"R80010187","name":"Kab\u002E\u0020Toli\u002DToli","nameLocal":"","parentId":"R2388664","displayName":"Kab\u002E\u0020Toli\u002DToli"},{"id":"R4277707","name":"Kota\u0020Palu","nameLocal":"","parentId":"R2388664","displayName":"Kota\u0020Palu"}]},
            {a:[{"id":"R80010276","name":"Kab\u002E\u0020Bombana","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Bombana"},{"id":"R7220476","name":"Kab\u002E\u0020Buton","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Buton"},{"id":"R80199886","name":"Kab\u002E\u0020Buton\u0020\u0026\u0020Buton\u0020Utara","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Buton\u0020\u0026\u0020Buton\u0020Utara"},{"id":"R80010280","name":"Kab\u002E\u0020Buton\u0020Utara","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Buton\u0020Utara"},{"id":"R80010275","name":"Kab\u002E\u0020Kolaka","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Kolaka"},{"id":"R80010279","name":"Kab\u002E\u0020Kolaka\u0020Utara","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Kolaka\u0020Utara"},{"id":"R80010274","name":"Kab\u002E\u0020Konawe","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Konawe"},{"id":"R80010273","name":"Kab\u002E\u0020Konawe\u0020Selatan","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Konawe\u0020Selatan"},{"id":"R80010278","name":"Kab\u002E\u0020Konawe\u0020Utara","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Konawe\u0020Utara"},{"id":"R7220480","name":"Kab\u002E\u0020Muna","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Muna"},{"id":"R80010272","name":"Kab\u002E\u0020Wakatobi","nameLocal":"","parentId":"R2388668","displayName":"Kab\u002E\u0020Wakatobi"},{"id":"R80010277","name":"Kota\u0020Bau\u002DBau","nameLocal":"","parentId":"R2388668","displayName":"Kota\u0020Bau\u002DBau"},{"id":"R1795267","name":"Kota\u0020Kendari","nameLocal":"","parentId":"R2388668","displayName":"Kota\u0020Kendari"}]},
            {a:[{"id":"R80010131","name":"Kab\u002E\u0020Bolaang\u0020Mongondow","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Bolaang\u0020Mongondow"},{"id":"R80010136","name":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020\u0028Bolmong\u0029","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020\u0028Bolmong\u0029"},{"id":"R80010133","name":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020Selatan","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020Selatan"},{"id":"R80010132","name":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020Timur","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020Timur"},{"id":"R80010126","name":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020Utara","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Bolaang\u0020Mongondow\u0020Utara"},{"id":"R80010128","name":"Kab\u002E\u0020Kepulauan\u0020Sangihe","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Kepulauan\u0020Sangihe"},{"id":"R80010125","name":"Kab\u002E\u0020Kepulauan\u0020Siau\u0020Tagulandang\u0020Biaro\u0020\u0028Sitaro\u0029","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Kepulauan\u0020Siau\u0020Tagulandang\u0020Biaro\u0020\u0028Sitaro\u0029"},{"id":"R4283367","name":"Kab\u002E\u0020Kepulauan\u0020Talaud","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Kepulauan\u0020Talaud"},{"id":"R80010135","name":"Kab\u002E\u0020Minahasa","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Minahasa"},{"id":"R80010127","name":"Kab\u002E\u0020Minahasa\u0020Selatan","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Minahasa\u0020Selatan"},{"id":"R80010124","name":"Kab\u002E\u0020Minahasa\u0020Tenggara","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Minahasa\u0020Tenggara"},{"id":"R80010123","name":"Kab\u002E\u0020Minahasa\u0020Utara","nameLocal":"","parentId":"R2388666","displayName":"Kab\u002E\u0020Minahasa\u0020Utara"},{"id":"R80010137","name":"Kota\u0020Bitung","nameLocal":"","parentId":"R2388666","displayName":"Kota\u0020Bitung"},{"id":"R80010130","name":"Kota\u0020Kotamobagu","nameLocal":"","parentId":"R2388666","displayName":"Kota\u0020Kotamobagu"},{"id":"R80010134","name":"Kota\u0020Manado","nameLocal":"","parentId":"R2388666","displayName":"Kota\u0020Manado"},{"id":"R80010129","name":"Kota\u0020Tomohon","nameLocal":"","parentId":"R2388666","displayName":"Kota\u0020Tomohon"}]},
            {a:[{"id":"R2648098","name":"Kab\u002E\u0020Agam","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Agam"},{"id":"R80010172","name":"Kab\u002E\u0020Dharmasraya","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Dharmasraya"},{"id":"R80010178","name":"Kab\u002E\u0020Kepulauan\u0020Mentawai","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Kepulauan\u0020Mentawai"},{"id":"R80010177","name":"Kab\u002E\u0020Lima\u0020Puluh\u0020Koto\u002Fkota","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Lima\u0020Puluh\u0020Koto\u002Fkota"},{"id":"R80010175","name":"Kab\u002E\u0020Padang\u0020Pariaman","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Padang\u0020Pariaman"},{"id":"R2648099","name":"Kab\u002E\u0020Pasaman","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Pasaman"},{"id":"R2648100","name":"Kab\u002E\u0020Pasaman\u0020Barat","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Pasaman\u0020Barat"},{"id":"R80010183","name":"Kab\u002E\u0020Pesisir\u0020Selatan","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Pesisir\u0020Selatan"},{"id":"R80010171","name":"Kab\u002E\u0020Sijunjung\u0020\u0028Sawah\u0020Lunto\u0020Sijunjung\u0029","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Sijunjung\u0020\u0028Sawah\u0020Lunto\u0020Sijunjung\u0029"},{"id":"R80010182","name":"Kab\u002E\u0020Solok","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Solok"},{"id":"R80010181","name":"Kab\u002E\u0020Solok\u0020Selatan","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Solok\u0020Selatan"},{"id":"R80010180","name":"Kab\u002E\u0020Tanah\u0020Datar","nameLocal":"","parentId":"R2390841","displayName":"Kab\u002E\u0020Tanah\u0020Datar"},{"id":"R80010174","name":"Kota\u0020Bukittinggi","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Bukittinggi"},{"id":"R80010186","name":"Kota\u0020Padang","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Padang"},{"id":"R80010179","name":"Kota\u0020Padang\u0020Panjang","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Padang\u0020Panjang"},{"id":"R80010185","name":"Kota\u0020Pariaman","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Pariaman"},{"id":"R80010184","name":"Kota\u0020Payakumbuh","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Payakumbuh"},{"id":"R80010170","name":"Kota\u0020Sawahlunto","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Sawahlunto"},{"id":"R80010176","name":"Kota\u0020Sawah\u0020Lunto","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Sawah\u0020Lunto"},{"id":"R80010173","name":"Kota\u0020Solok","nameLocal":"","parentId":"R2390841","displayName":"Kota\u0020Solok"}]},
            {a:[{"id":"R80010337","name":"Kab\u002E\u0020Banyuasin","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Banyuasin"},{"id":"R80010336","name":"Kab\u002E\u0020Empat\u0020Lawang","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Empat\u0020Lawang"},{"id":"R80010335","name":"Kab\u002E\u0020Lahat","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Lahat"},{"id":"R80010334","name":"Kab\u002E\u0020Muara\u0020Enim","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Muara\u0020Enim"},{"id":"R80010339","name":"Kab\u002E\u0020Musi\u0020Banyuasin","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Musi\u0020Banyuasin"},{"id":"R80010329","name":"Kab\u002E\u0020Musi\u0020Rawas","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Musi\u0020Rawas"},{"id":"R80010338","name":"Kab\u002E\u0020Ogan\u0020Ilir","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Ogan\u0020Ilir"},{"id":"R80010332","name":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ilir","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ilir"},{"id":"R2657934","name":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ulu","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ulu"},{"id":"R2657935","name":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ulu\u0020Selatan","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ulu\u0020Selatan"},{"id":"R2657933","name":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ulu\u0020Timur","nameLocal":"","parentId":"R2390842","displayName":"Kab\u002E\u0020Ogan\u0020Komering\u0020Ulu\u0020Timur"},{"id":"R80010331","name":"Kota\u0020Lubuk\u0020Linggau","nameLocal":"","parentId":"R2390842","displayName":"Kota\u0020Lubuk\u0020Linggau"},{"id":"R80010333","name":"Kota\u0020Pagar\u0020Alam","nameLocal":"","parentId":"R2390842","displayName":"Kota\u0020Pagar\u0020Alam"},{"id":"R80010330","name":"Kota\u0020Palembang","nameLocal":"","parentId":"R2390842","displayName":"Kota\u0020Palembang"},{"id":"R80010340","name":"Kota\u0020Prabumulih","nameLocal":"","parentId":"R2390842","displayName":"Kota\u0020Prabumulih"}]},
            {a:[{"id":"R80010259","name":"Kab\u002E\u0020Asahan","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Asahan"},{"id":"R80010253","name":"Kab\u002E\u0020Batu\u0020Bara","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Batu\u0020Bara"},{"id":"R80010252","name":"Kab\u002E\u0020Dairi","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Dairi"},{"id":"R80010265","name":"Kab\u002E\u0020Deli\u0020Serdang","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Deli\u0020Serdang"},{"id":"R80010240","name":"Kab\u002E\u0020Humbang\u0020Hasundutan","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Humbang\u0020Hasundutan"},{"id":"R80010264","name":"Kab\u002E\u0020Karo","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Karo"},{"id":"R80010263","name":"Kab\u002E\u0020Labuhan\u0020Batu","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Labuhan\u0020Batu"},{"id":"R80010251","name":"Kab\u002E\u0020Labuhan\u0020Batu\u0020Selatan","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Labuhan\u0020Batu\u0020Selatan"},{"id":"R80010247","name":"Kab\u002E\u0020Labuhan\u0020Batu\u0020Utara","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Labuhan\u0020Batu\u0020Utara"},{"id":"R80010246","name":"Kab\u002E\u0020Langkat","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Langkat"},{"id":"R80010262","name":"Kab\u002E\u0020Mandailing\u0020Natal","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Mandailing\u0020Natal"},{"id":"R80010261","name":"Kab\u002E\u0020Nias","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Nias"},{"id":"R80010242","name":"Kab\u002E\u0020Nias\u0020Barat","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Nias\u0020Barat"},{"id":"R80010250","name":"Kab\u002E\u0020Nias\u0020Selatan","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Nias\u0020Selatan"},{"id":"R80010241","name":"Kab\u002E\u0020Nias\u0020Utara","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Nias\u0020Utara"},{"id":"R80010244","name":"Kab\u002E\u0020Padang\u0020Lawas","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Padang\u0020Lawas"},{"id":"R80010268","name":"Kab\u002E\u0020Padang\u0020Lawas\u0020Utara","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Padang\u0020Lawas\u0020Utara"},{"id":"R80010256","name":"Kab\u002E\u0020Pakpak\u0020Bharat","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Pakpak\u0020Bharat"},{"id":"R80010243","name":"Kab\u002E\u0020Samosir","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Samosir"},{"id":"R80010245","name":"Kab\u002E\u0020Serdang\u0020Bedagai","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Serdang\u0020Bedagai"},{"id":"R80010239","name":"Kab\u002E\u0020Simalungun","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Simalungun"},{"id":"R80010249","name":"Kab\u002E\u0020Tapanuli\u0020Selatan","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Tapanuli\u0020Selatan"},{"id":"R80010248","name":"Kab\u002E\u0020Tapanuli\u0020Tengah","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Tapanuli\u0020Tengah"},{"id":"R80010267","name":"Kab\u002E\u0020Tapanuli\u0020Utara","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Tapanuli\u0020Utara"},{"id":"R80010255","name":"Kab\u002E\u0020Toba\u0020Samosir","nameLocal":"","parentId":"R2390843","displayName":"Kab\u002E\u0020Toba\u0020Samosir"},{"id":"R80010269","name":"Kota\u0020Binjai","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Binjai"},{"id":"R80010254","name":"Kota\u0020Gunungsitoli","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Gunungsitoli"},{"id":"R80010258","name":"Kota\u0020Medan","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Medan"},{"id":"R80010257","name":"Kota\u0020Padang\u0020Sidempuan","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Padang\u0020Sidempuan"},{"id":"R80010271","name":"Kota\u0020Pematang\u0020Siantar","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Pematang\u0020Siantar"},{"id":"R80010260","name":"Kota\u0020Sibolga","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Sibolga"},{"id":"R80010266","name":"Kota\u0020Tanjung\u0020Balai","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Tanjung\u0020Balai"},{"id":"R80010270","name":"Kota\u0020Tebing\u0020Tinggi","nameLocal":"","parentId":"R2390843","displayName":"Kota\u0020Tebing\u0020Tinggi"}]}
            ]
            var obj={};
            for(var i=0;i<sheng.length;i++){
                var b={};
                // console.log(shi[i].a)
                for(var j=0;j<shi[i].a.length;j++){
                        // console.log(shi[i].a[j][0])
                    b[shi[i].a[j].name]=shi[i].a[j].id
                }
                obj[sheng[i].name]=b;
            }
    
    
    
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
                    'county': '<option value="">都道府県を選択してください</option>',
                    'district': '<option value="">市町村を選択してください</option>'
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
