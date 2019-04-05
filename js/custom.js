var myObj, i, x = "";

document.getElementById("demo").innerHTML = x;
console.log(myObj);

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
                      console.log('has property');
                      element.appendChild(definition);
                      element.setAttribute("class", "has-definition");
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
