'use strict';

document.addEventListener('DOMContentLoaded', e => {

    const HISTORY_CONTAINER = document.querySelector('#historyContainer');

    history();

    function history(){
        requestHistory().then(response => {
            console.log(response);
            displayHistory(response.history);
        }, err => {
            console.error(err);
            ERROR_MESSAGE.classList.remove('d-none');
        });
    }

    function displayHistory(historyArr){
        HISTORY_CONTAINER.innerHTML = '';

        if(historyArr.length === 0){
            let p = document.createElement("p");
            p.innerHTML = 'Records not found';
            HISTORY_CONTAINER.appendChild(p);
            return;
        }

        historyArr.forEach(historyItem => {
            let p = document.createElement("p");
            p.innerHTML = `${historyItem.first_number} ${historyItem.operator} ${historyItem.second_number} = ${historyItem.result}`.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            HISTORY_CONTAINER.appendChild(p);
        });
    }

    async function requestHistory() {
        let response = await fetch('api/history', {
            method: 'GET',
        });
        return await response.json();
    }
});