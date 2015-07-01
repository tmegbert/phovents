<?php
$thumbDir = "images/magic/Powell/thumb";
$images = array_diff(scandir($thumbDir), array('..', '.'));
$imageWidths = array();
$index = 0;
foreach($images as $image){
    $thumb = $thumbDir . "/" . $image;

    //Read original image and create Imagick object
    $imageD=new Imagick($thumb);
    $d = $imageD->getImageGeometry(); 
    $w = $d['width']; 
    $imageWidths[$index]['image'] = $thumb;
    $imageWidths[$index]['width'] = $w;
    $index++;
}

//var_dump($imageWidths);
?>
<html>
<head>
<title>Blah</title>
<script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script type="text/javascript"> 
    var jsArray = <? echo json_encode($imageWidths); ?>;
    var rw = getRowWidth();
    var htmlstuff = getHTML(jsArray);
 

    window.onresize = function() {
        var rw = getRowWidth();
        console.log(rw);
    }

    function getHTML(jsArray)
    {
        var count = 0;
        var total = 0;
        var rowTop = 0;
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
                var ratios = new Array();
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
                var message = " top:" + rowTop;
                message += " height:" + height;
                console.log(message);
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
                    if(j!=count - 1) {
                        console.log("    " + jsArray[i-count+j].image + " left:" + left);
                        left += newWidthArray[j] + rowSpaces[index++];
                    } else {
                        console.log("    " + jsArray[i-count+j].image + " left:" + left);
                    }
                }
                //new row
                rowTop += height + 10;
                
                count = 1;
                total = imageW;
            }
        }
       // return message;
    }

    function getRowWidth()
    {
        var browserW = window.innerWidth - 200;
        var rowWidth = 0;
        var index = 0;
        while(rowWidth < browserW){
            rowWidth += jsArray[index].width;
            if(index != 0){ rowWidth += 10;}
            index++;
        }
        rowWidth -= jsArray[index].width + 10;
        return rowWidth;
    }
        
</script>
</head>
<body>
<div> Duh!</div>
</body>
</html>
