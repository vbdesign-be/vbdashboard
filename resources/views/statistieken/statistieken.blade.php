@extends('layouts/app')

@section('title', 'Statistieken')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Statistieken</h2>
          </div>
        </div>
        
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="flex flex-wrap -m-4">
            <div class="w-full lg:w-1/2 p-4">
              <div class="bg-white rounded">
                <div class="flex items-center py-5 px-6 border-b">
                  <h3 class="text-2xl font-bold">Balance</h3>
                  <div class="ml-auto inline-block py-2 px-3 border rounded text-xs text-gray-500">
                    <select class="pr-1" name="" id="">
                      <option value="1">Monthly</option>
                      <option value="1">Yearly</option>
                      <option value="1">Weekly</option>
                    </select>
                  </div>
                </div>
                <div class="pt-4 px-6">
                  <div class="flex flex-wrap -m-4 pb-16">
                    <div class="w-full md:w-1/2 p-4">
                      <div class="py-4 px-6 border rounded">
                        <h4 class="text-xs text-gray-500">Earnings</h4>
                        <div class="flex items-center">
                          <span class="mr-2 text-3xl font-bold">43.41%</span>
                          <span class="py-1 px-2 bg-green-500 text-xs text-white rounded-full">+2.5%</span>
                        </div>
                      </div>
                    </div>
                    <div class="w-full md:w-1/2 p-4">
                      <div class="py-4 px-6 border rounded">
                        <h4 class="text-xs text-gray-500">Sales Value</h4>
                        <div class="flex items-center">
                          <span class="mr-2 text-3xl font-bold">$95,422</span>
                          <span class="py-1 px-2 bg-green-500 text-xs text-white rounded-full">+13.5%</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="chart" data-type="area"></div>
              </div>
            </div>
            <div class="w-full lg:w-1/2 p-4">
              <div class="p-6 mb-8 bg-white shadow rounded">
                <div class="flex mb-3 items-center justify-between">
                  <h3 class="text-gray-500">Total Income</h3>
                  <button class="focus:outline-none">
                    <svg class="h-4 w-4 text-gray-200" viewbox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8 0.333344C7.67037 0.333344 7.34813 0.431092 7.07405 0.614228C6.79997 0.797363 6.58635 1.05766 6.4602 1.36221C6.33406 1.66675 6.30105 2.00186 6.36536 2.32516C6.42967 2.64846 6.5884 2.94543 6.82149 3.17852C7.05458 3.41161 7.35155 3.57034 7.67485 3.63465C7.99815 3.69896 8.33326 3.66596 8.63781 3.53981C8.94235 3.41366 9.20265 3.20004 9.38578 2.92596C9.56892 2.65188 9.66667 2.32965 9.66667 2.00001C9.66667 1.55798 9.49107 1.13406 9.17851 0.821499C8.86595 0.508939 8.44203 0.333344 8 0.333344ZM2.16667 0.333344C1.83703 0.333344 1.5148 0.431092 1.24072 0.614228C0.966635 0.797363 0.753014 1.05766 0.626868 1.36221C0.500722 1.66675 0.467717 2.00186 0.532025 2.32516C0.596334 2.64846 0.755068 2.94543 0.988156 3.17852C1.22124 3.41161 1.51822 3.57034 1.84152 3.63465C2.16482 3.69896 2.49993 3.66596 2.80447 3.53981C3.10902 3.41366 3.36931 3.20004 3.55245 2.92596C3.73559 2.65188 3.83333 2.32965 3.83333 2.00001C3.83333 1.55798 3.65774 1.13406 3.34518 0.821499C3.03262 0.508939 2.6087 0.333344 2.16667 0.333344ZM13.8333 0.333344C13.5037 0.333344 13.1815 0.431092 12.9074 0.614228C12.6333 0.797363 12.4197 1.05766 12.2935 1.36221C12.1674 1.66675 12.1344 2.00186 12.1987 2.32516C12.263 2.64846 12.4217 2.94543 12.6548 3.17852C12.8879 3.41161 13.1849 3.57034 13.5082 3.63465C13.8315 3.69896 14.1666 3.66596 14.4711 3.53981C14.7757 3.41366 15.036 3.20004 15.2191 2.92596C15.4023 2.65188 15.5 2.32965 15.5 2.00001C15.5 1.55798 15.3244 1.13406 15.0118 0.821499C14.6993 0.508939 14.2754 0.333344 13.8333 0.333344Z" fill="currentColor"></path>
                    </svg>
                  </button>
                </div>
                <div class="flex items-center mb-3">
                  <span class="text-4xl font-bold">$124,563.00</span>
                  <span class="inline-block ml-2 py-1 px-2 bg-green-500 text-white text-xs rounded-full">+6.9%</span>
                </div>
                <div class="relative w-full h-1 mb-2 bg-gray-50 rounded">
                  <div class="absolute top-0 left-0 w-4/6 h-full bg-purple-500 rounded"></div>
                </div>
                <p class="text-xs text-gray-200">Yearly Goal</p>
              </div>
              <div class="p-6 bg-white shadow rounded">
                <div class="flex mb-3 items-center justify-between">
                  <h3 class="text-gray-500">New Users</h3>
                  <button class="focus:outline-none">
                    <svg class="h-4 w-4 text-gray-200" viewbox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8 0.333344C7.67037 0.333344 7.34813 0.431092 7.07405 0.614228C6.79997 0.797363 6.58635 1.05766 6.4602 1.36221C6.33406 1.66675 6.30105 2.00186 6.36536 2.32516C6.42967 2.64846 6.5884 2.94543 6.82149 3.17852C7.05458 3.41161 7.35155 3.57034 7.67485 3.63465C7.99815 3.69896 8.33326 3.66596 8.63781 3.53981C8.94235 3.41366 9.20265 3.20004 9.38578 2.92596C9.56892 2.65188 9.66667 2.32965 9.66667 2.00001C9.66667 1.55798 9.49107 1.13406 9.17851 0.821499C8.86595 0.508939 8.44203 0.333344 8 0.333344ZM2.16667 0.333344C1.83703 0.333344 1.5148 0.431092 1.24072 0.614228C0.966635 0.797363 0.753014 1.05766 0.626868 1.36221C0.500722 1.66675 0.467717 2.00186 0.532025 2.32516C0.596334 2.64846 0.755068 2.94543 0.988156 3.17852C1.22124 3.41161 1.51822 3.57034 1.84152 3.63465C2.16482 3.69896 2.49993 3.66596 2.80447 3.53981C3.10902 3.41366 3.36931 3.20004 3.55245 2.92596C3.73559 2.65188 3.83333 2.32965 3.83333 2.00001C3.83333 1.55798 3.65774 1.13406 3.34518 0.821499C3.03262 0.508939 2.6087 0.333344 2.16667 0.333344ZM13.8333 0.333344C13.5037 0.333344 13.1815 0.431092 12.9074 0.614228C12.6333 0.797363 12.4197 1.05766 12.2935 1.36221C12.1674 1.66675 12.1344 2.00186 12.1987 2.32516C12.263 2.64846 12.4217 2.94543 12.6548 3.17852C12.8879 3.41161 13.1849 3.57034 13.5082 3.63465C13.8315 3.69896 14.1666 3.66596 14.4711 3.53981C14.7757 3.41366 15.036 3.20004 15.2191 2.92596C15.4023 2.65188 15.5 2.32965 15.5 2.00001C15.5 1.55798 15.3244 1.13406 15.0118 0.821499C14.6993 0.508939 14.2754 0.333344 13.8333 0.333344Z" fill="currentColor"></path>
                    </svg>
                  </button>
                </div>
                <div class="flex items-center mb-3">
                  <span class="text-4xl font-bold">94.2%</span>
                  <span class="inline-block ml-2 py-1 px-2 bg-green-500 text-white text-xs rounded-full">+6.9%</span>
                </div>
                <div class="chart" data-type="columns-stacked"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-4 bg-white shadow rounded">
            <div class="flex px-6 pb-4 border-b">
              <h3 class="text-xl font-bold">Recent Transactions</h3>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left"><th class="pb-3 font-medium">Transaction ID</th><th class="pb-3 font-medium">Date</th><th class="pb-3 font-medium">E-mail</th><th class="pb-3 font-medium">Subscription</th><th class="pb-3 font-medium">Status</th></tr>
                </thead>
                <tbody>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Monthly</td>
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-green-500 rounded-full">Completed</span>
                    </td>
                  </tr>
                  <tr class="text-xs">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Monthly</td>
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-red-500 rounded-full">Canceled</span>
                    </td>
                  </tr>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Lifetime</td>
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-orange-500 rounded-full">Pending</span>
                    </td>
                  </tr>
                  <tr class="text-xs">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Yearly</td>
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-green-500 rounded-full">Completed</span>
                    </td>
                  </tr>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Monthly</td>
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-green-500 rounded-full">Completed</span>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="text-center mt-5">
                <a class="inline-flex items-center text-xs text-indigo-500 hover:text-blue-600 font-medium" href="#">
                  <span class="inline-block mr-2">
                    <svg class="text-indigo-400 h-3 w-3" viewbox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.66667 12.3333H3.33333C2.8029 12.3333 2.29419 12.1226 1.91912 11.7476C1.54405 11.3725 1.33333 10.8638 1.33333 10.3333V3.66668C1.33333 3.48987 1.2631 3.3203 1.13807 3.19527C1.01305 3.07025 0.843478 3.00001 0.666667 3.00001C0.489856 3.00001 0.320286 3.07025 0.195262 3.19527C0.0702379 3.3203 0 3.48987 0 3.66668V10.3333C0 11.2174 0.351189 12.0652 0.976311 12.6904C1.60143 13.3155 2.44928 13.6667 3.33333 13.6667H8.66667C8.84348 13.6667 9.01305 13.5964 9.13807 13.4714C9.2631 13.3464 9.33333 13.1768 9.33333 13C9.33333 12.8232 9.2631 12.6536 9.13807 12.5286C9.01305 12.4036 8.84348 12.3333 8.66667 12.3333ZM4.66667 7.66668C4.66667 7.84349 4.7369 8.01306 4.86193 8.13808C4.98695 8.26311 5.15652 8.33334 5.33333 8.33334H8.66667C8.84348 8.33334 9.01305 8.26311 9.13807 8.13808C9.2631 8.01306 9.33333 7.84349 9.33333 7.66668C9.33333 7.48987 9.2631 7.3203 9.13807 7.19527C9.01305 7.07025 8.84348 7.00001 8.66667 7.00001H5.33333C5.15652 7.00001 4.98695 7.07025 4.86193 7.19527C4.7369 7.3203 4.66667 7.48987 4.66667 7.66668ZM12 4.96001C11.9931 4.89877 11.9796 4.83843 11.96 4.78001V4.72001C11.9279 4.65146 11.8852 4.58845 11.8333 4.53334V4.53334L7.83333 0.533343C7.77822 0.481488 7.71521 0.438731 7.64667 0.406677C7.62677 0.40385 7.60657 0.40385 7.58667 0.406677C7.51894 0.367838 7.44415 0.342906 7.36667 0.333344H4.66667C4.13623 0.333344 3.62753 0.544057 3.25245 0.91913C2.87738 1.2942 2.66667 1.80291 2.66667 2.33334V9.00001C2.66667 9.53044 2.87738 10.0392 3.25245 10.4142C3.62753 10.7893 4.13623 11 4.66667 11H10C10.5304 11 11.0391 10.7893 11.4142 10.4142C11.7893 10.0392 12 9.53044 12 9.00001V5.00001C12 5.00001 12 5.00001 12 4.96001ZM8 2.60668L9.72667 4.33334H8.66667C8.48986 4.33334 8.32029 4.26311 8.19526 4.13808C8.07024 4.01306 8 3.84349 8 3.66668V2.60668ZM10.6667 9.00001C10.6667 9.17682 10.5964 9.34639 10.4714 9.47141C10.3464 9.59644 10.1768 9.66668 10 9.66668H4.66667C4.48986 9.66668 4.32029 9.59644 4.19526 9.47141C4.07024 9.34639 4 9.17682 4 9.00001V2.33334C4 2.15653 4.07024 1.98696 4.19526 1.86194C4.32029 1.73691 4.48986 1.66668 4.66667 1.66668H6.66667V3.66668C6.66847 3.89411 6.70905 4.11956 6.78667 4.33334H5.33333C5.15652 4.33334 4.98695 4.40358 4.86193 4.52861C4.7369 4.65363 4.66667 4.8232 4.66667 5.00001C4.66667 5.17682 4.7369 5.34639 4.86193 5.47141C4.98695 5.59644 5.15652 5.66668 5.33333 5.66668H10.6667V9.00001Z" fill="currentColor"></path>
                    </svg>
                  </span>
                  <span>Load more transactions</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

@endsection