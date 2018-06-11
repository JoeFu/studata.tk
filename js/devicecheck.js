var screenwidth = window.screen.width; 
var screenheight = window.screen.height;

if(screenwidth<414 || screenheight<763)
{
    window.location.href="mobile/";
    window.alert("You Are using Mobile Device!");
}
else if(screenwidth == 768 && screenheight ==1024)
{
    window.location.href="mobile/";
    window.alert("You Are using iPad Device!");
}
else if(screenwidth == 1024 && screenheight ==1366)
{
    window.location.href="mobile/";
    window.alert("You Are using iPad Pro Device!");
}
else
{   
    // window.alert("PC");
}



// Ignore Following Test script.
var s = new Array(); 
s[0] = " 网页可见区域宽：" +document.body.clientWidth; 
s[1] = " 网页可见区域高：" +document.body.clientHeight; 
s[2] = " 网页可见区域宽：" +document.body.offsetWidth+ " (包括边线和滚动条的宽)"; 
s[3] = " 网页可见区域高：" +document.body.offsetHeight+ " (包括边线的宽)"; 
s[4] = " 网页正文全文宽：" +document.body.scrollWidth; 
s[5] = " 网页正文全文高：" +document.body.scrollHeight; 
s[6] = " 网页被卷去的高(ff)：" +document.body.scrollTop; 
s[7] = " 网页被卷去的高(ie)：" +document.documentElement.scrollTop; 
s[8] = " 网页被卷去的左：" +document.body.scrollLeft; 
s[9] = " 网页正文部分上：" +window.screenTop; 
s[10] = " 网页正文部分左：" +window.screenLeft; 
s[11] = " 屏幕分辨率的高：" +window.screen.height; 
s[12] = " 屏幕分辨率的宽：" +window.screen.width; 
s[13] = " 屏幕可用工作区高度：" +window.screen.availHeight; 
s[14] = " 屏幕可用工作区宽度：" +window.screen.availWidth;
s[15] = " 你的屏幕设置是 " +window.screen.colorDepth +" 位彩色"; 
s[16] = " 你的屏幕设置 " +window.screen.deviceXDPI +" 像素/英寸"; 
    var i=0;
    while(s[i]!=null)
    {
        console.log(s[i]);
        i++;
    }




