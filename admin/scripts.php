
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script>


  
  
   functionn alert(type, msg){
    let bs_class= $bs_class = (type == "success") ? "alert-success" : "alert-danger"; // Corrected spelling
    let element= document.createElement('div');
    element.innerHTML=`
    <div class='alert ${bs_class}_class alert-dismissible fade show position-absolute top-0 end-0 m-3' role='alert'>
                ${msg}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
    `;
    document.body.append(element);
   }

   function setActive() {
  let navbar = document.getElementById('sidebar');  // Get the sidebar by ID
  let a_tag = navbar.getElementsByTagName('a');   // Get all <a> tags inside the sidebar

  for (let i = 0; i < a_tag.length; i++) {   // Declare 'i' properly
    let file = a_tag[i].href.split('/').pop();  // Get the file name from href
    let file_name = file.split('.')[0];  // Extract the name without the extension

    if (window.location.href.indexOf(file_name) >= 0) {  // Compare with the current URL
      a_tag[i].classList.add('active');  // Add 'active' class if it matches
    }
  }
}

  setActive(); 
  window.onload = function() {
  setActive();
};


<script>


    function alert(type, msg){
        let bs_class = (type == "success") ? "alert-success" : "alert-danger"; // Corrected spelling
        let element = document.createElement('div');
        element.innerHTML=`
        <div class='alert ${bs_class} alert-dismissible fade show position-absolute top-0 end-0 m-3' role='alert'>
            ${msg}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        `;
        document.body.append(element);
    }

    function setActive() {
    let navbar = document.getElementById('sidebar');  // Get the sidebar by ID
    let a_tag = navbar.getElementsByTagName('a');   // Get all <a> tags inside the sidebar

    for (let i = 0; i < a_tag.length; i++) {    // Declare 'i' properly
        let file = a_tag[i].href.split('/').pop();  // Get the file name from href
        let file_name = file.split('.')[0];    // Extract the name without the extension

        if (window.location.href.indexOf(file_name) >= 0) {    // Compare with the current URL
        a_tag[i].classList.add('active');    // Add 'active' class if it matches
        }
    }
}

    setActive();
    window.onload = function() {
    setActive();
};

</script>