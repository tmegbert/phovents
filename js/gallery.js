
var rw = getRowWidth();
var samples = ["Powell", "Zion", "Clouds", "Arches"];

$(document).ready(function() {
    var phovent = document.getElementById('phovent').value;
    if(samples.indexOf(phovent) >= 0){
        document.getElementById('add_photo').style.visibility = "hidden";
    }

    getHTML(jsArray);
});

function debouncer( func , timeout ) {
   var timeoutID , timeout = timeout || 500;
   return function () {
      var scope = this , args = arguments;
      clearTimeout( timeoutID );
      timeoutID = setTimeout( function () {
          func.apply( scope , Array.prototype.slice.call( args ) );
      } , timeout );
   }
}


$( window ).resize( debouncer( function ( e ) {
    rw = getRowWidth();
    removeDOMClass("imgele");
    removeDOMClass("imgdiv");
    removeDOMClass("layout-row");
    getHTML();
    location.reload();
} ) );

function removeDOMClass(classname)
{
    var list = document.getElementsByClassName(classname);
    for(var i = list.length - 1; 0 <= i; i--)
        if(list[i] && list[i].parentElement)
            list[i].parentElement.removeChild(list[i]);
}

function getHTML(jsArray)
{
    var is_auth = false;
    var ratios = new Array();
    var count = 0;
    var total = 0;
    var rowTop = 0;
    var phoIndex = 0;
    var mainDiv = document.createElement('div');;
    mainDiv.id = "gallery_div";
    mainDiv.className = "layout-row";
    mainDiv.style.marginLeft = "40px";
    var user = readCookie('phouser');
    if(user){
        document.getElementById('mg_icon').style.visibility = "visible";
        is_auth = true;
    } else {
        document.getElementById('mg_icon').style.visibility = "hidden";
    }

    for(i = 0; i < jsArray.length; ++i){
        var imageW = jsArray[i].width;
        if((total + imageW) <= rw){
            count++;
            // image accepted to row
            total += imageW + 10;
        } else { // image too big for row
            var height = 200;
            var totalW = 0;
            var widthArray = new Array();
            var newWidthArray = new Array();
            var rowSpaces = new Array();
            for(j = 0; j < count; ++j){
                phoIndex = i-count+j;
                widthArray[j] = jsArray[phoIndex].width;
                newWidthArray[j] = jsArray[phoIndex].width;
                totalW += widthArray[j];
                if(typeof ratios[widthArray[j]] === 'undefined') {
                    ratios[widthArray[j]] = widthArray[j] / height;
                }
            }
            totalW += (count-1) * 10;
            var amountToAdd = rw - totalW;
            while(totalW < rw){
                height++;
                totalW = 0;
                for(j=0;j<count;++j){
                    newWidthArray[j] = Math.round(height * ratios[widthArray[j]]);
                    totalW += newWidthArray[j];
                    if(j!=0){totalW += 10};
                }
            }
            // write out the html
            var left = 0;
            for(j = 0; j < count - 1; ++j){
                rowSpaces[j] = 10;
            }
            var leftOver = totalW - rw;
            var index = 0;
            while(leftOver > 0){
                rowSpaces[index]--;      
                if(index == count -2){
                    index = 0;
                } else {
                    index++;
                }
                leftOver--;
            }
                
            index = 0;
            for(j=0;j<count;++j){
                phoIndex = i-count+j;
                // create div here
                var imageDiv = document.createElement('div');
                imageDiv.style.position = 'relative';
                imageDiv.style.top = rowTop;
                imageDiv.style.left = left;
                imageDiv.className = "imgdiv";

                var anchorParent = document.createElement('a');
                anchorParent.setAttribute('href', jsArray[phoIndex].midsize);
                anchorParent.setAttribute('rel', "lightbox");

                var imageElement = document.createElement('img');
                imageElement.src = jsArray[phoIndex].thumb;
                imageElement.style.height = height;
                imageElement.style.position = 'absolute';
                imageElement.className = "imgele";

                // download icon div
                var downloadDiv = document.createElement('div');
                downloadDiv.style.position = 'relative';
                downloadDiv.style.top = rowTop + height - 40;
                downloadDiv.style.left = left + 20;

                var downloadAnchor = document.createElement('a');
                downloadAnchor.setAttribute('href', 'download.php?download_file=' + jsArray[phoIndex].name);

                var downloadIcon = document.createElement('img');
                downloadIcon.src = 'images/download.png';
                downloadIcon.style.position = 'absolute';
                downloadIcon.style.height = 32;
                downloadIcon.style.zIndex = "1";

                if(is_auth){
                    // delete icon div
                    var deleteDiv = document.createElement('div');
                    deleteDiv.style.position = 'relative';
                    deleteDiv.style.top = rowTop + height - 40;
                    deleteDiv.style.left = left + newWidthArray[j] - 50;

                    var deleteAnchor = document.createElement('a');
                    deleteAnchor.setAttribute('href', 'delete.php?delete_file=' + jsArray[phoIndex].name);

                    var deleteIcon = document.createElement('img');
                    deleteIcon.src = 'images/delete_32x32.png';
                    deleteIcon.style.position = 'absolute';
                    deleteIcon.style.height = 32;
                    deleteIcon.style.zIndex = "1";

                    deleteAnchor.appendChild(deleteIcon);
                    deleteDiv.appendChild(deleteAnchor);
                    mainDiv.appendChild(deleteDiv);
                }

                downloadAnchor.appendChild(downloadIcon);
                downloadDiv.appendChild(downloadAnchor);
                mainDiv.appendChild(downloadDiv);

                anchorParent.appendChild(imageElement);
                imageDiv.appendChild(anchorParent);
                mainDiv.appendChild(imageDiv);
                
                if(j!=count - 1) {
                    left += newWidthArray[j] + rowSpaces[index++];
                }
            }
            //new row
            rowTop += height + 10;
            
            count = 1;
            total = imageW;
            
        }
        if(i == jsArray.length - 1){
            //display the last row
            height = 200;
            totalW = 0;
            widthArray = new Array();
            newWidthArray = new Array();
            rowSpaces = new Array();
            for(j = 0; j < count; ++j){
                phoIndex = i-count+j+1;
                widthArray[j] = jsArray[phoIndex].width;
                newWidthArray[j] = jsArray[phoIndex].width;
                totalW += widthArray[j];
                if(typeof ratios[widthArray[j]] === 'undefined') {
                    ratios[widthArray[j]] = widthArray[j] / height;
                }
            }
            totalW += (count-1) * 10;
            var amountToAdd = rw - totalW;
            while(totalW < rw && height < 200){
                height++;
                totalW = 0;
                for(j=0;j<count;++j){
                    newWidthArray[j] = Math.round(height * ratios[widthArray[j]]);
                    totalW += newWidthArray[j];
                    if(j!=0){totalW += 10};
                }
            }
            // write out the html
            left = 0;
            for(j = 0; j < count - 1; ++j){
                rowSpaces[j] = 10;
            }
            var leftOver = totalW - rw;
            var index = 0;
            while(leftOver > 0){
                rowSpaces[index]--;      
                if(index == count -2){
                    index = 0;
                } else {
                    index++;
                }
                leftOver--;
            }
                
            index = 0;
            for(j=0;j<count;++j){
                phoIndex = i-count+j+1;
                var imageDiv = document.createElement('div');
                imageDiv.style.position = 'relative';
                imageDiv.style.top = rowTop;
                imageDiv.style.left = left;
                imageDiv.className = "imgdiv";

                var anchorParent = document.createElement('a');
                anchorParent.setAttribute('href', jsArray[phoIndex].midsize);
                anchorParent.setAttribute('rel', "lightbox");

                var imageElement = document.createElement('img');
                imageElement.src = jsArray[phoIndex].thumb;
                imageElement.style.height = height;
                imageElement.style.position = 'absolute';
                imageElement.className = "imgele";

                // download icon div
                var downloadDiv = document.createElement('div');
                downloadDiv.style.position = 'relative';
                downloadDiv.style.top = rowTop + height - 40;
                downloadDiv.style.left = left + 20;

                var downloadAnchor = document.createElement('a');
                downloadAnchor.setAttribute('href', 'download.php?download_file=' + jsArray[phoIndex].name);

                var downloadIcon = document.createElement('img');
                downloadIcon.src = 'images/download.png';
                downloadIcon.style.position = 'absolute';
                downloadIcon.style.height = 32;
                downloadIcon.style.zIndex = "1";

                if(is_auth){
                    // delete icon div
                    var deleteDiv = document.createElement('div');
                    deleteDiv.style.position = 'relative';
                    deleteDiv.style.top = rowTop + height - 40;
                    deleteDiv.style.left = left + newWidthArray[j] - 50;

                    var deleteAnchor = document.createElement('a');
                    deleteAnchor.setAttribute('href', 'delete.php?delete_file=' + jsArray[phoIndex].name);

                    var deleteIcon = document.createElement('img');
                    deleteIcon.src = 'images/delete_32x32.png';
                    deleteIcon.style.position = 'absolute';
                    deleteIcon.style.height = 32;
                    deleteIcon.style.zIndex = "1";

                    deleteAnchor.appendChild(deleteIcon);
                    deleteDiv.appendChild(deleteAnchor);
                    mainDiv.appendChild(deleteDiv);
                }

                downloadAnchor.appendChild(downloadIcon);
                downloadDiv.appendChild(downloadAnchor);
                mainDiv.appendChild(downloadDiv);

                anchorParent.appendChild(imageElement);
                imageDiv.appendChild(anchorParent);
                mainDiv.appendChild(imageDiv);
                
                left += newWidthArray[j] + rowSpaces[index++];
            }
        }
    }
    document.body.appendChild(mainDiv);
}

function getRowWidth()
{
    var browserW = window.innerWidth - 100;
    return browserW;
}

function createCookie(name,value) 
{
    var date = new Date();
    date.setTime(date.getTime()+(24*60*60*1000));
    var expires = "; expires="+date.toGMTString();

    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) 
{
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) 
{
    createCookie(name,"",-1);
}
