<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\ReviewCategories;

class ReviewCategoryController extends Controller
{
    /*
     * Index View
     */
    public function index($request, $response)
    {
        $view = 'reviewCategories\index.twig';
        $reviewCategories = ReviewCategories::all();
        return $this->container->get('view')->render($response, $view, ['reviewCategories' => $reviewCategories]);
    }

    /*
     * Create View
     */
    public function create($request, $response)
    {
        $view = 'reviewCategories\create.twig';
        return $this->container->get('view')->render($response, $view);
    }

    /*
     * Create Endpoint
     */
    public function store($request, $response)
    {
        $form_data = $request->getParsedBody();
        $reviewCategory = ReviewCategories::create($form_data);

        if ($reviewCategory->id != null) {
            $this->container->get('flash')->addMessage('success', 'Successfully created Review Category!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to create Review Category... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/reviewCategories');
    }

    /*
     * Read View
     */
    public function show($request, $response, $id)
    {
        $view = 'reviewCategories\show.twig';
        $reviewCategory = ReviewCategories::where('id', $id)->get();
        return $this->container->get('view')->render($response, $view, ['reviewCategory' => $reviewCategory]);
    }

    /*
     * Update View
     */
    public function edit($request, $response, $id)
    {
        $view = '\reviewCategories\edit.twig';
        $reviewCategory = ReviewCategories::where('id', $id)->get();
        return $this->container->get('view')->render($response, $view, ['reviewCategory' => $reviewCategory]);
    }

    /*
     * Update Endpoint
     */
    public function update($request, $response, $id)
    {
        $form_data = $request->getParsedBody();
        $reviewCategory = ReviewCategories::find($id);

        if ($reviewCategory != null) {
            $reviewCategory->name = $form_data['name'];
            $reviewCategory->description = $form_data['description'];
            $reviewCategory->save();
            $this->container->get('flash')->addMessage('success', 'Successfully updated Review Category!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to update Review Category... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/reviewCategories');
    }

    /*
     * Delete Endpoint
     */
    public function destroy($request, $response, $id)
    {
        $reviewCategory = ReviewCategories::find($id);
        
        if ($reviewCategory != null) {
            $reviewCategory->delete();
            $this->container->get('flash')->addMessage('success', 'Successfully deleted Review Category!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to delete Review Category... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/reviewCategories');
    }
}