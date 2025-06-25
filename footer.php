<!-- Footer -->
<div class="container-fluid bg-light mt-5 border-top py-4">
  <div class="row">
    <!-- About Section -->
    <div class="col-lg-4 p-4">
      <h3 class="h-font fw-bold fs-3 mb-3">Hotel Star</h3>
      <p>
       <?php echo $contact_res['site_about']?>
      </p>
    </div>

    <!-- Navigation Links -->
    <div class="col-lg-4 p-4">
      <h5 class="mb-3 fw-bold">Quick Links</h5>
      <a href="index.php" class="d-block mb-2 text-dark text-decoration-none">Home</a>
      <a href="rooms.php" class="d-block mb-2 text-dark text-decoration-none">Rooms</a>
      <a href="facilities.php" class="d-block mb-2 text-dark text-decoration-none">Facilities</a>
      <a href="contact.php" class="d-block mb-2 text-dark text-decoration-none">Contact Us</a>
      <a href="aboutus.php" class="d-block mb-2 text-dark text-decoration-none">About</a>
    </div>

    <!-- Social Media Links -->
    <div class="col-lg-4 p-4">
      <h5 class="mb-3 fw-bold">Follow Us</h5>

      <?php
        if (!empty($contact_r['twitter'])) {
          echo <<<DATA
          <a href="{$contact_r['twitter']}" class="d-inline-block mb-2 text-dark text-decoration-none">
              <i class="bi bi-twitter me-1"></i> Twitter
          </a><br>
          DATA;
      }

      if (!empty($contact_r['twitter'])) {
        echo <<<DATA
        <a href="{$contact_r['twitter']}" class="d-inline-block mb-2 text-dark text-decoration-none">
            <i class="bi bi-instagram me-1"></i> instagram
        </a><br>
        DATA;
    }

    if (!empty($contact_r['twitter'])) {
      echo <<<DATA
      <a href="{$contact_r['twitter']}" class="d-inline-block mb-2 text-dark text-decoration-none">
          <i class="bi bi-facebook me-1"></i> facebook
      </a><br>
      DATA;
  }
      
        ?>
    </div>
  </div>
</div>

<!-- Copyright Footer -->
<footer class="bg-dark text-white text-center py-3">
  <div class="container">
    <hr class="border-light mb-3">
    <p class="mb-0">&copy; 2025 Hotel Star. All rights reserved.</p>
    <p class="mb-0">Designed with ❤️ by  Priyanshu</p>
  </div>
</footer>

<script>
function setActive(){
  let navbar= document.getElementById('nav_bar');
  let a_tag= navbar.getElementsByTagName('a');

  for(i=0;i<a_tag.length;i++){
    let file= a_tag[i].href.split('/').pop();
    let file_name= file.split('.')[0];

    if (document.location.href.indexOf(file_name)>=0){
      a_tag[i].classList.add('active');
    }
  }
}

let register_form= document.getElementById('reg_form');
register_form.addEventListener('submit',function(e) {
  e.preventDefault();

  let data= new FormData();
  data.append( 'name' ,register_form.elements['name'].value);
  data.append( 'email' ,register_form.elements['email'].value);
  data.append( 'phonenum' ,register_form.elements['number'].value);
  data.append( 'address' ,register_form.elements['address'].value);
  data.append( 'profile' ,register_form.elements['profile'].files[0]);
  data.append( 'pass' ,register_form.elements['pass'].value);
  data.append( 'cpass' ,register_form.elements['cpass'].value);
  data.append( 'register' ,'');

  var myModal = document.getElementById('registermodal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/login_register.php", true);
    

    xhr.onload = function() {
   
      if (this.responseText == 1) {
        
            alert("success: Site  status updated!");
            get_genral();
        } else {
          console.log(this.responseText)
            alert("Error: Failed to update status.");
        }

       
    
        
    }
    xhr.send(data);
    
  

  
});

  let log_in = document.getElementById('log_in');
  log_in.addEventListener('submit', function(e){
    e.preventDefault();
      
       let data= new FormData();
       data.append('email',log_in.elements['mail'].value);
       data.append('pass', log_in.elements['password'].value);
       data.append('login', '');

       var mymodal= document.getElementById('loginmodal');
       var modal=  bootstrap.Modal.getInstance(mymodal);
       modal.hide();

       let xhr= new XMLHttpRequest();

       xhr.open("POST","ajax/login_register.php", true);

       xhr.onload= function() {
        if(this.responseText==1){
           
        
         let fileurl= window.location.href.split('/').pop().split('?').shift();
        location.reload();
        }

        else if(this.responseText=='not_verified'){you
          alert("Email is not verified");
        }                                                                   
        else if(this.responseText=='inactive'){                    
          alert("Account Suspended.Please contact Admin.");
        }
        else if(this.responseText=='Invalid password'){
          alert("Incorrect Password");
        }
       

        


        else{
          console.log(this.reponseText)
          alert("Invalid credentials!"+ this.responseText);
        }

       }

     
       xhr.send(data);    
    

    
    


  });

  let forgot = document.getElementById('forgot');
  forgot.addEventListener('submit', function(e){
    e.preventDefault();
   
       let data= new FormData();
       data.append('email',forgot.elements['mail'].value);
      
       data.append('forgot', '');

       var mymodal= document.getElementById('forgotmodal');
       var modal=  bootstrap.Modal.getInstance(mymodal);
       modal.hide();

       let xhr= new XMLHttpRequest();

       xhr.open("POST","ajax/login_register.php", true);

       xhr.onload= function() {
        if(this.responseText=='mail_sent'){

          
          alert("Mail is sent to your mail id");
        }

        else if(this.responseText=='not_verified'){
          alert("Email is not verified");
        }
        else if(this.responseText=='inactive'){
          alert("Account Suspended.Please contact Admin.");
        }
        else if(this.responseText=='inv_mail'){
          alert("Incorrect mail");
        }
        

        


        

       }

     
       xhr.send(data);    
    

    
    


  });
  setActive();  
</script>