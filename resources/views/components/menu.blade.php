<nav class="lg:hidden py-6 px-6 border-b"><div class="flex items-center justify-between">
            <a class="text-2xl font-semibold" href="/">
              <img class="h-10" src="{{asset('img/vblogo.svg')}}" alt="" width="auto"></a>
            <button class="navbar-burger flex items-center rounded focus:outline-none">
              <svg class="text-white bg-indigo-500 hover:bg-indigo-600 block h-8 w-8 p-2 rounded" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><title>Mobile menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg></button>
          </div>
        </nav><div class="hidden lg:block navbar-menu relative z-50">
          <div class="navbar-backdrop fixed lg:hidden inset-0 bg-gray-800 opacity-10"></div>
          <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-3/4 lg:w-80 sm:max-w-xs pt-6 pb-8 bg-white border-r overflow-y-auto"><div class="flex w-full items-center px-6 pb-6 mb-6 lg:border-b border-blue-50">
              <a class="text-xl font-semibold" href="/">
                <img class="h-8 logo" src="{{asset('img/vblogo.svg')}}" alt="" width="auto"></a>
            </div>
            <div class="px-4 pb-6">
              <h3 class="mb-2 text-xs uppercase text-gray-200 font-medium">Main</h3>
              <ul class="mb-8 text-sm font-medium"><li>
                  <a class="flex items-center pl-3 py-3 pr-2 text-gray-500 hover:bg-indigo-50 rounded menu__item" href="/">
                    <span class="inline-block mr-3">
                      <svg class="text-gray-200 w-5 h-5" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.9066 3.12873C14.9005 3.12223 14.8987 3.11358 14.8923 3.10722C14.8859 3.10086 14.8771 3.09893 14.8706 3.09278C13.3119 1.53907 11.2008 0.666626 8.99996 0.666626C6.79914 0.666626 4.68807 1.53907 3.12935 3.09278C3.12279 3.09893 3.11404 3.10081 3.10763 3.10722C3.10122 3.11363 3.09944 3.12222 3.09334 3.12873C1.93189 4.29575 1.14217 5.78067 0.823851 7.39609C0.505534 9.01151 0.672885 10.685 1.30478 12.2054C1.93668 13.7258 3.00481 15.025 4.37435 15.9389C5.7439 16.8528 7.35348 17.3405 8.99996 17.3405C10.6464 17.3405 12.256 16.8528 13.6256 15.9389C14.9951 15.025 16.0632 13.7258 16.6951 12.2054C17.327 10.685 17.4944 9.01151 17.1761 7.39609C16.8578 5.78067 16.068 4.29575 14.9066 3.12873ZM8.99992 15.6666C8.00181 15.6663 7.01656 15.4414 6.11714 15.0087C5.21773 14.5759 4.42719 13.9464 3.80409 13.1666H7.15015C7.38188 13.4286 7.66662 13.6383 7.98551 13.782C8.3044 13.9257 8.65017 14 8.99992 14C9.34968 14 9.69544 13.9257 10.0143 13.782C10.3332 13.6383 10.618 13.4286 10.8497 13.1666H14.1958C13.5727 13.9464 12.7821 14.5759 11.8827 15.0087C10.9833 15.4414 9.99804 15.6663 8.99992 15.6666ZM8.16659 11.5C8.16659 11.3351 8.21546 11.174 8.30703 11.037C8.3986 10.8999 8.52875 10.7931 8.68102 10.7301C8.83329 10.667 9.00085 10.6505 9.1625 10.6826C9.32415 10.7148 9.47263 10.7942 9.58918 10.9107C9.70572 11.0272 9.78509 11.1757 9.81724 11.3374C9.8494 11.499 9.83289 11.6666 9.76982 11.8189C9.70675 11.9711 9.59994 12.1013 9.4629 12.1929C9.32586 12.2844 9.16474 12.3333 8.99992 12.3333C8.77898 12.3331 8.56714 12.2452 8.41091 12.089C8.25468 11.9327 8.16681 11.7209 8.16659 11.5ZM15.1751 11.5017L15.1665 11.5H11.4999C11.4983 10.9846 11.3373 10.4824 11.0389 10.0623C10.7405 9.64218 10.3193 9.32472 9.83325 9.15352V6.49996C9.83325 6.27894 9.74546 6.06698 9.58918 5.9107C9.4329 5.75442 9.22093 5.66663 8.99992 5.66663C8.77891 5.66663 8.56695 5.75442 8.41067 5.9107C8.25439 6.06698 8.16659 6.27894 8.16659 6.49996V9.15352C7.68054 9.32472 7.25939 9.64218 6.96098 10.0623C6.66256 10.4824 6.50151 10.9846 6.49992 11.5H2.83334L2.82474 11.5017C2.60799 10.9669 2.46221 10.406 2.39114 9.83329H3.16659C3.3876 9.83329 3.59956 9.74549 3.75584 9.58921C3.91212 9.43293 3.99992 9.22097 3.99992 8.99996C3.99992 8.77894 3.91212 8.56698 3.75584 8.4107C3.59956 8.25442 3.3876 8.16663 3.16659 8.16663H2.39114C2.54005 6.9821 3.00621 5.85981 3.74037 4.91838L4.28597 5.46399C4.36335 5.54137 4.4552 5.60274 4.5563 5.64462C4.65739 5.68649 4.76574 5.70804 4.87517 5.70804C4.98459 5.70804 5.09294 5.68649 5.19404 5.64461C5.29513 5.60274 5.38699 5.54136 5.46436 5.46399C5.54173 5.38661 5.60311 5.29476 5.64498 5.19366C5.68686 5.09257 5.70841 4.98422 5.70841 4.87479C5.70841 4.76537 5.68686 4.65702 5.64498 4.55592C5.60311 4.45483 5.54173 4.36297 5.46435 4.2856L4.91881 3.74005C5.86016 3.00613 6.98227 2.5401 8.16659 2.39118V3.16663C8.16659 3.38764 8.25439 3.5996 8.41067 3.75588C8.56695 3.91216 8.77891 3.99996 8.99992 3.99996C9.22093 3.99996 9.4329 3.91216 9.58918 3.75588C9.74546 3.5996 9.83325 3.38764 9.83325 3.16663V2.39118C11.0176 2.5401 12.1397 3.00613 13.081 3.74005L12.5355 4.2856C12.3792 4.44186 12.2914 4.6538 12.2914 4.87479C12.2914 5.09578 12.3792 5.30772 12.5355 5.46399C12.6917 5.62025 12.9037 5.70804 13.1247 5.70804C13.3457 5.70804 13.5576 5.62026 13.7139 5.46399L14.2595 4.91838C14.9936 5.85981 15.4598 6.9821 15.6087 8.16663H14.8333C14.6122 8.16663 14.4003 8.25442 14.244 8.4107C14.0877 8.56698 13.9999 8.77894 13.9999 8.99996C13.9999 9.22097 14.0877 9.43293 14.244 9.58921C14.4003 9.74549 14.6122 9.83329 14.8333 9.83329H15.6087C15.5376 10.406 15.3919 10.9669 15.1751 11.5017Z" fill="currentColor" class="menu__item__icon"></path></svg></span>
                    <span>Projecten</span>
                    <span class="inline-block ml-auto">
                      </span>
                  </a>
                </li>
                <li>
                  <a class="flex items-center pl-3 py-3 pr-2 text-gray-500 hover:bg-indigo-50 rounded menu__item" href="/statistieken">
                    <span class="inline-block mr-3">
                      <svg class="text-gray-200 w-5 h-5" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.00014 0.666626C4.41681 0.666626 0.666809 4.41663 0.666809 8.99996C0.666809 13.5833 4.41681 17.3333 9.00014 17.3333C13.5835 17.3333 17.3335 13.5833 17.3335 8.99996C17.3335 4.41663 13.5835 0.666626 9.00014 0.666626ZM2.58348 10.6666C2.41681 10.0833 2.33348 9.58329 2.33348 8.99996C2.33348 8.41663 2.41681 7.91663 2.58348 7.33329H4.16681C4.00014 8.41663 4.00014 9.58329 4.16681 10.6666H2.58348ZM3.25014 12.3333H4.41681C4.58348 13.0833 4.83348 13.8333 5.25014 14.5C4.41681 13.9166 3.75014 13.1666 3.25014 12.3333ZM4.41681 5.66663H3.25014C3.75014 4.83329 4.41681 4.08329 5.25014 3.49996C4.83348 4.16663 4.58348 4.91663 4.41681 5.66663ZM8.16681 15.4166C7.16681 14.6666 6.41681 13.5833 6.16681 12.3333H8.16681V15.4166ZM8.16681 10.6666H5.75014C5.66681 10.0833 5.66681 9.58329 5.66681 8.99996C5.66681 8.41663 5.66681 7.91663 5.75014 7.33329H8.16681V10.6666ZM8.16681 5.66663H6.16681C6.41681 4.41663 7.16681 3.33329 8.16681 2.58329V5.66663ZM14.7501 5.66663H13.5835C13.4168 4.91663 13.1668 4.16663 12.7501 3.49996C13.5835 4.08329 14.2501 4.83329 14.7501 5.66663ZM9.83348 2.58329C10.8335 3.33329 11.5835 4.41663 11.8335 5.66663H9.83348V2.58329ZM9.83348 15.4166V12.3333H11.8335C11.5835 13.5833 10.8335 14.6666 9.83348 15.4166ZM12.2501 10.6666H9.83348V7.33329H12.2501C12.3335 8.41663 12.3335 9.58329 12.2501 10.6666ZM12.8335 14.5C13.1668 13.8333 13.4168 13.0833 13.6668 12.3333H14.8335C14.2501 13.1666 13.5835 13.9166 12.8335 14.5ZM13.9168 10.6666C14.0835 9.58329 14.0835 8.41663 13.9168 7.33329H15.5001C15.8335 8.41663 15.8335 9.58329 15.5001 10.6666H13.9168Z" fill="currentColor" class="menu__item__icon"></path></svg></span>
                    <span>Statistieken</span>
                    
                  </a>
                </li>
                <li>
                  <a class="flex items-center pl-3 py-3 pr-4 text-gray-500 hover:bg-indigo-50 rounded menu__item" href="/shop">
                    <span class="inline-block mr-3">
                      <svg class="text-gray-200 w-5 h-5 menu__item__icon" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.3413 9.23329C11.8688 8.66683 12.166 7.92394 12.1747 7.14996C12.1747 6.31453 11.8428 5.51331 11.252 4.92257C10.6613 4.33183 9.86009 3.99996 9.02465 3.99996C8.18922 3.99996 7.38801 4.33183 6.79727 4.92257C6.20653 5.51331 5.87465 6.31453 5.87465 7.14996C5.88335 7.92394 6.18051 8.66683 6.70799 9.23329C5.97353 9.59902 5.3415 10.1416 4.86875 10.8122C4.396 11.4827 4.09734 12.2603 3.99965 13.075C3.97534 13.296 4.03982 13.5176 4.17891 13.6911C4.318 13.8645 4.52031 13.9756 4.74132 14C4.96233 14.0243 5.18395 13.9598 5.35743 13.8207C5.5309 13.6816 5.64201 13.4793 5.66632 13.2583C5.76577 12.4509 6.15703 11.7078 6.76639 11.1688C7.37576 10.6299 8.16117 10.3324 8.97466 10.3324C9.78814 10.3324 10.5735 10.6299 11.1829 11.1688C11.7923 11.7078 12.1835 12.4509 12.283 13.2583C12.3062 13.472 12.411 13.6684 12.5756 13.8066C12.7402 13.9448 12.9519 14.0141 13.1663 14H13.258C13.4764 13.9748 13.6761 13.8644 13.8135 13.6927C13.9508 13.521 14.0148 13.3019 13.9913 13.0833C13.9009 12.2729 13.6116 11.4975 13.1493 10.8258C12.687 10.1542 12.066 9.60713 11.3413 9.23329ZM8.99965 8.63329C8.70628 8.63329 8.41949 8.5463 8.17556 8.38331C7.93163 8.22031 7.7415 7.98865 7.62923 7.71761C7.51696 7.44656 7.48759 7.14831 7.54482 6.86058C7.60206 6.57284 7.74333 6.30853 7.95078 6.10108C8.15823 5.89364 8.42253 5.75236 8.71027 5.69513C8.99801 5.63789 9.29626 5.66727 9.5673 5.77954C9.83835 5.89181 10.07 6.08193 10.233 6.32586C10.396 6.5698 10.483 6.85658 10.483 7.14996C10.483 7.54336 10.3267 7.92066 10.0485 8.19883C9.77035 8.47701 9.39306 8.63329 8.99965 8.63329ZM14.833 0.666626H3.16632C2.50328 0.666626 1.86739 0.930018 1.39855 1.39886C0.929713 1.8677 0.666321 2.50358 0.666321 3.16663V14.8333C0.666321 15.4963 0.929713 16.1322 1.39855 16.6011C1.86739 17.0699 2.50328 17.3333 3.16632 17.3333H14.833C15.496 17.3333 16.1319 17.0699 16.6008 16.6011C17.0696 16.1322 17.333 15.4963 17.333 14.8333V3.16663C17.333 2.50358 17.0696 1.8677 16.6008 1.39886C16.1319 0.930018 15.496 0.666626 14.833 0.666626ZM15.6663 14.8333C15.6663 15.0543 15.5785 15.2663 15.4222 15.4225C15.266 15.5788 15.054 15.6666 14.833 15.6666H3.16632C2.94531 15.6666 2.73335 15.5788 2.57707 15.4225C2.42079 15.2663 2.33299 15.0543 2.33299 14.8333V3.16663C2.33299 2.94561 2.42079 2.73365 2.57707 2.57737C2.73335 2.42109 2.94531 2.33329 3.16632 2.33329H14.833C15.054 2.33329 15.266 2.42109 15.4222 2.57737C15.5785 2.73365 15.6663 2.94561 15.6663 3.16663V14.8333Z" fill="currentColor"></path></svg></span>
                    <span>Shop</span>
                    <span class="inline-block ml-auto">
                      </span>
                  </a>
                </li>
                <li>
                  <a class="flex items-center pl-3 py-3 pr-4 text-gray-500 hover:bg-indigo-50 rounded menu__item" href="/offerte">
                    <span class="inline-block mr-3">
                      <svg class="text-gray-200 w-5 h-5 menu__item__icon" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.6416 1.71669C17.0442 1.6138 16.4394 1.56084 15.8332 1.55835C13.7652 1.55666 11.7403 2.14966 9.99991 3.26669C8.25503 2.16433 6.23045 1.58588 4.16657 1.60002C3.56045 1.6025 2.95558 1.65546 2.35824 1.75835C2.16258 1.79209 1.98539 1.89457 1.85859 2.04735C1.73178 2.20013 1.66369 2.39316 1.66657 2.59169V12.5917C1.66479 12.7141 1.69001 12.8355 1.74045 12.9471C1.79089 13.0586 1.8653 13.1577 1.95839 13.2373C2.05147 13.3169 2.16096 13.3749 2.27904 13.4074C2.39712 13.4398 2.5209 13.4459 2.64157 13.425C3.83576 13.2183 5.05924 13.2526 6.23996 13.5259C7.42068 13.7993 8.53476 14.3061 9.51657 15.0167L9.61657 15.075H9.70824C9.80066 15.1135 9.89979 15.1334 9.99991 15.1334C10.1 15.1334 10.1992 15.1135 10.2916 15.075H10.3832L10.4832 15.0167C11.4582 14.2903 12.5691 13.767 13.75 13.4778C14.931 13.1887 16.158 13.1395 17.3582 13.3334C17.4789 13.3542 17.6027 13.3482 17.7208 13.3157C17.8389 13.2833 17.9483 13.2252 18.0414 13.1456C18.1345 13.0661 18.2089 12.967 18.2594 12.8554C18.3098 12.7438 18.335 12.6225 18.3332 12.5V2.50002C18.3246 2.31015 18.2512 2.12895 18.1254 1.98647C17.9996 1.84399 17.8289 1.7488 17.6416 1.71669ZM9.16657 12.7917C7.62481 11.9806 5.90867 11.5573 4.16657 11.5584C3.89157 11.5584 3.61657 11.5584 3.33324 11.5584V3.22502C3.61079 3.20902 3.88903 3.20902 4.16657 3.22502C5.9444 3.22306 7.68342 3.74476 9.16657 4.72502V12.7917ZM16.6666 11.5917C16.3832 11.5917 16.1082 11.5917 15.8332 11.5917C14.0911 11.5906 12.375 12.0139 10.8332 12.825V4.72502C12.3164 3.74476 14.0554 3.22306 15.8332 3.22502C16.1108 3.20902 16.389 3.20902 16.6666 3.22502V11.5917ZM17.6416 15.05C17.0442 14.9471 16.4394 14.8942 15.8332 14.8917C13.7652 14.89 11.7403 15.483 9.99991 16.6C8.2595 15.483 6.2346 14.89 4.16657 14.8917C3.56045 14.8942 2.95558 14.9471 2.35824 15.05C2.24976 15.0672 2.14576 15.1057 2.05221 15.1633C1.95866 15.2208 1.87741 15.2963 1.81313 15.3854C1.74885 15.4744 1.70281 15.5753 1.67766 15.6822C1.65251 15.7891 1.64874 15.9 1.66657 16.0084C1.70892 16.2248 1.83532 16.4156 2.01807 16.539C2.20082 16.6623 2.42502 16.7083 2.64157 16.6667C3.83576 16.4599 5.05924 16.4942 6.23996 16.7676C7.42068 17.0409 8.53476 17.5478 9.51657 18.2584C9.65771 18.3588 9.82665 18.4128 9.99991 18.4128C10.1732 18.4128 10.3421 18.3588 10.4832 18.2584C11.4651 17.5478 12.5791 17.0409 13.7599 16.7676C14.9406 16.4942 16.1641 16.4599 17.3582 16.6667C17.5748 16.7083 17.799 16.6623 17.9817 16.539C18.1645 16.4156 18.2909 16.2248 18.3332 16.0084C18.3511 15.9 18.3473 15.7891 18.3222 15.6822C18.297 15.5753 18.251 15.4744 18.1867 15.3854C18.1224 15.2963 18.0412 15.2208 17.9476 15.1633C17.8541 15.1057 17.7501 15.0672 17.6416 15.05Z" fill="currentColor"></path></svg></span>
                    <span>Offertes</span>
                    <span class="inline-block ml-auto">
                      </span>
                  </a>
                </li>
                <li>
                  <a class="flex items-center pl-3 py-3 pr-4 text-gray-500 hover:bg-indigo-50 rounded menu__item" href="/afspraak">
                    <span class="inline-block mr-3">
                      <svg class="text-gray-200 w-5 h-5" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.33335 9.83329H1.50002C1.27901 9.83329 1.06704 9.92109 0.910765 10.0774C0.754484 10.2337 0.666687 10.4456 0.666687 10.6666V16.5C0.666687 16.721 0.754484 16.9329 0.910765 17.0892C1.06704 17.2455 1.27901 17.3333 1.50002 17.3333H7.33335C7.55437 17.3333 7.76633 17.2455 7.92261 17.0892C8.07889 16.9329 8.16669 16.721 8.16669 16.5V10.6666C8.16669 10.4456 8.07889 10.2337 7.92261 10.0774C7.76633 9.92109 7.55437 9.83329 7.33335 9.83329ZM6.50002 15.6666H2.33335V11.5H6.50002V15.6666ZM16.5 0.666626H10.6667C10.4457 0.666626 10.2337 0.754423 10.0774 0.910704C9.92115 1.06698 9.83335 1.27895 9.83335 1.49996V7.33329C9.83335 7.55431 9.92115 7.76627 10.0774 7.92255C10.2337 8.07883 10.4457 8.16663 10.6667 8.16663H16.5C16.721 8.16663 16.933 8.07883 17.0893 7.92255C17.2456 7.76627 17.3334 7.55431 17.3334 7.33329V1.49996C17.3334 1.27895 17.2456 1.06698 17.0893 0.910704C16.933 0.754423 16.721 0.666626 16.5 0.666626ZM15.6667 6.49996H11.5V2.33329H15.6667V6.49996ZM16.5 9.83329H10.6667C10.4457 9.83329 10.2337 9.92109 10.0774 10.0774C9.92115 10.2337 9.83335 10.4456 9.83335 10.6666V16.5C9.83335 16.721 9.92115 16.9329 10.0774 17.0892C10.2337 17.2455 10.4457 17.3333 10.6667 17.3333H16.5C16.721 17.3333 16.933 17.2455 17.0893 17.0892C17.2456 16.9329 17.3334 16.721 17.3334 16.5V10.6666C17.3334 10.4456 17.2456 10.2337 17.0893 10.0774C16.933 9.92109 16.721 9.83329 16.5 9.83329ZM15.6667 15.6666H11.5V11.5H15.6667V15.6666ZM7.33335 0.666626H1.50002C1.27901 0.666626 1.06704 0.754423 0.910765 0.910704C0.754484 1.06698 0.666687 1.27895 0.666687 1.49996V7.33329C0.666687 7.55431 0.754484 7.76627 0.910765 7.92255C1.06704 8.07883 1.27901 8.16663 1.50002 8.16663H7.33335C7.55437 8.16663 7.76633 8.07883 7.92261 7.92255C8.07889 7.76627 8.16669 7.55431 8.16669 7.33329V1.49996C8.16669 1.27895 8.07889 1.06698 7.92261 0.910704C7.76633 0.754423 7.55437 0.666626 7.33335 0.666626ZM6.50002 6.49996H2.33335V2.33329H6.50002V6.49996Z" fill="currentColor" class="menu__item__icon"></path></svg></span>
                    <span>Afspraak</span>
                    <span class="inline-block ml-auto">
                      </span>
                  </a>
                </li>
                <li>
                  <a class="flex items-center pl-3 py-3 pr-4 text-gray-500 hover:bg-indigo-50 rounded menu__item" href="/faq">
                    <span class="inline-block mr-3">
                      <svg class="text-gray-200 w-5 h-5 menu__item__icon" viewbox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.6665 6.44996C13.6578 6.3734 13.6411 6.29799 13.6165 6.22496V6.14996C13.5765 6.06428 13.523 5.98551 13.4582 5.91663L8.45819 0.916626C8.3893 0.851806 8.31054 0.79836 8.22486 0.758293H8.14986C8.0652 0.709744 7.97171 0.678579 7.87486 0.666626H2.83319C2.17015 0.666626 1.53426 0.930018 1.06542 1.39886C0.596583 1.8677 0.333191 2.50358 0.333191 3.16663V14.8333C0.333191 15.4963 0.596583 16.1322 1.06542 16.6011C1.53426 17.0699 2.17015 17.3333 2.83319 17.3333H11.1665C11.8296 17.3333 12.4654 17.0699 12.9343 16.6011C13.4031 16.1322 13.6665 15.4963 13.6665 14.8333V6.49996C13.6665 6.49996 13.6665 6.49996 13.6665 6.44996ZM8.66652 3.50829L10.8249 5.66663H9.49986C9.27884 5.66663 9.06688 5.57883 8.9106 5.42255C8.75432 5.26627 8.66652 5.05431 8.66652 4.83329V3.50829ZM11.9999 14.8333C11.9999 15.0543 11.9121 15.2663 11.7558 15.4225C11.5995 15.5788 11.3875 15.6666 11.1665 15.6666H2.83319C2.61218 15.6666 2.40022 15.5788 2.24394 15.4225C2.08765 15.2663 1.99986 15.0543 1.99986 14.8333V3.16663C1.99986 2.94561 2.08765 2.73365 2.24394 2.57737C2.40022 2.42109 2.61218 2.33329 2.83319 2.33329H6.99986V4.83329C6.99986 5.49633 7.26325 6.13222 7.73209 6.60106C8.20093 7.0699 8.83681 7.33329 9.49986 7.33329H11.9999V14.8333Z" fill="currentColor"></path></svg></span>
                    <span>Support</span>
                    <span class="inline-block ml-auto">
                      <svg class="text-gray-400 w-3 h-3" viewbox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"></svg></span>
                  </a>
                </li>
              </ul>
              <ul class="text-sm font-medium"><li>
                  
                </li>
                <li>
                  
                </li>
                <li>
                  
                </li>
                <li>
                  
                </li>
              </ul><div class="pt-8">
                <a class="flex items-center pl-3 py-3 pr-2 text-gray-500 hover:bg-indigo-50 rounded" href="/profiel">
                  <span class="inline-block mr-4">
                    <svg class="text-gray-200 w-5 h-5 menu__item__icon" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.3413 9.23329C11.8688 8.66683 12.166 7.92394 12.1747 7.14996C12.1747 6.31453 11.8428 5.51331 11.252 4.92257C10.6613 4.33183 9.86009 3.99996 9.02465 3.99996C8.18922 3.99996 7.38801 4.33183 6.79727 4.92257C6.20653 5.51331 5.87465 6.31453 5.87465 7.14996C5.88335 7.92394 6.18051 8.66683 6.70799 9.23329C5.97353 9.59902 5.3415 10.1416 4.86875 10.8122C4.396 11.4827 4.09734 12.2603 3.99965 13.075C3.97534 13.296 4.03982 13.5176 4.17891 13.6911C4.318 13.8645 4.52031 13.9756 4.74132 14C4.96233 14.0243 5.18395 13.9598 5.35743 13.8207C5.5309 13.6816 5.64201 13.4793 5.66632 13.2583C5.76577 12.4509 6.15703 11.7078 6.76639 11.1688C7.37576 10.6299 8.16117 10.3324 8.97466 10.3324C9.78814 10.3324 10.5735 10.6299 11.1829 11.1688C11.7923 11.7078 12.1835 12.4509 12.283 13.2583C12.3062 13.472 12.411 13.6684 12.5756 13.8066C12.7402 13.9448 12.9519 14.0141 13.1663 14H13.258C13.4764 13.9748 13.6761 13.8644 13.8135 13.6927C13.9508 13.521 14.0148 13.3019 13.9913 13.0833C13.9009 12.2729 13.6116 11.4975 13.1493 10.8258C12.687 10.1542 12.066 9.60713 11.3413 9.23329ZM8.99965 8.63329C8.70628 8.63329 8.41949 8.5463 8.17556 8.38331C7.93163 8.22031 7.7415 7.98865 7.62923 7.71761C7.51696 7.44656 7.48759 7.14831 7.54482 6.86058C7.60206 6.57284 7.74333 6.30853 7.95078 6.10108C8.15823 5.89364 8.42253 5.75236 8.71027 5.69513C8.99801 5.63789 9.29626 5.66727 9.5673 5.77954C9.83835 5.89181 10.07 6.08193 10.233 6.32586C10.396 6.5698 10.483 6.85658 10.483 7.14996C10.483 7.54336 10.3267 7.92066 10.0485 8.19883C9.77035 8.47701 9.39306 8.63329 8.99965 8.63329ZM14.833 0.666626H3.16632C2.50328 0.666626 1.86739 0.930018 1.39855 1.39886C0.929713 1.8677 0.666321 2.50358 0.666321 3.16663V14.8333C0.666321 15.4963 0.929713 16.1322 1.39855 16.6011C1.86739 17.0699 2.50328 17.3333 3.16632 17.3333H14.833C15.496 17.3333 16.1319 17.0699 16.6008 16.6011C17.0696 16.1322 17.333 15.4963 17.333 14.8333V3.16663C17.333 2.50358 17.0696 1.8677 16.6008 1.39886C16.1319 0.930018 15.496 0.666626 14.833 0.666626ZM15.6663 14.8333C15.6663 15.0543 15.5785 15.2663 15.4222 15.4225C15.266 15.5788 15.054 15.6666 14.833 15.6666H3.16632C2.94531 15.6666 2.73335 15.5788 2.57707 15.4225C2.42079 15.2663 2.33299 15.0543 2.33299 14.8333V3.16663C2.33299 2.94561 2.42079 2.73365 2.57707 2.57737C2.73335 2.42109 2.94531 2.33329 3.16632 2.33329H14.833C15.054 2.33329 15.266 2.42109 15.4222 2.57737C15.5785 2.73365 15.6663 2.94561 15.6663 3.16663V14.8333Z" fill="currentColor"></path></svg></span>
                  <span class="">Profiel</span>
                </a>
                <a class="flex items-center pl-3 py-3 pr-2 text-gray-500 hover:bg-indigo-50 rounded" href="/logout">
                  <span class="inline-block mr-4">
                    <svg class="text-gray-200 w-5 h-5 menu__item__icon" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.33368 9.99996C3.33368 10.221 3.42148 10.4329 3.57776 10.5892C3.73404 10.7455 3.946 10.8333 4.16701 10.8333H10.492L8.57535 12.7416C8.49724 12.8191 8.43524 12.9113 8.39294 13.0128C8.35063 13.1144 8.32885 13.2233 8.32885 13.3333C8.32885 13.4433 8.35063 13.5522 8.39294 13.6538C8.43524 13.7553 8.49724 13.8475 8.57535 13.925C8.65281 14.0031 8.74498 14.0651 8.84653 14.1074C8.94808 14.1497 9.057 14.1715 9.16701 14.1715C9.27702 14.1715 9.38594 14.1497 9.48749 14.1074C9.58904 14.0651 9.68121 14.0031 9.75868 13.925L13.092 10.5916C13.1679 10.5124 13.2273 10.4189 13.267 10.3166C13.3504 10.1137 13.3504 9.88618 13.267 9.68329C13.2273 9.581 13.1679 9.48755 13.092 9.40829L9.75868 6.07496C9.68098 5.99726 9.58874 5.93563 9.48722 5.89358C9.3857 5.85153 9.27689 5.82988 9.16701 5.82988C9.05713 5.82988 8.94832 5.85153 8.8468 5.89358C8.74529 5.93563 8.65304 5.99726 8.57535 6.07496C8.49765 6.15266 8.43601 6.2449 8.39396 6.34642C8.35191 6.44794 8.33027 6.55674 8.33027 6.66663C8.33027 6.77651 8.35191 6.88532 8.39396 6.98683C8.43601 7.08835 8.49765 7.18059 8.57535 7.25829L10.492 9.16663H4.16701C3.946 9.16663 3.73404 9.25442 3.57776 9.4107C3.42148 9.56698 3.33368 9.77895 3.33368 9.99996ZM14.167 1.66663H5.83368C5.17064 1.66663 4.53475 1.93002 4.06591 2.39886C3.59707 2.8677 3.33368 3.50358 3.33368 4.16663V6.66663C3.33368 6.88764 3.42148 7.0996 3.57776 7.25588C3.73404 7.41216 3.946 7.49996 4.16701 7.49996C4.38803 7.49996 4.59999 7.41216 4.75627 7.25588C4.91255 7.0996 5.00035 6.88764 5.00035 6.66663V4.16663C5.00035 3.94561 5.08814 3.73365 5.24442 3.57737C5.4007 3.42109 5.61267 3.33329 5.83368 3.33329H14.167C14.388 3.33329 14.6 3.42109 14.7563 3.57737C14.9125 3.73365 15.0003 3.94561 15.0003 4.16663V15.8333C15.0003 16.0543 14.9125 16.2663 14.7563 16.4225C14.6 16.5788 14.388 16.6666 14.167 16.6666H5.83368C5.61267 16.6666 5.4007 16.5788 5.24442 16.4225C5.08814 16.2663 5.00035 16.0543 5.00035 15.8333V13.3333C5.00035 13.1123 4.91255 12.9003 4.75627 12.744C4.59999 12.5878 4.38803 12.5 4.16701 12.5C3.946 12.5 3.73404 12.5878 3.57776 12.744C3.42148 12.9003 3.33368 13.1123 3.33368 13.3333V15.8333C3.33368 16.4963 3.59707 17.1322 4.06591 17.6011C4.53475 18.0699 5.17064 18.3333 5.83368 18.3333H14.167C14.8301 18.3333 15.4659 18.0699 15.9348 17.6011C16.4036 17.1322 16.667 16.4963 16.667 15.8333V4.16663C16.667 3.50358 16.4036 2.8677 15.9348 2.39886C15.4659 1.93002 14.8301 1.66663 14.167 1.66663Z" fill="currentColor"></path></svg></span>
                  <span class="">Log Out</span>
                </a>
              </div>
            </div>
          </nav></div>