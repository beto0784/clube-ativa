document.addEventListener('DOMContentLoaded', function() {
    carregarAgendamentosDoDia();
});

function carregarAgendamentosDoDia() {
    fetch('http://seu-dominio.com/api/agendamentos_do_dia.php')
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#agendamentosDia tbody');
        tbody.innerHTML = '';
        data.forEach(agendamento => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${agendamento.horario}</td>
                <td>${agendamento.quadra}</td>
                <td>${agendamento.socio}</td>
                <td>${agendamento.status}</td>
                <td>
                    ${agendamento.status === 'Pendente' ? 
                      `<button onclick="registrarEntrada(${agendamento.id})">Registrar Entrada</button>` : 
                      'Entrada Registrada'}
                </td>
            `;
            tbody.appendChild(tr);
        });
    })
    .catch(error => console.error('Erro:', error));
}

function registrarEntrada(agendamentoId) {
    fetch('http://seu-dominio.com/api/registrar_entrada.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ agendamentoId }),
    })
    .then(response => response.json())
    .then(result => {
        if(result.sucesso) {
            alert(result.mensagem);
            carregarAgendamentosDoDia();
        } else {
            alert('Erro: ' + result.mensagem);
        }
    })
    .catch(error => console.error('Erro:', error));
}

function verificarSocio() {
    const busca = document.getElementById('buscarSocio').value;
    fetch(`http://seu-dominio.com/api/verificar_socio.php?busca=${busca}`)
    .then(response => response.json())
    .then(data => {
        const resultadoDiv = document.getElementById('resultadoVerificacao');
        if(data.sucesso) {
            resultadoDiv.innerHTML = `
                <h3>Sócio Encontrado</h3>
                <p>Nome: ${data.socio.nome}</p>
                <p>Matrícula: ${data.socio.matricula}</p>
                <p>Status: ${data.socio.status}</p>
                ${data.agendamentoHoje ? 
                  `<p>Agendamento Hoje: ${data.agendamentoHoje.horario} - Quadra ${data.agendamentoHoje.quadra}</p>` : 
                  '<p>Sem agendamento para hoje</p>'}
            `;
        } else {
            resultadoDiv.innerHTML = `<p>Erro: ${data.mensagem}</p>`;
        }
    })
    .catch(error => console.error('Erro:', error));
}
