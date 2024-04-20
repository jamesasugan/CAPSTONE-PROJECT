// for eye password icon
function togglePasswordVisibility(passwordId, iconId) {
  const passwordInput = document.getElementById(passwordId);
  const icon = document.getElementById(iconId);
  if (passwordInput && icon) {
    // Check if elements exist
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }
}

// for requirements on password
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm-password');
const submitButton = document.querySelector('.signup-btn input[type="submit"]');
const requirementList = document.querySelectorAll('.requirement-list li');

const requirements = [
  { regex: /.{8,}/, index: 0 },
  { regex: /[0-9]/, index: 1 },
  { regex: /[A-Z]/, index: 2 },
  { regex: /^[a-zA-Z0-9]*$/, index: 3 }, // Regex to disallow special characters
];

function updateRequirements() {
  if (!passwordInput || !requirementList.length) return; // Guard clause if elements are missing

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

  if (confirmPasswordInput) {
    // Check if confirm password matches only if confirm password input exists
    const passwordsMatch = passwordInput.value === confirmPasswordInput.value;
    confirmPasswordInput.style.borderColor = passwordsMatch ? 'green' : 'red';

    // Enable or disable submit button based on validations and match
    submitButton.disabled = !allValid || !passwordsMatch;
  } else if (submitButton) {
    // Enable or disable submit button based only on validations if confirm password does not exist
    submitButton.disabled = !allValid;
  }
}

if (passwordInput) {
  passwordInput.addEventListener('input', updateRequirements);
}
if (confirmPasswordInput) {
  confirmPasswordInput.addEventListener('input', updateRequirements);
}
