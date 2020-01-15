
$('#file-upload').click(function(){
  $('#file').click();
})

$('#fake_text_box').click(function(){
  $('#file').click();
})

$('#file').change(function(){
  $('#fake_text_box').val($(this).val())
})

function Change(id1,class1) {
  let target1 = document.getElementById(id1);

  let index = target1.selectedIndex;

  let target2 = document.getElementsByClassName(class1);

  if (index !== 0) {
    target2[0].classList.add("black");
  }else{
    target2[0].classList.remove("black");
  }
}

// console.log(i);