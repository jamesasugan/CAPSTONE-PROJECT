document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  let currentMonth = new Date().getMonth();
  let currentYear = new Date().getFullYear();
  const today = new Date();
  const monthNames = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
  ];

  // dito mo ata lalagay yung mga iinput sa schedule
  const schedules = {
    '2024-04-26': {
      availability: 'Dr. Smith available from 10 AM to 4 PM', // ito nakalagay sa date box
      extraInfo: 'Dr. Smith specializes in pediatric care.', // ito naman nakalagay sa modal
    },
    '2024-04-29': {
      availability: 'Dr. Smith available from 10 AM to 4 PM', // ito nakalagay sa date box
      extraInfo: 'Remember to bring your previous medical reports.', // ito naman nakalagay sa modal
    },
  };

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
    for (let day = 1; day <= daysInMonth; day++) {
      const currentDate = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
      let cls =
        'h-20 p-4 text-center cursor-pointer text-black dark:text-white font-bold';
      let isToday =
        today.getDate() === day &&
        today.getMonth() === currentMonth &&
        today.getFullYear() === currentYear;
      cls += isToday ? ' text-white bg-[#0b6c95]' : ' text-black';
      let info = schedules[currentDate]
        ? `<div class="text-xs text-blue-700 mt-1 overflow-hidden whitespace-nowrap text-overflow-ellipsis">${schedules[currentDate].availability}</div>`
        : '';
      cls += schedules[currentDate]
        ? ' bg-yellow-200 text-black dark:text-black'
        : ''; // Change background if there is a schedule
      html += `<div class="${cls}" data-date="${currentDate}">${day}${info}</div>`;
    }

    let totalCells = emptyDays + daysInMonth;
    let nextMonthDaysNeeded = totalCells % 7 !== 0 ? 7 - (totalCells % 7) : 0;
    for (let i = 0; i < nextMonthDaysNeeded; i++) {
      html += `<div class="h-20 p-4 text-center text-gray-400 opacity-60">${i + 1}</div>`;
    }
    html += '</div>';
    calendarEl.innerHTML += html;

    document.querySelectorAll('#calendar .cursor-pointer').forEach((cell) => {
      cell.addEventListener('click', function () {
        const date = this.getAttribute('data-date');
        const schedule = schedules[date];
        if (schedule) {
          document.getElementById('modalTitle').textContent =
            `Schedule for ${date}`;
          document.getElementById('modalContent').textContent =
            schedule.availability;
          document.getElementById('modalContent').innerHTML +=
            `<p class='text-sm text-gray-500 mt-2'>${schedule.extraInfo}</p>`; // Add extra info
          document.getElementById('modal').classList.remove('hidden');
        }
      });
    });
  }

  document.getElementById('nextMonth').addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    renderMonth();
  });

  document.getElementById('prevMonth').addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    renderMonth();
  });

  document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('modal').classList.add('hidden');
  });

  renderMonth();
});
