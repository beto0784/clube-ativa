document.addEventListener('DOMContentLoaded', function() {
    carregarStatusCadastro();
    carregarAgendamentos();

    document.getElementById('novoAgendamento').addEventListener('click', mostrarCalendario);
});

function carregarStatusCadastro() {
    // Assumindo que temos o ID do sócio armazenado em algum lugar (ex: localStorage)
    const socioId = localStorage.getItem('socioId');

    fetch(`https://beto0784.github.io/clube-ativa/api/status_cadastro.php?id=${socioId}`)
    .then(response => response.json())
    .then(data => {
        const statusDiv = document.getElementById('statusCadastro');
        statusDiv.textContent = `Status do cadastro: ${data.status}`;
    })
    .catch(error => console.error('Erro:', error));
}

function carregarAgendamentos() {
    const socioId = localStorage.getItem('socioId');

    fetch(`https://beto0784.github.io/clube-ativa/api/listar_agendamentos.php?socio_id=${socioId}`)
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#meusAgendamentos tbody');
        tbody.innerHTML = '';
        data.forEach(agendamento => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${agendamento.data}</td>
                <td>${agendamento.horario}</td>
                <td>${agendamento.quadra}</td>
                <td>${agendamento.status}</td>
            `;
            tbody.appendChild(tr);
        });
    })
    .catch(error => console.error('Erro:', error));
}

function mostrarCalendario() {
    const calendarioDiv = document.getElementById('calendarioAgendamento');
    calendarioDiv.style.display = 'block';
    
    // Aqui você pode implementar a lógica para mostrar um calendário interativo
    // Por exemplo, usando uma biblioteca como FullCalendar ou criando um calendário personalizado
    
    // Por enquanto, vamos apenas mostrar um seletor de data simples
    calendarioDiv.innerHTML = `
        <h3>Selecione a data para agendamento:</h3>
        <input type="date" id="dataAgendamento">
        <button onclick="buscarHorariosDisponiveis()">Buscar Horários Disponíveis</button>
    `;
}

function buscarHorariosDisponiveis() {
    const data = document.getElementById('dataAgendamento').value;
    
    fetch(`https://beto0784.github.io/clube-ativa/api/horarios_disponiveis.php?data=${data}`)
    .then(response => response.json())
    .then(data => {
        const calendarioDiv = document.getElementById('calendarioAgendamento');
        let html = '<h3>Horários Disponíveis:</h3>';
        data.forEach(horario => {
            html += `<button onclick="fazerAgendamento('${horario}')">${horario}</button>`;
        });
        calendarioDiv.innerHTML += html;
    })
    .catch(error => console.error('Erro:', error));
}

function fazerAgendamento(horario) {
    const socioId = localStorage.getItem('socioId');
    const data = document.getElementById('dataAgendamento').value;

    fetch('https://beto0784.github.io/clube-ativa/api/fazer_agendamento.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ socioId, data, horario }),
    })
    .then(response => response.json())
    .then(result => {
        if(result.sucesso) {
            alert(result.mensagem);
            carregarAgendamentos();
            document.getElementById('calendarioAgendamento').style.display = 'none';
        } else {
            alert('Erro: ' + result.mensagem);
        }
    })
    .catch(error => console.error('Erro:', error));
}
