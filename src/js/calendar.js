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

  // dito schedules. ikaw na bahala sa names, surname lang ata dapat tas yung dr. depende kung anong level nila, baka mamaw na yung iba kaya di na doctor tawag eh kaya dapat maiiba mo
  const schedules = {
    '2024-04-27': [
      { department: 'Pediatrics', doctor: 'Dr. Smith', times: '10 AM to 3 PM' },
      { department: 'X-ray', doctor: 'Dr. Asugan', times: '8 AM to 1 PM' },
      { department: 'X-ray', doctor: 'Dr. Asugan', times: '8 AM to 1 PM' },
      { department: 'X-ray', doctor: 'Dr. Asugan', times: '8 AM to 1 PM' },
      { department: 'X-ray', doctor: 'Dr. Asugan', times: '8 AM to 1 PM' },
      { department: 'X-ray', doctor: 'Dr. Asugan', times: '8 AM to 1 PM' },
      { department: 'X-ray', doctor: 'Dr. Asugan', times: '8 AM to 1 PM' },
    ],
    '2024-05-01': [
      { department: 'Pediatrics', doctor: 'Dr. Smith', times: '10 AM to 3 PM' },
      { department: 'X-ray', doctor: 'Dr. Asugan', times: '8 AM to 1 PM' },
    ],
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
      cls += isToday ? ' bg-[#0b6c95]' : '';
      let dayHasSchedule = schedules[currentDate];
      let info = dayHasSchedule
        ? `<div class="text-xs text-blue-700 mt-1 overflow-hidden whitespace-nowrap text-overflow-ellipsis">View Schedules</div>`
        : '';
      cls += dayHasSchedule ? ' bg-yellow-200' : ''; // Change background if there is a schedule
      html += `<div class="${cls}" data-date="${currentDate}">${day}${info}</div>`;
    }

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
    const modal = document.getElementById('modal');
    const titleEl = document.getElementById('modalTitle');
    const contentEl = document.getElementById('modalContent');
    titleEl.textContent = `Schedule/s for ${date}`;
    contentEl.innerHTML = daySchedules
      .map(
        (schedule) => `
            <div class="p-4">
                <h3 class="font-bold text-xl sm:text-2xl text-blue-800 dark:text-blue-200 mb-1">${schedule.department}</h3>
                <p class="text-black dark:text-white text-base sm:text-lg">${schedule.doctor} - ${schedule.times}</p>
            </div>
        `,
      )
      .join('');
    modal.classList.remove('hidden');
  }

  document.getElementById('prevMonth').addEventListener('click', function () {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear -= 1;
    } else {
      currentMonth -= 1;
    }
    renderMonth();
  });

  document.getElementById('nextMonth').addEventListener('click', function () {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear += 1;
    } else {
      currentMonth += 1;
    }
    renderMonth();
  });

  document.getElementById('closeModal').addEventListener('click', function () {
    document.getElementById('modal').classList.add('hidden');
  });

  renderMonth();
});
