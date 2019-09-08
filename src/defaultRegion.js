

const showRegionEditor = function() {
    document.getElementById("formEdit--hide").id="formEdit";
    document.getElementById("btnEdit").id="btnEdit--hide";
    document.getElementById("regionText").id="regionText--hide";

}

const hideRegionEditor = function() {
    document.getElementById("formEdit").id="formEdit--hide";
    document.getElementById("btnEdit--hide").id="btnEdit";
    document.getElementById("regionText--hide").id="regionText";
}


const whichOption = function(region){
    var select = document.getElementById("region");
    for(let i=0; i<select.length; ++i)
        select[i].innerHTML===region
        ?   select[i].setAttribute("selected", "selected")
        :   console.log("No");
}