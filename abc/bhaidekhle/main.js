var x="abc";
var y="xyz";

function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("left").style.marginLeft = "200px";
    document.getElementById("right").style.marginRight = "-100px";
    //document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.getElementById("left").style.marginLeft = "0";
    document.getElementById("right").style.marginRight = "0";
    //document.body.style.backgroundColor = "white";
}

function splitinit(){

   document.getElementById("left").style.display="block";
   document.getElementById("right").style.display="block";
   document.getElementById("leftreplace").style.display="none";
   document.getElementById("rightreplace").style.display="none";
}

function ifright(){

   document.getElementById("left").style.display="none";
   document.getElementById("leftreplace").style.display="block";
}

function ifleft(){

   document.getElementById("right").style.display="none";
   document.getElementById("rightreplace").style.display="block";
}

function xytoggle(x,y){
    document.getElementById(x).style.display="none";
    document.getElementById(y).style.display="block";
}

function toggle(x){
  if(document.getElementById(x).style.display=="none")
  {
      document.getElementById(x).style.display="block";    
  }
  else if(document.getElementById(x).style.display=="block")
  {
      document.getElementById(x).style.display="none";
  }
}

function display10(){
  document.getElementById("dis10b").innerHTML=document.getElementById("tenBoard").value;
  document.getElementById("dis10s").innerHTML=document.getElementById("tenSchool").value;
  document.getElementById("dis10m").innerHTML=document.getElementById("tenMarks").value;
}

function displaygrad(){
  document.getElementById("gradhq").innerHTML=document.getElementById("hqgrad").value;
  document.getElementById("gradc").innerHTML=document.getElementById("cgrad").value;
  document.getElementById("grads").innerHTML=document.getElementById("sgrad").value;
  document.getElementById("gradu").innerHTML=document.getElementById("ugrad").value;
  document.getElementById("gradc").innerHTML=document.getElementById("cgrad").value;
  document.getElementById("gradp").innerHTML=document.getElementById("pgrad").value;
  document.getElementById("grady").innerHTML=document.getElementById("ygrad").value;

}