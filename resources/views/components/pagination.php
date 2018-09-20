<?php
function pagination($currentPage, $total_pages)
{
  $nextPage = $currentPage + 1;
  $previousPage = $currentPage - 1;


  $content = '';
  $content .= '<nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">';

  if($currentPage > 1){
    $content .= '<li class="page-item">
                    <a class="page-link" href="?page='.$previousPage.'" onClick="$currentPage--; return false;">Previous</a>
                 </li>';
  }
  else{
    $content .= '<li class="page-item disabled">
                  <a class="page-link" href="?page='.$previousPage.'" onClick="$currentPage--; return false;" tabindex="-1">Previous</a>
                 </li>';
  }
  if($total_pages > 5){
    if($currentPage > 3){
     $content .= '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>
     <li class="page-item disabled"><a class="page-link" tabindex="-1">...</a></li>';
     if($currentPage < $total_pages-2){
       for($i = $currentPage-1; $i <= $currentPage+3; $i++){
        if($i == $currentPage){
         $content .= '<li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>';
        }
       else{
         $content .= '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
       }
      }  
    }
   else{
     for($i = $total_pages-4; $i <= $total_pages; $i++){
      if($i == $currentPage){
       $content .= '<li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>';
     }
     else{
       $content .= '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
     }
   }

 }
}
else{
 for($i = 1; $i <= 5; $i++){
  if($i == $currentPage){
   $content .= '<li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>';
 }
 else{
   $content .= '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
 }
}
}
}
else{
  for($i = 1; $i <= $total_pages; $i++){
    if($i == $currentPage){
     $content .= '<li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>';
   }
   else{
     $content .= '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
   }
 }
}

if($currentPage < $total_pages){
  $content .= '<li class="page-item"><a class="page-link" href="?page='.$nextPage.'">Next</a></li>
</ul></nav>';
}
else{
  $content .= '<li class="page-item disabled"><a class="page-link" tabindex="-1">Next</a></li>
</ul></nav>';
}

return $content;
}