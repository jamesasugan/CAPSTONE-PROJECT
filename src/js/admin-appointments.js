document.addEventListener('DOMContentLoaded', function () {
  const today = new Date().toISOString().split('T')[0];
  const rescheduleSection = document.getElementById('reschedule-section');
  const remarksInput = document.getElementById('remarks');
  const dateInput = document.getElementById('appointment-date');
  const dateTime = document.getElementById('appointment-time')

  document.querySelectorAll('input[name="list-status"]').forEach((input) => {
    input.addEventListener('change', function () {
      if (this.value === 'rescheduled') {
        rescheduleSection.style.display = 'flex';
        dateInput.required = true;
        dateTime.required = true;

        remarksInput.value = '';
      } else {
        rescheduleSection.style.display = 'none';
        dateInput.required = false;
        dateTime.required = false;

        if (this.value === 'approved') {

          remarksInput.value =
            'Your appointment is now listed, comply on the set date and time';
        } else if (this.value === 'cancelled') {
          remarksInput.value =
            'Your Appointment has been Cancelled due to unforeseen circumstances. Please rebook again if you want to continue';
        }
      }
    });
  });
});
