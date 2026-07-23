<?php

class Categoria
{
    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
        //cria categoria de teste

        if(isset($_SESSION['categoria'])){
            $_SESSION['categoria'] = [
                [
                    'id' => 1,
                    'nome' => 'Romance',
                    'descricao' => 'Livros de romance, literatura narrativa.'
                ],
                [
                    'id' => 2,
                    'nome' => 'Ficção',
                    'descricao' => 'Livros de ficção, imaginação e fantasia.'
                ],
                [
                    'id' => 3,
                    'nome' => 'Técnico',
                    'descricao' => 'Livros de Estudo, tecnologia.'
                ]
            ];
        }
    }
    //Retorna todas as categorias
    public function listar(): array
    {
        return $_SESSION['categoria'];
    }

    public function buscarPorId(int $id): ?array//Percorre as categorias e encontrar o id informado
    {
        foreach($_SESSION['categoria'] as $categoria)
        {
            if($categoria['id'] === $id)
            {
                return $categoria;
            }
        }
        return null;
    }

    public function cadastrar(string $nome, string $descricao): void
    {
        $_SESSION['categoria'][] = [
            'id' => $this->proximoId(),
            'nome' => $nome,
            'descricao' => $descricao 
        ];
    }

    private function proximoId(): int
    {
        if(empty($_SESSION['categoria'])){
            return 1;
        }

        $ids = array_column($_SESSION['categoria'], 'id');

        return max($ids) +1;
    }

    public function atualizar(int $id, string $nome, string $descricao): void
    {
        foreach($_SESSION['categoria'] as $categoria)
        {
            if($categoria['id'] === $id){
                $categoria['nome'] = $nome;
                $categoria['descricao'] = $descricao;
                break;
            }

            // foreach($_SESSION['categoria'] as $i => $categoria){
            //     if($categoria['id'] === $id){
            //         $_SESSION['categoria'][$i]['nome'] = $nome;
            //         $_SESSION['categoria'][$i]['descricao'] = $categoria;
            //         break;
            //     }
            // }
        }
    }

    public function excluir(int $id): void
    {
        $_SESSION['categoria'] = array_values
        (
            array_filter(
                $_SESSION['categoria'],
                fn(array $categoria): bool => $categoria['id'] !== $id
            )
        );
    }
}
