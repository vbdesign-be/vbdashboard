<style>
.mail__image__container{
    display: flex;
    justify-content: center;
    margin-top:10%;
    width:60%;
    margin-left:auto;
    margin-right:auto;
}

.mail__image{
    width:100%;
}

body{
    background-color: #F6F7F8;
    color: #2F4858;
    font-family: 'DM Sans', sans-serif;
}

.mail{
    width:80%;
    margin-left:auto;
    margin-right:auto;
    background-color: white;
    box-shadow: 0px 0px 24px -6px rgba(0,0,0,0.09);
    padding:25px;
    margin-top:100px;
    margin-bottom:100px;
    padding-bottom:100px
}

.mail__title{
    text-align:center;
}

.mail__info{
    width: 90%;
    margin-left: auto;
    margin-right: auto;
    text-align:center;
    justify-content:center;
}

.mail__info__list{
    list-style: none;
    padding-left:0px;
    margin-bottom:25px;
}

.mail__info__list li{
    margin-bottom:5px;
}

.mail__body{
    margin-top:50px;
}

.mail__body__title{
    text-align:center;
}

.mail__body__text{
    width:90%;
    margin-left:auto;
    margin-right:auto;
    
}

.mail__body__extra{
    display:grid;
    font-size:18px;
    width:90%;
    margin-left:auto;
    margin-right:auto;
}

.mail__body__extra__right{
    justify-self: end;
}

@media(min-width: 800px){
    .mail__info{
    width: 90%;
    display:grid;
    grid-template-columns: 1fr 1fr 1fr;
    margin-left: auto;
    margin-right: auto;
    text-align:left;
    
}

.mail__info__list:last-child{
    justify-self: end;
    text-align: right;
}

.mail__body__text{
    width:90%;
    margin-left:auto;
    margin-right:auto;
    
}

.mail__body__extra{
    display:grid;
    grid-template-columns: 1fr 1fr;
    font-size:18px;
    width:90%;
    margin-left:auto;
    margin-right:auto;
}
}




</style>

<div class="mail__image__container">
    <img class="mail__image" src="{{ asset('img/vblogo.svg') }}" alt="">
</div>

<div class="mail">
    <h1 class="mail__title">Offerte aanvraag</h1>
    <div class="mail__info">
        <ul class="mail__info__list">
            <li>{{ $user->last_name }}  {{ $user->first_name }}</li>
            <li>{{ $user->emails[0]->email }}</li>
            <li>{{ $position }}</li>
        </ul>
        <ul></ul>
        <ul class="mail__info__list">
            <li>{{ $company->name }}</li>
            <li>{{ $company->vat_number }}</li>
            <li>{{ $company->emails[0]->email }}</li>
            <li>{{ $company->website }}</li>
        </ul>
    </div>
    <div class="mail__body">
        <h1 class="mail__body__title">test offerte</h1>
        <p class="mail__body__text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.

Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.

Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat</p>
        <div class="mail__body__extra">
            <div>
                <p>Gewenste deadline:</p>
                <p class="mail__body__date">01-05-2022</p>
            </div>

            <div class="mail__body__extra__right">
                <p>Gewenste maximale kost:</p>
                <p class="mail__body__cost">€25</p>
            </div>
            
        </div> 
        

    </div>
</div>