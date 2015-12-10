/*signup validation*/
function CheckSignupForm() {
  {/*if there is no emails, set default values*/
    /*
    var input2=document.getElementById("Email");
    if(input2.value.length==0) input2.value="name@domain.com";
    var input3=document.getElementById("Phone");
    if(input3.value.length==0) input3.value="01012345678";*/
  }

  var submit = true;
  if(!PwCheck()) submit = false;
  if(!PwreCheck())  submit = false;

  return submit;
}


function PwCheck() {
  var lengthcheck = true;

  var pw = document.getElementById("PW").value;

  if(pw==null || pw=="" || pw.length<6){
    document.getElementById("pw_msg").innerHTML = "비밀번호는 6자 이상이어야 합니다";
    lengthcheck = false;
  }

  return lengthcheck;

}


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