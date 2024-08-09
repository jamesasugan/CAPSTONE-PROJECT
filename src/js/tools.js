
function successNotifcation(Container_id, NotifMessage){
  document.getElementById(Container_id).innerHTML = `
        <div  class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
          <div role="alert" class="w-full inline-flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"> 
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="w-full"><span class="font-medium">Success: </span><span id='successText'> Your appointment has been Booked!</span></span>
          </div>
        </div>`;
  document.getElementById('successText').innerHTML = NotifMessage;
  setTimeout(function() {
    resetNotif(Container_id);
  }, 5000);
}

function errorNotifcation(Container_id, NotifMessage){
  document.getElementById(Container_id).innerHTML =  `
        <div  class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
          <div role="alert" class="w-full inline-flex items-center bg-red-300 border border-red-400 text-red-800 px-4 py-3 rounded relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"> 
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
            <span class="w-full"><span class="font-medium">Error: </span> <span id='errorText'>Task failed successfully.</span></span>
          </div>
        </div>`
  document.getElementById('errorText').innerHTML = NotifMessage;
    setTimeout(function() {
    resetNotif(Container_id);
  }, 5000);
}
function warningNotifcation(Container_id,  NotifMessage){

  document.getElementById(Container_id).innerHTML  = `
        <div  class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
          <div role="alert" class="w-full inline-flex items-center bg-yellow-300 border border-yellow-400 text-black px-4 py-3 rounded relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
            <span class="w-full"><span class="font-medium">Warning: </span> <span id='waningText'> Invalid email address!</span></span>
          </div>
        </div>`;
  document.getElementById('waningText').innerHTML = NotifMessage;

  setTimeout(function() {
    resetNotif(Container_id);
  }, 5000);
}

function resetNotif(Container){
  $(`#${Container}`).empty();
}








function toggleDialog(id) {
  let dialog = document.getElementById(id);
  if (dialog) {
    if (dialog.hasAttribute('open')) {
      dialog.removeAttribute('open');
    } else {
      dialog.setAttribute('open', '');
    }
  }
}
function formatDate(dateString) {
  // Create a Date object from the input date string
  const date = new Date(dateString);

  // Format the date to "Month Day, Year"
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
}
function isNumeric(value) {
  return !isNaN(value) && (typeof value === 'number' || !isNaN(parseFloat(value)));
}
