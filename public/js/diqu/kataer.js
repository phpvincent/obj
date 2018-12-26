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
      
      var obj={
        
            "Madhinat Khalifa": {
              "MADHINAT KHALIFA":"AREA870"
            },
            "Umm Slal Ali": {
              "UMM SLAL ALI": "AREA871"
            },
            "Ras Laffan": {
              "RAS LAFFAN": "AREA872"
            },
            "Dukhan": {
              "DUKHAN": "AREA873"
            },
            "Al Khor": {
              "AL KHOR": "AREA874"
            },
            "Fareej Al Amir": {
              "FAREEJ AL AMIR": "AREA875"
            },
            "Dahl Al Hamam": {
              "DAHL AL HAMAM": "AREA876"
            },
            "New Al Rayyan": {
              "NEW AL RAYYAN": "AREA877"
            },
            "Al Kharatiyat": {
              "AL KHARATIYAT": "AREA878"
            },
            "Al Wajba": {
              "AL WAJBA": "AREA879"
            },
            "Umm Lekhba": {
              "UMM LEKHBA": "AREA880"
            },
            "Al Messila": {
              "AL MESSILA": "AREA881"
            },
            "Onaiza": {
              "ONAIZA": "AREA882"
            },
            "Umm Slal Mohammad": {
              "UMM SLAL MOHAMMAD": "AREA883"
            },
            "Ras Laffan Industrial City": {
              "RAS LAFFAN INDUSTRIAL CITY": "AREA884"
            },
            "Sports City": {
              "SPORTS CITY": "AREA885"
            },
            "Ras Abu Fontas": {
              "RAS ABU FONTAS": "AREA886"
            },
            "Al Udeid": {
              "AL UDEID": "AREA887"
            },
            "Lusail": {
              "LUSAIL": "AREA888"
            },
            "Umm Al Amad": {
              "UMM AL AMAD": "AREA889"
            },
            "Umm Said": {
              "UMM SAID": "AREA890"
            },
            "Doha": {
              "DOHA": "AREA891"
            },
            "Bani Hajer": {
              "BANI HAJER": "AREA892"
            },
            "Al Wakra": {
              "AL WAKRA": "AREA893"
            },
            "Al Khuwair": {
              "AL KHUWAIR": "AREA894"
            },
            "Al Khulaifat": {
              "AL KHULAIFAT": "AREA895"
            },
            "Saha": {
              "SAHA": "AREA896"
            },
            "Muaither": {
              "MUAITHER": "AREA897"
            },
            "Mesaimeer": {
              "MESAIMEER": "AREA898"
            },
            "Al Duhail": {
              "AL DUHAIL": "AREA899"
            },
            "Umm Bab": {
              "UMM BAB": "AREA900"
            },
            "Wadi Al Banat": {
              "WADI AL BANAT": "AREA901"
            },
            "Old Al Rayyan": {
              "OLD AL RAYYAN": "AREA902"
            },
            "Al Shamal": {
              "AL SHAMAL": "AREA903"
            },
            "Mesaieed": {
              "MESAIEED": "AREA904"
            },
            "Lzghawa": {
              "LZGHAWA": "AREA905"
            },
            "Al Waab": {
              "AL WAAB": "AREA906"
            },
            "Al Gharafa": {
              "AL GHARAFA": "AREA907"
            },
            "Al Dafna": {
              "AL DAFNA": "AREA908"
            },
            "Al Luqta": {
              "AL LUQTA": "AREA909"
            },
            "Al Sailiya": {
              "AL SAILIYA": "AREA910"
            },
            "Doha Municipality": {
              "Al Hitmi": "AREA865",
              "Wadi Al Sail": "AREA864",
              "Umm Lekhba": "AREA863",
              "Umm Ghuwailina": "AREA862",
              "Rawdat Al Khail": "AREA858",
              "Ras Abu Abboud": "AREA857",
              "Onaiza": "AREA856",
              "Old Al Ghanim": "AREA855",
              "Old Airport": "AREA854",
              "Nuaija": "AREA853",
              "New Slata": "AREA852",
              "Najma": "AREA850",
              "Mushaireb": "AREA849",
              "Madinat Khalifa South": "AREA845",
              "Madinat Khalifa North": "AREA844",
              "Jelaiah": "AREA842",
              "Industerial Area": "AREA840",
              "Hazm Al Markhiya": "AREA839",
              "Fereej Mohammed Bin Jasim": "AREA837",
              "Fereej Kulaib": "AREA836",
              "Fereej Bin Omran": "AREA835",
              "Fereej Bin Mahmoud": "AREA834",
              "Fereej Abdel Aziz": "AREA832",
              "Doha Port": "AREA830",
              "Doha International Airport": "AREA829",
              "Al Thumama": "AREA825",
              "Al Souq": "AREA823",
              "Al Sadd": "AREA820",
              "Al Rumaila": "AREA818",
              "Al Rufaa\/Old Al Hitmi": "AREA817",
              "Al Qassar": "AREA816",
              "Al Najada": "AREA814",
              "Al Mirqab\/Old Slata": "AREA813",
              "Al Messila": "AREA812",
              "Al Markhiya": "AREA811",
              "Al Mansoura": "AREA810",
              "Al Khuwair": "AREA808",
              "Al Khulaifat": "AREA807",
              "Al Jebailat": "AREA802",
              "Al Jasra": "AREA801",
              "Al Hilal": "AREA800",
              "Al Ebaib": "AREA797",
              "Al Doha Al Jadeeda": "AREA796",
              "Al Dafna": "AREA795",
              "Al Bidda": "AREA794"
            },
            "Al Rayyan Municipality": {
              "Sawda Natheel": "AREA860",
              "New Al Rayyan": "AREA851",
              "Mebaireek": "AREA846",
              "Fereej Al Amir": "AREA833",
              "Al Soudan": "AREA822",
              "Al Luqta": "AREA809",
              "Al Karaana": "AREA803",
              "Al Gharrafa": "AREA798",
              "Abu Samra": "AREA792"
            },
            "Al Daayen Municipality": {
              "Jabal Thuaileb": "AREA841"
            },
            "Umm Slal Municipality": {
              "Al Kharaitiyat": "AREA804"
            },
            "Al Sheehaniya Municipality": {
              "Umm Bab": "AREA861",
              "Rawdat Rashed": "AREA859",
              "Lijmiliya": "AREA843",
              "Dukhan": "AREA831",
              "Al Utouriya": "AREA826",
              "Al Sheehaniya": "AREA821",
              "Al Nasraniya": "AREA815"
            },
            "Al Khor And Al Thakhira Municipality": {
              "Al Thakhira": "AREA824",
              "Al Khor": "AREA806",
              "Al Ghuwairiya": "AREA799"
            },
            "Al Shamal Municipality": {
              "Al Kabiyah": "AREA869",
              "Al Adhbah": "AREA868",
              "Al Mafjar": "AREA867",
              "Fuwairit": "AREA838",
              "Al Ruwais": "AREA819",
              "Abu Dhalouf": "AREA791"
            },
            "Al Wakra Municipality": {
              "Mesaieed Industrial Area": "AREA848",
              "Mesaieed": "AREA847",
              "Al Wukair": "AREA828",
              "Al Wakra": "AREA827",
              "Al Kharrara": "AREA805",
              "Al Adaid": "AREA793"
            },
            "Al Jumaliyah Municiplaity": {
              "Al Jumaliyah": "AREA866"
            },
            "Al Daayen": {
              "AL DAAYEN": "AREA998"
            }
          
      };
    //   for(var i=0;i<sheng.length;i++){
    //       var b={};
    //       // console.log(shi[i].a)
    //       for(var j=0;j<shi[i].a.length;j++){
    //               // console.log(shi[i].a[j][0])
    //           b[shi[i].a[j].name]=shi[i].a[j].id
    //       }
    //       obj[sheng[i].name]=b;
    //   }
    
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
                    'county': '<option value="">- - المدينه - -</option>',
                    'district': '<option value="">- - البلده  - -</option>'
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
