<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Record</title>
    <link rel="stylesheet" href="../css/output.css" />
    <link rel="stylesheet" href="../css/staff.css" />
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
    <?php include 'admin-navbar.php'; ?>

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
                        <strong class="block">Username</strong>
                        <span class="block">franky123</span>
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

                <div class="mx-auto w-11/12 px-4 py-8 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mb-10">   
                    <div class="text-center mb-5">
                        <h1 class="font-bold text-2xl">Service:</h1>
                        <p class="font-semibold text-xl">Flu Vaccine, Pneumococcal Vaccine Measles, Mumps, and Rubella Vaccine, Monthly Immunization for babies, Polio Vaccine</p>
                    </div>

                    <a id="save_to_image">
                        <div class="invoice-container">
                            <table cellpadding="0" cellspacing="0">
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Consultation Date</td>
                                    <td class="font-medium">July 21, 2024</td>
                                </tr>
                                <!-- <tr 
                                wala na consultant kapag sa account ng doctor
                                
                                class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Consultant</td>
                                    <td class="font-medium">Dr. John Edward Dionisio</td>
                                </tr> -->
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Heart Rate</td>
                                    <td class="font-medium">90</td>
                                </tr>
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Temperature</td>
                                    <td class="font-medium">36</td>
                                </tr>
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Blood Pressure</td>
                                    <td class="font-medium">110/70</td>
                                </tr>
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Saturation</td>
                                    <td class="font-medium">96%</td>
                                </tr>
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Chief Complaint</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <!-- Chief Complaint -->
                                    <td colspan="2" class="font-medium">Experiencing high fever, severe headache, and joint pain for the past few days.</td>
                                </tr>
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Physical Examination</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <!-- Physical Examination -->
                                    <td colspan="2" class="font-medium">
                                        Patient appears febrile and fatigued. Normal heart sounds, no murmurs, regular rhythm. Clear breath sounds bilaterally, no wheezing or crackles. Soft, mild tenderness in the right upper quadrant, no organomegaly. No rash or petechiae observed. Stable except for elevated temperature.
                                    </td>
                                </tr>
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
                                    <td class="font-bold">Assessment</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <!-- Assessment -->
                                    <td colspan="2" class="font-medium">
                                        Febrile illness with severe headache and myalgia, suspected dengue fever.
                                    </td>
                                </tr>
                                <tr class="heading border-b border-gray-300 dark:border-gray-700">
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
                            
                            <div class="flex flex-wrap gap-2 justify-center items-center w-full mb-3" id='ImageResults'>
                            </div>
                        </div>
                    </a>
                </div>
            
        </div>
    </section>
    
</body>
</html>