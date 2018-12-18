<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>All Schools</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" media="screen" href="css/custom.css" />
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   
</head>
<body>
   <div class = "container">
   <table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">School Name</th>
      <th scope="col">About</th>
      <th scope="col">Boys</th>
      <th scope="col">Girls</th>
      <th scope="col">Logo</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if($content !== FALSE)
    {
        $count = 0;
        foreach($content as $row)
        {
            $count++;
            echo "<tr>";
            echo "<td>{$count}</td>";
            echo "<td>{$row['school_name']}</td>";
            echo "<td>{$row['about']}</td>";
            echo "<td>{$row['boys']}</td>";
            echo "<td>{$row['girls']}</td>";
            echo "<td><img src='{$row['logo']}' class='img-fluid' width='200px'/></td>";
            echo "</tr>";
        }
    }
    else
    {
        echo "No news to see here!";
    }
?>
  </tbody>
</table>
   </div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="js/custom.js"></script>