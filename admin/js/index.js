/**
 * Created by Razvan on 22-Feb-17.
 */
/**
 * For login use ajax because SAFARI does not support "required" in inputs.
 */
var logInButton;
var email;
var password;
var token;
$(function(){
    logInButton = $("#logInButton");
    logInButton.prop("disabled",false);
    logInButton.on("click",function(){
        email  =  $("#email").val();
        password = $("#password").val();
        if(!email || !validateEmail(email)){showToast("Please add a valid email.",600);return;}
        if(!password) {showToast("Please add a password.",600);return;}

        if(email && password && validateEmail(email)){
            token = md5(password);
            password = md5(email+password);
            logInButton.prop("disabled",true);
            doLogin(email,password,token);
        }
    });
});


function doLogin(email,password){
    Pace.restart();
    var login = $.ajax({
      //  url:URL,
        url: "session/log-in.php",
        type:"POST",
        data:{
            email : email,
            password : password,
            token : token
        }
    });
    login.done(function(msg){
        console.log(msg);
        if(msg!="response-negative" && msg=="response-ok"){
            showToast("Welcome!",600);
            window.location.href="students.php";
        }
        else showToast("Wrong credentials. Try Again!",600)
    });
    login.fail(function(){
       showToast("Server Error.",600);
    });
    login.always(function(){
        logInButton.prop("disabled",false);
    });
}

