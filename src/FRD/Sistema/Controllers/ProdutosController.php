<?php

namespace FRD\Sistema\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class ProdutosController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        Request::enableHttpMethodParameterOverride();

        $produtos = $app['controllers_factory'];

        $produtos->get("/", function() use($app) {
            $dados = $app['ProdutosData'];

            return $app['twig']->render('produtos.twig',['produtos'=>$dados['produtos'], 'categorias'=>$dados['categorias'], 'tags'=>$dados['tags']]);
        })->bind("produtos");


        $produtos->get("/{id}", function($id) use($app) {
            $dados = $app['ProdutoService']->find($id);
            $categorias = $app['CategoriaProdutoService']->findAll();
            $tags = $app['TagsService']->findAll();

            return $app['twig']->render('produto.twig',['produto'=>$dados, 'categorias'=>$categorias, 'tags'=>$tags]);
        })->bind("produto");



        $produtos->post("/", function(Request $request) use($app) {
            $data['nome'] = $request->get('nome');
            $data['categoria'] = $request->get('categoria');
            $data['descricao'] = $request->get('descricao');
            $data['valor'] = floatval($request->get('valor'));
            $data['tags'] = $request->get('tags');

            $validator = $app['ProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['ProdutosData'];

                return $app['twig']->render('produtos.twig',['produtos'=>$dados['produtos'], 'categorias'=>$dados['categorias'], 'tags'=>$dados['tags'], 'errors'=>$validator->getLogErrors()]);
            }

            $result = $app['ProdutoService']->insert($data);

            $dados = $app['ProdutosData'];

            return $app['twig']->render('produtos.twig',['produtos'=>$dados['produtos'], 'result'=>$result, 'categorias'=>$dados['categorias'], 'tags'=>$dados['tags']]);

        })->bind('cadastrar_produto');



        $produtos->put("/{id}", function(Request $request, $id) use($app) {
            $data['nome'] = $request->get('nome');
            $data['categoria'] = $request->get('categoria');
            $data['descricao'] = $request->get('descricao');
            $data['valor'] = floatval($request->get('valor'));
            $data['tags'] = $request->get('tags');

            $validator = $app['ProdutoService']->validate($app, $data);

            if (count($validator->getLogErrors()) > 0) {
                $dados = $app['ProdutosData'];

                return $app['twig']->render('produtos.twig',['produtos'=>$dados['produtos'], 'categorias'=>$dados['categorias'], 'tags'=>$dados['tags'], 'errors'=>$validator->getLogErrors()]);
            }

            $result = $app['ProdutoService']->update($id, $data);

            $dados = $app['ProdutosData'];

            return $app['twig']->render('produtos.twig',['produtos'=>$dados['produtos'], 'result'=>$result, 'categorias'=>$dados['categorias'], 'tags'=>$dados['tags']]);

        })->bind('atualizar_produto');



        $produtos->delete("/{id}", function($id) use($app) {
            $result = $app['ProdutoService']->delete($id);

            $dados = $app['ProdutosData'];

            return $app['twig']->render('produtos.twig',['produtos'=>$dados['produtos'], 'result'=>$result, 'categorias'=>$dados['categorias'], 'tags'=>$dados['tags']]);

        })->bind('apagar_produto');



        $produtos->get("/search/", function(Request $request) use($app) {
            $keyword = "%".$request->get('keyword')."%";
            $pag = $request->get('page');
            $max = 10;

            $dados = $app['ProdutoService']->buscar($keyword, $pag, $max);

            $c = $dados->count();
            $p = ceil($c / $max);

            return $app['twig']->render('produto_search.twig',["busca"=>$dados, "resultados"=>$c, "pages"=>$p]);
        })->bind("busca_produto");


        return $produtos;
    }

}