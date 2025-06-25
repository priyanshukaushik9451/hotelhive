<?php include 'header.php';?>
      <div class="container mt-5">
        <h2 class="text-center mb-4">Contact Us</h2>
        <p class="text-center mb-4">We'd love to hear from you! Reach out to us for any inquiries or reservations.</p>
    

        <div class="row">
            <!-- Contact Form -->
            <div class="col-md-6">
                <div class="bg-light p-4 rounded shadow-sm">
                    <h4 class="mb-3">Send Us a Message</h4>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
    
            <!-- Google Map -->
            <div class="col-md-6">
                <h4 class="mb-3">Our Location</h4>
                <iframe
                    src="<?php echo $contact_r['iframe']?>"
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    
        <!-- Contact Details -->
        <div class="text-center mt-5">
            <h4>Get in Touch</h4>
            <p><i class="bi bi-telephone"></i> <?php echo $contact_r['phn1']?></p>
            <p><i class="bi bi-envelope"></i> <?php echo $contact_r['email']?></p>
            <p><i class="bi bi-geo-alt"></i><?php echo $contact_r['address']?></p>
        </div>
    </div>
    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <?php include 'footer.php';?>
    