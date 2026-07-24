
  </div>

<footer class="container-fluid"  id="footer" >
  <div class="container">
    <div class="row">
      <div class="col-md-3 contact">
        <h3>CONTACT</h3>
        <div>
          <p>
            <img src="<?= base_url('assets/images/bld.png'); ?>">
            <span>
              UOB Plaza, 31st Floor<br/>
              Suite 3102<br/>
              Jl. MH. Thamrin No. 10<br/>
              Jakarta 10230
            </span>
          </p>
          <p>
            <img src="<?= base_url('assets/images/phn.png'); ?>">
            <span>
              +62 (0)21 296 1811
            </span>
          </p>
          <p>
            <img src="<?= base_url('assets/images/eml.png'); ?>">
            <span>
              Jakarta@agencyfish.com
            </span>
          </p>
        </div>
      </div>
      <div class="col-md-2">
        <h3>COMPANY</h3>
        <span class="glyphicon glyphicon-menu-down"></span>
        <div class="collapse">
          <p>
            Press Releases
          </p>
          <p>
            Mission
          </p>
          <p>
            Strategy
          </p>
          <p>
            Works
          </p>
        </div>
      </div>
      <div class="col-md-2">
        <h3>LEARN MORE</h3>
        <span class="glyphicon glyphicon-menu-down"></span>
        <div class="collapse">
          <p>
            Support
          </p>
          <p>
            Developers
          </p>
          <p>
            Customer Service
          </p>
          <p>
            Get Started Guide
          </p>
        </div>
      </div>
      <div class="col-md-5">
        <h3>FOLLOW US</h3>
        <div class="">
          <p class="follow-icon">
            <img src="<?= base_url('assets/images/icon_fb.png'); ?>"/>
            <img src="<?= base_url('assets/images/icon_tw.png'); ?>"/>
            <img src="<?= base_url('assets/images/icon_in.png'); ?>"/>
            <img src="<?= base_url('assets/images/icon_pt.png'); ?>"/>
          </p>
          <p class="app-icon">
            <img src="<?= base_url('assets/images/icon_appstore.png'); ?>"/>        
            <img src="<?= base_url('assets/images/icon_playstore.png'); ?>"/>
          </p>
        </div>
      </div>
    </div>
  </div>
  <div style="border-top: solid 1px #272e3e;margin-top:50px;padding: 15px 0">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <img src="<?= base_url('assets/images/logo_white.png'); ?>" alt="" style="margin: 15px 0;">
        </div>
        <div class="col-md-3">
          <h3>PRIVATE POLICY</h3>
        </div>
        <div class="col-md-3">
          <h3>TERMS & CONDITIONS</h3>
        </div>
        <div class="col-md-3">
          <h3>COPYRIGHT NOTIFICATIONS</h3>
        </div>
      </div>
    </div>
  </div>
  <p style="color: #6e788f !important;font-family: openSans;text-align: center;font-size:12px">&copy; 2019 Page Chain. All rights reserved.</p>
</footer>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 500, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        // if (pos < winTop + 600) {
        if (pos < winTop + 1000) {
          $(this).addClass("slider");
        }
    });
  });
  
  $(".container>.col-md-3,.col-md-2,.col-md-5").click(function(){
    $(this).children(".collapse").toggle();
    $(this).find(".glyphicon").toggleClass("glyphicon-menu-down");
  })
  /*footer*/
  var mql = window.matchMedia("screen and (max-width: 768px)")
  mediaqueryresponse(mql) // call listener function explicitly at run time
  mql.addListener(mediaqueryresponse) // attach listener function to listen in on state changes
  function mediaqueryresponse(mql) {
    if (mql.matches) {
      //$(".container").attr("data-toggle", "collapse");
      $('.collapse').collapse("hide");
    } else {
      $('.collapse').collapse("show");
      //$("[data-toggle='collapse']").removeAttr("data-toggle");
    }
  }
})
</script>

</body>
</html>
