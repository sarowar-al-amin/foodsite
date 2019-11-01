<?php session_start(); ?>
<?php
  include 'php/db_fucntions.php';
  include 'php/utility_functions.php';
?>
<?php
  $search = '';
?>
<?php
  $column = '';
  $direction = '';
  $validate = false;
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(isset($_POST['filter_products'])){
          $validate = true;
          $_SESSION['catagory_id'] = $_POST['catagory_id'];
          unset($_SESSION['search_string']);
      } elseif(isset($_POST['clear_filter'])){
          unset($_SESSION['catagory_id']);
          unset($_POST['catagory_id']);
      }
      if(isset($_POST['search'])){
          $_SESSION['search_string'] = $_POST['search_string'];
          unset($_SESSION['catagory_id']);
          unset($_POST['catagory_id']);
      } elseif(isset($_POST['clear_search'])){
          unset($_SESSION['search_string']);
      }
  } else{
      if(isset($_GET['col'])){
          if(is_numeric($_GET['col'])){
              if(($_GET['col'] >= 0) && ($_GET['col'] <= 1)){
                  $column = $_GET['col'];
              }
            }
          if(isset($_GET['dir'])){
              if(($_GET['dir'] === 'ASC') || ($_GET['dir'] === 'DESC')){
                  $direction = $_GET['dir'];
                }
            }
        }
    }

    $food_catagories = $t;
    if(isset($_SESSION['catagory_id'])){
        $catagory_id = $_SESSION['catagory_id'];
    } elseif (isset($_POST['catagory_id'])){
        $catagory_id = $_POST['catagory_id'];
    } else{
        $catagory_id = '';
    }
    if(isset($_SESSION['search_string'])){
        $search = $_SESSION['search_string'];
    }
?>

<?php
 $result = getAllProductsByCatagoryOrSearch($catagory_id, $search);
 if(is_string($result)){
    $table = $result;
 } else{
    $data = resultToData($result);
    if(($column !== '') && (!empty($direction))){
        $data = sortData($data, $column, $direction);
    }
    if(empty($catagory_id)){
        $headings = array('Product Name', 'Product Price', 'Click to see details', 'Catagory');
    } else{
        $headings = array('Product Name', 'Product Price', 'Click to see details'); 
    }

    $caption = "List of products";
    $table = printTable($data, $headings, $caption, 1, true, array(2), array('product_details.php'), array('Description'), array('detail')); 
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css" media="screen,projection" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Astor Mediterranean</title>
</head>
</html>