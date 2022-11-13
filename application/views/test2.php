
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
	table{
border: 15px solid #25BAE4;
border-collapse:collapse;
margin-top: 50px;
margin-left: 250px;
}
td{
width: 50px;
height: 50px;
text-align: center;
border: 1px solid #e2e0e0;
font-size: 18px;
font-weight: bold;
}
th{
height: 50px;
padding-bottom: 8px;
background:#25BAE4;
font-size: 20px;
}
.prev_sign a, .next_sign a{
color:white;
text-decoration: none;
}
tr.week_name{
font-size: 16px;
font-weight:400;
color:red;
width: 10px;
background-color: #efe8e8;
}
.highlight{
background-color:#25BAE4;
color:white;
height: 27px;
padding-top: 13px;
padding-bottom: 7px;
}
.calender .days td
{
	width: 80px;
	height: 80px;
}
.calender .hightlight
{
	font-weight: 600px;
}
.calender .days td:hover
{
	background-color: #DEF;
}
</style>


<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
		<?php echo $calender; ?>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

















<!-- <div class="container my-2">
    <h4 class="fw-bold">Monday</h4>
    <?php if(isset($_SESSION['Success'])):?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('Success')?>
        </div>
    <?php endif;?>
    <?=form_open('Welcome/test_post')?>
    <div class="card-content table-responsive">
        <table class="table table-bordered">
            <thead class="fw-bold">
                <tr>
                    <td>#</td>
                    <td>Subject</td>
                    <td>Start Schedule</td>
                    <td>End Schedule</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="dynamic_field">
                <tr>
                    <td>1</td>
                    <td>
                        <select name="sample[]" id="" class="form-select">
                            <option value=""></option>
                            <option value="A">A</option>
                        </select>
                    </td>
                    <td>
                        <input type="time" name="start[]" id="" class="form-control">
                    </td>
                    <td>
                        <input type="time" name="end[]" id="" class="form-control">
                    </td>
                    <td>
                        <button class="btn btn-success" id="add">+</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><button class="btn btn-success" type="submit">Save</button></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?= form_close();?>
</div>



<script type="text/javascript">

    $(document).ready(function(){      

      var i=1;  

   

      $('#add').click(function(){  

           i++;  

           
           var rowa = `
           <tr id="row${i}">
                <td>${i}</td>
                <td>
                    <select name="sample[]" id="" class="form-select" required>
                        <option value=""></option>
                        <option value="A">A</option>
                    </select>
                </td>
                <td>
                    <input type="time" name="start[]" id="" class="form-control" required>
                </td>
                <td>
                    <input type="time" name="end[]" id="" class="form-control" required>
                </td>
                <td>
                    <button name="remove" id="${i}" class="btn btn-danger btn_remove">X</button>
                </td>
            </tr>
           `;

           $('#dynamic_field').append(rowa);  
      });

  

      $(document).on('click', '.btn_remove', function(){  

           var button_id = $(this).attr("id");   
            i--;
           $('#row'+button_id+'').remove();  

      });  

  

    });  

</script> -->