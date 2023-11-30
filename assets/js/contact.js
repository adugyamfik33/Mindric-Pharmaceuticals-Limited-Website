const contact_form = document.querySelector('#contactForm');

contact_form.addEventListener('submit',(e)=>{
    e.preventDefault();
    let formData = new FormData(contact_form);
    fetch('http://localhost/mindric/assets/php/contact.php',{
        method:'POST',
        body: formData
    })
    .then(result => result.json())
    .then((data)=>{
        if(data.code == 200){
            Swal.fire(
                'Successful',
                `${data.message}`,
                'success'
              );
        }
        else{
            Swal.fire(
                'Try Again!',
                `${data.message}`,
                'error'
              );
        }
    })
    .catch((error)=>{
        console.log(error);
    });
});