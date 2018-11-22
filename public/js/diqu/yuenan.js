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
      var sheng=[{"id":"984930","name":"Thành phố Đà Nẵng"},{"id":"984966","name":"THỪA THIÊN HUẾ"},{"id":"984911","name":"TỈNH AN GIANG"},{"id":"984929","name":"TỈNH BÀ RỊA"},{"id":"984913","name":"TỈNH BẮC CẠN"},{"id":"984914","name":"TỈNH BẮC GIANG"},{"id":"984912","name":"TỈNH BẠC LIÊU"},{"id":"984915","name":"TỈNH BẮC NINH"},{"id":"984916","name":"TỈNH BẾN TRE"},{"id":"984925","name":"TỈNH BÌNH DUONG"},{"id":"984923","name":"TỈNH BÌNH PHƯỚC"},{"id":"984924","name":"TỈNH BÌNH THUẬN"},{"id":"984922","name":"TỈNH BÌNH ĐỊNH"},{"id":"984921","name":"TỈNH CÀ MAU"},{"id":"984926","name":"TỈNH CẦN THƠ"},{"id":"984920","name":"TỈNH CAO BẰNG"},{"id":"984940","name":"TỈNH GIA LAI"},{"id":"984934","name":"TỈNH HÀ GIANG"},{"id":"984936","name":"TỈNH HÀ NAM"},{"id":"984935","name":"TỈNH HÀ TĨNH"},{"id":"984932","name":"TỈNH HẢI DƯƠNG"},{"id":"984938","name":"TỈNH HẬU GIANG"},{"id":"984933","name":"TỈNH HÒA BÌNH"},{"id":"984942","name":"TỈNH HƯNG YÊN"},{"id":"984941","name":"TỈNH KHÁNH HÒA"},{"id":"984943","name":"TỈNH KIÊN GIANG"},{"id":"984945","name":"TỈNH LAI CHÂU"},{"id":"984948","name":"TỈNH LÂM ĐỒNG"},{"id":"984946","name":"TỈNH LẠNG SƠN"},{"id":"984947","name":"TỈNH LÀO CAI"},{"id":"984949","name":"TỈNH LONG AN"},{"id":"984950","name":"TỈNH NGHỆ AN"},{"id":"984951","name":"TỈNH NINH BÌNH"},{"id":"984952","name":"TỈNH NINH THUẬN"},{"id":"984953","name":"TỈNH PHÚ THỌ"},{"id":"984954","name":"TỈNH PHÚ YÊN"},{"id":"984955","name":"TỈNH QUẢNG BÌNH"},{"id":"984956","name":"TỈNH QUẢNG NAM"},{"id":"984957","name":"TỈNH QUẢNG NGÃI"},{"id":"984958","name":"TỈNH QUẢNG NINH"},{"id":"984959","name":"TỈNH QUẢNG TRỊ"},{"id":"984960","name":"TỈNH SÓC TRĂNG"},{"id":"984961","name":"TỈNH SƠN LA"},{"id":"984962","name":"TỈNH TÂY NINH"},{"id":"984963","name":"TỈNH THÁI BÌNH"},{"id":"984964","name":"TỈNH THÁI NGUYÊN"},{"id":"984965","name":"TỈNH THANH HÓA"},{"id":"984967","name":"TỈNH TIỀN GIANG"},{"id":"984969","name":"TỈNH TUYÊN QUANG"},{"id":"984970","name":"TỈNH VĨNH LONG"},{"id":"984971","name":"TỈNH VĨNH PHÚC"},{"id":"984972","name":"Tỉnh Yên Bái"},{"id":"984918","name":"TỈNH ĐĂK LĂK"},{"id":"984919","name":"TỈNH ĐĂK NÔNG"},{"id":"984917","name":"TỈNH ĐIỆN BIÊN"},{"id":"984927","name":"TỈNH ĐỒNG NAI"},{"id":"984928","name":"TỈNH ĐỒNG THÁP"},{"id":"1517779","name":"Tỉnh Nam Định"},{"id":"984937","name":"TP. HÀ NỘI"},{"id":"984931","name":"TP. HẢI PHÒNG"},{"id":"984939","name":"TP. HỒ CHÍ MINH"},{"id":"984968","name":"TRÀ VINH"},{"id":"984944","name":"ĐIỆN TỈNH KON TUM"}];
      var shi =[
          {a:[{"id":"985536","name":"An Khê"},{"id":"985549","name":"Chơn Tâm"},{"id":"985541","name":"Chuyển phát nhanh"},{"id":"985515","name":"Datapost Đà Nẵng"},{"id":"985528","name":"Hoà Cường"},{"id":"985547","name":"Hoà Minh"},{"id":"985548","name":"Hoà Mỹ"},{"id":"985552","name":"Hoà Sơn"},{"id":"985551","name":"Hoà Tiến"},{"id":"985518","name":"Hùng Vương"},{"id":"985525","name":"Liên Trì Nam"},{"id":"985530","name":"Mân Thái"},{"id":"985554","name":"Miếu Bông"},{"id":"985550","name":"Nam Ô"},{"id":"985523","name":"Ngô Gia Tư"},{"id":"985532","name":"Ngô Quyền"},{"id":"985556","name":"Ngũ Hành Sơn"},{"id":"985539","name":"Nguyễn Văn Linh"},{"id":"985542","name":"Nguyễn Văn Linh 2"},{"id":"985522","name":"Ông ích Khiêm"},{"id":"985543","name":"Phú Lộc"},{"id":"985520","name":"Quang Trung"},{"id":"985555","name":"Sơn Thuỷ"},{"id":"985517","name":"Sông Hàn"},{"id":"985537","name":"Tân An"},{"id":"985534","name":"Tân Chính"},{"id":"985538","name":"Thanh Khê"},{"id":"985531","name":"Thọ Quang"},{"id":"985521","name":"Thuận Phước 4"},{"id":"985546","name":"Tiếp Thị ĐN2"},{"id":"985558","name":"Tiếp Thị ĐN4"},{"id":"985533","name":"Trần Quang Diệu"},{"id":"985527","name":"Trần Quốc Toản"},{"id":"985526","name":"Trưng Nữ Vương"},{"id":"985514","name":"TTâm Khai thác VC"},{"id":"985524","name":"TTThương Nghiệp"},{"id":"985553","name":"Tuý Loan"},{"id":"985535","name":"Xuân Hoà"},{"id":"985516","name":"Đà Nẵng 1"},{"id":"985544","name":"Đà Nẵng 2"},{"id":"985545","name":"Đà Nẵng 2 KT"},{"id":"985529","name":"Đà Nẵng 3"},{"id":"985557","name":"Đà Nẵng 4"},{"id":"985540","name":"Đỗ Quang"},{"id":"985519","name":"Đống Đa"}]},
          {a:[{"id":"986825","name":"A Lưới"},{"id":"986814","name":"An Hòa"},{"id":"986822","name":"An Lỗ"},{"id":"986807","name":"Bến Ngự"},{"id":"986824","name":"Bình Điền"},{"id":"986832","name":"Cửa Thuận"},{"id":"986815","name":"Huế Ga"},{"id":"986812","name":"Huế Thành"},{"id":"986826","name":"Hương Thủy"},{"id":"986823","name":"Hương Trà"},{"id":"986827","name":"Kiốt Công Nghiệp"},{"id":"986838","name":"La Sơn"},{"id":"986840","name":"Lăng Cô"},{"id":"986809","name":"Lê Lợi"},{"id":"986808","name":"Lý Thường Kiệt"},{"id":"986830","name":"Nam Đông"},{"id":"986811","name":"Nhật Lệ"},{"id":"986820","name":"Phong Điền"},{"id":"986834","name":"Phú Lộc"},{"id":"986831","name":"Phú Vang"},{"id":"986836","name":"Phụng Chánh"},{"id":"986818","name":"Quảng Công"},{"id":"986819","name":"Quảng Thành"},{"id":"986817","name":"Quảng Điền"},{"id":"986813","name":"Tây Lộc"},{"id":"986839","name":"Thừa Lưu"},{"id":"986828","name":"Thủy Châu"},{"id":"986829","name":"Thủy Dương"},{"id":"986806","name":"TP Huế"},{"id":"986810","name":"Trần Hưng Đạo"},{"id":"986816","name":"Trần Phú"},{"id":"986833","name":"Trung Đông"},{"id":"986837","name":"Truồi"},{"id":"986835","name":"Tư Hiền"},{"id":"986821","name":"Điền Hòa"}]},
          {a:[{"id":"984984","name":"An Phú"},{"id":"984980","name":"Châu Phú"},{"id":"984978","name":"Châu Thành"},{"id":"984981","name":"Châu Đốc"},{"id":"984988","name":"Chi Lăng"},{"id":"984976","name":"Chợ Mới"},{"id":"984986","name":"Long Bình"},{"id":"984973","name":"Long Xuyên"},{"id":"984974","name":"Mỹ Long"},{"id":"984977","name":"Mỹ Luông"},{"id":"984982","name":"Núi Sam"},{"id":"984991","name":"Phú Hòa"},{"id":"984979","name":"Phú Tân"},{"id":"984985","name":"Quốc Thái"},{"id":"984983","name":"Tân Châu"},{"id":"984990","name":"Thoại Sơn"},{"id":"984987","name":"Tịnh Biên"},{"id":"984989","name":"Tri Tôn"},{"id":"984975","name":"Vàm Cống"},{"id":"984992","name":"Vọng Thê"}]},
          {a:[{"id":"985473","name":"5 Tầng"},{"id":"985469","name":"Bãi Sau"},{"id":"985470","name":"Bãi Trước"},{"id":"985492","name":"Bàu Lâm"},{"id":"985478","name":"Bến Đá"},{"id":"985482","name":"Bến Đầm"},{"id":"985474","name":"Bến Đình"},{"id":"985495","name":"Bình Châu"},{"id":"985494","name":"Bưng Riềng"},{"id":"985502","name":"BĐH Châu Đức"},{"id":"985481","name":"BĐH Côn Đảo"},{"id":"985483","name":"BĐH Long Điền"},{"id":"985507","name":"BĐH Tân Thành"},{"id":"985489","name":"BĐH X.Mộc"},{"id":"985487","name":"BĐH Đất Đỏ"},{"id":"985496","name":"BĐTX Bà Rịa"},{"id":"985471","name":"Cảng Cát lở"},{"id":"985475","name":"Chí Linh"},{"id":"985501","name":"Chợ Bà Rịa"},{"id":"985479","name":"Chợ Cũ"},{"id":"985497","name":"Gò Cát"},{"id":"985511","name":"Hắc Dịch"},{"id":"985491","name":"Hòa Bình"},{"id":"985490","name":"Hòa Hiệp"},{"id":"985499","name":"Hoà Long"},{"id":"985513","name":"Hội Bài"},{"id":"985500","name":"Kim Hải"},{"id":"985505","name":"Kim Long"},{"id":"985506","name":"Láng Lớn"},{"id":"985484","name":"Lò Vôi"},{"id":"985485","name":"Long Hải"},{"id":"985476","name":"Long Sơn"},{"id":"985498","name":"Long Toàn"},{"id":"985509","name":"Mỹ Xuân"},{"id":"985510","name":"Mỹ Xuân A"},{"id":"985477","name":"Nguyễn Văn Trỗi"},{"id":"985508","name":"Phú Mỹ"},{"id":"985488","name":"Phước Hải"},{"id":"985512","name":"Phước Hòa"},{"id":"985472","name":"Phước Thắng"},{"id":"985493","name":"Phước Thuận"},{"id":"985486","name":"Phước Tỉnh"},{"id":"985503","name":"Sơn Bình"},{"id":"985504","name":"Suối Nghệ"},{"id":"985480","name":"Thắng Nhất"},{"id":"985468","name":"Vũng Tàu"}]},
          {a:[{"id":"985022","name":"Ba Bể"},{"id":"985018","name":"Bạch Thông"},{"id":"985020","name":"Bằng Khẩu"},{"id":"985029","name":"Cao Kỳ"},{"id":"985026","name":"Chợ Mới"},{"id":"985027","name":"Chợ Mới 2"},{"id":"985025","name":"Chợ Đồn"},{"id":"985023","name":"Khang Ninh"},{"id":"985017","name":"Lạng San"},{"id":"985014","name":"Minh Khai"},{"id":"985015","name":"Nà Mày"},{"id":"985021","name":"Nà Phặc"},{"id":"985016","name":"Na Rì"},{"id":"985019","name":"Ngân Sơn"},{"id":"985030","name":"Pắc Nậm"},{"id":"985028","name":"Sáu Hai"},{"id":"985013","name":"TX Bắc Cạn"},{"id":"985024","name":"Vườn Quốc gia Ba Bể"}]},
          {a:[{"id":"985031","name":"Bắc Giang"},{"id":"985041","name":"Bố Hạ"},{"id":"985046","name":"Hiệp Hòa"},{"id":"985044","name":"Hồng Thái"},{"id":"985045","name":"KCN Đình Trám"},{"id":"985039","name":"Kép"},{"id":"985038","name":"Lạng Giang"},{"id":"985033","name":"Lục Nam"},{"id":"985035","name":"Lục Ngạn"},{"id":"985032","name":"Nguyễn Văn Cừ"},{"id":"985036","name":"Phố Lim"},{"id":"985034","name":"Sơn Động"},{"id":"985042","name":"Tân Yên"},{"id":"985043","name":"Việt Yên"},{"id":"985047","name":"Yên Dũng"},{"id":"985040","name":"Yên Thế"},{"id":"985037","name":"Đình Kim"}]},
          {a:[{"id":"984993","name":"Bạc Liêu"},{"id":"984996","name":"Cầu Sập"},{"id":"985012","name":"Cầu Số 2"},{"id":"985010","name":"Cây Giang"},{"id":"985002","name":"Chủ Chí"},{"id":"985004","name":"Giá Rai"},{"id":"985006","name":"Hộ Phòng"},{"id":"985011","name":"Hoà Bình"},{"id":"985003","name":"Hồng Dân"},{"id":"985009","name":"Kinh Tư"},{"id":"985007","name":"Láng Trâm"},{"id":"985005","name":"Láng Tròn"},{"id":"984999","name":"Phó Sinh"},{"id":"984998","name":"Phước Long"},{"id":"985001","name":"Rọc Lá"},{"id":"984994","name":"Trà Kha"},{"id":"985000","name":"Trưởng Tòa"},{"id":"984997","name":"Vĩnh Hưng"},{"id":"984995","name":"Vĩnh Lợi"},{"id":"985008","name":"Đông Hải"}]},
          {a:[{"id":"985048","name":"Bắc Ninh"},{"id":"985060","name":"Chợ Dâu"},{"id":"985067","name":"Chợ Ngụ"},{"id":"985066","name":"Chợ Núi"},{"id":"985053","name":"Chợ Và"},{"id":"985065","name":"Gia Bình"},{"id":"985063","name":"KCN Quế Võ"},{"id":"985054","name":"KCN Tiên Sơn"},{"id":"985069","name":"Kên Vàng"},{"id":"985068","name":"Lương Tài"},{"id":"985049","name":"Lý Thái Tổ"},{"id":"985064","name":"Nội Doi"},{"id":"985059","name":"Phố Hồ"},{"id":"985062","name":"Quế Võ"},{"id":"985058","name":"Thuận Thành"},{"id":"985052","name":"Tiên Du"},{"id":"985061","name":"Trạm Lộ"},{"id":"985056","name":"Trần Phú"},{"id":"985055","name":"Từ Sơn"},{"id":"985051","name":"Vạn An"},{"id":"985050","name":"Yên Phong"},{"id":"985057","name":"Đình Bảng"}]},
          {a:[{"id":"985075","name":"An Hiệp"},{"id":"985073","name":"An Hóa"},{"id":"985104","name":"An Ngãi trung"},{"id":"985087","name":"An Thới"},{"id":"985106","name":"An Thủy"},{"id":"985086","name":"An Định"},{"id":"985100","name":"Ba Tri"},{"id":"985083","name":"Ba Vát"},{"id":"985101","name":"Bảo Thuận"},{"id":"985107","name":"Bình Đại"},{"id":"985079","name":"Cái Mơn"},{"id":"985088","name":"Cẩm Sơn"},{"id":"985110","name":"Châu Hưng"},{"id":"985072","name":"Châu Thành"},{"id":"985077","name":"Chợ Lách"},{"id":"985085","name":"Chợ Thom"},{"id":"985099","name":"Giao Thạnh"},{"id":"985090","name":"Giồng trôm"},{"id":"985096","name":"Hưng Nhượng"},{"id":"985089","name":"Hương Mỹ"},{"id":"985108","name":"Lộc Thuận"},{"id":"985078","name":"Long Thới"},{"id":"985091","name":"Lương Quới"},{"id":"985081","name":"Mỏ Cày"},{"id":"985103","name":"Mỹ Chánh"},{"id":"985092","name":"Mỹ Lồng"},{"id":"985084","name":"Nhuận Phú Tân"},{"id":"985093","name":"Phước Long"},{"id":"985071","name":"T tâm dvu tin học"},{"id":"985105","name":"Taân Thuûy"},{"id":"985094","name":"Tân Hào"},{"id":"985098","name":"Tân Phong"},{"id":"985074","name":"Tân Phú"},{"id":"985082","name":"Tân Thành Bình"},{"id":"985080","name":"Tân Thiềng"},{"id":"985102","name":"Tân Xuân"},{"id":"985097","name":"Thạnh Phú"},{"id":"985095","name":"Thạnh Phú Đông"},{"id":"985109","name":"Thới Lai"},{"id":"985076","name":"Tiên Thuỷ"},{"id":"985070","name":"Ttâm Thành phố"}]},
          {a:[{"id":"985345","name":"An Bình"},{"id":"985361","name":"An Phú"},{"id":"985347","name":"Bến Cát"},{"id":"985368","name":"Bình Minh"},{"id":"985365","name":"Bình An"},{"id":"985363","name":"Bình Chuẩn"},{"id":"985354","name":"Dầu Tiếng"},{"id":"985364","name":"Dĩ An"},{"id":"985349","name":"Hưng Hòa"},{"id":"985348","name":"KCN Mỹ Phước"},{"id":"985352","name":"KCN Mỹ Phước 3"},{"id":"985360","name":"KCN Vsip"},{"id":"985340","name":"Khánh Bình"},{"id":"985350","name":"Lai Uyên"},{"id":"985355","name":"Long Hòa"},{"id":"985356","name":"Minh Hòa"},{"id":"985344","name":"Phú Giáo"},{"id":"985346","name":"Phước Hòa"},{"id":"985351","name":"Phú An"},{"id":"985338","name":"Phú Cường"},{"id":"985341","name":"Phú Mỹ"},{"id":"985367","name":"Sóng Thần"},{"id":"985353","name":"Sở Sao"},{"id":"985343","name":"Tân Ba"},{"id":"985342","name":"Tân Phước Khánh"},{"id":"985339","name":"Tân Uyên"},{"id":"985366","name":"Tân Đông Hiệp"},{"id":"985357","name":"Thanh Tuyền"},{"id":"985336","name":"Thủ Dầu Một"},{"id":"985358","name":"Thuận An"},{"id":"985362","name":"Thuận Giao"},{"id":"985337","name":"Tương Bình Hiệp"},{"id":"985359","name":"Đồng An"}]},
          {a:[{"id":"985289","name":"Bình Long"},{"id":"985286","name":"Bù Nho"},{"id":"985279","name":"Bù Đăng"},{"id":"985297","name":"Bù Đốp"},{"id":"985292","name":"Chơn Thành"},{"id":"985293","name":"Chơn Thành2"},{"id":"985288","name":"Lộc Ninh"},{"id":"985280","name":"Minh Hưng"},{"id":"985294","name":"Minh Hưng 2"},{"id":"985295","name":"Minh Lập"},{"id":"985296","name":"Nha Bích"},{"id":"985287","name":"Phú Riềng"},{"id":"985285","name":"Phước Bình"},{"id":"985282","name":"Phước Long"},{"id":"985276","name":"Tân Hòa"},{"id":"985291","name":"Tân Khai"},{"id":"985274","name":"Tân thành"},{"id":"985298","name":"Tân Tiến"},{"id":"985290","name":"Thanh Lương"},{"id":"985277","name":"Thuận Lợi"},{"id":"985284","name":"Đa Kia"},{"id":"985283","name":"Đak Ơ"},{"id":"985275","name":"Đồng Phú"},{"id":"985278","name":"Đồng Tâm"},{"id":"985273","name":"Đồng Xoài"},{"id":"985281","name":"Đức Liễu"}]},
          {a:[{"id":"985305","name":"Bắc Bình"},{"id":"985308","name":"Bình Tân"},{"id":"985311","name":"Chí Công"},{"id":"985323","name":"Gia An"},{"id":"985317","name":"Hàm Cường"},{"id":"985315","name":"Hàm Hiệp"},{"id":"985318","name":"Hàm Mỹ"},{"id":"985328","name":"Hàm Tân"},{"id":"985313","name":"Hàm Thuận Bắc"},{"id":"985316","name":"Hàm Thuận Nam"},{"id":"985334","name":"La Gi"},{"id":"985300","name":"Lê Hồng Phong"},{"id":"985307","name":"Lương Sơn"},{"id":"985322","name":"Măng Tố"},{"id":"985303","name":"Mũi Né"},{"id":"985319","name":"Mương Mán"},{"id":"985302","name":"Ngã 7"},{"id":"985312","name":"Phan Rí Cửa"},{"id":"985306","name":"Phan Rí Thành"},{"id":"985299","name":"Phan Thiết 1"},{"id":"985314","name":"Phú Long"},{"id":"985333","name":"Phú Quý"},{"id":"985335","name":"Phước Hội"},{"id":"985331","name":"Sơn Mỹ"},{"id":"985325","name":"Sùng Nhơn"},{"id":"985329","name":"Tân Minh"},{"id":"985332","name":"Tân Thắng"},{"id":"985330","name":"Tân Đức"},{"id":"985320","name":"Tánh Linh"},{"id":"985301","name":"Tổ dịch vụ(tổ Nghiệp vụ)"},{"id":"985327","name":"Trà Tân"},{"id":"985309","name":"Tuy Phong"},{"id":"985310","name":"Vĩnh Tân"},{"id":"985321","name":"Đồng Kho"},{"id":"985324","name":"Đức Linh"},{"id":"985304","name":"Đức Long"},{"id":"985326","name":"Đức Tài"}]},
          {a:[{"id":"985267","name":"An Lão"},{"id":"985257","name":"An Lương"},{"id":"985248","name":"An Nhơn"},{"id":"985259","name":"Bình Dương"},{"id":"985264","name":"Bồng Sơn"},{"id":"985235","name":"BĐ Hệ 1"},{"id":"985236","name":"Cảng"},{"id":"985238","name":"Chợ Dinh"},{"id":"985263","name":"Chợ Đề"},{"id":"985254","name":"Chợ Gành"},{"id":"985255","name":"Chợ Gồm"},{"id":"985247","name":"Diêu Trì Ga"},{"id":"985246","name":"Diêu Trì"},{"id":"985245","name":"Gò Bồi"},{"id":"985250","name":"Gò Găng"},{"id":"985265","name":"Hòai Ân"},{"id":"985261","name":"Hòai Hương"},{"id":"985260","name":"Hòai Nhơn"},{"id":"985252","name":"Lộc Thọ"},{"id":"985266","name":"Mỹ Thành"},{"id":"985239","name":"Ngô Mây"},{"id":"985251","name":"Nhơn Hòa"},{"id":"985243","name":"Phan Bội Châu"},{"id":"985242","name":"Phú Tài"},{"id":"985253","name":"Phù Cát"},{"id":"985256","name":"Phù Mỹ"},{"id":"985240","name":"Quang Trung"},{"id":"985233","name":"Quy Nhơn"},{"id":"985262","name":"Tam Quan"},{"id":"985258","name":"Tân Dân"},{"id":"985270","name":"Tây Sơn"},{"id":"985237","name":"Tháp Đôi"},{"id":"985234","name":"Tổ Tiếp Thị- Bán Hàng"},{"id":"985241","name":"Trần Quang Diệu"},{"id":"985244","name":"Tuy Phước"},{"id":"985272","name":"Vân Canh"},{"id":"985269","name":"Vĩnh Thạnh"},{"id":"985268","name":"Xuân Phong"},{"id":"985249","name":"Đập Đá"},{"id":"985271","name":"Đồng Phó"}]},
          {a:[{"id":"985210","name":"19 tháng 5"},{"id":"985191","name":"Cà Mau"},{"id":"985207","name":"Cái Nước"},{"id":"985208","name":"Cái Rắn"},{"id":"985219","name":"Gò Công"},{"id":"985221","name":"Hàng Vịnh"},{"id":"985209","name":"Hưng Mỹ"},{"id":"985201","name":"Khánh Hội"},{"id":"985204","name":"Khánh Hưng"},{"id":"985220","name":"Năm Căn"},{"id":"985213","name":"Ngọc Hiển"},{"id":"985192","name":"Nguyễn Tất Thành"},{"id":"985217","name":"Phú Tân"},{"id":"985218","name":"Phú Tân 2"},{"id":"985205","name":"Sông Đốc A"},{"id":"985206","name":"Sông Đốc B"},{"id":"985199","name":"Tắc Thủ"},{"id":"985194","name":"Tắc Vân"},{"id":"985222","name":"Tam Giang"},{"id":"985197","name":"Tân Bằng"},{"id":"985198","name":"Tân Lộc"},{"id":"985193","name":"Tân Thành"},{"id":"985195","name":"Thới Bình"},{"id":"985202","name":"Trần Văn Thời"},{"id":"985196","name":"Trí Phải"},{"id":"985200","name":"U Minh"},{"id":"985212","name":"Vàm Đầm"},{"id":"985215","name":"Viên An"},{"id":"985214","name":"Viên An Đông"},{"id":"985203","name":"Đá Bạc"},{"id":"985211","name":"Đầm Dơi"},{"id":"985216","name":"Đất Mũi"}]},
          {a:[{"id":"985372","name":"An Hòa"},{"id":"985378","name":"An Thới"},{"id":"985377","name":"Bình Thủy"},{"id":"985370","name":"Cái Khế"},{"id":"985381","name":"Cái Răng"},{"id":"985369","name":"Cần Thơ"},{"id":"985371","name":"Chợ Cái Khế"},{"id":"985388","name":"Cờ Đỏ"},{"id":"985380","name":"Hồi Lực"},{"id":"985375","name":"Hưng Lợi"},{"id":"985376","name":"Hưng Lợi 2"},{"id":"985373","name":"Mậu Thân"},{"id":"985382","name":"Ô Môn"},{"id":"985386","name":"Phong Điền"},{"id":"985391","name":"Phú Thứ"},{"id":"985390","name":"Thạnh An"},{"id":"985387","name":"Thới Lai"},{"id":"985384","name":"Thới Thuận"},{"id":"985383","name":"Thốt Nốt"},{"id":"985379","name":"Trà Nóc"},{"id":"985385","name":"Trung An"},{"id":"985389","name":"Vĩnh Thạnh"},{"id":"985374","name":"Xuân Khánh"}]},
          {a:[{"id":"985186","name":"Bảo Lạc"},{"id":"985187","name":"Bảo Lâm"},{"id":"985169","name":"Cao Bằng"},{"id":"985179","name":"Cao Bình"},{"id":"985174","name":"Hạ Lang"},{"id":"985180","name":"Hà Quảng"},{"id":"985177","name":"Hòa An"},{"id":"985182","name":"Nà Giàng"},{"id":"985178","name":"Nà Rị"},{"id":"985184","name":"Nguyên Bình"},{"id":"985189","name":"Phục Hòa"},{"id":"985173","name":"Quảng Uyên"},{"id":"985181","name":"Sóc Giang"},{"id":"985190","name":"Tà Lùng"},{"id":"985170","name":"Tam Trung"},{"id":"985171","name":"Tân Giang"},{"id":"985188","name":"Thạch An"},{"id":"985183","name":"Thông Nông"},{"id":"985185","name":"Tĩnh Túc"},{"id":"985176","name":"Trà Lĩnh"},{"id":"985175","name":"Trùng Khánh"},{"id":"985172","name":"Đề Thám"}]},
          {a:[{"id":"985994","name":"An Khê"},{"id":"986002","name":"Ayun Pa"},{"id":"985987","name":"Biển Hồ"},{"id":"985986","name":"Biển Hồ 2"},{"id":"985991","name":"Chư Á"},{"id":"985996","name":"Chư Pah"},{"id":"985999","name":"Chư Prông"},{"id":"986001","name":"Chư Pưh"},{"id":"986000","name":"Chư Sê"},{"id":"985989","name":"Diên Hồng"},{"id":"985997","name":"Ia Grai"},{"id":"986007","name":"Ia Pa"},{"id":"986005","name":"Ia Siêm"},{"id":"985995","name":"Kbang"},{"id":"986003","name":"Krông ChRo"},{"id":"986004","name":"Krông Pa"},{"id":"985993","name":"Mang Yang"},{"id":"986008","name":"Phú Thiện"},{"id":"985985","name":"Pleiku – Chư Pah"},{"id":"985990","name":"Trà Bá"},{"id":"985988","name":"Yên Đỗ"},{"id":"986006","name":"Đak Pơk"},{"id":"985992","name":"Đak Đoa"},{"id":"985998","name":"Đức Cơ"}]},
          {a:[{"id":"985673","name":"Bắc Mê"},{"id":"985683","name":"Bắc Quang"},{"id":"985670","name":"Công Viên"},{"id":"985669","name":"Hà Giang"},{"id":"985681","name":"Hoàng Su Phì"},{"id":"985685","name":"Hùng An"},{"id":"985675","name":"Mèo Vạc"},{"id":"985671","name":"Minh Khai"},{"id":"985677","name":"Phó Bảng"},{"id":"985678","name":"Quản Bạ"},{"id":"985688","name":"Quang Bình"},{"id":"985684","name":"Tân Quang"},{"id":"985679","name":"Vị Xuyên"},{"id":"985680","name":"Việt Lâm"},{"id":"985686","name":"Vĩnh Tuy"},{"id":"985682","name":"Xín Mần"},{"id":"985672","name":"Yên Biên"},{"id":"985674","name":"Yên Minh"},{"id":"985676","name":"Đồng Văn"},{"id":"985687","name":"Đồng Yên"}]},
          {a:[{"id":"985702","name":"Ba Đa"},{"id":"985709","name":"Bình Lục"},{"id":"985703","name":"Châu Sơn"},{"id":"985705","name":"Duy Tiên"},{"id":"985707","name":"Kim Bảng"},{"id":"985704","name":"Lý Nhân"},{"id":"985701","name":"Phủ Lý"},{"id":"985708","name":"Thanh Liêm"},{"id":"985706","name":"Đồng Văn"}]},
          {a:[{"id":"985698","name":"Cẩm Xuyên"},{"id":"985691","name":"Can Lộc"},{"id":"985689","name":"Hà Tĩnh"},{"id":"985692","name":"Hồng Lĩnh"},{"id":"985697","name":"Hương Khê"},{"id":"985695","name":"Hương Sơn"},{"id":"985699","name":"Kỳ Anh"},{"id":"985700","name":"Lộc Hà"},{"id":"985693","name":"Nghi Xuân"},{"id":"985690","name":"Thạch Hà"},{"id":"985696","name":"Vũ Quang"},{"id":"985694","name":"Đức Thọ"}]},
          {a:[{"id":"985632","name":"Bến Tắm"},{"id":"985639","name":"Bình Giang"},{"id":"985636","name":"Cẩm Giàng"},{"id":"985638","name":"Cẩm Giàng Ga"},{"id":"985637","name":"Cầu Ghẽ"},{"id":"985647","name":"Cầu Ràm"},{"id":"985650","name":"Cầu Xe"},{"id":"985631","name":"Chí Linh"},{"id":"985624","name":"Chợ Hệ"},{"id":"985642","name":"Gia Lộc"},{"id":"985618","name":"Hải Dương"},{"id":"985645","name":"Hồng Quang"},{"id":"985649","name":"Hưng Đạo"},{"id":"985625","name":"Kim Thành"},{"id":"985629","name":"Kinh Môn"},{"id":"985634","name":"Lục Đầu Giang"},{"id":"985627","name":"Nam Sách"},{"id":"985620","name":"Ngọc Châu"},{"id":"985646","name":"Ninh Giang"},{"id":"985633","name":"Phả Lại"},{"id":"985619","name":"Phòng KDBC"},{"id":"985640","name":"Quán Gỏi"},{"id":"985635","name":"Tân Dân"},{"id":"985641","name":"Thái Học"},{"id":"985630","name":"Thái Mông"},{"id":"985621","name":"Thanh Bình"},{"id":"985623","name":"Thanh Hà"},{"id":"985644","name":"Thanh Miện"},{"id":"985628","name":"Thanh Quang"},{"id":"985622","name":"Tiền Trung"},{"id":"985648","name":"Tứ Kỳ"},{"id":"985643","name":"Đoàn Thượng"},{"id":"985626","name":"Đồng Gia"}]},
          {a:[{"id":"985804","name":"Cái Tắc"},{"id":"985795","name":"Cầu Trắng"},{"id":"985806","name":"Châu Thành"},{"id":"985802","name":"Châu Thành A"},{"id":"985797","name":"Hòa An"},{"id":"985798","name":"Hòa Mỹ"},{"id":"985792","name":"Long Mỹ"},{"id":"985796","name":"Long Thạnh"},{"id":"985807","name":"Ngã Bảy"},{"id":"985794","name":"Phụng Hiệp"},{"id":"985791","name":"Phường 7"},{"id":"985799","name":"Phương Bình"},{"id":"985805","name":"Tân Hòa"},{"id":"985803","name":"Thạnh Xuân"},{"id":"985801","name":"Vị Thanh"},{"id":"985800","name":"Vị Thủy"},{"id":"985793","name":"Vĩnh Viễn"}]},
          {a:[{"id":"985667","name":"Ba Hàng Đồi"},{"id":"985661","name":"Cao Phong"},{"id":"985666","name":"Chợ Bến"},{"id":"985651","name":"Hòa Bình"},{"id":"985652","name":"KHoạch KDoanh"},{"id":"985665","name":"Kim Bôi"},{"id":"985656","name":"Kỳ Sơn"},{"id":"985663","name":"Lạc Sơn"},{"id":"985668","name":"Lạc Thủy"},{"id":"985657","name":"Lương Sơn"},{"id":"985660","name":"Mai Châu"},{"id":"985662","name":"Nông Trường"},{"id":"985655","name":"Phố Chăm"},{"id":"985653","name":"Phương Lâm"},{"id":"985658","name":"Tân Lạc"},{"id":"985654","name":"Tân Thịnh"},{"id":"985664","name":"Yên Thủy"},{"id":"985659","name":"Đà Bắc"}]},
          {a:[{"id":"986057","name":"Ân Thi"},{"id":"986062","name":"Bô Thời"},{"id":"986052","name":"Chợ Gạo"},{"id":"986058","name":"Chợ Thi"},{"id":"986049","name":"Hưng Yên"},{"id":"986061","name":"Khoái Châu"},{"id":"986060","name":"Kim Động"},{"id":"986051","name":"Lê Lợi"},{"id":"986070","name":"Mỹ Hào"},{"id":"986072","name":"Như Quỳnh"},{"id":"986050","name":"Phố Hiến"},{"id":"986054","name":"Phù Cừ"},{"id":"986055","name":"Quang Hưng"},{"id":"986065","name":"Tân Châu"},{"id":"986066","name":"Thuần Hưng"},{"id":"986053","name":"Tiên Lữ"},{"id":"986069","name":"Từ Hồ"},{"id":"986073","name":"Văn Giang"},{"id":"986071","name":"Văn Lâm"},{"id":"986074","name":"Văn Phúc"},{"id":"986068","name":"Yên Mỹ"},{"id":"986059","name":"Đa Lộc"},{"id":"986067","name":"Đại Hưng"},{"id":"986056","name":"Đình Cao"},{"id":"986064","name":"Đông Kết"},{"id":"986063","name":"Đông Tảo"}]},
          {a:[{"id":"986022","name":"Bình Tân"},{"id":"986046","name":"Cam An Nam"},{"id":"986047","name":"Cam Hòa"},{"id":"986045","name":"Cam Lâm"},{"id":"986039","name":"Cam Phú"},{"id":"986040","name":"Cam Phúc"},{"id":"986041","name":"Cam Phúc Nam"},{"id":"986043","name":"Cam Phước Đông"},{"id":"986038","name":"Cam Ranh"},{"id":"986032","name":"Diên Khánh"},{"id":"986035","name":"Diên Phước"},{"id":"986034","name":"Diên Xuân"},{"id":"986027","name":"Dục Mỹ"},{"id":"986009","name":"GDTT Nha Trang"},{"id":"986019","name":"Hoàng Hoa Thám"},{"id":"986025","name":"Hòn Khói"},{"id":"986037","name":"Khánh Sơn"},{"id":"986036","name":"Khánh Vĩnh"},{"id":"986026","name":"Lạc An"},{"id":"986016","name":"Lê Hồng Phong"},{"id":"986017","name":"Lê Thánh Tôn"},{"id":"986042","name":"Mỹ Ca"},{"id":"986033","name":"Ngã Ba Thành"},{"id":"986018","name":"Nguyễn Thiện Thuật"},{"id":"986024","name":"Ninh Hòa"},{"id":"986014","name":"Phương Sài"},{"id":"986048","name":"Suối Tân"},{"id":"986020","name":"Tân Lập"},{"id":"986010","name":"Tháp Bà"},{"id":"986044","name":"Trường Sa"},{"id":"986029","name":"Tu Bông"},{"id":"986028","name":"Vạn Ninh"},{"id":"986013","name":"Vạn Thạnh"},{"id":"986012","name":"Vĩnh Lương"},{"id":"986021","name":"Vĩnh Nguyên"},{"id":"986015","name":"Vĩnh Thạnh"},{"id":"986031","name":"Xuân Tự"},{"id":"986030","name":"Đại Lãnh"},{"id":"986011","name":"Đồng Đế"},{"id":"986023","name":"Đường Đệ"}]},
          {a:[{"id":"986089","name":"An Biên"},{"id":"986076","name":"An Hòa"},{"id":"986092","name":"An Minh"},{"id":"986088","name":"An Thới"},{"id":"986084","name":"Ba Hòn"},{"id":"986085","name":"Bình An"},{"id":"986081","name":"Bình Sơn"},{"id":"986112","name":"Cam An Nam"},{"id":"986113","name":"Cam Hòa"},{"id":"986111","name":"Cam Lâm"},{"id":"986105","name":"Cam Phú"},{"id":"986106","name":"Cam Phúc"},{"id":"986107","name":"Cam Phúc Nam"},{"id":"986109","name":"Cam Phước Đông"},{"id":"986104","name":"Cam Ranh"},{"id":"986093","name":"Châu Thành"},{"id":"986098","name":"Giồng Riềng"},{"id":"986096","name":"Gò Quao"},{"id":"986080","name":"Hòn Đất"},{"id":"986090","name":"Hưng Yên"},{"id":"986103","name":"Khánh Sơn"},{"id":"986100","name":"Kiên Hải"},{"id":"986083","name":"Kiên Lương"},{"id":"986079","name":"Kinh Tám"},{"id":"986099","name":"Long Thạnh"},{"id":"986108","name":"Mỹ Ca"},{"id":"986101","name":"Nam Du"},{"id":"986087","name":"Phú Quốc"},{"id":"986075","name":"Rạch Giá"},{"id":"986077","name":"Rạch Sỏi"},{"id":"986097","name":"Sóc Ven"},{"id":"986082","name":"Sóc Xoài"},{"id":"986114","name":"Suối Tân"},{"id":"986094","name":"Tắc Cậu"},{"id":"986078","name":"Tân Hiệp"},{"id":"986091","name":"Thứ 7"},{"id":"986110","name":"Trường Sa"},{"id":"986086","name":"TX Hà Tiên"},{"id":"986102","name":"U Minh Thượng"},{"id":"986095","name":"Vĩnh Thuận"}]},
          {a:[{"id":"986133","name":"Lai Châu"},{"id":"986137","name":"Mường Tè"},{"id":"986136","name":"Phong Thổ"},{"id":"986138","name":"Sìn Hồ"},{"id":"986135","name":"Tam Đường"},{"id":"986140","name":"Tân Uyên"},{"id":"986139","name":"Than Uyên"},{"id":"986134","name":"Đoàn Kết"}]},
          {a:[{"id":"986196","name":"Bảo Lâm"},{"id":"986198","name":"Bảo Lộc"},{"id":"986179","name":"Bùi Thị Xuân"},{"id":"986208","name":"Cát Tiên"},{"id":"986181","name":"Cấu Đất"},{"id":"986194","name":"Di Linh"},{"id":"986183","name":"Dran"},{"id":"986199","name":"Hà Giang"},{"id":"986195","name":"Hòa Ninh"},{"id":"986185","name":"Lạc Dương"},{"id":"986184","name":"Lạc Lâm"},{"id":"986186","name":"Lâm Hà"},{"id":"986190","name":"Liên Khương"},{"id":"986197","name":"Lộc An"},{"id":"986204","name":"Lộc Châu"},{"id":"986206","name":"Lộc Nga"},{"id":"986200","name":"Lộc Phát"},{"id":"986203","name":"Lộc Tiến"},{"id":"986176","name":"Mê Linh"},{"id":"986187","name":"Nam Ban"},{"id":"986201","name":"Nguyễn Công Trứ"},{"id":"986193","name":"Ninh Gia"},{"id":"986175","name":"Phan Chu Trinh"},{"id":"986180","name":"Phan Đình Phùng"},{"id":"986191","name":"Phi Nôm"},{"id":"986209","name":"Phước Cát 1"},{"id":"986177","name":"Quang Trung"},{"id":"986188","name":"Tân Hà"},{"id":"986192","name":"Tân Hội"},{"id":"986178","name":"Thái Phiên"},{"id":"986173","name":"Trại Mát"},{"id":"986172","name":"Trần Phú"},{"id":"986174","name":"Tự Phước"},{"id":"986171","name":"Đà Lạt"},{"id":"986214","name":"Đạ Rsal"},{"id":"986213","name":"Đạ Tông"},{"id":"986210","name":"ĐaHuoai"},{"id":"986205","name":"Đại Lào"},{"id":"986202","name":"Đạm Bri"},{"id":"986211","name":"Đạm Ri"},{"id":"986212","name":"Đạm Rông"},{"id":"986207","name":"ĐạTẻh"},{"id":"986182","name":"Đơn Dương"},{"id":"986189","name":"Đức Trọng"}]},
          {a:[{"id":"986151","name":"Bắc Sơn"},{"id":"986150","name":"Bình Gia"},{"id":"986145","name":"Cao Lộc"},{"id":"986152","name":"Chi lăng"},{"id":"986143","name":"Cửa Đông"},{"id":"986153","name":"Hữu Lũng"},{"id":"986142","name":"Kthác Vchuyển BC"},{"id":"986144","name":"Kỳ Lừa"},{"id":"986154","name":"Lộc Bình"},{"id":"986148","name":"Tràng Định"},{"id":"986141","name":"TT Lạng Sơn"},{"id":"986147","name":"Văn Lãng"},{"id":"986149","name":"Văn Quan"},{"id":"986155","name":"Đình Lập"},{"id":"986146","name":"Đồng Đăng"}]},
          {a:[{"id":"986157","name":"Bắc Hà"},{"id":"986167","name":"Bảo Thắng"},{"id":"986169","name":"Bảo Yên"},{"id":"986160","name":"Bát Xát"},{"id":"986163","name":"Cốc Lếu"},{"id":"986162","name":"Cửa Khẩu"},{"id":"986166","name":"Hoàng Liên"},{"id":"986164","name":"Kim Tân"},{"id":"986159","name":"Mường Khương"},{"id":"986165","name":"Pom Hán"},{"id":"986161","name":"Sapa"},{"id":"986158","name":"Si Ma Cai"},{"id":"986156","name":"TP Lào Cai"},{"id":"986170","name":"Trần Hưng Đạo"},{"id":"986168","name":"Văn Bàn"}]},
          {a:[{"id":"986219","name":"Bến Lức"},{"id":"986223","name":"Cần Giuộc"},{"id":"986221","name":"Cần Đước"},{"id":"986217","name":"Châu Thành"},{"id":"986216","name":"Chợ Tân An"},{"id":"986220","name":"Gò Đen"},{"id":"986225","name":"Hậu Nghĩa"},{"id":"986230","name":"Mộc Hóa"},{"id":"986222","name":"Rạch Kiến"},{"id":"986215","name":"Tân An"},{"id":"986232","name":"Tân Hưng"},{"id":"986229","name":"Tân Thạnh"},{"id":"986218","name":"Tân Trụ"},{"id":"986228","name":"Thạnh Hóa"},{"id":"986224","name":"Thủ Thừa"},{"id":"986231","name":"Vĩnh Hưng"},{"id":"986226","name":"Đức Hòa"},{"id":"986227","name":"Đức Huệ"}]},
          {a:[{"id":"986311","name":"Anh Sơn"},{"id":"986339","name":"Ba Bến"},{"id":"986281","name":"Bảo Nham"},{"id":"986235","name":"Bến Thủy"},{"id":"986249","name":"Bình Minh"},{"id":"986283","name":"Bưu Cục 1/5"},{"id":"986315","name":"Cây Chanh"},{"id":"986260","name":"Cầu Bùng"},{"id":"986302","name":"Cầu Khuôn"},{"id":"986319","name":"Cánh Tráp"},{"id":"986248","name":"Cảng"},{"id":"986341","name":"Ch ợ Phuống"},{"id":"986298","name":"Châu Bình"},{"id":"986332","name":"Chín Nam"},{"id":"986337","name":"Chơ Chùa"},{"id":"986343","name":"Chơ Cồn"},{"id":"986261","name":"Chợ Dàn"},{"id":"986335","name":"Chợ Giang"},{"id":"986271","name":"Chợ Ngò"},{"id":"986329","name":"Chơ Vac"},{"id":"986314","name":"Chợ Dừa"},{"id":"986242","name":"Chợ Ga"},{"id":"986336","name":"Chợ Giăng"},{"id":"986287","name":"Chợ Mới"},{"id":"986340","name":"Chợ Rộ"},{"id":"986250","name":"Chợ Sơn"},{"id":"986304","name":"Chợ Trung"},{"id":"986270","name":"Chợ Tuần"},{"id":"986316","name":"Con Cuông"},{"id":"986280","name":"Công Thành"},{"id":"986246","name":"Cửa Lò"},{"id":"986240","name":"Cửa Bắc"},{"id":"986257","name":"Cửa Hội"},{"id":"986265","name":"Diễn An"},{"id":"986258","name":"Diễn Châu"},{"id":"986263","name":"Diễn Lộc"},{"id":"986262","name":"Diễn Xuân"},{"id":"986264","name":"Diễn An"},{"id":"986303","name":"Giang Sơn"},{"id":"986338","name":"Hạnh Lâm"},{"id":"986276","name":"Hậu thành"},{"id":"986251","name":"Hải Hòa"},{"id":"986268","name":"Hoàng Mai"},{"id":"986274","name":"Hợp Thành"},{"id":"986326","name":"Hưng Châu"},{"id":"986237","name":"Hưng Dũng"},{"id":"986238","name":"Hưng Lôc"},{"id":"986324","name":"Hưng Nguyên"},{"id":"986325","name":"Hưng Xá"},{"id":"986269","name":"Kcn Hoàng Mai"},{"id":"986313","name":"Khai Sơn"},{"id":"986320","name":"Khe Bố"},{"id":"986317","name":"Khe Choăng"},{"id":"986322","name":"Khe Nằn"},{"id":"986333","name":"Kim Liên"},{"id":"986321","name":"Kỳ Sơn"},{"id":"986247","name":"Lan Châu"},{"id":"986312","name":"Lĩnh Sơn"},{"id":"986331","name":"Nam Anh"},{"id":"986323","name":"Nậm Cắn"},{"id":"986330","name":"Nam Giang"},{"id":"986305","name":"Nam Sơn"},{"id":"986327","name":"Nam Đàn"},{"id":"986255","name":"Nghi Liên"},{"id":"986252","name":"Nghi Lộc"},{"id":"986254","name":"Nghi Mü"},{"id":"986256","name":"Nghi Thái"},{"id":"986253","name":"Nghi Thạch"},{"id":"986285","name":"Nghĩa Hiếu"},{"id":"986289","name":"Nghĩa hợp"},{"id":"986286","name":"Nghĩa An"},{"id":"986284","name":"Nghĩa Minh"},{"id":"986342","name":"Nguyêt Bổng"},{"id":"986300","name":"Phú Phương"},{"id":"986245","name":"Phương Hoàng"},{"id":"986310","name":"Quang Sơn"},{"id":"986241","name":"Quán Bàu"},{"id":"986239","name":"Quán Bánh"},{"id":"986294","name":"Quán Dinh"},{"id":"986299","name":"Quế Phong"},{"id":"986295","name":"Quỳ Châu"},{"id":"986292","name":"Quỳ Hợp"},{"id":"986266","name":"Quỳnh Lưu"},{"id":"986272","name":"Quỳnh Lương"},{"id":"986267","name":"Quỳnh Xuân"},{"id":"986297","name":"Ta Chum"},{"id":"986291","name":"Tân An"},{"id":"986288","name":"Tân Kỳ"},{"id":"986290","name":"Tân phú"},{"id":"986277","name":"Tây Thành"},{"id":"986282","name":"Thái Hòa Nghĩa Đàn"},{"id":"986334","name":"Thanh Chương"},{"id":"986307","name":"Thuận Sơn"},{"id":"986309","name":"Trù Sơn"},{"id":"986233","name":"Trung tâm Vinh"},{"id":"986278","name":"Trung Thành"},{"id":"986318","name":"Tương Dương"},{"id":"986279","name":"Vân Tụ"},{"id":"986308","name":"Xuân Bài"},{"id":"986328","name":"Xuân Hòa"},{"id":"986259","name":"Yên Lý"},{"id":"986273","name":"Yên Thành"},{"id":"986306","name":"Đà Sơn"},{"id":"986234","name":"Đại Học Vinh"},{"id":"986301","name":"Đô Lương"},{"id":"986275","name":"Đô thành"},{"id":"986243","name":"Đôi Cung"},{"id":"986293","name":"Đồng Nai"},{"id":"986244","name":"Đông Vĩnh"},{"id":"986296","name":"Đò Ham"},{"id":"986236","name":"Đường 3-2"}]},
          {a:[{"id":"986351","name":"Bích Động"},{"id":"986367","name":"Bình Minh"},{"id":"986352","name":"Cầu Yên"},{"id":"986363","name":"Chợ Bút"},{"id":"986369","name":"Chợ Cát"},{"id":"986370","name":"Chợ Xanh"},{"id":"986345","name":"Ga"},{"id":"986353","name":"Gia Viễn"},{"id":"986354","name":"Gián"},{"id":"986349","name":"Hoa Lư"},{"id":"986372","name":"Khánh Nhạc"},{"id":"986371","name":"Khánh Phú"},{"id":"986364","name":"Kim Sơn"},{"id":"986355","name":"Nho Quan"},{"id":"986347","name":"Phúc Khánh"},{"id":"986365","name":"Quy Hậu"},{"id":"986346","name":"Quỳnh Sơn"},{"id":"986357","name":"Rịa"},{"id":"986358","name":"Tam Điệp"},{"id":"986348","name":"Tân Thành"},{"id":"986362","name":"Thanh Sơn"},{"id":"986350","name":"Trường Yên"},{"id":"986344","name":"Ttâm GD Ninh Bình"},{"id":"986356","name":"Ỷ Na"},{"id":"986366","name":"Yên Hoà"},{"id":"986368","name":"Yên Khánh"},{"id":"986360","name":"Yên Mô"},{"id":"986361","name":"Yên Phong"},{"id":"986359","name":"Đền Dâu"}]},
          {a:[{"id":"986374","name":"16 tháng 4"},{"id":"986381","name":"Bác Ái"},{"id":"986390","name":"Bắc Phong"},{"id":"986375","name":"Bình Sơn"},{"id":"986388","name":"Cà Ná"},{"id":"986380","name":"Hộ Hải"},{"id":"986377","name":"Hùng Vương"},{"id":"986386","name":"Long Bình"},{"id":"986379","name":"Nhơn Hải"},{"id":"986383","name":"Nhơn Sơn"},{"id":"986378","name":"Ninh Hải"},{"id":"986385","name":"Ninh Phước"},{"id":"986382","name":"Ninh Sơn"},{"id":"986373","name":"Phan Rang Tháp Chàm"},{"id":"986389","name":"Phước Diêm"},{"id":"986387","name":"Quán Thẻ"},{"id":"986384","name":"Quảng Sơn"},{"id":"986376","name":"Tháp Chàm"},{"id":"986391","name":"Thuận Bắc"}]},
          {a:[{"id":"986393","name":"B Phẩm K Thác"},{"id":"986411","name":"Cẩm Khê"},{"id":"986405","name":"Cổ Tiết"},{"id":"986410","name":"Hạ Hòa"},{"id":"986407","name":"Hoàng Xá"},{"id":"986400","name":"Lâm Thao"},{"id":"986396","name":"Nông Trang"},{"id":"986403","name":"Phú Hộ"},{"id":"986399","name":"Phù Ninh"},{"id":"986402","name":"Phú Thọ"},{"id":"986404","name":"Tam Nông"},{"id":"986395","name":"Tân Dân"},{"id":"986414","name":"Tân Sơn"},{"id":"986409","name":"Thanh Ba"},{"id":"986413","name":"Thanh Sơn"},{"id":"986406","name":"Thanh Thủy"},{"id":"986394","name":"Tiên Cát"},{"id":"986401","name":"Tiên Kiên"},{"id":"986397","name":"Vân Cơ"},{"id":"986392","name":"Việt Trì"},{"id":"986412","name":"Yên Lập"},{"id":"986398","name":"Đền Hùng"},{"id":"986408","name":"Đoan Hùng"}]},
          {a:[{"id":"986425","name":"An Ninh Tây"},{"id":"986423","name":"An Phú"},{"id":"986422","name":"Bình Kiến"},{"id":"986430","name":"Bình Thạnh"},{"id":"986420","name":"Ga"},{"id":"986416","name":"Hệ 1"},{"id":"986445","name":"Hòa Thắng"},{"id":"986439","name":"Hòa Xuân"},{"id":"986426","name":"Hòa Đa"},{"id":"986418","name":"Hương Sen"},{"id":"986421","name":"Kỹ Thuật Công Nghiệp"},{"id":"986432","name":"La Hai"},{"id":"986435","name":"Ngân Điền"},{"id":"986419","name":"Nguyễn Huệ"},{"id":"986440","name":"Phú Hiệp"},{"id":"986444","name":"Phú Hòa"},{"id":"986441","name":"Phú Thứ"},{"id":"986434","name":"Sơn Hòa"},{"id":"986443","name":"Sơn Thành"},{"id":"986427","name":"Sông Cầu"},{"id":"986436","name":"Sông Hinh"},{"id":"986424","name":"Tuy An"},{"id":"986415","name":"Tuy Hòa"},{"id":"986417","name":"Tuy Hòa Huyện"},{"id":"986437","name":"VHX Ealy (Tân Lập)"},{"id":"986429","name":"Xuân Hải"},{"id":"986428","name":"Xuân Hòa"},{"id":"986433","name":"Xuân Phước"},{"id":"986442","name":"Đồng Bò"},{"id":"986438","name":"Đông Mỹ"},{"id":"986431","name":"Đồng Xuân"}]},
          {a:[{"id":"986478","name":"Áng Sơn"},{"id":"986449","name":"Bắc Lý I"},{"id":"986450","name":"Bắc Lý II"},{"id":"986455","name":"Bố Trạch"},{"id":"986463","name":"Chánh Hòa"},{"id":"986483","name":"Chợ Chè"},{"id":"986474","name":"Chợ Cuồi"},{"id":"986482","name":"Chợ Cưỡi"},{"id":"986471","name":"Chợ Gát"},{"id":"986487","name":"Chợ Mai"},{"id":"986468","name":"Chợ Sãi"},{"id":"986485","name":"Chợ Trạm"},{"id":"986477","name":"Cổ Hiền"},{"id":"986454","name":"Cộn"},{"id":"986479","name":"Dinh Mười"},{"id":"986453","name":"Ga"},{"id":"986447","name":"Hải Đình"},{"id":"986469","name":"Hoà Ninh"},{"id":"986481","name":"Lệ Thuỷ"},{"id":"986448","name":"Lộc Đại"},{"id":"986456","name":"Lý Hòa"},{"id":"986473","name":"Minh Cầm"},{"id":"986475","name":"Minh Hóa"},{"id":"986480","name":"Mỹ Trung"},{"id":"986484","name":"Mỹ Đức"},{"id":"986459","name":"Nam Gianh"},{"id":"986467","name":"Ngoạ Cương"},{"id":"986461","name":"Phong Nha"},{"id":"986462","name":"Phú Quý"},{"id":"986476","name":"Quảng Ninh"},{"id":"986465","name":"Quảng Thọ"},{"id":"986464","name":"Quảng Trạch"},{"id":"986466","name":"Roòn"},{"id":"986486","name":"Sen Thuỷ"},{"id":"986472","name":"Tân Ấp"},{"id":"986457","name":"Thanh Khê"},{"id":"986458","name":"Thọ Lộc"},{"id":"986452","name":"Thuận Lý"},{"id":"986460","name":"Troóc"},{"id":"986470","name":"Tuyên Hóa"},{"id":"986451","name":"Đ Học Quảng Bình"},{"id":"986446","name":"Đồng Hới"}]},
          {a:[{"id":"986530","name":"A Xờ"},{"id":"986494","name":"An Mỹ"},{"id":"986492","name":"An Xuân"},{"id":"986501","name":"Bà Bầu"},{"id":"986511","name":"Bắc Trà My"},{"id":"986502","name":"Bến Xe"},{"id":"986504","name":"Cầu Chìm"},{"id":"986534","name":"Cây Sanh"},{"id":"986535","name":"Chiên Đàn"},{"id":"986514","name":"Cửa Đại"},{"id":"986500","name":"Diêm Phổ"},{"id":"986503","name":"Duy Xuyên"},{"id":"986525","name":"Gia Cốc"},{"id":"986522","name":"Hà Nha"},{"id":"986523","name":"Hà Tân"},{"id":"986510","name":"Hiệp Đức"},{"id":"986512","name":"Hội An"},{"id":"986508","name":"Hương An"},{"id":"986489","name":"Huỳnh Thúc Kháng"},{"id":"986499","name":"KCN Tam Hiệp"},{"id":"986517","name":"KCN ĐNam-ĐNgọc"},{"id":"986498","name":"Khu Ktế mở Chu Lai"},{"id":"986505","name":"Kiểm Lâm"},{"id":"986513","name":"Lê Hồng Phong"},{"id":"986532","name":"Nam Giang"},{"id":"986490","name":"Nam Hùng Vương"},{"id":"986527","name":"Nam Trà My"},{"id":"986497","name":"Núi Thành"},{"id":"986491","name":"Phan Chu Trinh"},{"id":"986519","name":"Phong Thử"},{"id":"986533","name":"Phú Ninh"},{"id":"986526","name":"Phước Sơn"},{"id":"986507","name":"Quế Sơn"},{"id":"986529","name":"Quyết Thắng"},{"id":"986493","name":"T tâm K doanh Dvụ Tổng hợp"},{"id":"986488","name":"Tam Kỳ"},{"id":"986531","name":"Tây Giang"},{"id":"986495","name":"Thăng Bình"},{"id":"986496","name":"Tiên Phước"},{"id":"986506","name":"Trà Kiệu"},{"id":"986509","name":"Trung Phước"},{"id":"986521","name":"Đại Lộc"},{"id":"986524","name":"Đại Minh"},{"id":"986515","name":"Điện Bàn"},{"id":"986518","name":"Điện Ngọc"},{"id":"986516","name":"Điện Phương"},{"id":"986520","name":"Điện Thắng"},{"id":"986528","name":"Đông Giang"}]},
          {a:[{"id":"986549","name":"Ba Tơ"},{"id":"986541","name":"Bình Sơn"},{"id":"986542","name":"Khu KTế Dung Quất"},{"id":"986538","name":"Lý Sơn"},{"id":"986548","name":"Minh Long"},{"id":"986552","name":"Mộ Đức"},{"id":"986547","name":"Nghĩa Hành"},{"id":"986536","name":"Quảng Ngãi"},{"id":"986537","name":"Quang Trung"},{"id":"986551","name":"Sa Huỳnh"},{"id":"986545","name":"Sơn Hà"},{"id":"986540","name":"Sơn Mỹ"},{"id":"986546","name":"Sơn Tây"},{"id":"986539","name":"Sơn Tịnh"},{"id":"986555","name":"Sông Vệ"},{"id":"986544","name":"Tây Trà"},{"id":"986553","name":"Thạch Trụ"},{"id":"986543","name":"Trà Bồng"},{"id":"986554","name":"Tư Nghĩa"},{"id":"986550","name":"Đức Phổ"}]},
          {a:[{"id":"986570","name":"Ba Chẽ"},{"id":"986571","name":"Bình Liêu"},{"id":"986562","name":"Cẩm Phả"},{"id":"986577","name":"Cây số 11"},{"id":"986568","name":"Cô Tô"},{"id":"986563","name":"Cọc 6"},{"id":"986557","name":"Cột 5"},{"id":"986564","name":"Cửa Ông"},{"id":"986559","name":"Hà Lầm"},{"id":"986560","name":"Hạ Long"},{"id":"986558","name":"Hà Tu"},{"id":"986573","name":"Hải Hà"},{"id":"986575","name":"Hoành Bồ"},{"id":"986556","name":"Hòn Gai"},{"id":"986561","name":"Kênh Đồng"},{"id":"986583","name":"Mạo Khê"},{"id":"986574","name":"Móng Cái"},{"id":"986565","name":"Mông Dương"},{"id":"986580","name":"Nam Khê"},{"id":"986581","name":"Phương Đông"},{"id":"986566","name":"Quang Hanh"},{"id":"986569","name":"Tiên Yên"},{"id":"986578","name":"Uông Bí"},{"id":"986567","name":"Vân Đồn"},{"id":"986579","name":"Vàng Danh"},{"id":"986576","name":"Yên Hưng"},{"id":"986572","name":"Đầm Hà"},{"id":"986582","name":"Đông Triều"}]},
          {a:[{"id":"986588","name":"Bến Quan"},{"id":"986597","name":"Bồ Bản"},{"id":"986590","name":"Cam Lộ"},{"id":"986592","name":"Chợ Cùa"},{"id":"986589","name":"Chợ Do"},{"id":"986586","name":"Gio Linh"},{"id":"986599","name":"Hải Lăng"},{"id":"986593","name":"Hướng Hoá"},{"id":"986594","name":"Lao Bảo"},{"id":"986585","name":"Lương An"},{"id":"986591","name":"Tân Lâm"},{"id":"986596","name":"Triệu Phong"},{"id":"986598","name":"TX Quảng Trị"},{"id":"986587","name":"Vĩnh Linh"},{"id":"986595","name":"Đakrông"},{"id":"986584","name":"Đông Hà"}]},
          {a:[{"id":"986608","name":"An Trạch"},{"id":"986600","name":"BC TP Sóc Trăng"},{"id":"986615","name":"Cù Lao Dung"},{"id":"986605","name":"Kế Sách"},{"id":"986604","name":"Kinh Ba"},{"id":"986603","name":"Lịch Hội Thượng"},{"id":"986601","name":"Long phú"},{"id":"986607","name":"Mỹ Tú"},{"id":"986611","name":"Mỹ Xuyên"},{"id":"986616","name":"Ngã Năm"},{"id":"986612","name":"Thạnh Phú"},{"id":"986613","name":"Thạnh Quới"},{"id":"986610","name":"Thạnh Trị"},{"id":"986606","name":"Thới an Hội"},{"id":"986609","name":"Thuận Hoà"},{"id":"986614","name":"Vĩnh Châu"},{"id":"986602","name":"Đại Ngãi"}]},
          {a:[{"id":"986625","name":"Ân Sinh"},{"id":"986637","name":"Bắc Yên"},{"id":"986623","name":"Bó Ẩn"},{"id":"986618","name":"Cầu 308"},{"id":"986621","name":"Chiềng An"},{"id":"986644","name":"Chiềng Khương"},{"id":"986620","name":"Chiềng Lề"},{"id":"986624","name":"Chiềng Sinh"},{"id":"986634","name":"Chiềng Ve"},{"id":"986628","name":"Cò Nòi"},{"id":"986636","name":"Gia Phù"},{"id":"986627","name":"Mai Sơn"},{"id":"986632","name":"Mộc Châu"},{"id":"986640","name":"Mường Bú"},{"id":"986638","name":"Mường La"},{"id":"986619","name":"Nà Cóong"},{"id":"986629","name":"Nà Sản"},{"id":"986631","name":"Phiêng Khoài"},{"id":"986635","name":"Phù Yên"},{"id":"986622","name":"Quyết Thắng"},{"id":"986641","name":"Quỳnh Nhai"},{"id":"986617","name":"Sơn La"},{"id":"986643","name":"Sông Mã"},{"id":"986645","name":"Sốp Cộp"},{"id":"986633","name":"Thảo Nguyên"},{"id":"986642","name":"Thuận Châu"},{"id":"986639","name":"Thủy Điện"},{"id":"986630","name":"Yên Châu"},{"id":"986626","name":"ĐH Tây Bắc"}]},
          {a:[{"id":"986651","name":"Bàu Năng"},{"id":"986663","name":"Bến Cầu"},{"id":"986657","name":"Châu Thành"},{"id":"986661","name":"Cửa số 2"},{"id":"986650","name":"Dương Minh Châu"},{"id":"986666","name":"Gò Dầu"},{"id":"986647","name":"Hiệp Ninh"},{"id":"986660","name":"Hoà Thành"},{"id":"986668","name":"KCN Trảng Bàng"},{"id":"986665","name":"Khẩu Mộc Bài"},{"id":"986669","name":"Linh Trung 3"},{"id":"986664","name":"Long Thuận"},{"id":"986662","name":"Mít Một"},{"id":"986656","name":"Mỏ Công"},{"id":"986648","name":"Ninh Sơn"},{"id":"986649","name":"Phường 1"},{"id":"986654","name":"Tân Biên"},{"id":"986652","name":"Tân Châu"},{"id":"986655","name":"Tân Lập"},{"id":"986653","name":"Tân Đông"},{"id":"986658","name":"Thái Bình"},{"id":"986659","name":"Thành Long"},{"id":"986667","name":"Trảng Bàng"},{"id":"986646","name":"Trung tâm khai thác vận chuyển"}]},
          {a:[{"id":"986675","name":"An Lễ"},{"id":"986682","name":"Bến Hiệp"},{"id":"986692","name":"Bồng Tiên"},{"id":"986679","name":"Cầu Cau"},{"id":"986684","name":"Cầu Vật"},{"id":"986673","name":"Châu Giang"},{"id":"986677","name":"Chợ Gành"},{"id":"986696","name":"Chợ Gốc"},{"id":"986694","name":"Chợ Lụ"},{"id":"986690","name":"Chợ Mễ"},{"id":"986687","name":"Chợ Nhội"},{"id":"986695","name":"Chợ Sóc"},{"id":"986680","name":"Chợ Tây"},{"id":"986686","name":"Cống Rút"},{"id":"986685","name":"Hưng Hà"},{"id":"986688","name":"Hưng Nhân"},{"id":"986700","name":"Hướng Tân"},{"id":"986699","name":"Kênh Xuyên"},{"id":"986693","name":"Kiến Xương"},{"id":"986681","name":"Quỳnh Phụ"},{"id":"986691","name":"Tân Đệ"},{"id":"986670","name":"Thái Bình"},{"id":"986676","name":"Thái Thụy"},{"id":"986678","name":"Thụy Phong"},{"id":"986697","name":"Tiền Hải"},{"id":"986674","name":"Tiên Hưng"},{"id":"986701","name":"Trung Đồng"},{"id":"986683","name":"Tư Môi"},{"id":"986689","name":"Vũ Thư"},{"id":"986698","name":"Đồng Châu"},{"id":"986671","name":"Đông Hưng"},{"id":"986672","name":"Đống Năm"}]},
          {a:[{"id":"986714","name":"Giang Tiên"},{"id":"986712","name":"La Hiên"},{"id":"986708","name":"Lưu xá"},{"id":"986704","name":"Mỏ Bạch"},{"id":"986718","name":"Phổ Yên"},{"id":"986720","name":"Phú Bình"},{"id":"986713","name":"Phú Lương"},{"id":"986707","name":"Phú Xá"},{"id":"986703","name":"Quán Triều"},{"id":"986710","name":"Quán Vuông"},{"id":"986717","name":"Sông Công"},{"id":"986702","name":"Thái Nguyên"},{"id":"986719","name":"Thanh Xuyên"},{"id":"986705","name":"Thịnh Đán"},{"id":"986711","name":"Võ Nhai"},{"id":"986716","name":"Đại Từ"},{"id":"986715","name":"Định Hóa"},{"id":"986709","name":"Đồng Hỷ"},{"id":"986706","name":"Đồng Quang"}]},
          {a:[{"id":"986756","name":"Ba Chè"},{"id":"986768","name":"Bá Thước"},{"id":"986730","name":"Ba Voi"},{"id":"986751","name":"Bỉm Sơn"},{"id":"986761","name":"Bồng Trung"},{"id":"986721","name":"BĐ Trung tâm"},{"id":"986765","name":"Cẩm Thủy"},{"id":"986750","name":"Cầu Cừ"},{"id":"986793","name":"Cầu Quan"},{"id":"986737","name":"Cầu Tào"},{"id":"986801","name":"Chợ Ghép"},{"id":"986803","name":"Chợ kho"},{"id":"986799","name":"Chợ Môi"},{"id":"986781","name":"Chợ Neo"},{"id":"986774","name":"Chợ Nưa"},{"id":"986743","name":"Chợ Phủ"},{"id":"986777","name":"Chợ Sánh"},{"id":"986773","name":"Chợ Sim"},{"id":"986794","name":"Chợ Trầu"},{"id":"986738","name":"Chợ Vực"},{"id":"986772","name":"Chợ Đà"},{"id":"986755","name":"Chợ Đu"},{"id":"986791","name":"Cửa Đạt"},{"id":"986732","name":"Ga Thanh Hoá"},{"id":"986748","name":"Hà Trung"},{"id":"986726","name":"Hàm Rồng"},{"id":"986739","name":"Hậu Lộc"},{"id":"986722","name":"Hệ 1"},{"id":"986741","name":"Hoa Lộc"},{"id":"986735","name":"Hoằng Hóa"},{"id":"986747","name":"Hói Đào"},{"id":"986758","name":"Kiểu"},{"id":"986731","name":"Lai Thành"},{"id":"986752","name":"Lam Sơn"},{"id":"986785","name":"Lang Chánh"},{"id":"986745","name":"Mai An Tiêm"},{"id":"986804","name":"Mai Lâm"},{"id":"986740","name":"Minh Lộc"},{"id":"986784","name":"Minh Tiến"},{"id":"986779","name":"Mục Sơn"},{"id":"986789","name":"Mường Lát"},{"id":"986788","name":"Na Mèo"},{"id":"986746","name":"Nga Nhân"},{"id":"986744","name":"Nga Sơn"},{"id":"986805","name":"Nghi Sơn"},{"id":"986736","name":"Nghĩa Trang"},{"id":"986782","name":"Ngọc Lặc"},{"id":"986796","name":"Như Thanh"},{"id":"986797","name":"Như Xuân"},{"id":"986792","name":"Nông Cống"},{"id":"986766","name":"Phố Vạc"},{"id":"986783","name":"Phố Xi"},{"id":"986728","name":"Phú Sơn"},{"id":"986767","name":"Phúc Do"},{"id":"986786","name":"Quan Hóa"},{"id":"986787","name":"Quan Sơn"},{"id":"986734","name":"Quảng Tiến"},{"id":"986798","name":"Quảng Xương"},{"id":"986733","name":"Sầm Sơn"},{"id":"986780","name":"Sao Vàng"},{"id":"986723","name":"T.Tâm DVKH"},{"id":"986764","name":"Thạch Quảng"},{"id":"986762","name":"Thạch Thành"},{"id":"986754","name":"Thiệu Hóa"},{"id":"986775","name":"Thọ Xuân"},{"id":"986759","name":"Thống nhất"},{"id":"986790","name":"Thường Xuân"},{"id":"986725","name":"Tiếp Thị BánHàng"},{"id":"986802","name":"Tĩnh Gia"},{"id":"986771","name":"Triệu Sơn"},{"id":"986727","name":"Trung Tâm CNTT"},{"id":"986795","name":"Trường sơn"},{"id":"986778","name":"Tứ Trụ"},{"id":"986763","name":"Vân Du"},{"id":"986800","name":"Văn Trinh"},{"id":"986760","name":"Vĩnh Lộc"},{"id":"986776","name":"Xuân Lai"},{"id":"986757","name":"Yên Định"},{"id":"986742","name":"Đại Lộc"},{"id":"986770","name":"Điền Lư"},{"id":"986749","name":"Đò Lèn"},{"id":"986724","name":"Đội Cung"},{"id":"986753","name":"Đông Sơn"},{"id":"986769","name":"Đồng Tâm"},{"id":"986729","name":"Đông Vệ"}]},
          {a:[{"id":"986885","name":"An Hữu"},{"id":"986878","name":"Ba Dừa"},{"id":"986850","name":"Bến Tranh"},{"id":"986876","name":"Bình Phú"},{"id":"986859","name":"Bình Đông"},{"id":"986869","name":"Bình Đức"},{"id":"986880","name":"Cái Bè"},{"id":"986872","name":"Cai Lậy"},{"id":"986865","name":"Châu Thành"},{"id":"986847","name":"Chợ Gạo"},{"id":"986842","name":"Chợ Mỹ Tho"},{"id":"986867","name":"Dưỡng Điềm"},{"id":"986852","name":"Gò Công Tây"},{"id":"986860","name":"Gò Công Đông"},{"id":"986882","name":"Hòa Khánh"},{"id":"986857","name":"Long Bình"},{"id":"986866","name":"Long Định"},{"id":"986874","name":"Mỹ Phước Tây"},{"id":"986841","name":"Mỹ Tho"},{"id":"986843","name":"Mỹ Tho 2"},{"id":"986883","name":"Mỹ Đức Tây"},{"id":"986873","name":"Nhị Quý"},{"id":"986871","name":"Phú Mỹ"},{"id":"986864","name":"Phú Đông"},{"id":"986879","name":"Tam Bình"},{"id":"986846","name":"Tân Mỹ Chánh"},{"id":"986877","name":"Tân Phong"},{"id":"986870","name":"Tân Phước"},{"id":"986856","name":"Tân Phú"},{"id":"986863","name":"Tân Tây"},{"id":"986884","name":"Tân Thanh"},{"id":"986861","name":"Tân Thành"},{"id":"986848","name":"Thanh Bình"},{"id":"986875","name":"Thạnh Lộc"},{"id":"986855","name":"Thạnh Nhựt"},{"id":"986853","name":"Thành Công"},{"id":"986858","name":"Thị xã Gò Công"},{"id":"986881","name":"Thiên Hộ"},{"id":"986849","name":"Thủ Khoa Huân"},{"id":"986845","name":"Trung Lương"},{"id":"986862","name":"Vàm Láng"},{"id":"986868","name":"Vĩnh Kim"},{"id":"986851","name":"Xuân Đông"},{"id":"986844","name":"Yersin"},{"id":"986854","name":"Đồng Sơn"}]},
          {a:[{"id":"986928","name":"Cầu Chà"},{"id":"986941","name":"Chiêm Hóa"},{"id":"986938","name":"Chợ Xoan"},{"id":"986947","name":"Hàm Yên"},{"id":"986948","name":"Ki lô mét 31"},{"id":"986939","name":"Kim Xuyên"},{"id":"986945","name":"Lăng Can"},{"id":"986934","name":"Lưỡng Vượng"},{"id":"986926","name":"Minh Xuân"},{"id":"986933","name":"Mỹ Lâm"},{"id":"986943","name":"Na Hang"},{"id":"986929","name":"Nông Tiến"},{"id":"986927","name":"Phan Thiết"},{"id":"986936","name":"Sơn Dương"},{"id":"986940","name":"Sơn Nam"},{"id":"986937","name":"Tân Trào"},{"id":"986935","name":"Thái Long"},{"id":"986944","name":"Thượng Lâm"},{"id":"986932","name":"Trung Môn"},{"id":"986924","name":"Tuyên Quang"},{"id":"986931","name":"Xuân Vân"},{"id":"986930","name":"Ỷ La"},{"id":"986946","name":"Yên Hoa"},{"id":"986925","name":"Yên Sơn"},{"id":"986942","name":"Đầm Hồng"}]},
          {a:[{"id":"986957","name":"Ba Càng"},{"id":"986959","name":"Bình Minh"},{"id":"986967","name":"Bình Tân"},{"id":"986965","name":"Cầu Mới"},{"id":"986955","name":"Cầu Đôi"},{"id":"986964","name":"Hiếu Phụng"},{"id":"986962","name":"Hựu Thành"},{"id":"986954","name":"KCN Hòa Phú"},{"id":"986953","name":"Long Hồ"},{"id":"986966","name":"Mang Thít"},{"id":"986958","name":"Mỹ Lộc"},{"id":"986950","name":"Nguyễn Huệ"},{"id":"986952","name":"Phước Thọ"},{"id":"986956","name":"Tam Bình"},{"id":"986968","name":"Tân Lược"},{"id":"986951","name":"Tân Ngãi 2"},{"id":"986960","name":"Trà Ôn"},{"id":"986949","name":"Vĩnh Long"},{"id":"986961","name":"Vĩnh Xuân"},{"id":"986963","name":"Vũng Liêm"}]},
          {a:[{"id":"986976","name":"Bến Then"},{"id":"986971","name":"Bình Xuyên"},{"id":"986974","name":"Lập Thạch"},{"id":"986975","name":"Liễn Sơn"},{"id":"986980","name":"Phúc Yên"},{"id":"986972","name":"Quang Hà"},{"id":"986973","name":"Tam Dương"},{"id":"986983","name":"Tam Đảo"},{"id":"986978","name":"Thổ Tang"},{"id":"986969","name":"TP Vĩnh Yên"},{"id":"986981","name":"Trưng Trắc"},{"id":"986977","name":"Vĩnh Tường"},{"id":"986982","name":"Xuân Hoà"},{"id":"986979","name":"Yên Lạc"},{"id":"986970","name":"Đồng Tâm"}]},
          {a:[{"id":"987004","name":"Ba Khe"},{"id":"986993","name":"Cẩm Ân"},{"id":"986991","name":"Cát Lem"},{"id":"986998","name":"Hợp Minh"},{"id":"986999","name":"Hưng Khánh"},{"id":"986995","name":"Khánh Hòa"},{"id":"986994","name":"Lục Yên"},{"id":"986985","name":"Minh Tân"},{"id":"987008","name":"Mù Cang Chải"},{"id":"987005","name":"Mỵ"},{"id":"986987","name":"Nam Cường"},{"id":"987006","name":"Nghĩa Lộ"},{"id":"986997","name":"Ngòi Hóp"},{"id":"987009","name":"Púng Luông"},{"id":"986992","name":"Thác Bà"},{"id":"987003","name":"Thái Lão"},{"id":"987001","name":"Trái Hút"},{"id":"987007","name":"Trạm Tấu"},{"id":"986996","name":"Trấn Yên"},{"id":"986989","name":"Trung tâm T.phố"},{"id":"987002","name":"Văn Chấn"},{"id":"987000","name":"Văn Yên"},{"id":"986984","name":"Yên Bái Ga"},{"id":"986986","name":"Yên Bái km5"},{"id":"986990","name":"Yên Bình"},{"id":"986988","name":"Yên Hòa"}]},
          {a:[{"id":"985152","name":"Buôn Đôn"},{"id":"985130","name":"ChuyểnPhát Nhanh"},{"id":"985148","name":"Cư Pao"},{"id":"985160","name":"Cưkuin"},{"id":"985144","name":"Cưmgar"},{"id":"985150","name":"Ea Toh"},{"id":"985151","name":"EaHleo"},{"id":"985141","name":"EaKar"},{"id":"985137","name":"Eakly"},{"id":"985142","name":"EaKnốp"},{"id":"985138","name":"EaQuang"},{"id":"985153","name":"EaSup"},{"id":"985131","name":"EaTam"},{"id":"985125","name":"Giao dịch TT BMT"},{"id":"985147","name":"Hà Lan"},{"id":"985155","name":"Hoà hiệp"},{"id":"985133","name":"Hoà Khánh"},{"id":"985134","name":"Hòa Phú"},{"id":"985132","name":"Hoà thắng"},{"id":"985129","name":"Hòa Thuận"},{"id":"985135","name":"Hòa Đông"},{"id":"985159","name":"Huyện Lắk"},{"id":"985127","name":"Km3"},{"id":"985128","name":"KM5"},{"id":"985158","name":"Krông Bông"},{"id":"985145","name":"Krông Buk"},{"id":"985154","name":"Krông na"},{"id":"985149","name":"Krông năng"},{"id":"985136","name":"Krông Pắc"},{"id":"985143","name":"MDrắk"},{"id":"985126","name":"Phan Bội Châu"},{"id":"985146","name":"Pơng Drang"},{"id":"985139","name":"Tân Tiến"},{"id":"985157","name":"Trung Hòa"},{"id":"985156","name":"Việt đức 4"},{"id":"985140","name":"Vụ Bổn"}]},
          {a:[{"id":"985166","name":"Cư Jút"},{"id":"985165","name":"Krông Nô"},{"id":"985168","name":"Tuy Đức"},{"id":"985167","name":"Đăk Glong"},{"id":"985164","name":"Đăk Mil"},{"id":"985161","name":"Đăk Nông"},{"id":"985162","name":"Đăk Rlấp"},{"id":"985163","name":"Đăk Song"}]},
          {a:[{"id":"985117","name":"Bản Phủ"},{"id":"985112","name":"Him Lam"},{"id":"985124","name":"Mường Ảng"},{"id":"985120","name":"Mường Chà"},{"id":"985122","name":"Mường Lay"},{"id":"985123","name":"Mường Nhé"},{"id":"985115","name":"Noong Bua"},{"id":"985113","name":"Thanh Bình"},{"id":"985114","name":"Thanh Trường"},{"id":"985121","name":"Tủa Chùa"},{"id":"985119","name":"Tuần Giáo"},{"id":"985116","name":"Điện Biên"},{"id":"985111","name":"Điện Biên Phủ"},{"id":"985118","name":"Điện Biên Đông"}]},
          {a:[{"id":"985439","name":"Bắc Sơn"},{"id":"985434","name":"Bảo Bình"},{"id":"985413","name":"Bảo Hòa"},{"id":"985406","name":"BĐ H. Thống Nhất"},{"id":"985433","name":"BĐH Cẩm Mỹ"},{"id":"985404","name":"BĐH Long Khánh"},{"id":"985425","name":"BĐH Long Thành"},{"id":"985429","name":"BĐH Nhơn Trạch"},{"id":"985418","name":"BĐH Tân Phú"},{"id":"985436","name":"BĐH Trảng Bom"},{"id":"985422","name":"BĐH Vĩnh Cửu"},{"id":"985408","name":"BĐH Xuân Lộc"},{"id":"985414","name":"BĐH Định Quán"},{"id":"985399","name":"Chợ Đồn"},{"id":"985407","name":"Gia Kiệm"},{"id":"985395","name":"Hố Nai"},{"id":"985437","name":"Hố Nai 3"},{"id":"985400","name":"Hoá An"},{"id":"985432","name":"KCN Nhơn Trạch"},{"id":"985402","name":"Khu Công nghiệp"},{"id":"985415","name":"La Ngà"},{"id":"985403","name":"Long Bình Tân"},{"id":"985427","name":"Long Đức"},{"id":"985421","name":"Phú Bình"},{"id":"985417","name":"Phú Cường"},{"id":"985420","name":"Phú Lâm"},{"id":"985419","name":"Phú Lập"},{"id":"985416","name":"Phú Túc"},{"id":"985428","name":"Phước Thái"},{"id":"985430","name":"Phước Thiền"},{"id":"985398","name":"Quang Vinh"},{"id":"985393","name":"Quyết Thắng"},{"id":"985438","name":"Sông Mây"},{"id":"985435","name":"Sông Ray"},{"id":"985394","name":"Tam Hiệp"},{"id":"985426","name":"Tam Phước"},{"id":"985396","name":"Tân Tiến"},{"id":"985401","name":"Tân Vạn"},{"id":"985424","name":"Thạnh Phú"},{"id":"985397","name":"Trảng Dài"},{"id":"985392","name":"TT GD Biên hòa"},{"id":"985423","name":"Vĩnh Tân"},{"id":"985412","name":"Xuân Bắc"},{"id":"985410","name":"Xuân Hưng"},{"id":"985409","name":"Xuân Tâm"},{"id":"985405","name":"Xuân Tân"},{"id":"985411","name":"Xuân Trường 2"},{"id":"985431","name":"Đại Phước"},{"id":"985440","name":"Đông Hoà"}]},
          {a:[{"id":"985449","name":"An Long"},{"id":"985455","name":"An Phong"},{"id":"985464","name":"Châu Thành"},{"id":"985451","name":"Giồng Găng"},{"id":"985466","name":"H.Cao Lãnh"},{"id":"985452","name":"Hồng Ngự"},{"id":"985460","name":"Lai Vung"},{"id":"985457","name":"Lấp Vò"},{"id":"985467","name":"Mỹ Long"},{"id":"985463","name":"Nàng Hai"},{"id":"985465","name":"Nha Mân"},{"id":"985448","name":"Phú Hiệp"},{"id":"985443","name":"Phường 11"},{"id":"985441","name":"Phường 6"},{"id":"985462","name":"Sadec"},{"id":"985447","name":"Tam Nông"},{"id":"985450","name":"Tân Hồng"},{"id":"985458","name":"Tân Mỹ"},{"id":"985456","name":"Tân Quới"},{"id":"985461","name":"Tân Thành"},{"id":"985454","name":"Thanh Bình"},{"id":"985444","name":"Tháp Mười"},{"id":"985453","name":"Thường Thới"},{"id":"985442","name":"TP Cao Lãnh"},{"id":"985445","name":"Trường Xuân"},{"id":"985459","name":"Vĩnh Thạnh"},{"id":"985446","name":"Đường Thét"}]},
          {a:[{"id":"1517789","name":"Giao Thủy"},{"id":"1517790","name":"Hải Hậu"},{"id":"1517782","name":"Mỹ Lộc"},{"id":"1517784","name":"Nam Trực"},{"id":"1517780","name":"Nam Định"},{"id":"1517787","name":"Nghĩa Hưng"},{"id":"1517785","name":"Trực Ninh"},{"id":"1517783","name":"Vụ Bản"},{"id":"1517788","name":"Xuân Trường"},{"id":"1517786","name":"Ý Yên"}]},
          {a:[{"id":"985777","name":"Ba Vì"},{"id":"985748","name":"Bắc Linh Đàm"},{"id":"985761","name":"Bắc Thăng Long"},{"id":"985721","name":"Bách Khoa"},{"id":"985737","name":"Bán Hàng 1"},{"id":"985757","name":"Bán Hàng Thanh Trì"},{"id":"985759","name":"Cao Lỗ"},{"id":"985750","name":"Cầu Diễn 2"},{"id":"985736","name":"Cầu Giấy"},{"id":"985723","name":"Chợ Mơ"},{"id":"985784","name":"Chương Mỹ"},{"id":"985741","name":"Ciputra"},{"id":"985753","name":"Cổ Nhuế"},{"id":"985728","name":"Cống Vị"},{"id":"985714","name":"Cửa Nam"},{"id":"985715","name":"Ga Hà Nội"},{"id":"985754","name":"Gia Lâm"},{"id":"985729","name":"Giảng Võ"},{"id":"985710","name":"Giao dịch 1"},{"id":"985718","name":"Giao Dich 5"},{"id":"985766","name":"Hà Đông"},{"id":"985769","name":"Hà Đông 2"},{"id":"985747","name":"Hai Bà Trưng"},{"id":"985717","name":"Hàng Vải"},{"id":"985772","name":"Hoài Đức"},{"id":"985739","name":"Hoàng Quốc Việt"},{"id":"985738","name":"Hoàng Sâm"},{"id":"985731","name":"Hùng Vương"},{"id":"985762","name":"KCN Thăng Long"},{"id":"985725","name":"Kim Liên"},{"id":"985727","name":"Láng Trung"},{"id":"985722","name":"Lò Đúc"},{"id":"985760","name":"Lộc Hà"},{"id":"985744","name":"Long Biên"},{"id":"985713","name":"Lương Văn Can"},{"id":"985765","name":"Mê Linh"},{"id":"985752","name":"Mỹ Đình 2"},{"id":"985788","name":"Mỹ Đức"},{"id":"985740","name":"Nghĩa Tân"},{"id":"985767","name":"Nguyễn Chánh"},{"id":"985719","name":"Nguyễn Công Trứ"},{"id":"985720","name":"Nguyễn Du"},{"id":"985735","name":"Nguyễn Quý Đức"},{"id":"985732","name":"Nguyễn Thái Học"},{"id":"985768","name":"Nguyễn Trãi"},{"id":"985779","name":"Nhông"},{"id":"985764","name":"Nội Bài"},{"id":"985771","name":"Phú Lãm"},{"id":"985789","name":"Phú Xuyên"},{"id":"985774","name":"Phúc Thọ"},{"id":"985730","name":"Quán Thánh"},{"id":"985783","name":"Quốc Oai"},{"id":"985711","name":"Quốc Tế"},{"id":"985746","name":"Sài Đồng"},{"id":"985763","name":"Sóc Sơn"},{"id":"985776","name":"Sơn Lộc"},{"id":"985775","name":"Sơn Tây"},{"id":"985780","name":"Suối Hai"},{"id":"985781","name":"Tản Lĩnh"},{"id":"985726","name":"Tây Sơn"},{"id":"985782","name":"Thạch Thất"},{"id":"985751","name":"Thăng long"},{"id":"985786","name":"Thanh Oai"},{"id":"985756","name":"Thanh Trì"},{"id":"985733","name":"Thanh Xuân"},{"id":"985734","name":"Thanh Xuân Bắc"},{"id":"985790","name":"Thường Tín"},{"id":"985712","name":"Tràng Tiền"},{"id":"985787","name":"Ứng Hòa"},{"id":"985770","name":"Văn Phú"},{"id":"985778","name":"Vạn Thắng"},{"id":"985785","name":"Xuân Mai"},{"id":"985743","name":"Yên Phụ"},{"id":"985742","name":"Yên Thái"},{"id":"985755","name":"Yên Viên"},{"id":"985773","name":"Đan Phượng"},{"id":"985749","name":"Định Công"},{"id":"985758","name":"Đông Anh"},{"id":"985716","name":"Đồng Xuân"},{"id":"985724","name":"Đống Đa"},{"id":"985745","name":"Đức Giang"}]},
          {a:[{"id":"985592","name":"An Dương"},{"id":"985597","name":"An Lão"},{"id":"985598","name":"An Tràng"},{"id":"985574","name":"Cảng Mới"},{"id":"985614","name":"Cát Hải"},{"id":"985585","name":"Cầu Giá"},{"id":"985577","name":"Cầu Tre"},{"id":"985603","name":"Cầu Đầm"},{"id":"985607","name":"Chợ Cầu"},{"id":"985591","name":"Chợ Hàng"},{"id":"985593","name":"Chợ Hỗ"},{"id":"985611","name":"Chợ Hương"},{"id":"985599","name":"Chợ kênh"},{"id":"985579","name":"Cửa Cấm"},{"id":"985570","name":"Gdich T Tâm K Thác V Chuyển"},{"id":"985616","name":"Hạ Lũng"},{"id":"985580","name":"Hàng Kênh"},{"id":"985568","name":"Hệ 1"},{"id":"985602","name":"Hoà Bình"},{"id":"985610","name":"Hoà Nghĩa"},{"id":"985615","name":"Hoà Quang"},{"id":"985575","name":"Hồng Bàng"},{"id":"985605","name":"Hùng Thắng"},{"id":"985595","name":"Kiến An"},{"id":"985609","name":"Kiến Thuỵ"},{"id":"985589","name":"Lê Chân"},{"id":"985584","name":"Minh Đức"},{"id":"985600","name":"Mỹ Đức"},{"id":"985608","name":"Nam Am"},{"id":"985617","name":"Nam Hải"},{"id":"985581","name":"Ng Bỉnh Khiêm"},{"id":"985576","name":"Ngô Quyền"},{"id":"985590","name":"Niệm Nghĩa"},{"id":"985561","name":"P. KDVTTH"},{"id":"985583","name":"Phả Lễ"},{"id":"985562","name":"Phòng KD BChính"},{"id":"985564","name":"Phòng Kế hoạch Kinh doanh"},{"id":"985566","name":"Phòng Kế toán thống kê tài chính"},{"id":"985571","name":"Phòng Kế toán Ttâm KTVC"},{"id":"985567","name":"Phòng Kỹ thuật nghiệp vụ"},{"id":"985563","name":"Phòng Tổ chức hành chính"},{"id":"985573","name":"Quán Toan"},{"id":"985596","name":"Quán Trữ"},{"id":"985586","name":"Quảng Thanh"},{"id":"985588","name":"Tân Hoa"},{"id":"985572","name":"Thượng Lý"},{"id":"985582","name":"Thuỷ Nguyên"},{"id":"985601","name":"Tiên Lãng"},{"id":"985594","name":"Tôn Đức Thắng"},{"id":"985559","name":"TP Hải phòng"},{"id":"985587","name":"Trịnh Xá"},{"id":"985565","name":"Ttâm KD Ptriển DV BĐ"},{"id":"985612","name":"Tú Sơn"},{"id":"985560","name":"V.Phòng BĐ T.Tâm"},{"id":"985569","name":"V.Phòng T.Tâm K thác VChuyển"},{"id":"985578","name":"Vạn Mỹ"},{"id":"985606","name":"Vĩnh Bảo"},{"id":"985613","name":"Đồ Sơn"},{"id":"985604","name":"Đông Quy"}]},
          {a:[{"id":"985939","name":"An Dương Vương"},{"id":"985859","name":"An Hội"},{"id":"985819","name":"An Khánh"},{"id":"985983","name":"An Lạc"},{"id":"985857","name":"An Nhơn"},{"id":"985882","name":"An Nhơn Tây"},{"id":"985883","name":"An Phú"},{"id":"985875","name":"An Sương"},{"id":"985818","name":"An Điền"},{"id":"985935","name":"An Đông"},{"id":"985920","name":"Bà Hạt"},{"id":"985979","name":"Bà Hom"},{"id":"985891","name":"Bà Quẹo"},{"id":"985874","name":"Bà Điểm"},{"id":"985848","name":"Bàn Cờ"},{"id":"985893","name":"Bàu Cát"},{"id":"985862","name":"Bàu Nai"},{"id":"985898","name":"Bảy Hiền"},{"id":"985911","name":"BChính Ủy Thác"},{"id":"985856","name":"Bến Cát"},{"id":"985812","name":"Bến Thành"},{"id":"985899","name":"Bình Chánh"},{"id":"985844","name":"Bình Chiểu"},{"id":"985909","name":"Bình Hưng"},{"id":"985975","name":"Bình Hưng Hoà"},{"id":"985969","name":"Bình Khánh"},{"id":"985888","name":"Bình Mỹ"},{"id":"985830","name":"Bình Thạnh"},{"id":"985837","name":"Bình Thọ"},{"id":"985977","name":"Bình Trị Đông"},{"id":"985839","name":"Bình Triệu"},{"id":"985821","name":"Bình Trưng"},{"id":"985945","name":"Bùi Minh Trực"},{"id":"985956","name":"Bùi Văn Ba"},{"id":"985967","name":"Bưu Cục 30/4"},{"id":"985976","name":"Bưu điện Bốn Xã"},{"id":"985964","name":"Cần Giờ"},{"id":"985965","name":"Cần Thạnh"},{"id":"985822","name":"Cát Lái"},{"id":"985903","name":"Cầu Xáng"},{"id":"985834","name":"Cầu Đỏ"},{"id":"985823","name":"Cây Dầu"},{"id":"985946","name":"Chánh Hưng"},{"id":"985889","name":"Chí Hòa"},{"id":"985905","name":"Chợ Bình Chánh"},{"id":"985824","name":"Chợ Nhỏ"},{"id":"985900","name":"Chợ Đệm"},{"id":"985877","name":"Củ Chi"},{"id":"985864","name":"Cviên Pmềm Qtrung"},{"id":"985943","name":"Dã Tượng"},{"id":"985910","name":"Datapost HCM"},{"id":"985897","name":"E.Town"},{"id":"985809","name":"G dịch Q Tế Sài Gòn"},{"id":"985906","name":"Ghi sê 2 Chợ BC"},{"id":"985808","name":"Giao dịch Sài Gòn"},{"id":"985973","name":"Gò Dầu"},{"id":"985855","name":"Gò Vấp"},{"id":"985835","name":"Hàng Xanh"},{"id":"985838","name":"Hiệp Bình Phước"},{"id":"985962","name":"Hiệp Phước"},{"id":"985866","name":"Hiệp Thành"},{"id":"985978","name":"Hồ Học Lãm"},{"id":"985936","name":"Hòa Bình"},{"id":"985966","name":"Hòa Hiệp"},{"id":"985914","name":"Hòa Hưng"},{"id":"985895","name":"Hoàng Hoa Thám"},{"id":"985937","name":"Hùng Vương"},{"id":"985948","name":"Khánh Hội"},{"id":"985842","name":"Khiết Tâm"},{"id":"985972","name":"Khu CN Tân Bình"},{"id":"985810","name":"Kthác bưuphẩm"},{"id":"985923","name":"Lạc Long Quân"},{"id":"985904","name":"Láng Le"},{"id":"985940","name":"Lê Hồng Phong"},{"id":"985902","name":"Lê Minh Xuân"},{"id":"985851","name":"Lê Văn Sỹ"},{"id":"985861","name":"Lê Văn Thọ"},{"id":"985840","name":"Linh Trung"},{"id":"985841","name":"Linh Xuân"},{"id":"985827","name":"Long Bình"},{"id":"985826","name":"Long Hòa"},{"id":"985961","name":"Long Thới"},{"id":"985921","name":"Lữ Gia"},{"id":"985892","name":"Lý Thường Kiệt"},{"id":"985928","name":"Minh Phụng"},{"id":"985984","name":"Mũi Tàu"},{"id":"985934","name":"Ng Duy Dương"},{"id":"985933","name":"Ng Tri Phương"},{"id":"985811","name":"Ng Đình Chiểu"},{"id":"985870","name":"Ngã Ba Bầu"},{"id":"985915","name":"Ngã Sáu Dân Chủ"},{"id":"985867","name":"Ngã Tư Ga"},{"id":"985919","name":"Ngô Gia Tự"},{"id":"985913","name":"Ngô Quyền"},{"id":"985836","name":"Ngô Tất Tố"},{"id":"985815","name":"Nguyễn Du"},{"id":"985949","name":"Nguyễn Khoái"},{"id":"985932","name":"Nguyễn Trãi"},{"id":"985849","name":"Nguyễn Văn Trỗi"},{"id":"985873","name":"Nhị Xuân"},{"id":"985833","name":"Nơ Trang Long"},{"id":"985930","name":"Phạm Văn Chí"},{"id":"985881","name":"Phạm Văn Cội"},{"id":"985894","name":"Phạm Văn Hai"},{"id":"985927","name":"Phó Cơ Điều"},{"id":"985908","name":"Phong Phú"},{"id":"985880","name":"Phú Hòa Đông"},{"id":"985929","name":"Phú Lâm"},{"id":"985954","name":"Phú Mỹ"},{"id":"985852","name":"Phú Nhuận"},{"id":"985912","name":"Phú Thọ"},{"id":"985974","name":"Phú Thọ Hòa"},{"id":"985963","name":"Phú Xuân"},{"id":"985828","name":"Phước Bình"},{"id":"985960","name":"Phước Kiển"},{"id":"985825","name":"Phước Long"},{"id":"985885","name":"Phước Thạnh"},{"id":"985813","name":"Quận 1"},{"id":"985918","name":"Quận 10"},{"id":"985925","name":"Quận 11"},{"id":"985846","name":"Quận 3"},{"id":"985947","name":"Quận 4"},{"id":"985938","name":"Quận 5"},{"id":"985931","name":"Quận 6"},{"id":"985953","name":"Quận 7"},{"id":"985944","name":"Quận 8"},{"id":"985863","name":"Quang Trung"},{"id":"985907","name":"Quy Đức"},{"id":"985941","name":"Rạch Ông"},{"id":"985916","name":"Sư Vạn Hạnh"},{"id":"985843","name":"Tam Bình"},{"id":"985890","name":"Tân Bình 2"},{"id":"985981","name":"Tân Kiên"},{"id":"985820","name":"Tân Lập"},{"id":"985957","name":"Tân Phong"},{"id":"985970","name":"Tân Phú"},{"id":"985886","name":"Tân Phú Trung"},{"id":"985958","name":"Tân Quy Đông"},{"id":"985896","name":"Tân Sơn Nhất"},{"id":"985980","name":"Tân Tạo"},{"id":"985865","name":"Tân Thới Hiệp"},{"id":"985868","name":"Tân Thới Nhất"},{"id":"985872","name":"Tân Thới Nhì"},{"id":"985951","name":"Tân Thuận"},{"id":"985955","name":"Tân Thuận Đông"},{"id":"985887","name":"Tân Trung"},{"id":"985817","name":"Tân Định"},{"id":"985971","name":"Tây Thạnh"},{"id":"985832","name":"Thanh Đa"},{"id":"985829","name":"Thị Nghè"},{"id":"985878","name":"Thị trấn Củ Chi"},{"id":"985959","name":"Thị trấn Nhà Bè"},{"id":"985854","name":"Thông Tây Hội"},{"id":"985845","name":"Thủ Đức"},{"id":"985917","name":"Tô Hiến Thành"},{"id":"985924","name":"Tôn Thất Hiệp"},{"id":"985950","name":"Tôn Đản"},{"id":"985814","name":"Trần Hưng Đạo"},{"id":"985926","name":"Trần Quý"},{"id":"985876","name":"Trung Chánh"},{"id":"985884","name":"Trung Lập"},{"id":"985860","name":"Trưng Nữ Vương"},{"id":"985869","name":"TT Hóc Môn"},{"id":"985982","name":"TTDVKH Bình Chánh"},{"id":"985879","name":"TTDVKH Củ Chi"},{"id":"985952","name":"TTDVKH Nam Sài Gòn"},{"id":"985850","name":"Tú Xương"},{"id":"985831","name":"Văn Thánh"},{"id":"985901","name":"Vĩnh Lộc"},{"id":"985847","name":"Vườn Xoài"},{"id":"985942","name":"Xóm Cũi"},{"id":"985858","name":"Xóm Mới"},{"id":"985816","name":"Đa Kao"},{"id":"985922","name":"Đầm Sen"},{"id":"985853","name":"Đông Ba"},{"id":"985968","name":"Đồng Hòa"},{"id":"985871","name":"Đông Thạnh"}]},
          {a:[{"id":"986895","name":"An Phú Tân"},{"id":"986906","name":"An Quảng Hữu"},{"id":"986890","name":"An Trường A"},{"id":"986892","name":"Bình Phú"},{"id":"986887","name":"Càng Long"},{"id":"986894","name":"Cầu Kè"},{"id":"986909","name":"Cầu Ngang"},{"id":"986900","name":"Cầu Quan"},{"id":"986901","name":"Châu Thành"},{"id":"986923","name":"Dân Thành"},{"id":"986916","name":"Duyên Hải"},{"id":"986915","name":"Hiệp Mỹ Tây"},{"id":"986914","name":"Hiệp Mỹ Đông"},{"id":"986918","name":"Hiệp Thạnh"},{"id":"986898","name":"Hiếu Tử"},{"id":"986902","name":"Hòa Minh"},{"id":"986911","name":"Kim Hòa"},{"id":"986919","name":"Long Hữu"},{"id":"986921","name":"Long Khánh"},{"id":"986913","name":"Long Sơn"},{"id":"986922","name":"Long Vĩnh"},{"id":"986903","name":"Lương Hòa"},{"id":"986899","name":"Ngãi Hùng"},{"id":"986920","name":"Ngũ Lạc"},{"id":"986888","name":"Nhị Long"},{"id":"986912","name":"Nhị Trường"},{"id":"986896","name":"Ninh Thới"},{"id":"986893","name":"Phương Thạnh"},{"id":"986891","name":"Tân An"},{"id":"986905","name":"Tập Sơn"},{"id":"986897","name":"Tiểu Cần"},{"id":"986886","name":"TP Trà Vinh"},{"id":"986904","name":"Trà Cú"},{"id":"986917","name":"Trường Long Hòa"},{"id":"986910","name":"Vinh Kim"},{"id":"986907","name":"Đại An"},{"id":"986908","name":"Đôn Xuân"},{"id":"986889","name":"Đức Mỹ"}]},
          {a:[{"id":"986119","name":"BC Bến Xe"},{"id":"986117","name":"BC Duy Tân"},{"id":"986116","name":"BC Hệ I"},{"id":"986121","name":"BC Hoà Bình"},{"id":"986125","name":"BC Kon Rẫy"},{"id":"986115","name":"BC Kon Tum"},{"id":"986126","name":"BC KonPLong"},{"id":"986129","name":"BC Ngọc Hồi"},{"id":"986123","name":"BC Nguyễn Huệ"},{"id":"986118","name":"BC Phan Đ Phùng"},{"id":"986124","name":"BC Plei Krông"},{"id":"986131","name":"BC Sa Thầy"},{"id":"986122","name":"BC Thương Mại"},{"id":"986120","name":"BC Trung Tín"},{"id":"986132","name":"BC Tu Mơ Rông"},{"id":"986130","name":"BC Đăk GLei"},{"id":"986127","name":"BC Đăk Hà"},{"id":"986128","name":"BC Đăk Tô"}]}
          
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
                    'county': '<option value="">- - xin chọn tỉnh, thành phố - -</option>',
                    'district': '<option value="">- -  xin chọn thị trấn, nội thành  - -</option>'
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
