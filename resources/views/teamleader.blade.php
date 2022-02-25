<form enctype="multipart/form-data" class="form" method="post" action="https://focus.teamleader.eu/oauth2/access_token">
@csrf
    <input id="id" type="text" name="client_id" value={{ $client_id }}>
    <input id="secret" type="text" name="client_secret" value={{ $client_secret }}>
    <input id="code" type="text" name="code" value={{ $code }}>
    <input id="grant" type="text" name="grant_type" value={{ $grant_type }}>
    <input id="redirect" type="text" name="redirect_uri" value={{ $redirect_uri }}>

    
</form>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

    


    let form = document.querySelector('.form');

    let input = form.querySelectorAll('input').value;

    let id = form.querySelector('#id').value;
    let secret = form.querySelector('#secret').value;
    let code = form.querySelector('#code').value;
    let grant = form.querySelector('#grant').value;
    let redirect = form.querySelector('#redirect').value;

    
    let formData = new FormData();
    formData.append('client_id', id);
    formData.append('client_secret', secret);
    formData.append('code', code);
    formData.append('grant_type', grant);
    formData.append('redirect_uri', redirect);

    


    if (input != "") {
        fetch(' https://focus.teamleader.eu/oauth2/access_token', { 
            method: 'POST',
            method : 'cors',
            headers: {
                'Content-Type': 'application/json',
            },
            body: formData
            })
            .then(response => response.json())
            .then(result => {
                console.log('Success:', result);
            })
            .catch(error => {
            console.error('Error:', error);
            });
        



        


    }
        
    


</script>


