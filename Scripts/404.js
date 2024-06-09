"use strict";
// [+] For Better Performance 
const $ = document;

// [+] Defining Variables
const homeButton = $.querySelector(".page-not-found__button--home");
const backButton = $.querySelector(".page-not-found__button--back");
// [+] Functions
function goHomeHandler(){
    location.replace("index.html");
}
function goBackHandler(){
    history.back();
}
// [+] Events
homeButton.addEventListener("click", goHomeHandler);
backButton.addEventListener("click", goBackHandler);