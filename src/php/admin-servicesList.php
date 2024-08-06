<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once 'Utils.php';
if (!user_has_roles(get_account_type(), [AccountType::ADMIN]))
{
  return;
}
?>

<section id="services" class="w-full min-h-[100vh]">
  <div class="flex flex-col items-center px-4">
    <h2 class="text-4xl sm:text-6xl font-bold text-center mt-32 mb-11">
      Our Services
    </h2>
  </div>

  <div class="flex justify-end mr-10">
    <button class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold cursor-pointer border-none" onclick="addnewService.showModal()">Add Service</button>
  </div>

  <!-- ito yung dropdown na may search, gayahin mo to sa patient chart

  searchInput1,2,3,4 label at id kung magdadagdag ka, tas optionsList1,2,3,4 kung magdadagdag ka
-->
    <div class="container mx-auto w-2/4 mb-3">
        <label for="searchInput1" class="block font-medium text-gray-800 dark:text-white text-lg">Search Service</label>
        <div class="relative">
            <input type="text" id="searchInput1" placeholder="Search services..." class="input input-bordered w-full px-3 py-2 mb-1 bg-white dark:bg-gray-800 text-gray-800 dark:text-white">
                <ul id="optionsList1" class="absolute z-10 hidden w-full py-1 bg-white border border-gray-300 rounded-md shadow-md dark:bg-gray-800 dark:border-gray-700"></ul>
        </div>
    </div>

   

    <div class="flex flex-wrap justify-center gap-6 p-10">
      
      <!-- service card div
       gawin mong dynamic yung onclick -->
      <div class="relative w-full max-w-md h-80 md:h-96 shadow-lg rounded-lg overflow-hidden serviceList flex flex-col items-center">
          <img src="../images/internal medicine.png" alt="Internal Medicine" class="w-full h-full object-cover">

          <div class="absolute inset-0 flex flex-col items-center justify-center">
              <p class="w-full text-center text-3xl mb-10 font-bold text-white bg-slate-400 bg-opacity-80 p-4 rounded" style="text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);">
                  Internal Medicine
              </p>  

              <!-- gawin mong dynamic yung mga button names na to -->
              <div class="flex gap-1 sm:gap-5 justify-between">
              <!-- mark as unavailable at mark as available buttons, pinag isang modal ko na lang, imodify mo na lang depende sa clinick na button -->
                <button class="btn-edit btn bg-yellow-500 hover:bg-yellow-700 text-white px-5 rounded cursor-pointer border-none" onclick="modService.showModal()"><i class="fa-solid fa-ban fa-xl"></i></button>
                <button class="btn-edit btn bg-green-500 hover:bg-green-700 text-white px-5 rounded cursor-pointer border-none" onclick="modService.showModal()"><i class="fa-solid fa-circle-check fa-xl"></i></button>

                <button class="btn-edit btn bg-[#0b6c95] hover:bg-[#11485f] text-white px-5 rounded cursor-pointer border-none" onclick="editService1.showModal()"><i class="fa-solid fa-pen-to-square fa-xl text-white"></i></button>
                <button class="btn-edit btn bg-red-500 hover:bg-red-700 text-white px-5 rounded cursor-pointer border-none" onclick="delService.showModal()"><i class="fa-solid fa-trash-can fa-xl"></i></button>
              </div>

              <button class="btn-card bg-[#0b6c95] hover:bg-[#11485f] text-white px-5 py-3 mt-10 font-semibold rounded cursor-pointer border-none transition duration-150" onclick="service1.showModal()">
                  See More
              </button>
          </div>
      </div>
     
    </div>
    
</section>
  <!-- modal for delete service -->
  <dialog id="delService" class="modal">
    <div class="modal-box bg-gray-200 dark:bg-neutral text-[#0e1011] dark:text-[#eef0f1]">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 font-bold text-xl">✕</button>
      </form>


      <h3 class="text-2xl font-bold text-center mt-5">Are you sure you want to <span class="text-red-500">Delete</span> (Service Name)?</h3>
      <form method="POST">
        <div class="flex justify-center mb-5 mt-5">
            <input type="submit" class="btn bg-red-500 hover:bg-red-700 border-none text-white w-1/2" value="Delete">
        </div>
      </form>
    </div>
  </dialog>

  <!-- modal for mark as available/unavailable service. pinag isa ko na lang, ikaw na bahala mag modify depende sa clinick na button sa dalawa -->
  <dialog id="modService" class="modal">
    <div class="modal-box bg-gray-200 dark:bg-neutral text-[#0e1011] dark:text-[#eef0f1]">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 font-bold text-xl">✕</button>
      </form>

      <h3 class="text-2xl font-bold text-center mt-5">Please choose a Service that you want to <span class="text-yellow-500">Mark as Unavailable</span></h3>
      <h3 class="text-2xl font-bold text-center mt-5">Please choose a Service that you want to <span class="text-green-500">Mark as Available</span></h3>

      <form method="GET">
        <ul class="w-full mt-3 text-lg font-medium text-black dark:text-white bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600">
            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                <div class="flex items-center ps-3">
                    <input id="InternalMedicine" name="Internal Medicine" type="checkbox" value="Internal Medicine" class="checkbox checkbox-info">
                    <label for="InternalMedicine" class="w-full py-3 ms-2 font-medium">Internal Medicine</label>
                </div>
            </li>
        </ul>
        
        <div class="flex justify-center mb-5 mt-5 ">
          <input type="submit" class="btn bg-yellow-500 hover:bg-yellow-700 border-none text-white sm:w-1/2 w-full" value="Mark as Unavailable">
          <input type="submit" class="btn bg-green-500 hover:bg-green-700 border-none text-white sm:w-1/2 w-full" value="Mark as Unavailable">
        </div>
      </form>

    </div>
  </dialog>

  <!-- modal for "See More" Content per service -->
  <dialog id="service1" class="modal modal-middle">
    <div class="modal-box bg-gray-200 dark:bg-neutral text-[#0e1011] dark:text-[#eef0f1] text-center">
      <img src="../images/internal medicine.png" alt="internal Services" class="w-full h-auto mb-4"/>
      <h3 class="font-bold text-2xl">Internal Medicine</h3>
      <div class="text-base font-medium">
        <p>Dr. Ryan Joseph Gahol, MD</p>
      </div>

      <div class="border border-gray-400 my-2"></div>

      <p class="py-4 text-base font-medium">
        Internal medicine is a medical specialty that deals with the diagnosis and medical, as opposed to surgical, treatment of diseases of adults.
      </p>

      <div class="border border-gray-400 my-2"></div>

      <!-- kung maraming type of service add mo dito -->
      <p class="font-bold">List of Services Offered</p>
        <div class="font-medium text-base">
            <ul class="list-disc list-inside ml-5">
                <li>Internal Medicine</li>
            </ul>
        </div>

        <p class="font-bold mt-3">Price Range</p>
        <p class="text-base font-medium">&#8369;500-1000</p>
        <p class="italic text-sm ">Prices may vary depending on the Doctor</p>

      <div class="modal-action flex justify-center">
        <a href="bookappointment.php?service=Internal Medicine" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold cursor-pointer border-none">
          Book Appointment
        </a>
        <form method="dialog">
          <button class="btn bg-gray-400 hover:bg-gray-500 border-none text-[#0e1011] dark:text-[#eef0f1]">
            Close
          </button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- modal for edit service
    isang modal lang ginawan ko ah yung internal medicine lang, gawan mo sa lahat ng madadagdag -->
    <dialog id="editService1" class="modal">
        <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-black dark:text-white p-0">
            <div class="modal-header sticky top-0 bg-gray-200 dark:bg-gray-700 z-10 px-10 pt-10">
                    <div class="flex justify-between">
                      <h3 class="font-bold text-3xl mb-0 text-center">Edit Service</h3>
                      <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black border-none mb-2">Close</button>
                        </form>
                    </div>
                    </div>            
                  <div class="border border-gray-600 dark:border-slate-300"></div>
              </div>     

              <!-- dito mo sa baba nitong comment ilagay yung form ng edit service (katulad lang nung add service)
            di ko na cinopy paste para di magulo kaya ikaw na -->

        </div>
    </dialog>

  <!-- modal for adding service -->
    <dialog id="addnewService" class="modal">
        <div class="modal-box w-11/12 max-w-5xl bg-gray-200 dark:bg-gray-700 text-black dark:text-white p-0">
            <div class="modal-header sticky top-0 bg-gray-200 dark:bg-gray-700 z-10 px-10 pt-10">
                    <div class="flex justify-between">
                      <h3 class="font-bold text-3xl mb-0 text-center">Add a Service</h3>
                      <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button, it will close the modal -->
                            <button class="btn bg-gray-400 dark:bg-white hover:bg-gray-500 dark:hover:bg-gray-400  text-black border-none mb-2">Close</button>
                        </form>
                    </div>
                    </div>     
                    
                    
                  <div class="border border-gray-600 dark:border-slate-300"></div>
              </div>

        <form id='addNewService' action="#" method="GET" class="my-10">
            <div class="flex justify-center flex-col items-center mt-5 w-full">
                <!-- Image -->
                <img
                    src="../images/pediatrics.jpg"
                    alt="pediatrics"
                    class="w-1/2 mb-4" 
                />
                <!-- File input -->
                <input 
                    type="file" 
                    class="file-input file-input-bordered file-input-info bg-gray-200 text-black dark:bg-gray-600 dark:text-white w-full max-w-xs mt-2"
                    accept="image/*" 
                    required
                    max="1" 
                    multiple="false" 
                />
                <!-- Service Title/Specialty -->
                <div class="mt-5 w-2/4">
                    <label
                    for="serviceTitle"
                    class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                    >Service Title</label
                    >
                    <input
                    id="serviceTitle"
                    name="serviceTitle"
                    type="text"
                    value=""
                    autocomplete="off"
                    placeholder="Type service title here..."
                    class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white "
                    />
                </div>
                <div class="mt-5 w-2/4">
                    <label 
                    for="horizontal-list-radio-license"
                    class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                    >Visit Type</label
                    >
                    <ul class="w-full text-lg font-medium text-gray-900 bg-gray-300 dark:bg-gray-600 border border-gray-200 rounded-lg dark:border-gray-600 dark:text-white">
                    <li class="border-b border-gray-400 dark:border-slate-300">
                        <label class="flex items-center pl-3 w-full cursor-pointer">
                        <input id="horizontal-list-radio-license"
                        type="radio"
                        value="Consultation"
                        name="service"
                        class="radio radio-info [color-scheme:light] dark:[color-scheme:dark]"
                        required>
                        <span class="py-3 ml-2 text-lg font-medium ">Consultation</span>
                        </label>
                    </li>
                    <li>
                        <label class="flex items-center pl-3 w-full cursor-pointer">
                        <input id="horizontal-list-radio-id"
                        type="radio"
                        value="Test/Procedure"
                        name="service"
                        class="radio radio-info [color-scheme:light] dark:[color-scheme:dark]"
                        required>
                        <span class="py-3 ml-2 text-lg font-medium ">Test/Procedure</span>
                        </label>
                    </li>
                    </ul>
                </div>
                <!-- Choose Specialty -->
                <div class="mt-5 w-2/4">
                    <label
                      for="selectSpecialty"
                      class="block font-medium text-black dark:text-white text-base sm:text-lg"
                      >Choose Specialty</label
                    >
                    <select
                      id="selectSpecialty"
                      name="selectSpecialty"
                      class="select select-bordered appearance-none block w-full px-3 border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white "
                      required
                    >
                      <option value="">Select...</option>
                      <option value="Internal Medicine">Internal Medicine</option>
                      <option value="General Medicine">General Medicine</option>
                      <option value="Pediatrics">Pediatrics</option>
                      <option value="Radiologist">Radiologist</option>
                    </select>
                  </div>
                  <!-- Service Description -->
                  <div class="mt-5 w-2/4">
                    <label
                    for="serviceDescription"
                    class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                    >Service Description</label
                    >
                    <textarea id="serviceDescription" rows="4" name="serviceDescription"  class="input input-bordered h-52 w-full bg-white dark:bg-gray-600 text-black dark:text-white  border-none" placeholder="Service Description here..."></textarea>
                </div>
                 <!-- Services Offered -->
                <div class="mt-5 w-2/4">
                    <label
                        for="listofService"
                        class="block font-medium text-black dark:text-white text-base sm:text-lg whitespace-nowrap overflow-hidden text-ellipsis"
                    >Service Offered</label>
                    <div id="servicesList">
                        <div class="flex items-center mb-2">
                            <input
                                id="listofService"
                                name="listofService[]"
                                type="text"
                                value=""
                                autocomplete="off"
                                placeholder="Service offered here..."
                                class="input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white "
                            />
                            <button type="button" class="ml-2 text-red-500 hidden text-2xl" onclick="removeServiceField(this)">
                                <i class="fa-solid fa-circle-xmark fa-xl"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-info mt-2" onclick="addServiceField()">Add another service offered</button>
                </div>
               <!-- Price Range -->
                <div class="mt-5 w-2/4">
                    <label
                        for="priceRangeStart"
                        class="block font-medium text-black dark:text-white text-base sm:text-lg"
                    >Estimate Starting Price: <span class="text-blue-500 font-bold">&#8369;</span><span id="priceStartLabel" class="text-blue-500 font-bold">100</span></label
                    >
                    <input
                        id="priceRangeStart"
                        name="priceRangeStart"
                        type="range"
                        min="100"
                        max="10000"
                        step="100"
                        value="100"
                        class="range range-info appearance-none block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none bg-gray-200 dark:bg-gray-600 text-black dark:text-white "
                        oninput="updatePriceStartLabel(this.value)"
                    />
                </div>

                <!-- Price Range (End) -->
                <div class="mt-2 w-2/4">
                    <label
                        for="priceRangeEnd"
                        class="block font-medium text-black dark:text-white text-base sm:text-lg"
                    >Estimate Maximum Price: <span class="text-blue-500 font-bold">&#8369;</span><span id="priceEndLabel" class="text-blue-500 font-bold">100</span></label
                    >
                    <input
                        id="priceRangeEnd"
                        name="priceRangeEnd"
                        type="range"
                        min="100"
                        max="10000"
                        step="100"
                        value="100"
                        class="range range-info appearance-none block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none bg-gray-200 dark:bg-gray-600 text-black dark:text-white "
                        oninput="updatePriceEndLabel(this.value)"
                    />
                </div>

                <div class="flex justify-center mt-5">
                    <input type="submit" value="Submit" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none px-8">         
                  </div> 
            </div>
        </form>
        </div>
    </dialog>


  <!-- script for dropdown na may search, pwede mo to gamitin sa patient chart -->
  <script>
         function createSearchableDropdown(items, searchInputId, optionsListId) {
            const searchInput = document.getElementById(searchInputId);
            const optionsList = document.getElementById(optionsListId);

            // Function to filter items based on search input
            function filterItems(searchTerm) {
                return items.filter(item =>
                    item.toLowerCase().includes(searchTerm.toLowerCase())
                );
            }

            // Function to update the list of options
            function updateOptionsList(searchTerm) {
                optionsList.innerHTML = "";
                const filteredItems = filterItems(searchTerm);
                filteredItems.forEach(item => {
                    const option = document.createElement("li");
                    option.textContent = item;
                    option.className = "px-3 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700";
                    option.addEventListener("click", () => {
                        searchInput.value = item;
                        optionsList.classList.add("hidden");
                    });
                    optionsList.appendChild(option);
                });
                if (filteredItems.length === 0) {
                    const noResult = document.createElement("li");
                    noResult.textContent = "No results found";
                    noResult.className = "px-3 py-2 cursor-not-allowed text-gray-400 dark:text-gray-500";
                    optionsList.appendChild(noResult);
                }
            }

            // Event listener for search input
            searchInput.addEventListener("input", () => {
                const searchTerm = searchInput.value.trim();
                updateOptionsList(searchTerm);
                optionsList.classList.remove("hidden");
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", (event) => {
                if (!event.target.closest(`#${optionsListId}`) && !event.target.closest(`#${searchInputId}`)) {
                    optionsList.classList.add("hidden");
                }
            });
        }

        // dito listahan ng nasa dropdown search, gawa kang bagong const na array pag bagong search dropdown
        const specialties = [
            "Internal Medicine",
            "General Medicine",
            "Pediatrics",
            "Radiologist",
            "Cardiology",
            "Orthopedics",
            "Dermatology",
            "Oncology",
            "Neurology",
            "Gastroenterology",
            // Add more specialties as needed
        ];

        // dito mo call
        createSearchableDropdown(specialties, 'searchInput1', 'optionsList1');
    </script>


<!-- script nung add service form -->
  <script>
    function updatePriceStartLabel(value) {
        var endPriceInput = document.getElementById("priceRangeEnd");
        var endPriceLabel = document.getElementById("priceEndLabel");
        var startPrice = parseInt(value);
        
        // Update the start price label
        document.getElementById("priceStartLabel").textContent = value;
        
        // Ensure the end price is not less than the start price
        if (parseInt(endPriceInput.value) < startPrice) {
            endPriceInput.value = startPrice;
            endPriceLabel.textContent = startPrice;
        }
    }

    // Function to update the label for the end price range
    function updatePriceEndLabel(value) {
        var startPrice = parseInt(document.getElementById("priceRangeStart").value);
        
        // Ensure the end price is not less than the start price
        if (parseInt(value) < startPrice) {
            document.getElementById("priceRangeEnd").value = startPrice;
            document.getElementById("priceEndLabel").textContent = startPrice;
        } else {
            document.getElementById("priceEndLabel").textContent = value;
        }
    }

    function addServiceField() {
        var servicesList = document.getElementById("servicesList");
        var newServiceDiv = document.createElement("div");
        newServiceDiv.className = "flex items-center mb-2";

        var newServiceField = document.createElement("input");
        newServiceField.setAttribute("type", "text");
        newServiceField.setAttribute("name", "listofService[]");
        newServiceField.setAttribute("autocomplete", "off");
        newServiceField.setAttribute("placeholder", "Add another service offered here...");
        newServiceField.className = "input input-bordered appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-base sm:text-lg bg-white dark:bg-gray-600 text-black dark:text-white";

        var removeButton = document.createElement("button");
        removeButton.setAttribute("type", "button");
        removeButton.className = "ml-2 text-red-500";
        removeButton.innerHTML = '<i class="fa-solid fa-circle-xmark fa-xl"></i>';
        removeButton.onclick = function() {
            removeServiceField(this);
        };

        newServiceDiv.appendChild(newServiceField);
        newServiceDiv.appendChild(removeButton);
        servicesList.appendChild(newServiceDiv);
    }

    function removeServiceField(button) {
        var serviceDiv = button.parentNode;
        serviceDiv.parentNode.removeChild(serviceDiv);
    }
    </script>
    

