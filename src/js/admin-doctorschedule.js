// main
document.addEventListener('DOMContentLoaded', function () {
  var editButton = document.getElementById('editSchedule');
  var updateButton = document.getElementById('updateSchedule');
  var cancelButton = document.getElementById('cancelSchedule');
  var form = document.getElementById('availability-form');
  var inputs = form.querySelectorAll(
    'input[type="checkbox"], input[type="time"], input[type="radio"], select',
  );
  var repeatStart = document.getElementById('repeatStart');
  var repeatEnd = document.getElementById('repeatEnd');

  // Function to enable/disable form fields
  function setFormDisabledState(disabled) {
    inputs.forEach(function (input) {
      input.disabled = disabled;
    });
    repeatStart.disabled = disabled;
    repeatEnd.disabled = disabled;
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
    setFormDisabledState(false);
    toggleButtons(false);
  });

  // Click event for Cancel button
  cancelButton.addEventListener('click', function () {
    form.reset();
    setFormDisabledState(true);
    toggleButtons(true);
    document.getElementById('checkboxAlert').classList.add('hidden');
  });

  deleteButton.addEventListener('click', function () {
    // Reset UI to initial state regardless of modal outcome
    form.reset();
    setFormDisabledState(true);
    toggleButtons(true);
    document.getElementById('checkboxAlert').classList.add('hidden'); // Hide the alert
  });
});

// for required on input date in delete schedule
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

// for disabled dates from delete day and delete range
document.addEventListener('DOMContentLoaded', function () {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0');
  var yyyy = today.getFullYear();

  var dateStr = yyyy + '-' + mm + '-' + dd;

  var deleteDayDate = document.getElementById('deleteDayDate');
  var startDate = document.getElementById('startDate');
  var endDate = document.getElementById('endDate');

  deleteDayDate.setAttribute('min', dateStr);
  startDate.setAttribute('min', dateStr);
  endDate.setAttribute('min', dateStr);

  startDate.addEventListener('change', function () {
    var selectedStartDate = new Date(startDate.value);
    selectedStartDate.setDate(selectedStartDate.getDate() + 1);

    var nextDay = new Date(selectedStartDate);
    var nextDayStr = nextDay.toISOString().split('T')[0];

    endDate.setAttribute('min', nextDayStr);
  });

  // for repeat date range
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0');
  var yyyy = today.getFullYear();
  var dateStr = yyyy + '-' + mm + '-' + dd;

  var repeatStart = document.getElementById('repeatStart');
  var repeatEnd = document.getElementById('repeatEnd');

  repeatStart.setAttribute('min', dateStr);
  repeatEnd.setAttribute('min', dateStr);

  repeatStart.addEventListener('change', function () {
    var selectedrepeatStart = new Date(repeatStart.value);
    selectedrepeatStart.setDate(selectedrepeatStart.getDate() + 1);

    var nextDay = new Date(selectedrepeatStart);
    var nextDayStr = nextDay.toISOString().split('T')[0];

    repeatEnd.setAttribute('min', nextDayStr);
  });
});
