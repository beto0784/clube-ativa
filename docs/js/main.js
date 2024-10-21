document.getElementById('cadastroSocio').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    fetch('http://seu-dominio.com/api/cadastrar_socio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(result => {
        if(result.sucesso) {
            alert(result.mensagem);
            this.reset();
        } else {
            alert('Erro: ' + result.mensagem);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao processar a solicitação.');
    });
});
