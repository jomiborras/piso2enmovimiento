function onClickBox() {
 for(var i=1;i<=3;i++){
       let checked=$("#choose-"+i).is(":checked");
       localStorage.setItem("checked-"+i, checked);
    }
 }


function onReady() {
   for(var i=1;i<=3;i++){
     if(localStorage.getItem("checked-"+i)=="true"){
      var checked=true;
     }
     else{
      var checked=false;
     }
    $("#choose-"+i).prop('checked', checked);
    onClickBox();
   }
}

$(document).ready(onReady);