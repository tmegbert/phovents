var rw = getRowWidth();

$(document).ready(function() {
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

function getHTML()
{
    var ratios = new Array();
    var count = 0;
    var total = 0;
    var rowTop = 0;
    var mainDiv = document.createElement('div');;
    mainDiv.id = "gallery_div";
    mainDiv.className = "layout-row";
    mainDiv.style.marginLeft = "40px";
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
                widthArray[j] = jsArray[i-count+j].width;
                newWidthArray[j] = jsArray[i-count+j].width;
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
                // create div here
                var imageDiv = document.createElement('div');
                imageDiv.style.position = 'relative';
                imageDiv.style.top = rowTop;
                imageDiv.style.left = left;
                imageDiv.className = "imgdiv";

                var anchorParent = document.createElement('a');
                anchorParent.setAttribute('href', jsArray[i-count+j].midsize);
                anchorParent.setAttribute('rel', "lightbox");

                var imageElement = document.createElement('img');
                imageElement.src = jsArray[i-count+j].thumb;
                imageElement.style.height = height;
                imageElement.style.position = 'absolute';
                imageElement.className = "imgele";

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
        if(i == jsArray.length -1){
            //display the last row
            height = 200;
            totalW = 0;
            widthArray = new Array();
            newWidthArray = new Array();
            rowSpaces = new Array();
            for(j = 0; j < count; ++j){
                widthArray[j] = jsArray[i-count+j+1].width;
                newWidthArray[j] = jsArray[i-count+j+1].width;
                totalW += widthArray[j];
                if(typeof ratios[widthArray[j]] === 'undefined') {
                    ratios[widthArray[j]] = widthArray[j] / height;
                }
            }
            totalW += (count-1) * 10;
            var amountToAdd = rw - totalW;
            while(totalW < rw && height < 300){
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
                var imageDiv = document.createElement('div');
                imageDiv.style.position = 'relative';
                imageDiv.style.top = rowTop;
                imageDiv.style.left = left;
                imageDiv.className = "imgdiv";

                var anchorParent = document.createElement('a');
                anchorParent.setAttribute('href', jsArray[i-count+j+1].midsize);
                anchorParent.setAttribute('rel', "lightbox");

                var imageElement = document.createElement('img');
                imageElement.src = jsArray[i-count+j+1].thumb;
                imageElement.style.height = height;
                imageElement.style.position = 'absolute';
                imageElement.className = "imgele";

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
