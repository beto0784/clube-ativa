document.addEventListener('DOMContentLoaded', function() {
    carregarAgendamentosPorQuadra();
    carregarAgendamentosPorDia();
    carregarSociosMaisAtivos();
});

function carregarAgendamentosPorQuadra() {
    fetch('http://seu-dominio.com/api/relatorios/agendamentos_por_quadra.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('agendamentosPorQuadra').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.quadra),
                datasets: [{
                    label: 'Número de Agendamentos',
                    data: data.map(item => item.total),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
}

function carregarAgendamentosPorDia() {
    fetch('http://seu-dominio.com/api/relatorios/agendamentos_por_dia.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('agendamentosPorDia').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                datasets: [{
                    label: 'Número de Agendamentos',
                    data: data,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
}

function carregarSociosMaisAtivos() {
    fetch('http://seu-dominio.com/api/relatorios/socios_mais_ativos.php')
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('#sociosMaisAtivos tbody');
        tbody.innerHTML = '';
        data.forEach((socio, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td>${socio.nome}</td>
                <td>${socio.total_agendamentos}</td>
            `;
            tbody.appendChild(tr);
        });
    });
}
