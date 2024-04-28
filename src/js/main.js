// for landpage-swiper.html
const swiper = new Swiper('.mySwiper', {
  spaceBetween: 0,
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  speed: 2000,
});

// for features.html
const swiperserve = new Swiper('.mySwiperist', {
  slidesPerView: 1,
  spaceBetween: 30,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    640: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

// Hamburger menu functionality
const toggleButton = document.querySelector('[aria-controls="mobile-menu"]');
const mobileMenu = document.getElementById('mobile-menu');

toggleButton.addEventListener('click', function () {
  if (mobileMenu.classList.contains('hidden')) {
    mobileMenu.classList.remove('hidden');
    mobileMenu.classList.add('block');
  } else {
    mobileMenu.classList.remove('block');
    mobileMenu.classList.add('hidden');
  }
});

// Close the mobile menu when a link is clicked
const menuLinks = mobileMenu.querySelectorAll('a');
menuLinks.forEach((link) => {
  link.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
    mobileMenu.classList.remove('block');
  });
});

// Close the mobile menu when clicking outside of it
document.addEventListener('click', function (event) {
  const withinBoundaries =
    event.composedPath().includes(mobileMenu) ||
    event.composedPath().includes(toggleButton);

  if (!withinBoundaries && !mobileMenu.classList.contains('hidden')) {
    mobileMenu.classList.add('hidden');
    mobileMenu.classList.remove('block');
  }
});

// Close dropdown menu
document.addEventListener('DOMContentLoaded', function () {
  const profileDropdown = document.querySelector('.profile-dropdown details');
  const dropdownContent = document.querySelector(
    '.profile-dropdown .dropdown-content',
  );

  document.addEventListener('click', function (event) {
    const isClickInsideProfileDropdown = profileDropdown.contains(event.target);

    if (!isClickInsideProfileDropdown && profileDropdown.open) {
      profileDropdown.removeAttribute('open');
    }
  });

  dropdownContent.addEventListener('click', function (event) {
    event.stopPropagation();
  });
});

// Toggle theme
document.addEventListener('DOMContentLoaded', function () {
  const themeCheckbox = document.querySelector('.theme-controller');
  if (themeCheckbox) {
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
    themeCheckbox.checked = savedTheme === 'dark';

    themeCheckbox.addEventListener('change', function (event) {
      if (event.target.checked) {
        setTheme('dark');
      } else {
        setTheme('light');
      }
    });
  } else {
    console.log('Theme controller element not found.');
  }
});

function setTheme(theme) {
  localStorage.setItem('theme', theme);
  if (theme === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
}

// for appointment date and time
document.addEventListener('DOMContentLoaded', function () {
  var inputDate = document.getElementById('appointment-date');
  if (inputDate) {
    var today = new Date();
    var todayDate = today.toISOString().slice(0, 10);
    inputDate.min = todayDate;
  }

  var inputTime = document.getElementById('appointment-time');
  if (inputTime) {
    adjustTimeAvailability();
    inputDate.addEventListener('change', adjustTimeAvailability); // Adjust time options when date changes
  }

  // do not change this
});

// for date of birth only
document.addEventListener('DOMContentLoaded', function () {
  var inputDob = document.getElementById('dob');
  if (inputDob) {
    // Check if the element exists
    var today = new Date();
    var maxDate = today.toISOString().split('T')[0]; // format yyyy-mm-dd
    inputDob.max = maxDate;
  }
});

// for vaccine stage
document.addEventListener('DOMContentLoaded', function () {
  const radios = document.querySelectorAll('input[name="vaccinated"]');
  const vaccineTypeSelect = document.getElementById('vaccine-type');

  radios.forEach((radio) => {
    radio.addEventListener('change', function () {
      vaccineTypeSelect.disabled = this.value !== 'yes';
    });
  });
});
