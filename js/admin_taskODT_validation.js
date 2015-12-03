/*want to add : guarantee the including of all columns*/
/*and do not duplicate*/
function CheckODTAdd() {


  var submit = true;

  if(!ExistODTName()) submit = false;
  if(!ExistSchema())  submit = false;
  if(ExistSpace()) submit = false;
  if(!isRightAttribute()) submit = false;

  return submit;
}

function ExistODTName() {
  var check = true;

  var ODTname = document.getElementById("ODTname").value;
  if(ODTname.length==0)
    check = false;

  if(!check) {
    document.getElementById("ODTname_msg").innerHTML = "ODT 이름을 입력하세요.";
  }

  return check;
}
function ExistSchema() {
  var check = false;

  for(var i=1; i<=10; i++) {
    var stringname= "name";
    var tempi = i.toString();
    var tempname = stringname.concat(tempi);
    //document.write(tempname);

    var gotname = document.getElementById(tempname).value;
    if(gotname.length!=0){
      check = true;
      break;
    }
  }

  if(!check) {
    document.getElementById("schema_msg").innerHTML = "schema를 하나 이상 입력하세요.";
  }

  return check;
}

function ExistSpace(){
  var check = false;

  for(var i=1; i<=10; i++) {
    var stringname= "name";
    var tempi = i.toString();
    var tempname = stringname.concat(tempi);
    //document.write(tempname);

    var gotname = document.getElementById(tempname).value;
    if(gotname.length!=0){
      var includespace = gotname.indexOf(' ');
      if(includespace!=-1){
        check = true;
        break;
      }
    }
  }

  if(check) {
    document.getElementById("schema_msg").innerHTML = "schema에 공백을 지워주세요";
  }

  return check;
}

function isRightAttribute(){
  var check = true;

  for(var i=1; i<=10; i++)
  {
    var stringname= "name";
    var tempi = i.toString();
    var tempname = stringname.concat(tempi);
    //document.write(tempname);

    var gotname = document.getElementById(tempname).value;
    if(gotname.length!=0)
    {
        var stringtype= "type";
        var tempi = i.toString();
        var temptype = stringtype.concat(tempi);
        //document.write(temptype);
        var gottype = document.getElementById(temptype).value;
        if(gottype=="varchar"){
          var stringlength= "length";
          var tempi = i.toString();
          var templength = stringlength.concat(tempi);
          //document.write(templength);
          var gotlength = document.getElementById(templength).value;
          if(gotlength==""){
            check = false;
            document.getElementById("schema_msg").innerHTML = "varchar에 length를 정해주세요.";
            break;
          }
          if(gotlength=="0"){
            check = false;
            document.getElementById("schema_msg").innerHTML = "varchar의 length는 0 이상이여야 합니다.";
            break;
          }
        }
    }

  }
  return check;
}