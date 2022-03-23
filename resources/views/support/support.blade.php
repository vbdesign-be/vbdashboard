@extends('layouts/app')

@section('title', 'Support')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Support</h2>
          </div>
        </div>


        <section class="py-8">
          <div class="container px-4 mx-auto">

          <div class="mb-8 p-8 bg-indigo-500 rounded">
            <div class="flex flex-wrap items-center -mx-4">
              <div class="w-full lg:w-2/3 px-4">
                <h2 class="text-3xl text-white font-bold">Heb je hulp nodig?</h2>
                <p class="text-indigo-50">Hieronder helpen we je graag verder</p>
              </div>
              <div class="w-full lg:w-1/3 px-4 flex items-center">
                <img src="artemis-assets/images/office.png" alt=""></div>
            </div>
          </div>

          <div class="mb-8 flex flex-wrap items-center justify-center  gap-6">
            <a href="" class="titlecard w-5/12 rounded bg-white py-8 px-12 shadow">
              <h1 class="text-center font-bold text-3xl">Faq</h1>
              <p class="text-center mx-auto w-8/12 my-8 text-base">Hier vind je de meest gestelde vragen door onze klanten.</p>
              <img src="" alt="logo faqs">
            </a>

            <a href="" class="titlecard w-5/12 rounded bg-white py-8 px-12 shadow">
              <h1 class="text-center font-bold text-3xl">Tickets</h1>
              <p class="text-center mx-auto w-8/12 my-8 text-base">Hier kan je ons een vraag stellen en je vragen opvolgen.</p>
              <img src="" alt="logo faqs">
            </a>
            
            
          </div>

          <!-- <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-3/12 px-4 mb-8 lg:mb-0">
              <div class="p-2 bg-white rounded">
                <ul class="text-sm"><li>
                    <a class="flex p-3 items-center font-medium bg-indigo-50 rounded text-indigo-500" href="/faq">
                      <span class="mr-3">
                        <svg class="text-indigo-500" width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.6663 0.833338H3.33301C2.66997 0.833338 2.03408 1.09673 1.56524 1.56557C1.0964 2.03441 0.833008 2.6703 0.833008 3.33334V16.6667C0.833008 17.3297 1.0964 17.9656 1.56524 18.4344C2.03408 18.9033 2.66997 19.1667 3.33301 19.1667H16.6663C17.3294 19.1667 17.9653 18.9033 18.4341 18.4344C18.9029 17.9656 19.1663 17.3297 19.1663 16.6667V3.33334C19.1663 2.6703 18.9029 2.03441 18.4341 1.56557C17.9653 1.09673 17.3294 0.833338 16.6663 0.833338V0.833338ZM6.66634 17.5H3.33301C3.11199 17.5 2.90003 17.4122 2.74375 17.2559C2.58747 17.0996 2.49967 16.8877 2.49967 16.6667V15.6833C2.7669 15.7804 3.04872 15.8311 3.33301 15.8333H6.66634V17.5ZM6.66634 14.1667H3.33301C3.11199 14.1667 2.90003 14.0789 2.74375 13.9226C2.58747 13.7663 2.49967 13.5544 2.49967 13.3333V12.35C2.7669 12.447 3.04872 12.4977 3.33301 12.5H6.66634V14.1667ZM6.66634 10.8333H3.33301C3.11199 10.8333 2.90003 10.7455 2.74375 10.5893C2.58747 10.433 2.49967 10.221 2.49967 10V3.33334C2.49967 3.11232 2.58747 2.90036 2.74375 2.74408C2.90003 2.5878 3.11199 2.5 3.33301 2.5H6.66634V10.8333ZM11.6663 17.5H8.33301V12.5H11.6663V17.5ZM11.6663 10.8333H8.33301V2.5H11.6663V10.8333ZM17.4997 16.6667C17.4997 16.8877 17.4119 17.0996 17.2556 17.2559C17.0993 17.4122 16.8874 17.5 16.6663 17.5H13.333V15.8333H16.6663C16.9506 15.8311 17.2324 15.7804 17.4997 15.6833V16.6667ZM17.4997 13.3333C17.4997 13.5544 17.4119 13.7663 17.2556 13.9226C17.0993 14.0789 16.8874 14.1667 16.6663 14.1667H13.333V12.5H16.6663C16.9506 12.4977 17.2324 12.447 17.4997 12.35V13.3333ZM17.4997 10C17.4997 10.221 17.4119 10.433 17.2556 10.5893C17.0993 10.7455 16.8874 10.8333 16.6663 10.8333H13.333V2.5H16.6663C16.8874 2.5 17.0993 2.5878 17.2556 2.74408C17.4119 2.90036 17.4997 3.11232 17.4997 3.33334V10ZM14.9997 5.83334C14.8349 5.83334 14.6737 5.88221 14.5367 5.97378C14.3997 6.06535 14.2928 6.1955 14.2298 6.34777C14.1667 6.50004 14.1502 6.66759 14.1824 6.82925C14.2145 6.9909 14.2939 7.13938 14.4104 7.25593C14.527 7.37247 14.6754 7.45184 14.8371 7.48399C14.9987 7.51615 15.1663 7.49964 15.3186 7.43657C15.4708 7.3735 15.601 7.26669 15.6926 7.12965C15.7841 6.99261 15.833 6.83149 15.833 6.66667C15.833 6.44566 15.7452 6.2337 15.5889 6.07742C15.4326 5.92113 15.2207 5.83334 14.9997 5.83334ZM4.99967 7.5C5.16449 7.5 5.32561 7.45113 5.46265 7.35956C5.59969 7.26799 5.7065 7.13785 5.76957 6.98557C5.83265 6.8333 5.84915 6.66575 5.817 6.5041C5.78484 6.34244 5.70547 6.19396 5.58893 6.07742C5.47239 5.96087 5.3239 5.8815 5.16225 5.84935C5.0006 5.8172 4.83304 5.8337 4.68077 5.89677C4.5285 5.95984 4.39835 6.06665 4.30678 6.2037C4.21522 6.34074 4.16634 6.50185 4.16634 6.66667C4.16634 6.88768 4.25414 7.09965 4.41042 7.25593C4.5667 7.41221 4.77866 7.5 4.99967 7.5Z" fill="currentColor"></path></svg></span>
                      <span>Faq</span>
                    </a>
                  </li>
                  <li>
                    <a class="flex p-3 items-center font-medium hover:bg-indigo-50 rounded text-gray-500 hover:text-indigo-500" href="/ask">
                      <span class="mr-3">
                        <svg class="text-indigo-100" width="18" height="16" viewbox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8332 3.83333H13.9998V3C13.9998 2.33696 13.7364 1.70107 13.2676 1.23223C12.7988 0.763392 12.1629 0.5 11.4998 0.5H3.1665C2.50346 0.5 1.86758 0.763392 1.39874 1.23223C0.929896 1.70107 0.666504 2.33696 0.666504 3V3V13C0.666504 13.663 0.929896 14.2989 1.39874 14.7678C1.86758 15.2366 2.50346 15.5 3.1665 15.5H14.8332C15.4962 15.5 16.1321 15.2366 16.6009 14.7678C17.0698 14.2989 17.3332 13.663 17.3332 13V6.33333C17.3332 5.67029 17.0698 5.03441 16.6009 4.56557C16.1321 4.09673 15.4962 3.83333 14.8332 3.83333ZM3.1665 2.16667H11.4998C11.7209 2.16667 11.9328 2.25446 12.0891 2.41074C12.2454 2.56702 12.3332 2.77899 12.3332 3V3.83333H3.1665C2.94549 3.83333 2.73353 3.74554 2.57725 3.58926C2.42097 3.43298 2.33317 3.22101 2.33317 3C2.33317 2.77899 2.42097 2.56702 2.57725 2.41074C2.73353 2.25446 2.94549 2.16667 3.1665 2.16667V2.16667ZM15.6665 10.5H14.8332C14.6122 10.5 14.4002 10.4122 14.2439 10.2559C14.0876 10.0996 13.9998 9.88768 13.9998 9.66667C13.9998 9.44565 14.0876 9.23369 14.2439 9.07741C14.4002 8.92113 14.6122 8.83333 14.8332 8.83333H15.6665V10.5ZM15.6665 7.16667H14.8332C14.1701 7.16667 13.5342 7.43006 13.0654 7.8989C12.5966 8.36774 12.3332 9.00363 12.3332 9.66667C12.3332 10.3297 12.5966 10.9656 13.0654 11.4344C13.5342 11.9033 14.1701 12.1667 14.8332 12.1667H15.6665V13C15.6665 13.221 15.5787 13.433 15.4224 13.5893C15.2661 13.7455 15.0542 13.8333 14.8332 13.8333H3.1665C2.94549 13.8333 2.73353 13.7455 2.57725 13.5893C2.42097 13.433 2.33317 13.221 2.33317 13V5.35833C2.60089 5.45251 2.8827 5.50042 3.1665 5.5H14.8332C15.0542 5.5 15.2661 5.5878 15.4224 5.74408C15.5787 5.90036 15.6665 6.11232 15.6665 6.33333V7.16667Z" fill="currentColor"></path></svg></span>
                      <span>Stel ons een vraag</span>
                    </a>
                  </li>
                  <li>
                    <a class="flex p-3 items-center font-medium hover:bg-indigo-50 rounded text-gray-500 hover:text-indigo-500" href="/status">
                      <span class="mr-3">
                        <svg class="text-indigo-100" width="14" height="18" viewbox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.00016 10.6667C6.77915 10.6667 6.56719 10.7545 6.41091 10.9107C6.25463 11.067 6.16683 11.279 6.16683 11.5V13.1667C6.16683 13.3877 6.25463 13.5996 6.41091 13.7559C6.56719 13.9122 6.77915 14 7.00016 14C7.22118 14 7.43314 13.9122 7.58942 13.7559C7.7457 13.5996 7.83349 13.3877 7.83349 13.1667V11.5C7.83349 11.279 7.7457 11.067 7.58942 10.9107C7.43314 10.7545 7.22118 10.6667 7.00016 10.6667ZM7.31683 8.23333C7.16598 8.16339 6.99765 8.14017 6.8335 8.16666L6.68349 8.21666L6.53349 8.29166L6.4085 8.39166C6.32924 8.4715 6.26696 8.56656 6.22543 8.67111C6.1839 8.77566 6.16396 8.88754 6.16683 9C6.16619 9.10967 6.18722 9.21839 6.22869 9.31992C6.27016 9.42145 6.33126 9.5138 6.4085 9.59166C6.48775 9.66753 6.5812 9.727 6.68349 9.76666C6.78239 9.81332 6.89085 9.83615 7.00016 9.83333C7.10983 9.83397 7.21855 9.81294 7.32008 9.77147C7.42161 9.73 7.51396 9.6689 7.59183 9.59166C7.66906 9.5138 7.73017 9.42145 7.77164 9.31992C7.81311 9.21839 7.83413 9.10967 7.83349 9C7.83413 8.89033 7.81311 8.78161 7.77164 8.68008C7.73017 8.57854 7.66906 8.4862 7.59183 8.40833C7.51083 8.33472 7.41782 8.27553 7.31683 8.23333ZM13.6668 6.45C13.6581 6.37344 13.6414 6.29802 13.6168 6.225V6.15C13.5768 6.06431 13.5233 5.98555 13.4585 5.91666V5.91666L8.45849 0.916664C8.38961 0.851844 8.31085 0.798398 8.22516 0.758331H8.14183C8.0608 0.715 7.97371 0.684099 7.8835 0.666664H2.8335C2.17045 0.666664 1.53457 0.930056 1.06573 1.3989C0.596888 1.86774 0.333496 2.50362 0.333496 3.16666V14.8333C0.333496 15.4964 0.596888 16.1323 1.06573 16.6011C1.53457 17.0699 2.17045 17.3333 2.8335 17.3333H11.1668C11.8299 17.3333 12.4658 17.0699 12.9346 16.6011C13.4034 16.1323 13.6668 15.4964 13.6668 14.8333V6.5C13.6668 6.5 13.6668 6.5 13.6668 6.45ZM8.66683 3.50833L10.8252 5.66666H9.50016C9.27915 5.66666 9.06719 5.57887 8.91091 5.42259C8.75463 5.26631 8.66683 5.05434 8.66683 4.83333V3.50833ZM12.0002 14.8333C12.0002 15.0543 11.9124 15.2663 11.7561 15.4226C11.5998 15.5789 11.3878 15.6667 11.1668 15.6667H2.8335C2.61248 15.6667 2.40052 15.5789 2.24424 15.4226C2.08796 15.2663 2.00016 15.0543 2.00016 14.8333V3.16666C2.00016 2.94565 2.08796 2.73369 2.24424 2.57741C2.40052 2.42113 2.61248 2.33333 2.8335 2.33333H7.00016V4.83333C7.00016 5.49637 7.26355 6.13226 7.73239 6.6011C8.20124 7.06994 8.83712 7.33333 9.50016 7.33333H12.0002V14.8333Z" fill="currentColor"></path></svg></span>
                      <span>Vragen bekijken</span>
                    </a>
                  </li>
                  <li>
                    
                  </li>
                  <li>
                    
                  </li>
                  <li>
                    
                  </li>
                </ul></div>
            </div>

            <div class="w-full lg:w-9/12 px-4">
              <div class="flex items-center mb-8 px-3">
                <span class="inline-flex justify-center items-center w-16 h-16 mr-4 bg-indigo-500 rounded">
                  <svg width="30" height="30" viewbox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M25.6663 0.333342H4.33301C3.27214 0.333342 2.25473 0.754769 1.50458 1.50491C0.754435 2.25506 0.333008 3.27248 0.333008 4.33334V25.6667C0.333008 26.7275 0.754435 27.745 1.50458 28.4951C2.25473 29.2452 3.27214 29.6667 4.33301 29.6667H25.6663C26.7272 29.6667 27.7446 29.2452 28.4948 28.4951C29.2449 27.745 29.6663 26.7275 29.6663 25.6667V4.33334C29.6663 3.27248 29.2449 2.25506 28.4948 1.50491C27.7446 0.754769 26.7272 0.333342 25.6663 0.333342V0.333342ZM9.66634 27H4.33301C3.97939 27 3.64025 26.8595 3.3902 26.6095C3.14015 26.3594 2.99967 26.0203 2.99967 25.6667V24.0933C3.42724 24.2486 3.87815 24.3297 4.33301 24.3333H9.66634V27ZM9.66634 21.6667H4.33301C3.97939 21.6667 3.64025 21.5262 3.3902 21.2761C3.14015 21.0261 2.99967 20.687 2.99967 20.3333V18.76C3.42724 18.9152 3.87815 18.9964 4.33301 19H9.66634V21.6667ZM9.66634 16.3333H4.33301C3.97939 16.3333 3.64025 16.1929 3.3902 15.9428C3.14015 15.6928 2.99967 15.3536 2.99967 15V4.33334C2.99967 3.97972 3.14015 3.64058 3.3902 3.39053C3.64025 3.14048 3.97939 3.00001 4.33301 3.00001H9.66634V16.3333ZM17.6663 27H12.333V19H17.6663V27ZM17.6663 16.3333H12.333V3.00001H17.6663V16.3333ZM26.9997 25.6667C26.9997 26.0203 26.8592 26.3594 26.6091 26.6095C26.3591 26.8595 26.02 27 25.6663 27H20.333V24.3333H25.6663C26.1212 24.3297 26.5721 24.2486 26.9997 24.0933V25.6667ZM26.9997 20.3333C26.9997 20.687 26.8592 21.0261 26.6091 21.2761C26.3591 21.5262 26.02 21.6667 25.6663 21.6667H20.333V19H25.6663C26.1212 18.9964 26.5721 18.9152 26.9997 18.76V20.3333ZM26.9997 15C26.9997 15.3536 26.8592 15.6928 26.6091 15.9428C26.3591 16.1929 26.02 16.3333 25.6663 16.3333H20.333V3.00001H25.6663C26.02 3.00001 26.3591 3.14048 26.6091 3.39053C26.8592 3.64058 26.9997 3.97972 26.9997 4.33334V15ZM22.9997 8.33334C22.736 8.33334 22.4782 8.41154 22.2589 8.55805C22.0396 8.70456 21.8687 8.91279 21.7678 9.15643C21.6669 9.40006 21.6405 9.66815 21.692 9.92679C21.7434 10.1854 21.8704 10.423 22.0569 10.6095C22.2433 10.796 22.4809 10.9229 22.7395 10.9744C22.9982 11.0258 23.2663 10.9994 23.5099 10.8985C23.7535 10.7976 23.9618 10.6267 24.1083 10.4074C24.2548 10.1882 24.333 9.93038 24.333 9.66667C24.333 9.31305 24.1925 8.97391 23.9425 8.72386C23.6924 8.47382 23.3533 8.33334 22.9997 8.33334ZM6.99967 11C7.26338 11 7.52117 10.9218 7.74043 10.7753C7.9597 10.6288 8.1306 10.4206 8.23151 10.1769C8.33243 9.93328 8.35883 9.66519 8.30739 9.40655C8.25594 9.14791 8.12895 8.91033 7.94248 8.72386C7.75601 8.53739 7.51844 8.41041 7.25979 8.35896C7.00115 8.30751 6.73306 8.33392 6.48943 8.43483C6.24579 8.53575 6.03756 8.70665 5.89105 8.92591C5.74454 9.14518 5.66634 9.40297 5.66634 9.66667C5.66634 10.0203 5.80682 10.3594 6.05686 10.6095C6.30691 10.8595 6.64605 11 6.99967 11Z" fill="white"></path></svg></span>
                <div>
                  <h2 class="mb-1 text-2xl font-bold">Frequently asked Questions</h2>
                  <p class="text-sm text-gray-500 font-medium">Hieronder vind je een lijst met de meest gestelde vragen</p>
                </div>
              </div>
              <ul>
                @foreach($faqs as $f)
              <li id="faq-item" class="py-5 px-6 mb-3 bg-white shadow rounded">
                  <button id="btn" class="w-full flex justify-between items-center">
                    <h3 class="text-sm font-bold">{{ $f->question }}</h3>
                    <span>
                      <svg width="10" height="6" viewbox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.08317 0.666657C8.74984 0.333323 8.24984 0.333323 7.91651 0.666657L4.99984 3.58332L2.08317 0.666657C1.74984 0.333323 1.24984 0.333323 0.916504 0.666657C0.583171 0.99999 0.583171 1.49999 0.916504 1.83332L4.41651 5.33332C4.58317 5.49999 4.74984 5.58332 4.99984 5.58332C5.24984 5.58332 5.4165 5.49999 5.58317 5.33332L9.08317 1.83332C9.41651 1.49999 9.41651 0.99999 9.08317 0.666657Z" fill="#8594A5"></path></svg></span>
                  </button>
                  <p id="answer" class="hidden mt-3 pr-6 text-sm text-gray-500">{{ $f->answer }}</p>
                  </li>
                  @endforeach
              </ul></div>
          </div> -->
        </div>
      </section>
        
        

@endsection