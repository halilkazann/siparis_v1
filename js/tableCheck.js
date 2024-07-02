function toggleCheckbox(id) {
    let checkbox = document.getElementById(id);
    checkbox.checked = !checkbox.checked;
  }
  
  let checkbox = document.getElementsByName('active[]')
  let topInput = document.getElementById('topInput')


  topInput.addEventListener('change', function() {
    let isChecked = this.checked;

    for (let i = 0; i < checkbox.length; i++) {
        checkbox[i].checked = isChecked;
    }

    // Eğer topInput işaretlenmediyse, checkbox'ları false yapmak için aşağıdaki adımları izleyebilirsiniz:
    if (!isChecked) {
        for (let i = 0; i < checkbox.length; i++) {
            checkbox[i].checked = false;
        }
    }
});


 
     



    

