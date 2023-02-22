
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="../css/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function () {
     $('#seconds').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#minutes').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#minutes').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#minutes').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#hours').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#hours').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#hours').spinner({
         min: 0});
 });
 </script>
 
 <p>
    <input id="hours" name="value" value=0 size=3/>
    <input id="minutes" name="value" value=0  size=2/>
    <input id="seconds" name="value" value=10 size=2/>
</p>
 