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


//winkelmandje

// let winkelmandje = document.querySelector('#winkelmandje');
// let select = document.querySelector('#selectMailbox');
// let mailbox = document.querySelector('#mailbox');


// select.addEventListener('change', (e) => {
//     e.preventDefault();

//     if(select.value === 'true'){
//        mailbox.classList.remove('hidden');
//     }
//     if(select.value === 'false'){
//         mailbox.classList.add('hidden');
//     }
    
// })

let items = document.querySelectorAll('#winkelmandje');

items.forEach((item) => {
    let deleteBtn = item.querySelector('.delete');
    let domain = item.querySelector('.domein');
    deleteBtn.addEventListener('click', (e) => {
        e.preventDefault();
        domain.value = "";
        item.classList.add('hidden');
    })

});


//emailadd

let emailAddBtn = document.querySelector('.emailAddBtn');
let emailAdd = document.querySelector('#emailAdd');

if(emailAddBtn !== null){
    emailAddBtn.addEventListener('click', (e) => {
        e.preventDefault();
        emailAdd.classList.remove('hidden');
        window.location.href = '#emailAdd';
    });
}



//emaildelete

// let emails = document.querySelectorAll('#emailBoxes');

// emails.forEach((email) => {

//     let deleteBtn = email.querySelector('.emailDeleteBtn');
//     deleteBtn.addEventListener('click', (e) => {
//         e.preventDefault();
        
//         //formdata verzenden;
        

//             //email.classList.add('hidden');

//     });
// })

//dns ass input field

let dnsAdd = document.querySelector('.dnsAdd');
let addDNSBtn = document.querySelector('.dnsAddBtn');

if(addDNSBtn !== null){
    addDNSBtn.addEventListener('click', (e) => {
        e.preventDefault();
        dnsAdd.classList.remove('hidden');
    });
    
}

//dns edit 

let editDNSBtns = document.querySelectorAll('.editDNSBtn');

let editForms = document.querySelectorAll('.editDns');

if(editForms !== null){
    editForms.forEach((edit) => {
        let deleteBtn = edit.querySelector('.dnsDelete');
        deleteBtn.addEventListener('click', (e) => {
            e.preventDefault();
            //popup laten verschijnen
            let number = deleteBtn.dataset.number;
            let modalDns = document.querySelector('.modal--deleteDns--'+number);
            modalDns.classList.remove('hidden');
        });
        
    
        edit.classList.add('hidden');
    })
}

if(editDNSBtns !== null){
    editDNSBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            let number = btn.dataset.number;
            let edit = document.querySelector(`.editDns--${number}`);
            editForms.forEach((forms) => {
                forms.classList.add('hidden');
            })
            edit.classList.remove('hidden');
        })
    })
}

let cancelDnsBtns = document.querySelectorAll('.cancelDnsBtn');

if(cancelDnsBtns !== null){
    cancelDnsBtns.forEach((btn) =>{
        btn.addEventListener('click', (e) => {
            let number = btn.dataset.number;
            let modal = document.querySelector('.modal--deleteDns--'+number)
            modal.classList.add('hidden');
        })
    })
}

//domain delete

let domainDeleteBtn = document.querySelector('.deleteDomainBtn');
let modalDomain = document.querySelector('.modal--deleteDomain');
if(domainDeleteBtn !== null){
    domainDeleteBtn.addEventListener('click', (e) => {
        e.preventDefault(); 
        modalDomain.classList.remove('hidden');
    })
}

let cancelDomainBtn = document.querySelector('.cancelDomainbtn');
if(cancelDomainBtn !== null){
    cancelDomainBtn.addEventListener('click', (e) =>{
        modalDomain.classList.add('hidden');
    })
    
}

//email delete

let deleteEmailBtns = document.querySelectorAll('.deleteEmailBtn');

if(deleteEmailBtns !== null){
deleteEmailBtns.forEach((btn) => {
    btn.addEventListener('click', (e) =>{
        e.preventDefault();
        let number = btn.dataset.number;
        let modal = document.querySelector('.modal--deleteEmail--'+number);
        modal.classList.remove('hidden');
    })
})
}

let cancelEmailBtns = document.querySelectorAll('.cancelEmailbtn');

if(cancelEmailBtns !== null){
    cancelEmailBtns.forEach((btn) =>{
        btn.addEventListener('click', (e) => {
            let number = btn.dataset.number;
            let modal = document.querySelector('.modal--deleteEmail--'+number)
            modal.classList.add('hidden');
        })
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


//zoekfunctie facturen
let searchFieldFactuur = document.querySelector('.search__form--factuur');

let inputFactuur = searchFieldFactuur.querySelector('.search__input');
let btnFactuur = searchFieldFactuur.querySelector('.search__btn');
let facturen = document.querySelectorAll('.facturen');


inputFactuur.addEventListener('keyup', (e) => {
    e.preventDefault();
    let value = inputFactuur.value;
    searchFactuur(value, facturen);
    
});

btnFactuur.addEventListener('click', (e) => {
    e.preventDefault();
    let value = inputFactuur.value;
    searchFactuur(value, facturen);
})

function searchFactuur(value, facturen){
    facturen.forEach((factuur) => {
        factuur.classList.add('hidden');

        let number = factuur.querySelector('.factuur__number').innerHTML;
        let name = factuur.querySelector('.factuur__name').innerHTML;
        let amount = factuur.querySelector('.factuur__amount').innerHTML;
        let date = factuur.querySelector('.factuur__date').innerHTML;
        let status = factuur.querySelector('.factuur__status').innerHTML;

        let filterNumber = number.toLowerCase().indexOf(value.toLowerCase());
        let filterName = name.toLowerCase().indexOf(value.toLowerCase());
        let filterAmount = amount.toLowerCase().indexOf(value.toLowerCase());
        let filterDate = date.toLowerCase().indexOf(value.toLowerCase());
        let filterStatus = status.toLowerCase().indexOf(value.toLowerCase());

        if(filterNumber > -1 || filterName > -1 || filterAmount > -1 || filterDate > -1 || filterStatus > -1){
            factuur.classList.remove('hidden');
        }


    })
}


