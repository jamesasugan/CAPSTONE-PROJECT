document.addEventListener('DOMContentLoaded', function () {
  const userTypeSelect = document.getElementById('staffType');
  const specialtyDiv = document.getElementById('specialtyDiv');
  const specialtySelect = document.getElementById('specialty');

  // Function to show/hide department and specialty based on user type
  function toggleFieldsBasedOnType() {
    const userType = userTypeSelect.value;
    if (userType === 'doctor') {
      specialtyDiv.style.display = '';
      specialtySelect.required = true;
    } else {
      specialtyDiv.style.display = 'none';
      specialtySelect.required = false;
    }
  }

  // Initially hide the fields if the selected type isn't "Doctor"
  toggleFieldsBasedOnType();

  // Event listener for changes on the userType select element
  userTypeSelect.addEventListener('change', toggleFieldsBasedOnType);
});
