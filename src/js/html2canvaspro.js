// html2canvaspro.js
let saveBtn = document.querySelector("#save");
saveBtn.addEventListener("click", function () {
    // Toggle visibility for capturing image
    let recordContent = document.querySelector(".recordContent");
    recordContent.style.display = "block"; // Temporarily show for capture
    recordContent.style.color = "black"; // Temporarily show for capture

    html2canvas(document.querySelector("#save_to_image")).then(function (canvas) {
        var link = document.createElement('a');
        link.setAttribute("download", "PatientRecord.png");
        link.setAttribute("href", canvas.toDataURL("image/png"));
        
        // Append link to DOM and trigger download
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        recordContent.style.display = "none"; 
    });
});
