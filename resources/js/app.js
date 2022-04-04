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
console.log(editDNSBtns);

if(editDNSBtns !== null){
    editDNSBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            
            let number = btn.dataset.number;
            let edit = document.querySelector(`.editDns--${number}`);
            edit.classList.remove('hidden');
        })
    })
}


















