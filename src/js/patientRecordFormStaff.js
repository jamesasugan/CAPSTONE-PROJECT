function getRecords(record_id, chart_id){
  $.ajax({
    url: 'ajax.php?action=getOverallRecord&record_id='+ encodeURIComponent(record_id) + '&chart_id='+encodeURIComponent(chart_id),
  method: 'GET',
    dataType: 'json',
    success: function(data) {

    if (data.successResponse === 1) {
      let resData = data.data
      let availed_service = resData.availedService.split(",").map(service => service.trim());
      let Servicecheckboxes = document.querySelectorAll('#services input[type="checkbox"]');

      //loop each check box options in services

      Servicecheckboxes.forEach(checkbox => {

        if (availed_service.includes(checkbox.value.trim())) {
          checkbox.checked = true; // Check the checkbox
        }
      });
      let services = resData.availedService.split(",");
      let mappedServices = services.map(x => "<li>" + x.trim() + "</li>");


      $('#availedService').html('<strong class="text-xl">Service: </strong><br><span class="text-lg font-medium">'+mappedServices+'</span>');
      document.querySelector('#patientRecordForm input[name="serviceSelected"]').value = resData.availedService;
      document.querySelector('#patientRecordForm input[name="consultation-date"]').value = resData.consultationDate;
      document.querySelector('#patientRecordForm input[name="record_id"]').value = resData.Record_ID;
      document.querySelector('#patientRecordForm input[name="blood-pressure"]').value = resData.Blood_Pressure;
      document.querySelector('#patientRecordForm input[name="heart-rate"]').value = resData.HeartRate;
      document.querySelector('#patientRecordForm input[name="saturation"]').value = resData.Saturation;
      document.querySelector('#patientRecordForm input[name="temperature"]').value = resData.Temperature;
      document.querySelector('#patientRecordForm textarea[name="Chief Complaint"]').value = resData.Chief_complaint;
      document.querySelector('#patientRecordForm textarea[name="Physical Examination"]').value = resData.Physical_Examination;
      document.querySelector('#patientRecordForm textarea[name="Assessment"]').value = resData.Assessment;
      document.querySelector('#patientRecordForm textarea[name="Treatment Plan"]').value = resData.Treatment_Plan;
      getResImg(record_id);

    }else if (data.successResponse === 2){
      window.location.href = 'consultationResults.php?chart_id=' + chart_id;
    }else {
      console.log(data.message)
    }
  },
  error: function(xhr, status, error) {
    console.error('Error fetching data:', error);
  }
});
}
function getResImg(id) {
  $.ajax({
    url: 'ajax.php?action=getResImg&record_id=' + encodeURIComponent(id),
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data.response === 1) {
        let resData = data.data;
        let imgResult = '';

        for (let i = 0; i < resData.length; i++) {
          imgResult += `
            <div class="flex flex-col items-center">
              <div class="w-full flex justify-end mb-1">
                <a class="bg-red-500 text-white px-2 py-1 rounded cursor-pointer" onclick='deleteImg(${resData[i].img_id}, ${id});'>Delete</a>
              </div>
              <img class="h-auto max-w-full object-cover" src="../PatientChartRecordResults/${resData[i].image_file_name}" alt="Image Result">
            </div>`;
        }
        $('#ImageResults').html(imgResult);
      }else if (data.response === 0){
        $('#ImageResults').empty();
      }
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}
function deleteImg(img_id,record_id){
  $.ajax({
    url: 'ajax.php?action=delResImg&img_id=' + encodeURIComponent(img_id),
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data.response === 1) {
        getResImg(record_id);

      }
    },
    error: function(xhr, status, error) {
      console.error('Error fetching data:', error);
    }
  });
}
