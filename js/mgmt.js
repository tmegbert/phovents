function populateCards()
{
    var content = document.getElementById('content');
    for (var i in phovents){
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
        edit_button.setAttribute("onClick", "editCard('" + phovents[i]['name'] + "');");
        edit_button.id = "editButton";
        edit_button.className = "userButton";
        edit_div.appendChild(edit_button);
        var del_div = document.createElement('div');
        del_div.id = "delCard";
        var del_button = document.createElement('button');
        del_button.setAttribute("onClick", "delCard(this);");
        del_button.id = "deleteButton";
        del_button.className = "userButton";
        del_div.appendChild(del_button);
        text_div.innerHTML = phovents[i]['name'];
        name_div.appendChild(text_div);
        name_div.appendChild(del_div);
        name_div.appendChild(edit_div);

        var desc_div = document.createElement('div');
        desc_div.className = "cardline";
        desc_div.innerHTML = "Description: " + phovents[i]['description'];

        var created_div = document.createElement('div');
        created_div.className = "cardline";
        created_div.innerHTML = "Date created: " + phovents[i]['creation_date'];

        var expire_div = document.createElement('div');
        expire_div.className = "cardline";
        expire_div.innerHTML = "Expiration date: " + phovents[i]['expiration_date'];

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
    showDialog('add');
    document.getElementById('name').value = "";
    document.getElementById('desc').value = "";
    document.getElementById('creation_date').value = "";
    document.getElementById('expiration_date').value = "";
}

function editCard(phoventName)
{
    document.getElementById('name').value = phoventName;
    document.getElementById('desc').value = phovents[phoventName].description;
    document.getElementById('creation_date').value = phovents[phoventName].creation_date;
    document.getElementById('expiration_date').value = phovents[phoventName].expiration_date;
    showDialog();
}

function delCard(obj)
{
    alert('Deleting Card');
}

function showDialog()
{
    document.getElementById('light').style.display='block';
    document.getElementById('fade').style.display='block';
}

function hideDialog(action)
{
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
    if ( action == 'save') {
        //Do some stuff to save the user object
    }
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

function signOut()
{
    window.location="http://www.nerkasoft.com/phovents";
}

window.onload = function() {
    setTimeout(function() {
        populateCards();
    }, 0);
}
