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
function setTheme(theme) {
  if (theme === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
}

setTheme('light');

document
  .querySelector('.theme-controller')
  .addEventListener('change', function (event) {
    if (event.target.checked) {
      setTheme('dark');
    } else {
      setTheme('light');
    }
  });

document.addEventListener('DOMContentLoaded', function () {
  document.querySelector('.theme-controller').checked = false;
});
