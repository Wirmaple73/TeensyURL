// [+] Defining Variables
const resultUrlBox = document.querySelector(".url-result");
const copyLinkButton = document.querySelector(".url-result__button");

// [+] Functions
function generateShortUrl() {
    const targetUrl = document.getElementById("targetUrl").value;
    
    try {
        new URL(targetUrl);
    }
    catch {
        alert("The specified URL is invalid. Please ensure you have entered it properly (URL must be preceded by an internet protocol like https).");
        return;
    }
    
    fetch("api/UrlShortener.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ url: targetUrl })
    }).then(async (response) => {
        if (!response.ok) {
            alert(`An unknown error has occurred (${response.status}: ${response.statusText}). Please try again later.`);
            return;
        }
        
        let json = await response.json();

        if (json.errorMessage != null) {
            alert(`An error has occurred:\n${json.errorMessage}`);
            return;
        }

        const generatedUrlCaption = document.querySelector("#generatedUrl");
        generatedUrlCaption.innerHTML = generatedUrlCaption.href = json.generatedUrl;

        showModal();
    });
}

function showModal(){
    resultUrlBox.classList.add("url-result--active");

    copyLinkButton.addEventListener("click", () => {
        if(window.navigator.clipboard){
            navigator.clipboard.writeText(document.getElementById('generatedUrl').href);
        }
        hideModal();
    });
}
function hideModal(){
    resultUrlBox.classList.remove("url-result--active");
}
