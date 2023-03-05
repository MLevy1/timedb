<script>
    var a = [1, 2, 3];
    localStorage.setItem("array", a);
    var myArray = localStorage.getItem("array");
    console.log(myArray) // "1, 2, 3";
</script>
