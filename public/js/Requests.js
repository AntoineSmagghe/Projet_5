
class Requests
{
    //Record Article
    /*
    saveArticle()
    {
        document.getElementsByName("article")[0].addEventListener("submit", (e)=>{
            fetch(e.target.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: e.submit,
            })
            .then(response => {
                console.log(response);
            })
            .catch(e => alert(e));
        });
    }
*/
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
                    }else{
                        alert(data.error);
                    }
                })
                .catch((e) => alert(e));
            })
        })
    }
}