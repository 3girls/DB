/*signup validation*/
function CheckTaskAdd() {

  {
    var input1=document.getElementById("taskdescription");
    if(input1.value.length==0) input1.value="no description";
    var input2=document.getElementById("minuploadperiod");
    if(input2.value.length==0) input2.value="1";
  }

  var submit = true;
  if(!ExistTaskName()) submit = false;
  if(!ExistTableName()) submit = false;
  if(!ExistSchema())  submit = false;
  if(ExistSpace()) submit = false;
  if(!isRightAttribute()) submit = false;

  return submit;
}
function ExistTaskName() {
  var check = true;

  var taskname = document.getElementById("taskname").value;
  if(taskname.length==0)
    check = false;

  if(!check) {
    document.getElementById("taskname_msg").innerHTML = "Task 이름을 입력하세요.";
  }

  return check;
}

function ExistTableName() {
  var check = true;

  var tablename = document.getElementById("tablename").value;
  if(tablename.length==0)
    check = false;

  if(!check) {
    document.getElementById("tablename_msg").innerHTML = "Table 이름을 입력하세요.";
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