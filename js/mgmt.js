function populateCards()
{
    var content = document.getElementById('content');
    for (var i in phovents){
        var name = phovents[i]['name'];
        var id = 'del' + name + 'Form';
        var cdate = timeConverter(phovents[i]['creation_date']);
        var edate = timeConverter(phovents[i]['expiration_date']);
        var card_div = document.createElement('div');
        card_div.className = "usercard";

        var ctop_div = document.createElement('div');
        ctop_div.className = "cardtop";

        var ccontent_div = document.createElement('div');
        ccontent_div.className = "cardcontent";

        var name_div = document.createElement('div');
        var text_div = document.createElement('div');
        text_div.id = "cardText";
        var edit_div = document.createElement('div');
        edit_div.id = "editCard";
        var edit_button = document.createElement('button');
        edit_button.setAttribute("onClick", "editCard('" + name + "');");
        edit_button.id = "editButton";
        edit_button.className = "userButton";
        edit_div.appendChild(edit_button);

        var del_div = document.createElement('div');
        del_div.id = "delCard";
        var del_button = document.createElement('button');
        del_button.setAttribute("onClick", "delCard(\"" + name + "\");");
        del_button.setAttribute("type", "button");
        del_button.id = "deleteButton";
        del_button.className = "userButton";
        del_div.appendChild(del_button);

        var name = document.createElement('input');
        name.setAttribute("type", "hidden");
        name.setAttribute("name", "name");
        name.setAttribute("value", phovents[i]['name']);

        var owner = document.createElement('input');
        owner.setAttribute("type", "hidden");
        owner.setAttribute("name", "owner");
        owner.setAttribute("value", phovents[i]['owner']);

        var action = document.createElement('input');
        action.setAttribute("type", "hidden");
        action.setAttribute("name", "action");
        action.setAttribute("value", "delete");

        var del_form = document.createElement('form');
        del_form.setAttribute('method', "POST");
        del_form.setAttribute('action', "mgmt.php");
        del_form.id = id;
        del_form.appendChild(del_div);
        del_form.appendChild(name);
        del_form.appendChild(owner);
        del_form.appendChild(action);

        text_div.innerHTML = phovents[i]['name'];
        name_div.appendChild(text_div);
        name_div.appendChild(del_form);
        name_div.appendChild(edit_div);

        var desc_div = document.createElement('div');
        desc_div.className = "cardline";
        desc_div.innerHTML = "Description: " + phovents[i]['description'];

        var created_div = document.createElement('div');
        created_div.className = "cardline";
        created_div.innerHTML = "Date created: " + cdate;

        var expire_div = document.createElement('div');
        expire_div.className = "cardline";
        expire_div.innerHTML = "Expiration date: " + edate;

        ctop_div.appendChild(name_div);
        ccontent_div.appendChild(desc_div);
        ccontent_div.appendChild(created_div);
        ccontent_div.appendChild(expire_div);

        card_div.appendChild(ctop_div);
        card_div.appendChild(ccontent_div);

        content.appendChild(card_div);
    }
}

function addCard()
{
    document.getElementById('d_title').innerHTML = "Add a phoVent";
    document.getElementById('name').value = "";
    document.getElementById('desc').value = "";
    document.getElementById('datepicker').value = "";
    showDialog('add');
}

function editCard(phoventName)
{
    document.getElementById('d_title').innerHTML = "Edit a phoVent";
    document.getElementById('name').value = phoventName;
    document.getElementById('desc').value = phovents[phoventName].description;
    document.getElementById('datepicker').value = getExpireDate(phovents[phoventName].expiration_date);
    showDialog('edit');
}

function delCard(phoVent)
{
    var id = 'del' + phoVent + 'Form';
    var result = confirm('Are you sure you want to delete ' + phoVent + '?');
    if(result == true){
        document.getElementById(id).submit();
    }
}

function showDialog(action)
{
    document.getElementById('light').style.display='block';
    document.getElementById('fade').style.display='block';
    if(action == "add"){
        document.getElementById('cardAction').value = "add";
    } else {
        document.getElementById('cardAction').value = "edit";
    }
    document.getElementById('name').focus();
}

function hideDialog()
{
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
    var form = document.getElementById('addForm');
}

function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (1825*24*60*60*1000));  // 5 years
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
}

function getExpireDate(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var year = a.getFullYear();
  var month = ("0" + Number(a.getMonth() + 1)).slice(-2);
  var date = ("0" + a.getDate()).slice(-2);
  var time = month + '/' + date + '/'  + year;
  return time;
}

function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = ("0" + a.getHours()).slice(-2);;
  var min = ("0" + a.getMinutes()).slice(-2);
  var sec = ("0" + a.getSeconds()).slice(-2);
  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
  return time;
}

function signOut()
{
    window.location="http://www.nerkasoft.com/phovents";
}

window.onload = function() {
    setTimeout(function() {
        populateCards();
    }, 0);
}
