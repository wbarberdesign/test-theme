<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chapter - Test</title>
    <style media="screen">
    body{
      font-family:helvetica;
      padding:50px;
      font-size:22px;
    }
    .define {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    }

    .has-definition:hover .define{
    visibility: visible;
    }

    .has-definition{
    cursor: pointer;
    border-bottom:2px dotted blue;
    }

    .lineBreak{
      height:20px;
    }

    </style>
  </head>
  <body>
    <h2>This is a single chapter page</h2>

    <?php
      $audio = get_field( "audio" );
      $json = get_field( "json" );
    ?>

    <audio controls id ="audiofile">
      <source src="<?php echo $audio['url']; ?>" type="audio/mp3">
      Your browser does not support the audio element.
    </audio>

    <div id="subtitles"></div>
    <p id="demo"></p>

    <script type="text/javascript">
    // pass PHP variable declared above to JavaScript variable
    var myObj, i, x = "";
    myObj = <?php echo $json ?>;
    console.log(myObj);

    for (i in myObj.fragments) {
        delete myObj.fragments[i].language;
        delete myObj.fragments[i].children;
        myObj.fragments[i].start = myObj.fragments[i].begin;
        myObj.fragments[i].text = myObj.fragments[i].lines[0];
        delete myObj.fragments[i].begin;
        delete myObj.fragments[i].lines;
    }

    document.getElementById("demo").innerHTML = x;

            ( function(win, doc) {
                var audioPlayer = doc.getElementById("audiofile");
                var subtitles = doc.getElementById("subtitles");
                var syncData = myObj.fragments;
                createSubtitle();

                function createSubtitle()
                {
                    var element;
                    var definition;
                    for (var i = 0; i < syncData.length; i++) {
                        element = doc.createElement('span');
                        element.setAttribute("id", "c_" + i);
                        element.innerText = syncData[i].text + " ";

                        if(syncData[i].hasOwnProperty('define')){
                          definition = doc.createElement('span');
                          definition.setAttribute("class", "define");
                          definition.innerText = syncData[i].define + " ";
                          element.appendChild(definition);
                          element.setAttribute("class", "has-definition");
                        }

                        if(syncData[i].hasOwnProperty('linebreak')){
                          lineBreak = doc.createElement('div');
                          lineBreak.setAttribute("class", "lineBreak");
                          element.appendChild(lineBreak);
                        }

                          subtitles.appendChild(element);
                        }


                    }

                audioPlayer.addEventListener("timeupdate", function(e){
                    syncData.forEach(function(element, index, array){
                        if( audioPlayer.currentTime >= element.start && audioPlayer.currentTime <= element.end ){
                            subtitles.children[index].style.background = 'yellow';
                          }else{
                            subtitles.children[index].style.background = '#f2f2f2';
                          }
                    });
                });
            }(window, document));
    </script>

  </body>
</html>
