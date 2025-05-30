CREATE TABLE agendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_hora DATETIME,
    local VARCHAR(100),
    prof_orientador VARCHAR(100),
    prof_convidado1 VARCHAR(100),
    prof_convidado2 VARCHAR(100),
    aluno1 VARCHAR(100),
    aluno2 VARCHAR(100),
    aluno3 VARCHAR(100),
    nota_final DECIMAL(4,2),
    aprovado ENUM('Sim', 'Não'),
    curso VARCHAR(100),
    cidade VARCHAR(100)
);