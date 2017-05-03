function formValidation(){
    var messageValue = document.querySelector('#messageSent').value;
    if(messageValue.length > 1000){
        document.querySelector('#errorMessageForm').style.display='block';
        return false;
    }
    return true;
}

function checkName(){
    var userName= document.querySelector('#recipient').value;
    
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState==4 && ajax.status==200){
            var res = JSON.parse(this.responseText);
            if(res.exists === true){
                document.querySelector('#nameNotExists').style.display='none';
                return true;
            }
            else{
                document.querySelector('#nameNotExists').style.display='block';
                return false;
            }
        }
    }
    ajax.open("post", "checkName.php", true);
    ajax.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    ajax.send(JSON.stringify({'userName':userName}));
}