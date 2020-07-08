// 全局变量a和b，分别用于获取用户框和密码框的value值
var a;
var b;
var c;

function oBlur_1() {
    //获取当前输入框内的值
    a = document.getElementsByTagName("input")[0].value;

    if (!a) { 
        document.getElementById("remind_1").innerHTML = "请输入新密码！";
        document.getElementById("change_margin_1").style.marginBottom = 1 + "px";
    } else {
        document.getElementById("remind_1").innerHTML = "";
        document.getElementById("change_margin_1").style.marginBottom = 19 + "px";
    }
}

function oBlur_2() {
    //获取当前输入框内的值
    b = document.getElementsByTagName("input")[1].value;

    if (!b) { 
        document.getElementById("remind_2").innerHTML = "请确认密码！";
        document.getElementById("change_margin_2").style.marginBottom = 1 + "px";
    } else { 
        document.getElementById("remind_2").innerHTML = "";
        document.getElementById("change_margin_2").style.marginBottom = 19 + "px";
    }
}

function oBlur_3() {
    //获取当前输入框内的值
    c = document.getElementsByTagName("input")[2].value;

    if (!b) { //密码框value值为空
        document.getElementById("remind_3").innerHTML = "请输入绑定邮箱！";
        document.getElementById("change_margin_3").style.marginBottom = 1 + "px";
        document.getElementById("change_margin_4").style.marginTop = 2 + "px";
    } else { //密码框value值不为空
        document.getElementById("remind_3").innerHTML = "";
        document.getElementById("change_margin_3").style.marginBottom = 19 + "px";
        document.getElementById("change_margin_4").style.marginTop = 19 + "px";
    }
}

function oFocus_1() {
    document.getElementById("remind_1").innerHTML = "";
    document.getElementById("change_margin_1").style.marginBottom = 19 + "px";
}

function oFocus_2() {
    document.getElementById("remind_2").innerHTML = "";
    document.getElementById("change_margin_2").style.marginBottom = 19 + "px";
}
function oFocus_3() {
    document.getElementById("remind_3").innerHTML = "";
    document.getElementById("change_margin_3").style.marginBottom = 19 + "px";
}


//若输入框为空，阻止表单的提交
function submitTest() {
    //获取当前输入框内的值
    a = document.getElementsByTagName("input")[0].value;
    b = document.getElementsByTagName("input")[1].value;
    c = document.getElementsByTagName("input")[2].value;

    if(!a){
        document.getElementById("remind_1").innerHTML = "请输入新密码！";
        document.getElementById("change_margin_1").style.marginBottom = 1 + "px";
        return false;
    }
    if(!b){
        document.getElementById("remind_2").innerHTML = "请确认密码！";
        document.getElementById("change_margin_2").style.marginBottom = 1 + "px";
        return false;
    }
    if(!c){
        document.getElementById("remind_3").innerHTML = "请输入绑定邮箱！";
        document.getElementById("change_margin_3").style.marginBottom = 1 + "px";
        document.getElementById("change_margin_4").style.marginTop = 2 + "px";
        return false;
    }
}