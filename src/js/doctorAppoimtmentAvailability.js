function getDoctorAvailability(id) {
  $.ajax({
    url: 'ajax.php?action=getDoctorAvailabilityDate&doctor_ID=' + encodeURIComponent(id),
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      $('#appointment-time').html('');
      const dateInput = document.getElementById('appointment-date');
      const dateNote = document.getElementById('appointmentDateNote');
      dateInput.value = "";
      dateInput.disabled = true;
      dateNote.innerHTML = '';
      dateNote.classList.add('hidden');

      if (response.message === 'No schedule') {
        dateNote.innerHTML = '(This doctor has no schedule)';
        dateNote.classList.remove('hidden');
      } else if (Array.isArray(response)) {
        dateInput.disabled = false;
        checkDoctorAvailability(dateInput, response, id);
      }
    },
    error: function(xhr, status, error) {
      console.error('Error fetching schedule:', error);
    }
  });
}

function checkDoctorAvailability(dateInput, datesArray, doctor_id) {
  const newDateInput = dateInput.cloneNode(true);
  dateInput.parentNode.replaceChild(newDateInput, dateInput);
  newDateInput.addEventListener('change', function() {
    const dateNote = document.getElementById('appointmentDateNote');
    if (!datesArray.includes(newDateInput.value)) {
      dateNote.classList.remove('hidden');
      dateNote.innerHTML = '(Please check doctor schedule)';
      newDateInput.value = '';
    } else {
      getAvailableAppointmentTime(newDateInput.value, doctor_id);
      dateNote.classList.add('hidden');
    }
  });
}




function getAvailableAppointmentTime(date, doctor_id){
  $.ajax({
    url: 'ajax.php?action=getDoctorAvailabilityTime&schedDate=' + encodeURIComponent(date) + '&doctor_id=' + encodeURIComponent(doctor_id),
    method: 'GET',
    dataType: 'html',
    success: function(response) {
      $('#appointment-time').html(response);
    }
  })
}