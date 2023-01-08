/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import 'bootstrap-icons/font/bootstrap-icons.css';

require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});

document.getElementById('watchlist').addEventListener('click', addtoWatchlist);

function addToWatchlist(e) { //e for event
    e.preventDefault(); //désactive le fonctionnement normal du lien : permet de rester sur la page

    const watchlistLink = e.currentTarget;
    const link = watchlistLink.href;
    //Envoie une requête HTTP avec fetch à l'URL défini dans le href

    try {
        fetch(link)
            //Récupère le JSON de la réponse HTTP
            .then(res => res.json())
            .then(data => {
                const watchlistIcon = watchlistLink.firstElementChild;
                if (data.isInWatchlist) {
                    watchlistIcon.classList.remove("bi-heart"); //Supprime le coeur vide
                    watchlistIcon.classList.add("bi-heart-fill"); //Ajoute le coeur plein
                } else {
                    watchlistIcon.classList.remove("bi-heart-fill");
                    watchlistIcon.classList.add("bi-heart");
                }
            });
    } catch (err) {
        console.error(err);
    }
}

/* import logoPath from '../images/logo.png';

let html = `<img src="${logoPath}" alt="ACME logo">`;
 */

