/*signup validation*/
function CheckSignupForm() {
  var submit = true;
  if(!IdCheck())    submit = false;
  if(!PwCheck())    submit = false;
  if(!PwreCheck())  submit = false;
  return submit;
}

/*id check*/
function IdCheck() {
  var check = true;

  var id = document.getElementById("ID").value;
  if(id.length<4)
    check = false;

  if(!check) {
    document.getElementById("id_msg").innerHTML = "아이디는 4자 이상이어야 입니다";
  }

  return check;
}

/*pw check*/
function PwCheck() {
  var lengthcheck = true;

  var pw = document.getElementById("PW").value;

  if(pw.length<6)
    lengthcheck = false;

  if(!lengthcheck) {
    document.getElementById("pwc_msg").innerHTML = "비밀번호는 6자 이상이어야 합니다";
    return false;
  }
  else
    return true;
}

/*pwre check*/
function PwreCheck() {
  var check = true;

  var pw = document.getElementById("PW").value;
  var pwre = document.getElementById("PW_check").value;

  if(pw.length!=pwre.length)
    check = false;
  else {
    for(var i=0; i<pw.length; i++)
      if(pw.charAt(i)!=pwre.charAt(i))
        check = false;
  }

  if(!check)
    document.getElementById("pwrecheck_msg").innerHTML = "비밀번호가 일치하지 않습니다";

  return check;
}
