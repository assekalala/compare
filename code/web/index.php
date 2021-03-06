<html>
<head>
  <title>Compare Transactions</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <script src="js/jquery.min.js"></script>
  <script language="Javascript">
  $(document).ready(function(){
    $("button").click(function(){
        $("#unmatched").toggle();
    });
});
  </script>
</head>

<body>
<div class="container">
<form method="post" enctype="multipart/form-data">
 <fieldset class="fieldset-border">
  <legend class="fieldset-border">Specify files to compare:</legend>
  Select file 1: <input type="file" name="file1" required><br>
  Select file 2: <input type="file" name="file2" required>
  <input type="submit" value="Compare">
 </fieldset>
</form>
 <?php
 require 'functions.php';
 if( isset($_FILES['file1']) && isset($_FILES['file2'])) {

   $file1 = fopen($_FILES['file1']['tmp_name'], 'r+');
   $file1_records = array();
   while( ($row = fgetcsv($file1, 8192)) !== FALSE ) {
   	$file1_records[] = $row;
   }


   $fh = fopen($_FILES['file1']['tmp_name'], 'r+');
   $file2_records = array();
   while( ($row = fgetcsv($fh, 8192)) !== FALSE ) {
   	$file2_records[] = $row;
   }

   $file1 = new SplFileObject($_FILES['file1']['tmp_name']);
   $file1->setFlags(SplFileObject::READ_CSV);

   $file2 = new SplFileObject($_FILES['file2']['tmp_name']);
   $file2->setFlags(SplFileObject::READ_CSV);

   foreach ($file1 as $row) {
       $csv_1[] = $row;
   }

   foreach ($file2 as $row) {
       $csv_2[] = $row;
   }

   $unique_to_file1 = array_udiff($csv_1, $csv_2, 'row_compare');
   $unique_to_file2 = array_udiff($csv_2, $csv_1, 'row_compare');
 ?>
 <br>

 <fieldset class="fieldset-border">
   <legend class="fieldset-border">Comparison results</legend>
   <div class="row">
     <div class="col-6" style="border: 1px solid #ccc; padding: 10px; margin-right: 25px; margin-left: 25px;">
       <h3><?= $_FILES['file1']['name'] ?></h3>
       <p>Total Records: <?= count($file1_records); ?></p>
       <p>Matching Records: <?= count($file1_records) - count($unique_to_file1) - 1; ?></p>
       <p>Unmatched Records: <?= count($unique_to_file1); ?></p>
     </div>

     <div  class="col-5" style="border: 1px solid #ccc; padding: 10px; " >
       <h3><?= $_FILES['file2']['name'] ?></h3>
       <p>Total Records: <?= count($file2_records); ?></p>
       <p>Matching Records: <?= count($file2_records) - count($unique_to_file2) - 1; ?></p>
       <p>Unmatched Records: <?= count($unique_to_file2); ?></p>
     </div>
   </div>
   <br><br>
   <div style="text-align: center"><button>Unmatched Report</button></div>
 </fieldset>

 <br />

 <fieldset id="unmatched" class="fieldset-border">
   <legend class="fieldset-border">Unmatched Report</legend>
   <div class="row">
     <div class="col-6">
       <h3><?= $_FILES['file1']['name'] ?></h3>
       <table class="table table-striped table-condensed">
         <tr><td>Date</td><td>Reference</td><td>Amount</td></tr>
         <?php
            foreach($unique_to_file1 as $unique_row) {
              echo "<tr>";
              // var_dump($unique_row);
              echo "<td>". $unique_row[1] ."</td>";
              echo "<td>". $unique_row[7] ."</td>";
              echo "<td>". $unique_row[2] ."</td>";
              echo "</tr>";
            }
         ?>
       </table>
     </div>
     <div class="col-6">
       <h3><?= $_FILES['file2']['name'] ?></h3>
       <table class="table table-striped table-condensed">
         <tr><td>Date</td><td>Reference</td><td>Amount</td></tr>
         <?php
            foreach($unique_to_file2 as $unique_row) {
              echo "<tr>";
              // var_dump($unique_row);
              echo "<td>". $unique_row[1] ."</td>";
              echo "<td>". $unique_row[7] ."</td>";
              echo "<td>". $unique_row[2] ."</td>";
              echo "</tr>";
            }
         ?>
       </table>
     </div>
   </div/>
 </fieldset>

 <?php } ?>
</div>
</body>
</html>
