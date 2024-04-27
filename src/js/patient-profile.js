// For passwword validation
// Toggle password visibility
function togglePasswordVisibility(passwordId, iconId) {
  const passwordInput = document.getElementById(passwordId);
  const icon = document.getElementById(iconId);
  if (passwordInput && icon) {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }
}

// Initialize elements
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm-password');
const submitButton = document.getElementById('updateSecurityBtn');
const requirementList = document.querySelectorAll('.requirement-list li');

const requirements = [
  { regex: /.{8,}/, index: 0 }, // At least 8 characters
  { regex: /[0-9]/, index: 1 }, // At least one digit
  { regex: /[A-Z]/, index: 2 }, // At least one uppercase letter
  { regex: /^[a-zA-Z0-9]*$/, index: 3 }, // No special characters
];

function updateRequirements() {
  let allValid = true;
  requirements.forEach((item) => {
    const isValid = item.regex.test(passwordInput.value);
    const requirementItem = requirementList[item.index];

    if (isValid) {
      requirementItem.firstElementChild.className = 'fa-solid fa-check';
      requirementItem.classList.add('valid');
    } else {
      requirementItem.firstElementChild.className = 'fa-solid fa-circle';
      requirementItem.classList.remove('valid');
      allValid = false;
    }
  });

  const passwordsMatch = confirmPasswordInput.value === passwordInput.value;
  confirmPasswordInput.style.borderColor = passwordsMatch ? 'green' : 'red';
  submitButton.disabled = !allValid || !passwordsMatch;
}

// Event listeners
if (passwordInput) {
  passwordInput.addEventListener('input', updateRequirements);
}
if (confirmPasswordInput) {
  confirmPasswordInput.addEventListener('input', updateRequirements);
}

// Functions to manage edit mode in the form
function toggleSecurityEdit(enable) {
  document.getElementById('password').disabled = !enable;
  document.getElementById('confirm-password').disabled = !enable;
  document.getElementById('editSecurityBtn').classList.toggle('hidden', enable);
  document
    .getElementById('updateSecurityBtn')
    .classList.toggle('hidden', !enable);
  document
    .getElementById('cancelSecurityBtn')
    .classList.toggle('hidden', !enable);
  document
    .querySelector('.requirement-list')
    .classList.toggle('hidden', !enable);

  // Add event listeners only when enabling edit mode
  if (enable) {
    passwordInput.addEventListener('input', updateRequirements);
    confirmPasswordInput.addEventListener('input', updateRequirements);
  } else {
    passwordInput.removeEventListener('input', updateRequirements);
    confirmPasswordInput.removeEventListener('input', updateRequirements);
  }
}

//for sidebar links
document
  .getElementById('personalInfoTab')
  .addEventListener('click', function () {
    document.getElementById('personalInfo').classList.remove('hidden');
    document.getElementById('securityPrivacy').classList.add('hidden');
    document.getElementById('appointmentHistory').classList.add('hidden');
  });

document
  .getElementById('securityPrivacyTab')
  .addEventListener('click', function () {
    document.getElementById('personalInfo').classList.add('hidden');
    document.getElementById('securityPrivacy').classList.remove('hidden');
    document.getElementById('appointmentHistory').classList.add('hidden');
  });

document
  .getElementById('appointmentHistoryTab')
  .addEventListener('click', function () {
    document.getElementById('personalInfo').classList.add('hidden');
    document.getElementById('securityPrivacy').classList.add('hidden');
    document.getElementById('appointmentHistory').classList.remove('hidden');
  });

// for active links sidebar
document.addEventListener('DOMContentLoaded', function () {
  const items = document.querySelectorAll('.sidebar-item');
  items.forEach((item) => {
    item.addEventListener('click', function () {
      items.forEach((innerItem) => {
        // Remove active classes
        innerItem.classList.remove('bg-[#0b6c95]', 'text-white', 'font-bold');
        innerItem.classList.add('text-black', 'dark:text-white');
      });
      // Add active classes to the clicked item
      item.classList.add('bg-[#0b6c95]', 'text-white', 'font-bold');
      item.classList.remove('text-black', 'dark:text-white');
    });
  });
  // Set initial active state
  document.getElementById('personalInfo').click();
});

// for patient-profile
let editing = false;

document.getElementById('editButton').addEventListener('click', () => {
  toggleEdit(!editing);
});

function toggleEdit(enable) {
  editing = enable;
  document
    .querySelectorAll('#personal-info input, #personal-info select')
    .forEach((input) => {
      input.disabled = !enable;
    });
  if (enable) {
    document.getElementById('editButton').classList.add('hidden');
    document.getElementById('updateButton').classList.remove('hidden');
    document.getElementById('cancelButton').classList.remove('hidden');
  } else {
    document.getElementById('editButton').classList.remove('hidden');
    document.getElementById('updateButton').classList.add('hidden');
    document.getElementById('cancelButton').classList.add('hidden');
  }
}
