/**
 * Created by Razvan on 08-Feb-17.
 */


/**
 * Function used for determining when user has scrolled close to bottom of page
 * Great for "Load More" tricks
 */
function lazyLoadNewsFeed(nearToBottom, element, parent){

     console.log("DocHeight : "+ $(document).height());
     console.log("E Scroll Top : "+ element.scrollTop());
     console.log("E Height : "+ element.height() );
     console.log("W InnerHeight : "+ parent.height());
    return (element.scrollTop() >= (parent.height() - nearToBottom));
}


function lazyLoadElement(nearToBottom, element, parent){
    return (element.height()+ element.scrollTop() >= (parent.height() - nearToBottom));
}

function lazyLoadDocument(nearToBottom){
    return (window.innerHeight+ $(window).scrollTop() >= ($(document).height() - nearToBottom));
}
/**
 console.log("DocHeight : "+ $(document).height());
 console.log("W Scroll Top : "+ $(window).scrollTop());
 console.log("W Height : "+ $(window).height());
 console.log("W InnerHeight : "+ window.innerHeight);
 */


/**
 * Function used for determining if an image is or not on the server
 */
function imageExists(url, callback) {
    var img = new Image();
    img.onload = function() { callback(true); };
    img.onerror = function() { callback(false); };
    img.src = url;
}

const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };


function convertDate(date){
    date = date.toDate("dd/mm/yyyy");
    var day = date.getDate(); if(day <= 9) day = "0"+day;
    var month = date.getMonth()+1; if(month <= 9) month = "0"+month;
    var year = date.getFullYear();
    date = year+"-"+month+"-"+day;
    return date;
}


String.prototype.toDate = function(format)
{


    var normalized      = this.replace(/[^a-zA-Z0-9]/g, '-');
    var normalizedFormat= format.toLowerCase().replace(/[^a-zA-Z0-9]/g, '-');
    var formatItems     = normalizedFormat.split('-');
    var dateItems       = normalized.split('-');

    var monthIndex  = formatItems.indexOf("mm");
    var dayIndex    = formatItems.indexOf("dd");
    var yearIndex   = formatItems.indexOf("yyyy");
    var hourIndex     = formatItems.indexOf("hh");
    var minutesIndex  = formatItems.indexOf("ii");
    var secondsIndex  = formatItems.indexOf("ss");

    var today = new Date();

    var year  = yearIndex>-1  ? dateItems[yearIndex]    : today.getFullYear();
    var month = monthIndex>-1 ? dateItems[monthIndex]-1 : today.getMonth()-1;
    var day   = dayIndex>-1   ? dateItems[dayIndex]     : today.getDate();

    var hour    = hourIndex>-1      ? dateItems[hourIndex]    : today.getHours();
    var minute  = minutesIndex>-1   ? dateItems[minutesIndex] : today.getMinutes();
    var second  = secondsIndex>-1   ? dateItems[secondsIndex] : today.getSeconds();

    return new Date(year,month,day,hour,minute,second);
};



/**
 Global PRINTS
 printHelper()helps show the blue info-box with custom text inside.
 */

function printHelper(parent, content, html){

    var print = '<div class="HELPERContentContainer doNotSelect"> ' +
        '<div class="HELPERFilterInfoContainer"> ';
    if(html) print+='<span>'+content+'</span>';
    else print+=content;
    print+='</div>';
    parent.append(print);
}

function labelThis(parent, text){
        var print = '<span>' + text + '</span>';
        parent.append(print);
}

function getFirstWord(str) {
    if (str.indexOf(' ') === -1)
        return str;
    else
        return str.substr(0, str.indexOf(' '));
}



function showToast(text, timeout){
    $(function(){
        var container = $("#toast");
        if(!container.length) {
            var toast = '<div id="toast"> ' +
                '<div  id="toastInnerContainer"> ' +
                '<span  style="color: #FF5400" id="toast-text"></span> ' +
                '</div> ' +
                '</div>';

                $("body").append(toast)
        }
        $("#toast-text").text(text);
        container.show();
        if(timeout!=false)
        setTimeout(function () {
            $("#toast").fadeOut('slow');}, timeout);
    });
}

function hideToast(){
    var container = $("#toast");
    container.fadeOut(50);
}


function compareDates(dateTimeA, dateTimeB) {
    var momentA = moment(dateTimeA,"YYYY/MM/DD");
    var momentB = moment(dateTimeB,"YYYY/MM/DD");
    if (momentA > momentB) return 1;
    else if (momentA < momentB) return -1;
    else return 0;
}


function favicon(depthToRoot){

    var prePath="";
    for (var i = 0; i < depthToRoot; i++) prePath += "../";
    prePath+="images/favicon";
    var print = '';

    // $('head').append(print);
}



function validateEmail(email) {
   var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone(phone){
    re = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g;
    if(re.test(phone)){
        if(phone.trim().length < 10) return false;
    }
    else return false;
    return true;
}


function validateString(str){
    return !(str == null || str.length == 0 || str.trim().length == 0 || str === '');

}


/**
 * FAVICON
 */

$(function(){

});


