// 全局变量a用于获取邮件的value值
var a;

//输入框失去焦点后验证value值
function oBlur_1() {
    //获取当前输入框内的值
    a = document.getElementsByTagName("input")[0].value;

    if (!a) { //用户框value值为空
        document.getElementById("remind_1").innerHTML = "请输入注册邮箱！";
        document.getElementById("change_margin_1").style.marginBottom = 1 + "px";
    } else { //用户框value值不为空
        document.getElementById("remind_1").innerHTML = "";
        document.getElementById("change_margin_1").style.marginBottom = 19 + "px";
    }
}

//输入框获得焦点的隐藏提醒
function oFocus_1() {
    document.getElementById("remind_1").innerHTML = "";
    document.getElementById("change_margin_1").style.marginBottom = 19 + "px";
}

//若输入框为空，阻止表单的提交
function submitTest() {
    //获取当前输入框内的值
    a = document.getElementsByTagName("input")[0].value;
    if (!a) { //输入框value值为空
        document.getElementById("remind_1").innerHTML = "请输入注册邮箱！";
        document.getElementById("change_margin_1").style.marginBottom = 1 + "px";
        return false;
    }
}