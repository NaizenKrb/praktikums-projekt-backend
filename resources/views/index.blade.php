<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <meta name="HandheldFriendly" content="True">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kalender</title>
    <link href="/css/output.css" rel="stylesheet">
    <link rel="icon" href="/img/kalender.png">
    <script type="text/javascript">
        window.currentUser = {{ Illuminate\Support\Js::from($user) }};
        window.holidays = {{ Illuminate\Support\Js::from($holidays) }};
        window.allHolidays = {{ Illuminate\Support\Js::from($allHolidays) }};
    </script>
    <style>
        /* For Firefox Browser */
        html {
            scrollbar-width: auto;
            scrollbar-color: #004B7C #f7f4ed;
        }

        /* For Chrome, EDGE, Opera, Others */

        .scrollbar::-webkit-scrollbar {
            width: 13px;
            height: 20px;
        }

        .scrollbar::-webkit-scrollbar-track {
            border-radius: 100vh;
            background: #f7f4ed;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: #004B7C;
            border-radius: 100vh;
            border: 3px solid #f6f7ed;
        }

        .scrollbar::-webkit-scrollbar-thumb:hover {
            background: #0068AD;
        }
    </style>
</head>
<body class="scrollbar bg-white">

<header class="z-20 flex bg-slate-50 items-center justify-between border-b border-gray-200 py-4 px-6 lg:flex-none">
      <div class="items-center">
          <h1 class="text-2xl font-semibold text-gray-900 border-b border-gray-300">
              <time id="month"></time>
          </h1>
          <h2 id="user" class="text-lg font-semibold text-gray-900"></h2>
      </div>
      <div class="flex items-center">
          <div class="flex items-center shadow-md rounded-md md:items-stretch ">
              <button id="last" type="button" class="flex items-center justify-center rounded-l-md border border-r-0 border-gray-300 py-2 pl-3 pr-4 bg-white text-gray-400  hover:text-gray-500 hover:bg-gray-50 focus:relative md:w-9 md:px-2 md:hover:bg-slate-50">
                  <span class="sr-only">Previous month</span>
                  <!-- Heroicon name: solid/chevron-left -->
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
              </button>
              <button type="button" class="thisMonth hidden border-t border-b border-gray-300 px-3.5 bg-white text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50  focus:relative md:block">Heute</button>
              <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
              <button id="next" type="button" class="flex items-center justify-center rounded-r-md border border-l-0 border-gray-300 py-2 pl-4 pr-3 bg-white text-gray-400 hover:text-gray-500 hover:bg-gray-50  focus:relative md:w-9 md:px-2 md:hover:bg-gray-50 ">
                  <span class="sr-only">Nächster Monat</span>
                  <!-- Heroicon name: solid/chevron-right -->
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
              </button>
          </div>
          <div class="hidden md:ml-4 md:flex md:items-center">
              <div class="ml-6 h-6 w-px bg-gray-300"></div>
              <button type="button" class="addEvent focus:outline-none ml-6 rounded-md border border-transparent bg-netzfactor py-2 px-4 text-sm font-medium text-white shadow-md hover:bg-netzfactor-light focus:ring-2 focus:ring-netzfactor focus:ring-offset-2">Event Hinzufügen</button>
          </div>
          <div class="relative ml-6 md:hidden buttoncontainer">
              <button type="button" class="viewButton shadow-md -mx-2 flex items-center rounded-md border border-gray-300 p-2 text-gray-400 hover:text-gray-500" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                  <span class="sr-only">Menü öffnen</span>
                  <!-- Heroicon name: solid/dots-horizontal -->
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                  </svg>
              </button>

        <!--
          Dropdown menu, show/hide based on menu state.

          Entering: "transition ease-out duration-100"
            From: "transform opacity-0 scale-95"
            To: "transform opacity-100 scale-100"
          Leaving: "transition ease-in duration-75"
            From: "transform opacity-100 scale-100"
            To: "transform opacity-0 scale-95"
        -->
              <div class="viewMenu hidden focus:outline-none absolute right-0 mt-3 w-36 origin-top-right divide-y divide-gray-100 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="menu-0-button" tabindex="-1">
                  <div class="py-1" role="none">
                      <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                      <a href="#" class="addEvent text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-0">Event erstellen</a>
                  </div>
                  <div class="py-1" role="none">
                      <a href="#" class="thisMonth text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-1">Gehe zu Heute</a>
                  </div>
              </div>
          </div>
      </div>
</header>

<main class="w-full">
      <!-- Modal -->
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-20">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container w-11/12 md:max-w-md sm:max-h-[80vh] mx-auto shadow-lg z-50 overflow-y-auto scrollbar">
            <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
                <span class="text-sm">(Esc)</span>
            </div>


            <div class="modal-content bg-white py-4 text-left px-6 border-2 border-slate-300 shadow-sm rounded-md" >
                <!--Title-->
                <div class="flex justify-between items-center pb-4 border-b border-slate-300" >
                    <div class="flex justify-between items-center">
                        <img src="/img/event.png" class="w-10 h-10 mr-2" alt="event">
                        <p class="text-xl text-center font-semibold">Event Hinzufügen</p>
                    </div>
                    <div class="modal-close cursor-pointer z-50 p-1 border border-slate-300 rounded-md hover:bg-gray-100 shadow-sm">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>
                <!--Body-->
                <form action="/kalender/submit" method="post" id="vacationForm" class="py-3">
                    <label class="my-3 p-2 border border-slate-300 rounded-md shadow-sm flex flex-col justify-center text-lg font-medium">
                        <span>Anfang:</span>
                        <input type="date" name="startDate" class="startDate border border-slate-200 rounded-md p-1">
                    </label>
                    <label class="my-3 p-2 border border-slate-300 rounded-md shadow-sm flex flex-col justify-center text-lg font-medium">
                        <span>Ende:</span>
                        <input type="date" name="endDate" class="endDate shadow-sm border border-slate-200 rounded-md p-1">
                    </label>
                    <label class="my-3 p-2 border border-slate-300 rounded-md shadow-sm justify-around grid grid-cols-2 text-lg font-medium">
                        <div class="flex items-center justify-center">
                            <input value="fullDay" name="holidaytype" id="default-radio-1" type="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-slate-300" checked>
                            <label for="default-radio-1" class="ml-2 text-lg font-semibold">Ganztags</label>
                        </div>
                        <div class="flex items-center justify-center">
                            <input value="halfDay" name="holidaytype" id="default-radio-2" type="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-slate-300">
                            <label for="default-radio-2" class="ml-2 text-lg font-semibold">Halbtags</label>
                        </div>
                        <div class="flex items-center justify-center">
                            <input value="morning" name="daytime" id="default-radio-3" type="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-slate-300">
                            <label for="default-radio-3" class="ml-2 text-md font-semibold">Vormittags</label>
                        </div>
                        <div class="flex items-center justify-center">
                            <input value="afternoon" name="daytime" id="default-radio-4" type="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-slate-300">
                            <label for="default-radio-4" class="ml-2 text-md font-semibold">Nachmittags</label>
                        </div>
                    </label>
                    <label class="my-3 p-2 border border-slate-300 rounded-md shadow-sm flex flex-col justify-center text-lg font-medium ">
                        <span>Kommentar:</span>
                        <textarea name="comment" class="shadow-sm border border-slate-200 rounded-md p-1 h-24 resize-none scrollbar" placeholder="Kommentar zum Urlaub"></textarea>
                    </label>
                </form>
                <!--Footer-->
                <div class="flex justify-end border-t border-slate-300 pt-4">
                    <button type="submit" class="addButton border border-slate-300 rounded-lg bg-netzfactor py-2 px-4 shadow-md text-white hover:bg-netzfactor-light mr-2">Hinzufügen</button>
                    <button class="modal-close border border-slate-300 rounded-lg bg-transparent py-2 px-4 shadow-md  text-netzfactor hover:bg-gray-100 hover:text-netzfactor-light">Schließen</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Kalender -->
    <div id="calendar" class="lg:flex lg:flex-auto lg:flex-col" >
        <div id="table-header" class="grid grid-cols-7 text-center text-2xl font-semibold text-black leading-6 lg:flex-none overflow-hidden gap-2 mt-2 mx-1">
            <div class="bg-slate-50 border border-slate-300 py-3 rounded-md">M<span class="sr-only sm:not-sr-only">ontag</span></div>
            <div class="bg-slate-50 border border-slate-300 py-3 rounded-md">D<span class="sr-only sm:not-sr-only">ienstag</span></div>
            <div class="bg-slate-50 border border-slate-300 py-3 rounded-md">M<span class="sr-only sm:not-sr-only">ittwoch</span></div>
            <div class="bg-slate-50 border border-slate-300 py-3 rounded-md">D<span class="sr-only sm:not-sr-only">onnerstag</span></div>
            <div class="bg-slate-50 border border-slate-300 py-3 rounded-md">F<span class="sr-only sm:not-sr-only">reitag</span></div>
            <div class="bg-slate-50 border border-slate-300 py-3 rounded-md">S<span class="sr-only sm:not-sr-only">amstag</span></div>
            <div class="bg-slate-50 border border-slate-300 py-3 rounded-md">S<span class="sr-only sm:not-sr-only">onntag</span></div>
        </div>

        <div id="days" class="grid grid-cols-7 initial-scale gap-2 my-2 mx-1" >
        </div>

        <div class="flex mx-1 mb-2 p-1 bg-slate-100 rounded-md border border-slate-300 font-semibold">
            <div class="flex m-1 border-r border-slate-300 bg-green-200">
                <div class="mx-1">
                    Gebuchte Urlaubstage:
                </div>
                <div id="bookedDays" class="mx-1">
                </div>
            </div>
            <div class="flex m-1 border-r border-slate-300 bg-green-200">
                <div class="mx-1">
                    Verbleibende Urlaubstage:
                </div>
                <div id="remainingDays" class="mx-1">

                </div>
            </div>
        </div>
    </div>
</main>


<footer class="bg-slate-50 relative block mb-0 w-full border-t">
    <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
        <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
            <div class="px-5 py-2">
                <a href="#" class="text-base text-gray-500 hover:text-gray-900"> Über uns </a>
            </div>

            <div class="px-5 py-2">
                <a href="#" class="text-base text-gray-500 hover:text-gray-900"> Blog </a>
            </div>

        </nav>
        <div class="mt-8 flex justify-center space-x-6">
            <a href="#" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Instagram</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                </svg>
            </a>

            <a href="#" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Twitter</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                </svg>
            </a>

            <a href="https://github.com/NaizenKrb" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">GitHub</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        <p class="mt-8 text-center text-base text-gray-400">&copy; 2022</p>
    </div>
</footer>
<script type="text/javascript" async src="/js/script.js"></script>
</body>


</html>
