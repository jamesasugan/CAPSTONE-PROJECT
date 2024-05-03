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
