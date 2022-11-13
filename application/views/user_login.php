
<section class="login-section">
  
  <div class="px-4 py-5 px-md-5 text-center text-lg-start">
      <div class="container">
          <div class="row gx-lg-5 align-items-center">
              <div class="col-lg-6 col-xl-6 mb-5 mb-lg-0">
                  <h1 class="my-5 display-3 fw-bold ls-tight">
                      School Attendance<br/>
                      <span class="text-primary">System</span>
                  </h1>
                  <p class="fw-bold" style="color: hsl(217, 10%, 50.8%)">
                        User Login Panel
                  </p>
              </div>

              <div class="col">

              </div>

              <div class="col-lg-5 col-xl-4 mb-5 mb-lg-0">
                  <div class="card">
                      <div class="card-body py-5 px-md-5">
                          <!-- form -->
                          <?php if(validation_errors()): ?>
                            <div class="alert alert-danger">
                                <?= validation_errors(); ?>
                            </div>
                          <?php endif; ?>
                          <?= form_open('Welcome/auth_login')?>
                          <h5 class="text-primary mb-2">Sign in</h1>
                          <div class="form-outline mb-4">
                              <input type="text" name="enum" class="form-control">
                              <label for="" class="form-label">School ID Number</label>
                          </div>
                          <div class="form-outline mb-4">
                              <input type="password" name="password" class="form-control">
                              <label for="" class="form-label">Password</label>
                          </div>

                          <button class="btn btn-primary">Sign in</button>
                          <?= form_close() ?>
                      </div>
                  </div>
              </div>
          </div>



      </div>
  </div>

</section>
