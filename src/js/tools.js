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