<?php
  
namespace App\Enums;
 
enum ProjectFilterEnum:int {
    case myFilterLabel = 10;
    case publishedFilterLabel = 20;
    case assignedFilterLabel = 30;
    case allFilterLabel = 40;
}


?>