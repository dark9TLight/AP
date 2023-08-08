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

    function checkPlanlot() {
        var planlotValue = document.getElementById("myInput").value;
        if (planlotValue.trim() === "") {
            alert("Planlot can't null");
            event.preventDefault(); // Prevent form submission if planlot is null
        } else if (/\s/.test(planlotValue)) {
            alert("Planlot can't contain whitespace");
            event.preventDefault(); // Prevent form submission if planlot contains whitespace
        } 
       /* else if (!/^\d{8}$/.test(planlotValue)) {
            alert("Planlot == 8 digit and no character.");
            event.preventDefault(); // Prevent form submission if planlot contains characters
        } */
    }

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

    function searchPlanlotMaster() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("amdata");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[15];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
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
