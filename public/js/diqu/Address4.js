
var addressInit = function(_cmbProvince, _cmbCity, _cmbArea,_Select4, defaultProvince, defaultCity, defaultArea,defaultZip)
{
    var cmbProvince = document.getElementById(_cmbProvince);
    var cmbCity = document.getElementById(_cmbCity);
    var cmbArea = document.getElementById(_cmbArea);
    var cmbZip = document.getElementById(_Select4);
     
    function cmbSelect(cmb, str)
    {
        for(var i=0; i<cmb.options.length; i++)
        {
            if(cmb.options[i].value == str)
            {
                cmb.selectedIndex = i;
                return;
            }
        }
    }
    function cmbAddOption(cmb, str, obj)
    {
        var option = document.createElement("OPTION");
        cmb.options.add(option);
        option.innerHTML = str;
        option.value = str;
        option.obj = obj;
    }
    function changeZip()
    {
        cmbZip.options.length = 0;
        if(cmbArea.selectedIndex == -1)return;
        var item = cmbArea.options[cmbArea.selectedIndex].obj;
        for(var i=0; i<item.postList.length; i++)
        {
            cmbAddOption(cmbZip, item.postList[i], null);
        }
        cmbSelect(cmbZip, defaultZip);
    }
    function changeCity()
    {
        cmbArea.options.length = 0;
        if(cmbCity.selectedIndex == -1)return;
        var item = cmbCity.options[cmbCity.selectedIndex].obj;
        // console.log(item)

        for(var i=0; i<item.areaList.length; i++)
        {
            cmbAddOption(cmbArea, item.areaList[i].name, item.areaList[i]);
        }
        cmbSelect(cmbArea, defaultArea);
        changeZip();
        cmbArea.onchange = changeZip;
    }
    function changeProvince()
    {
        cmbCity.options.length = 0;
        cmbCity.onchange = null;
        if(cmbProvince.selectedIndex == -1)return;
        var item = cmbProvince.options[cmbProvince.selectedIndex].obj;
        for(var i=0; i<item.cityList.length; i++)
        {
            cmbAddOption(cmbCity, item.cityList[i].name, item.cityList[i]);
        }
        cmbSelect(cmbCity, defaultCity);
        changeCity();
        cmbCity.onchange = changeCity;
    }
     
    for(var i=0; i<provinceList.length; i++)
    {
        cmbAddOption(cmbProvince, provinceList[i].name, provinceList[i]);
    }
    cmbSelect(cmbProvince, defaultProvince);
    changeProvince();
    cmbProvince.onchange = changeProvince;
}
 
