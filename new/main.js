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