<section
      class="header-main fixed w-full z-50 bg-white dark:bg-neutral text-neutral dark:text-gray-200 border-b border-gray-400 dark:border-gray-600"
    >
      <nav>
        <div class=" mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
          <div class="relative flex h-20 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
              <!-- Mobile menu button-->
              <button
                type="button"
                class="inline-flex items-center justify-center p-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                aria-controls="mobile-menu"
                aria-expanded="false"
              >
                <span class="sr-only">Open main menu</span>

                <svg
                  class="h-6 w-6"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16m-7 6h7"
                  />
                </svg>

                <svg
                  class="hidden h-6 w-6"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>

            <div
              class="flex-1 flex items-center justify-center sm:items-stretch content-center"
            >
            <div class="logo-main flex-shrink-0">
              <a href="index.php?page=#landpage-swiper">
                <!-- Light mode logo (Shown in light mode, hidden in dark mode) -->
                <img
                  class="ml-0 sm:ml-12 block h-10 lg:h-16 w-auto dark:hidden"
                  src="../images/HCMC-blue.png"
                  alt="logo"
                />
                <!-- Dark mode logo (Hidden in light mode, shown in dark mode) -->
                <img
                  class="ml-0 sm:ml-12 h-10 lg:h-16 w-auto dark-img hidden dark:block"
                  src="../images/HCMC-white.png"  
                  alt="logo"
                />
              </a>
          </div>

              <div
                class="hidden sm:block sm:ml-6 text-neutral dark:text-gray-100 content-center"
              >
                <div class="nav-text flex justify-center flex-grow">
                  <div
                    class="flex space-x-4 uppercase font-bold text-xs md:text-xs lg:text-lg"
                  >
                    <a
                      href="bookappointment.php"
                      class="hover:bg-gray-300 dark:hover:bg-gray-700 dark:hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      Book appointment
                    </a>
                    <a
                      href="#"
                      class="hover:bg-gray-300 dark:hover:bg-gray-700 dark:hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      Doctor's Schedule
                    </a>
                    <a
                      href="index.php?page=#services"
                      class="hover:bg-gray-300 dark:hover:bg-gray-700 dark:hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      Our Services
                    </a>
                    <a
                      href="index.php?page=#about-us"
                      class="hover:bg-gray-300 dark:hover:bg-gray-700 dark:hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      About Us
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="absolute inset-y-0 right-0 flex items-center sm:static sm:inset-auto sm:ml-6 sm:pr-0"
            >
              <!-- Profile dropdown. Pag di naka log in, wala dapat to, palitan mo ng "Log In" -->

              <div class="profile-dropdown relative">
                <ul class="menu menu-horizontal">
                  <li>
                    <details>
                      <summary>
                        <i class="fa-solid fa-user text-3xl"></i>
                      </summary>
                      <ul
                        class="dropdown-content p-2 bg-gray-200 dark:bg-gray-700 rounded-t-none z-10 w-36 sm:right-1 translate-x-7 custom-dropdown-menu"
                      >
                        <li>
                        
                          <label
                            class="cursor-pointer grid place-items-center gap-2"
                            style="
                              grid-template-columns: auto auto;
                              align-items: center;
                            "
                          >
                            <input
                              type="checkbox"
                              name="toggle-theme"
                              value="synthwave"
                              class="toggle theme-controller bg-base-content"
                              style="
                                grid-row: 1;
                                grid-column: 1 / span 2;
                                z-index: 1;
                              "
                            />
                           
                            <svg
                              class="stroke-base-100 fill-base-100"
                              style="
                                grid-row: 1;
                                grid-column: 1;
                                width: 20px;
                                height: 20px;
                                justify-self: start;
                              "
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            >
                              <circle cx="12" cy="12" r="5" />
                              <path
                                d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"
                              />
                            </svg>
                            <svg
                              class="stroke-base-100 fill-base-100"
                              style="
                                grid-row: 1;
                                grid-column: 2;
                                width: 20px;
                                height: 20px;
                                justify-self: end;
                              "
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            >
                              <path
                                d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"
                              ></path>
                            </svg>
                          </label>
                        </li>

                        <!-- labas mo to pag di naka log in -->
                        <li>
                          <a href="login.html"
                            class="hover:bg-gray-300 dark:hover:bg-gray-600 hover:font-bold text-lg transition duration-300 ease-in-out"
                            >Log In</a
                          >
                        </li>    
                        <!-- labas mo to pag di naka log in end --> 
                        
                        <!-- ito nakalabas pag naka log in -->
                        <li>
                          <a
                            class="hover:bg-gray-300 dark:hover:bg-gray-600 hover:font-bold text-lg transition duration-300 ease-in-out"
                            >Profile</a
                          >
                        </li>
                        <li>
                          <a
                            class="hover:bg-gray-300 dark:hover:bg-gray-600 hover:font-bold text-lg transition duration-300 ease-in-out"
                            >Log Out</a
                          >
                        </li>  
                        <!-- ito nakalabas pag naka log in end -->   

                      </ul>
                    </details>
                  </li>
                </ul>
              </div>
               <!-- Profile dropdown end -->

            </div>
          </div>
        </div>

        

        <!-- Mobile menu, toggle classes based on menu state. -->
        <div
          class="hidden sm:hidden bg-gray-200 dark:bg-neutral border-b border-gray-400 dark:border-gray-600"
          id="mobile-menu"
        >
          <div
            class="px-2 pt-2 pb-3 space-y-1 text-neutral dark:text-gray-200 uppercase"
          >
            <a
              href="bookappointment.php"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >Book Appointment</a
            >
            <a
              href="#"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >Doctor's Schedule</a
            >
            <a
              href="#services"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >Our Services</a
            >
            <a
              href="#about-us"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >About Us</a
            >
          </div>
        </div>
      </nav>
    </section>






    