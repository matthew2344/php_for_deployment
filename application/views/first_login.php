
<div class="email-section py-5">

<div class="row">
    
    <div class="container">
    
        <div class="d-flex justify-content-center">
    
            <div class="card p-5 col-5">
                <?php if(isset($_SESSION['incorrect'])):?>
                <div class="alert alert-danger">
                    <?= $_SESSION['incorrect']; ?>
                </div>
                <?php endif; ?>
                <div class="card-title">
                    <h4 class="mb-3">New Login</h1>
                    <p class="text-danger">*Change password</p>
                    <hr>
                </div>
                <div class="card-body">
                    <?= form_open('Login/validate_new/');?>
                    <p>Please enter your new password <span class="text-danger">*</span></p>
                    <label for="Old password">Old password</label>
                    <input type="password" name="oldpassword" id="" class="form-control mb-3">
                    <label for="New password">New password</label>
                    <input type="password" name="password" id="" class="form-control mb-3">
                    <label for="Confirm password">Confirm password</label>
                    <input type="password" name="cpassword" id="" class="form-control mb-3">
                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                    <?= form_close();?>
                </div>
            </div>
    
        </div>
    
    </div>
    
</div>

</div>