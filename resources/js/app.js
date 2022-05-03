const { add, findLastIndex, isSet } = require('lodash');

require('./bootstrap');

// //loader
// let loader_container = document.querySelector('.loader__container');

//fadein funtie
//bron: http://jsfiddle.net/TH2dn/606/
function fadeIn(el, time) {
    el.style.opacity = 0;
  
    var last = +new Date();
    var tick = function() {
      el.style.opacity = +el.style.opacity + (new Date() - last) / time;
      last = +new Date();
  
      if (+el.style.opacity < 1) {
        (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
      }
    };
  
    tick();
  }
  
 


//loading domeindetail
let domainDetailBtns = document.querySelectorAll('.domainDetailBtn');
if(domainDetailBtns !== null){
    let loader__container = document.querySelector('.loader__container');
    domainDetailBtns.forEach((btn) => {
        
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            let domain = btn.dataset.domain;
            loader__container.style.display = "flex";
            fadeIn(loader__container, 200);
            window.location.href = "/domein/"+domain;
        })

    })
}

//loading search domein
let domainSearchBtn = document.querySelector('.domainSearchBtn');

if(domainSearchBtn !== null){
    let loader__container = document.querySelector('.loader__container');
    domainSearchBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loader__container.style.display = "flex";
        fadeIn(loader__container, 200);
        document.querySelector(".searchDomain").submit(); 
    });
}

//loading nameserver update
let nameserverUpdateBtn = document.querySelector('.nameserverUpdateBtn');
if(nameserverUpdateBtn !== null){
    let loader__container = document.querySelector('.loader__container');
    nameserverUpdateBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loader__container.style.display = "flex";
        fadeIn(loader__container, 200);
        document.querySelector(".nameserverUpdate").submit(); 
    });
}


//tickets samenvoegen
let ticketsMerge = document.querySelectorAll('.ticket--merge');

if(ticketsMerge != null){
    ticketsMerge.forEach((ticket) => {
        ticket.addEventListener('click', (e) => {
            ticketsMerge.forEach((t) => {
                t.style.scale = "1";
            });
            ticket.style.scale = "0.9";
            let id = ticket.dataset.id;
            document.querySelector('.ticket2').value = id;
        })
    })
}

//tickets/timeline
let agentTickets = document.querySelector('.agentTickets');
let agentTimeline = document.querySelector('.agentTimeline'); 

let ticketsBtn = document.querySelector('.ticketsBtn');
let timelineBtn = document.querySelector('.timelineBtn');

if(timelineBtn !== null){
timelineBtn.addEventListener('click', (e) => {
    e.preventDefault();
    agentTickets.classList.add('hidden');
    agentTimeline.classList.remove('hidden');

    ticketsBtn.classList.remove('menu--horizontal--active');
    timelineBtn.classList.add('menu--horizontal--active');
})
}

if(ticketsBtn !== null){
    ticketsBtn.addEventListener('click', (e) => {
        e.preventDefault();
        agentTimeline.classList.add('hidden');
        agentTickets.classList.remove('hidden');

        timelineBtn.classList.remove('menu--horizontal--active');
        ticketsBtn.classList.add('menu--horizontal--active');
    })
}

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

//zoekfunctie dns
let searchFieldDns = document.querySelector('.search__form--dns');

if(searchFieldDns !== null){

let inputDns = searchFieldDns.querySelector('.search__input');
let btnDns = searchFieldDns.querySelector('.search__btn');
let dnss = document.querySelectorAll('.dns');


inputDns.addEventListener('keyup', (e) => {
    e.preventDefault();
    let value = inputDns.value;
    searchDns(value, dnss);
});

btnDns.addEventListener('click', (e) => {
    e.preventDefault();
    let value = inputDns.value;
    searchDns(value, dnss);
})

function searchDns(value, dnss){
    dnss.forEach((dns) => {
        dns.classList.add('hidden');

        let type = dns.querySelector('.dns__type').innerHTML;
        let name = dns.querySelector('.dns__name').innerHTML;
        let content = dns.querySelector('.dns__content').innerHTML;
        let ttl = dns.querySelector('.dns__ttl').innerHTML;
        

        let filterType = type.toLowerCase().indexOf(value.toLowerCase());
        let filterName = name.toLowerCase().indexOf(value.toLowerCase());
        let filterContent = content.toLowerCase().indexOf(value.toLowerCase());
        let filterTtl = ttl.toLowerCase().indexOf(value.toLowerCase());
        

        if(filterType > -1 || filterName > -1 || filterContent > -1 || filterTtl > -1){
            dns.classList.remove('hidden');
        }


    })
}
}

//dns ass input field

let dnsAdd = document.querySelector('.dnsAdd');
let addDNSBtn = document.querySelector('.dnsAddBtn');

if(addDNSBtn !== null){
    addDNSBtn.addEventListener('click', (e) => {
        e.preventDefault();
        dnsAdd.classList.remove('hidden');
        let editDNS = document.querySelectorAll('.editDns');
        editDNS.forEach((d) => {
            d.classList.add('hidden');
        })
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
            document.querySelector('.dnsAdd').classList.add('hidden');
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
let searchFieldTicket = document.querySelector('.search__form--ticket');

if(searchFieldTicket !== null){
    let inputTicket = searchFieldTicket.querySelector('.search__input');
    let btnTicket = searchFieldTicket.querySelector('.search__btn');
    let tickets = document.querySelectorAll('.ticket');
    btnTicket.addEventListener('click', (e) => {
        e.preventDefault();
        let value = inputTicket.value;
        searchTicket(value, tickets);
    })

    inputTicket.addEventListener('keyup', (e) => {
        e.preventDefault();
        let value = inputTicket.value;
        searchTicket(value, tickets);
    })

    function searchTicket(value, tickets){
        tickets.forEach((ticket) => {
            ticket.classList.add('hidden');
    
            let status = ticket.querySelector('.ticket__status').innerHTML;
            let title = ticket.querySelector('.ticket__title').innerHTML;
            
    
            let filterStatus = status.toLowerCase().indexOf(value.toLowerCase());
            let filterTitle = title.toLowerCase().indexOf(value.toLowerCase());
            
    
            if(filterStatus > -1 || filterTitle > -1){
                ticket.classList.remove('hidden');
            }
    
    
        })
    }
}

//ticket agent delete
let ticketDeleteBtn = document.querySelector('.deleteTicketBtn');
let modalTicket = document.querySelector('.modal--deleteTicket');
if(ticketDeleteBtn !== null){
    ticketDeleteBtn.addEventListener('click', (e) => {
        e.preventDefault(); 
        modalTicket.classList.remove('hidden');
    })
}

let cancelTicketBtn = document.querySelector('.cancelTicketbtn');
if(cancelTicketBtn !== null){
    cancelTicketBtn.addEventListener('click', (e) =>{
        modalTicket.classList.add('hidden');
    })
    
}

//zoekfunctie tickets agents
let searchFieldTicketAgent = document.querySelector('.search__form--agent');

if(searchFieldTicketAgent !== null){
    let inputTicket = searchFieldTicketAgent.querySelector('.search__input');
    let btnTicket = searchFieldTicketAgent.querySelector('.search__btn');
    let tickets = document.querySelectorAll('.ticket--agent');
    btnTicket.addEventListener('click', (e) => {
        e.preventDefault();
        let value = inputTicket.value;
        searchTicket(value, tickets);
    })

    inputTicket.addEventListener('keyup', (e) => {
        e.preventDefault();
        let value = inputTicket.value;
        searchTicket(value, tickets);
    })

    function searchTicket(value, tickets){
       
        tickets.forEach((ticket) => {
            ticket.style.display = "none";
    
            let info = ticket.querySelector('.ticket__subject').innerHTML;
            let sender = ticket.querySelector('.ticket__sender').innerHTML;
            
            let filterInfo = info.toLowerCase().indexOf(value.toLowerCase());
            let filterSender = sender.toLowerCase().indexOf(value.toLowerCase());
            
            if(filterInfo > -1 || filterSender > -1){
                ticket.style.display = "grid";
            }
    
    
        })
    }
}

//filter tickets agent
let filterSelect = document.querySelector('.filterSelect');

if(filterSelect !== null){
    let url = document.location.href;
    let realUrl = url.split("?")[0];
    filterSelect.addEventListener('change', (e) => {
        e.preventDefault();
        let filter = filterSelect.value;
        window.location.href = realUrl + "?filter="+filter;
    })
}





//zoekfunctie facturen
let searchFieldFactuur = document.querySelector('.search__form--factuur');

if(searchFieldFactuur !== null){

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

}

//zoekfuncite offertes
let searchFieldOfferte = document.querySelector('.search__form--offerte');

if(searchFieldOfferte !== null){
    let inputOfferte = searchFieldOfferte.querySelector('.search__input');
    let btnOfferte = searchFieldOfferte.querySelector('.search__btn');
    let offertes = document.querySelectorAll('.offerte');

    inputOfferte.addEventListener('keyup', (e) => {
        e.preventDefault();
        let value = inputOfferte.value;
        searchOfferte(value, offertes);
        
    });
    
    btnOfferte.addEventListener('click', (e) => {
        e.preventDefault();
        let value = inputOfferte.value;
        searchOfferte(value, offertes);
    })

    function searchOfferte(value, offertes){
        offertes.forEach((offerte) => {
            offerte.classList.add('hidden');
            
            let title = offerte.querySelector('.offerte__title').innerHTML;
            let reference = offerte.querySelector('.offerte__reference').innerHTML;
            let amount = offerte.querySelector('.offerte__amount').innerHTML;
            let status = offerte.querySelector('.offerte__status').innerHTML;
            
            
    
            let filterTitle = title.toLowerCase().indexOf(value.toLowerCase());
            let filterReference = reference.toLowerCase().indexOf(value.toLowerCase());
            let filterAmount = amount.toLowerCase().indexOf(value.toLowerCase());
            let filterStatus = status.toLowerCase().indexOf(value.toLowerCase());
            
    
            if(filterTitle > -1 || filterReference > -1 || filterAmount > -1 || filterStatus > -1){
                offerte.classList.remove('hidden');
            }
    
    
        })
    }
}
