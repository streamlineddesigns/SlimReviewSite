<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Platforms;

class PlatformController extends Controller
{
    /*
     * Index View
     */
    public function index($request, $response)
    {
        $view = 'platforms\index.twig';
        $platforms = Platforms::all();
        return $this->container->get('view')->render($response, $view, ['platforms' => $platforms]);
    }

    /*
     * Create View
     */
    public function create($request, $response)
    {
        $view = 'platforms\create.twig';
        return $this->container->get('view')->render($response, $view);
    }

    /*
     * Create Endpoint
     */
    public function store($request, $response)
    {
        $form_data = $request->getParsedBody();
        $platform = Platforms::create($form_data);

        if ($platform->id != null) {
            $this->container->get('flash')->addMessage('success', 'Successfully created platform!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to create platform... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/platforms');
    }

    /*
     * Read View
     */
    public function show($request, $response, $id)
    {
        $view = 'platforms\show.twig';
        $platform = Platforms::where('id', $id)->get();
        return $this->container->get('view')->render($response, $view, ['platform' => $platform]);
    }

    /*
     * Update View
     */
    public function edit($request, $response, $id)
    {
        $view = '\platforms\edit.twig';
        $platform = Platforms::where('id', $id)->get();
        return $this->container->get('view')->render($response, $view, ['platform' => $platform]);
    }

    /*
     * Update Endpoint
     */
    public function update($request, $response, $id)
    {
        $form_data = $request->getParsedBody();
        $platform = Platforms::find($id);

        if ($platform != null) {
            $platform->name = $form_data['name'];
            $platform->save();
            $this->container->get('flash')->addMessage('success', 'Successfully updated platform!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to update platform... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/platforms');
    }

    /*
     * Delete Endpoint
     */
    public function destroy($request, $response, $id)
    {
        $platform = Platforms::find($id);
        
        if ($platform != null) {
            $platform->delete();
            $this->container->get('flash')->addMessage('success', 'Successfully deleted platform!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to delete platform... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/platforms');
    }
}