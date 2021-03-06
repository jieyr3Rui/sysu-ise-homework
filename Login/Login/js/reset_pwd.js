// 全局变量a和b，分别用于获取value值
var a;
var b;

//用户框失去焦点后验证value值
function oBlur_1() {
    //获取当前输入框内的值
    a = document.getElementsByTagName("input")[0].value;
    b = document.getElementsByTagName("input")[1].value;

    if (!a) { 
        document.getElementById("remind_1").innerHTML = "请输入新密码！";
        document.getElementById("change_margin_1").style.marginBottom = 1 + "px";
    } else { 
        document.getElementById("remind_1").innerHTML = "";
        document.getElementById("change_margin_1").style.marginBottom = 19 + "px";
    }
}

//密码框失去焦点后验证value值
function oBlur_2() {
    //获取当前输入框内的值
    a = document.getElementsByTagName("input")[0].value;
    b = document.getElementsByTagName("input")[1].value;

    if (!b) { //密码框value值为空
        document.getElementById("remind_2").innerHTML = "请确认密码！";
        document.getElementById("change_margin_2").style.marginBottom = 1 + "px";
        document.getElementById("change_margin_3").style.marginTop = 2 + "px";
    } else { //密码框value值不为空
        document.getElementById("remind_2").innerHTML = "";
        document.getElementById("change_margin_2").style.marginBottom = 19 + "px";
        document.getElementById("change_margin_3").style.marginTop = 19 + "px";
    }
}

//用户框获得焦点的隐藏提醒
function oFocus_1() {
    document.getElementById("remind_1").innerHTML = "";
    document.getElementById("change_margin_1").style.marginBottom = 19 + "px";
}

//密码框获得焦点的隐藏提醒
function oFocus_2() {
    document.getElementById("remind_2").innerHTML = "";
    document.getElementById("change_margin_2").style.marginBottom = 19 + "px";
}

//若输入框为空，阻止表单的提交
function submitTest() {
    //获取当前输入框内的值
    a = document.getElementsByTagName("input")[0].value;
    b = document.getElementsByTagName("input")[1].value;

    if (!a && !b) { //用户框value值和密码框value值都为空
        document.getElementById("remind_1").innerHTML = "请输入新密码！";
        document.getElementById("change_margin_1").style.marginBottom = 1 + "px";
        document.getElementById("remind_2").innerHTML = "请确认密码！";
        document.getElementById("change_margin_2").style.marginBottom = 1 + "px";
        document.getElementById("change_margin_3").style.marginTop = 2 + "px";
        return false; //只有返回true表单才会提交
    } else if (!a) { //用户框value值为空
        document.getElementById("remind_1").innerHTML = "请输入新密码！";
        document.getElementById("change_margin_1").style.marginBottom = 1 + "px";
        return false;
    } else if (!b) { //密码框value值为空
        document.getElementById("remind_2").innerHTML = "请确认密码！";
        document.getElementById("change_margin_2").style.marginBottom = 1 + "px";
        document.getElementById("change_margin_3").style.marginTop = 2 + "px";
        return false;
    }
}