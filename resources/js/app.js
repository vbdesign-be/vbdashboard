const { add } = require('lodash');

require('./bootstrap');



//faq opnenen

let faqs = document.querySelectorAll('#faq-item');

faqs.forEach((faq) => {
    let btn = faq.querySelector('#btn');
    let answer = faq.querySelector("#answer")
    let click = 0;

    btn.addEventListener('click', (e) =>{

        

        if(!click){
            answer.classList.remove('hidden');
            click = 1;
        }else if(click){
            answer.classList.add('hidden');
            click = 0;
        }
        
        
    })
    
})


//profile form

let selectBtn = document.querySelector('.selectForm');
let userForm = document.querySelector('.form--user');
let companyForm = document.querySelector('.form--company');

if(selectBtn){

selectBtn.addEventListener('click', (e) => {
    let value = selectBtn.value;
    
    if(value === "profiel"){
        companyForm.style.display = "none";
        userForm.style.display = "block";
    }else if(value === "company"){
        companyForm.style.display = "block";
        userForm.style.display = "none";
    }
})
}



//addTicket

let addTicketBtn = document.querySelector('.addTicketBtn');

if(addTicketBtn !== null){
    addTicketBtn.addEventListener('click', (e) => {
        e.preventDefault();
        let addTicket = document.querySelector('.form--addTicket');
        addTicket.classList.remove('hidden');
    })
}



//zoekfunctie tickets
let searchTicket = document.querySelector('.search__form--ticket');

if(searchTicket !== null){
    let inputField = document.querySelector('.search__input');
    let searchBtn = document.querySelector('.search__btn')

    searchBtn.addEventListener('click', (e) => {
        e.preventDefault();
        let input = inputField.value;
        let tickets = document.querySelectorAll('.ticket');
        tickets.forEach((ticket) => {
            searchTickets(ticket, input);
        })
    })

    inputField.addEventListener('keyup', (e) => {
        let input = inputField.value;
        let tickets = document.querySelectorAll('.ticket');
        tickets.forEach((ticket) => {

            searchTickets(ticket, input);
            
        })
    })

    function searchTickets(ticket, input){
        ticket.classList.add('hidden');
            
            let title = ticket.querySelector('.ticket__title').innerHTML;
            let text = ticket.querySelector('.ticket__text').innerHTML;
            let status = ticket.querySelector('.ticket__status').innerHTML;
            
            let filterTitle = title.toLowerCase().indexOf(input.toLowerCase());
            let filterText = text.toLowerCase().indexOf(input.toLowerCase());
            let filterStatus = status.toLowerCase().indexOf(input.toLowerCase());

            if(filterTitle > -1 || filterText > -1 || filterStatus > -1){
                ticket.classList.remove('hidden');
            }
    }
}




