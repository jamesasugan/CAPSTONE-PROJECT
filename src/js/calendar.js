document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  let currentMonth = new Date().getMonth();
  let currentYear = new Date().getFullYear();
  let currentView = 'month'; // Default view
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

  const schedules = {
    '2024-04-27': {
      availability: 'Dr. Smith available from 10 AM to 4 PM',
      extraInfo: 'Dr. Smith specializes in pediatric care.',
    },
    '2024-04-29': {
      availability: 'Dr. Smith available from 10 AM to 4 PM',
      extraInfo: 'Remember to bring your previous medical reports.',
    },
    '2024-05-01': {
      availability: 'Dr. Smith available from 10 AM to 4 PM',
      extraInfo: 'Remember to bring your previous medical reports.',
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
    for (let i = 1; i <= emptyDays; i++) {
      let day = prevMonthDays - emptyDays + i;
      html += `<div class="h-20 p-4 text-center cursor-pointer text-gray-400">${day}</div>`;
    }
    let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    for (let i = 1; i <= daysInMonth; i++) {
      let cls = 'h-20 p-4 text-center cursor-pointer';
      let isToday =
        i === today.getDate() &&
        currentMonth === today.getMonth() &&
        currentYear === today.getFullYear();
      let dateKey = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
      let info = schedules[dateKey]
        ? `<div class="text-xs text-blue-700 font-bold mt-1">${schedules[dateKey].availability}</div>`
        : '';
      cls += isToday
        ? ' bg-[#0b6c95] text-white'
        : ' text-black dark:text-white';
      cls += schedules[dateKey] ? ' bg-yellow-200 ' : '';
      html += `<div class="${cls}" data-date="${dateKey}">${i}${info}</div>`;
    }
    let remainingDays = (7 - ((emptyDays + daysInMonth) % 7)) % 7;
    for (let i = 1; i <= remainingDays; i++) {
      html += `<div class="h-20 p-4 text-center cursor-pointer text-gray-400">${i}</div>`;
    }
    html += '</div>';
    calendarEl.innerHTML += html;
  }

  function renderWeek() {
    calendarEl.innerHTML = '';
    updateMonthYearDisplay();
    let headerHtml =
      '<div class="grid grid-cols-7 divide-x divide-y border text-black dark:text-white border-gray-500">';
    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    daysOfWeek.forEach((day) => {
      headerHtml += `<div class="font-bold text-xs sm:text-base px-2 py-2 text-center">${day}</div>`;
    });
    headerHtml += '</div>';
    calendarEl.innerHTML += headerHtml;

    let currentDate = new Date(
      currentYear,
      currentMonth,
      today.getDate() - today.getDay(),
    );
    let html =
      '<div class="grid grid-cols-7 divide-x divide-y border border-gray-500">';
    for (let i = 0; i < 7; i++) {
      let day = currentDate.getDate();
      let cls =
        'h-20 p-4 text-center cursor-pointer text-black dark:text-white';
      let dateKey = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
      let info = schedules[dateKey]
        ? `<div class="text-xs text-blue-700 mt-1 font-bold">${schedules[dateKey].availability}</div>`
        : '';
      cls +=
        currentDate.toDateString() === new Date().toDateString()
          ? ' bg-[#0b6c95] text-white'
          : '';
      cls +=
        (schedules[dateKey] ? ' bg-yellow-200' : '') +
        (currentDate.getMonth() !== currentMonth ? ' text-gray-400' : '');
      html += `<div class="${cls}" data-date="${dateKey}">${day}${info}</div>`;
      currentDate.setDate(currentDate.getDate() + 1);
    }
    html += '</div>';
    calendarEl.innerHTML += html;
  }

  function renderDay() {
    calendarEl.innerHTML = '';
    updateMonthYearDisplay();
    let cls =
      'h-64 w-full border border-gray-500 text-center text-black dark:text-white cursor-pointer';
    let dateKey = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
    let info = schedules[dateKey]
      ? `<div class="text-xs text-blue-700  bg-yellow-200 pt-20 pb-[93px] my-10">${schedules[dateKey].availability}</div>`
      : '<div class="my-10">No events</div>';
    let isToday =
      today.getFullYear() === currentYear &&
      today.getMonth() === currentMonth &&
      today.getDate() === today.getDate();
    cls += isToday ? ' text-black font-bold' : '';
    let html = `<div class="${cls} ">${today.getDate()}${info}</div>`;
    calendarEl.innerHTML += html;
  }

  function renderCalendar() {
    switch (currentView) {
      case 'month':
        renderMonth();
        break;
      case 'week':
        renderWeek();
        break;
      case 'day':
        renderDay();
        break;
    }
  }

  document.getElementById('prevMonth').addEventListener('click', function () {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear--;
    } else {
      currentMonth--;
    }
    renderCalendar();
  });

  document.getElementById('nextMonth').addEventListener('click', function () {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear++;
    } else {
      currentMonth++;
    }
    renderCalendar();
  });

  document.getElementById('viewSelect').addEventListener('change', function () {
    currentView = this.value;
    renderCalendar();
  });

  renderCalendar(); // Initial render based on the default view
});
