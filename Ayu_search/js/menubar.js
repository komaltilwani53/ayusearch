let drugData = document.querySelector('.drug-data');
let biologicalData = document.querySelector('.biological');

function selectDrug(){
    if(drugData.classList[0].includes('show')){
        drugData.classList = ['hide drug-data annot'];
    }else{
        drugData.classList = ['show drug-data annot'];
    }
}
function selectBiological(){
    if(biologicalData.classList[0].includes('show')){
        biologicalData.classList = ['hide biological annot'];
    }else{
        biologicalData.classList = ['show biological annot'];
    }
}
console.log("hey");
let emp ={} ;
emp.name="success";
// console.log();
const test=document.querySelector("#p_name");

test.addEventListener("change",function(){
    let val=document.querySelector("#p_name").value;
    console.log(val);
})

$.ajax({
    url:"index.php",
    method:"post",
    data:{emp:JSON.stringify(emp)}
})

