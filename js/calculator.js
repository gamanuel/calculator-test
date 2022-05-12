'use strict';

document.addEventListener('DOMContentLoaded', e => {

    const CALCULATOR_NUMBERS = document.querySelectorAll('.calculator-number');
    const CALCULATOR_OPERATORS = document.querySelectorAll('.calculator-operator');
    const CALCULATOR_DISPLAY = document.querySelector('#calculator-display');
    const BTN_EQUAL = document.querySelector('#btn-equal');
    const BTN_CLEAR = document.querySelector('#btn-clear');
    const ERROR_MESSAGE = document.querySelector('#error-message');

    let inProcess = false;

    let calculator_operation = {
        first_number: '',
        second_number: '',
        operator: '',
    }

    CALCULATOR_NUMBERS.forEach(input => {
        if(inProcess){
            return;
        }

        input.addEventListener('click', () => {
            (!calculator_operation.operator)
            ? calculator_operation.first_number += input.value
            : calculator_operation.second_number += input.value;

            displayOperation();
        });
    });

    CALCULATOR_OPERATORS.forEach(input => {
        if(inProcess){
            return;
        }

        input.addEventListener('click', () => {
            calculator_operation.operator = input.value;

            displayOperation();
        });
    });

    BTN_EQUAL.addEventListener('click', () => {
        if(inProcess || !calculator_operation.first_number || !calculator_operation.operator || !calculator_operation.second_number){
            return;
        }

        if(!ERROR_MESSAGE.classList.contains('d-none')){
           ERROR_MESSAGE.classList.add('d-none');
        }

        requestOperation().then(response => {
            clearOperation();
            calculator_operation.first_number = response.result;
            displayOperation();
            inProcess = false;
        }, err => {
            inProcess = false;
            ERROR_MESSAGE.classList.remove('d-none');
            console.error(err);
        });
    });

    BTN_CLEAR.addEventListener('click', () => {
        if(inProcess){
            return;
        }

        clearOperation();
        displayOperation(false);
    });

    function clearOperation(){
        calculator_operation.first_number = '';
        calculator_operation.second_number = '';
        calculator_operation.operator = '';
    }

    function displayOperation(flag = true){
        if(flag){
            CALCULATOR_DISPLAY.value = `${calculator_operation.first_number} ${calculator_operation.operator} ${calculator_operation.second_number}`.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

            return;
        }

        CALCULATOR_DISPLAY.value = 0;
    }

    async function requestOperation() {
        inProcess = true;
        let data = new FormData();
        data.append('first_number',calculator_operation.first_number);
        data.append('operator',calculator_operation.operator);
        data.append('second_number',calculator_operation.second_number);

        let response = await fetch('api/operation', {
            method: 'POST',
            body: data
        });
        return await response.json();
    }
});