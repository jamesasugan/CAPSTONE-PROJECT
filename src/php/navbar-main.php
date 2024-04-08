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
              <div class="logo-main flex-shrink-0 ">
                <img
                  class="block h-10 lg:h-16 w-auto dark:mix-blend-plus-lighter"
                  src="../images/HCMC logo.png"
                  alt="logo"
                />
              </div>
              <div
                class="hidden sm:block sm:ml-6 text-neutral dark:text-gray-100 content-center"
              >
                <div class="nav-text flex justify-center flex-grow">
                  <div
                    class="flex space-x-4 uppercase font-bold text-xs md:text-xs lg:text-lg"
                  >
                    <a
                      href="#"
                      class="hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      Book appointment
                    </a>
                    <a
                      href="#"
                      class="hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      Doctor's Schedule
                    </a>
                    <a
                      href="#"
                      class="hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      Our Services
                    </a>
                    <a
                      href="#"
                      class="hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md transition duration-300 ease-in-out"
                    >
                      Contact Us
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="absolute inset-y-0 right-0 flex items-center sm:static sm:inset-auto sm:ml-6 sm:pr-0"
            >
              <!-- Profile dropdown -->
              <div class="profile-dropdown relative">
                <ul class="menu menu-horizontal">
                  <li>
                    <details>
                      <summary>
                        <i class="fa-solid fa-user text-3xl"></i>
                      </summary>
                      <ul
                        class="p-2 bg-gray-200 dark:bg-gray-700 rounded-t-none z-10 w-36 sm:right-1 translate-x-7 custom-dropdown-menu"
                      >
                        <li>
                          <!-- light and dark mode -->
                          <label
                            class="cursor-pointer grid place-items-center gap-2"
                            style="
                              grid-template-columns: auto auto;
                              align-items: center;
                            "
                          >
                            <input
                              type="checkbox"
                              value="synthwave"
                              class="toggle theme-controller bg-base-content"
                              style="
                                grid-row: 1;
                                grid-column: 1 / span 2;
                                z-index: 1;
                              "
                            />
                            <!-- Ensure SVGs are properly sized and aligned within the grid -->
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
                      </ul>
                    </details>
                  </li>
                </ul>
              </div>
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
              href="#"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >Book Appointment</a
            >
            <a
              href="#"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >Doctor's Schedule</a
            >
            <a
              href="#"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >Our Services</a
            >
            <a
              href="#"
              class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white border-b border-slate-800 dark:border-slate-300"
              >Contact Us</a
            >
          </div>
        </div>
      </nav>
    </section>

       <script>
      // Hamburger menu functionality
      document
        .querySelector('[aria-controls="mobile-menu"]')
        .addEventListener("click", function () {
          var target = document.getElementById(
            this.getAttribute("aria-controls")
          );
          if (target.classList.contains("hidden")) {
            target.classList.remove("hidden");
            target.classList.add("block");
          } else {
            target.classList.remove("block");
            target.classList.add("hidden");
          }
        });
    </script>

    <!-- script for dark mode/light mode toggle -->
    <script>
      function setTheme(theme) {
        if (theme === "dark") {
          document.documentElement.classList.add("dark");
        } else {
          document.documentElement.classList.remove("dark");
        }
      }

      setTheme("light");

      document
        .querySelector(".theme-controller")
        .addEventListener("change", function (event) {
          if (event.target.checked) {
            setTheme("dark");
          } else {
            setTheme("light");
          }
        });

      document.addEventListener("DOMContentLoaded", function () {
        document.querySelector(".theme-controller").checked = false;
      });
    </script>