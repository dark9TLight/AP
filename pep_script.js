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
