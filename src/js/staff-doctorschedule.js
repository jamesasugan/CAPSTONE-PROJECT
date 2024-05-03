document.addEventListener('DOMContentLoaded', function () {
  // Get button elements
  var editButton = document.getElementById('editSchedule');
  var updateButton = document.getElementById('updateSchedule');
  var cancelButton = document.getElementById('cancelSchedule');
  var form = document.getElementById('availability-form');
  var inputs = form.querySelectorAll(
    'input[type="checkbox"], input[type="time"], input[type="radio"]',
  );

  var yesNote = document.getElementById('yesNote'); // Get the yes note element
  var noNote = document.getElementById('noNote'); // Get the no note element

  // Function to enable/disable form fields
  function setFormDisabledState(disabled) {
    inputs.forEach(function (input) {
      input.disabled = disabled;
    });
  }

  // Function to show/hide buttons
  function toggleButtons(showEdit) {
    if (showEdit) {
      editButton.style.display = 'block';
      updateButton.style.display = 'none';
      cancelButton.style.display = 'none';
    } else {
      editButton.style.display = 'none';
      updateButton.style.display = 'block';
      cancelButton.style.display = 'block';
    }
  }

  // Click event for Edit button
  editButton.addEventListener('click', function () {
    setFormDisabledState(false); // Enable all inputs
    toggleButtons(false); // Show update and cancel buttons
  });

  // Click event for Cancel button
  cancelButton.addEventListener('click', function () {
    form.reset(); // Reset form fields to their default values
    setFormDisabledState(true); // Disable all inputs
    toggleButtons(true); // Show the edit button
    yesNote.style.display = 'none'; // Hide yes note
    noNote.style.display = 'none'; // Hide no note
  });

  deleteButton.addEventListener('click', function () {
    // Reset UI to initial state regardless of modal outcome
    form.reset();
    setFormDisabledState(true);
    toggleButtons(true);
  });

  // Manage display of notes based on radio button changes
  document.getElementById('yesRadio').addEventListener('change', function () {
    yesNote.style.display = this.checked ? 'block' : 'none';
    noNote.style.display = 'none';
  });

  document.getElementById('noRadio').addEventListener('change', function () {
    noNote.style.display = this.checked ? 'block' : 'none';
    yesNote.style.display = 'none';
  });
});

document.addEventListener('DOMContentLoaded', function () {
  var deleteSched = document.getElementById('deleteSched');
  var radios = document.querySelectorAll('input[name="list-radio"]');
  var deleteAllNote = document.getElementById('deleteAllNote');
  var deleteDayNote = document.getElementById('deleteDayNote');
  var customDeleteNote = document.getElementById('customDeleteNote');
  var deleteDayDate = document.getElementById('deleteDayDate');
  var startDate = document.getElementById('startDate');
  var endDate = document.getElementById('endDate');
  var passwordInput = document.getElementById('dlt-password');

  // Function to reset the modal
  window.resetModal = function () {
    radios.forEach((radio) => (radio.checked = false));
    deleteAllNote.style.display = 'none';
    deleteDayNote.style.display = 'none';
    customDeleteNote.style.display = 'none';
    deleteDayDate.value = '';
    startDate.value = '';
    endDate.value = '';
    passwordInput.value = '';
  };
  // Close modal and reset
  document
    .querySelector('.modal-action button')
    .addEventListener('click', function () {
      deleteSched.close();
      resetModal();
    });

  // Attach event listeners for radio changes
  radios.forEach((radio) => {
    radio.addEventListener('change', function () {
      // Reset display
      deleteAllNote.style.display = 'none';
      deleteDayNote.style.display = 'none';
      customDeleteNote.style.display = 'none';
      // Remove required attributes
      deleteDayDate.removeAttribute('required');
      startDate.removeAttribute('required');
      endDate.removeAttribute('required');

      // Manage display and required attributes based on selection
      if (radio.value === 'deleteAll') {
        deleteAllNote.style.display = 'block';
      } else if (radio.value === 'deleteDay') {
        deleteDayNote.style.display = 'block';
        deleteDayDate.setAttribute('required', '');
      } else if (radio.value === 'customDelete') {
        customDeleteNote.style.display = 'block';
        startDate.setAttribute('required', '');
        endDate.setAttribute('required', '');
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  var dateStr = yyyy + '-' + mm + '-' + dd; // Manually format to YYYY-MM-DD

  // Set the minimum date attributes for each relevant input
  var deleteDayDate = document.getElementById('deleteDayDate');
  var startDate = document.getElementById('startDate');
  var endDate = document.getElementById('endDate');

  deleteDayDate.setAttribute('min', dateStr);
  startDate.setAttribute('min', dateStr);
  endDate.setAttribute('min', dateStr);

  // Update endDate's min attribute when startDate changes
  startDate.addEventListener('change', function () {
    var selectedStartDate = new Date(startDate.value);
    selectedStartDate.setDate(selectedStartDate.getDate() + 1); // Add one day to start date

    var nextDay = new Date(selectedStartDate);
    var nextDayStr = nextDay.toISOString().split('T')[0]; // Format to YYYY-MM-DD

    endDate.setAttribute('min', nextDayStr);
  });
});
