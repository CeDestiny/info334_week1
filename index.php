
<!DOCTYPE html>
<html>
<head>
<script>
function searchNBA(str) {
  if (str.length == 0) {
    document.getElementById("txtNbaResults").innerHTML = "Please enter a search result";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtNbaResults").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET", "nbasearch.php?search="+encodeURI(str), true);
    xmlhttp.send();
  }
}
</script>
<!-- not sure how to load this within the php that is returned and have it trigger lazy loading -->
<script src="./js/lazysizes.min.js" async="">
</script>
</head>
<body>

<p><b>Start typing a name in the input field below:</b></p>
<form action="">
  <label for="fname">NBA Search:</label>
  <input type="text" id="fname" name="fname" onkeyup="searchNBA(this.value)">
</form>
<p>Results:<br/>
<span id="txtNbaResults"></span></p>

</body>
</html>