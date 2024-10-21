document.addEventListener('DOMContentLoaded', function() {
    carregarSociosPendentes();
});

function carregarSociosPendentes() {
    fetch('https://beto0784.github.io/clube-ativa/api/listar_socios_pendentes.php')
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#sociosPendentes tbody');
        tbody.innerHTML = '';
        data.forEach(socio => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${socio.nome}</td>
                <td>${socio.email}</td>
                <td>${socio.matricula}</td>
                <td>
                    <button onclick="aprovarSocio(${socio.id})">Aprovar</button>
                    <button onclick="rejeitarSocio(${socio.id})">Rejeitar</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    })
    .catch(error => console.error('Erro:', error));
}

function aprovarSocio(id) {
    atualizarStatusSocio(id, 'aprovado');
}

function rejeitarSocio(id) {
    atualizarStatusSocio(id, 'rejeitado');
}

function atualizarStatusSocio(id, status) {
    fetch('https://beto0784.github.io/clube-ativa/api/atualizar_status_socio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id, status }),
    })
    .then(response => response.json())
    .then(result => {
        if(result.sucesso) {
            alert(result.mensagem);
            carregarSociosPendentes();
        } else {
            alert('Erro: ' + result.mensagem);
        }
    })
    .catch(error => console.error('Erro:', error));
}
