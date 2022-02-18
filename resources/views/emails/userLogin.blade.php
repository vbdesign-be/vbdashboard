<style>

body{
    background-color: #F6F7F8;
}

.mail{
    width:80%;
    margin-left:auto;
    margin-right:auto;
    background-color: white;
    box-shadow: 0px 0px 24px -6px rgba(0,0,0,0.09);
    padding:25px;
    margin-top:100px;
    margin-bottom:150px;
}

.mail__title{
    color: #2F4858;
    font-family: 'DM Sans', sans-serif;
    font-size: 36px;
    text-align:center;
}

.mail__text{
    color: #2F4858;
    font-family: 'DM Sans', sans-serif;
    font-size: 18px;
    text-align: center;
}

.mail__btn{
    display:flex;
    justify-content: center;
    margin-top:50px;
}

.btn{
    background-color: #2F4858;
    border-radius: 30px;
    padding: 10px 20px 10px 20px;
    color:white;
    border:none;
    font-size: 24px;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
}

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

</style>

<div class="mail__image__container">
    <img class="mail__image" src="{{ asset('img/vblogo.svg') }}" alt="">
</div>


<div class="mail">
    <h1 class="mail__title">Hallo {{ $user->firstname }}</h1>
    <p class="mail__text">Klik op de knop om in te loggen op het dashboard</p>
    <div class="mail__btn">
        <a class="btn" href="{{ $url }}">Login</a>
    </div>
</div>





