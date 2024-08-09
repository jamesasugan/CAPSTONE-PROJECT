function setAppointmentId(appointmentId) {
  document.getElementById('newChart').setAttribute('data-appointment-id', appointmentId);
}

function getAppointmentInfo(patientAppointment_ID){
  $.ajax({
    url: 'ajax.php?action=getAppointmentInfo&patientAppointment_ID=' + patientAppointment_ID,
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data) {
        let appointmentSchedule = data.Appointment_schedule;
        let date = '';
        let formattedTime

        if (appointmentSchedule) {
          let parts = appointmentSchedule.split(' ');
          date = parts[0];
          formattedTime = appointmentSchedule ?
            (() => {
              const startTime = new Date(`2000-01-01T${parts[1]}`);
              const endTime = new Date(startTime.getTime() + 30 * 60000);

              const formattedStartTime = startTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
              const formattedEndTime = endTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });

              return `${formattedStartTime} - ${formattedEndTime}`;
            })()
            : 'N/A';



        }
        let status = data.Status.charAt(0).toUpperCase() + data.Status.slice(1).toLowerCase();
        document.querySelector('#appointment_status').textContent = status;
        document.querySelector('#AppointmentType').textContent = data.Appointment_type;

        let statusClass = '';
        switch (status) {
          case 'Pending':
            statusClass = 'text-yellow-600';
            break;
          case 'Approved':
            statusClass = 'text-info';
            break;
          case 'Rescheduled':
            statusClass = 'text-yellow-600';
            break;
          case 'Completed':
            statusClass = 'text-green-500';
            break;
          case 'Cancelled':
            statusClass = 'text-error';
            break;
          default:
            statusClass = 'text-slate-100';
            break;
        }
        document.getElementById('appointment_status').className = '';

        document.getElementById('appointment_status').classList.add('font-bold', statusClass)

        document.getElementById('approve').disabled = (status === 'Cancelled');


        let reason;
        if (data.ServiceType !== null) {
          reason = data.ServiceType
        }else {
          reason = '';
        }

        //document.querySelector('#update_appointment select[name="service-type"]').value = service_type;
        $('#selectedService').html(reason);
        document.querySelector('#appointmentform input[name="appointment-dateHistory"]').value = date;
        document.querySelector('#appointmentform input[name="appointment-timeHistory"]').value = formattedTime;
        document.querySelector('#appointmentform input[name="first-nameHistory"]').value = data.First_Name;
        document.querySelector('#appointmentform input[name="middle-nameHistory"]').value = data.Middle_Name;
        document.querySelector('#appointmentform input[name="last-nameHistory"]').value = data.Last_Name;
        document.querySelector('#appointmentform input[name="email"]').value = data.MemberPatientEmail;
        document.querySelector('#appointmentform input[name="contact-numberHistory"]').value = data.Contact_Number;
        document.querySelector('#appointmentform input[name="dobHistory"]').value = data.DateofBirth;
        document.querySelector('#appointmentform input[name="addressHistory"]').value = data.Address;
        document.querySelector('#update_appointment input[name="appointment_id"]').value = data.Appointment_ID;
        document.querySelector('#appointmentform select[name="sexHistory"]').value = data.Sex;

        let selectedStaff = document.querySelector('#update_appointment select[name="appointDoctor"]')
        if (selectedStaff){
          selectedStaff.value = data.Staff_ID;

        }

      }
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}
function create_patientChart(id) {
  $.ajax({
    url: 'ajax.php?action=createPatientChart&appointment_id=' + encodeURIComponent(id),
    type: 'GET',
    success: function(response) {
      if (parseInt(response) === 1) {
        window.location.href='staff-patientsRecord.php';
      } else {
        document.getElementById('error').innerHTML = response;
        toggleDialog('errorAlert');
      }
      console.log(response)
    }

  });
}

document.getElementById('update_appointment').addEventListener('submit', function(e){
  e.preventDefault();
  let form_data = new FormData(e.target);
  $.ajax({
    url: 'ajax.php?action=updateAppointment',
    type: 'POST',
    data: form_data,
    processData: false,
    contentType: false,
    success: function(response) {
      if (response.response === 1) {
        let actionSuccessMessage = 'Appointment has been updated, patient will get notified through SMS notification';
        successNotifcation('successNotif', actionSuccessMessage);


        setTimeout(function() {
          window.location.href='staff-appointments.php';
        }, 3000);
      }else {
        errorNotifcation('errorAlert', response.message);

      }
    }
  });
})