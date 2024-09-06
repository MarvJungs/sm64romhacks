document.addEventListener('DOMContentLoaded', function () {
    if(!hasCookie('hasConsent')) {
        const main = document.getElementsByTagName('main')[0];
        const card = document.createElement('div');
        const cardBody = document.createElement('div');
        const cardText = document.createElement('p');
        const acceptButton = document.createElement('button');
        const rejectButton = document.createElement('button');

        card.setAttribute('class', 'card p-2');

        cardBody.setAttribute('class', 'card-body');

        cardText.setAttribute('class', 'card-text');
        cardText.innerHTML = 'This site uses cookies. Cookies may only be used for certain functionalities for privacy reasons. Some Content may not be available for you if you decline but most content remains available. For more information about cookies, please visit <a href="https://gdpr.eu/cookies/">https://gdpr.eu/cookies/</a>';
        
        acceptButton.setAttribute('class', 'btn btn-success card-link');
        acceptButton.innerText = 'Accept';
        acceptButton.addEventListener('click', () => {
            setCookie('hasConsent', true, '365');
            this.location.reload();
        });

        rejectButton.setAttribute('class', 'btn btn-danger card-link');
        rejectButton.innerText = 'Reject';
        rejectButton.addEventListener('click', () => {
            card.remove();
        });
        
        cardBody.appendChild(cardText);
        cardBody.appendChild(acceptButton);
        cardBody.appendChild(rejectButton);

        card.appendChild(cardBody);

        main.insertBefore(card, main.firstChild);
        
    }
});

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function hasCookie(cname) {
    let cookie = getCookie(cname);
    if (cookie != "") {
        return true;
    } else {
        return false;
    }
}