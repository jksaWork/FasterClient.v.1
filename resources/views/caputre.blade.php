<html>
  <head>
    <title>reCAPTCHA demo: Simple page</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <form action="?" method="POST">
      <div
        class="g-recaptcha"
        data-sitekey="6Lc2CxUmAAAAADiGj3iQn4g4kqR0AgAWyJcwKdWn"
      ></div>
      <br />
      <input type="submit" value="Submit" />
    </form>
  </body>
</html>

<!-- Captue site Key    6Lc2CxUmAAAAADiGj3iQn4g4kqR0AgAWyJcwKdWn  -->
<!-- scrit Key 6Lc2CxUmAAAAADrECg6KXBKJ8us3e_lkDZMLnTcF  -->
<script type="text/javascript">
  var onloadCallback = function () {
    alert("grecaptcha is ready!");
  };
</script>

<script
  src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
  async
  defer
></script>
