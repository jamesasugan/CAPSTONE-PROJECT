// For passwword validation
// Toggle password visibility
document.addEventListener('DOMContentLoaded', function () {
  setupPasswordToggle('password', 'password-icon');
  setupPasswordToggle('confirm-password', 'confirm-password-icon');
  initializeSecurityForm();
});

function setupPasswordToggle(passwordId, iconId) {
  const passwordInput = document.getElementById(passwordId);
  const icon = document.getElementById(iconId);
  const button = icon.closest('button');

  updateButtonDisplay(passwordInput, button);

  button.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });

  observeAttributeChanges(passwordInput, 'disabled', function () {
    updateButtonDisplay(passwordInput, button);
  });
}

function updateButtonDisplay(passwordInput, button) {
  button.style.display = passwordInput.disabled ? 'none' : 'flex';
}

function observeAttributeChanges(element, attribute, callback) {
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (
        mutation.type === 'attributes' &&
        mutation.attributeName === attribute
      ) {
        callback();
      }
    });
  });
  observer.observe(element, { attributes: true, attributeFilter: [attribute] });
}

function initializeSecurityForm() {
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm-password');

  // Save initial values
  passwordInput.dataset.initialValue = passwordInput.value;
  confirmPasswordInput.dataset.initialValue = confirmPasswordInput.value;

  document
    .getElementById('cancelSecurityBtn')
    .addEventListener('click', function () {
      resetForm();
    });
}

function resetForm() {
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm-password');

  // Reset values to initial
  passwordInput.value = passwordInput.dataset.initialValue;
  confirmPasswordInput.value = confirmPasswordInput.dataset.initialValue;

  // Reset visibility of password fields
  resetVisibility('password', 'password-icon');
  resetVisibility('confirm-password', 'confirm-password-icon');

  // Reset UI elements and validate
  resetUI();
  validatePasswords();
  resetPasswordIndicators(); // Add this line to reset indicators
}

function resetVisibility(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);
  input.type = 'password';
  icon.classList.remove('fa-eye-slash');
  icon.classList.add('fa-eye');
}

function validatePasswords() {
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm-password');
  if (!passwordInput.disabled) {
    const passwordsMatch = confirmPasswordInput.value === passwordInput.value;
    confirmPasswordInput.style.borderColor = passwordsMatch ? 'green' : 'red';
    const submitButton = document.getElementById('updateSecurityBtn');
    submitButton.disabled = !passwordsMatch || passwordInput.value === '';
  }
}

function resetUI() {
  const confirmPasswordInput = document.getElementById('confirm-password');
  confirmPasswordInput.style.borderColor = ''; // Reset border color to default
}
function resetPasswordIndicators() {
  requirementList.forEach((item) => {
    item.firstElementChild.className = 'fa-solid fa-circle';
    item.classList.remove('valid');
  });
}

// for password validation
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
  .getElementById('personalInfoTabStaff')
  .addEventListener('click', function () {
    document.getElementById('personalInfoStaff').classList.remove('hidden');
    document.getElementById('passwordSectionStaff').classList.add('hidden');
    resetSecurityEditState(); // Reset the password tab when leaving it
    getUserInfo();
  });

document
  .getElementById('passwordTabStaff')
  .addEventListener('click', function () {
    document.getElementById('personalInfoStaff').classList.add('hidden');
    document.getElementById('passwordSectionStaff').classList.remove('hidden');
    resetPersonalInfoStaffEditState(); // Reset the personal info tab when leaving it
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
  document.getElementById('personalInfoTabStaff').click();
});

// for patient-profile information
let editing = false;

document.getElementById('editButton').addEventListener('click', () => {
  toggleEdit(!editing);
});

function toggleEdit(enable) {
  editing = enable;
  const form = document.getElementById('personal-info');
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
    form.reset();
    getUserInfo();
  }
}

// for resetting when other link is clicked
function resetPersonalInfoStaffEditState() {
  editing = false;
  document.getElementById('editButton').classList.remove('hidden');
  document.getElementById('updateButton').classList.add('hidden');
  document.getElementById('cancelButton').classList.add('hidden');
  document
    .querySelectorAll('#personal-info input, #personal-info select')
    .forEach((input) => {
      input.disabled = true;
    });
  document.getElementById('personal-info').reset();
}

function resetSecurityEditState() {
  document.getElementById('editSecurityBtn').classList.remove('hidden');
  document.getElementById('updateSecurityBtn').classList.add('hidden');
  document.getElementById('cancelSecurityBtn').classList.add('hidden');
  document.getElementById('password').disabled = true;
  document.getElementById('confirm-password').disabled = true;
  document.querySelector('.requirement-list').classList.add('hidden');
  resetForm();
}
