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









