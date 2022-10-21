 //check browser
var isie=(/msie/i).test(navigator.userAgent); //ie
var isie6=(/msie 6/i).test(navigator.userAgent); //ie 6
var isie7=(/msie 7/i).test(navigator.userAgent); //ie 7
var isie8=(/msie 8/i).test(navigator.userAgent); //ie 8
var isie9=(/msie 9/i).test(navigator.userAgent); //ie 9
var isie10=(/msie 10/i).test(navigator.userAgent); //ie 9
var isfirefox=(/firefox/i).test(navigator.userAgent); //firefox
var isapple=(/applewebkit/i).test(navigator.userAgent); //safari,chrome
var isopera=(/opera/i).test(navigator.userAgent); //opera
var isios=(/(ipod|iphone|ipad)/i).test(navigator.userAgent);//ios
var isipad=(/(ipad)/i).test(navigator.userAgent);//ipad
var isandroid=(/android/i).test(navigator.userAgent);//android
var device;
//if(isie7 || isie8 || isie9){ isie6=false;}
//if(isie9){ isie=false;}
//if(isapple || isios || isipad || isandroid){}else{}



function setCookie(name,value,expiredays) { 
    var today = new Date();
    today.setDate(today.getDate()+expiredays);
    document.cookie = name + "=" + escape(value) + "; path=/; expires=" + today.toGMTString() + ";";
}


function getCookie( name ) {
   var nameOfCookie = name + "="; 
   var x = 0; 
   while ( x <= document.cookie.length ) 
   { 
           var y = (x+nameOfCookie.length); 
           if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
                   if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
                           endOfCookie = document.cookie.length; 
                   return unescape( document.cookie.substring( y, endOfCookie ) ); 
           } 
           x = document.cookie.indexOf( " ", x ) + 1; 
           if ( x == 0 ) 
                   break; 
   } 
   return ""; 
}

function setCookie01(name, value, expireDate)
{
    var date_expire = new Date();
    date_expire.setDate(date_expire.getDate()+expireDate);

    var cookieStr = name + "=" + escape(value) +
                    "; domain=" + escape(".auri.oktomato.net") +
                              "; path=/"  +
                    ((expireDate == null ) ? "" : ("; expires=" + date_expire.toGMTString())) ;

   // alert(cookieStr);

    document.cookie = cookieStr;
}

//모달 팝업창
function LayerPopup_type(obj){
	/*
    var id_Motion = $(".popup_layer");
    var objHeight = $(obj).outerHeight();
    var winHeight = $(window).height();
     if(obj =="close"){
      id_Motion.css("display","none");
      $("#cover").remove();
  }else{
     var backgound = $("<div>").attr({
         "id": "cover"
       }).css({
         "height": $(window).outerHeight()
       })
      $("#wrap").append(backgound);

    for(var i=0; i<=id_Motion.length; i++){
        $(id_Motion[i]).css("display","none");
     }
   $(obj).css({
      "display":"block",
      "z-index":150,
      "top": (winHeight -  objHeight ) / 2 ,
      "left":"50%",
      "margin-left":-( $(obj).outerWidth() / 2)
    });
     //alert(objHeight +",,,,"+ winHeight );
     //if(objHeight > winHeight){}
     backgound.off().on("click",function(){
        id_Motion.css("display","none");
        backgound.remove();
        backgound.off("click");
     });

  }//if    
 
  */
}//LayerPopup_type

var scrollT = $(window).scrollTop();
var initSize = true;

$.fn.extend({
    imgConversion : function(s,type){
     var xt = $(this).attr('src').lastIndexOf('.') + 1;
     xt = $(this).attr('src').substr(xt);
     if(s) $(this).attr('src', $(this).attr('src').replace('off.'+xt, (type != "hover")? 'on.'+xt :'hover.'+xt ));
     else $(this).attr('src', $(this).attr('src').replace((type != "hover")? 'on.'+xt : 'hover.'+xt , 'off.'+xt));
     return $(this);
   }
 });

var sideMenuState;

function bbsCheckbox(){
  $(".check_listbox.box").each(function(index){
      $(this).find("label").attr("for","b0102"+index).end().find("input[type='checkbox']").attr("id","b0102"+index);
    })
    .find("label").click(function(){
      var  on = $(this).next().prop("checked") == true;
      if(on){
        $(this).removeClass("on");
      }else{
        $(this).addClass("on");
      }
    });
    $(".check_listbox.all").click(function(){
      
      var  on = $(this).hasClass("on");
      if(on){
        $(this).removeClass("on").parents("table").find("tbody .check_listbox > input[type='checkbox']").prop("checked",false).prev().removeClass("on");
      }else{
        $(this).addClass("on").parents("table").find("tbody .check_listbox > input[type='checkbox']").prop("checked",true).prev().addClass("on");
      }
    });
}

function initResize(b){

    var reizeTimeOut;
    var headerAreaWidth = $("#header").outerWidth();
    var contentAreaWidth = $(window).width();
    var contentAreaHeight = $(window).height();
     if(initSize){
         if(contentAreaWidth > 900){
           $(".container_inner > .side").css({"left":0});
           $("#lnb .inner > ul").css({"margin-left":200});
           $(".container_inner > .content").css({"margin-left":219});
           sideMenuState = true;
        }else{
           $(".container_inner > .side").css({"left":-199});
           $("#menu-button").css("display","block").stop().animate({"left":198},300);
           $("#lnb .inner > ul").css({"margin-left":0});
           $(".container_inner > .content").css({"margin-left":22});
           sideMenuState = false;
        }
        initSize = false;     
     }else{

    clearInterval(reizeTimeOut);
      reizeTimeOut = setTimeout(function(){
          if(contentAreaWidth > 900){
             $(".container_inner > .side").stop().animate({"left":0},700);
             $("#menu-button").css("display","none").stop().animate({"left":174},300);
             $("#lnb .inner > ul").stop().animate({"margin-left":200},400);
             $(".container_inner > .content").stop().animate({"margin-left":219},400);
             sideMenuState = true;
          }else{
             $(".container_inner > .side").stop().animate({"left":-199},400);
             $("#menu-button").css("display","block").stop().animate({"left":198},300);
             $("#lnb .inner > ul").stop().animate({"margin-left":0},400);
             $(".container_inner > .content").stop().animate({"margin-left":22},400);
             sideMenuState = false;
         }    
   },600); 

 }
 boxAllHeight();

}//767

function fnClickCheck2(obj , bg) {
  
  $(obj).each(function(e){
    var elemt = $(this);
    var txt = new Array();
    if(!bg){
      txt =  elemt.val();
      elemt.focusin(function(){
         if($(this).val() == txt){
            $(this).val("");
         }else{
        ///  alert(false);
         }//if
      });//focusin
       elemt.focusout(function(){
        if($(this).val() == ""){
            $(this).val(txt);
        }
      });//focusout
    
    }else{//bg
      txt =  elemt.css("background-image");
      //console.log(txt);
      elemt.focusin(function(){
        if(elemt.val() == ""){
            elemt.css("background-image","none");
         }
      })//focusin
       elemt.focusout(function(){
        if(elemt.val() == ""){
            elemt.css("background-image",txt);
        }
      });//focusout


    
    }


  });//each
};




function pageSetting(){
    var lnb1depth = $("#lnb .list > li");
    var snb1depth = $(".side .snb > li");
    var lnbClassification = pageNum !="" && pageNum > 0 && pageNum <= lnb1depth.length;
    var subClassification = subNum !="" && subNum > 0 && subNum <= snb1depth.length;
    var lnbOpacitySpeed = 200;
    var lnbBarSpeed = 300;
    var bareasingIn = "easeInQuad";
    var bareasingOut = "easeOutQuad";
    var lnbeasingIn = "easeInQuad";
    var lnbeasingOut = "easeOutQuad";

     if(lnbClassification){
        lnb1depth.siblings(".m"+pageNum).addClass("on");
     }

      if(subClassification){
        snb1depth.siblings(".s"+subNum).addClass("on");
     }

    var snbTimeout;

    $("<img>").attr({
      "src" : "../intro_images/bg/bg_snb_arr.gif",
      "alt" : ""
    }).css({
      "position":"absolute",
      "right":(subClassification) ? 0 : -8,
      "top":(subClassification) ? $(".side .snb > li.s"+subNum).offset().top - 52 : 0
    }).addClass("arr_snb").appendTo(".side")
    
      


  $(".side .snb > li").on("mouseenter" , function(){
    clearInterval(snbTimeout);
      $(".arr_snb").stop().animate({
        "right":0,
        "top":$(this).offset().top - 52
      },300)
  });

  $(".side .snb > li").on("mouseleave" , function(){
      snbTimeout = setTimeout(function(){
      $(".arr_snb").stop().animate({
        "right":0,
        "top":$(".side .snb > li.s"+subNum).offset().top - 52
      },300)    
      },700)
  });

  initResize();
}
$(function(){
  $("#menu-button").on("mouseenter mouseleave",function(e){
    if(e.type == "mouseenter"){
      $("#menu-button-line").stop().animate({"width":30},300,function(){
      $("#menu-button-text").stop().animate({
        "left":59,
        "opacity":1
      },300);
      }); 

    }else{
      $("#menu-button-line").stop().animate({"width":0},300);
        $("#menu-button-text").stop().animate({
        "left":65,
        "opacity":0
      },300);
    }
  
  }).on("click",function(){
    $(".container_inner > .side").stop().animate({"left": (sideMenuState) ? -199 : 0},700);
    $(this).find("#menu-button-icon > img").imgConversion(!sideMenuState);
      sideMenuState = !sideMenuState;
  });
});

function boxAllHeight(){
  //var openFlag = getCookie("openFlag");
  //console.log(openFlag);
  //var sideOpenMenu = $("#menuOption");
  var snbMenu = $(".side");
  var snbMenuHeight = snbMenu.outerHeight();
  var winHeight = $(window).height();
  var conHeight = $("#wrap").outerHeight();
  snbMenu.css("height" ,"" );

  if(winHeight > conHeight){
      snbMenu.css("height", winHeight);
  }else{
     snbMenu.css("height", conHeight);
  }
}

function checkListMotion(){
    $(".lst_check").each(function(){
        var $this = $(this)
        var prev;
        $this.find(">span").each(function(){
          if($(this).find(" > input").prop("checked")){
            $(this).addClass("on");
          } else {
            $(this).removeClass("on");
		  }
        });//each

    }); //each

    $(".lst_check > span ").find(" > label").off().on("click",function(){
      if($(this).parents(".lst_check").hasClass("radio")){
       $(this).parent().siblings(".on").removeClass("on").end().addClass("on");
     }else{
      $(this).parent().toggleClass("on");
     }//if

  });
}



// function initScroll(){
//   scrollT = $(window).scrollTop();
//  //사이드메뉴 높이값 여부
// }