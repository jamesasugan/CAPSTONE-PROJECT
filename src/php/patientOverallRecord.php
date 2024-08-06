<!-- admin and patient -->
<?php
session_start();
require_once 'Utils.php';
include_once '../Database/database_conn.php';
if (!user_has_roles(get_account_type(), [AccountType::PATIENT, AccountType::ADMIN]))
{
  return;
}


/* else {
  return;
  //header('Location: staff-patientsRecord.php');
 // exit();
}*/


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Record</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
    <link rel="stylesheet" href="../css/print.css">
    <script
      src="https://kit.fontawesome.com/70df29d299.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="icon" type="image/x-icon" href="../images/logosmall.png" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script
      type="module"
      src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule=""
      src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
</head>
<body>
    <div class="mainContainer">
    <?php include 'navbar.php'; ?>

        <!-- OVERALL RECORDS PARA SA ADMIN AT PATIENT -->

        <section id="overallPatientRecord" class="w-full min-h-screen flex justify-center items-center pt-28 p-5 bg-[#f6fafc] dark:bg-[#17222a]">
            <div class="w-full max-w-8xl min-h-[600px] mx-auto p-4 rounded-lg shadow-lg bg-gray-200 dark:bg-gray-700 text-[#0e1011] dark:text-[#eef0f1]">
                <div class="flex text-center justify-center font-bold">
                    <h1 class="text-4xl mb-2">Patient Record</h1>
                </div>

                <div class="mb-10 mt-5 flex justify-center">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2 max-w-4xl w-full text-lg">
                        <div>
                            <strong class="block">Name</strong>
                            <span class="block" id='vrecName'></span>
                        </div>
                        <div>
                            <strong class="block" >Age</strong>
                            <span class="block" id='vrecAge'></span>
                        </div>
                        <div>
                            <strong class="block" >Sex</strong>
                            <span class="block" id='vrecSex'></span>
                        </div>
                        <div>
                            <strong class="block" >Contact Number</strong>
                            <span class="block" id='vrecContactNum'></span>
                        </div>
                        <div>
                            <strong class="block" >Email</strong>
                          <span class="block" id='vrecEmail'></span>
                        </div>
                        <div>
                            <strong class="block">Weight</strong>
                          <span class="block" id='vrecWeight'></span>
                        </div>
                        <div>
                            <strong class="block">Date of Birth</strong>
                          <span class="block" id='vrecDob'></span>
                        </div>
                        <div>
                            <strong class="block">Medical Condition</strong>
                          <span class="block" id='vrecMDcondition'></span>
                        </div>
                        <div>
                            <strong class="block">Address</strong>
                          <span class="block" id='vrecAddress'></span>
                        </div>
                    </div>
                </div>

            
                <!-- eto kapag wala pang record
                <p class="text-2xl font-semibold text-center">No Records Yet</p>
                -->

                <div class="flex justify-center mb-5 mt-5">
                    <button id="print" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none printformButton flex flex-col items-center px-5 py-1">
                        <i class="fa-solid fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>

                    <div class="mx-auto w-11/12 px-4 py-8 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mb-10">   

                            <div class="recordList">
                                <table cellpadding="0" cellspacing="0" class="w-full">
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold py-2 text-xl w-1/4">Service</td>
                                        <td class="w-3/4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="font-medium py-2" id='vrecAvailedService'>
                                            <li>Flu Vaccine</li>
                                            <li>Pneumococcal Vaccine Measles, Mumps, and Rubella Vaccine</li>
                                            <li>Monthly Immunization for babies</li>
                                            <li>Polio Vaccine</li>
                                        </td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/2">Consultation Date</td>
                                        <td class="font-medium w-1/2" id='vrecConsultationDate'>July 21, 2024</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/2">Consultant</td>
                                        <td class="font-medium w-1/2" id='vrecConsultant'>Dr. John Edward Dionisio</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/2">Heart Rate</td>
                                        <td class="font-medium w-1/2" id='vrecHearRate'>90</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/2">Temperature</td>
                                        <td class="font-medium w-1/2" id='vrecTemp'>36</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/2">Blood Pressure</td>
                                        <td class="font-medium w-1/2" id='vrecBP'>110/70</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/2">Saturation</td>
                                        <td class="font-medium w-1/2" id='vrecSaturation'>96%</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/4">Chief Complaint</td>
                                        <td class="w-3/4"></td>
                                    </tr>
                                    <tr>
                                        <!-- Chief Complaint -->
                                        <td colspan="2" class="font-medium" id='vrecChiefComp'>Experiencing high fever, severe headache, and joint pain for the past few days.</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/4">Physical Examination</td>
                                        <td class="w-3/4"></td>
                                    </tr>
                                    <tr>
                                        <!-- Physical Examination -->
                                        <td colspan="2" class="font-medium" id='vrecPhyExam'>
                                            Patient appears febrile and fatigued. Normal heart sounds, no murmurs, regular rhythm. Clear breath sounds bilaterally, no wheezing or crackles. Soft, mild tenderness in the right upper quadrant, no organomegaly. No rash or petechiae observed. Stable except for elevated temperature.
                                        </td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/4">Assessment</td>
                                        <td class="w-3/4"></td>
                                    </tr>
                                    <tr>
                                        <!-- Assessment -->
                                        <td colspan="2" class="font-medium" id='vrecAssesment'>
                                            Febrile illness with severe headache and myalgia, suspected dengue fever.
                                        </td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold w-1/4">Treatment Plan</td>
                                        <td class="w-3/4"></td>
                                    </tr>
                                    <tr>
                                        <!-- Treatment Plan -->
                                        <td colspan="2" class="font-medium" id='vrecTreatmentPlan'>
                                            Order dengue NS1 antigen test and dengue IgM and IgG antibody tests to confirm the diagnosis. Recommend complete blood count (CBC) to check for leukopenia and thrombocytopenia, which are common in dengue fever. Advise the patient to maintain adequate hydration by drinking plenty of fluids. Prescribe acetaminophen 500 mg, one tablet every 6 hours as needed for fever and pain. Instruct the patient to avoid NSAIDs such as ibuprofen and aspirin due to the risk of bleeding.
                                        </td>
                                    </tr>
                                </table>

                                <!-- hide mo tong "Results" tsaka border pag walang image -->
                                <div class="border border-gray-400 mt-10 mb-10" id='presborder'></div>
                                <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center" id='vresttext'>Results</h2>
                                <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id="VImageResults">
                                    <div class="flex flex-col items-center">                
                                        <!-- image dito, example lang tong img tag, alisin mo na lang -->
<!--                                        <img class="h-auto max-w-full object-cover" src="../images/xray.jpg" alt="Image Result">
-->                                    </div>
                                </div>

                            </div>
                    </div>
                
            </div>
        </section>
    </div>

    <!-- print content -->
    <div class="recordContent hidden">
              <a id="save_to_image">
                <div class="invoice-container"> 
                  <table cellpadding="0" cellspacing="0" class="w-full">
                    <tr class="top">
                        <td colspan="2">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold">Patient Record Form</span>
                                <img
                                src="../images/HCMC-blue.png"
                                class="w-full max-w-xs"
                                style="width: 100%; max-width: 100px"
                                />
                            </div>
                        </td>
                    </tr>
                    <tr class="information">
                      <td colspan="2">
                      <table class="table-fixed w-full">
                        <tr>
                          <td class="w-1/2 p-2 align-top">
                            <p><strong>Name:</strong> <span id='precName'></span></p>
                            <p><strong>Sex:</strong> <span id='precSex'></span></p>
                            <p><strong>Medical Conditions:</strong> <span id='precMD'></span></p>
                            <p><strong>Email:</strong> <span id='precEmail'></span></p>
                            <p><strong>Address:</strong> <span  id='precAddress'></span></p>
                          </td>
                          <td class="w-1/2 p-2 align-top">
                            <p><strong>Age:</strong> <span  id='precAge'></span></p>
                            <p><strong>Weight:</strong> <span  id='precWeight'></span></p>
                            <p><strong>Contact Number:</strong> <span id='precContactNum'></span></p>
                            <p><strong>Date of Birth:</strong> <span id='precDOB'></span></p>
                          </td>
                        </tr>
                      </table>
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Service</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2" id='precAvailedService'>

                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/2">Consultation Date</td>
                      <td class="font-medium py-2 w-1/2" id='precConsultationDate'>July 21, 2024</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/2">Consultant</td>
                      <td class="font-medium py-2 w-1/2" id='precConsultant'>Dr. John Edward Dionisio</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/2">Heart Rate</td>
                      <td class="font-medium py-2 w-1/2 id='precHearRate'">90</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/2">Temperature</td>
                      <td class="font-medium py-2 w-1/2" id='precTemp'>36</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/2">Blood Pressure</td>
                      <td class="font-medium py-2 w-1/2" id='precBP'>110/70</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/2">Saturation</td>
                      <td class="font-medium py-2 w-1/2" id='precSaturation'>96%</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/4">Chief Complaint</td>
                      <td class="w-3/4"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2" id='precChiefComp'>Experiencing high fever, severe headache, and joint pain for the past few days.</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/4">Physical Examination</td>
                      <td class="w-3/4"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2" id='precPhyExam'>
                      Patient appears febrile and fatigued.
                      Normal heart sounds, no murmurs, regular rhythm.
                      Clear breath sounds bilaterally, no wheezing or crackles.
                      Soft, mild tenderness in the right upper quadrant, no organomegaly.
                      No rash or petechiae observed.
                      Stable except for elevated temperature.
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/4">Assessment</td>
                      <td class="w-3/4"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2" id='precAssesment'>
                      Febrile illness with severe headache and myalgia, suspected dengue fever.
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2 w-1/4">Treatment Plan</td>
                      <td class="w-3/4"></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2" id='precTreatmentPlan'>
                      Order dengue NS1 antigen test and dengue IgM and IgG antibody tests to confirm the diagnosis.
                      Recommend complete blood count (CBC) to check for leukopenia and thrombocytopenia, which are common in dengue fever.
                      Advise the patient to maintain adequate hydration by drinking plenty of fluids.
                      Prescribe acetaminophen 500 mg, one tablet every 6 hours as needed for fever and pain.
                      Instruct the patient to avoid NSAIDs such as ibuprofen and aspirin due to the risk of bleeding.
                      </td>
                    </tr>
                  </table>

                  <!-- image results dito, hide mo "Results" na text pag walang image -->
                  <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center mt-10" id='presttext'>Results</h2>

                  <!-- isang buong div na to per image -->
                  <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id="PImageResults">

                  </div>

                  <!-- image results end -->

                </div>
            </a>
    </div>
    <!-- print content end -->

    <script src="../js/index.js"></script>


    <script>
      document.addEventListener('DOMContentLoaded', function(){
        $.ajax({
          url: 'ajax.php?action=getOverallRecord&chart_id=' + encodeURIComponent('<?=$_GET["chart_id"]?>') + '&record_id=' +  encodeURIComponent('<?=$_GET["record_id"]?>'),
          type: 'GET',
          success: function(response) {
            if (response.successResponse === 1) {
              let data = response.data;


              $('#vrecName').html(data.First_Name + data.Middle_Name + data.Last_Name);
              let age = Math.floor((new Date() - new Date(data.DateofBirth)) / (365.25 * 24 * 60 * 60 * 1000));
              $('#vrecAge').html(age)
              $('#vrecSex').html(data.Sex);
              $('#vrecContactNum ').html(data.Contact_Number);
              $('#vrecEmail').html(data.patientEmail);
              $('#vrecWeight').html(data.Weight);
              $('#vrecDob').html(data.DateofBirth);
              $('#vrecMDcondition').html(data.Medical_condition);
              $('#vrecAddress').html(data.Address);


              let services = data.availedService.split(",");
              let mappedServices = services.map(x => "<li>" + x.trim() + "</li>");
              $('#vrecAvailedService').html(mappedServices);
              $('#vrecConsultationDate').html(data.consultationDate);
             $('#vrecConsultant').html(response.consultant);
              $('#vrecHearRate').html(data.HeartRate);
              $('#vrecTemp').html(data.Temperature);
              $('#vrecBP').html(data.Blood_Pressure);
              $('#vrecSaturation').html(data.Saturation);
              $('#vrecChiefComp').html(data.Chief_complaint);
              $('#vrecPhyExam').html(data.Physical_Examination);
              $('#vrecAssesment').html(data.Assessment);
              $('#vrecTreatmentPlan').html(data.Treatment_Plan);

              $('#precAvailedService').html(mappedServices);



              $('#precName').html(data.First_Name + data.Middle_Name + data.Last_Name);
              $('#precSex').html(data.Sex);
              $('#precMD').html(data.Medical_condition);
              $('#precEmail').html(data.patientEmail);
              $('#precAddress').html(data.Address);
              $('#precAge').html(age)
              $('#precWeight').html(data.Weight);
              $('#precContactNum').html(data.Contact_Number)
              $('#precDOB').html(data.DateofBirth);

              $('#precConsultationDate').html(data.consultationDate);
              $('#precConsultant').html(response.consultant);
              $('#precHearRate').html(data.HeartRate);
              $('#precTemp').html(data.Temperature);
              $('#precBP').html(data.Blood_Pressure);
              $('#precSaturation').html(data.Saturation);
              $('#precChiefComp').html(data.Chief_complaint);
              $('#precPhyExam').html(data.Physical_Examination);
              $('#precAssesment').html(data.Assessment);
              $('#precTreatmentPlan').html(data.Treatment_Plan);

            } else {
              console.error('Error: ' + response.error);
            }
          }

        });
      })
      document.addEventListener('DOMContentLoaded', function() {
        $.ajax({
          url: 'ajax.php?action=getResImg&record_id=' + encodeURIComponent('<?=$_GET["record_id"]?>'),
          type: 'GET',
          success: function(response) {
            if (response.response === 1) {
              let imgResult = "";
              let imgResultList = response.data;

              if (Array.isArray(imgResultList) && imgResultList.length > 0) {
                for (let i = 0; i < imgResultList.length; i++) {
                  let imageFileName = imgResultList[i].image_file_name;
                  imgResult += `
                            <div class="flex flex-col items-center">
                                <img class="h-auto max-w-full object-cover" src="../PatientChartRecordResults/${imageFileName}" alt="Image Result">
                            </div>
                        `;
                  console.log(imageFileName); // Logging for debugging
                }
              } else {
                console.log("No images found in response.");
              }

              // Update HTML elements
              $('#PImageResults').html(imgResult);
              $('#VImageResults').html(imgResult);
            } else {
              $('#presborder, #presttext, #vresttext').addClass('hidden');

            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX request failed:", status, error);
          }
        });
      });

    </script>
    
</body>
</html>