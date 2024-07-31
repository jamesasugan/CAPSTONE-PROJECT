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
    <link rel="stylesheet" href="../css/services-swiper.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/main.js" defer></script>
</head>
<body>
    <div class="mainContainer">
        <?php include 'admin-navbar.php'; ?>

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
                            <span class="block">Franklin C. Saint</span>
                        </div>
                        <div>
                            <strong class="block">Age</strong>
                            <span class="block">22</span>
                        </div>
                        <div>
                            <strong class="block">Sex</strong>
                            <span class="block">Male</span>
                        </div>
                        <div>
                            <strong class="block">Contact Number</strong>
                            <span class="block">09231512512</span>
                        </div>
                        <div>
                            <strong class="block">Email</strong>
                            <span class="block">franklinsaint@gmail.com</span>
                        </div>
                        <div>
                            <strong class="block">Weight</strong>
                            <span class="block">60</span>
                        </div>
                        <div>
                            <strong class="block">Date of Birth</strong>
                            <span class="block">February 21, 2002</span>
                        </div>
                        <div>
                            <strong class="block">Medical Condition</strong>
                            <span class="block">N/A</span>
                        </div>
                        <div>
                            <strong class="block">Address</strong>
                            <span class="block">Platero Binan Laguna</span>
                        </div>
                    </div>
                </div>

            
                <!-- eto kapag wala pang record -->
                <p class="text-2xl font-semibold text-center">No Records Yet</p>
                
                <div class="flex justify-center mb-5 mt-5">
                    <button id="print" class="btn bg-[#0b6c95] hover:bg-[#11485f] text-white font-bold border-none printformButton flex flex-col items-center px-5 py-1">
                        <i class="fa-solid fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>

                    <div class="mx-auto w-11/12 px-4 py-8 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mb-10">   

                            <div class="recordList">
                                <table cellpadding="0" cellspacing="0">
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold py-2 text-lg">Service</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="font-medium py-2">
                                            <li>Flu Vaccine</li>
                                            <li>Pneumococcal Vaccine Measles, Mumps, and Rubella Vaccine</li>
                                            <li>Monthly Immunization for babies</li>
                                            <li>Polio Vaccine</li>
                                        </td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Consultation Date</td>
                                        <td class="font-medium">July 21, 2024</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Consultant</td>
                                        <td class="font-medium">Dr. John Edward Dionisio</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Heart Rate</td>
                                        <td class="font-medium">90</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Temperature</td>
                                        <td class="font-medium">36</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Blood Pressure</td>
                                        <td class="font-medium">110/70</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Saturation</td>
                                        <td class="font-medium">96%</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Chief Complaint</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <!-- Chief Complaint -->
                                        <td colspan="2" class="font-medium">Experiencing high fever, severe headache, and joint pain for the past few days.</td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Physical Examination</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <!-- Physical Examination -->
                                        <td colspan="2" class="font-medium">
                                            Patient appears febrile and fatigued. Normal heart sounds, no murmurs, regular rhythm. Clear breath sounds bilaterally, no wheezing or crackles. Soft, mild tenderness in the right upper quadrant, no organomegaly. No rash or petechiae observed. Stable except for elevated temperature.
                                        </td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Assessment</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <!-- Assessment -->
                                        <td colspan="2" class="font-medium">
                                            Febrile illness with severe headache and myalgia, suspected dengue fever.
                                        </td>
                                    </tr>
                                    <tr class="headList border-b border-gray-300 dark:border-gray-700">
                                        <td class="font-bold">Treatment Plan</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <!-- Treatment Plan -->
                                        <td colspan="2" class="font-medium">
                                            Order dengue NS1 antigen test and dengue IgM and IgG antibody tests to confirm the diagnosis. Recommend complete blood count (CBC) to check for leukopenia and thrombocytopenia, which are common in dengue fever. Advise the patient to maintain adequate hydration by drinking plenty of fluids. Prescribe acetaminophen 500 mg, one tablet every 6 hours as needed for fever and pain. Instruct the patient to avoid NSAIDs such as ibuprofen and aspirin due to the risk of bleeding.
                                        </td>
                                    </tr>
                                </table>

                                <!-- hide mo tong "Results" tsaka border pag walang image -->
                                <div class="border border-gray-400 mt-10 mb-10"></div>
                                <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Results</h2>   
                                <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id="ImageResults">
                                    <div class="flex flex-col items-center">                
                                        <!-- image dito, example lang tong img tag, alisin mo na lang -->
                                        <img class="h-auto max-w-full object-cover" src="../images/xray.jpg" alt="Image Result">
                                    </div>          
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
                  <table cellpadding="0" cellspacing="0">
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
                            <p><strong>Name:</strong> Franklin C. Saint</p>
                            <p><strong>Sex:</strong> Male</p>
                            <p><strong>Medical Conditions:</strong> N/A</p>
                            <p><strong>Email:</strong> franklinsaint@gmail.com</p>
                            <p><strong>Address:</strong> California, USA</p>
                          </td>
                          <td class="w-1/2 p-2 align-top">
                            <p><strong>Age:</strong> 22</p>
                            <p><strong>Weight:</strong> 60kg</p>
                            <p><strong>Contact Number:</strong> 09763218546</p>           
                            <p><strong>Date of Birth:</strong> February 21, 2002</p>
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
                      <td colspan="2" class="font-medium py-2">
                        <li>Flu Vaccine</li>
                        <li>Pneumococcal Vaccine Measles, Mumps, and Rubella Vaccine</li>
                        <li>Monthly Immunization for babies</li>
                        <li>Polio Vaccine</li>
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Consultation Date</td>
                      <td class="font-medium py-2">July 21, 2024</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Consultant</td>
                      <td class="font-medium py-2">Dr. John Edward Dionisio</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Heart Rate</td>
                      <td class="font-medium py-2">90</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Temperature</td>
                      <td class="font-medium py-2">36</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Blood Pressure</td>
                      <td class="font-medium py-2">110/70</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Saturation</td>
                      <td class="font-medium py-2">96%</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Chief Complaint</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">Experiencing high fever, severe headache, and joint pain for the past few days.</td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Physical Examination</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">
                      Patient appears febrile and fatigued.
                      Normal heart sounds, no murmurs, regular rhythm.
                      Clear breath sounds bilaterally, no wheezing or crackles.
                      Soft, mild tenderness in the right upper quadrant, no organomegaly.
                      No rash or petechiae observed.
                      Stable except for elevated temperature.
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Assessment</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">
                      Febrile illness with severe headache and myalgia, suspected dengue fever.
                      </td>
                    </tr>
                    <tr class="heading ">
                      <td class="font-bold py-2">Treatment Plan</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="font-medium py-2">
                      Order dengue NS1 antigen test and dengue IgM and IgG antibody tests to confirm the diagnosis.
                      Recommend complete blood count (CBC) to check for leukopenia and thrombocytopenia, which are common in dengue fever.
                      Advise the patient to maintain adequate hydration by drinking plenty of fluids.
                      Prescribe acetaminophen 500 mg, one tablet every 6 hours as needed for fever and pain.
                      Instruct the patient to avoid NSAIDs such as ibuprofen and aspirin due to the risk of bleeding.
                      </td>
                    </tr>
                  </table>

                  <!-- image results dito, hide mo "Results" na text pag walang image -->
                  <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-center mt-10">Results</h2>

                  <!-- isang buong div na to per image -->
                  <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id="ImageResults">
                    <div class="flex flex-col items-center">
                        <!-- image dito, example lang tong img tag, alisin mo na lang -->
                        <img class="h-auto max-w-full object-cover" src="../images/xray.jpg" alt="Image Result">
                    </div>          
                  </div>

                  <!-- image results end -->

                </div>
            </a>
    </div>
    <!-- print content end -->

    <script src="../js/index.js"></script>
    <script src="../js/html2canvaspro.js"></script>
    
</body>
</html>