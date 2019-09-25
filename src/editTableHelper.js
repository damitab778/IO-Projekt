const showTableEditor = function() {
    const ld=new Number(document.getElementById("iledzieci").innerHTML);
    if(ld>0){
    document.getElementById("userTable").id="userTable--hide";
    document.getElementById("btnEditTable").id="btnEditTable--hide";
    document.getElementById("userTableEditor--hide").id="userTableEditor";
    document.getElementById("btnEditDecision--hide").id="btnEditDecision";
    }
}

const hideTableEditor = function() {
    document.getElementById("userTable--hide").id="userTable";
    document.getElementById("btnEditTable--hide").id="btnEditTable";
    document.getElementById("userTableEditor").id="userTableEditor--hide";
    document.getElementById("btnEditDecision").id="btnEditDecision--hide";
}

const whichSchool = function(){
    let i=0;
    var school = document.getElementById(`szkola${i}`);
    let select;
    while(school!==null){
        select = document.getElementById(`szkolaDoEdycji${i}`);
        for(let i=0; i<select.length; ++i)
        select[i].innerHTML===school.innerHTML
        ?   select[i].setAttribute("selected", "selected")
        :   console.log("Not this school");
        ++i;
        school = document.getElementById(`szkola${i}`);
    }
}

const cutCurrency = (str) => {
    str=str.split(" ",1);
    return new Number(str);
}

const whichAmount = function(){
    let i=0;
    var amount = document.getElementById(`kwota${i}`);
    let inputNumber;
    while(amount!==null){
        inputNumber = document.getElementById(`kwotaDoEdycji${i}`);
        inputNumber.setAttribute("value",cutCurrency(amount.innerHTML));
        ++i;
        amount = document.getElementById(`kwota${i}`);
    }
}

const resetEditTable = function(){
    document.getElementById("btnEditTable").addEventListener("click",()=>{
    
        whichAmount();
        whichSchool();
    
        return true;
    });
}

resetEditTable();