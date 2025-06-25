<?php
require('header.php');
require('scripts.php');
?>

<div class="container mt-4">
    <h3 class="mb-4">SETTINGS</h3>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">General Settings</h5>

            <p><strong>Site Title:</strong> <span id="site_title"></span></p>
            <p><strong>Address:</strong> <span id="site_about"></span></p>

            <button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#editModal">
                <i class="bi bi-pencil-square"></i> Edit
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Shutdown Website</h5>
            <p>No customers will be allowed to book hotel rooms when shutdown mode is turned on.</p>

            <label class="d-flex align-items-center">
                <span class="me-2">Turn Off/On:</span>
                <input type="checkbox" id="shutdown_toggle" class="form-check-input" style="width: 20px; height: 20px; cursor: pointer;" onchange="upd_shutdown(this.checked ? 1 : 0)">
            </label>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editModal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit General Settings</h5>
                        <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <div class="mb-3">
                                <label for="siteTitleInput" class="form-label">Site Title</label>
                                <input type="text" name="site_title" class="form-control" id="title_input" required>
                            </div>
                            <div class="mb-3">
                                <label for="aboutUsInput" class="form-label">Address</label>
                                <textarea class="form-control" name="site_about" id="aboutus_input" rows="4" required> </textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="title_input.value=genral_data.site_title, aboutus_input.value=genral_data.site_about" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>

    <div class="card shadow-sm p-3">
        <h5 class="card-title">Contact Settings</h5>
        <div class="card-body">
            <p><strong>Address:</strong> <span id="contact_address"></span></p>
            <p><strong>Google Map:</strong> <span id="contact_map"></span></p>
            <p><strong>Phone Numbers:</strong> <span id="contact_phone"></span></p>
            <p><strong>Email:</strong> <span id="contact_email"></span></p>

            <p><strong>Social Links:</strong>
                <i class="bi bi-facebook"></i> <span id="contact_facebook"></span> <br>
                <i class="bi bi-instagram"></i> <span id="contact_instagram"></span> <br>
                <i class="bi bi-twitter"></i> <span id="contact_twitter"></span>
            </p>

            <h6 class="mt-3">Google Maps iFrame:</h6>
            <div class="embed-responsive embed-responsive-16by9 border rounded">
                <iframe id="contact_iframe" class="embed-responsive-item w-100" height="200" src="https://maps.google.com/..." frameborder="0" allowfullscreen>
                </iframe>
            </div>

            <div class="text-end mt-3">
                <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#editContactModal">Edit</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editContactForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editContactModalLabel">Edit Contact Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="contact_address" id="contact_address_input" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Google Map</label>
                            <input type="text" class="form-control" name="contact_map" id="contact_map_input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Numbers</label>
                            <input type="text" class="form-control" name="contact_phone" id="contact_phone_input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_email" id="contact_email_input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Facebook</label>
                            <input type="text" class="form-control" name="contact_facebook" id="contact_facebook_input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Instagram</label>
                            <input type="text" class="form-control" name="contact_instagram" id="contact_instagram_input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Twitter</label>
                            <input type="text" class="form-control" name="contact_twitter" id="contact_twitter_input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">iFrame</label>
                            <textarea class="form-control" name="contact_iframe" id="contact_iframe_input" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="fillContactInputs(contacts_data)" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-3" id="team_card">
        <div class="card-header">
            <h5 class="card-title">Management Team</h5>
            <button class="btn btn-dark btn-sm float-end" data-bs-toggle="modal" data-bs-target="#teammodal">
                <i class="bi bi-plus-square"></i>Add
            </button>
        </div>
        <div class="card-body">  
             <div class="row" id="team_list">
    <!-- Sample Team Member Card -->
    <!-- <div class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm">
            <img src="../images/about/IMG_43031.jpg" class="card-img-top" alt="Team Member Photo">
            <div class="card-body text-center">
                <h6 class="card-title mb-1">John Doe</h6>
                <p class="text-muted mb-0">Manager</p>
            </div>
        </div>
    </div> -->
</div>
            
        </div>
    </div>

    <div class="modal fade" id="teammodal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="teamModal_form" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teamModalLabel">Add Team Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="team_name" id="team_name_input">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="team_position" id="team_position_input">
                        </div>
                       
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="file" class="form-control" accept=".jpg, .png, .webp" name="poopop" id="team_image_input">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_member" value="Upload" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>







<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let genral_data, contacts_data; 
    let editmodal_form= document.getElementById('editModal_form');
    let contact_modal_form=document.getElementById('editContactForm');
    let title_input = document.getElementById('title_input');
    let about_input = document.getElementById('aboutus_input');
    let team_form= document.getElementById('teamModal_form');
    let member_name_input = document.getElementById('team_name_input');
    let member_position_input = document.getElementById('team_position_input');
    let member_image_input= document.getElementById('team_image_input');
    
    function get_genral() {
    let site_title = document.getElementById('site_title');  
    let site_about = document.getElementById('site_about');   


   
    let shutdown_toggle = document.getElementById('shutdown_toggle');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);          
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {  
        try {
            let genral_data = JSON.parse(this.responseText);
            

            if (genral_data) {
                site_title.innerText = genral_data.site_title;
                site_about.innerText = genral_data.site_about;

                title_input.value = genral_data.site_title;
                about_input.value = genral_data.site_about;

                // Properly set the checkbox state
                shutdown_toggle.checked = genral_data.shutdown == 1;
            }

        } catch (error) {
            console.log("Error parsing response:", error);
        }
    };

    xhr.send('get_genral=1');
} 

editmodal_form.addEventListener('submit', function(e){
    e.preventDefault();
    upd_genral(document.getElementById('title_input').value, document.getElementById('aboutus_input').value)

})




   

    function upd_genral(site_title_value, site_about_value) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        var myModal = document.getElementById('editModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert("success: Changes saved!");
            get_genral();
        } else {
            alert("Error: No changes made.");
        }
    };

    xhr.send(
        'site_title=' + encodeURIComponent(site_title_value) + 
        '&site_about=' + encodeURIComponent(site_about_value) + 
        '&upd_genral=1'
    );
}






function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert("success: Site shutdown status updated!");
            get_genral();
        } else {
            alert("Error: Failed to update shutdown status.");
        }
    };

    xhr.send('upd_shutdown=' + val);
}


function get_contacts() {
   
let contacts_p_id= ['contact_address', 'contact_map','contact_phone','contact_email','contact_facebook','contact_instagram','contact_twitter'];
let iframe = document.getElementById('contact_iframe');


   
   

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {  
       
             contacts_data = JSON.parse(this.responseText);
            contacts_data=   Object.values(contacts_data);
            console.log(contacts_data);

            for(i=0; i<contacts_p_id.length; i++){
                document.getElementById(contacts_p_id[i]).innerText = contacts_data[i+1];


            }
            iframe.src= contacts_data[8];           
            fillContactInputs(contacts_data);             



            

           
       
    };

    xhr.send('get_contacts=1');
} 

function fillContactInputs(data){
     let contact_address_input= ['contact_address_input','contact_map_input','contact_phone_input','contact_email_input','contact_facebook_input','contact_instagram_input','contact_twitter_input','contact_iframe_input'];
     for(i=0; i<contact_address_input.length;i++){
    document.getElementById(contact_address_input[i]).value=data[i+1];
}
}

contact_modal_form.addEventListener('submit', function(e){
    e.preventDefault();
    upd_contact_modal(document.getElementById('contact_address_input').value, document.getElementById('contact_map_input').value , document.getElementById('contact_phone_input').value, document.getElementById('contact_email_input').value, document.getElementById('contact_facebook_input').value , document.getElementById('contact_instagram_input').value , document.getElementById('contact_twitter_input').value, document.getElementById('contact_iframe_input').value);

})

function upd_contact_modal(contact_address_input, contact_map_input, contact_phone_input, contact_email_input, contact_facebook_input, contact_instagram_input, contact_twitter_input, contact_iframe_input) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        console.log(this.responseText); // Debugging

        var myModal = document.getElementById('editContactModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText.trim() === "1") {
            alert("Success: Changes saved!");
            get_contacts();
        } else {
            console.log(this.responseText)
            alert("Error: " + this.responseText);
        }
    };

    xhr.send(
        'site_address=' + encodeURIComponent(contact_address_input) + 
        '&site_map=' + encodeURIComponent(contact_map_input) + 
        '&site_phn=' + encodeURIComponent(contact_phone_input) + 
        '&site_email=' + encodeURIComponent(contact_email_input) + 
        '&site_facebook=' + encodeURIComponent(contact_facebook_input) + 
        '&site_instagram=' + encodeURIComponent(contact_instagram_input) + 
        '&site_twitter=' + encodeURIComponent(contact_twitter_input) + 
        '&site_iframe=' + encodeURIComponent(contact_iframe_input) + 
        '&upd_contact_modal=1'
    );
}


team_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_member(document.getElementById('team_name_input').value, document.getElementById('team_position_input').value, document.getElementById('team_image_input').value);

})                        

function add_member() { 
    let data = new FormData();
    
    // Get the correct input fields
    

    // Ensure input fields exist before proceeding
    if (!member_name_input || !member_position_input || !member_image_input){                                 
        alert("Error: One or more input fields are missing!");
        return;
    }

    // Append form data
    data.append('name', member_name_input.value);
    data.append('position', member_position_input.value);
    data.append('team_image', member_image_input.files[0]);
    data.append('add_member', 1);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);          

    xhr.onload = function() {
       
        
        if (this.responseText.trim() === "1") {
            alert("Success: Team details uploaded successfully!");
            get_member();
        } else {
            alert("Error: Failed to upload team details. Response: " + this.responseText);
        }
    };

    xhr.send(data);
}

function get_member(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);          
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {  
       
        document.getElementById('team_list').innerHTML=this.responseText
       
    };

    xhr.send('get_member=1');    

}
function delete_image(val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../ajax/setting_crud.php", true);          
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {  
     if(this.responseText==1){
        alert("team member is removed");
        get_member();
     }  
     else{
        alert("failed! server down");
     }
        
       
    };

    xhr.send('delete_image='+val);    

}









window.onload=function(){ 
        get_genral();
        get_contacts();
        get_member();
    };

</script>
 