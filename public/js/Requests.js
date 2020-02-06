
class Requests
{
    //Delete pictures
    delPictures()
    {
        document.querySelectorAll('[data-delete]').forEach((a) => {
            a.addEventListener('click', (e) => {
                e.preventDefault()
                fetch(a.getAttribute('href'), {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({'_token': a.dataset.token})
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                        document.getElementsByName(data.idImg)[0].remove();
                        let addFlash = new AddFlashMessage("Image removed", "fail", document.getElementById("flash_messages"));
                        addFlash.init();
                    }else{
                        alert(data.error);
                    }
                })
                .catch((e) => alert(e));
            })
        })
    }
}