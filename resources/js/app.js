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







