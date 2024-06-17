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

let selectedVisitType = '';
document.querySelectorAll('input[name="VisitType"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    selectedVisitType = this.value;
    getAppointDoctor(selectedVisitType);
    loadServices();
  });
});

document.getElementById('doctor').addEventListener('change', function() {
  loadServices();
});

function loadServices() {
  const doctorId = document.getElementById('doctor').value;
  document.getElementById('ServiceType').value = '';
  $('#availedServices').html('');
  if (selectedVisitType && doctorId) {
    getServices(doctorId, selectedVisitType);
  }

}
function getAppointDoctor(selectedVisitType){
  $.ajax({
    url: 'ajax.php?action=bookAppointmentDoctor&VisitType=' + encodeURIComponent(selectedVisitType),
    method: 'GET',
    dataType: 'html',
    success: function(data) {
      $('#doctor').html(data);
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}

function getServices(staff_Id, visitType){
  $.ajax({
    url: 'ajax.php?action=getDoctorServices&VisitType=' + encodeURIComponent(visitType) + '&staff_id=' + encodeURIComponent(staff_Id),
    method: 'GET',
    dataType: 'html',
    success: function(data) {
      $('#services').html(data);
      attachCheckboxListeners();
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}

function attachCheckboxListeners() {
  let services = document.getElementById('services');
  const checkboxes = services.querySelectorAll('input[type="checkbox"]');
  const serviceTypeInput = document.getElementById('ServiceType');

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const selectedSpecialty = this.getAttribute('data-specialty');

      if (this.checked) {
        checkboxes.forEach(cb => {
          if (cb !== this && cb.getAttribute('data-specialty') !== selectedSpecialty) {
            cb.checked = false;
          }
        });
      }

      updateServiceTypeInput();
    });
  });

  function updateServiceTypeInput() {
    let serviceval = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value)
      .join(';');
    serviceTypeInput.value = serviceval;
    $('#availedServices').html(': ' + serviceval);
  }
}