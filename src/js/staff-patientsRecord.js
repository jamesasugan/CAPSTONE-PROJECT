document.addEventListener('DOMContentLoaded', function () {
  const editBtn = document.getElementById('editBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const updateBtn = document.getElementById('updateBtn');
  const form = document.getElementById('patientForm');
  const inputs = form.querySelectorAll(
    'input[type=text], input[type=date], input[type=file], textarea',
  );

  // Enable editing
  editBtn.addEventListener('click', function (e) {
    e.preventDefault();
    updateBtn.classList.remove('hidden');
    cancelBtn.classList.remove('hidden');
    editBtn.classList.add('hidden');

    inputs.forEach((input) => {
      input.disabled = false;
    });
  });

  // Cancel editing
  cancelBtn.addEventListener('click', function (e) {
    e.preventDefault();
    resetPatientForm();
  });
});

function resetPatientForm() {
  const form = document.getElementById('patientForm');
  const inputs = form.querySelectorAll(
    'input[type=text], input[type=date], input[type=file], textarea',
  );
  const editBtn = document.getElementById('editBtn');
  const updateBtn = document.getElementById('updateBtn');
  const cancelBtn = document.getElementById('cancelBtn');

  form.reset(); // Reset form fields to their default values

  inputs.forEach((input) => {
    input.disabled = true; // Disable all inputs
  });

  // Show/Hide buttons correctly
  editBtn.classList.remove('hidden');
  updateBtn.classList.add('hidden');
  cancelBtn.classList.add('hidden');
}

// Handle the modal close event
document
  .querySelector('.modal-action button')
  .addEventListener('click', function (e) {
    e.preventDefault();
    resetPatientForm();
    view_info1.close(); // Close the modal
  });
