// for radio button
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[name="recordExist"]');
    const searchPatientRecord = document.getElementById('searchPatientRecord');
  
    radioButtons.forEach(radio => {
      radio.addEventListener('change', function() {
        if (this.value === 'Yes') {
          searchPatientRecord.classList.remove('hidden');
        } else {
          searchPatientRecord.classList.add('hidden');
        }
      });
    });
});

// for dropdown na may search
document.addEventListener('DOMContentLoaded', function() {
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
    const existingRecord = [
        "John Edward E. Dionisio",
        "James Emmanuel L. Asugan",
        "Cy Anthony O. Cruz",
        "Clent A. Juarez",
    ];
    

    // dito mo call
    createSearchableDropdown(existingRecord, 'searchInput1', 'optionsList1');
});

// for services || ayusin mo error pag nag sselect ng service naka error, null daw
document.addEventListener('DOMContentLoaded', function() {
    let services = document.getElementById('services');
    const checkboxes = services.querySelectorAll('input[type="checkbox"]');
    const otherServiceTextarea = document.getElementById('otherService');
    const serviceTypeInput = document.getElementById('ServiceType');

    otherServiceTextarea.addEventListener('input', function() {
      checkboxes.forEach(checkbox => {
        checkbox.checked = false;
      });
      serviceTypeInput.value = this.value;
    });

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const selectedSpecialty = this.getAttribute('data-specialty');

        if (this.checked) {
          checkboxes.forEach(cb => {
            if (cb !== this && cb.getAttribute('data-specialty') !== selectedSpecialty) {
              cb.checked = false;
            }
          });
          otherServiceTextarea.value = '';
        }

        updateServiceTypeInput();
      });
    });

    function updateServiceTypeInput() {
      serviceTypeInput.value = Array.from(checkboxes)
        .filter(cb => cb.checked)
        .map(cb => cb.value)
        .join(';');
    }
  });

  
  