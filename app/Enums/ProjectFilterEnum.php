<?php
  
namespace App\Enums;
 
enum ProjectFilterEnum:int {
    case projectsMy = 10;
    case projectsPublished = 20;
    case projectsForMe = 30;
    case projectsInGroup = 40;
    case projectsAll = 50;
}


?>