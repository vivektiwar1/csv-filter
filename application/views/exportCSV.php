<!DOCTYPE HTML>  
<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      .error {color: #FF0000;}
        #submit, #signup{
            background: #f0c14b;
            border-color: #a88734 #9c7e31 #846a29;
            color: #111;
            border-style: solid;
            border-width: 1px;
        }
        body{
            background-image: url('1.jpg');
            background-attachment: fixed;  
            background-size: cover;
            /* opacity: 0.5; */
        }
    </style>
  </head>
  <body>  
    <div class="container">
      <div class="row mt-4">
        <div class="col-md-4">
					<?php if($this->session->flashdata('errors')): ?>
						<div class="alert alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
							<?= $this->session->flashdata('errors')?>
						</div>
					<?php endif; ?> 
					<?php if ($this->session->flashdata('success')): ?>
						<div class="m-b-15">
								<div class="alert alert-success alert-dismissable">
										<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
										<p>
												<i class="icon fa fa-check"></i>
												<?php echo $this->session->flashdata('success'); ?>
										</p>
								</div>
						</div>
				<?php endif; ?>  
        </div>
      </div>
      <div class="row  mt-4">
          <select class="form-group shadow-lg p-1 mb-5 bg-white rounded" id="filter">
            <option value="<?= base_url('exportCSV/filtered') ?>">Country filter</option>
            <option value="<?= base_url('exportCSV/pricefilter') ?>">Price filter</option>
          </select>
          <form class="form-group shadow-lg p-3 mb-5 bg-white rounded" action="<?= base_url('exportCSV/filtered') ?>" method="POST" id="form" enctype="multipart/form-data">
              <label>Select CSV file to filter:</label>
              <div class="input-group mb-2">
                  <input class="btn btn-info" type="file" name="csv" id="csv" required />
              </div>
              <small class="form-text text-muted">Filter according to Dropdown</small><br>
              <input class="btn btn-warning btn-block mt-2" type="submit" name="submit" id="submit" value="Submit">
          </form>
      </div>  
    </div>
    <script>
      $(document).ready(function(){
        $('#filter').on('change', function(){
          var action = $(this).val();
          $('form').attr('action',action);
        })
      })
    </script>
  </body>
</html>