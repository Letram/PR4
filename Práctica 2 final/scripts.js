function deleteOrderLine(drinkid, pvp, amount, orderid, idfila){
    if(!confirm("Desea borrar la linea que ha seleccionado?"))return;

    var ajax= new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(this.readyState== 4 && this.status == 200) {
            var res = JSON.parse(this.responseText); //resultado formato JSON {deleted:lógico}
            if(res.deleted === true){
                var fila=document.querySelector('#fila'+idfila); //Se usa id por la clausura
                fila.parentNode.removeChild(fila); //Eliminamos la fila del juego
                var aux = document.querySelector('#tablaBebidas').rows.length; 
                if(aux == 1)document.querySelector('#tablaBebidas').style.display = 'none';
            }
        }
    };
    ajax.open("post","delete_orderLine_json.php",true);
    ajax.setRequestHeader("Content-Type","application/json;charset=UTF-8");
    var data = {"drinkid":drinkid, "orderid":orderid, "pvp":pvp, "amount":amount};
    ajax.send(JSON.stringify(data)); //Formato {id:identificador de registro a borrar}
}

function checkType(){
    var typeValue=document.querySelector('#type').value;
    if(typeValue != 2)document.querySelector('#localidad').style.display = 'none';
    else document.querySelector('#localidad').style.display = 'block';
}

function formValidation(){
    var formName=document.querySelector('#name').value;
    if(formName.length < 4){
        document.querySelector('#nameError').innerHTML = "Nombre no válido, el tamaño mínimo es 4 caracteres."
        return false;
    }
    var formPass=document.querySelector('#pass').value;
    if(formPass.length < 4){
        document.querySelector('#passError').innerHTML = "Contraseña no válida, el tamaño mínimo es 4 caracteres."
        return false;
    }
    var formUser=document.querySelector('#user').value;
    if(formUser.length < 4){
        document.querySelector('#userError').innerHTML = "Usuario no válido, el tamaño mínimo es 4 caracteres."
        return false;
    }
}

function addOrderLine(drinkid, pvp, orderid, label){
    var stock = document.querySelector('#cantidad'+label).value;

    if(stock > 0){
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (this.readyState== 4 && this.status == 200) {
                var res = JSON.parse(this.responseText); //resultado formato JSON {deleted:lógico}
                if(res.added == true){
                    //TODO
                    var drinkTable = document.querySelector('#tablaBebidas');
                    var newRow = drinkTable.insertRow(-1);
                    var index = newRow.rowIndex;
                    newRow.id = "fila"+index;
                    var newCell = newRow.insertCell(-1);
                    newCell.innerHTML = res.marca;
                    newCell = newRow.insertCell(-1);
                    newCell.innerHTML = stock;
                    newCell = newRow.insertCell(-1);
                    newCell.innerHTML = pvp;
                    newCell = newRow.insertCell(-1);
                    var index = newRow.rowIndex;
                    newCell.innerHTML = "<button class=\"smallButton\" onclick=\"deleteOrderLine("+drinkid+", "+pvp+", "+stock+", "+orderid+", "+(index)+")\">Borrar</button>";
                    if(drinkTable.style.display == 'none')drinkTable.style.display = "block";
                }
            }
        };
        ajax.open("post", "add_orderLine_json.php", true);
        ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        ajax.send(JSON.stringify({"idbebida":drinkid,"unidades":stock, "pvp":pvp, "orderid":orderid}));
    }
}