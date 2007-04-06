function fileSelected() 
{
    var count = document.getElementById('fileToUpload').files.length;
    document.getElementById('details').innerHTML = "";
    for (var index = 0; index < count; index ++){
        var file = document.getElementById('fileToUpload').files[index];
        var fileSize = 0;
        if (file.size > 1024 * 1024)
            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
        else
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
        //document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
        document.getElementById('details').innerHTML += 'Size: ' + fileSize;
        document.getElementById('details').innerHTML += '<p>';
    }
}

function uploadFile() 
{
    var fd = new FormData();
    var phovent = document.getElementById('select_input').value;
    fd.append('phoVent', phovent);
    var count = document.getElementById('fileToUpload').files.length;
    for (var index = 0; index < count; index ++){
        var file = document.getElementById('fileToUpload').files[index];
        fd.append('myFile', file);
    }

    var xhr = new XMLHttpRequest();
    xhr.upload.addEventListener("progress", uploadProgress, false);
    xhr.addEventListener("load", uploadComplete, false);
    xhr.addEventListener("error", uploadFailed, false);
    xhr.addEventListener("abort", uploadCanceled, false);
    xhr.open("POST", "savetofile.php");
    xhr.send(fd);
}

function uploadProgress(evt) 
{
    if (evt.lengthComputable) {
        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
        document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
    } else {
        document.getElementById('progress').innerHTML = 'unable to compute';
    }
}

/* This event is raised when the server send back a response */
function uploadComplete(evt) 
{
    alert(evt.target.responseText);
}

function uploadFailed(evt) 
{
    alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) 
{
    alert("The upload has been canceled by the user or the browser dropped the connection.");
}
