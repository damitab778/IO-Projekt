const polishLettersRegion = ()=>{
    var region = document.getElementById("regionText").innerHTML;
if(region==="dolnoslaskie"){
    document.getElementById("regionText").innerHTML="dolnośląskie";
}
else if(region==="slaskie"){
    document.getElementById("regionText").innerHTML="śląskie";
}
else if(region==="lodzkie"){
    document.getElementById("regionText").innerHTML="łódzkie";
}
else if(region==="warminsko-mazurskie"){
    document.getElementById("regionText").innerHTML="warmińsko-mazurskie";
}
else if(region==="malopolskie"){
    document.getElementById("regionText").innerHTML="małopolskie";
}
else if(region==="swietokrzyskie"){
    document.getElementById("regionText").innerHTML="świętokrzyskie";
}
return document.getElementById("regionText").innerHTML;
}
polishLettersRegion();

const showRegionEditor = function() {
    document.getElementById("formEdit--hide").id="formEdit";
    document.getElementById("btnEdit").id="btnEdit--hide";
    document.getElementById("regionText").id="regionText--hide";

}

const hideRegionEditor = function() {
    document.getElementById("formEdit").id="formEdit--hide";
    document.getElementById("btnEdit--hide").id="btnEdit";
    document.getElementById("regionText--hide").id="regionText";
    polishLettersRegion();
}


const whichOption = function(region){
    var select = document.getElementById("region");
    for(let i=0; i<select.length; ++i)
        select[i].innerHTML===region
        ?   select[i].setAttribute("selected", "selected")
        :   console.log("No");
}

var woj = document.getElementById("regionText").innerHTML;

document.getElementById("btnEdit").addEventListener("click",()=>whichOption(woj));