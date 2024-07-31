let selectedVisitType = '';
document.querySelectorAll('input[name="VisitType"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    selectedVisitType = this.value;
    getAppointDoctor(selectedVisitType);
    loadServices();
  });
});

document.getElementById('doctor').addEventListener('change', function() {
  loadServices();
});

function loadServices() {
  const doctorId = document.getElementById('doctor').value;
  document.getElementById('ServiceType').value = '';
  $('#availedServices').html('');
  if (selectedVisitType && doctorId) {
    getServices(doctorId, selectedVisitType);
  }

}
function getAppointDoctor(selectedVisitType){
  $.ajax({
    url: 'ajax.php?action=bookAppointmentDoctor&VisitType=' + encodeURIComponent(selectedVisitType),
    method: 'GET',
    dataType: 'html',
    success: function(data) {
      $('#doctor').html(data);
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}

function getServices(staff_Id, visitType){
  $.ajax({
    url: 'ajax.php?action=getDoctorServices&VisitType=' + encodeURIComponent(visitType) + '&staff_id=' + encodeURIComponent(staff_Id),
    method: 'GET',
    dataType: 'html',
    success: function(data) {
      $('#services').html(data);
      attachCheckboxListeners();
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}

function attachCheckboxListeners() {
  let services = document.getElementById('services');
  const checkboxes = services.querySelectorAll('input[type="checkbox"]');
  const serviceTypeInput = document.getElementById('ServiceType');

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const selectedSpecialty = this.getAttribute('data-specialty');

      if (this.checked) {
        checkboxes.forEach(cb => {
          if (cb !== this && cb.getAttribute('data-specialty') !== selectedSpecialty) {
            cb.checked = false;
          }
        });
      }

      updateServiceTypeInput();
    });
  });

  function updateServiceTypeInput() {
    let serviceval = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value)
      .join(';');
    serviceTypeInput.value = serviceval;
    $('#availedServices').html(serviceval);
  }
}