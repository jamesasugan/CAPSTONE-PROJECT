document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  let currentMonth = new Date().getMonth();
  let currentYear = new Date().getFullYear();
  const today = new Date();
  const monthNames = [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
  ];

  const schedules = getDoctorSchedule();

  let searchFormVisible = true; // Track visibility of search form
  let noScheduleTextVisible = true; // Track visibility of "No schedule" text

  function updateMonthYearDisplay() {
      const monthYearEl = document.getElementById('currentMonth');
      monthYearEl.textContent = `${monthNames[currentMonth]} ${currentYear}`;
  }

  function renderMonth() {
      calendarEl.innerHTML = '';
      updateMonthYearDisplay();
      const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
      let headerHtml =
          '<div class="grid grid-cols-7 divide-x divide-y border text-black dark:text-white border-gray-500">';
      daysOfWeek.forEach((day) => {
          headerHtml += `<div class="font-bold text-xs sm:text-base px-2 py-2 text-center">${day}</div>`;
      });
      headerHtml += '</div>';
      calendarEl.innerHTML += headerHtml;

      const firstDay = new Date(currentYear, currentMonth, 1).getDay();
      let html =
          '<div class="grid grid-cols-7 divide-x divide-y border border-gray-500">';
      let emptyDays = firstDay;
      const prevMonthDays = new Date(currentYear, currentMonth, 0).getDate();
      for (let i = 0; i < emptyDays; i++) {
          html += `<div class="h-20 p-4 text-center text-gray-400 opacity-60">${prevMonthDays - emptyDays + 1 + i}</div>`;
      }

      const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
      let hasSchedules = false; // Flag to track if there are schedules in the current month

      for (let day = 1; day <= daysInMonth; day++) {
          const currentDate = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
          let cls = 'h-20 p-4 text-center cursor-pointer text-black dark:text-white font-bold';
          let isToday =
              today.getDate() === day &&
              today.getMonth() === currentMonth &&
              today.getFullYear() === currentYear;
          cls += isToday ? ' bg-[#0b6c95]' : '';

          let dayHasSchedule = schedules[currentDate];
          if (dayHasSchedule) {
              hasSchedules = true; // If there are schedules for any day, set the flag to true
          }

          let info = dayHasSchedule
              ? `<div class="text-xs text-blue-700 mt-1 overflow-hidden whitespace-nowrap text-overflow-ellipsis">View Schedules</div>`
              : '';
          cls += dayHasSchedule ? ' bg-yellow-200' : '';
          html += `<div class="${cls}" data-date="${currentDate}">${day}${info}</div>`;
      }

      // Restore visibility states of search form and "No schedule" text
      const searchForm = document.querySelector('#scheduleDetails form');
      const noScheduleText = document.getElementById('scheduleContent');

      if (hasSchedules) {
          searchForm.style.display = 'block'; // Show the search form
          noScheduleText.style.display = 'none'; // Hide the "No schedule" text
      } else {
          searchForm.style.display = 'none'; // Hide the search form
          noScheduleText.style.display = 'block'; // Show the "No schedule" text
      }

      searchForm.style.display = searchFormVisible ? 'block' : 'none';
      noScheduleText.style.display = noScheduleTextVisible ? 'block' : 'none';

      let totalCells = emptyDays + daysInMonth;
      let nextMonthDaysNeeded = totalCells % 7 !== 0 ? 7 - (totalCells % 7) : 0;
      for (let i = 0; i < nextMonthDaysNeeded; i++) {
          html += `<div class="h-20 p-4 text-center text-gray-400 opacity-60">${i + 1}</div>`;
      }
      html += '</div>';
      calendarEl.innerHTML += html;

      document.querySelectorAll('#calendar .cursor-pointer').forEach((day) => {
        day.addEventListener('click', function () {
            const date = this.getAttribute('data-date');
            if (schedules[date]) {
                showModal(date, schedules[date]);
            }
        });
    });
  }

  function showModal(date, daySchedules) {
      const titleEl = document.getElementById('modalTitle');
      const contentEl = document.getElementById('modalContent');
      const formattedDate = formatDate(date); // Format the date as desired

      titleEl.textContent = `${formattedDate}`;
      contentEl.innerHTML = daySchedules
          .map(
              (schedule) => `
                  <div class="p-4 w-full">
                      <h3 class="font-bold text-lg text-blue-800 dark:text-blue-200 mb-1 specialtySched">${schedule.department}</h3>
                      <p class="text-black dark:text-white text-base timeSched font-medium">${schedule.doctor} <br> ${schedule.times}</p>
                  </div>
              `,
          )
          .join('');
  }

  function formatDate(date) {
    const [year, month, day] = date.split('-');
    return `${monthNames[parseInt(month) - 1]} ${parseInt(day)}, ${year}`;
}


// Show schedule for the current date when the page loads
const currentDate = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
if (schedules[currentDate]) {
    showModal(currentDate, schedules[currentDate]);
} else {
    // If there are no schedules for the current day, display the date anyway
    const titleEl = document.getElementById('modalTitle');
    const formattedDate = formatDate(currentDate); // Format the date as desired
    titleEl.textContent = `${formattedDate}`;
}

document.getElementById('prevMonth').addEventListener('click', function () {
  if (currentMonth === 0) {
      currentMonth = 11;
      currentYear -= 1;
  } else {
      currentMonth -= 1;
  }
  searchFormVisible = document.querySelector('#scheduleDetails form').style.display !== 'none'; // Preserve search form visibility
  noScheduleTextVisible = document.getElementById('scheduleContent').style.display !== 'none'; // Preserve "No schedule" text visibility
  renderMonth();
});

document.getElementById('nextMonth').addEventListener('click', function () {
  if (currentMonth === 11) {
      currentMonth = 0;
      currentYear += 1;
  } else {
      currentMonth += 1;
  }
  searchFormVisible = document.querySelector('#scheduleDetails form').style.display !== 'none'; // Preserve search form visibility
  noScheduleTextVisible = document.getElementById('scheduleContent').style.display !== 'none'; // Preserve "No schedule" text visibility
  renderMonth();
});


renderMonth();
});

function getDoctorSchedule() {
let schedule;
$.ajax({
    url: 'ajax.php?action=getDoctorSched',
    method: 'GET',
    dataType: 'json',
    async: false,
    success: function (response) {
        schedule = response;
    },
    error: function (xhr, status, error) {
        console.error('Error fetching schedule:', error);
    }
});
return schedule;
}

