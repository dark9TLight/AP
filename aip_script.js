function toggleDarkMode() {
    var body = document.getElementsByTagName('body')[0];
    body.classList.toggle('dark-mode');
}
function toggleDarkMode() {
    var body = document.getElementsByTagName('body')[0];
    body.classList.toggle('dark-mode');
    var button = document.getElementById('darkModeButton');
    if (body.classList.contains('dark-mode')) {
        button.textContent = 'Light Mode';
    } else {
        button.textContent = 'Dark Mode';
    }
}
function validateForm() {  
    // Get the selected file
    var fileInput = document.getElementById('upstock');
    var file = fileInput.files[0];
    
    // Check if a file is selected
    if (!file) {
        alert('Please select a file to import.');
        return false; // Prevent form submission
    }
    
    // Check if the file is in CSV format
    var fileName = file.name;
    var fileExtension = fileName.split('.').pop().toLowerCase();
    if (fileExtension !== 'csv') {
        alert('Please select a CSV file to import.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}                         

function validateFormds() { 
    // Get the selected file
    var fileInput2 = document.getElementById('upstockautojit');
    var file2 = fileInput2.files[0];
    
    // Check if a file is selected
    if (!file2) {
        alert('Please select a file to import.');
        return false; // Prevent form submission
    }
    
    // Check if the file is in CSV format
    var fileName2 = file2.name;
    var fileExtension2 = fileName2.split('.').pop().toLowerCase();
    if (fileExtension2 !== 'csv') {
        alert('Please select a CSV file to import.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}         

function checkPlanlot() {
    var planlotValue = document.getElementById("myInput").value;
    if (planlotValue.trim() === "") {
        alert("Planlot can't null");
        event.preventDefault(); // Prevent form submission if planlot is null
    } else if (/\s/.test(planlotValue)) {
        alert("Planlot can't contain whitespace");
        event.preventDefault(); // Prevent form submission if planlot contains whitespace
    } 
   // else if (!/^\d{8}$/.test(planlotValue)) {
     // alert("Planlot == 8 digit and no character.");
     // event.preventDefault(); // Prevent form submission if planlot contains characters
 // }
}   

function checkPlanlotUser() { 
    var planlotValue = document.getElementById("myInputUser").value;
    if (planlotValue.trim() === "") {
        alert("Planlot can't null");
        event.preventDefault(); // Prevent form submission if planlot is null
    } else if (/\s/.test(planlotValue)) {
        alert("Planlot can't contain whitespace");
        event.preventDefault(); // Prevent form submission if planlot contains whitespace
    } 
   // else if (!/^\d{8}$/.test(planlotValue)) {
     // alert("Planlot == 8 digit and no character.");
     // event.preventDefault(); // Prevent form submission if planlot contains characters
 // }
}

document.addEventListener("DOMContentLoaded", function() {
    var dragDropArea = document.getElementById("dragDropArea");
    var fileInput = document.getElementById("upstock");
    dragDropArea.addEventListener("dragover", function(e) {
        e.preventDefault();
        dragDropArea.style.backgroundColor = "#f2f2f2";
    });
    dragDropArea.addEventListener("dragleave", function(e) {
        e.preventDefault();
        dragDropArea.style.backgroundColor = "transparent";
    });
    dragDropArea.addEventListener("drop", function(e) {
        e.preventDefault();
        dragDropArea.style.backgroundColor = "transparent";
        fileInput.files = e.dataTransfer.files;
    });
    dragDropArea.addEventListener("click", function() {
        fileInput.click();
    });
    fileInput.addEventListener("change", function() {
        dragDropArea.style.backgroundColor = "transparent";
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var dragDropArea2 = document.getElementById("dragDropArea2");
    var fileInput = document.getElementById("upstockautojit");
    dragDropArea2.addEventListener("dragover", function(e) {
        e.preventDefault();
        dragDropArea2.style.backgroundColor = "#f2f2f2";
    });
    dragDropArea2.addEventListener("dragleave", function(e) {
        e.preventDefault();
        dragDropArea2.style.backgroundColor = "transparent";
    });
    dragDropArea2.addEventListener("drop", function(e) {
        e.preventDefault();
        dragDropArea2.style.backgroundColor = "transparent";
        fileInput.files = e.dataTransfer.files;
    });
    dragDropArea2.addEventListener("click", function() {
        fileInput.click();
    });
    fileInput.addEventListener("change", function() {
        dragDropArea2.style.backgroundColor = "transparent";
    });
});

function searchPlanlotMaster() {
    var input, filter, table1, table2, tr1, tr2, td1, td2, i, txtValue1, txtValue2;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table1 = document.getElementById("imdata"); // ID of the first table
    table2 = document.getElementById("amdata"); // ID of the second table
    tr1 = table1.getElementsByTagName("tr");
    tr2 = table2.getElementsByTagName("tr");
        for (i = 0; i < tr1.length; i++) {
            td1 = tr1[i].getElementsByTagName("td")[2];
            if (td1) {
            txtValue1 = td1.textContent || td1.innerText;
                if (txtValue1.toUpperCase().indexOf(filter) > -1) {
                    tr1[i].style.display = "";
                } else {
                    tr1[i].style.display = "none";
                }
            }
        }
        for (i = 0; i < tr2.length; i++) {
            td2 = tr2[i].getElementsByTagName("td")[15];
            if (td2) {
            txtValue2 = td2.textContent || td2.innerText;
                if (txtValue2.toUpperCase().indexOf(filter) > -1) {
                    tr2[i].style.display = "";
                } else {
                    tr2[i].style.display = "none";
                }
            }
        }
    }
        document.addEventListener("keydown", function(event) {
        if (event.key === "/") {
            event.preventDefault();
            document.getElementById("myInput").focus();
        }
        });

function searchPlanlotMaster() {
    var input, filter, table1, table2, tr1, tr2, td1, td2, i, txtValue1, txtValue2;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table1 = document.getElementById("imdata"); // ID of the first table
    table2 = document.getElementById("amdata"); // ID of the second table
    tr1 = table1.getElementsByTagName("tr");
    tr2 = table2.getElementsByTagName("tr");
        for (i = 0; i < tr1.length; i++) {
            td1 = tr1[i].getElementsByTagName("td")[2];
            if (td1) {
            txtValue1 = td1.textContent || td1.innerText;
                if (txtValue1.toUpperCase().indexOf(filter) > -1) {
                    tr1[i].style.display = "";
                } else {
                    tr1[i].style.display = "none";
                }
            }
        }
        for (i = 0; i < tr2.length; i++) {
            td2 = tr2[i].getElementsByTagName("td")[15];
            if (td2) {
            txtValue2 = td2.textContent || td2.innerText;
                if (txtValue2.toUpperCase().indexOf(filter) > -1) {
                    tr2[i].style.display = "";
                } else {
                    tr2[i].style.display = "none";
                }
            }
        }
    }
        document.addEventListener("keydown", function(event) {
        if (event.key === "/") {
            event.preventDefault();
            document.getElementById("myInput").focus();
        }
        });

function searchPlanlotMasterUser() {
    var input, filter, table1, table2, tr1, tr2, td1, td2, i, txtValue1, txtValue2;
    input = document.getElementById("myInputUser");
    filter = input.value.toUpperCase();
    table1 = document.getElementById("imdata"); // ID of the first table
    table2 = document.getElementById("amdata"); // ID of the second table
    tr1 = table1.getElementsByTagName("tr");
    tr2 = table2.getElementsByTagName("tr");
        for (i = 0; i < tr1.length; i++) {
            td1 = tr1[i].getElementsByTagName("td")[2];
            if (td1) {
            txtValue1 = td1.textContent || td1.innerText;
                if (txtValue1.toUpperCase().indexOf(filter) > -1) {
                    tr1[i].style.display = "";
                } else {
                    tr1[i].style.display = "none";
                }
            }
        }
        for (i = 0; i < tr2.length; i++) {
            td2 = tr2[i].getElementsByTagName("td")[15];
            if (td2) {
            txtValue2 = td2.textContent || td2.innerText;
                if (txtValue2.toUpperCase().indexOf(filter) > -1) {
                    tr2[i].style.display = "";
                } else {
                    tr2[i].style.display = "none";
                }
            }
        }
    }
        document.addEventListener("keydown", function(event) {
        if (event.key === "/") {
            event.preventDefault();
            document.getElementById("myInputUser").focus();
        }
        });

    function copyLink() {
      var linkElement = document.getElementById("sharedfolderaddress").getElementsByTagName("a")[0];
      var link = linkElement.href;
      
      // Create a temporary input element
      var tempInput = document.createElement("input");
      tempInput.setAttribute("value", link);
      
      // Append the input element to the body
      document.body.appendChild(tempInput);
      
      // Select and copy the link from the input element
      tempInput.select();
      document.execCommand("copy");
      
      // Remove the temporary input element
      document.body.removeChild(tempInput);
      
      //alert("Link copied to clipboard!");
    }



    