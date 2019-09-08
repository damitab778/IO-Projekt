function ilebachorow(){
    const LICZBA = document.getElementById("ld").value;
    var tekst="";
        if(LICZBA>0){
            for(i=0;i<LICZBA;++i) {
            tekst+=`
            <div class="row">
                <label for="dziecko${i}" class="dzieckoLabel">Dziecko ${i+1}.</label>  
                <div id="dziecko${i}" class="dziecko">
                    <label for="szkola${i}" class="secondLabel">Szkoła: </label>
                    <select id="szkola${i}" class="custom-select" name="szkola${i}">
                       <option>Podstawowka</option>
                       <option>Gimnazjum</option>
                       <option>Liceum lub Technikum</option>
                       <option>Szkola wyzsza</option>
                    <td>
                    </select>
                    <label for="kwota${i}" class="secondLabel">Kwota kieszonkowego: </label>
                    <!--<select id="kwota${i}" class="custom-select" name="kwota${i}" >
                       <option>10</option>
                       <option>20</option>
                       <option>40</option>
                       <option>60</option>
                       <option>80</option>
                       <option>100</option>
                    </select>-->
                    <input type="number" min="10" max="5000" placeholder="[10-5000] zł" step="10" id="kwota${i}" name="kwota${i}">
                </div>
            </div>`;
            }
            document.getElementById("listaDodawaniaDzieci").innerHTML=tekst;
            
        }
        else document.getElementById("listaDodawaniaDzieci").innerHTML="Nie masz dzieci!";
    }