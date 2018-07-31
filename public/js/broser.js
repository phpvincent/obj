function myjs() {
    document.getElementById("os").value = getOS();
    document.getElementById("resolution").value=getResolution();
    document.getElementById("brower").value = getBrowser();
    document.getElementById("browerLang").value=getBrowserLang();
    document.getElementById("timeZone").value=getTimezone();

}
function getOS(){
    var sUserAgent = navigator.userAgent;
    var isWin = (navigator.platform == "Win32")
        || (navigator.platform == "Windows");
    var isMac = (navigator.platform == "Mac68K")
        || (navigator.platform == "MacPPC")
        || (navigator.platform == "Macintosh")
        || (navigator.platform == "MacIntel");
    if (isMac)
        return "Mac";
    var isUnix = (navigator.platform == "X11") && !isWin && !isMac;
    if (isUnix)
        return "Unix";
    var isLinux = (String(navigator.platform).indexOf("Linux") > -1);
    if (isLinux)
        return "Linux";
    if (isWin) {
        var isWin2K = sUserAgent.indexOf("Windows NT 5.0") > -1
            || sUserAgent.indexOf("Windows 2000") > -1;
        if (isWin2K)
            return "Win2000";
        var isWinXP = sUserAgent.indexOf("Windows NT 5.1") > -1
            || sUserAgent.indexOf("Windows XP") > -1;
        if (isWinXP)
            return "WinXP";
        var isWin2003 = sUserAgent.indexOf("Windows NT 5.2") > -1
            || sUserAgent.indexOf("Windows 2003") > -1;
        if (isWin2003)
            return "Win2003";
        var isWin2003 = sUserAgent.indexOf("Windows NT 6.0") > -1
            || sUserAgent.indexOf("Windows Vista") > -1;
        if (isWin2003)
            return "WinVista";
        var isWin2003 = sUserAgent.indexOf("Windows NT 6.1") > -1
            || sUserAgent.indexOf("Windows 7") > -1;
        if (isWin2003)
            return "Win7";
    }
    return "None";
}
function getResolution(){
	return window.screen.width + "x" + window.screen.height;
}
function getBrowser(){
	var userAgent = navigator.userAgent;
    var isOpera = userAgent.indexOf("Opera") > -1;
    if (isOpera) {
        return "Opera"
    }
    if (userAgent.indexOf("Chrome") > -1) {
        return "Chrome";
    }
    if (userAgent.indexOf("Firefox") > -1) {
        return "Firefox";
    }
    if (userAgent.indexOf("Safari") > -1) {
        return "Safari";
    }
    if (userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1
        && !isOpera) {
        return "IE";
    }
}
function getBrowserLang(){
    return navigator.language || window.navigator.browserLanguage;
}
function getTimezone(){
    return new Date().getTimezoneOffset()/60*(-1);
}

