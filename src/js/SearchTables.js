function handleSearch(inputId, tableId) {
  let input, filter, programFilter, table, tbody, tr, td, i, txtValue;
  input = document.getElementById(inputId);
  filter = input.value.toUpperCase();

  table = document.getElementById(tableId);
  tbody = table.getElementsByTagName("tbody")[0];
  tr = tbody.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    let found = false;
    let programMatch = false;
    for (let j = 0; j < td.length; j++) {
      let cell = td[j];
      if (cell) {
        txtValue = cell.textContent || cell.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          found = true;
          break;
        }
      }
    }

    if (found && programMatch) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}
