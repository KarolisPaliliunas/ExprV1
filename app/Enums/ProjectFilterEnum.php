<?php
  
namespace App\Enums;
 
enum ProjectFilterEnum:int {
    case myFilterLabel = 10;
    case publishedFilterLabel = 20;
    case assignedFilterLabel = 30;
    //case projectsInGroup = 40;
    case allFilterLabel = 50;
}


?>