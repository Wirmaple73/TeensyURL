"use strict";
// [+] For Better Performance 
const $ = document;

// [+] Defining Variables
const homeButton = $.querySelector(".page-not-found__button--home");

// [+] Functions
function goHomeHandler(){
    location.replace("index.html");
}

// [+] Events
homeButton.addEventListener("click", goHomeHandler);