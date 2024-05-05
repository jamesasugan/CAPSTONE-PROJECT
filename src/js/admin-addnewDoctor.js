document.addEventListener('DOMContentLoaded', function () {
  const userTypeSelect = document.getElementById('staffType');
  const departmentDiv = document.getElementById('departmentDiv');
  const specialtyDiv = document.getElementById('specialtyDiv');
  const departmentSelect = document.getElementById('department');
  const specialtySelect = document.getElementById('specialty');

  // Function to show/hide department and specialty based on user type
  function toggleFieldsBasedOnType() {
    const userType = userTypeSelect.value;
    if (userType === 'doctor') {
      departmentDiv.style.display = '';
      specialtyDiv.style.display = '';
      departmentSelect.required = true;
      specialtySelect.required = true;
    } else {
      departmentDiv.style.display = 'none';
      specialtyDiv.style.display = 'none';
      departmentSelect.required = false;
      specialtySelect.required = false;
    }
  }

  // Initially hide the fields if the selected type isn't "Doctor"
  toggleFieldsBasedOnType();

  // Event listener for changes on the userType select element
  userTypeSelect.addEventListener('change', toggleFieldsBasedOnType);
});
