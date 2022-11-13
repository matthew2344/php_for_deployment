<div class="card-body border border-top-0 mb-2">
    <div class="row">
        <h4 class="fw-bold"><i class="fa-solid fa-calendar"></i> Manage Calendar</h4>
    </div>
    <hr>
    <div class="col-sm-4 mt-2">
      <button data-bs-toggle="modal" data-bs-target="#dayOff" class="btn btn-success">Add day off</button>
    </div>
    <div class="row mt-4">
      <?=$calendar; ?>
    </div>
    
</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="dayOff" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add School Day Off</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open("Admin/student_section/")?>
      <div class="modal-body">
        <label for="" class="form-label">School Day Off</label>
        <div class="input-group">
          <div class="input-group-text"><i class="fa-solid fa-calendar-days"></i></div>
          <input type="date" name="" id="" class="form-control">
          <div class="input-group-text">-</div>
          <input type="date" name="" id="" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?=form_close();?>
    </div>
    

  </div>

</div>




<script defer>
    const day = document.getElementById("day");
    function get(button){
        console.log(button.innerHTML);
        day.value = button.innerHTML;
    };
</script>